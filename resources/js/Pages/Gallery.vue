<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import FlashMessage from '@js/Components/Notifications/FlashMessage.vue'
import Logo from '@js/Components/Common/Logo.vue'

const page = usePage()
const personalisation = computed(() => page.props.personalisation || {})

const logoUrl = computed(() => {
  return personalisation.value.app_logo
    ? `/storage/${personalisation.value.app_logo}`
    : '/images/logo.png'
})

const logoDarkUrl = computed(() => {
  return personalisation.value.app_logo_dark
    ? `/storage/${personalisation.value.app_logo_dark}`
    : '/images/logo-dark.png'
})

const props = defineProps({
  projects: {
    type: Array,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  featuredProjects: {
    type: Array,
    default: () => [],
  },
})

const selectedCategory = ref('all')
const mobileMenuOpen = ref(false)

const filteredProjects = computed(() => {
  if (selectedCategory.value === 'all') {
    return props.projects
  }
  return props.projects.filter(p => p.category?.id === selectedCategory.value)
})

const setCategory = categoryId => {
  selectedCategory.value = categoryId
}
</script>

<template>
  <FlashMessage />
  <Head title="Galeri Proyek - Elevasi Design & Build" />
  <div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
    <!-- Header -->
    <header
      class="sticky top-0 z-50 w-full border-b border-gray-100 bg-white/80 py-2 backdrop-blur-sm dark:border-gray-800 dark:bg-gray-900/80">
      <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2">
        <Link href="/" class="flex items-center gap-3">
          <Logo size="2.5rem" max-size="2.5rem" />
        </Link>
        <button
          class="flex items-center border border-gray-500 px-2 py-1 text-gray-800 md:hidden dark:border-gray-500 dark:text-gray-200"
          @click="mobileMenuOpen = !mobileMenuOpen">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
              v-if="!mobileMenuOpen"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16m-7 6h7" />
            <path
              v-else
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <nav class="hidden gap-8 text-sm font-medium text-gray-700 md:flex dark:text-gray-200">
          <Link href="/" class="transition-colors hover:text-amber-600">Beranda</Link>
          <Link href="/projects" class="text-amber-600 dark:text-amber-400">Proyek</Link>
          <Link href="/about" class="transition-colors hover:text-amber-600">Tentang</Link>
          <Link href="/contact" class="transition-colors hover:text-amber-600">Kontak</Link>
        </nav>
      </div>
      <!-- Mobile menu -->
      <div
        v-show="mobileMenuOpen"
        class="border-t border-gray-100 bg-white md:hidden dark:border-gray-800 dark:bg-gray-900">
        <div class="space-y-3 px-4 py-3">
          <Link
            href="/"
            class="block text-sm text-gray-700 hover:text-amber-600 dark:text-gray-200">
            Beranda
          </Link>
          <Link href="/projects" class="block text-sm text-amber-600 dark:text-amber-400">
            Proyek
          </Link>
          <Link
            href="/about"
            class="block text-sm text-gray-700 hover:text-amber-600 dark:text-gray-200">
            Tentang
          </Link>
          <Link
            href="/contact"
            class="block text-sm text-gray-700 hover:text-amber-600 dark:text-gray-200">
            Kontak
          </Link>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden py-16 sm:py-20">
      <div
        class="absolute inset-0 bg-gradient-to-br from-amber-50/50 via-white to-slate-50 dark:from-amber-900/10 dark:via-gray-900 dark:to-gray-900"></div>
      <div class="relative mx-auto max-w-7xl px-4 text-center">
        <h1 class="mb-4 text-4xl font-bold text-gray-900 md:text-5xl dark:text-white">
          Galeri Proyek
        </h1>
        <p class="mx-auto max-w-2xl text-lg text-gray-600 dark:text-gray-300">
          Jelajahi proyek-proyek terbaik yang telah kami kerjakan dengan dedikasi dan kualitas
          tinggi
        </p>
      </div>
    </section>

    <!-- Category Filter -->
    <section class="mx-auto max-w-7xl px-4 py-8">
      <div class="flex flex-wrap justify-center gap-3">
        <button
          @click="setCategory('all')"
          :class="[
            'rounded-full px-4 py-2 text-sm font-medium transition-all duration-200',
            selectedCategory === 'all'
              ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30'
              : 'bg-white text-gray-700 hover:bg-amber-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700',
          ]">
          Semua
        </button>
        <button
          v-for="category in categories"
          :key="category.id"
          @click="setCategory(category.id)"
          :class="[
            'rounded-full px-4 py-2 text-sm font-medium transition-all duration-200',
            selectedCategory === category.id
              ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30'
              : 'bg-white text-gray-700 hover:bg-amber-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700',
          ]">
          {{ category.name }}
        </button>
      </div>
    </section>

    <!-- Projects Grid -->
    <section class="mx-auto max-w-7xl px-4 pb-16">
      <div v-if="filteredProjects.length > 0" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <Link
          v-for="project in filteredProjects"
          :key="project.id"
          :href="route('projects.show', project.slug)"
          class="group relative overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl dark:bg-gray-800">
          <!-- Image -->
          <div class="relative aspect-[4/3] overflow-hidden">
            <img
              v-if="project.featured_image_url"
              :src="project.featured_image_url"
              :alt="project.title"
              class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
            <div
              v-else
              class="flex h-full w-full items-center justify-center bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/30 dark:to-amber-800/30">
              <svg
                class="h-16 w-16 text-amber-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <!-- Overlay -->
            <div
              class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            <!-- Category Badge -->
            <span
              class="absolute top-4 left-4 rounded-full bg-amber-500 px-3 py-1 text-xs font-medium text-white">
              {{ project.category?.name || 'Proyek' }}
            </span>
            <!-- Featured Badge -->
            <span
              v-if="project.is_featured"
              class="absolute top-4 right-4 rounded-full bg-yellow-400 px-2 py-1 text-xs font-medium text-yellow-900">
              ★ Featured
            </span>
          </div>
          <!-- Content -->
          <div class="p-5">
            <h3
              class="mb-2 text-lg font-bold text-gray-900 transition-colors group-hover:text-amber-600 dark:text-white dark:group-hover:text-amber-400">
              {{ project.title }}
            </h3>
            <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
              <span v-if="project.location" class="flex items-center gap-1">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ project.location }}
              </span>
              <span v-if="project.year_completed">{{ project.year_completed }}</span>
            </div>
          </div>
        </Link>
      </div>
      <div v-else class="py-16 text-center">
        <svg
          class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
          Belum ada proyek dalam kategori ini
        </p>
      </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white py-12 dark:border-gray-800 dark:bg-gray-900">
      <div class="mx-auto max-w-7xl px-4">
        <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
          <div class="flex items-center gap-3">
            <img src="/images/logo.png" class="block h-8 w-auto dark:hidden" alt="Elevasi Logo" />
            <img
              src="/images/logo-dark.png"
              class="hidden h-8 w-auto dark:block"
              alt="Elevasi Logo" />
            <span class="text-sm text-gray-600 dark:text-gray-400">
              © 2024 Elevasi Design & Build
            </span>
          </div>
          <nav class="flex gap-6 text-sm text-gray-600 dark:text-gray-400">
            <Link href="/" class="hover:text-amber-600">Beranda</Link>
            <Link href="/projects" class="hover:text-amber-600">Proyek</Link>
            <Link href="/about" class="hover:text-amber-600">Tentang</Link>
            <Link href="/contact" class="hover:text-amber-600">Kontak</Link>
          </nav>
        </div>
      </div>
    </footer>
  </div>
</template>
