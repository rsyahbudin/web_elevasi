<script setup>
import { Head } from '@inertiajs/vue3'
import Default from '@js/Layouts/Default.vue'
import { useForm, usePage, router } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import FilePondUploader from '@js/Components/Forms/FilePondUploader.vue'
import FormInput from '@js/Components/Forms/FormInput.vue'
import FormTextarea from '@js/Components/Forms/FormTextarea.vue'
import PageHeader from '@js/Components/Common/PageHeader.vue'
import axios from 'axios'

defineOptions({
  layout: Default,
})

const page = usePage()
const csrfToken = page.props.csrf_token

const props = defineProps({
  personalisation: {
    type: Object,
    required: false,
    default: () => ({}),
  },
})

const form = useForm({
  app_name: props.personalisation?.app_name || null,
  copyright_text: props.personalisation?.copyright_text || null,
  phone: props.personalisation?.phone || null,
  email: props.personalisation?.email || null,
  whatsapp: props.personalisation?.whatsapp || null,
  address: props.personalisation?.address || null,
})

const uploadConfig = {
  process: {
    url: route('admin.personalization.upload'),
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': csrfToken,
      Accept: 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: true,
    onload: response => {
      return typeof response === 'string' ? JSON.parse(response) : response
    },
  },
  load: (source, load) => {
    fetch(source)
      .then(res => res.blob())
      .then(load)
  },
  revert: null,
  remove: null,
}

const appLogoFiles = ref([])
const appLogoDarkFiles = ref([])
const faviconFiles = ref([])

onMounted(() => {
  if (props.personalisation?.app_logo) {
    appLogoFiles.value = [
      {
        source: `/storage/${props.personalisation.app_logo}`,
        options: { type: 'local' },
      },
    ]
  }
  if (props.personalisation?.app_logo_dark) {
    appLogoDarkFiles.value = [
      {
        source: `/storage/${props.personalisation.app_logo_dark}`,
        options: { type: 'local' },
      },
    ]
  }
  if (props.personalisation?.favicon) {
    faviconFiles.value = [
      {
        source: `/storage/${props.personalisation.favicon}`,
        options: { type: 'local' },
      },
    ]
  }
})

const handleProcessedFile = (error, file, name) => {
  if (error || !file) return

  // Parse the server response to get the file path
  let response = file.serverId
  if (typeof response === 'string') {
    try {
      response = JSON.parse(response)
    } catch (e) {
      // response might be raw string if not JSON
    }
  }

  // Update global page props immediately so header/footer update without page reload
  // This prevents FilePond from resetting its preview
  if (response && response.path) {
    if (page.props.personalisation) {
      page.props.personalisation[name] = response.path.replace(/^\/storage\//, '')
    }
  }
}

const handleFileRemoved = async (error, file, name) => {
  if (!error) {
    try {
      // Determine the path of the file being removed
      let pathToRemove = null

      // If it's a local file (loaded from server initially)
      if (file.options && file.options.type === 'local') {
        pathToRemove = file.source
      }
      // If it's a newly uploaded file
      else if (file.serverId) {
        let response = file.serverId
        if (typeof response === 'string') {
          try {
            response = JSON.parse(response)
          } catch (e) {}
        }

        if (response && response.path) {
          pathToRemove = response.path
        }
      }

      // Send delete request with path
      await axios.post(route('admin.personalization.delete.file'), {
        field: name,
        path: pathToRemove,
      })

      // Update global page props locally ONLY if we are removing the current active logo
      if (page.props.personalisation && page.props.personalisation[name]) {
        const currentPath = page.props.personalisation[name]
        // Check if the path being removed matches the current prop path (ignoring /storage/ prefix differences if any)
        const normalizedCurrent = currentPath.startsWith('/storage/')
          ? currentPath
          : '/storage/' + currentPath
        const normalizedRemove = pathToRemove
          ? pathToRemove.startsWith('/storage/')
            ? pathToRemove
            : '/storage/' + pathToRemove
          : ''

        if (normalizedCurrent === normalizedRemove) {
          page.props.personalisation[name] = null
        }
      }
    } catch (e) {
      console.error('Error removing file:', e)
    }
  }
}

const submit = () => {
  form.post(route('admin.personalization.update.info'), {
    preserveScroll: true,
  })
}

const refreshPersonalisation = () => {
  router.reload({
    only: ['personalisation'], // this matches the key from HandleInertiaRequests
  })
}
</script>

<template>
  <Head title="Pengaturan Situs" />

  <main class="main-container mx-auto max-w-7xl" aria-labelledby="personalization-settings">
    <div class="container-border">
      <PageHeader
        title="Pengaturan Situs"
        description="Konfigurasi tampilan, branding, dan informasi kontak website"
        :breadcrumbs="[
          { label: 'Dashboard', href: '/' },
          { label: 'System Settings', href: route('admin.setting.index') },
          { label: 'Pengaturan Situs' },
        ]" />

      <div class="p-6 dark:bg-gray-900">
        <div
          class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
          <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
            Informasi Aplikasi
          </h3>
          <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
            Konfigurasi nama dan informasi dasar aplikasi
          </p>

          <form id="app-details-form" class="max-w-2xl space-y-8" @submit.prevent="submit">
            <div class="space-y-6">
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <FormInput
                  id="app_name"
                  v-model="form.app_name"
                  label="Nama Aplikasi"
                  placeholder="Masukkan nama aplikasi"
                  :error="form.errors.app_name" />
                <FormInput
                  id="copyright_text"
                  v-model="form.copyright_text"
                  label="Teks Copyright"
                  placeholder="Masukkan teks copyright"
                  :error="form.errors.copyright_text" />
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Contact Information Section -->
      <div class="border-t border-gray-200 p-6 dark:border-gray-700 dark:bg-gray-900">
        <div
          class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
          <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
            Informasi Kontak
          </h3>
          <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
            Informasi kontak yang akan ditampilkan di halaman publik
          </p>

          <div class="max-w-2xl space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <FormInput
                id="phone"
                v-model="form.phone"
                label="Nomor Telepon"
                placeholder="+62 812 3456 7890"
                :error="form.errors.phone" />
              <FormInput
                id="email"
                v-model="form.email"
                type="email"
                label="Email"
                placeholder="info@example.com"
                :error="form.errors.email" />
              <FormInput
                id="whatsapp"
                v-model="form.whatsapp"
                label="Nomor WhatsApp"
                placeholder="6281234567890"
                :error="form.errors.whatsapp" />
            </div>
            <FormTextarea
              id="address"
              v-model="form.address"
              label="Alamat"
              placeholder="Masukkan alamat lengkap"
              :rows="3"
              :error="form.errors.address" />
          </div>
        </div>
      </div>

      <div
        class="flex justify-center border-t border-gray-200 bg-gray-50 px-4 py-4 sm:justify-end sm:px-6 dark:border-gray-700 dark:bg-gray-800">
        <button
          type="submit"
          form="app-details-form"
          class="btn btn-sm btn-primary w-full sm:w-auto"
          :disabled="form.processing"
          :aria-busy="form.processing">
          <svg
            v-if="form.processing"
            class="h-4 w-4 animate-spin"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            aria-hidden="true">
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4" />
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
          </svg>
          {{ form.processing ? 'Menyimpan...' : 'Simpan Pengaturan' }}
        </button>
      </div>

      <div class="border-t border-gray-200 p-4 sm:p-6 dark:border-gray-700 dark:bg-gray-900">
        <div
          class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
          <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Branding</h3>
          <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
            Upload dan kelola logo dan favicon aplikasi
          </p>

          <div class="max-w-6xl space-y-16 md:space-y-16">
            <div
              class="grid grid-cols-1 gap-8 md:grid-cols-3 md:gap-12"
              role="group"
              aria-label="Media uploads">
              <div class="flex justify-center">
                <div class="w-full max-w-48 md:w-32">
                  <FilePondUploader
                    id="app_logo"
                    name="app_logo"
                    label="Logo"
                    label-idle="Drop logo here..."
                    :accepted-file-types="['image/jpeg', 'image/png']"
                    :server="uploadConfig"
                    :files="appLogoFiles"
                    @processfile="(error, file) => handleProcessedFile(error, file, 'app_logo')"
                    @removefile="(error, file) => handleFileRemoved(error, file, 'app_logo')" />
                </div>
              </div>

              <div class="flex justify-center">
                <div class="w-full max-w-48 md:w-32">
                  <FilePondUploader
                    id="app_logo_dark"
                    name="app_logo_dark"
                    label="Logo (dark mode)"
                    label-idle="Drop logo here..."
                    :accepted-file-types="['image/jpeg', 'image/png']"
                    :server="uploadConfig"
                    :files="appLogoDarkFiles"
                    @processfile="
                      (error, file) => handleProcessedFile(error, file, 'app_logo_dark')
                    "
                    @removefile="
                      (error, file) => handleFileRemoved(error, file, 'app_logo_dark')
                    " />
                </div>
              </div>

              <div class="flex justify-center">
                <div class="w-full max-w-48 md:w-32">
                  <FilePondUploader
                    id="favicon"
                    name="favicon"
                    label="Favicon"
                    label-idle="Drop favicon here..."
                    :accepted-file-types="['image/png', 'image/x-icon']"
                    :server="uploadConfig"
                    :files="faviconFiles"
                    @processfile="(error, file) => handleProcessedFile(error, file, 'favicon')"
                    @removefile="(error, file) => handleFileRemoved(error, file, 'favicon')" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
