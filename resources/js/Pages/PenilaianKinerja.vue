<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

const props = defineProps({
    sheets: Array
});

const isModalOpen = ref(false);
const selectedSheet = ref({});

function showDetail(sheet) {
    selectedSheet.value = sheet;
    isModalOpen.value = true;
}

function closeModal() {
    isModalOpen.value = false;
}
const deleteEvent = (id) => {
    if (confirm("Are you sure you want to move this to trash?")) {
        Inertia.delete(route("daily-sheet.delete", { sheet: id }), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                console.log('Item moved to trash successfully');
            },
            onError: (errors) => {
                console.error('Error moving item to trash:', errors);
            },
        });
    }
};
</script>

<template>

    <Head title="Table Form Daily Sheet" />
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

        <section class="p-3 bg-gray-100 sm:p-5">
            <div class="max-w-screen-xl px-4 mx-auto lg:px-12">
                <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                    <div
                        class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                        <div
                            class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                            <button @click="$inertia.visit(route('form'))"
                                class="flex items-center px-4 py-2 mx-1 text-sm font-medium bg-green-600 text-white rounded-lg justify-right bg-navbar bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                Tambah Nilai
                                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                            </button>
                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                                class="flex items-center px-4 py-2 mx-1 text-sm font-medium bg-green-600 text-white rounded-lg justify-right bg-navbar bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
                                type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                    class="w-4 h-4 mr-2 text-white" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Filter
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            
                        </div>
                    </div>
                    <div class="mx-5 mb-5 overflow-x-auto bg-green-600 rounded-xl">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-white uppercase bg-navbar">
                                <tr>
                                    <th scope="col" class="px-4 py-4">Nama</th>
                                    <th scope="col" class="px-4 py-3">Divisi</th>
                                    <th scope="col" class="px-4 py-3">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="sheet in sheets" :key="sheet.id" class="border-b">
                                    <th scope="row" class="px-4 py-3 font-medium ">
                                        {{ sheet.id }}</th>
                                    <td class="px-4 py-3">{{ sheet.name }}</td>
                                    
                                    <td class="px-4 py-3">
                                        <div class="relative inline-block text-left">
                                            <button id="dropdownDefaultButton" @click="toggleDropdown(sheet.id)"
                                                class="focus:outline-none p-2.5 text-center inline-flex items-center"
                                                type="button">
                                                <svg class="w-6 h-6" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <circle cx="5" cy="12" r="2" fill="green" />
                                                    <circle cx="12" cy="12" r="2" fill="green" />
                                                    <circle cx="19" cy="12" r="2" fill="green" />
                                                </svg>
                                            </button>
                                            <div v-if="isOpenDropdown(sheet.id)"
                                                class="absolute right-0 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 bg-navbar">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                                    <li>
                                                        <button @click="showDetail(sheet)"
                                                            class="block w-full px-4 py-2 text-left hover:bg-green-100 dark:hover:bg-green-600 dark:hover:text-white">Detail</button>
                                                    </li>
                                                    <li>
                                                        <button @click="deleteEvent(sheet.id)"
                                                            class="block w-full px-4 py-2 text-left text-red-500 hover:bg-gray-100 dark:hover:bg-red-600 dark:hover:text-white">Delete</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal -->
        <transition name="fade" @after-leave="closeModal">
            <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
                    <h2 class="mb-4 text-xl font-bold">Detail Lembar Kerja Harian</h2>
                    <div class="mb-4">
                        <strong>Nama:</strong> {{ selectedSheet.name }}
                    </div>
                    <div class="mb-4">
                        <strong>Divisi:</strong>
                        <span v-if="selectedSheet.division === 'sec'"> Sekretaris</span>
                        <span v-if="selectedSheet.division === 'keg'"> Kepegawaian, Umum & Kehumasan</span>
                        <span v-if="selectedSheet.division === 'kua'">Keuangan & Aset</span>
                        <span v-if="selectedSheet.division === 'pen'">Perencanaan & Pelaporan</span>
                        <span v-if="selectedSheet.division === 'pda'">Perekonomian & Sumber Daya Alam</span>
                        <span v-if="selectedSheet.division === 'ink'">Insfrastruktur & Kewilayahan</span>
                        <span v-if="selectedSheet.division === 'ppm'">Pemerintahan & Pembangunan Manusia</span>
                        <span v-if="selectedSheet.division === 'pde'">Perencanaan,
                            Pengendalian &
                            Evaluasi Pembangunan Daerah</span>
                    </div>
                    <div class="mb-4">
                        <strong>Bobot Nilai:</strong> {{ selectedSheet.start_time }} - {{ selectedSheet.stop_time }}
                    </div>
                    <div class="mb-4">
                        <strong>Kategori Nilai:</strong> {{ selectedSheet.entry_date }}
                    </div>
                    <div class="mb-4">
                        <strong>Kemampuan Teknis:</strong> {{ selectedSheet.kemampuan_teknis }}
                    </div>
                    <div class="mb-4">
                        <strong>Kualitas Pekerjaan:</strong> {{ selectedSheet.kualitas_pekerjaan }}
                    </div>
                    <div class="mb-4">
                        <strong>Kemampuan Problem Solving:</strong> {{ selectedSheet.kemampuan_problem_solving }} - {{ selectedSheet.stop_time }}
                    </div>
                    <div class="mb-4">
                        <strong>Kemampuan Beradaptasi:</strong> {{ selectedSheet.kemampuan_berdaptasi }}
                    </div>
                    <div class="mb-4">
                        <strong>Kerjasama Tim</strong> {{ selectedSheet.kerjasama_tim }}
                    </div>
                    <div class="mb-4">
                        <strong>Kepatuhan Terhadap Aturan dan Etika:</strong> {{ selectedSheet.aturan_etika }}
                    </div>

                    <button @click="isModalOpen = false"
                        class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none">
                        Close
                    </button>
                </div>
            </div>
        </transition>
    </AuthenticatedLayout>

</template>


<script>
export default {
    props: {
        sheet: Object,
        csrfToken: String
    },
    data() {
        return {
            activeDropdownId: null,
        };
    },
    methods: {
        toggleDropdown(id) {
            this.activeDropdownId = this.activeDropdownId === id ? null : id;
        },
        isOpenDropdown(id) {
            return this.activeDropdownId === id;
        },
    },
}
</script>
