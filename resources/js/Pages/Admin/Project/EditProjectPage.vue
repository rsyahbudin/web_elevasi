<script setup>
import { Head, useForm, router, Link } from '@inertiajs/vue3'
import Default from '@js/Layouts/Default.vue'
import PageHeader from '@js/Components/Common/PageHeader.vue'
import FormInput from '@js/Components/Forms/FormInput.vue'
import FormSelect from '@js/Components/Forms/FormSelect.vue'
import FormTextarea from '@js/Components/Forms/FormTextarea.vue'
import FormCheckbox from '@js/Components/Forms/FormCheckbox.vue'
import SimpleImageUploader from '@js/Components/Forms/SimpleImageUploader.vue'
import { ref, computed } from 'vue'

defineOptions({
  layout: Default,
})

const props = defineProps({
  project: {
    type: Object,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
})

const form = useForm({
  _method: 'PUT',
  title: props.project.title || '',
  description: props.project.description || '',
  client_name: props.project.client_name || '',
  location: props.project.location || '',
  category_id: props.project.category_id || '',
  year_completed: props.project.year_completed || new Date().getFullYear(),
  is_featured: props.project.is_featured || false,
  status: props.project.status || 'draft',
  featured_image: null,
  images: [],
  remove_featured_image: false,
  existing_images: props.project.images || [],
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

const hasExistingFeaturedImage = computed(() => {
  return props.project.featured_image_url && !form.remove_featured_image
})

const existingGalleryImages = computed(() => {
  return form.existing_images.map((img, index) => ({
    path: img,
    url: props.project.image_urls?.[index] || '',
  }))
})

const removeFeaturedImage = () => {
  form.remove_featured_image = true
}

const removeExistingGalleryImage = index => {
  form.existing_images.splice(index, 1)
}

const submit = () => {
  form.post(route('admin.project.update', { project: props.project.id }), {
    forceFormData: true,
    preserveScroll: true,
  })
}
</script>

<template>
  <Head :title="`Edit: ${project.title}`" />
  <main class="main-container mx-auto max-w-7xl" aria-labelledby="edit-project">
    <div class="container-border">
      <PageHeader
        :title="`Edit: ${project.title}`"
        description="Perbarui informasi proyek"
        :breadcrumbs="[
          { label: 'Dashboard', href: route('dashboard') },
          { label: 'Manajemen Proyek', href: route('admin.project.index') },
          { label: 'Edit Proyek' },
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
              <!-- Featured Image -->
              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Gambar Utama
                </label>
                <div v-if="hasExistingFeaturedImage" class="mb-4">
                  <div class="relative inline-block">
                    <img
                      :src="project.featured_image_url"
                      class="h-32 w-48 rounded-lg object-cover"
                      alt="Featured image" />
                    <button
                      type="button"
                      @click="removeFeaturedImage"
                      class="absolute -top-2 -right-2 rounded-full bg-red-500 p-1 text-white hover:bg-red-600">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
                </div>
                <SimpleImageUploader v-model="form.featured_image" :multiple="false" />
                <p v-if="form.errors.featured_image" class="mt-1 text-sm text-red-600">
                  {{ form.errors.featured_image }}
                </p>
              </div>

              <!-- Gallery Images -->
              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Galeri Gambar
                </label>
                <div v-if="existingGalleryImages.length > 0" class="mb-4 flex flex-wrap gap-4">
                  <div
                    v-for="(img, index) in existingGalleryImages"
                    :key="img.path"
                    class="relative">
                    <img
                      :src="img.url"
                      class="h-24 w-32 rounded-lg object-cover"
                      alt="Gallery image" />
                    <button
                      type="button"
                      @click="removeExistingGalleryImage(index)"
                      class="absolute -top-2 -right-2 rounded-full bg-red-500 p-1 text-white hover:bg-red-600">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
                </div>
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
              Simpan Perubahan
            </button>
          </div>
        </form>
      </section>
    </div>
  </main>
</template>
