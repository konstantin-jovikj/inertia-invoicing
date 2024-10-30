<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";

import { computed, ref, watch, onMounted } from "vue";

const props = defineProps({
    company: Object,
    searchTerm: String,
});

const companyContacts = props.company.contacts;
console.log("Company Contacts:", companyContacts);

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");
</script>

<template>
    <Head title="Companies" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <!-- message -->
                <div
                    v-if="flashMessage"
                    class="px-4 py-2 rounded-md bg-sky-200"
                >
                    {{ flashMessage }}
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between mb-4">
                            <h2 class="px-6 text-sky-800">
                                Детални информации
                            </h2>
                        </div>

                        <div class="flex flex-col gap-2 lg:flex-row">
                            <div
                                class="w-full p-4 border border-blue-500 rounded md:w-50"
                            >
                                <div>
                                    <h2 class="text-xl font-bold">
                                        {{ company.name }}
                                    </h2>
                                    <p>{{ company.address }}</p>
                                    <p>
                                        {{ company.place.zip }}-{{
                                            company.place.place
                                        }}
                                    </p>
                                    <p>{{ company.place.country.name }}</p>
                                </div>
                                <hr class="my-4" />
                                <h2
                                    class="px-6 py-2 mb-4 text-lg font-bolder bg-slate-100"
                                >
                                    Контакти
                                </h2>
                                <div class="px-6">
                                    <!-- <hr class="my-4" /> -->
                                    <ul class="list-disc">
                                        <p class="text-red-500" v-if="companyContacts.length === 0">
                                            Не се пронајдени контакти.
                                        </p>
                                        <li
                                            class="mb-6"
                                            v-for="contact in companyContacts"
                                            :key="contact.id"
                                        >
                                            <span
                                                class="font-bold "
                                                >{{ contact.first_name }}
                                                {{ contact.last_name }}</span
                                            >

                                            <span> - </span>
                                            <span class="text-teal-800">{{ contact.position }}</span>
                                            <p>
                                                <span class="text-xs italic">емаил: </span><a
                                                :href="`mailto:${contact.email}`"
                                                ><span class="text-sky-600">{{ contact.email }}</span></a
                                            >
                                            </p>

                                            <p>
                                                <span class="text-xs italic">телефон: </span>{{ contact.phone }}
                                            </p>
                                            <p>
                                                <span class="text-xs italic">мобилен: </span>
                                                {{ contact.mob }}
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div
                                class="w-full p-4 border border-blue-500 rounded md:w-50"
                            >
                                <h2>Листа на документи</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
