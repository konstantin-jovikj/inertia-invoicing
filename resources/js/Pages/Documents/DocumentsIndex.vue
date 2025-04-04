<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import { computed, ref, watch, onMounted } from "vue";
import { debounce } from "lodash";
import EditIcon from "../../Components/EditIcon.vue";
import DeleteIcon from "../../Components/DeleteIcon.vue";
import TruckIcon from "@/Components/TruckIcon.vue";
import PlanetIcon from "@/Components/PlanetIcon.vue";
import AddIcon from "../../Components/AddIcon.vue";
import DocumentNewIcon from "@/Components/DocumentNewIcon.vue";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { useForm } from "@inertiajs/vue3";
import { latinToCyrillic } from "@/helpers/latinToCyrillic";

const props = defineProps({
    documents: Object,
    documentTypes: Array,
    searchTerm: String,
    clients: Array,
});

const form = useForm({
    desired_document_id: "",
});

// onMounted(() => {
//     documents.value.data.forEach((doc) => {
//         doc.desiredDocumentId = ''; // Initialize the desiredDocumentId
//     });
// });

// const search = ref(props.searchTerm);
const search = ref(props.searchTerm || "");
const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

// Generate an array of years from 2020 to 2040
const years = Array.from({ length: 41 }, (_, i) => 2020 + i);
const exportStates = ["извозни", "домашни"];

const selectedYear = ref(""); // Year selected by the user
const selectedType = ref(""); // Document type selected by the user
const selectedClient = ref(""); // Client  selected by the user selectedExport
const selectedExport = ref("");

// Watch the selected year and type, and trigger re-fetch when either changes
watch(
    [selectedYear, selectedType, selectedClient, selectedExport],
    debounce((newValues) => {
        const [newYear, newType, newClient, newExport] = newValues;

        // Trigger re-fetch of documents with the selected year and type
        router.get(
            "/documents",
            {
                year: newYear,
                type: newType,
                client: newClient,
                export: newExport,
            },
            {
                preserveState: true,
            },
        );
    }, 200),
);

// Delete document function
const deleteDocument = (id) => {
    if (confirm("Дали сигурно сакаш да го избришеш овој документ?")) {
        router.delete("/document/delete/" + id, {
            preserveState: false,
            onSuccess: () => {
                flashMessage.value = props.flash.message;
            },
        });
    }
};

onMounted(() => {
    if (flashMessage.value) {
        setTimeout(() => {
            flashMessage.value = "";
        }, 3000);
    }
});

const getPaginationLabel = (label) => {
    // Handle special cases for prev/next arrows
    if (label === "&laquo; Previous") return "<<";
    if (label === "Next &raquo;") return ">>";
    return label;
};

console.log(props.documents);
</script>

<template>
    <Head title="Documents" />

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
                            <h2 class="font-bold text-sky-800">Документи</h2>
                            <div class="flex gap-4">
                                <!-- Export Selection Dropdown -->
                                <select
                                    v-model="selectedExport"
                                    as="select"
                                    id="client"
                                    class="w-[150px] px-8 mt-1 text-base border border-sky-500 rounded bg-gray-50"
                                >
                                    <option value="" selected>Извоз...</option>
                                    <option
                                        v-for="exportState in exportStates"
                                        :key="exportState"
                                        :value="exportState"
                                    >
                                        {{ exportState }}
                                    </option>
                                </select>

                                <!-- Client Selection Dropdown -->
                                <select
                                    v-model="selectedClient"
                                    as="select"
                                    id="client"
                                    class="w-[350px] px-4 mt-1 text-base border rounded bg-gray-50 border-sky-500"
                                >
                                    <option value="" selected>Клиент...</option>
                                    <option
                                        v-for="client in clients"
                                        :key="client"
                                        :value="client.id"
                                    >
                                        {{ client.name }}
                                    </option>
                                </select>

                                <!-- Year Selection Dropdown -->
                                <select
                                    v-model="selectedYear"
                                    as="select"
                                    id="year"
                                    class="w-[120px] px-4 mt-1 text-base border rounded bg-gray-50 border-sky-500"
                                >
                                    <option value="" selected>Година...</option>
                                    <option
                                        v-for="year in years"
                                        :key="year"
                                        :value="year"
                                    >
                                        {{ year }}
                                    </option>
                                </select>

                                <select
                                    v-model="selectedType"
                                    as="select"
                                    id="type"
                                    class="w-[200px] px-4 py-1 mt-1 text-base border rounded bg-gray-50 border-sky-500"
                                >
                                    <option value="" selected>
                                        Тип на Документ...
                                    </option>
                                    <option
                                        v-for="type in documentTypes"
                                        :key="type.id"
                                        :value="type.id"
                                    >
                                        {{ latinToCyrillic(type.type) }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <table
                            class="min-w-full divide-y divide-gray-200 shadow table-auto sm:rounded-lg"
                        >
                            <thead class="bg-primary">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        index
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Бр
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Бр на Документ
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Тип на Документ
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Клиент
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Датум
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-center text-white uppercase bg-sky-700"
                                    >
                                        Износ
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Акција
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="text-xs bg-white divide-y divide-gray-200"
                            >
                                <tr
                                    class="hover:bg-slate-100"
                                    v-for="(document, index) in documents.data"
                                    :key="document.id"
                                    :class="[
                                        document.is_for_advanced_payment
                                            ? 'bg-red-50 hover:bg-red-100'
                                            : '',
                                    ]"
                                >
                                    <td class="text-xs text-slate-300">
                                        {{ document.id }} {{}}
                                    </td>
                                    <td class="">
                                        {{ documents.from + index }}
                                    </td>
                                    <td
                                        class="text-base font-semibold text-emerald-700"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'products.create',
                                                    document.id,
                                                )
                                            "
                                            class="hover:text-red-600"
                                        >
                                            {{ document.document_no }}
                                        </Link>
                                    </td>
                                    <td class="flex text-base font-semibold">
                                        <!-- <span
                                            v-if="document.packing_list"
                                            class="pe-2 text-orange-500"
                                        >
                                            <TruckIcon />
                                        </span> -->
                                        {{
                                            document.is_for_advanced_payment
                                                ? "Авансна "
                                                : ""
                                        }}
                                        {{
                                            latinToCyrillic(
                                                document.document_type.type,
                                            )
                                        }}
                                        <span
                                            class="text-cyan-600 flex px-2"
                                            v-if="document.is_for_export"
                                        >
                                            <PlanetIcon
                                                v-tippy="{
                                                    content: `извоз`,
                                                    arrow: true,
                                                    theme: 'light',
                                                }"
                                        /></span>
                                        <span>
                                            <span
                                                class="text-lime-600 hover:bg-gray-800"
                                                v-if="document.packing_list"
                                            >
                                                <!-- <TruckIcon > -->
                                                <Link
                                                    v-tippy="{
                                                        content: `Пакинг Листа Бр: ${document.packing_list.document_no}`,
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"
                                                    :href="`/packinglist/create/${document.packing_list.id}`"
                                                    ><TruckIcon></TruckIcon>
                                                </Link>
                                                <!-- </TruckIcon> -->
                                            </span>
                                        </span>
                                    </td>

                                    <td
                                        class="text-base font-semibold text-sky-600"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'company.show',
                                                    document.company.id,
                                                )
                                            "
                                            class="hover:text-red-800"
                                        >
                                            {{ document.company.name }}
                                        </Link>
                                    </td>

                                    <td
                                        v-if="document.document_type.id !== 7"
                                        class="text-base font-semibold text-purple-600"
                                    >
                                        {{
                                            new Date(document.date)
                                                .toLocaleDateString("en-GB", {
                                                    day: "2-digit",
                                                    month: "2-digit",
                                                    year: "numeric",
                                                })
                                                .replace(/\//g, ".")
                                        }}
                                    </td>
                                    <td
                                        v-else
                                        class="text-base font-semibold text-purple-600"
                                    >
                                        {{
                                            new Date(
                                                document.load_date,
                                            ).toLocaleDateString("en-GB", {
                                                    day: "2-digit",
                                                    month: "2-digit",
                                                    year: "numeric",
                                                })
                                                .replace(/\//g, ".")
                                        }}
                                    </td>

                                    <td class="px-2 text-right">
                                        <span
                                            v-if="
                                                document.document_type.id !== 7
                                            "
                                            class="pr-2 text-base font-semibold text-red-600"
                                        >
                                            {{
                                                new Intl.NumberFormat("en-US", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2,
                                                }).format(
                                                    document.total_with_tax_and_discount,
                                                )
                                            }}
                                        </span>
                                        <span
                                            v-if="
                                                document.document_type.id !== 7
                                            "
                                            class="px-1 text-left text-base font-semibold text-red-600"
                                        >
                                            {{
                                                document.curency_id
                                                    ? document.curency.symbol
                                                    : ""
                                            }}
                                        </span>
                                    </td>

                                    <td class="px-4">
                                        <div class="flex gap-2">
                                            <Link
                                                v-if="
                                                    document.document_type.id ==
                                                    7
                                                "
                                                class="hover:text-green-600 text-slate-300 content-center"
                                                :href="
                                                    route(
                                                        'travelorder.view',
                                                        document.id,
                                                    )
                                                "
                                            >
                                                <EditIcon
                                                    v-tippy="{
                                                        content: `Измени Патен Налог`,
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"
                                                />
                                            </Link>

                                            <Link
                                                v-else
                                                class="hover:text-green-600 text-slate-300 content-center"
                                                :href="
                                                    route(
                                                        'products.create',
                                                        document.id,
                                                    )
                                                "
                                            >
                                                <EditIcon
                                                    v-tippy="{
                                                        content: `Измени ${latinToCyrillic(
                                                            document
                                                                .document_type
                                                                .type,
                                                        )}`,
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"
                                                />
                                            </Link>

                                            <button
                                                class="hover:text-red-700 text-slate-300"
                                                @click="
                                                    () =>
                                                        deleteDocument(
                                                            document.id,
                                                        )
                                                "
                                            >
                                                <DeleteIcon
                                                    v-tippy="{
                                                        content: `Избриши ${latinToCyrillic(
                                                            document
                                                                .document_type
                                                                .type,
                                                        )}`,
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"
                                                />
                                            </button>

                                            <!-- Copy To Actions -->

                                            <div class="w-full lg:w-1/2">
                                                <form
                                                    class="flex gap-2"
                                                    @submit.prevent="
                                                        form.post(
                                                            `/convert/document/${document.id}/${document.desiredDocumentId}`,
                                                            {
                                                                onError: () =>
                                                                    form.reset(),
                                                            },
                                                        )
                                                    "
                                                >
                                                    <select
                                                        v-model="
                                                            document.desiredDocumentId
                                                        "
                                                        id="convert"
                                                        class="w-full h-6 m-0 py-0 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                    >
                                                        <option
                                                            value=""
                                                            disabled
                                                        >
                                                            Направи...
                                                        </option>
                                                        <option
                                                            v-for="documentType in documentTypes"
                                                            :key="
                                                                documentType.id
                                                            "
                                                            :value="
                                                                documentType.id
                                                            "
                                                        >
                                                            {{
                                                                latinToCyrillic(
                                                                    documentType.type,
                                                                )
                                                            }}
                                                        </option>
                                                    </select>

                                                    <button
                                                        :disabled="
                                                            !document.desiredDocumentId
                                                        "
                                                        type="submit"
                                                    >
                                                        <DocumentNewIcon
                                                            class="hover:text-sky-800"
                                                        />
                                                        <span
                                                            v-if="
                                                                form.processing
                                                            "
                                                            >Loading...</span
                                                        >
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div
                            v-if="documents && documents.links"
                            class="flex flex-col lg:flex-row lg:justify-around"
                        >
                            <div class="mt-2">
                                <Link
                                    v-for="link in documents.links"
                                    :key="link.label"
                                    :href="link.url || '#'"
                                    class="p-1 mx-1 hover:bg-sky-200"
                                    :class="{
                                        'text-slate-300': !link.url,
                                        'text-sky-500 font-bold': link.active,
                                    }"
                                >
                                    {{ getPaginationLabel(link.label) }}
                                </Link>
                            </div>

                            <p class="mt-3 text-xs text-gray-500">
                                Прикажани се од {{ documents.from }} до
                                {{ documents.to }} од вкупно
                                {{ documents.total }} записи
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
