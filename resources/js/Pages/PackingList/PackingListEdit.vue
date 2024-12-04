<script setup>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import {
        Head
    } from "@inertiajs/vue3";
    import TextInput from "../../Components/TextInput.vue";
    import InputLabel from "../../Components/InputLabel.vue";
    import {
        useForm,
        usePage
    } from "@inertiajs/vue3";
    import {
        computed,
        ref,
        toRefs
    } from "vue";
    import {
        Modal
    } from "@inertiaui/modal-vue";
    import {
        watch
    } from "vue";

    const props = defineProps({
        packingList: Object,
        ownerCompanies: Array,
        clientCompanies: Array,
        authUser: Object,
    });

    const {
        packingList
    } = toRefs(props);

    const date = new Date(packingList.value.date);
    const formattedDate =
        `${String(date.getDate()).padStart(2, "0")}/${String(date.getMonth() + 1).padStart(2, "0")}/${date.getFullYear()}`;

    const form = useForm({
        user_id: packingList.value.user_id,
        owner_id: packingList.value.owner_id,
        client_id: packingList.value.client_id,
        document_no: packingList.value.document_no,
        date: new Date(packingList.value.date).toLocaleDateString("en-CA"),
    });

    const submit = () => {
        console.log(form);
    };
</script>

<template>
    <Modal ref="modalRef" max-width="3xl" class="rounded-md">
        <div class="py-2">
            <div class="mx-auto max-w-11/12 sm:px-3 lg:px-4">
                
                    <div class="p-2 text-gray-900">
                        <form
                            @submit.prevent="
                                form.put(
                                    '/packinglist/update/' + packingList.id,
                                    {
                                        onError: () => form.reset(),
                                    },
                                )
                            ">
                            
                                <p class="text-lg font-bold">Измени Пакинг Листа</p>
                                <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-2">
                                    <div class="lg:col-span-2">
                                        <hr />
                                        <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6">

                                            <!-- Packing List No -->
                                            <div class="py-4 mb-4 border-b border-gray-200 md:col-span-3">
                                                <InputLabel for="document_no">Број на Пакинг Листа
                                                </InputLabel>

                                                <TextInput v-model="form.document_no" type="text" id="document_no"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" />

                                                <span
                                                    class="text-xs italic text-red-600">{{ form . errors . document_no }}</span>
                                            </div>

                                            <!-- Date -->
                                            <div class="py-4 mb-4 border-b border-gray-200 md:col-span-3">
                                                <InputLabel for="date">Датум</InputLabel>

                                                <TextInput v-model="form.date" type="date" id="date"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" />

                                                <span class="text-xs italic text-red-600">{{ form . errors . date }}</span>
                                            </div>

                                            <!-- Firma Domakin -->
                                            <div class="md:col-span-6">
                                                <InputLabel for="owner_id">Избери фирма</InputLabel>
                                                <select v-model="form.owner_id" id="owner_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50">
                                                    <option value="" disabled>
                                                        Фирма...
                                                    </option>
                                                    <option v-for="ownerCompany in ownerCompanies"
                                                        :key="ownerCompany.id" :value="ownerCompany.id">
                                                        {{ ownerCompany . name }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600">{{ form . errors . owner_id }}</span>
                                            </div>

                                            <!-- Firma Klient -->
                                            <div class="md:col-span-6">
                                                <InputLabel for="client_id">Избери Клиент</InputLabel>
                                                <select v-model="form.client_id" id="client_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50">
                                                    <option value="" disabled>
                                                        Клиент ...
                                                    </option>
                                                    <option v-for="clientCompany in clientCompanies"
                                                        :key="clientCompany.id"
                                                        :value="clientCompany.id">
                                                        {{ clientCompany . name }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600">{{ form . errors . client_id }}</span>
                                            </div>


                                            <div class="text-right md:col-span-5">
                                                <div class="inline-flex items-end">
                                                    <button type="submit"
                                                        class="px-4 py-2 text-white rounded font-bolder bg-sky-700 hover:bg-sky-800">
                                                        Ажурирај
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
    </Modal>
</template>
