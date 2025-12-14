<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Logo from '@js/Components/Common/Logo.vue'
import NavDarkModeToggle from '@js/Components/Nav/NavDarkModeToggle.vue'

const mobileMenuOpen = ref(false)
const page = usePage()

// Helper to determine active state (simple matching)
const isActive = path => page.url === path
</script>

<template>
  <header
    class="sticky top-0 z-50 w-full border-b border-gray-100 bg-white/80 py-2 backdrop-blur-sm dark:border-gray-800 dark:bg-gray-900/80">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2">
      <Link href="/" class="flex items-center gap-3">
        <Logo class="h-10 w-auto" />
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
        <Link
          href="/"
          class="transition-colors hover:text-amber-600"
          :class="{ 'text-amber-600 dark:text-amber-400': isActive('/') }">
          Beranda
        </Link>
        <Link
          href="/projects"
          class="transition-colors hover:text-amber-600"
          :class="{ 'text-amber-600 dark:text-amber-400': isActive('/projects') }">
          Proyek
        </Link>
        <Link
          href="/about"
          class="transition-colors hover:text-amber-600"
          :class="{ 'text-amber-600 dark:text-amber-400': isActive('/about') }">
          Tentang
        </Link>
        <Link
          href="/contact"
          class="transition-colors hover:text-amber-600"
          :class="{ 'text-amber-600 dark:text-amber-400': isActive('/contact') }">
          Kontak
        </Link>
        <div class="border-l border-gray-200 pl-4 dark:border-gray-700">
          <NavDarkModeToggle :show-tooltip="false" />
        </div>
      </nav>
    </div>
    <!-- Mobile menu -->
    <div
      v-show="mobileMenuOpen"
      class="border-t border-gray-100 bg-white md:hidden dark:border-gray-800 dark:bg-gray-900">
      <div class="space-y-3 px-4 py-3">
        <Link
          href="/"
          class="block text-sm text-gray-700 hover:text-amber-600 dark:text-gray-200"
          :class="{ 'text-amber-600 dark:text-amber-400': isActive('/') }">
          Beranda
        </Link>
        <Link
          href="/projects"
          class="block text-sm text-gray-700 hover:text-amber-600 dark:text-gray-200"
          :class="{ 'text-amber-600 dark:text-amber-400': isActive('/projects') }">
          Proyek
        </Link>
        <Link
          href="/about"
          class="block text-sm text-gray-700 hover:text-amber-600 dark:text-gray-200"
          :class="{ 'text-amber-600 dark:text-amber-400': isActive('/about') }">
          Tentang
        </Link>
        <Link
          href="/contact"
          class="block text-sm text-gray-700 hover:text-amber-600 dark:text-gray-200"
          :class="{ 'text-amber-600 dark:text-amber-400': isActive('/contact') }">
          Kontak
        </Link>
        <div
          class="flex items-center justify-between border-t border-gray-100 pt-3 dark:border-gray-800">
          <span class="text-sm text-gray-500 dark:text-gray-400">Tema</span>
          <NavDarkModeToggle :show-tooltip="false" />
        </div>
      </div>
    </div>
  </header>
</template>
