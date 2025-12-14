<script setup>
import { Head } from '@inertiajs/vue3'
import Navbar from '@js/Shared/Public/Navbar.vue'
import Footer from '@js/Shared/Public/Footer.vue'
</script>

<template>
  <Head title="Terms of Service - Elevasi Design & Build" />
  <div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
    <Navbar />

    <div class="mx-auto max-w-3xl p-6 py-16">
      <!-- Header -->
      <div class="mb-12 text-center">
        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Terms of Service</h1>
        <p class="text-gray-600 dark:text-gray-300">
          This software is open source and governed by the MIT License.
        </p>
      </div>

      <!-- MIT License Notice -->
      <div
        class="mb-8 rounded-lg border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
        <div class="flex items-center space-x-3">
          <div
            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/50">
            <svg
              class="h-4 w-4 text-blue-600 dark:text-blue-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900 dark:text-white">MIT Licensed Software</h3>
            <a
              href="https://opensource.org/license/MIT"
              class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
              target="_blank">
              View Official MIT License →
            </a>
          </div>
        </div>
      </div>

      <!-- License Text -->
      <div class="rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white">The MIT License</h2>
        </div>

        <div class="p-6">
          <div
            class="rounded bg-gray-50 p-4 font-mono text-sm leading-relaxed text-gray-700 dark:bg-gray-900/50 dark:text-gray-300">
            <p class="mb-4">
              Permission is hereby granted, free of charge, to any person obtaining a copy of this
              software and associated documentation files (the "Software"), to deal in the Software
              without restriction, including without limitation the rights to use, copy, modify,
              merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
              permit persons to whom the Software is furnished to do so, subject to the following
              conditions:
            </p>

            <p class="mb-4">
              The above copyright notice and this permission notice shall be included in all copies
              or substantial portions of the Software.
            </p>

            <p class="font-medium text-gray-900 dark:text-white">
              THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
              INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
              PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
              HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
              CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
              OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
            </p>
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>
