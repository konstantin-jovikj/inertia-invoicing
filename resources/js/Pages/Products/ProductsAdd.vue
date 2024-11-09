<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { reactive } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

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
                            <div
                                class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3"
                            >
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
                                    <div
                                        class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                    >
                                        <div class="md:col-span-6">
                                            <p>Produkti</p>
                                            <button
                                                class="px-4 py-2 my-2 bg-green-500"
                                                @click="addRow"
                                            >
                                                Add Empty Row
                                            </button>
                                            <table
                                                class="w-full border border-separate border-slate-400"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="border border-slate-300 ..."
                                                        >
                                                            Opis
                                                        </th>
                                                        <th
                                                            class="border border-slate-300 ..."
                                                        >
                                                            Kol
                                                        </th>
                                                        <th
                                                            class="border border-slate-300 ..."
                                                        >
                                                            Cena
                                                        </th>
                                                        <th
                                                            class="border border-slate-300 ..."
                                                        >
                                                            Vk.Cena
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="(
                                                            product, index
                                                        ) in products"
                                                        :key="
                                                            product.id || index
                                                        "
                                                    >
                                                        <!-- <tr
                                                        v-for="product in products"
                                                        :key="product.id"
                                                    > -->
                                                        <td>
                                                            {{
                                                                product.description
                                                            }}
                                                        </td>
                                                        <td
                                                            class="py-2 border border-slate-300"
                                                        >
                                                            {{ product.qty }}
                                                        </td>
                                                        <td
                                                            class="py-2 border border-slate-300"
                                                        >
                                                            {{
                                                                product.single_price
                                                            }}
                                                        </td>
                                                        <td
                                                            class="py-2 border border-slate-300"
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
                                            <form
                                                @submit.prevent="
                                                    form.post(
                                                        '/products/store',
                                                        {
                                                            onSuccess: () => {
                                                                form.reset();
                                                            },
                                                            onError: () =>
                                                                form.reset(),
                                                        }
                                                    )
                                                "
                                            >
                                                <label for=""
                                                    >Description</label
                                                >
                                                <input
                                                    v-model="form.description"
                                                    type="text"
                                                />

                                                <label for="">Q-ty</label>
                                                <input
                                                    v-model="form.qty"
                                                    type="number"
                                                />

                                                <label for="">Price</label>
                                                <input
                                                    v-model="form.single_price"
                                                    type="number"
                                                />

                                                <button type="submit">
                                                    Add
                                                </button>
                                            </form>
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
