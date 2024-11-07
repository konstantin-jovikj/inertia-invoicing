<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "../../../Components/TextInput.vue";
import InputLabel from "../../../Components/InputLabel.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { throttle } from "lodash";


const props = defineProps({
    vehicle: {
        type: Object,
        required: true,
    },
});
// Initialize form with tax_rate as an empty string
const form = useForm({
    model: props.vehicle.model || '',
    type: props.vehicle.type || '',
    register_plate_number: props.vehicle.register_plate_number || '',
    max_weight_loaded: props.vehicle.max_weight_loaded || '',
    max_weight_empty: props.vehicle.max_weight_empty || '',
    payload: props.vehicle.payload || '',
});

const submit = () => {
    console.log(form);
};
</script>

<template>
    <Head title="Vehicles" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form
                            @submit.prevent="
                                form.put('/vehicles/update/' + vehicle.id, {
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
                                            Додај Ново Возило
                                        </p>
                                        <p>Внеси податоци за Возилото</p>
                                    </div>
                                    <div class="lg:col-span-2">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                        >
                                            <div class="md:col-span-2">
                                                <InputLabel for="model"
                                                    >Модел</InputLabel
                                                >
                                                <TextInput
                                                    id="model"
                                                    v-model="form.model"
                                                    type="text"
                                                    class="block w-full mt-1"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.model
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-2">
                                                <InputLabel for="type"
                                                    >Тип</InputLabel
                                                >
                                                <TextInput
                                                    id="type"
                                                    v-model="form.type"
                                                    type="text"
                                                    class="block w-full mt-1"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.type
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-2">
                                                <InputLabel for="register_plate_number"
                                                    >Број на Регистерски Таблици</InputLabel
                                                >
                                                <TextInput
                                                    id="register_plate_number"
                                                    v-model="form.register_plate_number"
                                                    type="text"
                                                    class="block w-full mt-1"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.register_plate_number
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-2">
                                                <InputLabel for="max_weight_loaded"
                                                    >Макс. Маса на Товарено Возило</InputLabel
                                                >
                                                <TextInput
                                                    id="max_weight_loaded"
                                                    v-model="form.max_weight_loaded"
                                                    type="number"
                                                    class="block w-full mt-1"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.max_weight_loaded
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-2">
                                                <InputLabel for="max_weight_empty"
                                                    >Макс. Маса на Празно Возило</InputLabel
                                                >
                                                <TextInput
                                                    id="max_weight_empty"
                                                    v-model="form.max_weight_empty"
                                                    type="number"
                                                    class="block w-full mt-1"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.max_weight_empty
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-2">
                                                <InputLabel for="payload"
                                                    >Носивост</InputLabel
                                                >
                                                <TextInput
                                                    id="payload"
                                                    v-model="form.payload"
                                                    type="number"
                                                    class="block w-full mt-1"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.payload
                                                    }}</span
                                                >
                                            </div>

                                            <div
                                                class="text-right md:col-span-5"
                                            >
                                                <div
                                                    class="inline-flex items-end"
                                                >
                                                    <button
                                                        type="submit"
                                                        class="px-4 py-2 font-bold text-white rounded bg-sky-500 hover:bg-sky-700"
                                                    >
                                                        Додај
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
