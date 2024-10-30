<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";

import { computed, ref, watch, onMounted } from "vue";

const props = defineProps({
    company: Object,
    searchTerm: String,
});

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
                                <h2 class="text-xl font-bold">
                                    {{ company.name }}
                                </h2>
                                <p>
                                    {{ company.place.zip }}-{{
                                        company.place.place
                                    }}
                                </p>
                                <p>{{ company.place.country.name }}</p>
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
