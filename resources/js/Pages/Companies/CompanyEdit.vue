<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import UploadFileIcon from "@/Components/UploadFileIcon.vue";
import { reactive, ref, toRefs } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

const auth = usePage().props.auth;

const props = defineProps({
    company: {
        type: Object,
        required: true,
    },
    places: {
        type: Array,
        required: true,
    },
});

const { company } = toRefs(props);

const form = useForm({
    user_id: auth.user ? auth.user.id : null,
    // customer_id: props.customer.id,
    id: company.value.id,
    place_id: company.value.place_id,
    address: company.value.address,
    name: company.value.name,
    reg_number: company.value.reg_number,
    tax_number: company.value.tax_number,
    web: company.value.web,
    phone: company.value.phone,
    mobile: company.value.mobile,
    email: company.value.email,
    notes: company.value.notes,
});
console.log("FORM Data : ", form);


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="form.put('/companies/update/' + form.id, {
                            onError: () => form.reset()
                        })">
                            <div
                                class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8"
                            >
                                <div
                                    class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3"
                                >
                                    <div class="mb-6 text-gray-600">
                                        <p class="text-lg font-medium">
                                            Измени Фирма
                                        </p>
                                        <p>
                                            Измени ги основните информации за
                                            фирмата
                                        </p>
                                    </div>

                                    <div class="lg:col-span-3">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-12"
                                        >
                                            <div class="md:col-span-4">
                                                <InputLabel for="name"
                                                    >Назив на Фирма</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.name"
                                                    type="text"
                                                    id="name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.name
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel for="reg_number"
                                                    >ЕМБС (Матичен /
                                                    Регистрациски
                                                    Број)</InputLabel
                                                >
                                                <TextInput
                                                    v-model="form.reg_number"
                                                    type="text"
                                                    id="code"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.code
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel
                                                    for="form.tax_number"
                                                    >ЕДБ (Даночен
                                                    Број)</InputLabel
                                                >
                                                <TextInput
                                                    v-model="form.tax_number"
                                                    type="text"
                                                    id="tax_number"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.code
                                                    }}</span
                                                >
                                            </div>
                                        </div>

                                        <div
                                            class="grid grid-cols-1 gap-4 mt-4 text-sm gap-y-2 md:grid-cols-12"
                                        >
                                            <div class="md:col-span-4">
                                                <InputLabel for="address"
                                                    >Адреса</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.address"
                                                    type="text"
                                                    id="address"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.address
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel for="place"
                                                    >Одбери Место</InputLabel
                                                >
                                                <select
                                                    v-model="form.place_id"
                                                    id="place"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Избери место
                                                    </option>
                                                    <option
                                                        v-for="place in places"
                                                        :key="place.id"
                                                        :value="place.id"
                                                    >
                                                    {{ place.place }} - {{ place.zip }} - {{ place.country ? place.country.name : 'N/A' }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.place
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel for="web"
                                                    >Web</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.web"
                                                    type="text"
                                                    id="web"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{ form.errors.web }}</span
                                                >
                                            </div>
                                        </div>

                                        <div
                                            class="grid grid-cols-1 gap-4 mt-4 text-sm gap-y-2 md:grid-cols-12"
                                        >
                                            <div class="md:col-span-4">
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

                                            <div class="md:col-span-4">
                                                <InputLabel for="mobile"
                                                    >Мобилен</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.mobile"
                                                    type="text"
                                                    id="mobile"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.mobile
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel for="email"
                                                    >Е-маил</InputLabel
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
                                        </div>

                                        <div
                                            class="grid grid-cols-1 gap-4 mt-8 text-sm gap-y-2 md:grid-cols-12"
                                        >
                                            <div class="md:col-span-12">
                                                <InputLabel for="notes"
                                                    >Забелешки</InputLabel
                                                >
                                                <textarea
                                                    v-model="form.notes"
                                                    id="notes"
                                                    class="w-full border px-4 py-2 rounded focus:border-blue-500 focus:shadow-outline outline-none text-sm"
                                                    rows="12"
                                                    placeholder="Забелешки ..."
                                                ></textarea>

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.notes
                                                    }}</span
                                                >
                                            </div>
                                        </div>




                                        <div
                                            class="mt-4 text-right md:col-span-9"
                                        >
                                            <div class="inline-flex items-end">
                                                <button
                                                    type="submit"
                                                    class="px-4 py-2 font-bold text-white rounded bg-sky-500 hover:bg-sky-700"
                                                >
                                                    Измени
                                                </button>
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
