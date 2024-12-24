<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { latinToCyrillic } from "@/helpers/latinToCyrillic";


const props = defineProps({
    document: {
        type: Object,
        required: true,
    },
    documentType: Array,
    ownerCompanies: Array,
    clientCompanies: Array,
    authUser: Object,
    vehicles: Array,
    drivers: Array,
    places: Array,

    curencies: Array,
    taxes: Array,
    terms: Array,
    incoterms: Array,
});

// console.log(props.documentType);

const form = useForm({
    user_id: props.document.user_id,
    document_type_id: props.document.document_type_id,
    owner_id: props.document.owner_id ? Number(props.document.owner_id) : '',
    client_id: props.document.client_id,
    vehicle_id: props.document.vehicle_id,
    driver_id: props.document.driver_id,
    document_no: props.document.document_no,
    load_date: new Date(props.document.load_date).toLocaleDateString("en-CA"),
    unload_date: new Date(props.document.unload_date).toLocaleDateString("en-CA"),
    load_place_id: props.document.load_place_id,
    unload_place_id: props.document.unload_place_id,
    marking: props.document.marking,
    boxes_nr: props.document.boxes_nr,
    packaging_type: props.document.packaging_type,
    goods_type: props.document.goods_type,
    note: props.document.note,
    instruction: props.document.instruction,
    picked_up_by: props.document.picked_up_by,
    tax_id : null,
    advance_payment: props.document.advance_payment,
});
console.log(form);
// const submit = () => {
//     console.log(form);
// };
</script>

<template>
    <Head title="Taxes" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="form.put('/document/update/' + props.document.id, {
                            onError: () => form.reset()
                        })">
                            <div
                                class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8"
                            >
                                <div
                                    class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-2"
                                >
                                    <div class="text-gray-600">
                                        <p class="text-lg font-medium">
                                            Ажурирај Товарен Лист 
                                        </p>
                                        <p>
                                            Ажурирај податоци за Товарниот Лист
                                        </p>
                                    </div>
                                    <div class="lg:col-span-2">
                                        <hr />
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                        >
                                            <!-- Document No -->
                                            <div
                                                class="py-4 mb-4 md:col-span-1"
                                            >
                                                <InputLabel for="document_no"
                                                    >Број на
                                                    {{
                                                        props.documentType.type
                                                    }}
                                                </InputLabel>

                                                <TextInput
                                                    v-model="form.document_no"
                                                    type="text"
                                                    id="document_no"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.document_no
                                                    }}</span
                                                >
                                            </div>

                                            <!--Load Date -->
                                            <div
                                                class="py-4 mb-4 md:col-span-1"
                                            >
                                                <InputLabel for="load_date"
                                                    >Датум на Утовар</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.load_date"
                                                    type="date"
                                                    id="date"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.load_date
                                                    }}</span
                                                >
                                            </div>

                                            <!--Unload Date -->
                                            <div
                                                class="py-4 mb-4 md:col-span-1"
                                            >
                                                <InputLabel for="load_date"
                                                    >Датум на
                                                    Истовар</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.unload_date"
                                                    type="date"
                                                    id="date"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.unload_date
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Firma Domakin -->
                                            <div class="py-4 md:col-span-1">
                                                <InputLabel for="owner_id"
                                                    >Избери фирма</InputLabel
                                                >
                                                <select
                                                    v-model="form.owner_id"
                                                    id="owner_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Фирма...
                                                    </option>
                                                    <option
                                                        v-for="ownerCompany in ownerCompanies"
                                                        :key="ownerCompany.id"
                                                        :value="ownerCompany.id"
                                                    >
                                                        {{ ownerCompany.name }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.owner_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Firma Klient -->
                                            <div class="py-4 md:col-span-2">
                                                <InputLabel for="client_id"
                                                    >Избери Клиент</InputLabel
                                                >
                                                <select
                                                    v-model="form.client_id"
                                                    id="client_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Клиент ...
                                                    </option>
                                                    <option
                                                        v-for="clientCompany in clientCompanies"
                                                        :key="clientCompany.id"
                                                        :value="
                                                            clientCompany.id
                                                        "
                                                    >
                                                        {{ clientCompany.name }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.client_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Load Place -->
                                            <div class="md:col-span-1">
                                                <InputLabel for="load_place_id"
                                                    >Место на Утовар</InputLabel
                                                >
                                                <select
                                                    v-model="form.load_place_id"
                                                    id="curency_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Место на Утовар ...
                                                    </option>
                                                    <option
                                                        v-for="place in places"
                                                        :key="place.id"
                                                        :value="place.id"
                                                    >
                                                        {{ place.place }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors
                                                            .load_place_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Unload Place -->
                                            <div class="md:col-span-1">
                                                <InputLabel
                                                    for="unload_place_id"
                                                    >Место на
                                                    Истовар</InputLabel
                                                >
                                                <select
                                                    v-model="
                                                        form.unload_place_id
                                                    "
                                                    id="curency_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Место на Истовар ...
                                                    </option>
                                                    <option
                                                        v-for="place in places"
                                                        :key="place.id"
                                                        :value="place.id"
                                                    >
                                                        {{ place.place }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors
                                                            .unload_place_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Vehicle -->
                                            <div class="md:col-span-1">
                                                <InputLabel for="vehicle_id"
                                                    >Избери Возило</InputLabel
                                                >
                                                <select
                                                    v-model="form.vehicle_id"
                                                    id="vehicle_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Возило ...
                                                    </option>
                                                    <option
                                                        v-for="vehicle in vehicles"
                                                        :key="vehicle.id"
                                                        :value="vehicle.id"
                                                    >
                                                        {{
                                                            vehicle.register_plate_number
                                                        }}
                                                        - {{ vehicle.model }}
                                                        -
                                                        {{ vehicle.type }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.vehicle_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Driver -->
                                            <div class="md:col-span-1">
                                                <InputLabel for="driver_id"
                                                    >Избери Возач</InputLabel
                                                >
                                                <select
                                                    v-model="form.driver_id"
                                                    id="driver_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Возач ...
                                                    </option>
                                                    <option
                                                        v-for="driver in drivers"
                                                        :key="driver.id"
                                                        :value="driver.id"
                                                    >
                                                        {{ driver.name }}
                                                        {{ driver.surname }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.driver_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Ознака -->
                                            <div class="mb-4 md:col-span-1">
                                                <InputLabel for="marking"
                                                    >Ознака
                                                </InputLabel>

                                                <TextInput
                                                    v-model="form.marking"
                                                    type="text"
                                                    id="marking"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.marking
                                                    }}</span
                                                >
                                            </div>

                                            <!-- boxes_nr -->
                                            <div class="mb-4 md:col-span-1">
                                                <InputLabel for="boxes_nr"
                                                    >Број на Пакети</InputLabel
                                                >
                                                <div
                                                    class="flex items-center gap-2"
                                                >
                                                    <TextInput
                                                        v-model="form.boxes_nr"
                                                        type="number"
                                                        id="boxes_nr"
                                                        class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                    />
                                                </div>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.boxes_nr
                                                    }}</span
                                                >
                                            </div>

                                            <!-- packaging_type -->
                                            <div class="mb-4 md:col-span-1">
                                                <InputLabel for="packaging_type"
                                                    >Вид на Амбалажа
                                                </InputLabel>

                                                <TextInput
                                                    v-model="
                                                        form.packaging_type
                                                    "
                                                    type="text"
                                                    id="packaging_type"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors
                                                            .packaging_type
                                                    }}</span
                                                >
                                            </div>

                                            <!-- goods_type -->
                                            <div class="mb-4 md:col-span-2">
                                                <InputLabel for="goods_type"
                                                    >Вид на Стока
                                                </InputLabel>

                                                <TextInput
                                                    v-model="form.goods_type"
                                                    type="text"
                                                    id="goods_type"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.goods_type
                                                    }}</span
                                                >
                                            </div>

                                            <!-- note -->
                                            <div class="mb-4 md:col-span-3">
                                                <InputLabel for="note"
                                                    >Забелешка
                                                </InputLabel>

                                                <TextInput
                                                    v-model="form.note"
                                                    type="text"
                                                    id="note"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.note
                                                    }}</span
                                                >
                                            </div>

                                            <!-- instruction -->
                                            <div class="mb-4 md:col-span-3">
                                                <InputLabel for="note"
                                                    >Инструкции
                                                </InputLabel>

                                                <TextInput
                                                    v-model="form.instruction"
                                                    type="text"
                                                    id="instruction"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.instruction
                                                    }}</span
                                                >
                                            </div>

                                            <!-- picked_up_by -->
                                            <div class="mb-4 md:col-span-3">
                                                <InputLabel for="v"
                                                    >Робата ја Превзема
                                                </InputLabel>

                                                <TextInput
                                                    v-model="form.picked_up_by"
                                                    type="text"
                                                    id="picked_up_by"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.picked_up_by
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
                                                        class="px-4 py-2 text-white rounded font-bolder bg-sky-500 hover:bg-sky-700"
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
