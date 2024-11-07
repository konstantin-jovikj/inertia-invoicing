<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import { computed, ref, watch, onMounted } from "vue";
import { debounce } from "lodash";
import EditIcon from "../../Components/EditIcon.vue";
import DeleteIcon from "../../Components/DeleteIcon.vue";
import AddIcon from "../../Components/AddIcon.vue";

const props = defineProps({
    taxes: Object,
});
// const search = ref(props.searchTerm);

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

// Delete bank function
const deleteTax = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш оваа ДДВ Ставка?")) {
        router.delete("/taxes/delete/" + id, {
            preserveState: false,
            onSuccess: () => {
                flashMessage.value = pageProps.flash?.message || ""; // Use pageProps.flash
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
    <Head title="Tax" />

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
                            <h2 class="font-bold text-sky-800">ДДВ Ставки</h2>
                            <div class="flex">
                                <Link
                                    v-tippy="{
                                        content: 'Додај Нова ДДВ Ставка',
                                        arrow: true,
                                        theme: 'light',
                                    }"
                                    href="taxes/add"
                                    class="mx-4 mt-2 text-5xl hover:text-sky-500 text-slate-500"
                                    ><AddIcon
                                /></Link>
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
                                        Стапка на ДДВ
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
                                    v-for="(tax, index) in taxes.data"
                                    :key="tax.id"
                                >
                                    <td class="text-xs text-slate-300">
                                        {{ tax.id }} {{}}
                                    </td>
                                    <td class="">
                                        {{ taxes.from + index }} {{}}
                                    </td>
                                    <td class="">{{ tax.tax_rate }} %</td>

                                    <td class="">
                                        <div class="flex gap-2">


                                            <button
                                                class="hover:text-red-700 text-slate-300"
                                                @click="
                                                    () => deleteTax(tax.id)
                                                "
                                            >
                                                <DeleteIcon
                                                    v-tippy="{
                                                        content:
                                                            'Избриши ДДВ Ставка',
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
                            v-if="taxes && taxes.links"
                            class="flex flex-col lg:flex-row lg:justify-around"
                        >
                            <div class="mt-2">
                                <Link
                                    v-for="link in taxes.links"
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
                                Прикажани се од {{ taxes.from }} до
                                {{ taxes.to }} од вкупно
                                {{ taxes.total }} записи
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
