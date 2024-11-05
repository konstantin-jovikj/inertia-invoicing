<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { reactive } from "vue";
import { useForm } from "@inertiajs/vue3";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    banks: Array,
    company: Object,
    account: Object,
});

const form = useForm({
    company_id: props.account.company_id,
    bank_id: props.account.bank_id,
    is_for_export: Boolean(props.account.is_for_export),
    is_active: Boolean(props.account.is_active),
    giro_account: props.account.giro_account,
    account_no: props.account.account_no,
    swift: props.account.swift,
    iban: props.account.iban,
});

const submit = () => {
    console.log(form);
};
</script>

<template>
    <Head title="Banks" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form
                            @submit.prevent="
                                form.put('/accounts/update/' + account.id, {
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
                                            Додај Нова Сметка
                                        </p>
                                        <hr class="mt-2 mb-4" />
                                        <p>
                                            Едитирај ги податоците за Банкарската сметка на
                                            <br />
                                            <span
                                                class="font-bold text-sky-600"
                                                >{{ account.company.name }}</span
                                            >
                                        </p>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                        >
                                            <div class="md:col-span-6">
                                                <InputLabel
                                                    for="form.is_for_export"
                                                    >Дали е девизна
                                                    сметка?</InputLabel
                                                >

                                                <Checkbox
                                                    :checked="
                                                        form.is_for_export
                                                    "
                                                    @change="
                                                        (e) =>
                                                            (form.is_for_export =
                                                                e.target.checked)
                                                    "
                                                    id="bank"
                                                    class="w-8 h-8 mt-1 border rounded bg-gray-50 "
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors
                                                            .is_for_export
                                                    }}</span
                                                >
                                            </div>
                                            <div class="md:col-span-6">
                                                <InputLabel for="name"
                                                    >Банка</InputLabel
                                                >

                                                <select
                                                    v-model="form.bank_id"
                                                    id="country"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Избери Банка ...
                                                    </option>
                                                    <option
                                                        v-for="bank in banks"
                                                        :key="bank.id"
                                                        :value="bank.id"
                                                    >
                                                        {{ bank.name_cyr }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.name_cyr
                                                    }}</span
                                                >
                                            </div>

                                            <div :class="form.is_for_export ? 'md:col-span-3' : 'md:col-span-6'"
                                            v-if="form.is_for_export == false"
                                            >
                                                <InputLabel for="giro_account"
                                                    >Жиро Сметка</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.giro_account"
                                                    type="text"
                                                    id="giro_account"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.giro_account
                                                    }}</span
                                                >
                                            </div >

                                                <div
                                                v-if="form.is_for_export"
                                                    class="md:col-span-3"
                                                >
                                                    <InputLabel for="account_no"
                                                        >Acc No</InputLabel
                                                    >

                                                    <TextInput
                                                        v-model="
                                                            form.account_no
                                                        "
                                                        type="text"
                                                        id="account_no"
                                                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                    />
                                                    <span
                                                        class="text-xs italic text-red-600"
                                                        >{{
                                                            form.errors
                                                                .account_no
                                                        }}</span
                                                    >
                                                </div>

                                                <div v-if="form.is_for_export" class="md:col-span-3">
                                                    <InputLabel for="swift"
                                                        >SWIFT</InputLabel
                                                    >

                                                    <TextInput
                                                        v-model="form.swift"
                                                        type="text"
                                                        id="swift"
                                                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                    />
                                                    <span
                                                        class="text-xs italic text-red-600"
                                                        >{{
                                                            form.errors.swift
                                                        }}</span
                                                    >
                                                </div>

                                                <div v-if="form.is_for_export" :class="form.is_for_export ? 'md:col-span-6' : 'md:col-span-3'">
                                                    <InputLabel for="iban"
                                                        >IBAN</InputLabel
                                                    >

                                                    <TextInput
                                                        v-model="form.iban"
                                                        type="text"
                                                        id="swift"
                                                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                    />
                                                    <span
                                                        class="text-xs italic text-red-600"
                                                        >{{
                                                            form.errors.iban
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
                                                        class="px-4 py-2 mt-4 font-bold text-white rounded bg-sky-500 hover:bg-sky-700"
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
