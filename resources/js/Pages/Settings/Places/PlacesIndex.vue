<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import TextInput from "../../../Components/TextInput.vue";
import SecondaryButton from "../../../Components/SecondaryButton.vue";
import { computed, ref, watch, onMounted } from "vue";
import { debounce } from "lodash";

const props = defineProps({
    places: Object,
    searchTerm: String,
});
// const search = ref(props.searchTerm);
const search = ref(props.searchTerm || "");
const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

watch(
    search,
    debounce(
        (query) =>
            router.get(
                "/places",
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

// Delete country function
const deletePlace = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш оваместо?")) {
        router.delete("/places/delete/" + id, {
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
    <Head title="Places" />

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
                            <h2 class="font-bold text-sky-800">Градови / Места</h2>
                            <div class="flex ">

                                <Link
                                href="places/add"
                                class="px-4 py-1 mr-10 text-3xl rounded-lg hover:bg-sky-400 bg-sky-200"
                                >+</Link
                                >
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
                                        Zip
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
                                    v-for="(place, index) in places.data"
                                    :key="place.id"
                                >
                                <td class="text-xs text-slate-300">{{ place.id }}</td>
                                    <td class="">{{ places.from + index }}</td>
                                    <td class="">{{ place.zip }}</td>
                                    <td class="">{{ place.place }} <span class="mx-4">-</span> <span class="text-xs italic text-slate-500">{{ place.country.name }}</span></td>
                                    <td class="">
                                        <div class="flex gap-2">
                                            <Link
                                                class="px-2 py-1 text-xs font-bold text-white uppercase rounded-md bg-emerald-600 hover:bg-emerald-700"
                                                :href="
                                                    route(
                                                        'place.edit',
                                                        place.id
                                                    )
                                                "
                                                >Измени</Link
                                            >

                                            <button
                                                class="px-2 py-1 text-xs font-bold text-white uppercase bg-red-600 rounded-md hover:bg-red-700"
                                                @click="
                                                    () =>
                                                        deletePlace(
                                                            place.id
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
                            v-if="places && places.links"
                            class="flex flex-col lg:flex-row lg:justify-around"
                        >
                            <div class="mt-2">

                                <Link
                                    v-for="link in places.links"
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
                                Прикажани се од {{ places.from }} до
                                {{ places.to }} од вкупно
                                {{ places.total }} записи
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
