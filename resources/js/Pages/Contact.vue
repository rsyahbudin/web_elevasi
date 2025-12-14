<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import FlashMessage from '@js/Components/Notifications/FlashMessage.vue'
import Navbar from '@js/Shared/Public/Navbar.vue'
import Footer from '@js/Shared/Public/Footer.vue'

const page = usePage()
const contact = computed(() => page.props.contact || {})

const form = useForm({
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: '',
})

const submitForm = () => {
  alert('Terima kasih! Pesan Anda telah dikirim. Kami akan segera menghubungi Anda.')
  form.reset()
}

const contactInfo = computed(() => [
  {
    icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z',
    icon2: 'M15 11a3 3 0 11-6 0 3 3 0 016 0z',
    title: 'Alamat',
    content: contact.value.address || 'Jakarta, Indonesia',
  },
  {
    icon: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
    title: 'Telepon',
    content: contact.value.phone || '+62 822 3154 5981',
  },
  {
    icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
    title: 'Email',
    content: contact.value.email || 'farhansyahbudin@elevasidesignbuild.com',
  },
])
</script>

<template>
  <FlashMessage />
  <Head title="Hubungi Kami - Elevasi Design & Build" />
  <div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
    <!-- Header -->
    <Navbar />

    <!-- Hero -->
    <section class="relative overflow-hidden py-16">
      <div
        class="absolute inset-0 bg-gradient-to-br from-amber-50/50 via-white to-slate-50 dark:from-amber-900/10 dark:via-gray-900 dark:to-gray-900"></div>
      <div class="relative mx-auto max-w-7xl px-4 text-center">
        <h1 class="mb-4 text-4xl font-bold text-gray-900 md:text-5xl dark:text-white">
          Hubungi Kami
        </h1>
        <p class="mx-auto max-w-2xl text-lg text-gray-600 dark:text-gray-300">
          Punya proyek atau pertanyaan? Kami siap membantu Anda mewujudkan bangunan impian.
        </p>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16">
      <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-12 lg:grid-cols-2">
          <!-- Contact Form -->
          <div class="rounded-2xl bg-white p-8 shadow-lg dark:bg-gray-800">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Kirim Pesan</h2>
            <form @submit.prevent="submitForm" class="space-y-6">
              <div class="grid gap-6 md:grid-cols-2">
                <div>
                  <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Nama
                  </label>
                  <input
                    v-model="form.name"
                    type="text"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="Nama lengkap"
                    required />
                </div>
                <div>
                  <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Email
                  </label>
                  <input
                    v-model="form.email"
                    type="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="email@example.com"
                    required />
                </div>
              </div>
              <div class="grid gap-6 md:grid-cols-2">
                <div>
                  <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Telepon
                  </label>
                  <input
                    v-model="form.phone"
                    type="tel"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="+62 822 3154 5981" />
                </div>
                <div>
                  <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Subjek
                  </label>
                  <select
                    v-model="form.subject"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="">Pilih subjek</option>
                    <option value="konsultasi">Konsultasi Proyek</option>
                    <option value="penawaran">Minta Penawaran</option>
                    <option value="kerjasama">Kerjasama</option>
                    <option value="lainnya">Lainnya</option>
                  </select>
                </div>
              </div>
              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Pesan
                </label>
                <textarea
                  v-model="form.message"
                  rows="5"
                  class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                  placeholder="Ceritakan tentang proyek atau pertanyaan Anda..."
                  required></textarea>
              </div>
              <button
                type="submit"
                class="w-full rounded-lg bg-amber-500 px-8 py-4 font-medium text-white transition-all hover:bg-amber-600">
                Kirim Pesan
              </button>
            </form>
          </div>

          <!-- Contact Info -->
          <div>
            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Informasi Kontak</h2>
            <div class="space-y-6">
              <div
                v-for="info in contactInfo"
                :key="info.title"
                class="flex items-start gap-4 rounded-xl bg-white p-6 shadow-md dark:bg-gray-800">
                <div
                  class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/50">
                  <svg
                    class="h-6 w-6 text-amber-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      :d="info.icon" />
                    <path
                      v-if="info.icon2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      :d="info.icon2" />
                  </svg>
                </div>
                <div>
                  <h3 class="font-bold text-gray-900 dark:text-white">{{ info.title }}</h3>
                  <p class="text-gray-600 dark:text-gray-400">{{ info.content }}</p>
                </div>
              </div>
            </div>

            <!-- WhatsApp CTA -->
            <div
              class="mt-8 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-6 text-white">
              <h3 class="mb-2 text-lg font-bold">Chat via WhatsApp</h3>
              <p class="mb-4 text-sm text-green-100">
                Butuh respons cepat? Hubungi kami langsung via WhatsApp.
              </p>
              <a
                href="https://wa.me/6282231545981"
                target="_blank"
                class="inline-flex items-center rounded-lg bg-white px-6 py-3 font-medium text-green-600 transition hover:bg-green-50">
                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                WhatsApp Kami
              </a>
            </div>

            <!-- Map Placeholder -->
            <div class="mt-8 overflow-hidden rounded-2xl bg-gray-200 dark:bg-gray-700">
              <div class="flex h-64 items-center justify-center">
                <div class="text-center text-gray-500 dark:text-gray-400">
                  <svg
                    class="mx-auto mb-2 h-12 w-12"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
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
                  <p>Peta Lokasi</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <Footer />
  </div>
</template>
