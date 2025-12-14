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

const mobileMenuOpen = ref(false)

const team = [
  { name: 'Ahmad Rahman', role: 'Founder & CEO', image: null },
  { name: 'Siti Nurhaliza', role: 'Lead Architect', image: null },
  { name: 'Budi Santoso', role: 'Project Manager', image: null },
]

const stats = [
  { value: '100+', label: 'Proyek Selesai' },
  { value: '50+', label: 'Klien Puas' },
  { value: '10+', label: 'Tahun Pengalaman' },
  { value: '25+', label: 'Tim Profesional' },
]
</script>

<template>
  <FlashMessage />
  <Head title="Tentang Kami - Elevasi Design & Build" />
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
          <Link href="/projects" class="transition-colors hover:text-amber-600">Proyek</Link>
          <Link href="/about" class="text-amber-600 dark:text-amber-400">Tentang</Link>
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
          <Link
            href="/projects"
            class="block text-sm text-gray-700 hover:text-amber-600 dark:text-gray-200">
            Proyek
          </Link>
          <Link href="/about" class="block text-sm text-amber-600 dark:text-amber-400">
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

    <!-- Hero -->
    <section class="relative overflow-hidden py-20">
      <div
        class="absolute inset-0 bg-gradient-to-br from-amber-50/50 via-white to-slate-50 dark:from-amber-900/10 dark:via-gray-900 dark:to-gray-900"></div>
      <div class="relative mx-auto max-w-7xl px-4 text-center">
        <h1 class="mb-4 text-4xl font-bold text-gray-900 md:text-5xl dark:text-white">
          Tentang Kami
        </h1>
        <p class="mx-auto max-w-2xl text-lg text-gray-600 dark:text-gray-300">
          Elevasi Design & Build adalah kontraktor profesional yang berdedikasi menghadirkan
          kualitas terbaik untuk setiap proyek konstruksi.
        </p>
      </div>
    </section>

    <!-- Story Section -->
    <section class="bg-white py-16 dark:bg-gray-900">
      <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
          <div>
            <span
              class="mb-2 inline-block text-sm font-medium tracking-wider text-amber-600 uppercase dark:text-amber-400">
              Cerita Kami
            </span>
            <h2 class="mb-6 text-3xl font-bold text-gray-900 dark:text-white">
              Membangun dengan Integritas dan Kualitas
            </h2>
            <div class="space-y-4 text-gray-600 dark:text-gray-300">
              <p>
                Didirikan dengan visi untuk menjadi mitra konstruksi terpercaya, Elevasi Design &
                Build telah berkembang menjadi salah satu kontraktor terkemuka di Indonesia.
              </p>
              <p>
                Kami percaya bahwa setiap proyek adalah unik dan memerlukan pendekatan yang
                personal. Tim kami yang berpengalaman bekerja sama dengan klien untuk memahami
                kebutuhan dan mewujudkan visi mereka menjadi kenyataan.
              </p>
              <p>
                Dengan fokus pada kualitas, ketepatan waktu, dan kepuasan pelanggan, kami telah
                menyelesaikan ratusan proyek dari rumah tinggal hingga gedung komersial.
              </p>
            </div>
          </div>
          <div class="relative">
            <img
              src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
              alt="Construction Team"
              class="rounded-2xl shadow-xl" />
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-amber-500 py-16">
      <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
          <div v-for="stat in stats" :key="stat.label" class="text-center">
            <div class="text-4xl font-bold text-white md:text-5xl">{{ stat.value }}</div>
            <div class="mt-2 text-amber-100">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Values Section -->
    <section class="bg-white py-16 dark:bg-gray-900">
      <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 text-center">
          <span
            class="mb-2 inline-block text-sm font-medium tracking-wider text-amber-600 uppercase dark:text-amber-400">
            Nilai-Nilai Kami
          </span>
          <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Prinsip yang Kami Pegang</h2>
        </div>
        <div class="grid gap-8 md:grid-cols-3">
          <div
            class="rounded-2xl border border-gray-100 bg-gray-50 p-8 text-center dark:border-gray-700 dark:bg-gray-800">
            <div
              class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/50">
              <svg
                class="h-8 w-8 text-amber-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Kualitas</h3>
            <p class="text-gray-600 dark:text-gray-400">
              Kami tidak berkompromi dengan kualitas. Setiap detail dikerjakan dengan standar
              tertinggi.
            </p>
          </div>
          <div
            class="rounded-2xl border border-gray-100 bg-gray-50 p-8 text-center dark:border-gray-700 dark:bg-gray-800">
            <div
              class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/50">
              <svg
                class="h-8 w-8 text-amber-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Tepat Waktu</h3>
            <p class="text-gray-600 dark:text-gray-400">
              Kami menghargai waktu Anda. Setiap proyek dikerjakan sesuai jadwal yang disepakati.
            </p>
          </div>
          <div
            class="rounded-2xl border border-gray-100 bg-gray-50 p-8 text-center dark:border-gray-700 dark:bg-gray-800">
            <div
              class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/50">
              <svg
                class="h-8 w-8 text-amber-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Transparansi</h3>
            <p class="text-gray-600 dark:text-gray-400">
              Komunikasi terbuka dan jelas. Anda selalu tahu perkembangan proyek Anda.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16">
      <div class="mx-auto max-w-7xl px-4 text-center">
        <h2 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">
          Siap Memulai Proyek Anda?
        </h2>
        <p class="mx-auto mb-8 max-w-xl text-gray-600 dark:text-gray-300">
          Hubungi kami untuk konsultasi gratis dan wujudkan bangunan impian Anda.
        </p>
        <Link
          href="/contact"
          class="inline-flex items-center rounded-lg bg-amber-500 px-8 py-4 font-medium text-white transition-all hover:bg-amber-600">
          Hubungi Kami
          <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 8l4 4m0 0l-4 4m4-4H3" />
          </svg>
        </Link>
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
