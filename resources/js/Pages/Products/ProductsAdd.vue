<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ModalLink } from '@inertiaui/modal-vue'

// import {Modal, ModalLink } from "@/Components/ModalLink.vue";

const props = defineProps({
    document: Object,
    products: Array,
});

const form = useForm({
    document_id: props.document.id,
    description: "",
    qty: "",
    single_price: "",
    total_price: "",
});

const state = reactive({
    products: [...props.products],
});

const addRow = async () => {
    const newRow = {
        document_id: props.document.id,
        id: null,
        description: "",
        qty: "",
        single_price: "",
        total_price: "",
    };
    state.products.push(newRow);

    try {
        // Use router.post instead of Inertia.post with async/await
        const response = await router.post("/products/store", newRow);

        // After creating, update the row with the new ID from the response
        if (response && response.data) {
            newRow.id = response.data.id;
        }
    } catch (error) {
        console.error("Error adding row:", error);
    }
};

const loading = ref(false);

const saveCell = (row, field, value) => {
    row[field] = value; // Update local data immediately for UX

    // Send updated data to the backend using Inertia
    router.put(`/products/update/${row.id}`, {
        [field]: value,
    });
};
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div
                            class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8"
                        >
                            <div class="grid grid-cols-1 gap-4 text-sm gap-y-2">
                                <div class="text-gray-600">
                                    <p class="text-lg font-medium">
                                        {{ props.document.document_type.type }}
                                    </p>
                                    <span> Бр: </span>
                                    <span>{{
                                        props.document.document_no
                                    }}</span>
                                    <hr class="py-4" />
                                    <span class="text-xs italic">Клиент: </span>
                                    <span class="text-sm font-semibold">
                                        {{ props.document.company.name }}
                                    </span>
                                    <p>Total: {{ props.document.total }}</p>
                                </div>

                                <div class="lg:col-span-2">
                                    <hr class="my-4" />
                                    <div
                                        class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                    >
                                        <div class="md:col-span-6">
                                            <p>Produkti</p>
                                            <!-- <button class="px-4 py-2 my-2 bg-green-500" @click="addRow">
                                                Add Empty Row
                                            </button> -->
                                            <table
                                                class="min-w-full text-sm font-light text-center border-collapse text-surface border-e"
                                            >
                                                <thead
                                                    class="font-medium border-b border-neutral-200"
                                                >
                                                    <tr>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Id
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Opis
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Kol
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Cena
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Vk.Cena
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        class="border-b border-neutral-200 border-e"
                                                        v-for="(
                                                            product, index
                                                        ) in products"
                                                        :key="
                                                            product.id || index
                                                        "
                                                    >
                                                        <td
                                                            class="px-2 py-1 text-left whitespace-nowrap border-e"
                                                        >
                                                            {{ product.id }}
                                                        </td>
                                                        <td
                                                            class="px-2 py-1 text-left whitespace-nowrap border-e"
                                                        >
                                                            {{
                                                                product.description
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-2 py-1 text-left whitespace-nowrap border-e"
                                                        >
                                                            {{ product.qty }}
                                                        </td>
                                                        <td
                                                            class="px-2 py-1 text-right whitespace-nowrap border-e"
                                                        >
                                                            {{
                                                                product.single_price
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-2 py-1 text-right whitespace-nowrap border-e"
                                                        >
                                                            {{
                                                                product.total_price
                                                            }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div>
                                            <ModalLink
                                                :href="`/products/add/modal/${props.document.id}`"
                                                class="px-4 py-2 text-white bg-gray-900 rounded-md"
                                            >
                                                Додај Производ
                                            </ModalLink>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
