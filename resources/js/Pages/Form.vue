<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import AppModal from '@/Components/Modal.vue';
import { ref } from 'vue';
</script>

<template>

    <Head title="Dashboard" />


    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-end">
                <!-- Tulisan di sebelah kiri -->
                <div class="text-left mr-4">
                    <h2 class="font-semibold text-xl teyxt-gray-800 leading-tight">SIMAPAK</h2>
                    <h3>Sistem Informasi Manajemen Penilaian Angka Kredit</h3>
                </div>

                <!-- Gambar di sebelah kanan -->
                <img src="build/assets/bappeda.png" alt="Logo" class="h-20">
                <!-- Sesuaikan path dan ukuran gambar -->
            </div>
        </template>



        <form class="pt-6">
            <div class="p-12 max-w-3xl mx-auto bg-white border border-gray-300 rounded-xl shadow-sm">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">

                        <!-- Bagian Grid untuk Input Nama dan Divisi -->
                        <div class="mt-10 grid grid-cols-2 gap-x-6 gap-y-8">
                            <div class="sm:col-span-1">
                                <label for="karyawan-select" class="block text-md font-bold leading-6">Pilih
                                    Karyawan</label>
                                <div class="mt-2">
                                    <multiselect :options="formattedKaryawan" v-model="selectedKaryawan"
                                        label="displayLabel" placeholder="NIP - Nama" track-by="nip"
                                        @search="fetchKaryawan"
                                        class="block w-full py-1.5 text-gray-900 focus:ring-0 sm:text-sm sm:leading-6">
                                        <template #option="{ option }">
                                            <div>
                                                {{ option.nip }} - {{ option.nama }}
                                            </div>
                                        </template>
                                        <template #selected-item="{ option }">
                                            <div>
                                                {{ option.nip }} - {{ option.nama }}
                                            </div>
                                        </template>
                                    </multiselect>
                                </div>
                            </div>

                            <div class="col-span-1">
                                <label for="division"
                                    class="block text-md font-bold leading-6 text-green-700">Divisi</label>
                                <div class="mt-2">
                                    <input type="text" name="divisi" id="divisi" :value="unitKerja"
                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                        readonly />
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-1 mt-8">
                            <label for="input_nilai" class="block text-md font-bold leading-6 text">Input Nilai</label>


                        </div>

                        <div id="app" class="sm:col-span-1 mt-8">
                            <!-- Container untuk tombol -->
                            <div class="flex space-x-4">
                                <!-- Tombol pertama untuk membuka modal -->
                                <button @click="toggleModal" :class="[
                                    'modal-button',
                                    'text-white',
                                    isKemampuanTeknisExists ? 'bg-blue-700 hover:bg-blue-800' : 'bg-green-700 hover:bg-green-800',
                                    'focus:ring-4',
                                    'focus:outline-none',
                                    isKemampuanTeknisExists ? 'focus:ring-blue-300' : 'focus:ring-green-300',
                                    'font-medium',
                                    'rounded-lg',
                                    'text-sm',
                                    'px-5',
                                    'py-2.5',
                                    'text-center',
                                    isKemampuanTeknisExists ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
                                    'flex',
                                    'items-center',
                                    'space-x-2',
                                    'disabled:opacity-50',
                                    'disabled:text-gray-500',
                                    'disabled:bg-gray-300'
                                ]" type="button" :disabled="!isKaryawanSelected">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        :stroke-width="isKemampuanTeknisExists ? '1.5' : '2'" stroke="currentColor"
                                        class="w-5 h-5">
                                        <path
                                            :d="isKemampuanTeknisExists ? 'M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z' : 'M12 4v16m8-8H4'"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path :d="isKemampuanTeknisExists ? 'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' : ''"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>Kemampuan Teknis</span>
                                </button>

                                <!-- Main modal -->
                                <div v-if="showModal" tabindex="-1" aria-hidden="true"
                                    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full inset-0">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeModal"></div>
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Penilaian Kemampuan Teknis
                                                </h1>
                                                <button @click="closeModal" type="button"
                                                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-4 md:p-5">
                                                <!-- Form for technical skills -->
                                                <form @submit.prevent="submitTechnicalSkills" method="POST">
                                                    <div class="flex items-center space-x-4 mb-4">
                                                        <label for="pengetahuan"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">Pengetahuan</label>
                                                        <input v-model.number="technicalSkills.pengetahuan"
                                                            type="number" name="pengetahuan" id="pengetahuan"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            required />
                                                    </div>

                                                    <div class="flex items-center space-x-4 mb-4">
                                                        <label for="keterampilan"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">Keterampilan</label>
                                                        <input v-model.number="technicalSkills.keterampilan"
                                                            type="number" name="keterampilan" id="keterampilan"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            required />
                                                    </div>

                                                    <div class="flex items-center space-x-4">
                                                        <label for="pengalaman"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">Pengalaman</label>
                                                        <input v-model.number="technicalSkills.pengalaman" type="number"
                                                            name="pengalaman" id="pengalaman"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            required />
                                                    </div>

                                                    <div class="flex items-center space-x-4 mb-4">
                                                        <label for="implementasi"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">Implementasi</label>
                                                        <input v-model.number="technicalSkills.implementasi"
                                                            type="number" name="implementasi" id="implementasi"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            required />
                                                    </div>

                                                    <div class="flex items-center space-x-4">
                                                        <label for="sertifikasi"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">Sertifikasi</label>
                                                        <input v-model.number="technicalSkills.sertifikasi"
                                                            type="number" name="sertifikasi" id="sertifikasi"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            required />
                                                    </div>

                                                    <div class="flex items-center space-x-4 mb-4"
                                                        :hidden="!isKemampuanTeknisExists">
                                                        <label for="bobot_nilai"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">Bobot
                                                            Nilai</label>
                                                        <input v-model.number="technicalSkills.bobot_nilai"
                                                            type="number" name="bobot_nilai" id="bobot_nilai"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            readonly />
                                                    </div>

                                                    <div class="flex items-center space-x-4 mb-4"
                                                        :hidden="!isKemampuanTeknisExists">
                                                        <label for="kategori_nilai"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">Kategori
                                                            Nilai</label>
                                                        <input v-model.text="technicalSkills.kategori_nilai" type="text"
                                                            name="kategori_nilai" id="kategori_nilai"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            readonly />
                                                    </div>

                                                    <div class="flex justify-end">
                                                        <button type="submit" :disabled="!isEditing"
                                                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 disabled:text-gray-500 disabled:bg-gray-300">
                                                            {{ isEditing ? 'Simpan Perubahan' : 'Simpan' }}
                                                        </button>
                                                        <button type="button" @click="editTechnicalSkills"
                                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                            v-if="isKemampuanTeknisExists">
                                                            Edit
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Tombol kedua untuk membuka modal kedua -->
                                <button @click="toggleModal2" :class="[
                                    'modal-button',
                                    'text-white',
                                    isKualitasPekerjaanExists ? 'bg-blue-700 hover:bg-blue-800' : 'bg-green-700 hover:bg-green-800',
                                    'focus:ring-4',
                                    'focus:outline-none',
                                    isKualitasPekerjaanExists ? 'focus:ring-blue-300' : 'focus:ring-green-300',
                                    'font-medium',
                                    'rounded-lg',
                                    'text-sm',
                                    'px-5',
                                    'py-2.5',
                                    'text-center',
                                    isKualitasPekerjaanExists ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
                                    'flex',
                                    'items-center',
                                    'space-x-2',
                                    'disabled:opacity-50',
                                    'disabled:text-gray-500',
                                    'disabled:bg-gray-300'
                                ]" type="button" :disabled="!isKaryawanSelected">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        :stroke-width="isKualitasPekerjaanExists ? '1.5' : '2'" stroke="currentColor"
                                        class="w-5 h-5">
                                        <path
                                            :d="isKualitasPekerjaanExists ? 'M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z' : 'M12 4v16m8-8H4'"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            :d="isKualitasPekerjaanExists ? 'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' : ''"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>Kualitas Pekerjaan</span>
                                </button>



                                <!-- Main modal -->
                                <div v-if="showModal2" tabindex="-1" aria-hidden="true"
                                    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full inset-0">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeModal"></div>
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Penilaian Kualitas Pekerjaan
                                                </h1>
                                                <button @click="closeModal" type="button"
                                                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-4 md:p-5">
                                                <form class="space-y-4" @submit.prevent="submitQuality" method="POST">
                                                    <div class="flex items-center space-x-4 mb-4">
                                                        <label for="ketepatan"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                            Ketepatan
                                                        </label>
                                                        <input v-model.number="quality.ketepatan" type="number"
                                                            name="ketepatan" id="ketepatan"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            required />
                                                    </div>

                                                    <div class="flex items-center space-x-4 mb-4">
                                                        <label for="ketelitian"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                            Ketelitian
                                                        </label>
                                                        <input v-model.number="quality.ketelitian" type="number"
                                                            name="ketelitian" id="ketelitian"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            required />
                                                    </div>

                                                    <div class="flex items-center space-x-4">
                                                        <label for="kreativitas"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                            Kreativitas
                                                        </label>
                                                        <input v-model.number="quality.kreativitas" type="number"
                                                            name="kreativitas" id="kreativitas"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            required />
                                                    </div>


                                                    <div class="flex items-center space-x-4 mb-4">
                                                        <label for="kepatuhan"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                            Kepatuhan
                                                        </label>
                                                        <input v-model.number="quality.kepatuhan" type="number"
                                                            name="kepatuhan" id="kepatuhan"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            required />
                                                    </div>

                                                    <div class="flex items-center space-x-4">
                                                        <label for="tepat_waktu"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                            Penyelesaian Tepat Waktu
                                                        </label>
                                                        <input v-model.number="quality.tepat_waktu" type="number"
                                                            name="tepat_waktu" id="tepat_waktu"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            required />
                                                    </div>
                                                    <div class="flex items-center space-x-4 mb-4"
                                                        :hidden="!isKualitasPekerjaanExists">
                                                        <label for="bobot_nilai"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">Bobot
                                                            Nilai</label>
                                                        <input v-model.number="quality.bobot_nilai" type="number"
                                                            name="bobot_nilai" id="bobot_nilai"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            readonly />
                                                    </div>

                                                    <div class="flex items-center space-x-4 mb-4"
                                                        :hidden="!isKualitasPekerjaanExists">
                                                        <label for="kategori_nilai"
                                                            class="text-sm font-medium text-gray-900 dark:text-white w-1/3">Kategori
                                                            Nilai</label>
                                                        <input v-model.text="quality.kategori_nilai" type="text"
                                                            name="kategori_nilai" id="kategori_nilai"
                                                            class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                            readonly />
                                                    </div>

                                                    <div class="flex justify-end">
                                                        <button type="submit"
                                                            :disabled="!isNewData && !isEditingQuality"
                                                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 disabled:text-gray-500 disabled:bg-gray-300">
                                                            {{ isEditingQuality ? 'Simpan Perubahan' : 'Simpan' }}
                                                        </button>
                                                        <button type="button" @click="editQuality"
                                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                            v-if="isKualitasPekerjaanExists">
                                                            Edit
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- Tombol ketiga untuk membuka modal ketiga -->
                                <button @click="toggleModal3" :class="[
                                    'modal-button',
                                    'text-white',
                                    isProblemSolvingExists ? 'bg-blue-700 hover:bg-blue-800' : 'bg-green-700 hover:bg-green-800',
                                    'focus:ring-4',
                                    'focus:outline-none',
                                    isProblemSolvingExists ? 'focus:ring-blue-300' : 'focus:ring-green-300',
                                    'font-medium',
                                    'rounded-lg',
                                    'text-sm',
                                    'px-5',
                                    'py-2.5',
                                    'text-center',
                                    isProblemSolvingExists ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
                                    'flex',
                                    'items-center',
                                    'space-x-2',
                                    'disabled:opacity-50',
                                    'disabled:text-gray-500',
                                    'disabled:bg-gray-300'
                                ]" type="button" :disabled="!isKaryawanSelected">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        :stroke-width="isProblemSolvingExists ? '1.5' : '2'" stroke="currentColor"
                                        class="w-5 h-5">
                                        <path
                                            :d="isProblemSolvingExists ? 'M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z' : 'M12 4v16m8-8H4'"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path :d="isProblemSolvingExists ? 'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' : ''"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>Kemampuan Problem Solving</span>
                                </button>
                            </div>
                        </div>



                        <!-- Main modal -->
                        <div v-if="showModal3" tabindex="-1" aria-hidden="true"
                            class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full inset-0">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeModal"></div>
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Kemampuan Problem Solving
                                        </h1>
                                        <button @click="closeModal" type="button"
                                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5">
                                        <form class="space-y-4" @submit.prevent="submitProblemSolving">
                                            <div class="flex items-center space-x-4 mb-4">
                                                <label for="identifikasi_masalah"
                                                    class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                    Identifikasi Masalah
                                                </label>
                                                <input v-model.number="problem.identifikasi_masalah" type="number"
                                                    name="identifikasi_masalah" id="identifikasi_masalah"
                                                    class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                    required />
                                            </div>

                                            <div class="flex items-center space-x-4 mb-4">
                                                <label for="analisis"
                                                    class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                    Analisis
                                                </label>
                                                <input v-model.number="problem.analisi" type="number" name="analisis"
                                                    id="analisis"
                                                    class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                    required />
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="kreativitas_solusi"
                                                    class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                    Kreativitas Solusi
                                                </label>
                                                <input v-model.number="problem.kreativitas_solusi" type="number"
                                                    name="kreativitas_solusi" id="kreativitas_solusi"
                                                    class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                    required />
                                            </div>


                                            <div class="flex items-center space-x-4 mb-4">
                                                <label for="implementasi_solusi"
                                                    class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                    Implementasi Solusi
                                                </label>
                                                <input v-model.number="problem.implementasi_solusi" type="number"
                                                    name="implementasi_solusi" id="implementasi_solusi"
                                                    class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                    required />
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="evaluasi_solusi"
                                                    class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                    Evaluasi Solusi
                                                </label>
                                                <input v-model.number="problem.evaluasi_solusi" type="number"
                                                    name="evaluasi_solusi" id="evaluasi_solusi"
                                                    class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                    required />
                                            </div>


                                            <div class="flex justify-end">
                                                <button type="submit"
                                                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol keempat untuk membuka modal keempat -->
                        <div class="flex space-x-4 mt-4">
                            <button @click="toggleModal4" :class="[
                                'modal-button',
                                'text-white',
                                isKemampuanBeradaptasiExists ? 'bg-blue-700 hover:bg-blue-800' : 'bg-green-700 hover:bg-green-800',
                                'focus:ring-4',
                                'focus:outline-none',
                                isKemampuanBeradaptasiExists ? 'focus:ring-blue-300' : 'focus:ring-green-300',
                                'font-medium',
                                'rounded-lg',
                                'text-sm',
                                'px-5',
                                'py-2.5',
                                'text-center',
                                isKemampuanBeradaptasiExists ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
                                'flex',
                                'items-center',
                                'space-x-2',
                                'disabled:opacity-50',
                                'disabled:text-gray-500',
                                'disabled:bg-gray-300'
                            ]" type="button" :disabled="!isKaryawanSelected">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    :stroke-width="isKemampuanBeradaptasiExists ? '1.5' : '2'" stroke="currentColor"
                                    class="w-5 h-5">
                                    <path
                                        :d="isKemampuanBeradaptasiExists ? 'M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z' : 'M12 4v16m8-8H4'"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path :d="isKemampuanBeradaptasiExists ? 'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' : ''"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span>Kemampuan Beradaptasi</span>
                            </button>




                            <!-- Main modal -->
                            <div v-if="showModal4" tabindex="-1" aria-hidden="true"
                                class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full inset-0">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeModal"></div>
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Kemampuan Beradaptasi
                                            </h1>
                                            <button @click="closeModal" type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5">
                                            <form class="space-y-4" @submit.prevent="submitAdapt">
                                                <div class="flex items-center space-x-4 mb-4">
                                                    <label for="fleksibilitas"
                                                        class="text-sm font-medium text-gray-900 dark:text-white w-1/2">
                                                        Fleksibilitas
                                                    </label>
                                                    <input v-model.number="adapt.flesibilitas" type="number"
                                                        name="fleksibilitas" id="fleksibilitas"
                                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                        required />
                                                </div>

                                                <div class="flex items-center space-x-4 mb-4">
                                                    <label for="adaptabilitas"
                                                        class="text-sm font-medium text-gray-900 dark:text-white w-1/2">
                                                        Keterbukaan Terhadap Perubahan
                                                    </label>
                                                    <input v-model.number="adapt.adaptabilitas" type="number"
                                                        name="adaptabilitas" id="adaptabilitas"
                                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                        required />
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="mengatasi_hambatan"
                                                        class="text-sm font-medium text-gray-900 dark:text-white w-1/2">
                                                        Kemampuan Mengatasi Hambatan
                                                    </label>
                                                    <input v-model.number="adapt.mengatasi_hambatan" type="number"
                                                        name="mengatasi_hambatan" id="mengatasi_hambatan"
                                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                        required />
                                                </div>


                                                <div class="flex items-center space-x-4 mb-4">
                                                    <label for="pembelajaran_cepat"
                                                        class="text-sm font-medium text-gray-900 dark:text-white w-1/2">
                                                        Pembelajaran Cepat
                                                    </label>
                                                    <input v-model.number="adapt.pembelajaran_cepat" type="number"
                                                        name="pembelajaran_cepat" id="pembelajaran_cepat"
                                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                        required />
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="umpan_balik"
                                                        class="text-sm font-medium text-gray-900 dark:text-white w-1/2">
                                                        Respon Terhadap Umpan Balik
                                                    </label>
                                                    <input v-model.number="adapt.umpan_balik" type="number"
                                                        name="umpan_balik" id="umpan_balik"
                                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                        required />
                                                </div>


                                                <div class="flex justify-end">
                                                    <button type="submit"
                                                        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol kelima untuk membuka modal kelima -->

                            <button @click="toggleModal5" :class="[
                                'modal-button',
                                'text-white',
                                isKerjasamaTimExists ? 'bg-blue-700 hover:bg-blue-800' : 'bg-green-700 hover:bg-green-800',
                                'focus:ring-4',
                                'focus:outline-none',
                                isKerjasamaTimExists ? 'focus:ring-blue-300' : 'focus:ring-green-300',
                                'font-medium',
                                'rounded-lg',
                                'text-sm',
                                'px-5',
                                'py-2.5',
                                'text-center',
                                isKerjasamaTimExists ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
                                'flex',
                                'items-center',
                                'space-x-2',
                                'disabled:opacity-50',
                                'disabled:text-gray-500',
                                'disabled:bg-gray-300'
                            ]" type="button" :disabled="!isKaryawanSelected">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    :stroke-width="isKerjasamaTimExists ? '1.5' : '2'" stroke="currentColor"
                                    class="w-5 h-5">
                                    <path
                                        :d="isKerjasamaTimExists ? 'M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z' : 'M12 4v16m8-8H4'"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path :d="isKerjasamaTimExists ? 'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' : ''"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span>Kerjasama Tim</span>
                            </button>



                            <!-- Main modal -->
                            <div v-if="showModal5" tabindex="-1" aria-hidden="true"
                                class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full inset-0">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeModal"></div>
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Kerjasama Tim
                                            </h1>
                                            <button @click="closeModal" type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5">
                                            <form class="space-y-4" @submit.prevent="submitTeam">
                                                <div class="flex items-center space-x-4 mb-4">
                                                    <label for="komunikasi"
                                                        class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                        Komunikasi
                                                    </label>
                                                    <input v-model.number="team.komunikasi" type="number"
                                                        name="komunikasi" id="komunikasi"
                                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                        required />
                                                </div>

                                                <div class="flex items-center space-x-4 mb-4">
                                                    <label for="kolaborasi"
                                                        class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                        Kolaborasi
                                                    </label>
                                                    <input v-model.number="team.kolaborasi" type="number"
                                                        name="kolaborasi" id="kolaborasi"
                                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                        required />
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="komitmen"
                                                        class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                        Komitmen
                                                    </label>
                                                    <input v-model.number="team.komitmen" type="number" name="komitmen"
                                                        id="komitmen"
                                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                        required />
                                                </div>


                                                <div class="flex items-center space-x-4 mb-4">
                                                    <label for="penyelesaian_konflik"
                                                        class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                        Penyelesaian Konflik
                                                    </label>
                                                    <input v-model.number="team.penyelesaian_konflik" type="number"
                                                        name="penyelesaian_konflik" id="penyelesaian_konflik"
                                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                        required />
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="kontribusi"
                                                        class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                        Kontribusi
                                                    </label>
                                                    <input v-model.number="team.kontribusi" type="number"
                                                        name="kontribusi" id="kontribusi"
                                                        class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                        required />
                                                </div>


                                                <div class="flex justify-end">
                                                    <button type="submit"
                                                        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Tombol keenam untuk membuka modal keenam -->

                            <button @click="toggleModal6" :class="[
                                'modal-button',
                                'text-white',
                                isKepatuhanExists ? 'bg-blue-700 hover:bg-blue-800' : 'bg-green-700 hover:bg-green-800',
                                'focus:ring-4',
                                'focus:outline-none',
                                isKepatuhanExists ? 'focus:ring-blue-300' : 'focus:ring-green-300',
                                'font-medium',
                                'rounded-lg',
                                'text-sm',
                                'px-5',
                                'py-2.5',
                                'text-center',
                                isKepatuhanExists ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
                                'flex',
                                'items-center',
                                'space-x-2',
                                'disabled:opacity-50',
                                'disabled:text-gray-500',
                                'disabled:bg-gray-300'
                            ]" type="button" :disabled="!isKaryawanSelected">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    :stroke-width="isKepatuhanExists ? '1.5' : '2'" stroke="currentColor"
                                    class="w-5 h-5">
                                    <path
                                        :d="isKepatuhanExists ? 'M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z' : 'M12 4v16m8-8H4'"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path :d="isKepatuhanExists ? 'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' : ''"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span>Kepatuhan Terhadap Aturan dan Etika</span>
                            </button>
                        </div>

                        <!-- Main modal -->
                        <div v-if="showModal6" tabindex="-1" aria-hidden="true"
                            class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full inset-0">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeModal"></div>
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Kepatuhan Terhadap Aturan dan Etika
                                        </h1>
                                        <button @click="closeModal" type="button"
                                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5">
                                        <form class="space-y-4" @submit.prevent="submitCompliance">
                                            <div class="flex items-center space-x-4 mb-4">
                                                <label for="patuh_aturan"
                                                    class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                    Kepatuhan Terhadap Aturan
                                                </label>
                                                <input v-model.number="compliance.patuh_aturan" type="number"
                                                    name="patuh_aturan" id="patuh_aturan"
                                                    class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                    required />
                                            </div>

                                            <div class="flex items-center space-x-4 mb-4">
                                                <label for="etika_kerja"
                                                    class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                    Etika Kerja
                                                </label>
                                                <input v-model.number="compliance.etika_kerja" type="number"
                                                    name="etika_kerja" id="etika_kerja"
                                                    class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                    required />
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="integritas"
                                                    class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                    Integritas
                                                </label>
                                                <input v-model.number="compliance.integritas" type="number"
                                                    name="integritas" id="integritas"
                                                    class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                    required />
                                            </div>


                                            <div class="flex items-center space-x-4 mb-4">
                                                <label for="tanggungjawab"
                                                    class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                    Tanggung Jawab
                                                </label>
                                                <input v-model.number="compliance.tanggungjawab" type="number"
                                                    name="tanggungjawab" id="tanggungjawab"
                                                    class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                    required />
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="disiplin"
                                                    class="text-sm font-medium text-gray-900 dark:text-white w-1/3">
                                                    Disiplin
                                                </label>
                                                <input v-model.number="compliance.disiplin" type="number"
                                                    name="disiplin" id="disiplin"
                                                    class="bg-gray-50 border border-gray-300 text-green-900 text-xs rounded-lg focus:ring-green-500 focus:border-green-500 block w-1/4 p-1.5 dark:bg-green-600 dark:border-green-500 dark:placeholder-green-400 dark:text-white"
                                                    required />
                                            </div>


                                            <div class="flex justify-end">
                                                <button type="submit"
                                                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end mt-7">
                            <button type="submit"
                                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                Simpan
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script>
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';
import { ref } from 'vue';

export default {
    components: {
        Multiselect
    },
    data() {
        return {
            selectedKaryawan: null,
            karyawan: [],
            kemampuanTeknis: [],
            isKualitasPekerjaanExists: false,
            kualitasPekerjaan: [],
            technicalSkillsList: [],
            qualityList: [],
            updatedSkill: [],
            updatedQualitySkill: [],
            searchQuery: '',
            showModal: false,
            isEditing: false,
            showModal2: false,
            isNewData: true,
            isEditingQuality: false,
            showModal3: false,
            showModal4: false,
            showModal5: false,
            showModal6: false,
            technicalSkills: {
                pengetahuan: null,
                keterampilan: null,
                pengalaman: null,
                implementasi: null,
                sertifikasi: null,
                bobot_nilai: null,
                kategori_nilai: null,
            },
            quality: {
                pengetahuan: null,
                keterampilan: null,
                pengalaman: null,
                implementasi: null,
                sertifikasi: null,
                bobot_nilai: null,
                kategori_nilai: null,
            },
            problemSolving: {
                identifikasi_masalah: null,
                analisis: null,
                kreativitas_solusi: null,
                implementasi_solusi: null,
                evaluasi_solusi: null,
            },
            adapt: {
                fleksibilitas : null,
                adaptabilitas: null,
                mengatasi_hambatan: null,
                pembelajaran_cepat: null,
                umpan_balik: null,
            },
            teamWork: {
                komunikasi: null,
                kolaborasi: null,
                komitmen:null, 
                penyelesaian_konflik:null,
                kontribusi:null, 
            },
            compliance: {
                patuh_aturan:null,
                etika_kerja:null,
                integritas:null,
                tanggungjawab:null,
                disiplin:null,
            }
        };
    },
    computed: {
        formattedKaryawan() {
            return this.karyawan.map(k => ({
                ...k,
                displayLabel: `${k.nip} - ${k.nama}`
            }));
        },
        unitKerja() {
            return this.selectedKaryawan ? this.selectedKaryawan.unit_kerja : '';
        },
        isKaryawanSelected() {
            return this.selectedKaryawan !== null;
        },
        isKemampuanTeknisExists() {
            return this.kemampuanTeknis !== null && this.kemampuanTeknis.length > 0;
        },
        isKualitasPekerjaanExists() {
            return this.kualitasPekerjaan !== null && this.kualitasPekerjaan.length > 0;
        }
    },
    methods: {
        async fetchKaryawan(search) {
            this.searchQuery = search;
            try {
                const response = await fetch(`/api/karyawan?search=${search}`);
                this.karyawan = await response.json();
            } catch (error) {
                console.error("Error fetching karyawan:", error);
            }
        },
        async checkKemampuanTeknis() {
            try {
                if (this.selectedKaryawan) {
                    const response = await fetch(`/api/get-kemampuan-teknis?search=${this.selectedKaryawan.nip}`);
                    this.kemampuanTeknis = await response.json();
                } else {
                    this.kemampuanTeknis = [];
                }
            } catch (error) {
                console.error("Error fetching kemampuan teknis:", error);
            }
        },
        async submitTechnicalSkills() {
            if (!this.selectedKaryawan) {
                alert('Please select a karyawan.');
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                console.error('CSRF token is missing');
                return;
            }

            try {
                let response;

                if (this.isEditing) {
                    // Update data
                    response = await fetch(`/kemampuan-teknis/${this.selectedKaryawan.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            nip: this.selectedKaryawan.nip,
                            ...this.technicalSkills
                        })
                    });
                } else {
                    // Create data
                    response = await fetch('/kemampuan-teknis', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            nip: this.selectedKaryawan.nip,
                            ...this.technicalSkills
                        })
                    });
                }

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                // Parse the JSON response
                const result = await response.json();

                // Check if technicalSkillsList is defined and update or add
                if (this.technicalSkillsList) {
                    if (this.isEditing) {
                        this.updateTechnicalSkillInList(result);
                    } else {
                        this.addTechnicalSkillToList(result);
                    }
                } else {
                    console.error('technicalSkillsList is not defined');
                }

                // Optionally, refetch the list of kemampuan teknis
                await this.checkKemampuanTeknis();
                await this.fetchKemampuanTeknis();

                this.isEditing = false;

            } catch (error) {
                console.error('Error submitting technical skills:', error);
            }
        },
        updateTechnicalSkillInList(updatedSkill) {
            console.log('technicalSkillsList:', this.technicalSkillsList);
            console.log('updatedSkill:', updatedSkill);

            // Check if technicalSkillsList is an array and updatedSkill has a valid id
            if (Array.isArray(this.technicalSkillsList) && updatedSkill?.id) {
                const index = this.technicalSkillsList.findIndex(skill => skill.id === updatedSkill.id);

                // Update the skill if it's found in the list
                if (index !== -1) {
                    this.$set(this.technicalSkillsList, index, updatedSkill); // Using Vue's reactivity-friendly method
                    console.log('Skill updated successfully');
                } else {
                    console.error('Skill to update not found in the list');
                }
            } else {
                console.error('technicalSkillsList is not an array or updatedSkill does not have a valid id');
            }
        },
        addTechnicalSkillToList(newSkill) {
            // Check if technicalSkillsList is an array
            if (Array.isArray(this.technicalSkillsList)) {
                this.technicalSkillsList.push(newSkill);
            } else {
                console.error('technicalSkillsList is not an array');
            }
        },
        async toggleModal() {
            this.showModal = !this.showModal;
            if (this.selectedKaryawan) {
                await this.fetchKemampuanTeknis();
            }
        },
        async fetchKemampuanTeknis() {
            try {
                const response = await axios.get(`/api/get-kemampuan-teknis?search=${this.selectedKaryawan.nip}`);
                const data = response.data;
                if (data.length > 0) {
                    this.technicalSkills = data[0]; // Assuming data is an array and taking the first item
                } else {
                    // Reset technicalSkills if no data found
                    this.technicalSkills = {
                        pengetahuan: null,
                        keterampilan: null,
                        pengalaman: null,
                        implementasi: null,
                        sertifikasi: null,
                        bobot_nilai: null,
                        kategori_nilai: null
                    };
                }
            } catch (error) {
                console.error("Error fetching kemampuan teknis:", error);
            }
        },
        editTechnicalSkills() {
            this.isEditing = true;
            this.technicalSkills = { ...this.technicalSkills }; // membuat salinan objek technicalSkills
        },
        // toggleModal2() {
        //     this.showModal2 = !this.showModal2;
        // },

        methods: {
            async checkKualitasPekerjaan() {
                try {
                    if (this.selectedKaryawan) {
                        const response = await fetch(`/api/get-kualitas-pekerjaan?search=${this.selectedKaryawan.nip}`);
                        if (response.ok) {
                            this.kualitasPekerjaan = await response.json();
                            // Update status berdasarkan data yang diperoleh
                            this.isKualitasPekerjaanExists = this.kualitasPekerjaan.length > 0;
                        } else {
                            console.error('Error fetching kualitas pekerjaan:', response.statusText);
                        }
                    } else {
                        this.kualitasPekerjaan = [];
                        this.isKualitasPekerjaanExists = false;
                    }
                } catch (error) {
                    console.error("Error fetching kualitas pekerjaan:", error);
                }
            },

            async submitQuality() {
                if (!this.selectedKaryawan) {
                    alert('Please select a karyawan.');
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (!csrfToken) {
                    console.error('CSRF token is missing');
                    return;
                }

                try {
                    let response;

                    // Cek apakah mode menambah data baru atau edit data
                    if (!this.isNewData) {
                        // Update data kualitas pekerjaan (PUT request)
                        response = await fetch(`/kualitas-pekerjaan/${this.selectedKaryawan.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                nip: this.selectedKaryawan.nip,
                                ...this.quality
                            })
                        });
                    } else {
                        // Tambah data kualitas pekerjaan baru (POST request)
                        response = await fetch('/kualitas-pekerjaan', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                nip: this.selectedKaryawan.nip,
                                ...this.quality
                            })
                        });
                    }

                    if (!response.ok) {
                        throw new Error(`Network response was not ok: ${response.statusText}`);
                    }

                    const result = await response.json();

                    if (this.qualityList) {
                        if (!this.isNewData) {
                            this.updateQualityInList(result);
                        } else {
                            this.addQualityToList(result);
                        }
                    } else {
                        console.error('qualityList is not defined');
                    }

                    // Update status kualitas pekerjaan
                    await this.checkKualitasPekerjaan();
                    await this.fetchKualitasPekerjaan();

                    // Setelah submit, ubah status isNewData dan isEditingQuality
                    this.isNewData = false;
                    this.isEditingQuality = false;
                    this.isKualitasPekerjaanExists = true; // Ensure this is set to true

                } catch (error) {
                    console.error('Error submitting kualitas pekerjaan:', error);
                }
            }
        },


        updateQualityInList(updatedQualitySkill) {
            console.log('qualityList:', this.qualityList);
            console.log('updatedQualitySkill:', updatedQualitySkill);


            if (Array.isArray(this.qualityListList) && updatedQualitySkill?.id) {
                const index = this.qualityList.findIndex(skill => skill.id === updatedQualitySkill.id);

                // Update the skill if it's found in the list
                if (index !== -1) {
                    this.$set(this.qualityListList, index, updatedQualitySkill); // Using Vue's reactivity-friendly method
                    console.log('Skill Quality updated successfully');
                } else {
                    console.error('Skill Quality to update not found in the list');
                }
            } else {
                console.error('QualityList is not an array or updatedQualitySkill does not have a valid id');
            }
        },
        addQualityToList(newQuality) {
            // Check if technicalSkillsList is an array
            if (Array.isArray(this.qualityList)) {
                this.qualityList.push(newQuality);
            } else {
                console.error('QualityList is not an array');
            }
        },

        async toggleModal2() {
            this.showModal2 = !this.showModal2;
            if (this.selectedKaryawan) {
                await this.fetchKualitasPekerjaan();
            }
        },
        async fetchKualitasPekerjaan() {
            try {
                const response = await axios.get(`/api/get-kualitas-pekerjaan?search=${this.selectedKaryawan.nip}`);
                const data = response.data;
                if (data.length > 0) {
                    this.quality = data[0]; // Assuming data is an array and taking the first item
                } else {
                    // Reset technicalSkills if no data found
                    this.quality = {
                        pengetahuan: null,
                        keterampilan: null,
                        pengalaman: null,
                        implementasi: null,
                        sertifikasi: null,
                        bobot_nilai: null,
                        kategori_nilai: null,
                    };
                }
            } catch (error) {
                console.error("Error fetching kualitas pekerjaan:", error);
            }
        },
        editQuality() {
            this.isNewData = false;
            this.isEditingQuality = true;
            this.quality = { ...this.quality };
        },
        toggleModal3() {
            this.showModal3 = !this.showModal3;
        },
        toggleModal4() {
            this.showModal4 = !this.showModal4;
        },
        toggleModal5() {
            this.showModal5 = !this.showModal5;
        },
        toggleModal6() {
            this.showModal6 = !this.showModal6;
        },
        closeModal() {
            this.showModal = false;
            this.showModal2 = false;
            this.showModal3 = false;
            this.showModal4 = false;
            this.showModal5 = false;
            this.showModal6 = false;
        },
        handleSubmit2() {
            console.log('Form submitted');
            this.closeModal();
        },
        handleSubmit3() {
            console.log('Form submitted');
            this.closeModal();
        },
        handleSubmit4() {
            console.log('Form submitted');
            this.closeModal();
        },
        handleSubmit5() {
            console.log('Form submitted');
            this.closeModal();
        },
        handleSubmit6() {
            console.log('Form submitted');
            this.closeModal();
        }
    },
    mounted() {
        this.fetchKaryawan('');
    },
    watch: {
        selectedKaryawan(newVal) {
            if (newVal) {
                this.checkKemampuanTeknis();
            }
        }
    }
};
</script>