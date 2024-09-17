<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-end">
                <!-- Tulisan di sebelah kiri -->
                <div class="text-left mr-4">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">SIMAPAK</h2>
                    <h3>Sistem Informasi Manajemen Penilaian Angka Kredit</h3>
                </div>

                <!-- Gambar di sebelah kanan -->
                <img src="build/assets/bappeda.png" alt="Logo" class="h-20">
                <!-- Sesuaikan path dan ukuran gambar -->
            </div>
        </template>



        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!!!!!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
