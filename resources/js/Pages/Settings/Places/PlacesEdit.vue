<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "../../../Components/TextInput.vue";
import InputLabel from "../../../Components/InputLabel.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { toRefs } from "vue";

// Define `country` as a prop
const props = defineProps({
    place: {
        type: Object,
        required: true,
    },
    countries: {
        type: Array,
        required: true,
    },
});

// Extract `country` for reactivity
const { place } = toRefs(props);

// Initialize `form` with the values from `country`
const form = useForm({
    place: place.value.place,
    zip: place.value.zip,
    id: place.value.id,
    country_id: place.value.country_id,
});

console.log("Place:", place);

const submit = () => {
    console.log("Form data:", form);
    // Handle form submission logic here
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form
                            @submit.prevent="
                                form.put('/places/update/' + form.id, {
                                    onError: () => form.reset(),
                                })
                            "
                        >
                            <div
                                class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8"
                            >
                                <div
                                    class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3"
                                >
                                    <div class="text-gray-600">
                                        <p class="text-lg font-medium">
                                            Едитирај го Градот / Местото
                                        </p>
                                        <p>
                                            Едитирај го името и / или кодот на
                                            Градот / Местото
                                        </p>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-5"
                                        >
                                            <div class="md:col-span-5">
                                                <InputLabel for="country"
                                                    >Одбери Држава</InputLabel
                                                >
                                                <select
                                                    v-model="form.country_id"
                                                    id="country"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Избери држава
                                                    </option>
                                                    <option
                                                        v-for="country in countries"
                                                        :key="country.id"
                                                        :value="country.id"
                                                    >
                                                        {{ country.name }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.name
                                                    }}</span
                                                >
                                            </div>

                                            <div
                                                class="md:col-span-3"
                                                v-if="form.country_id"
                                            >
                                                <InputLabel for="name"
                                                    >Име</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.place"
                                                    type="text"
                                                    id="name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.place
                                                    }}</span
                                                >
                                            </div>

                                            <div
                                                class="md:col-span-2"
                                                v-if="form.country_id"
                                            >
                                                <InputLabel for="code"
                                                    >Код</InputLabel
                                                >
                                                <TextInput
                                                    v-model="form.zip"
                                                    type="text"
                                                    id="code"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{ form.errors.zip }}</span
                                                >
                                            </div>

                                            <div
                                                class="flex justify-between text-right md:col-span-5"
                                            >
                                                <Link
                                                    :href="route('place.index')"
                                                     class="px-4 py-2 mt-4 font-bold text-white rounded bg-slate-500 hover:bg-slate-700"
                                                    >Назад</Link
                                                >
                                                <div
                                                    class="inline-flex items-end"
                                                >
                                                    <button
                                                        type="submit"
                                                        class="px-4 py-2 mt-4 font-bold text-white rounded bg-sky-500 hover:bg-sky-700"
                                                    >
                                                        Измени
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
