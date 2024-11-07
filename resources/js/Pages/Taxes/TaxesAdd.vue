<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { throttle } from "lodash";

// Initialize form with tax_rate as an empty string
const form = useForm({
    tax_rate: "",
});

// Underlying reactive value for tax_rate as a number
// const tax_rate_number = ref(0);

// // Computed property for tax_rate with formatted two decimals
// const formattedTaxRate = computed({
//   get() {
//     return tax_rate_number.value.toFixed(2);
//   },
//   set(value) {
//     const parsedValue = parseFloat(value);
//     tax_rate_number.value = isNaN(parsedValue) ? 0 : parsedValue;
//   },
// });

// // Throttle the updates to the computed tax rate
// const throttledTaxRate = throttle(() => formattedTaxRate.value, 500);

// Form submit function
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
                                form.post('/taxes/store', {
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
                                            Додај Нова ДДВ Ставка
                                        </p>
                                        <p>
                                            Внеси ја новата ДДВ Ставка (во
                                            проценти)
                                        </p>
                                    </div>
                                    <div class="lg:col-span-2">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                        >
                                            <div class="md:col-span-4">
                                                <InputLabel for="tax_rate"
                                                    >ДДВ Износ</InputLabel
                                                >
                                                <TextInput
                                                    id="tax_rate"
                                                    v-model="form.tax_rate"
                                                    type="text"
                                                    class="block w-full mt-1"
                                                    autocomplete="off"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.tax_rate
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
