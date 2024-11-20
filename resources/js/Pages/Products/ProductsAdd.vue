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
import { onMounted } from "vue";
import { debounce } from "lodash";
import { Tippy } from "vue-tippy";

// import {Modal, ModalLink } from "@/Components/ModalLink.vue";

// Props from the parent
const props = defineProps({
    document: Object,
    products: Array,
});

// Accessing Inertia's page props
const page = usePage(); // This gives you access to all shared props
const flashMessage = ref(page.props.flash?.message || ""); // Access flash message from shared props

// Form for adding products
const form = useForm({
    document_id: props.document.id,
    description: "",
    qty: "",
    single_price: "",
    total_price: "",
});

// State for managing products
const state = reactive({
    products: [...props.products],
    document: [...props.products],
});

// Delete Product function
const deleteProduct = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш овој Производ")) {
        router.delete(`/products/delete/${id}`, {
            preserveState: false,
            onSuccess: () => {
                flashMessage.value = page.props.flash.message; // Update the flash message
            },
        });
    }
};

// Handle flash message timeout
onMounted(() => {
    if (flashMessage.value) {
        setTimeout(() => {
            flashMessage.value = "";
        }, 3000);
    }
});
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
                                <div class="flex-col text-gray-500">
                                    <div>
                                        <span class="italic text-md">
                                            {{
                                                props.document.document_type
                                                    .type
                                            }}
                                        </span>
                                        <span class="italic text-md">
                                            Бр:
                                        </span>
                                        <span
                                            class="text-lg font-bold text-black"
                                            >{{
                                                props.document.document_no
                                            }}</span
                                        >
                                    </div>
                                    <div>
                                        <span class="italic text-md"
                                            >Kлиент:
                                        </span>
                                        <span
                                            class="text-lg font-bold text-black"
                                        >
                                            {{ props.document.company.name }}
                                        </span>
                                    </div>
                                    <!-- <hr /> -->
                                    <div>
                                        <table
                                            class="font-light text-center border-collapse w-[350px] text-sm text-surface border-e mt-4"
                                        >
                                            <tr
                                                class="border-t border-b border-indigo-300 border-e border-s"
                                            >
                                                <th class="border-indigo-300 bg-indigo-50 border-e">
                                                    <span class="italic font-normal text-right text-indigo-600 pe-4 text-md">
                                                        Основица
                                                    </span>
                                                   </th>
                                                <td class="text-lg font-bold text-right text-indigo-600">
                                                    {{
                                                        new Intl.NumberFormat(
                                                            "en-US",
                                                            {
                                                                minimumFractionDigits: 2,
                                                                maximumFractionDigits: 2,
                                                            },
                                                        ).format(
                                                            props.document
                                                                .total,
                                                        )
                                                    }}
                                                </td>
                                                <td class="text-lg font-bold text-right text-indigo-600 pe-4">
                                                    {{
                                                        props.document.curency
                                                            .symbol
                                                    }}
                                                </td>
                                            </tr>

                                            <!-- DISCOUNT -->

                                            <tr
                                                  v-if="props.document.discount !== null && props.document.discount > 0"
                                                class="border-t border-b border-indigo-300 border-e border-s"
                                            >
                                                <th class="border-indigo-300 bg-indigo-50 border-e">
                                                    <span class="italic font-normal text-right text-indigo-600 pe-4 text-md">
                                                        Попуст {{ props.document.discount }} %
                                                    </span>
                                                   </th>
                                                <td class="text-lg font-bold text-right text-indigo-600">
                                                    {{
                                                        new Intl.NumberFormat(
                                                            "en-US",
                                                            {
                                                                minimumFractionDigits: 2,
                                                                maximumFractionDigits: 2,
                                                            },
                                                        ).format(
                                                            props.document
                                                                .discount_amount,
                                                        )
                                                    }}
                                                </td>
                                                <td class="text-lg font-bold text-right text-indigo-600 pe-4">
                                                    {{
                                                        props.document.curency
                                                            .symbol
                                                    }}
                                                </td>
                                            </tr>

                                            <!-- DDV -->

                                            <tr
                                             v-if="props.document.tax.tax_rate != 0"
                                                class="border-t border-b border-indigo-300 border-e border-s"
                                            >
                                                <th class="border-indigo-300 bg-indigo-50 border-e">
                                                    <span class="italic font-normal text-right text-indigo-600 pe-4 text-md">
                                                        ДДВ {{ props.document.tax.tax_rate }} %
                                                    </span>
                                                   </th>
                                                <td class="text-lg font-bold text-right text-indigo-600">
                                                    {{
                                                        new Intl.NumberFormat(
                                                            "en-US",
                                                            {
                                                                minimumFractionDigits: 2,
                                                                maximumFractionDigits: 2,
                                                            },
                                                        ).format(
                                                            props.document
                                                                .tax_amount,
                                                        )
                                                    }}
                                                </td>
                                                <td class="text-lg font-bold text-right text-indigo-600 pe-4">
                                                    {{
                                                        props.document.curency
                                                            .symbol
                                                    }}
                                                </td>
                                            </tr>



                                        </table>

                                    </div>
                                </div>

                                <div class="lg:col-span-2">
                                    <hr class="my-4" />
                                    <div
                                        class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                    >
                                        <div class="md:col-span-6">
                                            <p>Производи</p>

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
