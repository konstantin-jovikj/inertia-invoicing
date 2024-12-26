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
import PackageIcon from "@/Components/PackageIcon.vue";
import CertificateIcon from "@/Components/CertificateIcon.vue";
import FreonIcon from "@/Components/FreonIcon.vue";
import { onMounted } from "vue";
import { debounce } from "lodash";
import { Tippy } from "vue-tippy";
import WarrantyIcon from "@/Components/WarrantyIcon.vue";
import PrintIcon from "@/Components/PrintIcon.vue";
import { latinToCyrillic } from "@/helpers/latinToCyrillic";
import AlbanianFlag from "@/Components/AlbanianFlag.vue";
import MacedonianFlag from "@/Components/MacedonianFlag.vue";

// Props from the parent
const props = defineProps({
    document: Object,
    products: Array,
    packingListExists: Boolean,
    secondLatestDoc: Object
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

function numberToWordsMK(number) {
    const units = [
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
    const teens = [
        "десет",
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
    const tens = [
        "",
        "",
        "дваесет",
        "триесет",
        "четириесет",
        "педесет",
        "шеесет",
        "седумдесет",
        "осумдесет",
        "деведесет",
    ];
    const hundreds = [
        "",
        "сто",
        "двеста",
        "триста",
        "четиристотини",
        "петстотини",
        "шестотини",
        "седумстотини",
        "осумстотини",
        "деветстотини",
    ];
    const thousands = ["", "илјада", "илјади"];
    const millions = ["", "милион", "милиони"];

    if (number === 0) {
        return "нула";
    }

    let words = "";

    // Handle millions
    if (number >= 1000000) {
        const millionPart = Math.floor(number / 1000000);
        number %= 1000000;

        words += this.numberToWordsMK(millionPart) + " ";
        words += millionPart === 1 ? millions[1] : millions[2];
        if (number > 0) {
            words += " и ";
        }
    }

    // Handle thousands
    if (number >= 1000) {
        const thousandPart = Math.floor(number / 1000);
        number %= 1000;

        words += this.numberToWordsMK(thousandPart) + " ";
        words += thousandPart === 1 ? thousands[1] : thousands[2];
        if (number > 0) {
            words += " и ";
        }
    }

    // Handle hundreds
    if (number >= 100) {
        const hundredPart = Math.floor(number / 100);
        number %= 100;

        words += hundreds[hundredPart];
        if (number > 0) {
            words += " и ";
        }
    }

    // Handle tens and units
    if (number >= 10 && number < 20) {
        words += teens[number - 10];
    } else {
        const tenPart = Math.floor(number / 10);
        const unitPart = number % 10;

        if (tenPart > 0) {
            words += tens[tenPart];
            if (unitPart > 0) {
                words += " и ";
            }
        }

        if (unitPart > 0) {
            words += units[unitPart];
        }
    }

    return words;
}

console.log("packingListExists", props.packingListExists);

const createPackingList = () => {
    router.post(`/packinglist/add/${props.document.id}`);
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
                        <span v-if="props.secondLatestDoc" class="">
                            posledna {{ props.secondLatestDoc.document_no }}
                        </span>
                            <!-- Izmeni Dokument -->
                            <div class="flex gap-2 mt-2">
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
                                            content: `Измени ${latinToCyrillic(props.document.document_type.type)}`,
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
                                            content: `Принтај ${latinToCyrillic(props.document.document_type.type)}`,
                                            arrow: true,
                                            theme: 'light',
                                        }"
                                    />
                                </a>

                                <!-- Create Packing List AddIcon -->
                                <a
                                    v-if="!packingListExists"
                                    class="px-4 hover:text-sky-600 text-slate-300"
                                    @click.prevent="createPackingList"
                                >
                                    <PackageIcon
                                        v-tippy="{
                                            content: 'Направи Пакинг Листа',
                                            arrow: true,
                                            theme: 'light',
                                        }"
                                    />
                                </a>
                            </div>
                            <!-- Izmeni Dokument end-->
                            <div class="grid grid-cols-1 gap-4 text-sm gap-y-2">
                                <div class="flex-col text-gray-500">
                                    
                                    <div class="flex items-center">
                                        <span class="italic text-md">
                                            {{
                                                latinToCyrillic(
                                                    props.document.document_type
                                                        .type,
                                                )
                                            }}
                                        </span>
                                        <span
                                            v-if="props.document.is_for_export"
                                            class="italic text-md text-green-600 font-semibold px-2"
                                        >
                                            EXPORT
                                        </span>
                                        <span class="italic text-md">
                                            Бр:
                                        </span>
                                        <span
                                            class="text-lg font-bold text-black px-2"
                                            >{{
                                                props.document.document_no
                                            }}</span
                                        >

                                        <span
                                            class="ps-4 text-black"
                                            v-if="document.packing_list"
                                        >
                                            <Link
                                                :href="`/packinglist/create/${document.packing_list.id}`"
                                                class="text-md font-semibold px-4"
                                            >
                                                {{
                                                    `со пакинг листа бр: ${document.packing_list.document_no}`
                                                }}
                                            </Link>
                                        </span>
                                        <span
                                            v-if="props.document.is_translation"
                                            class=""
                                        >
                                            <AlbanianFlag></AlbanianFlag>
                                        </span>
                                        <span
                                            v-else
                                            class=""
                                        >
                                            <MacedonianFlag></MacedonianFlag>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="italic text-md"
                                            >Kлиент:
                                        </span>

                                        <Link
                                            class="hover:text-green-600 text-slate-300 content-center"
                                            :href="
                                                route(
                                                    'company.show',
                                                    props.document.company.id,
                                                )
                                            "
                                            ><span
                                                class="text-lg font-bold text-black"
                                            >
                                                {{
                                                    props.document.company.name
                                                }}
                                            </span>
                                        </Link>
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
                                                            class="px-2 py-1 text-left whitespace-nowrap border-e flex"
                                                        >
                                                            {{
                                                                product.description
                                                            }}
                                                            <div
                                                                v-if="
                                                                    product.length
                                                                "
                                                            >
                                                                <span> - </span>
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
                                                            </div>
                                                            <div
                                                                v-if="
                                                                    product.width
                                                                "
                                                            >
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
                                                            </div>
                                                            <div
                                                                v-if="
                                                                    product.height
                                                                "
                                                            >
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
                                                            </div>
                                                            <div
                                                                v-if="
                                                                    product.manufacturer_id
                                                                "
                                                            >
                                                                -
                                                                <span
                                                                    class="font-bold text-green-900"
                                                                    >{{
                                                                        product
                                                                            .manufacturers
                                                                            .name
                                                                    }}</span
                                                                >
                                                                -
                                                                <span
                                                                    class="text-blue-800"
                                                                >
                                                                    {{
                                                                        product
                                                                            .manufacturers
                                                                            .place
                                                                            .country
                                                                            .name
                                                                    }}
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-2 py-1 text-left whitespace-nowrap border-e"
                                                        >
                                                        {{new Intl.NumberFormat(
                                                                    "en-US",
                                                                    {
                                                                        minimumFractionDigits: 0,
                                                                        maximumFractionDigits: 4,
                                                                    },
                                                                ).format(
                                                                    product.qty,
                                                                )}}
                                                            
                                                        </td>
                                                        <td
                                                            class="px-2 py-1 text-right whitespace-nowrap border-e"
                                                        >
                                                            {{
                                                                new Intl.NumberFormat(
                                                                    "en-US",
                                                                    {
                                                                        minimumFractionDigits: 0,
                                                                        maximumFractionDigits: 4,
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
                                                                    class="px-2 hover:text-green-600 text-slate-300"
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

                                                                <!-- CE Declaration -->
                                                                <div
                                                                v-if="product.manufacturer_id ==1"
                                                                class="flex">

                                                                
                                                                <a
                                                                    class="px-2 hover:text-orange-300 text-slate-300"
                                                                    :href="`/ce/print/${product.id}`"
                                                                    target="_blank"
                                                                >
                                                                    <CertificateIcon
                                                                        v-tippy="{
                                                                            content:
                                                                                'CE Certificate',
                                                                            arrow: true,
                                                                            theme: 'light',
                                                                        }"
                                                                    />
                                                                </a>

                                                                <!-- Freon Certificate -->

                                                                <a
                                                                    class="px-2 hover:text-green-700 text-slate-300"
                                                                    :href="`/freon/print/${product.id}`"
                                                                    target="_blank"
                                                                >
                                                                    <FreonIcon
                                                                        v-tippy="{
                                                                            content:
                                                                                'Freon Certificate',
                                                                            arrow: true,
                                                                            theme: 'light',
                                                                        }"
                                                                    />
                                                                </a>
                                                            </div>
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
                                    numberToWordsMK(
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
