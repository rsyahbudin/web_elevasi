<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import FlashMessage from '@js/Components/Notifications/FlashMessage.vue'
import Navbar from '@js/Shared/Public/Navbar.vue'
import Footer from '@js/Shared/Public/Footer.vue'

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
    <Navbar />

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
    <Footer />
  </div>
</template>
