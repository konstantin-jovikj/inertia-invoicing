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
import WarrantyIcon from "@/Components/WarrantyIcon.vue";
import PrintIcon from "@/Components/PrintIcon.vue";
// import {Modal, ModalLink } from "@/Components/ModalLink.vue";

// Props from the parent
const props = defineProps({
    document: Object,
    products: Array,
});

console.log(props.products);
// Accessing Inertia's page props
const page = usePage(); // This gives you access to all shared props
const flashMessage = ref(page.props.flash?.message || ""); // Access flash message from shared props

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

function convertToMacedonianWords(number) {
    if (number == null || isNaN(number)) {
        return "Непозната сума"; // "Unknown amount" in Macedonian
    }

    const ones = [
        "",
        "еден",
        "два",
        "три",
        "четири",
        "пет",
        "шест",
        "седум",
        "осум",
        "девет",
    ];
    const tens = [
        "",
        "десет",
        "дваесет",
        "триесет",
        "четириесет",
        "педесет",
        "шеесет",
        "седумдесет",
        "осумдесет",
        "деведесет",
    ];
    const teens = [
        "единаесет",
        "дванаесет",
        "тринаесет",
        "четиринаесет",
        "петнаесет",
        "шеснаесет",
        "седумнаесет",
        "осумнаесет",
        "деветнаесет",
    ];
    const thousands = ["", "илјада", "милиони", "милијарди"];

    function numberToWords(n) {
        if (n === 0) return "нула";

        let words = "";
        let groupIndex = 0;

        while (n > 0) {
            const group = n % 1000;
            if (group > 0) {
                let groupWords = "";

                const hundreds = Math.floor(group / 100);
                const remainder = group % 100;

                if (hundreds > 0) {
                    groupWords += `${ones[hundreds]} сто `;
                }

                if (remainder > 10 && remainder < 20) {
                    groupWords += `${teens[remainder - 11]} `;
                } else {
                    const tensValue = Math.floor(remainder / 10);
                    const onesValue = remainder % 10;

                    if (tensValue > 0) {
                        groupWords += `${tens[tensValue]} `;
                    }

                    if (onesValue > 0) {
                        groupWords += `${ones[onesValue]} `;
                    }
                }

                if (groupIndex > 0) {
                    groupWords += `${thousands[groupIndex]} `;
                }

                words = `${groupWords}${words}`.trim();
            }

            n = Math.floor(n / 1000);
            groupIndex++;
        }

        return words.trim();
    }

    // Split the number into integer and decimal parts
    const [integerPart, decimalPart] = number.toString().split(".");

    // Convert integer part
    let result = numberToWords(parseInt(integerPart, 10));

    // Convert decimal part (if exists)
    if (decimalPart > 0) {
        result += ` запирка ${decimalPart
            .split("")
            .map((digit) => ones[parseInt(digit, 10)])
            .join(" ")}`;
    }

    return result;
}
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
                            <div class="flex gap-2">
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

                                <a
                                    class="px-4 hover:text-sky-600 text-slate-300"
                                    :href="`/document/print/${props.document.id}`"
                                    target="_blank"
                                >
                                    <PrintIcon
                                        v-tippy="{
                                            content: `Принтај ${props.document.document_type.type}`,
                                            arrow: true,
                                            theme: 'light',
                                        }"
                                    />
                                </a>
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
                                                            -
                                                            {{
                                                                new Intl.NumberFormat(
                                                                    "en-US",
                                                                    {
                                                                        minimumFractionDigits: 0,
                                                                        maximumFractionDigits: 2,
                                                                    },
                                                                ).format(
                                                                    product.length,
                                                                )
                                                            }}
                                                            x
                                                            {{
                                                                new Intl.NumberFormat(
                                                                    "en-US",
                                                                    {
                                                                        minimumFractionDigits: 0,
                                                                        maximumFractionDigits: 2,
                                                                    },
                                                                ).format(
                                                                    product.width,
                                                                )
                                                            }}
                                                            x
                                                            {{
                                                                new Intl.NumberFormat(
                                                                    "en-US",
                                                                    {
                                                                        minimumFractionDigits: 0,
                                                                        maximumFractionDigits: 2,
                                                                    },
                                                                ).format(
                                                                    product.height,
                                                                )
                                                            }}
                                                            -
                                                            <span
                                                                class="font-bold text-green-900"
                                                                v-if="product.manufacturer_id"
                                                                >{{
                                                                    product
                                                                        .manufacturers
                                                                        .name
                                                                }}</span
                                                            >
                                                            -
                                                            <span
                                                                class="text-blue-800" 
                                                                v-if="product.manufacturer_id"                                                         
                                                            >
                                                                {{
                                                                    product
                                                                        .manufacturers
                                                                        .place
                                                                        .country
                                                                        .name
                                                                }}
                                                            </span>
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
                                                            <div></div>
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

                                                                <a
                                                                    class="px-4 hover:text-green-600 text-slate-300"
                                                                    :href="`/product/warranty/${product.id}`"
                                                                    target="_blank"
                                                                >
                                                                    <WarrantyIcon
                                                                        v-tippy="{
                                                                            content:
                                                                                'Гаранција',
                                                                            arrow: true,
                                                                            theme: 'light',
                                                                        }"
                                                                    />
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="mt-4">
                                            <ModalLink
                                                :href="`/products/add/modal/${props.document.id}`"
                                                class="px-4 py-2 text-white bg-gray-700 rounded-md hover:bg-gray-900"
                                            >
                                                Додај Производ
                                            </ModalLink>
                                        </div>
                                    </div>
                                </div>

                                <!-- CALCULATED FIELDS -->
                                <div class="flex justify-end">
                                    <table
                                        class="font-light text-center border-collapse w-[400px] text-sm text-surface border-e mt-4"
                                    >
                                        <tr
                                            class="border-t border-b border-indigo-300 border-e border-s"
                                        >
                                            <th
                                                class="border-indigo-300 bg-indigo-50 border-e"
                                            >
                                                <span
                                                    class="italic font-normal text-right text-indigo-600 pe-4 text-md"
                                                >
                                                    Основица
                                                </span>
                                            </th>
                                            <td
                                                class="text-lg font-bold text-right text-indigo-600"
                                            >
                                                {{
                                                    new Intl.NumberFormat(
                                                        "en-US",
                                                        {
                                                            minimumFractionDigits: 2,
                                                            maximumFractionDigits: 2,
                                                        },
                                                    ).format(
                                                        props.document.total,
                                                    )
                                                }}
                                            </td>
                                            <td
                                                class="text-lg font-bold text-right text-indigo-600 pe-4"
                                            >
                                                {{
                                                    props.document.curency
                                                        .symbol
                                                }}
                                            </td>
                                        </tr>

                                        <!-- DISCOUNT -->

                                        <tr
                                            v-if="
                                                props.document.discount !==
                                                    null &&
                                                props.document.discount > 0
                                            "
                                            class="border-t border-b border-indigo-300 border-e border-s"
                                        >
                                            <th
                                                class="border-indigo-300 bg-indigo-50 border-e"
                                            >
                                                <span
                                                    class="italic font-normal text-right text-indigo-600 pe-4 text-md"
                                                >
                                                    Попуст
                                                    {{
                                                        props.document.discount
                                                    }}
                                                    %
                                                </span>
                                            </th>
                                            <td
                                                class="text-lg font-bold text-right text-indigo-600"
                                            >
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
                                            <td
                                                class="text-lg font-bold text-right text-indigo-600 pe-4"
                                            >
                                                {{
                                                    props.document.curency
                                                        .symbol
                                                }}
                                            </td>
                                        </tr>

                                        <!-- DDV -->

                                        <tr
                                            v-if="
                                                props.document.tax &&
                                                props.document.tax.tax_rate != 0
                                            "
                                            class="border-t border-b border-indigo-300 border-e border-s"
                                        >
                                            <th
                                                class="border-indigo-300 bg-indigo-50 border-e"
                                            >
                                                <span
                                                    class="italic font-normal text-right text-indigo-600 pe-4 text-md"
                                                >
                                                    ДДВ
                                                    {{
                                                        props.document.tax
                                                            .tax_rate
                                                    }}
                                                    %
                                                </span>
                                            </th>
                                            <td
                                                class="text-lg font-bold text-right text-indigo-600"
                                            >
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
                                            <td
                                                class="text-lg font-bold text-right text-indigo-600 pe-4"
                                            >
                                                {{
                                                    props.document.curency
                                                        .symbol
                                                }}
                                            </td>
                                        </tr>

                                        <!-- Document Grand Total -->

                                        <tr
                                            class="border-t border-b border-indigo-300 border-e border-s"
                                        >
                                            <th
                                                class="border-indigo-300 bg-pink-50 border-e"
                                            >
                                                <span
                                                    class="italic font-normal text-right text-pink-600 pe-4 text-md"
                                                >
                                                    Вкупно со ДДВ
                                                </span>
                                            </th>
                                            <td
                                                class="text-lg font-bold text-right text-pink-600"
                                            >
                                                {{
                                                    new Intl.NumberFormat(
                                                        "en-US",
                                                        {
                                                            minimumFractionDigits: 2,
                                                            maximumFractionDigits: 2,
                                                        },
                                                    ).format(
                                                        props.document
                                                            .total_with_tax_and_discount,
                                                    )
                                                }}
                                            </td>
                                            <td
                                                class="text-lg font-bold text-right text-pink-600 pe-4"
                                            >
                                                {{
                                                    props.document.curency
                                                        .symbol
                                                }}
                                            </td>
                                        </tr>

                                        <!-- AVANS -->

                                        <tr
                                            v-if="
                                                props.document
                                                    .advance_payment !== null &&
                                                props.document.advance_payment >
                                                    0
                                            "
                                            class="border-t border-b border-indigo-300 border-e border-s"
                                        >
                                            <th
                                                class="border-indigo-300 bg-teal-50 border-e"
                                            >
                                                <span
                                                    class="italic font-normal text-right text-teal-600 pe-4 text-md"
                                                >
                                                    Аванс
                                                </span>
                                            </th>
                                            <td
                                                class="text-lg font-bold text-right text-teal-600"
                                            >
                                                {{
                                                    new Intl.NumberFormat(
                                                        "en-US",
                                                        {
                                                            minimumFractionDigits: 2,
                                                            maximumFractionDigits: 2,
                                                        },
                                                    ).format(
                                                        props.document
                                                            .advance_payment,
                                                    )
                                                }}
                                            </td>
                                            <td
                                                class="text-lg font-bold text-right text-teal-600 pe-4"
                                            >
                                                {{
                                                    props.document.curency
                                                        .symbol
                                                }}
                                            </td>
                                        </tr>

                                        <!-- Preostanata Osnovica -->

                                        <tr
                                            v-if="
                                                props.document
                                                    .advance_payment !== null &&
                                                props.document.advance_payment >
                                                    0
                                            "
                                            class="border-t border-b border-indigo-300 border-e border-s"
                                        >
                                            <th
                                                class="border-indigo-300 bg-teal-50 border-e"
                                            >
                                                <span
                                                    class="italic font-normal text-right text-teal-600 pe-4 text-md"
                                                >
                                                    Преостаната Основица
                                                </span>
                                            </th>
                                            <td
                                                class="text-lg font-bold text-right text-teal-600"
                                            >
                                                {{
                                                    new Intl.NumberFormat(
                                                        "en-US",
                                                        {
                                                            minimumFractionDigits: 2,
                                                            maximumFractionDigits: 2,
                                                        },
                                                    ).format(
                                                        props.document
                                                            .advanced_payment_base,
                                                    )
                                                }}
                                            </td>
                                            <td
                                                class="text-lg font-bold text-right text-teal-600 pe-4"
                                            >
                                                {{
                                                    props.document.curency
                                                        .symbol
                                                }}
                                            </td>
                                        </tr>

                                        <!-- Preostanatо ДДВ -->

                                        <tr
                                            v-if="
                                                props.document
                                                    .advance_payment !== null &&
                                                props.document.advance_payment >
                                                    0
                                            "
                                            class="border-t border-b border-indigo-300 border-e border-s"
                                        >
                                            <th
                                                class="border-indigo-300 bg-teal-50 border-e"
                                            >
                                                <span
                                                    class="italic font-normal text-right text-teal-600 pe-4 text-md"
                                                >
                                                    Преостанатo ДДВ
                                                </span>
                                            </th>
                                            <td
                                                class="text-lg font-bold text-right text-teal-600"
                                            >
                                                {{
                                                    new Intl.NumberFormat(
                                                        "en-US",
                                                        {
                                                            minimumFractionDigits: 2,
                                                            maximumFractionDigits: 2,
                                                        },
                                                    ).format(
                                                        props.document
                                                            .advanced_payment_tax,
                                                    )
                                                }}
                                            </td>
                                            <td
                                                class="text-lg font-bold text-right text-teal-600 pe-4"
                                            >
                                                {{
                                                    props.document.curency
                                                        .symbol
                                                }}
                                            </td>
                                        </tr>

                                        <!-- VKUPNO ZA NAPLATA -->

                                        <tr
                                            v-if="
                                                props.document
                                                    .advance_payment !== null &&
                                                props.document.advance_payment >
                                                    0
                                            "
                                            class="border-t border-b-4 border-b-red-500 border-indigo-300 border-e border-s"
                                        >
                                            <th
                                                class="border-indigo-300 bg-red-100 border-e"
                                            >
                                                <span
                                                    class="font-medium text-right text-red-600 pe-4 text-md"
                                                >
                                                    Вк.Преостанато со ДДВ
                                                </span>
                                            </th>
                                            <td
                                                class="text-lg font-bold text-right text-red-600 bg-red-100"
                                            >
                                                {{
                                                    new Intl.NumberFormat(
                                                        "en-US",
                                                        {
                                                            minimumFractionDigits: 2,
                                                            maximumFractionDigits: 2,
                                                        },
                                                    ).format(
                                                        props.document
                                                            .grand_total,
                                                    )
                                                }}
                                            </td>
                                            <td
                                                class="text-lg font-bold text-right text-red-600 pe-4 bg-red-100"
                                            >
                                                {{
                                                    props.document.curency
                                                        .symbol
                                                }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- WORDS -->
                            <div class="text-xs text-purple-400 italic">
                                {{
                                    convertToMacedonianWords(
                                        props.document
                                            .total_with_tax_and_discount ?? 0,
                                    )
                                }}
                                {{ props.document.curency.symbol }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
