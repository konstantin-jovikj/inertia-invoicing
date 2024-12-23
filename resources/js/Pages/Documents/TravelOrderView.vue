<script setup>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import {
        Head,
        usePage
    } from "@inertiajs/vue3";
    import {
        computed,
        ref
    } from "vue";
    import {
        latinToCyrillic
    } from "@/helpers/latinToCyrillic";
    import PrintIcon from "@/Components/PrintIcon.vue";
    import { Tippy } from "vue-tippy";


    const props = defineProps({
        document: Object,
        owner: Object,
        client: Object,
    });

    // Helper function to format dates
    const formatDate = (date) => {
        if (!date) return "Непознато"; // Handle null or undefined dates
        const d = new Date(date);
        const day = String(d.getDate()).padStart(2, "0");
        const month = String(d.getMonth() + 1).padStart(2, "0"); // Months are 0-based
        const year = d.getFullYear();
        return `${day}.${month}.${year}`; // Format as dd.mm.YYYY
    };
</script>

<template>

    <Head title="Travel Order" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto w-1/2 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex justify-around align-middle items-center">

                        <div class="p-6 text-gray-900">
                            <p>Патен Налог Бр: <span class="font-bold">{{ props . document . document_no }}</span></p>
                        </div>
                        <div>
                            <a 
                                    class="px-4 hover:text-sky-600 text-slate-300"
                                    :href="`/travelorder/print/${props.document.id}`"
                                    target="_blank"
                                >
                                    <PrintIcon
                                        v-tippy="{
                                            content: `Принтај Патен Налог`,
                                            arrow: true,
                                            theme: 'light',
                                        }"
                                    />
                                </a>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900">
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Купувач: </span>
                            <span class="font-bold">
                                {{ props . document . company . name }} -
                                {{ props . client . place . place }} -
                                {{ props . client . place . country . name }}
                            </span>
                        </p>
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Продавач: </span>
                            <span class="font-bold">
                                {{ props . owner . name }} -
                                {{ props . owner . place . place }} -
                                {{ props . owner . place . country . name }}
                            </span>
                        </p>
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Превозник: </span>
                            <span class="font-bold">
                                {{ props . owner . name }} -
                                {{ props . owner . place . place }} -
                                {{ props . owner . place . country . name }}
                            </span>
                        </p>
                    </div>
                    <div class="px-6 text-gray-900">
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Рег. Број на Возило: </span>
                            <span class="font-bold">{{ props . document . vehicle . register_plate_number }}</span>
                        </p>
                    </div>
                    <div class="p-6 text-gray-900">
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Место на Утовар: </span>
                            <span class="font-bold">{{ props . document . load_place . place }}</span>
                        </p>
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Дата на Утовар: </span>
                            <span class="font-bold">{{ formatDate(props . document . load_date) }}</span>
                        </p>
                    </div>
                    <div class="p-6 text-gray-900">
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Место на Истовар: </span>
                            <span class="font-bold">{{ props . document . unload_place . place }}</span>
                        </p>
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Дата на Истовар: </span>
                            <span class="font-bold">{{ formatDate(props . document . unload_date) }}</span>
                        </p>
                    </div>
                    <div class="p-6 text-gray-900">
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Ознака / Број: </span>
                            <span class="font-bold">{{ props . document . marking }}</span>
                        </p>
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Број на Пакети: </span>
                            <span class="font-bold">{{ props . document . boxes_nr }}</span>
                        </p>
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Вид на Амбалажа: </span>
                            <span class="font-bold">{{ props . document . packaging_type }}</span>
                        </p>
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Вид на Стока: </span>
                            <span class="font-bold">{{ props . document . goods_type }}</span>
                        </p>
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Бруто тежина: </span>
                            <span class="font-bold">{{ props . document . total_weight }}</span>
                        </p>
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Зафатнина m<sup>3</sup>: </span>
                            <span class="font-bold">{{ props . document . total_volume }}</span>
                        </p>
                    </div>

                    <div class="p-6 text-gray-900">
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Забелешки и ограничувања на Превозникот: </span>
                            <span class="font-bold">{{ props . document . note }}</span>
                        </p>
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Дополнителни инструкции при превоз на стоката: </span>
                            <span class="font-bold">{{ props . document . instruction }}</span>
                        </p>
     
                    </div>
                    <div class="p-6 text-gray-900">
                        <p class="text-sm">
                            <span class="text-xs italic text-gray-500">Робата за Презема: </span>
                            <span class="font-bold">{{ props . document . picked_up_by }}</span>
                        </p>
     
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
