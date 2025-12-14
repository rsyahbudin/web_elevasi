<script setup>
import { computed, ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const logoUrl = computed(() => {
  const path = page.props.personalisation?.app_logo
  return path ? (path.startsWith('/storage/') ? path : `/storage/${path}`) : null
})

const darkLogoUrl = computed(() => {
  const path = page.props.personalisation?.app_logo_dark
  return path ? (path.startsWith('/storage/') ? path : `/storage/${path}`) : null
})

defineProps({
  // Allow passing generic class restrictions if needed, though attributes fallthrough usually handles this
  className: {
    type: String,
    default: '',
  },
})

const hasError = ref(false)
const hasDarkError = ref(false)

const handleLoadError = isDark => {
  if (isDark) {
    hasDarkError.value = true
  } else {
    hasError.value = true
  }
}
</script>

<template>
  <div class="inline-flex shrink-0 items-center justify-center" :class="className">
    <!-- Case 1: Both logos exist -->
    <template v-if="logoUrl && darkLogoUrl">
      <!-- Light Mode Logo: Hide in dark mode -->
      <img
        v-if="!hasError"
        :src="logoUrl"
        alt="Logo"
        class="block h-full w-auto dark:hidden"
        @error="handleLoadError(false)" />

      <!-- Dark Mode Logo: Show ONLY in dark mode -->
      <img
        v-if="!hasDarkError"
        :src="darkLogoUrl"
        alt="Logo Dark"
        class="hidden h-full w-auto dark:block"
        @error="handleLoadError(true)" />
    </template>

    <!-- Case 2: Only Light Mode Logo exists -->
    <template v-else-if="logoUrl">
      <img
        v-if="!hasError"
        :src="logoUrl"
        alt="Logo"
        class="h-full w-auto"
        @error="handleLoadError(false)" />
    </template>

    <!-- Case 3: Only Dark Mode Logo exists (rare but possible) -->
    <template v-else-if="darkLogoUrl">
      <img
        v-if="!hasDarkError"
        :src="darkLogoUrl"
        alt="Logo"
        class="h-full w-auto"
        @error="handleLoadError(true)" />
    </template>

    <!-- Fallback Text -->
    <h1
      v-if="
        (!logoUrl && !darkLogoUrl) ||
        (logoUrl && hasError && !darkLogoUrl) ||
        (darkLogoUrl && hasDarkError && !logoUrl)
      "
      class="text-xl font-bold whitespace-nowrap text-gray-800 dark:text-white">
      {{ page.props.personalisation?.app_name || 'GuacPanel' }}
    </h1>
  </div>
</template>

<style scoped>
/* No scoped styles needed, relying on utility classes */
</style>
