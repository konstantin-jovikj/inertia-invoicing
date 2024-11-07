<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "../../../Components/TextInput.vue";
import InputLabel from "../../../Components/InputLabel.vue";
import { useForm } from "@inertiajs/vue3";



const props = defineProps({
    driver: {
        type: Object,
        required: true,
    },
});


// Initialize form with tax_rate as an empty string
const form = useForm({
    name: props.driver.name || '',
    surname: props.driver.surname || '',
    licence_no: props.driver.licence_no || '',
    personal_id_no: props.driver.personal_id_no || ''
});

const submit = () => {
    console.log(form);
};
</script>

<template>
    <Head title="Taxes" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form
                            @submit.prevent="
                                form.put('/drivers/update/' + driver.id, {
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
                                            Едитирај Возач
                                        </p>
                                        <p>Едитирај ги податоците за Возачот</p>
                                    </div>
                                    <div class="lg:col-span-2">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                        >
                                            <div class="md:col-span-3">
                                                <InputLabel for="name"
                                                    >Име</InputLabel
                                                >
                                                <TextInput
                                                    id="name"
                                                    v-model="form.name"
                                                    type="text"
                                                    class="block w-full mt-1"
                                                    autocomplete="off"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.name
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="surname"
                                                    >Презиме</InputLabel
                                                >
                                                <TextInput
                                                    id="surname"
                                                    v-model="form.surname"
                                                    type="text"
                                                    class="block w-full mt-1"
                                                    autocomplete="off"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.surname
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="licence_no"
                                                    >Број на Возачка Дозвола</InputLabel
                                                >
                                                <TextInput
                                                    id="licence_no"
                                                    v-model="form.licence_no"
                                                    type="text"
                                                    class="block w-full mt-1"
                                                    autocomplete="off"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.licence_no
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="personal_id_no"
                                                    >Број на Лична Карта</InputLabel
                                                >
                                                <TextInput
                                                    id="personal_id_no"
                                                    v-model="form.personal_id_no"
                                                    type="text"
                                                    class="block w-full mt-1"
                                                    autocomplete="off"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.personal_id_no
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
                                                        Ажурирај
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
