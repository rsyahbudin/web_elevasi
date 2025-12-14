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
  project: {
    type: Object,
    required: true,
  },
  relatedProjects: {
    type: Array,
    default: () => [],
  },
})

const mobileMenuOpen = ref(false)
const selectedImage = ref(null)
const showLightbox = ref(false)

const allImages = computed(() => {
  const images = []
  if (props.project.featured_image_url) {
    images.push(props.project.featured_image_url)
  }
  if (props.project.image_urls && props.project.image_urls.length > 0) {
    images.push(...props.project.image_urls)
  }
  return images
})

const openLightbox = imageUrl => {
  selectedImage.value = imageUrl
  showLightbox.value = true
}

const closeLightbox = () => {
  showLightbox.value = false
  selectedImage.value = null
}
</script>

<template>
  <FlashMessage />
  <Head :title="`${project.title} - Elevasi Design & Build`" />
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

    <!-- Breadcrumb -->
    <div class="mx-auto max-w-7xl px-4 py-6">
      <nav class="flex text-sm text-gray-500 dark:text-gray-400">
        <Link href="/" class="hover:text-amber-600">Beranda</Link>
        <span class="mx-2">/</span>
        <Link href="/projects" class="hover:text-amber-600">Proyek</Link>
        <span class="mx-2">/</span>
        <span class="text-gray-900 dark:text-white">{{ project.title }}</span>
      </nav>
    </div>

    <!-- Project Content -->
    <article class="mx-auto max-w-7xl px-4 pb-16">
      <div class="grid gap-8 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2">
          <!-- Hero Image -->
          <div v-if="project.featured_image_url" class="relative mb-8 overflow-hidden rounded-2xl">
            <img
              :src="project.featured_image_url"
              :alt="project.title"
              class="h-auto w-full cursor-pointer object-cover transition-transform duration-300 hover:scale-105"
              @click="openLightbox(project.featured_image_url)" />
          </div>

          <!-- Title & Description -->
          <h1 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">
            {{ project.title }}
          </h1>
          <div class="mb-6 flex flex-wrap items-center gap-4">
            <span class="rounded-full bg-amber-500 px-4 py-1 text-sm font-medium text-white">
              {{ project.category?.name || 'Proyek' }}
            </span>
            <span v-if="project.year_completed" class="text-gray-500 dark:text-gray-400">
              Tahun {{ project.year_completed }}
            </span>
          </div>
          <div
            v-if="project.description"
            class="prose prose-gray dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
            <p class="whitespace-pre-wrap">{{ project.description }}</p>
          </div>

          <!-- Gallery -->
          <div v-if="allImages.length > 1" class="mt-12">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Galeri Foto</h2>
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
              <div
                v-for="(imageUrl, index) in allImages"
                :key="index"
                class="group relative aspect-square cursor-pointer overflow-hidden rounded-xl"
                @click="openLightbox(imageUrl)">
                <img
                  :src="imageUrl"
                  :alt="`${project.title} - Foto ${index + 1}`"
                  class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110" />
                <div
                  class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                  <svg
                    class="h-10 w-10 text-white"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
          <!-- Project Info Card -->
          <div class="sticky top-24 space-y-6">
            <div class="rounded-2xl bg-white p-6 shadow-lg dark:bg-gray-800">
              <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-white">Detail Proyek</h3>
              <dl class="space-y-4">
                <div v-if="project.client_name">
                  <dt class="text-sm text-gray-500 dark:text-gray-400">Klien</dt>
                  <dd class="font-medium text-gray-900 dark:text-white">
                    {{ project.client_name }}
                  </dd>
                </div>
                <div v-if="project.location">
                  <dt class="text-sm text-gray-500 dark:text-gray-400">Lokasi</dt>
                  <dd class="font-medium text-gray-900 dark:text-white">{{ project.location }}</dd>
                </div>
                <div v-if="project.year_completed">
                  <dt class="text-sm text-gray-500 dark:text-gray-400">Tahun Selesai</dt>
                  <dd class="font-medium text-gray-900 dark:text-white">
                    {{ project.year_completed }}
                  </dd>
                </div>
                <div v-if="project.category">
                  <dt class="text-sm text-gray-500 dark:text-gray-400">Kategori</dt>
                  <dd class="font-medium text-gray-900 dark:text-white">
                    {{ project.category.name }}
                  </dd>
                </div>
              </dl>
            </div>

            <!-- CTA -->
            <div class="rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 p-6 text-white">
              <h3 class="mb-2 text-lg font-bold">Tertarik dengan Proyek Serupa?</h3>
              <p class="mb-4 text-sm text-amber-100">Hubungi kami untuk konsultasi gratis</p>
              <Link
                href="/contact"
                class="inline-block rounded-lg bg-white px-4 py-2 font-medium text-amber-600 transition hover:bg-amber-50">
                Hubungi Kami
              </Link>
            </div>

            <!-- Back Button -->
            <Link
              href="/projects"
              class="flex items-center gap-2 text-gray-600 transition hover:text-amber-600 dark:text-gray-400">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 19l-7-7 7-7" />
              </svg>
              Kembali ke Galeri
            </Link>
          </div>
        </div>
      </div>

      <!-- Related Projects -->
      <section v-if="relatedProjects.length > 0" class="mt-16">
        <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">Proyek Terkait</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <Link
            v-for="related in relatedProjects"
            :key="related.id"
            :href="route('projects.show', related.slug)"
            class="group relative overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl dark:bg-gray-800">
            <div class="relative aspect-[4/3] overflow-hidden">
              <img
                v-if="related.featured_image_url"
                :src="related.featured_image_url"
                :alt="related.title"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
              <div
                v-else
                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/30 dark:to-amber-800/30">
                <svg
                  class="h-12 w-12 text-amber-400"
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
            </div>
            <div class="p-4">
              <h3 class="font-bold text-gray-900 group-hover:text-amber-600 dark:text-white">
                {{ related.title }}
              </h3>
            </div>
          </Link>
        </div>
      </section>
    </article>

    <!-- Lightbox -->
    <div
      v-if="showLightbox"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
      @click="closeLightbox">
      <button class="absolute top-4 right-4 text-white hover:text-amber-400" @click="closeLightbox">
        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <img
        :src="selectedImage"
        :alt="project.title"
        class="max-h-[90vh] max-w-full rounded-lg object-contain"
        @click.stop />
    </div>

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
