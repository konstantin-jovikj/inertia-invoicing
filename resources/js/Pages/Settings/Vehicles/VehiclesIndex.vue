<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";

import { computed, ref, watch, onMounted } from "vue";
import { debounce } from "lodash";
import EditIcon from "../../../Components/EditIcon.vue";
import DeleteIcon from "../../../Components/DeleteIcon.vue";
import AddIcon from "../../../Components/AddIcon.vue";

const props = defineProps({
    vehicles: Object,
});
// const search = ref(props.searchTerm);

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

// Delete bank function
const deleteVehicle = (id) => {
    if (confirm("Дали сигурно сакаш да го избришеш ова Возило?")) {
        router.delete("/vehicles/delete/" + id, {
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
    <Head title="Vehicles" />

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
                            <h2 class="font-bold text-sky-800">Возила</h2>
                            <div class="flex">
                                <Link
                                    v-tippy="{
                                        content: 'Додај Ново Возило',
                                        arrow: true,
                                        theme: 'light',
                                    }"
                                    href="vehicles/add"
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
                                        Модел
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Тип
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Број на Рег. Таблици
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Макс маса на товарено возило
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Макс маса на празно возило
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Макс Товар
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
                                    v-for="(vehicle, index) in vehicles.data"
                                    :key="vehicle.id"
                                >
                                    <td class="text-xs text-slate-300">
                                        {{ vehicle.id }} {{}}
                                    </td>
                                    <td class="">
                                        {{ vehicles.from + index }} {{}}
                                    </td>
                                    <td class="">{{ vehicle.model }}</td>
                                    <td class="">{{ vehicle.type }}</td>
                                    <td class="">{{ vehicle.register_plate_number }}</td>
                                    <td class="">{{ vehicle.max_weight_loaded }}</td>
                                    <td class="">{{ vehicle.max_weight_empty }}</td>
                                    <td class="">{{ vehicle.payload }}</td>

                                    <td class="">
                                        <div class="flex gap-2">

                                            <Link
                                                class="hover:text-green-600 text-slate-300"
                                                :href="
                                                    route(
                                                        'vehicles.edit',
                                                        vehicle.id
                                                    )
                                                "
                                            >
                                                <EditIcon v-tippy="{
                                                        content:
                                                            'Измени Возило',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"/>
                                            </Link>

                                            <button
                                                class="hover:text-red-700 text-slate-300"
                                                @click="
                                                    () => deleteVehicle(vehicle.id)
                                                "
                                            >
                                                <DeleteIcon
                                                    v-tippy="{
                                                        content:
                                                            'Избриши Возило',
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
                            v-if="vehicles && vehicles.links"
                            class="flex flex-col lg:flex-row lg:justify-around"
                        >
                            <div class="mt-2">
                                <Link
                                    v-for="link in vehicles.links"
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
                                Прикажани се од {{ vehicles.from }} до
                                {{ vehicles.to }} од вкупно
                                {{ vehicles.total }} записи
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
