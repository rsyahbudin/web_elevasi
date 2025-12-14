<script setup>
import { Head, useForm, router, Link } from '@inertiajs/vue3'
import Default from '@js/Layouts/Default.vue'
import PageHeader from '@js/Components/Common/PageHeader.vue'
import FormInput from '@js/Components/Forms/FormInput.vue'
import FormSelect from '@js/Components/Forms/FormSelect.vue'
import FormTextarea from '@js/Components/Forms/FormTextarea.vue'
import FormCheckbox from '@js/Components/Forms/FormCheckbox.vue'
import SimpleImageUploader from '@js/Components/Forms/SimpleImageUploader.vue'
import { ref } from 'vue'

defineOptions({
  layout: Default,
})

const props = defineProps({
  categories: {
    type: Array,
    required: true,
  },
})

const form = useForm({
  title: '',
  description: '',
  client_name: '',
  location: '',
  category_id: '',
  year_completed: new Date().getFullYear(),
  is_featured: false,
  status: 'draft',
  featured_image: null,
  images: [],
})

const statusOptions = [
  { id: 'draft', name: 'Draft' },
  { id: 'published', name: 'Published' },
]

const currentYear = new Date().getFullYear()
const yearOptions = Array.from({ length: 30 }, (_, i) => ({
  id: currentYear - i,
  name: String(currentYear - i),
}))

const submit = () => {
  form.post(route('admin.project.store'), {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>

<template>
  <Head title="Tambah Proyek" />
  <main class="main-container mx-auto max-w-7xl" aria-labelledby="create-project">
    <div class="container-border">
      <PageHeader
        title="Tambah Proyek Baru"
        description="Tambahkan proyek baru ke dalam galeri"
        :breadcrumbs="[
          { label: 'Dashboard', href: route('dashboard') },
          { label: 'Manajemen Proyek', href: route('admin.project.index') },
          { label: 'Tambah Proyek' },
        ]">
        <template #actions>
          <Link :href="route('admin.project.index')" class="btn btn-secondary btn-sm">Kembali</Link>
        </template>
      </PageHeader>

      <section class="p-6 dark:bg-gray-900">
        <form @submit.prevent="submit" class="space-y-8">
          <!-- Basic Info -->
          <div
            class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
              Informasi Proyek
            </h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <FormInput
                v-model="form.title"
                label="Judul Proyek"
                :error="form.errors.title"
                name="title"
                required />
              <FormSelect
                v-model="form.category_id"
                :options="categories"
                option-label="name"
                option-value="id"
                name="category_id"
                label="Kategori"
                :error="form.errors.category_id"
                required />
              <FormInput
                v-model="form.client_name"
                label="Nama Klien"
                :error="form.errors.client_name"
                name="client_name" />
              <FormInput
                v-model="form.location"
                label="Lokasi"
                :error="form.errors.location"
                name="location" />
              <FormSelect
                v-model="form.year_completed"
                :options="yearOptions"
                option-label="name"
                option-value="id"
                name="year_completed"
                label="Tahun Selesai"
                :error="form.errors.year_completed" />
              <FormSelect
                v-model="form.status"
                :options="statusOptions"
                option-label="name"
                option-value="id"
                name="status"
                label="Status"
                :error="form.errors.status" />
            </div>
            <div class="mt-6">
              <FormTextarea
                v-model="form.description"
                label="Deskripsi"
                :error="form.errors.description"
                name="description"
                :rows="4" />
            </div>
            <div class="mt-6">
              <FormCheckbox
                v-model="form.is_featured"
                label="Featured Project"
                description="Tampilkan proyek ini di halaman utama"
                :error="form.errors.is_featured" />
            </div>
          </div>

          <!-- Images -->
          <div
            class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Gambar</h3>
            <div class="space-y-6">
              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Gambar Utama
                </label>
                <SimpleImageUploader v-model="form.featured_image" :multiple="false" />
                <p v-if="form.errors.featured_image" class="mt-1 text-sm text-red-600">
                  {{ form.errors.featured_image }}
                </p>
              </div>
              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Galeri Gambar
                </label>
                <SimpleImageUploader v-model="form.images" :multiple="true" :max-files="10" />
                <p v-if="form.errors.images" class="mt-1 text-sm text-red-600">
                  {{ form.errors.images }}
                </p>
              </div>
            </div>
          </div>

          <!-- Submit -->
          <div class="flex justify-end gap-4">
            <Link :href="route('admin.project.index')" class="btn btn-secondary">Batal</Link>
            <button type="submit" class="btn btn-primary" :disabled="form.processing">
              Simpan Proyek
            </button>
          </div>
        </form>
      </section>
    </div>
  </main>
</template>
