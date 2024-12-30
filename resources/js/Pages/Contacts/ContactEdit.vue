<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { reactive } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

const auth = usePage().props.auth;

const props = defineProps({
    contact: {
        type: Object,
        required: true,
    },
});

// Accessing the place and country data
// const place = props.company.place;
// const country = place ? place.country : null; // Ensure place exists before accessing country

const form = useForm({
    id: props.contact.id,
    company_id: props.contact.company_id,
    first_name: props.contact.first_name,
    last_name: props.contact.last_name,
    phone: props.contact.phone,
    mob: props.contact.mob,
    email: props.contact.email,
    position: props.contact.position,
});

const submit = () => {
    console.log(form);
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="form.put('/contact/update/' + form.id, {
                            onError: () => form.reset()
                        })">
                            <div
                                class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8"
                            >
                                <div
                                    class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3"
                                >
                                    <div class="text-gray-600">
                                        <p class="text-lg font-medium">
                                            Ажурирај Контакт
                                        </p>
                                        <p>Ажурирај контакт информации</p>
                                        <div
                                            class="p-3 mt-4 "
                                        >
                                            <h3 class="py-2 text-lg font-bold">
                                                {{ props.contact.company.name }}
                                            </h3>
                                            <img
                                                v-if="props.contact.company.logo"
                                                :src="`/storage/${props.contact.company.logo}`"
                                                alt="Company Logo"
                                                class="object-contain w-40 h-20 border border-gray-100 rounded-lg"
                                            />
                                            <p class="mt-2">
                                                {{ props.contact.company.address }}
                                            </p>
                                            <p class="mt-2">
                                                {{ props.contact.company.place.zip }} -
                                                {{ props.contact.company.place.place }}
                                            </p>
                                            <p class="mt-2">
                                                {{ props.contact.company.place.country.name }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                        >
                                            <div class="md:col-span-3">
                                                <InputLabel for="first_name"
                                                    >Име</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.first_name"
                                                    type="text"
                                                    id="first_name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.first_name
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="last_name"
                                                    >Презиме</InputLabel
                                                >
                                                <TextInput
                                                    v-model="form.last_name"
                                                    type="text"
                                                    id="last_name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.last_name
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="phone"
                                                    >Телефон</InputLabel
                                                >
                                                <TextInput
                                                    v-model="form.phone"
                                                    type="text"
                                                    id="phone"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.phone
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="mob"
                                                    >Мобилен</InputLabel
                                                >
                                                <TextInput
                                                    v-model="form.mob"
                                                    type="text"
                                                    id="mob"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.mob
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="email"
                                                    >Емаил</InputLabel
                                                >
                                                <TextInput
                                                    v-model="form.email"
                                                    type="email"
                                                    id="email"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.email
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="position"
                                                    >Позиција</InputLabel
                                                >
                                                <TextInput
                                                    v-model="form.position"
                                                    type="text"
                                                    id="position"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.position
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
