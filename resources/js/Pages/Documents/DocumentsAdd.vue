<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps({
    documentType: Object,
    ownerCompanies: Array,
    clientCompanies: Array,
    authUser: Object,
});

console.log(props.documentType);

const form = useForm({
    user_id: props.authUser.id,
    is_for_export: false,
    owner_id: "",
    client_id: "",
});

const submit = () => {
    console.log(form);
};
</script>

<template>
    <Head title="Taxes" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form
                            @submit.prevent="
                                form.post('/documents/store', {
                                    onError: () => form.reset(),
                                })
                            "
                        >
                            <div
                                class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8"
                            >
                                <div
                                    class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-2"
                                >
                                    <div class="text-gray-600">
                                        <p class="text-lg font-medium">
                                            Додај Нова
                                            {{ props.documentType.type }}
                                        </p>
                                        <p>
                                            Внеси податоци за новата
                                            {{ props.documentType.type }}
                                        </p>
                                    </div>
                                    <div class="lg:col-span-2">
                                        <hr/>
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                        >
                                            <!-- Is For Export -->
                                            <div class="py-4 mb-4 border-b border-gray-200 md:col-span-6">
                                                <InputLabel
                                                    for="doc_is_for_export"
                                                    >Дали е за
                                                    Извоз?</InputLabel
                                                >

                                                <input
                                                    type="checkbox"
                                                    v-model="form.is_for_export"
                                                    id="doc_is_for_export"
                                                    class="w-8 h-8 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors
                                                            .is_for_export
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Firma Domakin -->
                                            <div class="md:col-span-3">
                                                <InputLabel for="owner"
                                                    >Одбери фирма</InputLabel
                                                >
                                                <select
                                                    v-model="form.owner_id"
                                                    id="owner"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Избери фирма...
                                                    </option>
                                                    <option
                                                        v-for="ownerCompany in ownerCompanies"
                                                        :key="ownerCompany.id"
                                                        :value="ownerCompany.id"
                                                    >
                                                        {{ ownerCompany.name }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.name
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Firma Klient -->
                                            <div class="md:col-span-3">
                                                <InputLabel for="client"
                                                    >Одбери Клиент</InputLabel
                                                >
                                                <select
                                                    v-model="form.client_id"
                                                    id="client"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Одбери Клиент ...
                                                    </option>
                                                    <option
                                                        v-for="clientCompany in clientCompanies"
                                                        :key="clientCompany.id"
                                                        :value="
                                                            clientCompany.id
                                                        "
                                                    >
                                                        {{ clientCompany.name }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.name
                                                    }}</span
                                                >
                                            </div>

                                            <div
                                                class="text-right md:col-span-5"
                                            >
                                                <div
                                                    class="inline-flex items-end"
                                                >
                                                    <button
                                                        type="submit"
                                                        class="px-4 py-2 font-bold text-white rounded bg-sky-500 hover:bg-sky-700"
                                                    >
                                                        Додај
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
