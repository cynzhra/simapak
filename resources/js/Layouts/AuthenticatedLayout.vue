<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
// import { Link } from '@inertiajs/vue3';
import { Link, usePage } from '@inertiajs/inertia-vue3'

// Fetch the current user from the page props
const page = usePage()

const showingNavigationDropdown = ref(false);
</script>
<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <nav class="w-64 bg-white shadow-lg border-r border-gray-100">
      <div class="flex flex-col items-center justify-center h-32 bg-white border-b border-gray-200">
        <!-- User Information -->
        <div class="flex items-center space-x-4 p-4">
          <!-- User Info -->
          <div class="flex flex-col text-left">
            <div class="font-medium text-lg text-gray-800">{{ $page.props.auth.user.name }}</div>
            <div class="text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
          </div>
          <!-- User Photo -->
          <img src="build/assets/bappeda.png" alt="User Photo" class="w-12 h-12 rounded-full object-cover">
        </div>
      </div>

      <!-- Navigation Links -->
      <div class="flex-1 p-4">
        <ul class="space-y-20 mt-20">
          <li>
            <NavLink :href="route('dashboard')" :active="route().current('dashboard')"
              class="block px-4 py-2 rounded hover:text-yellow-500 hover:bg-cl active:text-white flex items-center space-x-2 w-full">
              <!-- SVG Icon -->
              <svg class="w-6 h-6 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                  d="M4.857 3A1.857 1.857 0 0 0 3 4.857v4.286C3 10.169 3.831 11 4.857 11h4.286A1.857 1.857 0 0 0 11 9.143V4.857A1.857 1.857 0 0 0 9.143 3H4.857Zm10 0A1.857 1.857 0 0 0 13 4.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 9.143V4.857A1.857 1.857 0 0 0 19.143 3h-4.286Zm-10 10A1.857 1.857 0 0 0 3 14.857v4.286C3 20.169 3.831 21 4.857 21h4.286A1.857 1.857 0 0 0 11 19.143v-4.286A1.857 1.857 0 0 0 9.143 13H4.857Zm10 0A1.857 1.857 0 0 0 13 14.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 19.143v-4.286A1.857 1.857 0 0 0 19.143 13h-4.286Z"
                  clip-rule="evenodd" />
              </svg>
              <span>Dashboard</span>
            </NavLink>
          </li>

          <li>
            <NavLink :href="route('penilaian')" :active="route().current('penilaian')"
              class="block px-4 py-2 rounded hover:text-yellow-500 hover:bg-cl active:text-white flex items-center space-x-2 w-full">
              <!-- SVG Icon -->
              <svg class="w-6 h-6 text-green-600 dark:text-green" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
              </svg>
              <span>Penilaian Kinerja</span>
            </NavLink>
          </li>

          <li>
            <NavLink :href="route('akhir')" :active="route().current('akhir')"
              class="block px-4 py-2 rounded hover:text-yellow-500 hover:bg-cl active:text-white flex items-center space-x-2 w-full">
              <!-- SVG Icon -->
              <svg class="w-6 h-6 text-green-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z" />
              </svg>
              <span>Penilaian Akhir</span>
            </NavLink>
          </li>

        </ul>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Page Header -->
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-6">
        <slot />
      </main>
    </div>
  </div>
</template>





<!-- <script>
  export default {
    name: 'Sidebar',
  };
  </script> -->
