<script setup>
import { Head, useForm, router, Link } from '@inertiajs/vue3'
import DataTable from '@js/Components/Common/Datatable.vue'
import Default from '@js/Layouts/Default.vue'
import Modal from '@js/Components/Notifications/Modal.vue'
import { createColumnHelper } from '@tanstack/vue-table'
import { h, ref, watch } from 'vue'
import PageHeader from '@js/Components/Common/PageHeader.vue'
import FormInput from '@js/Components/Forms/FormInput.vue'
import FormSelect from '@js/Components/Forms/FormSelect.vue'
import FormTextarea from '@js/Components/Forms/FormTextarea.vue'
import FormCheckbox from '@js/Components/Forms/FormCheckbox.vue'

defineOptions({
  layout: Default,
})

const props = defineProps({
  projects: {
    type: Object,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
})

const columnHelper = createColumnHelper()
const loading = ref(false)
const pagination = ref({
  current_page: props.projects.current_page,
  per_page: Number(props.projects.per_page),
  total: props.projects.total,
})

const showDeleteModal = ref(false)
const projectToDelete = ref(null)
const showCreateModal = ref(false)

const form = useForm({
  title: '',
  description: '',
  client_name: '',
  location: '',
  category_id: '',
  year_completed: new Date().getFullYear(),
  is_featured: false,
  status: 'draft',
})

const closeModal = () => {
  showDeleteModal.value = false
  projectToDelete.value = null
  showCreateModal.value = false
  form.reset()
}

const handleEdit = project => {
  if (!project?.id) return
  router.visit(route('admin.project.edit', { project: project.id }))
}

const confirmDeleteProject = project => {
  projectToDelete.value = project
  showDeleteModal.value = true
}

const deleteProject = () => {
  if (!projectToDelete.value?.id) return

  router.delete(route('admin.project.destroy', { project: projectToDelete.value.id }), {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false
      projectToDelete.value = null
    },
    onError: () => {
      showDeleteModal.value = false
      projectToDelete.value = null
    },
  })
}

const openCreateModal = () => {
  router.visit(route('admin.project.create'))
}

const columns = [
  columnHelper.accessor('featured_image_url', {
    header: 'Gambar',
    cell: info => {
      const url = info.getValue()
      if (url) {
        return h('img', {
          src: url,
          class: 'w-16 h-12 object-cover rounded-lg',
          alt: 'Project image',
        })
      }
      return h(
        'div',
        {
          class:
            'w-16 h-12 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center',
        },
        [
          h(
            'svg',
            {
              class: 'w-6 h-6 text-gray-400',
              fill: 'none',
              stroke: 'currentColor',
              viewBox: '0 0 24 24',
            },
            [
              h('path', {
                'stroke-linecap': 'round',
                'stroke-linejoin': 'round',
                'stroke-width': '2',
                d: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
              }),
            ]
          ),
        ]
      )
    },
  }),
  columnHelper.accessor('title', {
    header: 'Judul',
    cell: info => h('span', { class: 'font-medium' }, info.getValue() || '-'),
  }),
  columnHelper.accessor('category.name', {
    header: 'Kategori',
    cell: info =>
      h(
        'span',
        {
          class:
            'px-2 py-1 text-xs capitalize rounded-md bg-blue-50 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300',
        },
        info.getValue() || 'Tanpa Kategori'
      ),
  }),
  columnHelper.accessor('location', {
    header: 'Lokasi',
    cell: info => h('span', info.getValue() || '-'),
  }),
  columnHelper.accessor('year_completed', {
    header: 'Tahun',
    cell: info => h('span', info.getValue() || '-'),
  }),
  columnHelper.accessor('status', {
    header: 'Status',
    cell: info => {
      const status = info.getValue()
      const isPublished = status === 'published'
      return h(
        'span',
        {
          class: isPublished
            ? 'px-2 py-1 text-xs rounded-md bg-green-50 text-green-700 dark:bg-green-900/50 dark:text-green-300'
            : 'px-2 py-1 text-xs rounded-md bg-amber-50 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300',
        },
        isPublished ? 'Published' : 'Draft'
      )
    },
  }),
  columnHelper.accessor('is_featured', {
    header: 'Featured',
    cell: info => {
      const isFeatured = info.getValue()
      return h(
        'span',
        {
          class: isFeatured ? 'text-yellow-500' : 'text-gray-300 dark:text-gray-600',
        },
        '★'
      )
    },
  }),
  columnHelper.display({
    id: 'actions',
    header: 'Aksi',
    cell: info => {
      const project = info.row.original
      if (!project?.id) return null

      const editButton = h(
        'button',
        {
          class:
            'p-2 text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg cursor-pointer hover:scale-105 transition-all duration-200',
          onClick: () => handleEdit(project),
          type: 'button',
          title: 'Edit Project',
        },
        [
          h('span', { class: 'sr-only' }, 'Edit Project'),
          h(
            'svg',
            {
              class: 'h-4 w-4',
              fill: 'none',
              stroke: 'currentColor',
              viewBox: '0 0 24 24',
              'aria-hidden': 'true',
            },
            [
              h('path', {
                'stroke-linecap': 'round',
                'stroke-linejoin': 'round',
                'stroke-width': '2',
                d: 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
              }),
            ]
          ),
        ]
      )

      const deleteButton = h(
        'button',
        {
          class:
            'p-2 text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg cursor-pointer hover:scale-105 transition-all duration-200',
          onClick: () => confirmDeleteProject(project),
          type: 'button',
          title: 'Hapus Project',
        },
        [
          h('span', { class: 'sr-only' }, 'Hapus Project'),
          h(
            'svg',
            {
              class: 'h-4 w-4',
              fill: 'none',
              stroke: 'currentColor',
              viewBox: '0 0 24 24',
              'aria-hidden': 'true',
            },
            [
              h('path', {
                'stroke-linecap': 'round',
                'stroke-linejoin': 'round',
                'stroke-width': '2',
                d: 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
              }),
            ]
          ),
        ]
      )

      return h(
        'div',
        {
          class: 'flex items-center gap-2 justify-end',
        },
        [editButton, deleteButton]
      )
    },
  }),
]

watch(
  pagination,
  newPagination => {
    loading.value = true
    router.get(
      route('admin.project.index'),
      {
        page: newPagination.current_page,
        per_page: Number(newPagination.per_page),
      },
      {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => (loading.value = false),
      }
    )
  },
  { deep: true }
)
</script>

<template>
  <Head title="Manajemen Proyek" />
  <main class="main-container mx-auto max-w-7xl" aria-labelledby="project-management">
    <div class="container-border">
      <PageHeader
        title="Manajemen Proyek"
        description="Kelola proyek-proyek yang telah dikerjakan"
        :breadcrumbs="[
          { label: 'Dashboard', href: route('dashboard') },
          { label: 'Manajemen Proyek' },
        ]">
        <template #actions>
          <Link :href="route('admin.project.category.index')" class="btn btn-secondary btn-sm mr-2">
            Kategori
          </Link>
          <button @click="openCreateModal" class="btn btn-primary btn-sm">Tambah Proyek</button>
        </template>
      </PageHeader>

      <section class="p-6 dark:bg-gray-900">
        <div
          class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
          <DataTable
            :data="projects.data"
            :columns="columns"
            :loading="loading"
            :pagination="pagination"
            :search-fields="['title', 'location', 'client_name']"
            empty-message="Belum ada proyek"
            empty-description="Proyek akan muncul di sini setelah ditambahkan"
            export-file-name="projects"
            @update:pagination="pagination = $event" />
        </div>
      </section>
    </div>
  </main>

  <Modal :show="showDeleteModal" @close="closeModal" size="md">
    <template #title>
      <div class="text-red-600 dark:text-red-400">Hapus Proyek</div>
    </template>

    <template #default>
      <div class="space-y-4">
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Apakah Anda yakin ingin menghapus proyek ini?
        </p>
        <div
          v-if="projectToDelete"
          class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
          <h4 class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Detail proyek:</h4>
          <dl class="space-y-1">
            <div class="flex gap-2">
              <dt class="text-sm text-gray-500 dark:text-gray-400">Judul:</dt>
              <dd class="text-sm text-gray-900 dark:text-gray-100">
                {{ projectToDelete.title }}
              </dd>
            </div>
            <div class="flex gap-2">
              <dt class="text-sm text-gray-500 dark:text-gray-400">Kategori:</dt>
              <dd class="text-sm text-gray-900 dark:text-gray-100">
                {{ projectToDelete.category?.name || 'Tanpa Kategori' }}
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </template>

    <template #footer>
      <div class="flex justify-end gap-8">
        <button
          @click="closeModal"
          type="button"
          class="cursor-pointer px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400">
          Batal
        </button>
        <button @click="deleteProject" type="button" class="btn btn-danger btn-sm">
          Ya, Hapus
        </button>
      </div>
    </template>
  </Modal>
</template>
