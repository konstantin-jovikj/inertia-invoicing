<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";

import InputLabel from "../../Components/InputLabel.vue";
import Dropdown from "@/Components/Dropdown.vue";
import { reactive } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    customer_types: Array,
});

const form = useForm({
    customer_type_id: "",

});

const submit = () => {
    console.log(form);
};

console.log("Customer_Type:", props.customer_types);
</script>

<template>
    <Head title="Add New Customer" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form
                            @submit.prevent="
                                form.post('/customers/store', {
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
                                            Тип на Коминтент
                                        </p>
                                        <p>
                                            Одбери го типот на Коминтент
                                        </p>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-5"
                                        >
                                            <div class="md:col-span-5">
                                                <InputLabel for="country"
                                                    >Одбери Тип на Коминтент</InputLabel
                                                >
                                                <select
                                                    v-model="form.customer_type_id"
                                                    id="country"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Тип на Коминтент ...
                                                    </option>
                                                    <option
                                                        v-for="type in customer_types"
                                                        :key="type.id"
                                                        :value="type.id"
                                                    >
                                                        {{ type.type }}
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
                                                class="flex justify-between text-right md:col-span-5"
                                            >
                                                <Link
                                                    :href="route('place.index')"
                                                    class="px-4 py-2 mt-4 font-bold text-white rounded bg-slate-500 hover:bg-slate-700"
                                                    >Назад</Link
                                                >
                                                <div
                                                v-if="form.customer_type_id"
                                                    class="inline-flex items-end"
                                                >
                                                    <button
                                                        type="submit"
                                                        class="px-4 py-2 mt-4 font-bold text-white rounded bg-sky-500 hover:bg-sky-700"
                                                    >
                                                        Креирај
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
