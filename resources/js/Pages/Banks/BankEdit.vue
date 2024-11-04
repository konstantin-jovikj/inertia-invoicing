<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { reactive } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

const auth = usePage().props.auth;

const props = defineProps({
    bank: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    id: props.bank.id,
    name_cyr: props.bank.name_cyr,
    name_lat: props.bank.name_lat,
    address_cyr: props.bank.address_cyr,
    address_lat: props.bank.address_lat,
});

const submit = () => {
    console.log(form)
}
</script>

<template>
    <Head title="Banks" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="form.put('/banks/update/' + form.id, {
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
                                            Измени ја Банка
                                        </p>
                                        <p>
                                            Промени го името и/или адресата на Банката
                                        </p>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                        >
                                            <div class="md:col-span-3">
                                                <InputLabel for="name">Име Кирилица</InputLabel>

                                                <TextInput
                                                    v-model="form.name_cyr"
                                                    type="text"
                                                    id="name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span class="text-xs italic text-red-600">{{ form.errors.name_cyr }}</span>
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="name">Име Латиница</InputLabel>

                                                <TextInput
                                                    v-model="form.name_lat"
                                                    type="text"
                                                    id="name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span class="text-xs italic text-red-600">{{ form.errors.name_lat }}</span>
                                            </div>


                                            <div class="md:col-span-3">
                                                <InputLabel for="name">Адреса Кирилица</InputLabel>

                                                <TextInput
                                                    v-model="form.address_cyr"
                                                    type="text"
                                                    id="name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span class="text-xs italic text-red-600">{{ form.errors.address_cyr }}</span>
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="name">Адреса Латиница</InputLabel>

                                                <TextInput
                                                    v-model="form.address_lat"
                                                    type="text"
                                                    id="name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span class="text-xs italic text-red-600">{{ form.errors.address_lat }}</span>
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
                                                        Зачувај
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
