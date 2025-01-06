<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import EditIcon from "../../Components/EditIcon.vue";
import DeleteIcon from "../../Components/DeleteIcon.vue";
import AddAccountIcon from "@/Components/AddAccountIcon.vue";
import AddContactIcon from "@/Components/AddContactIcon.vue";
import DocumentNewIcon from "@/Components/DocumentNewIcon.vue";
import { computed, ref, watch, onMounted } from "vue";
import { latinToCyrillic } from "@/helpers/latinToCyrillic";
import { useForm } from "@inertiajs/vue3";
import { debounce } from "lodash";
import { Bar } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";

const props = defineProps({
    company: Object,
    searchTerm: String,
    documents: Object,
    documentTypes: Array,
    searchTerm: String,
    clients: Array,
});

const form = useForm({
    desired_document_id: "",
});

const companyContacts = props.company.contacts;
console.log("Company:", props.company);

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

// Delete contact function
const deleteContact = (id) => {
    if (confirm("Дали сигурно сакаш да го избришеш овој контакт?")) {
        router.delete("/contacts/delete/" + id, {
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

const websiteDomain = computed(() => {
    try {
        const url = new URL(
            props.company.web.startsWith("http")
                ? props.company.web
                : `http://${props.company.web}`,
        );
        return {
            href: url.href, // Complete URL with protocol
            hostname: url.hostname, // Just the domain, e.g., "www.frigosan.com.mk"
        };
    } catch (error) {
        return {
            href: props.company.web,
            hostname: props.company.web,
        };
    }
});
// console.log(props.company.web);

const toggleActive = (id) => {
    router.patch(
        `/activate/account/${id}`,
        {},
        {
            preserveState: true, // Keeps current component state (like pagination, sorting)
            onSuccess: (page) => {
                flashMessage.value = page.props.flash.message;
            },
            onError: (errors) => {
                console.error("Error toggling active status:", errors);
            },
        },
    );
};

// Delete Account function
const deleteAccount = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш оваа банкарска сметка?")) {
        router.delete("/accounts/delete/" + id, {
            preserveState: false,
            onSuccess: () => {
                flashMessage.value = props.flash.message;
            },
        });
    }
};

const getPaginationLabel = (label) => {
    // Handle special cases for prev/next arrows
    if (label === "&laquo; Previous") return "<<";
    if (label === "Next &raquo;") return ">>";
    return label;
};

// const search = ref(props.searchTerm);
const search = ref(props.searchTerm || "");

// Generate an array of years from 2020 to 2040
const years = Array.from({ length: 31 }, (_, i) => 2020 + i);
const exportStates = ["извозни", "домашни"];

const selectedYear = ref(""); // Year selected by the user
const selectedType = ref(""); // Document type selected by the user
// Client  selected by the user selectedExport
const selectedExport = ref("");

// Watch the selected year and type, and trigger re-fetch when either changes
watch(
    [selectedYear, selectedType, selectedExport],
    debounce((newValues) => {
        const [newYear, newType, newExport] = newValues;
        const companyId = props.company.id;
        // Trigger re-fetch of documents with the selected year and type
        router.get(
            `/companies/show/${companyId}`,
            {
                year: newYear,
                type: newType,
                export: newExport,
            },
            {
                preserveState: true,
            },
        );
    }, 200),
);

// CHARTS

// Register Chart.js components
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
);

// Compute dataset data
const datasetData = computed(() => {
  return years.map(year => {
    // Count documents of type "Invoice" for the specific year
    return props.documents.data.filter(
      document =>
        document.document_type?.type === "Invoice" &&
        new Date(document.date).getFullYear() === year
    ).length;
  });
});

// Define chart data
const chartData = ref({
  labels: years, // Use the years array for labels
  datasets: [
    {
      label: "Фактури на Годишно Ниво",
      data: datasetData.value,
      backgroundColor: "rgba(75, 192, 192, 0.6)", // Example bar color
      borderColor: "rgba(75, 192, 192, 1)", // Example border color
      borderWidth: 1
    }
  ]
});

// Chart options
const chartOptions = ref({
  responsive: true,
  scales: {
    y: {
      beginAtZero: true
    }
  }
});

// Computed property to format notes
const formattedNotes = computed(() => {
  return props.company.notes.replace(/\n/g, '<br>');
});
// const chartOptions = ref({
//     responsive: true,
// });
</script>

<template>
    <Head :title="company.name" />

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
                        <div
                            class="w-full p-4 border-t-4 border-emerald-600 rounded md:w-50 mb-4"
                        >
                            <div class="flex justify-between mb-4">
                                <h2 class="text-sky-800">Документи</h2>
                                <div class="flex gap-4">
                                    <!-- Export Selection Dropdown -->
                                    <select
                                        v-model="selectedExport"
                                        as="select"
                                        id="client"
                                        class="w-full h-10 px-8 mt-1 text-xs border rounded bg-gray-50"
                                    >
                                        <option value="" selected>
                                            Извоз...
                                        </option>
                                        <option
                                            v-for="exportState in exportStates"
                                            :key="exportState"
                                            :value="exportState"
                                        >
                                            {{ exportState }}
                                        </option>
                                    </select>

                                    <!-- Client Selection Dropdown -->
                                    <!-- <select
                                    v-model="selectedClient"
                                    as="select"
                                    id="client"
                                    class="w-full h-10 px-8 mt-1 text-xs border rounded bg-gray-50"
                                >
                                    <option value="" selected>Клиент...</option>
                                    <option
                                        v-for="client in clients"
                                        :key="client"
                                        :value="client.id"
                                    >
                                        {{ client.name }}
                                    </option>
                                </select> -->

                                    <!-- Year Selection Dropdown -->
                                    <select
                                        v-model="selectedYear"
                                        as="select"
                                        id="year"
                                        class="w-full h-10 px-8 mt-1 text-xs border rounded bg-gray-50"
                                    >
                                        <option value="" selected>
                                            Година...
                                        </option>
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
                                        class="h-10 px-8 mt-1 text-xs border rounded bg-gray-50 w-[150px]"
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
                                >
                                    <td class="text-xs text-slate-300">
                                        {{ document.id }} {{}}
                                    </td>
                                    <td class="">
                                        {{ documents.from + index }}
                                    </td>
                                    <td class="text-base font-semibold text-emerald-700">
                                        <Link :href="route('products.create', document.id)"
                                    class="hover:text-red-600">
                                        {{ document.document_no }}
                                    </Link>
                                    </td>
                                    <td class="flex text-base font-semibold">
                                        {{
                                            latinToCyrillic(
                                                document.document_type.type,
                                            )
                                        }}
                                        <span class="text-gray-400">
                                            {{
                                                document.is_for_export
                                                    ? "-за извоз"
                                                    : ""
                                            }}
                                        </span>
                                    </td>

                                    <td class="text-base font-semibold text-purple-600">
                                        {{
                                            new Date(
                                                document.date,
                                            ).toLocaleDateString("en-GB")
                                        }}
                                    </td>

                                    <td class="px-2 text-right">
                                        <span
                                        v-if="document.document_type.id !== 7"
                                            class="pr-2 text-base font-bold text-red-600"
                                        >
                                            {{
                                                new Intl.NumberFormat("en-US", {
                                                    minimumFractionDigits: 0,
                                                    maximumFractionDigits: 4,
                                                }).format(document.total_with_tax_and_discount)
                                            }}
                                        </span>
                                        <span 
                                        v-if="document.document_type.id !== 7"
                                         class="px-1 text-left">
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
                                            v-if="document.document_type.id == 7"
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
                                                        content: `Измени ${document.document_type.type}`,
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
                                                        content: `Измени ${document.document_type.type}`,
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
                                                        content:
                                                            'Избриши Банка',
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
                                                    :disabled="!document.desiredDocumentId"
                                                   
                                                        type="submit"
                                                    >
                                                        
                                                        <DocumentNewIcon  class="  hover:text-sky-800" />
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
                        <div
                            class="flex justify-between mb-4 border-t-4 border-emerald-600 mt-8 pt-4"
                        >
                            <h2 class="px-6 text-sky-800">
                                Детални информации
                            </h2>
                        </div>

                        <div class="flex flex-col gap-2 lg:flex-row">
                            <div
                                class="w-full p-4 border border-blue-500 rounded md:w-50"
                            >
                                <div>
                                    <div class="pb-2">
                                        <Link
                                            class="hover:text-green-600 text-slate-300"
                                            :href="
                                                route(
                                                    'company.edit',
                                                    company.id,
                                                )
                                            "
                                        >
                                            <EditIcon
                                                v-tippy="{
                                                    content: 'Измени',
                                                    arrow: true,
                                                    theme: 'light',
                                                }"
                                            />
                                        </Link>
                                    </div>
                                    <h2
                                        class="text-xl font-bold"
                                        v-if="company.name"
                                    >
                                        {{ company.name }}
                                    </h2>
                                    <p v-if="company.address">
                                        {{ company.address }}
                                    </p>
                                    <p v-if="company.place">
                                        {{ company.place.zip }} -
                                        {{ company.place.place }}
                                    </p>
                                    <p
                                        v-if="
                                            company.place &&
                                            company.place.country
                                        "
                                    >
                                        {{ company.place.country.name }}
                                    </p>
                                    <hr class="py-2" />
                                    <p v-if="company.tax_number">
                                        <span class="text-sm italic"
                                            >Даночен Бр : </span
                                        >{{ company.tax_number }}
                                    </p>
                                    <p v-if="company.reg_number">
                                        <span class="text-sm italic"
                                            >Рег Бр / ЕМБС : </span
                                        >{{ company.reg_number }}
                                    </p>
                                    <p v-if="company.web">
                                        <span class="text-sm italic"
                                            >Web :
                                        </span>
                                        <a
                                            :href="websiteDomain.href"
                                            target="_blank"
                                            class="text-sky-600"
                                        >
                                            {{ websiteDomain.href }}
                                        </a>
                                    </p>
                                    <p v-if="company.mobile">
                                        <span class="text-sm italic"
                                            >Мобилен :
                                        </span>
                                        {{ company.mobile }}
                                    </p>
                                    <p v-if="company.phone">
                                        <span class="text-sm italic"
                                            >Телефон :
                                        </span>
                                        {{ company.phone }}
                                    </p>

                                    <p v-if="company.email">
                                        <span class="text-sm italic"
                                            >Е-маил :
                                        </span>
                                        {{ company.email }}
                                    </p>

                                    <p class="text-sm italic"
                                    >забелешки :
                                </p>
                                <div v-if="company.notes" class="mb-2 text-xs text-purple-700 border border-purple-900 p-2 rounded-md">
    <div v-html="formattedNotes"></div>
  </div>
                                </div>
                                <hr class="my-4" />
                                <div
                                    class="flex items-center justify-between px-6 mb-4 bg-slate-100"
                                >
                                    <span class="text-lg font-bolder">
                                        Контакти
                                    </span>
                                    <div>
                                        <Link
                                            class="px-1 hover:text-orange-600 text-slate-300"
                                            :href="
                                                route(
                                                    'contacts.create',
                                                    company.id,
                                                )
                                            "
                                        >
                                            <AddContactIcon
                                                v-tippy="{
                                                    content: 'Додај Контакт',
                                                    arrow: true,
                                                    theme: 'light',
                                                }"
                                            />
                                        </Link>
                                    </div>
                                </div>
                                <div class="px-6">
                                    <!-- <hr class="my-4" /> -->
                                    <ul class="list-disc">
                                        <p
                                            class="text-red-500"
                                            v-if="companyContacts.length === 0"
                                        >
                                            Не се пронајдени контакти.
                                        </p>
                                        <li
                                            class="p-4 mb-6 hover:bg-slate-50"
                                            v-for="contact in companyContacts"
                                            :key="contact.id"
                                        >
                                            <div class="flex justify-between">
                                                <div>
                                                    <span class="font-bold"
                                                        >{{
                                                            contact.first_name
                                                        }}
                                                        {{
                                                            contact.last_name
                                                        }}</span
                                                    >

                                                    <span> - </span>
                                                    <span
                                                        class="text-teal-800"
                                                        >{{
                                                            contact.position
                                                        }}</span
                                                    >
                                                </div>
                                                <div
                                                    class="flex justify-end gap-2"
                                                >
                                                    <Link
                                                        class="hover:text-green-600 text-slate-300"
                                                        :href="
                                                            route(
                                                                'contact.edit',
                                                                contact.id,
                                                            )
                                                        "
                                                    >
                                                        <EditIcon
                                                            v-tippy="{
                                                                content:
                                                                    'Едитирај Контакт',
                                                                arrow: true,
                                                                theme: 'light',
                                                            }"
                                                        />
                                                    </Link>

                                                    <button
                                                        class="hover:text-red-700 text-slate-300"
                                                        @click="
                                                            () =>
                                                                deleteContact(
                                                                    contact.id,
                                                                )
                                                        "
                                                    >
                                                        <DeleteIcon
                                                            v-tippy="{
                                                                content:
                                                                    'Избриши Контакт',
                                                                arrow: true,
                                                                theme: 'light',
                                                            }"
                                                        />
                                                    </button>
                                                </div>
                                            </div>
                                            <p>
                                                <span class="text-xs italic"
                                                    >емаил: </span
                                                ><a
                                                    :href="`mailto:${contact.email}`"
                                                    ><span
                                                        class="text-sky-600"
                                                        >{{
                                                            contact.email
                                                        }}</span
                                                    ></a
                                                >
                                            </p>

                                            <p>
                                                <span class="text-xs italic"
                                                    >телефон: </span
                                                >{{ contact.phone }}
                                            </p>
                                            <p>
                                                <span class="text-xs italic"
                                                    >мобилен:
                                                </span>
                                                {{ contact.mob }}
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div
                                v-if="!company.is_customer"
                                class="w-full p-4 border border-blue-500 rounded md:w-50"
                            >
                                <Link
                                    class="hover:text-sky-600 text-slate-300"
                                    :href="route('account.create', company.id)"
                                >
                                    <AddAccountIcon
                                        v-tippy="{
                                            content:
                                                'Додај Нова Банкарска Сметка',
                                            arrow: true,
                                            theme: 'light',
                                        }"
                                    />
                                </Link>
                                <h2 class="mt-4 font-bold">Банкарски Сметки</h2>
                                <hr />
                                <!-- BANKARSKI SMETKI TABELA -->
                                <div
                                    class="container p-2 mx-auto sm:p-4 dark:text-gray-800"
                                >
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-xs">
                                            <colgroup>
                                                <col />
                                                <col />
                                                <col />
                                                <col class="w-24" />
                                            </colgroup>
                                            <thead class="dark:bg-gray-300">
                                                <tr class="text-left">
                                                    <th class="p-3">Банка</th>
                                                    <th class="p-3">Статус</th>
                                                    <th class="p-3">Тип</th>
                                                    <th class="p-3">Акција</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="account in company.accounts"
                                                    :key="account.id"
                                                    class="border-b border-opacity-20 dark:border-gray-300 dark:bg-gray-50"
                                                >
                                                    <td class="p-3">
                                                        <p
                                                            v-if="
                                                                account.is_for_export
                                                            "
                                                        >
                                                            {{
                                                                account.bank
                                                                    .name_lat
                                                            }}
                                                        </p>
                                                        <p v-else>
                                                            {{
                                                                account.bank
                                                                    .name_cyr
                                                            }}
                                                        </p>
                                                    </td>
                                                    <td class="p-3">
                                                        <div
                                                            class="inline-flex items-center gap-2"
                                                        >
                                                            <label
                                                                class="text-sm cursor-pointer text-slate-600"
                                                                >Неактивна</label
                                                            >

                                                            <div
                                                                class="relative inline-block h-5 w-11"
                                                            >
                                                                <input
                                                                    type="checkbox"
                                                                    :checked="
                                                                        account.is_active
                                                                    "
                                                                    @change="
                                                                        toggleActive(
                                                                            account.id,
                                                                        )
                                                                    "
                                                                    class="h-5 transition-colors duration-300 rounded-full appearance-none cursor-pointer peer w-11 bg-slate-100 checked:bg-emerald-700"
                                                                />
                                                                <label
                                                                    class="absolute top-0 left-0 w-5 h-5 transition-transform duration-300 bg-white border rounded-full shadow-sm cursor-pointer border-slate-300 peer-checked:translate-x-6 peer-checked:border-green-800"
                                                                ></label>
                                                            </div>

                                                            <label
                                                                :class="
                                                                    account.is_active
                                                                        ? ' text-green-600 font-bold'
                                                                        : ' text-slate-600'
                                                                "
                                                                class="text-sm cursor-pointer"
                                                                >Активна</label
                                                            >
                                                        </div>
                                                    </td>
                                                    <td class="p-3">
                                                        <p
                                                            class="dark:text-gray-600"
                                                            v-if="
                                                                account.is_for_export
                                                            "
                                                        >
                                                            Девизна (извоз)
                                                        </p>
                                                        <p
                                                            class="dark:text-gray-600"
                                                            v-else
                                                        >
                                                            Денарска
                                                        </p>
                                                    </td>

                                                    <td class="p-3 text-right">
                                                        <div class="flex gap-2">
                                                            <Link
                                                                class="hover:text-green-600 text-slate-300"
                                                                :href="
                                                                    route(
                                                                        'account.edit',
                                                                        account.id,
                                                                    )
                                                                "
                                                            >
                                                                <EditIcon
                                                                    v-tippy="{
                                                                        content:
                                                                            'Измени',
                                                                        arrow: true,
                                                                        theme: 'light',
                                                                    }"
                                                                />
                                                            </Link>
                                                            <!-- //Delete -->
                                                            <button
                                                                class="hover:text-red-700 text-slate-300"
                                                                @click="
                                                                    () =>
                                                                        deleteAccount(
                                                                            account.id,
                                                                        )
                                                                "
                                                            >
                                                                <DeleteIcon
                                                                    v-tippy="{
                                                                        content:
                                                                            'Избриши Сметка',
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
                                </div>
                            </div>
                            <div
                                v-if="company.is_customer"
                                class="w-full p-4 border border-blue-500 rounded md:w-50"
                            >
                                <h2 class="mt-4 font-bold">Анализи</h2>
                                <hr />
                                <!-- Analizi -->
                                <div
                                    class="container p-2 mx-auto sm:p-4 dark:text-gray-800"
                                >
                                    <div class="overflow-x-auto">
                                        <Bar
                                            id="my-chart-id"
                                            :options="chartOptions"
                                            :data="chartData"
                                        />
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
