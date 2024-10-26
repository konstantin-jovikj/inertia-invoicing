<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { useForm } from "@inertiajs/vue3";
import { toRefs } from "vue";

// Define `country` as a prop
const props = defineProps({
    country: {
        type: Object,
        required: true,
    },
});

// Extract `country` for reactivity
const { country } = toRefs(props);

// Initialize `form` with the values from `country`
const form = useForm({
    name: country.value.name,
    code: country.value.code,
    id: country.value.id,
});

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
                                form.put(`/countries/update/${country}`, {
                                    onError: () => form.reset(),
                                })
                            "
                        >
                            <div>
                                <InputLabel for="name">Име</InputLabel>
                                <TextInput
                                    v-model="form.name"
                                    type="text"
                                    id="name"
                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                />
                                <span class="text-xs italic text-red-600">{{
                                    form.errors.name
                                }}</span>
                            </div>

                            <div>
                                <InputLabel for="code">Код</InputLabel>
                                <TextInput
                                    v-model="form.code"
                                    type="text"
                                    id="code"
                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                />
                                <span class="text-xs italic text-red-600">{{
                                    form.errors.code
                                }}</span>
                            </div>

                            <button
                                type="submit"
                                class="px-4 py-2 font-bold text-white rounded bg-sky-500 hover:bg-sky-700"
                            >
                                Додај
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
