<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import Default from '@js/Layouts/Default.vue'
import PageHeader from '@js/Components/Common/PageHeader.vue'
import Modal from '@js/Components/Notifications/Modal.vue'
import FormInput from '@js/Components/Forms/FormInput.vue'
import FormCheckbox from '@js/Components/Forms/FormCheckbox.vue'

defineOptions({
  layout: Default,
})

const props = defineProps({
  clients: Object,
  filters: Object,
})

const showModal = ref(false)
const editingClient = ref(null)
const deleteConfirmId = ref(null)
const previewLogo = ref(null)

const form = useForm({
  name: '',
  logo: null,
  website: '',
  order: 0,
  is_active: true,
})

const openCreateModal = () => {
  editingClient.value = null
  previewLogo.value = null
  form.reset()
  form.clearErrors()
  showModal.value = true
}

const openEditModal = client => {
  editingClient.value = client
  previewLogo.value = client.logo_url
  form.name = client.name
  form.website = client.website || ''
  form.order = client.order
  form.is_active = client.is_active
  form.logo = null
  form.clearErrors()
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingClient.value = null
  previewLogo.value = null
}

const handleLogoChange = event => {
  const file = event.target.files[0]
  if (file) {
    form.logo = file
    previewLogo.value = URL.createObjectURL(file)
  }
}

const submitForm = () => {
  if (editingClient.value) {
    form
      .transform(data => ({
        ...data,
        _method: 'PUT',
      }))
      .post(route('admin.client.update', editingClient.value.id), {
        forceFormData: true,
        onSuccess: () => closeModal(),
        onError: () => {},
        onFinish: () => (form.processing = false),
      })
  } else {
    form.post(route('admin.client.store'), {
      forceFormData: true,
      onSuccess: () => closeModal(),
      onError: () => {},
      onFinish: () => (form.processing = false),
    })
  }
}

const deleteClient = id => {
  router.delete(route('admin.client.destroy', id), {
    onSuccess: () => (deleteConfirmId.value = null),
  })
}
</script>

<template>
  <Head title="Kelola Klien" />
  <PageHeader title="Kelola Klien" description="Kelola logo dan informasi klien" />

  <div
    class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <!-- Header -->
    <div
      class="flex items-center justify-between border-b border-gray-200 p-4 dark:border-gray-700">
      <div class="flex items-center gap-4">
        <input
          v-model="filters.search"
          type="text"
          placeholder="Cari klien..."
          class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
          @input="
            router.get(
              route('admin.client.index'),
              { search: filters.search },
              { preserveState: true }
            )
          " />
      </div>
      <button
        type="button"
        @click="openCreateModal"
        class="inline-flex items-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:outline-none">
        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 4v16m8-8H4" />
        </svg>
        Tambah Klien
      </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm">
        <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
          <tr>
            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Logo</th>
            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Nama</th>
            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Website</th>
            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Urutan</th>
            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Status</th>
            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          <tr
            v-for="client in clients.data"
            :key="client.id"
            class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
            <td class="px-4 py-3">
              <div class="h-12 w-12 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700">
                <img
                  v-if="client.logo_url"
                  :src="client.logo_url"
                  :alt="client.name"
                  class="h-full w-full object-contain" />
                <div v-else class="flex h-full w-full items-center justify-center text-gray-400">
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              </div>
            </td>
            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ client.name }}</td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
              <a
                v-if="client.website"
                :href="client.website"
                target="_blank"
                class="text-amber-600 hover:underline">
                {{ client.website }}
              </a>
              <span v-else>-</span>
            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ client.order }}</td>
            <td class="px-4 py-3">
              <span
                :class="
                  client.is_active
                    ? 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400'
                    : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400'
                "
                class="rounded-full px-2 py-1 text-xs font-medium">
                {{ client.is_active ? 'Aktif' : 'Nonaktif' }}
              </span>
            </td>
            <td class="px-4 py-3">
              <div class="flex items-center gap-2">
                <button
                  class="rounded p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                  @click="openEditModal(client)">
                  <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                </button>
                <button
                  v-if="deleteConfirmId !== client.id"
                  class="rounded p-1 text-gray-500 hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-900/50"
                  @click="deleteConfirmId = client.id">
                  <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
                <div v-else class="flex items-center gap-1">
                  <button
                    class="rounded bg-red-500 px-2 py-1 text-xs text-white hover:bg-red-600"
                    @click="deleteClient(client.id)">
                    Hapus
                  </button>
                  <button
                    class="rounded bg-gray-200 px-2 py-1 text-xs text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-300"
                    @click="deleteConfirmId = null">
                    Batal
                  </button>
                </div>
              </div>
            </td>
          </tr>
          <tr v-if="!clients.data?.length">
            <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
              Belum ada klien
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <Modal :show="showModal" @close="closeModal">
    <div class="p-6">
      <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
        {{ editingClient ? 'Edit Klien' : 'Tambah Klien' }}
      </h2>
      <form @submit.prevent="submitForm" class="space-y-4">
        <FormInput v-model="form.name" label="Nama Klien" :error="form.errors.name" required />

        <div>
          <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
            Logo
          </label>
          <div class="flex items-center gap-4">
            <div
              class="h-20 w-20 overflow-hidden rounded-lg border border-gray-300 bg-gray-100 dark:border-gray-600 dark:bg-gray-700">
              <img v-if="previewLogo" :src="previewLogo" class="h-full w-full object-contain" />
              <div v-else class="flex h-full w-full items-center justify-center text-gray-400">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
            <input
              type="file"
              accept="image/*"
              class="text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-amber-700 hover:file:bg-amber-100"
              @change="handleLogoChange" />
          </div>
          <p v-if="form.errors.logo" class="mt-1 text-sm text-red-500">{{ form.errors.logo }}</p>
        </div>

        <FormInput
          v-model="form.website"
          label="Website (URL)"
          :error="form.errors.website"
          placeholder="https://example.com" />

        <FormInput v-model="form.order" label="Urutan" type="number" :error="form.errors.order" />

        <FormCheckbox v-model="form.is_active" label="Aktif" />

        <div class="flex justify-end gap-3 pt-4">
          <button
            type="button"
            @click="closeModal"
            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
            Batal
          </button>
          <button
            type="submit"
            :disabled="form.processing"
            class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600 disabled:opacity-50">
            {{
              form.processing ? 'Menyimpan...' : editingClient ? 'Simpan Perubahan' : 'Tambah Klien'
            }}
          </button>
        </div>
      </form>
    </div>
  </Modal>
</template>
