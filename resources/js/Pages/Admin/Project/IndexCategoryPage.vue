<script setup>
import { Head, useForm, router, Link } from '@inertiajs/vue3'
import DataTable from '@js/Components/Common/Datatable.vue'
import Default from '@js/Layouts/Default.vue'
import Modal from '@js/Components/Notifications/Modal.vue'
import { createColumnHelper } from '@tanstack/vue-table'
import { h, ref, watch } from 'vue'
import PageHeader from '@js/Components/Common/PageHeader.vue'
import FormInput from '@js/Components/Forms/FormInput.vue'
import FormTextarea from '@js/Components/Forms/FormTextarea.vue'

defineOptions({
  layout: Default,
})

const props = defineProps({
  categories: {
    type: Object,
    required: true,
  },
})

const columnHelper = createColumnHelper()
const loading = ref(false)
const pagination = ref({
  current_page: props.categories.current_page,
  per_page: Number(props.categories.per_page),
  total: props.categories.total,
})

const showDeleteModal = ref(false)
const categoryToDelete = ref(null)
const showFormModal = ref(false)
const editingCategory = ref(null)

const form = useForm({
  name: '',
  description: '',
})

const closeModal = () => {
  showDeleteModal.value = false
  categoryToDelete.value = null
  showFormModal.value = false
  editingCategory.value = null
  form.reset()
  form.clearErrors()
}

const openCreateModal = () => {
  editingCategory.value = null
  form.reset()
  showFormModal.value = true
}

const openEditModal = category => {
  editingCategory.value = category
  form.name = category.name
  form.description = category.description || ''
  showFormModal.value = true
}

const confirmDeleteCategory = category => {
  categoryToDelete.value = category
  showDeleteModal.value = true
}

const deleteCategory = () => {
  if (!categoryToDelete.value?.id) return

  router.delete(
    route('admin.project.category.destroy', { project_category: categoryToDelete.value.id }),
    {
      preserveScroll: true,
      onSuccess: () => {
        closeModal()
      },
      onError: () => {
        closeModal()
      },
    }
  )
}

const submitForm = () => {
  if (editingCategory.value) {
    form.put(
      route('admin.project.category.update', { project_category: editingCategory.value.id }),
      {
        preserveScroll: true,
        onSuccess: () => {
          closeModal()
        },
        onError: () => {
          // Keep modal open on error
        },
        onFinish: () => {
          // Reset processing state
        },
      }
    )
  } else {
    form.post(route('admin.project.category.store'), {
      preserveScroll: true,
      onSuccess: () => {
        closeModal()
      },
      onError: () => {
        // Keep modal open on error
      },
      onFinish: () => {
        // Reset processing state
      },
    })
  }
}

const columns = [
  columnHelper.accessor('name', {
    header: 'Nama Kategori',
    cell: info => h('span', { class: 'font-medium' }, info.getValue() || '-'),
  }),
  columnHelper.accessor('description', {
    header: 'Deskripsi',
    cell: info => h('span', { class: 'text-gray-500 dark:text-gray-400' }, info.getValue() || '-'),
  }),
  columnHelper.accessor('projects_count', {
    header: 'Jumlah Proyek',
    cell: info =>
      h(
        'span',
        {
          class:
            'px-2 py-1 text-xs rounded-md bg-blue-50 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300',
        },
        info.getValue() || 0
      ),
  }),
  columnHelper.accessor('created_at', {
    header: 'Dibuat',
    cell: info => h('span', info.getValue() || '-'),
  }),
  columnHelper.display({
    id: 'actions',
    header: 'Aksi',
    cell: info => {
      const category = info.row.original
      if (!category?.id) return null

      const editButton = h(
        'button',
        {
          class:
            'p-2 text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg cursor-pointer hover:scale-105 transition-all duration-200',
          onClick: () => openEditModal(category),
          type: 'button',
          title: 'Edit Kategori',
        },
        [
          h('span', { class: 'sr-only' }, 'Edit Kategori'),
          h(
            'svg',
            {
              class: 'h-4 w-4',
              fill: 'none',
              stroke: 'currentColor',
              viewBox: '0 0 24 24',
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
          onClick: () => confirmDeleteCategory(category),
          type: 'button',
          title: 'Hapus Kategori',
        },
        [
          h('span', { class: 'sr-only' }, 'Hapus Kategori'),
          h(
            'svg',
            {
              class: 'h-4 w-4',
              fill: 'none',
              stroke: 'currentColor',
              viewBox: '0 0 24 24',
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

      return h('div', { class: 'flex items-center gap-2 justify-end' }, [editButton, deleteButton])
    },
  }),
]

watch(
  pagination,
  newPagination => {
    loading.value = true
    router.get(
      route('admin.project.category.index'),
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
  <Head title="Kategori Proyek" />
  <main class="main-container mx-auto max-w-7xl" aria-labelledby="category-management">
    <div class="container-border">
      <PageHeader
        title="Kategori Proyek"
        description="Kelola kategori untuk proyek-proyek"
        :breadcrumbs="[
          { label: 'Dashboard', href: route('dashboard') },
          { label: 'Manajemen Proyek', href: route('admin.project.index') },
          { label: 'Kategori' },
        ]">
        <template #actions>
          <Link :href="route('admin.project.index')" class="btn btn-secondary btn-sm mr-2">
            Kembali
          </Link>
          <button @click="openCreateModal" class="btn btn-primary btn-sm">Tambah Kategori</button>
        </template>
      </PageHeader>

      <section class="p-6 dark:bg-gray-900">
        <div
          class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
          <DataTable
            :data="categories.data"
            :columns="columns"
            :loading="loading"
            :pagination="pagination"
            :search-fields="['name', 'description']"
            empty-message="Belum ada kategori"
            empty-description="Kategori akan muncul di sini setelah ditambahkan"
            export-file-name="project-categories"
            @update:pagination="pagination = $event" />
        </div>
      </section>
    </div>
  </main>

  <!-- Form Modal -->
  <Modal :show="showFormModal" @close="closeModal" size="md">
    <template #title>
      {{ editingCategory ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
    </template>

    <template #default>
      <form @submit.prevent="submitForm" class="space-y-4">
        <FormInput
          v-model="form.name"
          label="Nama Kategori"
          :error="form.errors.name"
          name="name"
          required />
        <FormTextarea
          v-model="form.description"
          label="Deskripsi (Opsional)"
          :error="form.errors.description"
          name="description"
          :rows="3" />
      </form>
    </template>

    <template #footer>
      <div class="flex justify-end gap-4">
        <button
          @click="closeModal"
          type="button"
          class="cursor-pointer px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400">
          Batal
        </button>
        <button
          @click="submitForm"
          type="button"
          class="btn btn-primary btn-sm"
          :disabled="form.processing">
          {{ editingCategory ? 'Simpan Perubahan' : 'Tambah Kategori' }}
        </button>
      </div>
    </template>
  </Modal>

  <!-- Delete Modal -->
  <Modal :show="showDeleteModal" @close="closeModal" size="md">
    <template #title>
      <div class="text-red-600 dark:text-red-400">Hapus Kategori</div>
    </template>

    <template #default>
      <div class="space-y-4">
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Apakah Anda yakin ingin menghapus kategori ini?
        </p>
        <div
          v-if="categoryToDelete"
          class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
          <p class="font-medium text-gray-900 dark:text-gray-100">{{ categoryToDelete.name }}</p>
          <p
            v-if="categoryToDelete.projects_count > 0"
            class="mt-2 text-sm text-amber-600 dark:text-amber-400">
            ⚠️ Kategori ini memiliki {{ categoryToDelete.projects_count }} proyek terkait dan tidak
            dapat dihapus.
          </p>
        </div>
      </div>
    </template>

    <template #footer>
      <div class="flex justify-end gap-4">
        <button
          @click="closeModal"
          type="button"
          class="cursor-pointer px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400">
          Batal
        </button>
        <button
          v-if="!categoryToDelete?.projects_count"
          @click="deleteCategory"
          type="button"
          class="btn btn-danger btn-sm">
          Ya, Hapus
        </button>
      </div>
    </template>
  </Modal>
</template>
