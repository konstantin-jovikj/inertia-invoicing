<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {
        Head,
        Link
    } from '@inertiajs/vue3';
    import DoubleRightArrow from '@/Components/DoubleRightArrow.vue';
    import MapIcon from '@/Components/MapIcon.vue';
    import PlaceIcon from '@/Components/PlaceIcon.vue';
    import BankIcon from '@/Components/BankIcon.vue';
    import CarIcon from '@/Components/CarIcon.vue';
    import CarIcon2 from '@/Components/CarIcon2.vue';
    import CurrencyIcon from '@/Components/CurrencyIcon.vue';
    import BuildingIcon from '@/Components/BuildingIcon.vue';

    const props = defineProps({
        clientsCount: Object,
        documentsCount: Object,
    });
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>


        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div class="flex flex-col gap-4 lg:flex-row">
                            <!-- KLlienti -->
                            <Link :href="route('companies.index')"
                                class="flex justify-around bg-gray-50 w-full lg:w-[250px] p-4 shadow-md rounded-md hover:border-cyan-500 border-2 hover:bg-gray-800 hover:text-gray-50 hover:shadow-xl">
                            <h2 class="text-center">Вкупно {{ props . clientsCount }} Клиенти</h2>
                            <DoubleRightArrow></DoubleRightArrow>
                            </Link>

                            <!-- Dokumenti -->
                            <Link :href="route('document.index')"
                                class="flex justify-around bg-gray-50 w-full lg:w-[250px] p-4 shadow-md rounded-md hover:border-cyan-500 border-2 hover:bg-gray-800 hover:text-gray-50 hover:shadow-xl">
                            <h2 class="text-center">Вкупно {{ props . documentsCount }} Документи</h2>
                            <DoubleRightArrow></DoubleRightArrow>
                            </Link>

                        </div >
                        <!--Admin Panel-->
                        <div class="mt-10 flex flex-col md:flex-row gap-4">
                            <!-- Drzavi-->
                            <div class="bg-gray-50 w-full md:w-3/12 lg:w-2/12 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link  class="flex flex-col items-center justify-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <MapIcon class="text-gray-700"></MapIcon>
                                        <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                            <h3 class="text-center">Држави</h3>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                             <!-- Gradovi-->
                             <div class="bg-gray-50 w-full md:w-3/12 lg:w-2/12 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link  class="flex flex-col items-center justify-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <PlaceIcon class="text-gray-700"></PlaceIcon>
                                        <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                            <h3 class="text-center">Градови</h3>
                                        </div>
                                    </div>
                                </Link>
                            </div>

                             <!-- Banki-->
                             <div class="bg-gray-50 w-full md:w-3/12 lg:w-2/12 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link  class="flex flex-col items-center justify-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <BankIcon class="text-gray-700"></BankIcon>
                                        <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                            <h3 class="text-center">Банки</h3>
                                        </div>
                                    </div>
                                </Link>
                            </div>

                            <!-- Vozila-->
                            <div class="bg-gray-50 w-full md:w-3/12 lg:w-2/12 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link  class="flex flex-col items-center justify-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <CarIcon class="text-gray-700"></CarIcon>
                                        <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                            <h3 class="text-center">Возила</h3>
                                        </div>
                                    </div>
                                </Link>
                            </div>


                             <!-- Valuti-->
                             <div class="bg-gray-50 w-full md:w-3/12 lg:w-2/12 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link  class="flex flex-col items-center justify-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <CurrencyIcon class="text-gray-700"></CurrencyIcon>
                                        <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                            <h3 class="text-center">Валути</h3>
                                        </div>
                                    </div>
                                </Link>
                            </div>

                            <!-- Firma-->
                            <div class="bg-gray-50 w-full md:w-3/12 lg:w-2/12 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link  class="flex flex-col items-center justify-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <BuildingIcon class="text-gray-700"></BuildingIcon>
                                        <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                            <h3 class="text-center">Фирма</h3>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
