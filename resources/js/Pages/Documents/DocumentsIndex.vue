<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import { computed, ref, watch, onMounted } from "vue";
import { debounce } from "lodash";
import EditIcon from "../../Components/EditIcon.vue";
import DeleteIcon from "../../Components/DeleteIcon.vue";
import AddIcon from "../../Components/AddIcon.vue";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";

const props = defineProps({
    documents: Object,
    documentTypes: Array,
    searchTerm: String,
    clients: Array,
});
// const search = ref(props.searchTerm);
const search = ref(props.searchTerm || "");
const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

// Generate an array of years from 2000 to 2050
const years = Array.from({ length: 51 }, (_, i) => 2000 + i);

const selectedYear = ref(""); // Year selected by the user
const selectedType = ref(""); // Document type selected by the user
const selectedClient = ref(""); // Client  selected by the user

// Watch the selected year and type, and trigger re-fetch when either changes
watch(
    [selectedYear, selectedType, selectedClient],
    debounce((newValues) => {
        const [newYear, newType, newClient] = newValues;

        // Trigger re-fetch of documents with the selected year and type
        router.get(
            "/documents",
            {
                year: newYear,
                type: newType,
                client: newClient,
            },
            {
                preserveState: true,
            },
        );
    }, 500),
);

// Delete bank function
const deleteBank = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш оваа банка?")) {
        router.delete("/bank/delete/" + id, {
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
                            <div class="flex gap-2">
                                <!-- <Link
                                    href="banks/add"
                                    class="mx-4 mt-2 text-5xl hover:text-sky-500 text-slate-500"
                                    ><AddIcon
                                /></Link>
                                <TextInput
                                    placeholder="Барај ..."
                                    v-model="search"
                                    type="search"
                                /> -->

                                <!-- Client Selection Dropdown -->
                                <select
                                    v-model="selectedClient"
                                    as="select"
                                    id="client"
                                    class="w-full h-10 px-8 mt-1 text-xs border rounded bg-gray-50"
                                >
                                    <option value=""  selected>
                                        Клиент...
                                    </option>
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
                                    class=" h-10 px-8 mt-1 text-xs border rounded bg-gray-50 w-[150px]"
                                >
                                    <option value=""  selected>
                                        Тип на Документ...
                                    </option>
                                    <option
                                        v-for="type in documentTypes"
                                        :key="type.id"
                                        :value="type.id"
                                    >
                                        {{ type.type }}
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
                                >
                                    <td class="text-xs text-slate-300">
                                        {{ document.id }} {{}}
                                    </td>
                                    <td class="">
                                        {{ documents.from + index }}
                                    </td>
                                    <td class="">
                                        {{ document.document_no }}
                                    </td>
                                    <td class="">
                                        {{ document.document_type.type }}
                                        <span class="text-red-600">
                                            {{
                                                document.is_for_export
                                                    ? "-за извоз"
                                                    : ""
                                            }}
                                        </span>
                                    </td>
                                    <td class="">
                                        {{ document.company.name }}
                                    </td>
                                    <td class="">
                                        {{
                                            new Date(
                                                document.date,
                                            ).toLocaleDateString("en-GB")
                                        }}
                                    </td>

                                    <td class="px-8 text-right">
                                        <span class="pr-8">
                                            {{
                                                new Intl.NumberFormat("en-US", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2,
                                                }).format(document.total)
                                            }}
                                        </span>
                                        <span class="px-2">
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
                                                class="hover:text-green-600 text-slate-300"
                                                :href="
                                                    route(
                                                        'bank.edit',
                                                        document.id,
                                                    )
                                                "
                                            >
                                                <EditIcon
                                                    v-tippy="{
                                                        content: 'Измени Банка',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"
                                                />
                                            </Link>

                                            <button
                                                class="hover:text-red-700 text-slate-300"
                                                @click="
                                                    () =>
                                                        deleteBank(document.id)
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
