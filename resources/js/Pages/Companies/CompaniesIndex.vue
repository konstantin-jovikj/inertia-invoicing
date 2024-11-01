<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import EditIcon from "../../Components/EditIcon.vue";
import DeleteIcon from "../../Components/DeleteIcon.vue";
import ViewIcon from "../../Components/ViewIcon.vue";
import AddIcon from "../../Components/AddIcon.vue";
import AddContactIcon from "@/Components/AddContactIcon.vue";
import ImageIcon from "@/Components/ImageIcon.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import { computed, ref, watch, onMounted } from "vue";
import { debounce } from "lodash";
import { Tippy } from "vue-tippy";

const props = defineProps({
    companies: Object,
    searchTerm: String,
});

const search = ref(props.searchTerm || "");
const { url } = usePage(); // Get the current URL directly from usePage()
const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

// Computed property to check if the current URL is '/companies'
const isCompaniesIndex = computed(() => {
    return url === "/companies"; // Returns true only if the URL is exactly '/companies'
});
console.log("PageProps URL", url);

// Watch for changes in search input
watch(
    search,
    debounce((query) => {
        router.get(
            "/companies",
            {
                search: query,
            },
            {
                preserveState: true,
            }
        );
    }, 500)
);

// Delete place function
const deleteCompany = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш оваа копанија?")) {
        router.delete("/companies/delete/" + id, {
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
    <Head title="Companies" />

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
                            <h2 class="font-bold text-sky-800">
                                Компании / Фирми
                            </h2>
                            <div class="flex">
                                <Link
                                    v-if="isCompaniesIndex"
                                    href="customers/add"
                                    class="mx-4 mt-2 text-5xl hover:text-sky-500 text-slate-500"
                                    ><AddIcon
                                /></Link>

                                <Link
                                    v-else
                                    href="add"
                                    class="mx-4 mt-2 text-5xl hover:text-sky-500 text-slate-500"
                                    ><AddIcon
                                /></Link>
                                <TextInput
                                    placeholder="Барај ..."
                                    v-model="search"
                                    type="search"
                                />
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
                                        Id
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
                                        Име / Назив
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Место
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Акција
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    class="hover:bg-slate-100"
                                    v-for="(company, index) in companies.data"
                                    :key="company.id"
                                >
                                    <td class="text-xs text-slate-300">
                                        {{ company.id }}
                                    </td>
                                    <td class="">
                                        {{ companies.from + index }}
                                    </td>
                                    <td class="">{{ company.name }}</td>
                                    <td class="">
                                        {{ company.place.place }}
                                        <span class="mx-4">-</span>
                                        <span class="">{{
                                            company.place.country.name
                                        }}</span>
                                    </td>
                                    <td class="">
                                        <div class="flex gap-2">
                                            <Link
                                                class="px-4 hover:text-orange-600 text-slate-300"
                                                :href="
                                                    route(
                                                        'contacts.create',
                                                        company.id
                                                    )
                                                "
                                            >
                                                <AddContactIcon
                                                    v-tippy="{
                                                        content:
                                                            'Додај Контакт',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"
                                                />
                                            </Link>

                                            <Link
                                                class="hover:text-sky-600 text-slate-300"
                                                :href="
                                                    route(
                                                        'company.show',
                                                        company.id
                                                    )
                                                "
                                            >
                                                <ViewIcon v-tippy="{
                                                        content:
                                                            'Детален Преглед',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }" />
                                            </Link>

                                            <Link
                                                class="hover:text-green-600 text-slate-300"
                                                :href="
                                                    route(
                                                        'company.edit',
                                                        company.id
                                                    )
                                                "
                                            >
                                                <EditIcon v-tippy="{
                                                        content:
                                                            'Измени',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"/>
                                            </Link>

                                            <Link
                                                class="hover:text-pink-400 text-slate-300"
                                                :href="
                                                    route(
                                                        'company.logo.edit',
                                                        company.id
                                                    )
                                                "
                                            >
                                                <ImageIcon v-tippy="{
                                                        content:
                                                            'Измени Лого',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"/>
                                            </Link>

                                            <button
                                                class="hover:text-red-700 text-slate-300"
                                                @click="
                                                    () =>
                                                        deleteCompany(company.id)
                                                "
                                            >
                                                <DeleteIcon v-tippy="{
                                                        content:
                                                            'Избриши',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"/>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div
                            v-if="companies && companies.links"
                            class="flex flex-col lg:flex-row lg:justify-around"
                        >
                            <div class="mt-2">
                                <Link
                                    v-for="link in companies.links"
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
                                Прикажани се од {{ companies.from }} до
                                {{ companies.to }} од вкупно
                                {{ companies.total }} записи
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
