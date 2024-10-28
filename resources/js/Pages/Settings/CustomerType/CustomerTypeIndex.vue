<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import TextInput from "../../../Components/TextInput.vue";
import SecondaryButton from "../../../Components/SecondaryButton.vue";
import { computed, ref, watch, onMounted } from "vue";
import { debounce } from "lodash";

const props = defineProps({
    customer_types: Object,
});

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");


// Delete country function
const deleteCUstomerType = (id) => {
    if (confirm("Дали сигурно сакаш да го избришеш типот на коминтент?")) {
        router.delete("/customertype/delete/" + id, {
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
</script>

<template>
    <Head title="Customer Type" />

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
                            <h2 class="font-bold text-sky-800">Тип на Коминтенти</h2>
                            <div class="flex ">

                                <Link
                                href="customertype/add"
                                class="px-4 py-1 mr-10 text-3xl rounded-lg hover:bg-sky-400 bg-sky-200"
                                >+</Link
                                >

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
                                    Тип на Коминтент
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
                                    v-for="(type, index) in customer_types.data"
                                    :key="type.id"
                                >
                                    <td class="text-xs text-slate-300">{{ type.id }}</td>
                                    <td class="">{{ customer_types.from + index }}</td>
                                    <td class="">{{ type.type }}</td>

                                    <td class="">
                                        <div class="flex gap-2">
                                            <Link
                                                class="px-2 py-1 text-xs font-bold text-white uppercase rounded-md bg-emerald-600 hover:bg-emerald-700"
                                                :href="
                                                    route(
                                                        'customertype.edit',
                                                        type.id
                                                    )
                                                "
                                                >Измени</Link
                                            >

                                            <button
                                                class="px-2 py-1 text-xs font-bold text-white uppercase bg-red-600 rounded-md hover:bg-red-700"
                                                @click="
                                                    () =>
                                                    deleteCUstomerType(
                                                            type.id
                                                        )
                                                "
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div
                            v-if="customer_types && customer_types.links"
                            class="flex flex-col lg:flex-row lg:justify-around"
                        >
                            <div class="mt-2">
                                <Link
                                    v-for="link in customer_types.links"
                                    :key="link.label"
                                    v-html="link.label"
                                    v-bind="{ href: link.url || '#' }"
                                    class="p-1 mx-1 hover:bg-sky-200"
                                    :class="{
                                        'text-slate-300': !link.url,
                                        'text-sky-500 font-bold': link.active,
                                    }"
                                >
                                </Link>
                            </div>

                            <p class="mt-3 text-xs text-gray-500">
                                Прикажани се од {{ customer_types.from }} до
                                {{ customer_types.to }} од вкупно
                                {{ customer_types.total }} записи
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
