<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { reactive } from "vue";
import { useForm } from '@inertiajs/vue3'


const form = useForm({
    name: "",
    code: "",
});

const submit = () => {
    console.log(form)
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="form.post('/countries/store', {
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
                                            Додај Нова Држава
                                        </p>
                                        <p>
                                            Внеси го името и кодот на Државата
                                        </p>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-5"
                                        >
                                            <div class="md:col-span-3">
                                                <InputLabel for="name">Име</InputLabel>

                                                <TextInput
                                                    v-model="form.name"
                                                    type="text"
                                                    id="name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span class="text-xs italic text-red-600">{{ form.errors.name }}</span>
                                            </div>

                                            <div class="md:col-span-2">
                                                <InputLabel for="code">Код</InputLabel>
                                                <TextInput
                                                    v-model="form.code"
                                                    type="text"
                                                    id="code"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span class="text-xs italic text-red-600">{{ form.errors.code }}</span>
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
