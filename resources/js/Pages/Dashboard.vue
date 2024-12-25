<script setup>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import {
        Head,
        Link
    } from "@inertiajs/vue3";
    import DoubleRightArrow from "@/Components/DoubleRightArrow.vue";
    import MapIcon from "@/Components/MapIcon.vue";
    import PlaceIcon from "@/Components/PlaceIcon.vue";
    import BankIcon from "@/Components/BankIcon.vue";
    import CarIcon from "@/Components/CarIcon.vue";
    import CarIcon2 from "@/Components/CarIcon2.vue";
    import CurrencyIcon from "@/Components/CurrencyIcon.vue";
    import BuildingIcon from "@/Components/BuildingIcon.vue";
    import ClientIcon from "@/Components/ClientIcon.vue";
    import FolderIcon from "@/Components/FolderIcon.vue";
    import EuIcon from "@/Components/EuIcon.vue";
import CategoriesIcon from "@/Components/CategoriesIcon.vue";
import DeclarationsIcon from "@/Components/DeclarationsIcon.vue";

    const props = defineProps({
        clientsCount: Number,
        totalDocs: Number,
        packingListCount: Number,
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
                                class="flex justify-around items-center bg-gray-50 w-full lg:w-[350px] p-4 shadow-md rounded-md hover:border-cyan-500 border-2 hover:bg-gray-800 hover:text-gray-50 hover:shadow-xl">
                            <ClientIcon></ClientIcon>
                            <h2 class="text-center">
                                Вкупно {{ props . clientsCount }} Клиенти
                            </h2>
                            <DoubleRightArrow></DoubleRightArrow>
                            </Link>

                            <!-- Dokumenti -->
                            <Link :href="route('document.index')"
                                class="flex justify-around items-center bg-gray-50 w-full lg:w-[350px] p-4 shadow-md rounded-md hover:border-cyan-500 border-2 hover:bg-gray-800 hover:text-gray-50 hover:shadow-xl">
                            <FolderIcon></FolderIcon>
                            <div>
                                <h2 class="text-center">
                                    Вкупно {{ props . totalDocs }} Документи
                                </h2>
                                <p class="text-center text-xs text-gray-400">
                                    Од кои
                                    {{ props . packingListCount }} Пакинг
                                    Листи
                                </p>
                            </div>
                            <DoubleRightArrow></DoubleRightArrow>
                            </Link>
                        </div>
                        <!--Admin Panel-->
                        <div class="mt-10 grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
                            <!-- Drzavi-->
                            <div
                                class="bg-gray-50 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link :href="route('country.index')" class="flex flex-col items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <MapIcon class="text-gray-700"></MapIcon>
                                    <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                        <h3 class="text-center">Држави</h3>
                                    </div>
                                </div>
                                </Link>
                            </div>
                            <!-- Gradovi-->
                            <div
                                class="bg-gray-50 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link :href="route('place.index')" class="flex flex-col items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <PlaceIcon class="text-gray-700"></PlaceIcon>
                                    <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                        <h3 class="text-center">Градови</h3>
                                    </div>
                                </div>
                                </Link>
                            </div>

                            <!-- Banki-->
                            <div
                                class="bg-gray-50 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link :href="route('banks.index')" class="flex flex-col items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <BankIcon class="text-gray-700"></BankIcon>
                                    <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                        <h3 class="text-center">Банки</h3>
                                    </div>
                                </div>
                                </Link>
                            </div>

                            <!-- Vozila-->
                            <div
                                class="bg-gray-50 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link :href="route('vehicles.index')" class="flex flex-col items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <CarIcon class="text-gray-700"></CarIcon>
                                    <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                        <h3 class="text-center">Возила</h3>
                                    </div>
                                </div>
                                </Link>
                            </div>

                            <!-- Valuti-->
                            <div
                                class="bg-gray-50 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link :href="route('currency.index')" class="flex flex-col items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <CurrencyIcon class="text-gray-700"></CurrencyIcon>
                                    <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                        <h3 class="text-center">Валути</h3>
                                    </div>
                                </div>
                                </Link>
                            </div>

                            <!-- Firma-->
                            <div
                                class="bg-gray-50 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link :href="route('companies.notcustomer.index')"
                                    class="flex flex-col items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <BuildingIcon class="text-gray-700"></BuildingIcon>
                                    <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                        <h3 class="text-center">Фирма</h3>
                                    </div>
                                </div>
                                </Link>
                            </div>
                            <!-- ЕУ Регулативи-->
                            <div
                                class="bg-gray-50 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link :href="route('regulations.index')"
                                    class="flex flex-col items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <EuIcon class="text-gray-700"></EuIcon>
                                    <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                        <h3 class="text-center">
                                            ЕУ Регулативи
                                        </h3>
                                    </div>
                                </div>
                                </Link>
                            </div>
                            <!-- ЕУ Directivi-->
                            <div
                                class="bg-gray-50 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link :href="route('directivesAll.index')"
                                    class="flex flex-col items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <EuIcon class="text-gray-700"></EuIcon>
                                    <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                        <h3 class="text-center">
                                            ЕУ Директиви
                                        </h3>
                                    </div>
                                </div>
                                </Link>
                            </div>

                            <!-- ЕУ Directivi. regulativi i Kategorii konekcii-->
                            <div
                                class="bg-gray-50 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link :href="route('directives.index')"
                                    class="flex flex-col items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <CategoriesIcon class="text-gray-700"></CategoriesIcon>
                                    <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                        <h3 class="text-center">
                                            ЕУ Директиви  Регулативи Поврзување
                                        </h3>
                                    </div>
                                </div>
                                </Link>
                            </div>
                            <!-- Declaracii-->
                            <div
                                class="bg-gray-50 shadow-md py-4 hover:border-sky-500 border-2 rounded-lg transition duration-200 ease-in-out hover:scale-105 hover:rotate-[3deg]">
                                <Link :href="route('declarations.index')"
                                    class="flex flex-col items-center justify-center">
                                <div class="flex flex-col items-center justify-center">
                                    <DeclarationsIcon class="text-gray-700"></DeclarationsIcon>
                                    <div class="bg-gray-50 rounded text-gray-500 px-4 py-2 font-semibold">
                                        <h3 class="text-center">
                                            Изјави за Потекло на Роба
                                        </h3>
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
