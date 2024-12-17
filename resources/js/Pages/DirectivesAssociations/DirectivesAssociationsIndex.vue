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
    categoryDirectivesAndRegulations: Array,
});

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

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

console.log(props.categoryDirectivesAndRegulations);
</script>

<template>
    <Head title="EU regulatives and Directives" />

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
                                ЕУ регулативи и Директиви
                            </h2>
                            <!-- <div class="flex">
                                <Link
                                    href="banks/add"
                                    class="mx-4 mt-2 text-5xl hover:text-sky-500 text-slate-500"
                                    ><AddIcon
                                /></Link>
                                <TextInput
                                    placeholder="Барај ..."
                                    v-model="search"
                                    type="search"
                                />
                            </div> -->
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
                                        Категорија
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Регулативи
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Директиви
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
                                    v-for="(
                                        categoryDirectivesAndRegulation
                                    ) in categoryDirectivesAndRegulations"
                                    :key="categoryDirectivesAndRegulation.id"
                                >
                                    <td class="text-xs text-slate-300">
                                        {{
                                            categoryDirectivesAndRegulation.id
                                        }}
                                        {{}}
                                    </td>

                                    <td class="">
                                        {{
                                            categoryDirectivesAndRegulation.name
                                        }}
                                    </td>
                                    <td>
                                        <li
                                            v-for="regulation in categoryDirectivesAndRegulation.regulations"
                                            :key="regulation.id"
                                            class="text-xs"
                                            v-tippy="{
                                                content: regulation.description,
                                                arrow: true,
                                                theme: 'light',
                                            }"
                                        >
                                            {{ regulation.regulation }}
                                        </li>
                                    </td>

                                    <td class="">
                                        <li
                                            v-for="directives in categoryDirectivesAndRegulation.directives"
                                            :key="directives.id"
                                            class="text-xs"
                                            v-tippy="{
                                                content: directives.description,
                                                arrow: true,
                                                theme: 'light',
                                            }"
                                        >
                                            {{ directives.directive }}
                                        </li>
                                    </td>

                                    <td class="">
                                        <div class="flex gap-2">
                                            <Link
                                                class="hover:text-green-600 text-slate-300"
                                                :href="route('categoryDirectivesAndRegulations.edit', { category: categoryDirectivesAndRegulation.id })"
                                            >
                                            
                                                <EditIcon
                                                    v-tippy="{
                                                        content:
                                                            'Измени Категорија',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"
                                                />
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
