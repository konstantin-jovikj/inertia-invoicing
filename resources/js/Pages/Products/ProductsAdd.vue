<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ModalLink } from "@inertiaui/modal-vue";
import DeleteIcon from "@/Components/DeleteIcon.vue";
import AddContactIcon from "@/Components/AddContactIcon.vue";
import AddRowIcon from "@/Components/AddRowIcon.vue";
import EditIcon from "@/Components/EditIcon.vue";

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
    // products: props.products.map(product => ({ ...product, _isNew: false })),
    document: [...props.products],
});

// Delete Product function
const deleteProduct = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш овој Производ")) {
        router.delete("/products/delete/" + id, {
            preserveState: false,
            onSuccess: () => {
                flashMessage.value = props.flash.message;
            },
        });
    }
};

// onMounted(() => {
//     if (flashMessage.value) {
//         setTimeout(() => {
//             flashMessage.value = "";
//         }, 3000);
//     }
// });

// const loading = ref(false);
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
                            <!-- Izmeni Dokument -->
                            <div>
                                <ModalLink
                                    class="hover:text-green-600 text-slate-300"
                                    :href="
                                        route(
                                            'document.edit',
                                            props.document.id,
                                        )
                                    "
                                >
                                    <EditIcon
                                        v-tippy="{
                                            content: `Измени ${props.document.document_type.type}`,
                                            arrow: true,
                                            theme: 'light',
                                        }"
                                    />
                                </ModalLink>
                            </div>
                            <!-- Izmeni Dokument end-->
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
                                    <p>
                                        Total:
                                        {{
                                            new Intl.NumberFormat("en-US", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2,
                                            }).format(props.document.total)
                                        }}
                                        <!-- <span>{{
                                            props.document.curency.symbol
                                        }}</span> -->
                                    </p>
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
                                                            class="px-2 py-1 text-gray-400"
                                                        >
                                                            Id
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Бр
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Опис
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Кол
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Цена
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Вк.Цена
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="px-2 py-1"
                                                        >
                                                            Акција
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
                                                            class="px-1 py-1 text-xs text-left text-gray-300 bg-gray-100 whitespace-nowrap border-e"
                                                        >
                                                            {{ product.id }}
                                                        </td>

                                                        <td
                                                            class="px-2 py-1 text-left whitespace-nowrap border-e"
                                                        >
                                                            {{ index + 1 }}
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
                                                                new Intl.NumberFormat(
                                                                    "en-US",
                                                                    {
                                                                        minimumFractionDigits: 2,
                                                                        maximumFractionDigits: 2,
                                                                    },
                                                                ).format(
                                                                    product.single_price,
                                                                )
                                                            }}
                                                            {{
                                                                props.document
                                                                    .curency
                                                                    .symbol
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-2 py-1 text-right whitespace-nowrap border-e"
                                                        >
                                                            {{
                                                                new Intl.NumberFormat(
                                                                    "en-US",
                                                                    {
                                                                        minimumFractionDigits: 2,
                                                                        maximumFractionDigits: 2,
                                                                    },
                                                                ).format(
                                                                    product.total_price,
                                                                )
                                                            }}
                                                            {{
                                                                props.document
                                                                    .curency
                                                                    .symbol
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-2 py-1 text-right whitespace-nowrap border-e"
                                                        >
                                                            <div
                                                                class="flex gap-1"
                                                            >
                                                                <Link
                                                                    class="px-4 hover:text-orange-600 text-slate-300"
                                                                    :href="`/documents/add/row/${props.document.id}/${product.id}`"
                                                                >
                                                                    <AddRowIcon
                                                                        v-tippy="{
                                                                            content:
                                                                                'Додај Празен Ред',
                                                                            arrow: true,
                                                                            theme: 'light',
                                                                        }"
                                                                    />
                                                                </Link>

                                                                <ModalLink
                                                                    class="hover:text-green-600 text-slate-300"
                                                                    :href="
                                                                        route(
                                                                            'product.edit',
                                                                            product.id,
                                                                        )
                                                                    "
                                                                >
                                                                    <EditIcon
                                                                        v-tippy="{
                                                                            content:
                                                                                'Измени Производ',
                                                                            arrow: true,
                                                                            theme: 'light',
                                                                        }"
                                                                    />
                                                                </ModalLink>

                                                                <button
                                                                    class="hover:text-red-700 text-slate-300"
                                                                    @click="
                                                                        () =>
                                                                            deleteProduct(
                                                                                product.id,
                                                                            )
                                                                    "
                                                                >
                                                                    <DeleteIcon
                                                                        v-tippy="{
                                                                            content:
                                                                                'Избриши Производ',
                                                                            arrow: true,
                                                                            theme: 'light',
                                                                        }"
                                                                    />
                                                                </button>
                                                            </div>
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
