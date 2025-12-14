<script setup>
import { ref, watch, computed, onMounted } from 'vue'

const props = defineProps({
  modelValue: {
    type: [Array, Object, null],
    default: null,
  },
  multiple: {
    type: Boolean,
    default: false,
  },
  maxFiles: {
    type: Number,
    default: 10,
  },
  accept: {
    type: String,
    default: 'image/png, image/jpeg, image/webp',
  },
})

const emit = defineEmits(['update:modelValue'])

const fileInput = ref(null)
const previewUrls = ref([])
const isDragging = ref(false)

// Safely get files as array
const getFilesArray = value => {
  if (!value) return []
  if (Array.isArray(value)) return value.filter(f => f != null)
  return [value]
}

// Generate preview URLs from files
const updatePreviews = files => {
  // Clean up old blob URLs
  previewUrls.value.forEach(url => {
    if (url && typeof url === 'string' && url.startsWith('blob:')) {
      try {
        URL.revokeObjectURL(url)
      } catch (e) {
        // Ignore errors
      }
    }
  })

  // Generate new previews
  previewUrls.value = files
    .map(file => {
      if (file instanceof File) {
        return URL.createObjectURL(file)
      }
      if (typeof file === 'string') {
        return file
      }
      return null
    })
    .filter(url => url != null)
}

// Watch for changes to modelValue
watch(
  () => props.modelValue,
  newVal => {
    const files = getFilesArray(newVal)
    updatePreviews(files)
  },
  { immediate: true }
)

const handleFileSelect = event => {
  const files = Array.from(event.target.files || [])
  addFiles(files)
  // Reset input
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const addFiles = files => {
  if (!files.length) return

  if (props.multiple) {
    const currentFiles = getFilesArray(props.modelValue)
    const available = props.maxFiles - currentFiles.length
    const newFiles = files.slice(0, Math.max(0, available))
    emit('update:modelValue', [...currentFiles, ...newFiles])
  } else {
    emit('update:modelValue', files[0] || null)
  }
}

const removeFile = index => {
  if (props.multiple) {
    const currentFiles = getFilesArray(props.modelValue)
    const newFiles = currentFiles.filter((_, i) => i !== index)
    emit('update:modelValue', newFiles)
  } else {
    emit('update:modelValue', null)
  }
}

const handleDragOver = event => {
  event.preventDefault()
  isDragging.value = true
}

const handleDragLeave = () => {
  isDragging.value = false
}

const handleDrop = event => {
  event.preventDefault()
  isDragging.value = false
  const files = Array.from(event.dataTransfer?.files || [])
  addFiles(files)
}

const triggerFileInput = () => {
  fileInput.value?.click()
}
</script>

<template>
  <div>
    <input
      ref="fileInput"
      type="file"
      :multiple="multiple"
      :accept="accept"
      class="hidden"
      @change="handleFileSelect" />

    <div
      :class="[
        'relative cursor-pointer rounded-lg border-2 border-dashed p-6 text-center transition-colors',
        isDragging
          ? 'border-amber-500 bg-amber-50 dark:bg-amber-900/20'
          : 'border-gray-300 hover:border-gray-400 dark:border-gray-600 dark:hover:border-gray-500',
      ]"
      @click="triggerFileInput"
      @dragover="handleDragOver"
      @dragleave="handleDragLeave"
      @drop="handleDrop">
      <svg
        class="mx-auto h-12 w-12 text-gray-400"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
        <span class="font-medium text-amber-600 hover:text-amber-500">Klik untuk upload</span>
        atau drag and drop
      </p>
      <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">
        PNG, JPG, WEBP {{ multiple ? `(Max ${maxFiles} files)` : '' }}
      </p>
    </div>

    <!-- Preview Grid -->
    <div
      v-if="previewUrls.length > 0"
      class="mt-4 grid gap-4"
      :class="multiple ? 'grid-cols-2 md:grid-cols-4' : 'grid-cols-1'">
      <div v-for="(url, index) in previewUrls" :key="index" class="group relative">
        <img
          :src="url"
          class="h-24 w-full rounded-lg object-cover"
          :class="!multiple ? 'h-40' : ''"
          alt="Preview" />
        <button
          type="button"
          class="absolute -top-2 -right-2 rounded-full bg-red-500 p-1 text-white opacity-0 transition group-hover:opacity-100 hover:bg-red-600"
          @click.stop="removeFile(index)">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>
