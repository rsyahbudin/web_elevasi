<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import FlashMessage from '@js/Components/Notifications/FlashMessage.vue'

const props = defineProps({
  featuredProjects: {
    type: Array,
    default: () => [],
  },
})

const mobileMenuOpen = ref(false)
const showBackToTop = ref(false)

const handleScroll = () => {
  showBackToTop.value = window.scrollY > 500
}

const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})

const services = [
  {
    title: 'Konstruksi Bangunan',
    description: 'Pembangunan rumah, ruko, dan gedung komersial dengan kualitas terbaik.',
    icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
  },
  {
    title: 'Renovasi',
    description: 'Renovasi total atau parsial dengan desain modern dan fungsional.',
    icon: 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z',
  },
  {
    title: 'Interior Design',
    description: 'Desain interior yang elegan dan sesuai dengan kebutuhan Anda.',
    icon: 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
  },
  {
    title: 'Konsultasi Desain',
    description: 'Konsultasi gratis untuk mewujudkan bangunan impian Anda.',
    icon: 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
  },
]
</script>

<template>
  <FlashMessage />
  <Head title="Elevasi Design & Build - Kontraktor Profesional" />
  <div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
    <!-- Header -->
    <header
      class="sticky top-0 z-50 w-full border-b border-gray-100 bg-white/80 py-2 backdrop-blur-sm dark:border-gray-800 dark:bg-gray-900/80">
      <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2">
        <Link href="/" class="flex items-center gap-3">
          <img src="/images/logo.png" class="block h-10 w-auto dark:hidden" alt="Elevasi Logo" />
          <img
            src="/images/logo-dark.png"
            class="hidden h-10 w-auto dark:block"
            alt="Elevasi Logo" />
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
          <Link href="/" class="text-amber-600 dark:text-amber-400">Beranda</Link>
          <Link href="/projects" class="transition-colors hover:text-amber-600">Proyek</Link>
          <Link href="/about" class="transition-colors hover:text-amber-600">Tentang</Link>
          <Link href="/contact" class="transition-colors hover:text-amber-600">Kontak</Link>
        </nav>
        <Link
          href="/login"
          class="hidden items-center border border-amber-500 bg-amber-500/20 px-4 py-2 font-medium text-amber-700 transition-all hover:bg-amber-500/30 md:inline-flex dark:text-amber-300">
          Login
        </Link>
      </div>
      <!-- Mobile menu -->
      <div
        v-show="mobileMenuOpen"
        class="border-t border-gray-100 bg-white md:hidden dark:border-gray-800 dark:bg-gray-900">
        <div class="space-y-3 px-4 py-3">
          <Link href="/" class="block text-sm text-amber-600 dark:text-amber-400">Beranda</Link>
          <Link
            href="/projects"
            class="block text-sm text-gray-700 hover:text-amber-600 dark:text-gray-200">
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
    <section class="relative overflow-hidden py-20 lg:py-32">
      <div
        class="absolute inset-0 bg-gradient-to-br from-amber-50/50 via-white to-slate-50 dark:from-amber-900/10 dark:via-gray-900 dark:to-gray-900"></div>
      <div
        class="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-amber-100 opacity-30 blur-3xl dark:bg-amber-800"></div>
      <div
        class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-orange-100 opacity-30 blur-3xl dark:bg-orange-800"></div>
      <div class="relative mx-auto max-w-7xl px-4">
        <div class="grid items-center gap-12 lg:grid-cols-2">
          <div>
            <span
              class="mb-4 inline-block rounded-full bg-amber-100 px-4 py-1 text-sm font-medium text-amber-700 dark:bg-amber-900/50 dark:text-amber-300">
              Kontraktor Profesional
            </span>
            <h1
              class="mb-6 text-4xl leading-tight font-bold text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
              Wujudkan
              <span
                class="bg-gradient-to-r from-amber-600 to-orange-500 bg-clip-text text-transparent">
                Bangunan Impian
              </span>
              Anda
            </h1>
            <p class="mb-8 text-lg text-gray-600 dark:text-gray-300">
              Elevasi Design & Build adalah partner terpercaya untuk konstruksi, renovasi, dan
              desain interior. Kami menghadirkan kualitas terbaik dengan harga kompetitif.
            </p>
            <div class="flex flex-col gap-4 sm:flex-row">
              <Link
                href="/projects"
                class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-6 py-4 font-medium text-white transition-all hover:bg-amber-600 hover:shadow-lg hover:shadow-amber-500/30">
                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Lihat Portofolio
              </Link>
              <Link
                href="/contact"
                class="inline-flex items-center justify-center rounded-lg border-2 border-gray-300 bg-white px-6 py-4 font-medium text-gray-700 transition-all hover:border-amber-500 hover:text-amber-600 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:border-amber-500">
                Konsultasi Gratis
              </Link>
            </div>
          </div>
          <div class="relative">
            <div class="relative overflow-hidden rounded-2xl shadow-2xl">
              <img
                src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                alt="Construction Project"
                class="h-auto w-full object-cover" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
            </div>
            <!-- Stats Card -->
            <div
              class="absolute -bottom-6 -left-6 rounded-xl bg-white p-4 shadow-xl dark:bg-gray-800">
              <div class="flex items-center gap-4">
                <div
                  class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/50">
                  <svg
                    class="h-6 w-6 text-amber-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-2xl font-bold text-gray-900 dark:text-white">100+</p>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Proyek Selesai</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Section -->
    <section class="bg-white py-20 dark:bg-gray-900">
      <div class="mx-auto max-w-7xl px-4">
        <div class="mb-16 text-center">
          <span
            class="mb-2 inline-block text-sm font-medium tracking-wider text-amber-600 uppercase dark:text-amber-400">
            Layanan Kami
          </span>
          <h2 class="text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">
            Solusi Lengkap untuk Konstruksi
          </h2>
        </div>
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
          <div
            v-for="(service, index) in services"
            :key="index"
            class="group rounded-2xl border border-gray-100 bg-gradient-to-br from-white to-gray-50 p-6 transition-all duration-300 hover:-translate-y-2 hover:border-amber-200 hover:shadow-xl dark:border-gray-700 dark:from-gray-800 dark:to-gray-800/50 dark:hover:border-amber-500/50">
            <div
              class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-amber-100 transition-colors group-hover:bg-amber-500 dark:bg-amber-900/50">
              <svg
                class="h-7 w-7 text-amber-600 transition-colors group-hover:text-white"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  :d="service.icon" />
              </svg>
            </div>
            <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">
              {{ service.title }}
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ service.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Projects -->
    <section v-if="featuredProjects.length > 0" class="py-20">
      <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 flex items-end justify-between">
          <div>
            <span
              class="mb-2 inline-block text-sm font-medium tracking-wider text-amber-600 uppercase dark:text-amber-400">
              Portofolio
            </span>
            <h2 class="text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">
              Proyek Unggulan Kami
            </h2>
          </div>
          <Link
            href="/projects"
            class="hidden items-center gap-2 font-medium text-amber-600 transition hover:text-amber-700 md:flex dark:text-amber-400">
            Lihat Semua
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </Link>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <Link
            v-for="project in featuredProjects"
            :key="project.id"
            :href="route('projects.show', project.slug)"
            class="group relative overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl dark:bg-gray-800">
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
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
              <span
                class="absolute top-4 left-4 rounded-full bg-amber-500 px-3 py-1 text-xs font-medium text-white">
                {{ project.category?.name || 'Proyek' }}
              </span>
            </div>
            <div class="p-5">
              <h3
                class="mb-1 text-lg font-bold text-gray-900 transition-colors group-hover:text-amber-600 dark:text-white dark:group-hover:text-amber-400">
                {{ project.title }}
              </h3>
              <p v-if="project.location" class="text-sm text-gray-500 dark:text-gray-400">
                <svg
                  class="mr-1 inline h-4 w-4"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                </svg>
                {{ project.location }}
              </p>
            </div>
          </Link>
        </div>
        <div class="mt-8 text-center md:hidden">
          <Link
            href="/projects"
            class="inline-flex items-center gap-2 font-medium text-amber-600 transition hover:text-amber-700 dark:text-amber-400">
            Lihat Semua Proyek
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </Link>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-br from-amber-500 to-orange-500 py-20">
      <div class="mx-auto max-w-7xl px-4">
        <div class="relative rounded-2xl bg-white/10 p-8 backdrop-blur-sm md:p-12">
          <div class="absolute inset-0 bg-[url('/grid.svg')] opacity-10"></div>
          <div class="relative z-10 text-center">
            <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">
              Siap Membangun Bersama Kami?
            </h2>
            <p class="mx-auto mb-8 max-w-2xl text-lg text-amber-100">
              Konsultasikan proyek impian Anda dengan tim profesional kami. Gratis dan tanpa
              komitmen.
            </p>
            <div class="flex flex-col justify-center gap-4 sm:flex-row">
              <Link
                href="/contact"
                class="inline-flex items-center justify-center rounded-lg bg-white px-8 py-4 font-bold text-amber-600 transition-all hover:bg-amber-50 hover:shadow-lg">
                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Hubungi Kami
              </Link>
              <a
                href="https://wa.me/6281234567890"
                target="_blank"
                class="inline-flex items-center justify-center rounded-lg border-2 border-white bg-transparent px-8 py-4 font-bold text-white transition-all hover:bg-white/10">
                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white py-12 dark:border-gray-800 dark:bg-gray-900">
      <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-8 md:grid-cols-4">
          <div class="md:col-span-2">
            <div class="mb-4 flex items-center gap-3">
              <img
                src="/images/logo.png"
                class="block h-10 w-auto dark:hidden"
                alt="Elevasi Logo" />
              <img
                src="/images/logo-dark.png"
                class="hidden h-10 w-auto dark:block"
                alt="Elevasi Logo" />
            </div>
            <p class="mb-4 text-gray-600 dark:text-gray-400">
              Elevasi Design & Build adalah kontraktor profesional yang berkomitmen menghadirkan
              kualitas terbaik untuk setiap proyek konstruksi dan renovasi.
            </p>
          </div>
          <div>
            <h4 class="mb-4 font-bold text-gray-900 dark:text-white">Navigasi</h4>
            <nav class="space-y-2 text-sm">
              <Link href="/" class="block text-gray-600 hover:text-amber-600 dark:text-gray-400">
                Beranda
              </Link>
              <Link
                href="/projects"
                class="block text-gray-600 hover:text-amber-600 dark:text-gray-400">
                Proyek
              </Link>
              <Link
                href="/about"
                class="block text-gray-600 hover:text-amber-600 dark:text-gray-400">
                Tentang
              </Link>
              <Link
                href="/contact"
                class="block text-gray-600 hover:text-amber-600 dark:text-gray-400">
                Kontak
              </Link>
            </nav>
          </div>
          <div>
            <h4 class="mb-4 font-bold text-gray-900 dark:text-white">Kontak</h4>
            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
              <p>📍 Jakarta, Indonesia</p>
              <p>📞 +62 812 3456 7890</p>
              <p>✉️ info@elevasidesign.com</p>
            </div>
          </div>
        </div>
        <div
          class="mt-8 border-t border-gray-200 pt-8 text-center text-sm text-gray-600 dark:border-gray-700 dark:text-gray-400">
          <p>© 2024 Elevasi Design & Build. All rights reserved.</p>
        </div>
      </div>
    </footer>

    <!-- Back to Top Button -->
    <button
      v-show="showBackToTop"
      class="fixed right-4 bottom-4 z-50 rounded-full bg-amber-500 p-3 text-white shadow-lg transition-all hover:bg-amber-600 sm:right-8 sm:bottom-8"
      aria-label="Kembali ke atas"
      @click="scrollToTop">
      <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M5 10l7-7m0 0l7 7m-7-7v18" />
      </svg>
    </button>
  </div>
</template>
