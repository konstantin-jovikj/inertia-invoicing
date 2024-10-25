<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import { computed, ref, watch } from "vue";
import { debounce } from "lodash";
// import { defineProps } from "vue";

// import { onMounted } from "vue";

// onMounted(() => {
//     console.log("countries.current_page:", countries.current_page);
//     console.log("countries.per_page:", countries.per_page);
// });

const props = defineProps({
    countries: Object,
    searchTerm: String
});
// const search = ref(props.searchTerm);
const search = ref(props.searchTerm || "");

watch(
    search,
    debounce(
        (query) =>
            router.get(
                "/countries",
                {
                    search: query,
                },
                {
                    preserveState: true,
                }
            ),
        500
    )
);



</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-end mb-4">
                            <TextInput
                                placeholder="Барај ..."
                                v-model="search"
                                type="search"
                            />
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
                                        Бр
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Име
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Ознака
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
                                    v-for="country in countries.data"
                                    :key="country.id"
                                >
                                    <td class=""> {{  country.id }}</td>
                                    <td class="">{{ country.name }}</td>
                                    <td class="">{{ country.code }}</td>
                                    <td class="">button</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div v-if="countries && countries.links">
                            <Link
                                v-for="link in countries.links"
                                :key="link.label"
                                v-html="link.label"
                                 v-bind="{ href: link.url || '#' }"
                                class="p-1 mx-1"
                                :class="{
                                    'text-slate-300': !link.url,
                                    'text-sky-500 font-bold': link.active,
                                }"
                            >
                            </Link>

                            <p>
                                Прикажани се од {{ countries.from }} до
                                {{ countries.to }} од вкупно
                                {{ countries.total }} записи
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
