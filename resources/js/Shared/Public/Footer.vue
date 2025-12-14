<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import Logo from '@js/Components/Common/Logo.vue'

const page = usePage()
const contact = computed(() => page.props.contact || {})
</script>

<template>
  <footer class="border-t border-gray-200 bg-white py-12 dark:border-gray-800 dark:bg-gray-900">
    <div class="mx-auto max-w-7xl px-4">
      <div class="grid gap-8 md:grid-cols-4">
        <div class="md:col-span-2">
          <div class="mb-4 flex items-center gap-3">
            <Logo class="h-10 w-auto" />
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
            <Link href="/about" class="block text-gray-600 hover:text-amber-600 dark:text-gray-400">
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
            <p v-if="contact.address">📍 {{ contact.address }}</p>
            <p v-else>📍 Jakarta, Indonesia</p>
            <p v-if="contact.phone">📞 {{ contact.phone }}</p>
            <p v-else>📞 +62 822 3154 5981</p>
            <p v-if="contact.email">✉️ {{ contact.email }}</p>
            <p v-else>✉️ farhansyahbudin@elevasidesignbuild.com</p>
          </div>
        </div>
      </div>
      <div
        class="mt-8 border-t border-gray-200 pt-8 text-center text-sm text-gray-600 dark:border-gray-700 dark:text-gray-400">
        <p>© {{ new Date().getFullYear() }} Elevasi Design & Build. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>
