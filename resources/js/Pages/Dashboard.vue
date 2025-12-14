<script setup>
import { Head, usePage, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import Default from '@js/Layouts/Default.vue'

defineOptions({
  layout: Default,
})

const props = defineProps({
  stats: {
    type: Array,
    required: true,
    default: () => [],
  },
  recentProjects: {
    type: Array,
    default: () => [],
  },
  projectsByCategory: {
    type: Array,
    default: () => [],
  },
})

const page = usePage()
const userName = computed(() => page.props.auth.user?.name || 'User')

const formattedDate = computed(() => {
  const date = new Date()
  return {
    display: date.toLocaleDateString('id-ID', {
      weekday: 'long',
      day: 'numeric',
      month: 'long',
      year: 'numeric',
    }),
  }
})

const greeting = computed(() => {
  const hour = new Date().getHours()
  if (hour < 12) return 'Selamat Pagi'
  if (hour < 17) return 'Selamat Siang'
  return 'Selamat Malam'
})

const icons = {
  folder:
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>',
  globe:
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>',
  star: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
  tag: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
  users:
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
}

const colorClasses = {
  blue: 'bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400',
  green: 'bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-400',
  amber: 'bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-400',
  purple: 'bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400',
  indigo: 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400',
}
</script>

<template>
  <Head title="Dashboard" />

  <main class="min-h-screen">
    <div class="mx-auto max-w-6xl">
      <!-- Header -->
      <header
        class="mb-6 rounded-xl border border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50 p-6 shadow-sm sm:mb-8 sm:p-8 dark:border-gray-700 dark:from-gray-800 dark:to-gray-800">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between sm:gap-6">
          <div class="flex-1">
            <h1 class="mb-2 text-2xl font-bold text-gray-900 sm:text-3xl dark:text-white">
              {{ greeting }}, {{ userName }} 👋
            </h1>
            <p class="text-sm text-gray-600 sm:text-base dark:text-gray-400">
              Selamat datang di Panel Admin Elevasi Design & Build
            </p>
          </div>
          <time
            class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-xs font-medium text-gray-600 sm:text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
            <svg
              class="h-4 w-4 flex-shrink-0"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>{{ formattedDate.display }}</span>
          </time>
        </div>
      </header>

      <!-- Stats Cards -->
      <section class="mb-8">
        <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
          <div
            v-for="(stat, index) in stats"
            :key="index"
            class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition-all hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-start justify-between">
              <div>
                <p class="text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                  {{ stat.title }}
                </p>
                <p class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl dark:text-white">
                  {{ stat.value }}
                </p>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                  {{ stat.description }}
                </p>
              </div>
              <div
                class="flex h-10 w-10 items-center justify-center rounded-lg sm:h-12 sm:w-12"
                :class="colorClasses[stat.color]">
                <svg
                  class="h-5 w-5 sm:h-6 sm:w-6"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  v-html="icons[stat.icon]"></svg>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Content Grid -->
      <div class="grid gap-6 lg:grid-cols-3">
        <!-- Recent Projects -->
        <div
          class="rounded-xl border border-gray-200 bg-white shadow-sm lg:col-span-2 dark:border-gray-700 dark:bg-gray-800">
          <div
            class="flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Proyek Terbaru</h2>
            <Link
              :href="route('admin.project.index')"
              class="text-sm font-medium text-amber-600 hover:text-amber-700 dark:text-amber-400">
              Lihat Semua →
            </Link>
          </div>
          <div
            v-if="recentProjects.length > 0"
            class="divide-y divide-gray-200 dark:divide-gray-700">
            <div
              v-for="project in recentProjects"
              :key="project.id"
              class="flex items-center gap-4 p-4 transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50">
              <div
                v-if="project.featured_image_url"
                class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg">
                <img
                  :src="project.featured_image_url"
                  :alt="project.title"
                  class="h-full w-full object-cover" />
              </div>
              <div
                v-else
                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/50">
                <svg
                  class="h-6 w-6 text-amber-600 dark:text-amber-400"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="min-w-0 flex-1">
                <p class="truncate font-medium text-gray-900 dark:text-white">
                  {{ project.title }}
                </p>
                <div class="mt-1 flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                  <span>{{ project.category }}</span>
                  <span>•</span>
                  <span>{{ project.created_at }}</span>
                </div>
              </div>
              <div class="flex items-center gap-2">
                <span
                  v-if="project.is_featured"
                  class="rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-400">
                  ★ Featured
                </span>
                <span
                  :class="
                    project.status === 'published'
                      ? 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400'
                      : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'
                  "
                  class="rounded-full px-2 py-0.5 text-xs font-medium">
                  {{ project.status === 'published' ? 'Published' : 'Draft' }}
                </span>
              </div>
            </div>
          </div>
          <div v-else class="p-8 text-center">
            <svg
              class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <p class="mt-4 text-gray-500 dark:text-gray-400">Belum ada proyek</p>
            <Link
              :href="route('admin.project.create')"
              class="mt-4 inline-flex items-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600">
              + Tambah Proyek
            </Link>
          </div>
        </div>

        <!-- Projects by Category -->
        <div
          class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
          <div
            class="flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Proyek per Kategori</h2>
          </div>
          <div v-if="projectsByCategory.length > 0" class="p-5">
            <div class="space-y-4">
              <div v-for="cat in projectsByCategory" :key="cat.name">
                <div class="mb-1 flex items-center justify-between text-sm">
                  <span class="font-medium text-gray-700 dark:text-gray-300">{{ cat.name }}</span>
                  <span class="text-gray-500 dark:text-gray-400">{{ cat.count }} proyek</span>
                </div>
                <div class="h-2 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                  <div
                    class="h-full rounded-full bg-amber-500"
                    :style="{
                      width: `${Math.min((cat.count / Math.max(...projectsByCategory.map(c => c.count))) * 100, 100)}%`,
                    }"></div>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400">Belum ada kategori</p>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <section class="mt-8">
        <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Aksi Cepat</h2>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
          <Link
            :href="route('admin.project.create')"
            class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-amber-500 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-amber-500">
            <div
              class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/50">
              <svg
                class="h-5 w-5 text-amber-600 dark:text-amber-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 4v16m8-8H4" />
              </svg>
            </div>
            <div>
              <p class="font-medium text-gray-900 dark:text-white">Tambah Proyek</p>
              <p class="text-xs text-gray-500 dark:text-gray-400">Buat proyek baru</p>
            </div>
          </Link>
          <Link
            :href="route('admin.project.index')"
            class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-blue-500 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-blue-500">
            <div
              class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/50">
              <svg
                class="h-5 w-5 text-blue-600 dark:text-blue-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 10h16M4 14h16M4 18h16" />
              </svg>
            </div>
            <div>
              <p class="font-medium text-gray-900 dark:text-white">Kelola Proyek</p>
              <p class="text-xs text-gray-500 dark:text-gray-400">Lihat semua proyek</p>
            </div>
          </Link>
          <Link
            :href="route('admin.project.category.index')"
            class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-purple-500 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-purple-500">
            <div
              class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/50">
              <svg
                class="h-5 w-5 text-purple-600 dark:text-purple-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
              </svg>
            </div>
            <div>
              <p class="font-medium text-gray-900 dark:text-white">Kategori</p>
              <p class="text-xs text-gray-500 dark:text-gray-400">Kelola kategori</p>
            </div>
          </Link>
          <a
            href="/"
            target="_blank"
            class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-green-500 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-green-500">
            <div
              class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/50">
              <svg
                class="h-5 w-5 text-green-600 dark:text-green-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
            </div>
            <div>
              <p class="font-medium text-gray-900 dark:text-white">Lihat Website</p>
              <p class="text-xs text-gray-500 dark:text-gray-400">Buka halaman publik</p>
            </div>
          </a>
        </div>
      </section>
    </div>
  </main>
</template>
