<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { latinToCyrillic } from "@/helpers/latinToCyrillic";

const props = defineProps({
    documentType: Object,
    ownerCompanies: Array,
    clientCompanies: Array,
    authUser: Object,
    curencies: Array,
    taxes: Array,
    terms: Array,
    incoterms: Array,
    vehicles: Array,
    drivers: Array,
    places: Array,
    latestDoc: Object,
});

// console.log(props.latestDoc.document_no);

const form = useForm({
    user_id: props.authUser.id,
    document_type_id: props.documentType.id,
    is_for_export: false,
    is_translation: false,
    is_for_advanced_payment: false,
    print_price: true,
    owner_id: "",
    client_id: "",
    curency_id: "",
    tax_id: "",
    term_id: "",
    incoterm_id: "",
    vehicle_id: "",
    driver_id: "",
    document_no: "",
    date: new Date().toISOString().slice(0, 10),
    drawing_no: "",
    advance_payment: 0,
    discount: 0,
    delivery: "",
    note: "",
    incoterm_place_id: "",
});

// Define computed property to get the currency symbol based on selected currency
const selectedCurrencySymbol = computed(() => {
    // Find the currency object based on curencyId and return the symbol
    const curency = props.curencies.find((cur) => cur.id === form.curency_id);
    return curency ? curency.symbol : ""; // Return the symbol or an empty string if not found
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
                                form.post('/documents/store', {
                                    onError: () => form.reset(),
                                })
                            "
                        >
                            <div
                                class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8"
                            >
                                <div
                                    class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-2"
                                >
                                    <div
                                        class="text-gray-600 flex justify-between w-full"
                                    >
                                        <div>
                                            <p class="text-lg font-medium">
                                                Додај Нова
                                                {{
                                                    latinToCyrillic(
                                                        props.documentType.type,
                                                    )
                                                }}
                                            </p>
                                            <p>
                                                Внеси податоци за новата
                                                {{
                                                    latinToCyrillic(
                                                        props.documentType.type,
                                                    )
                                                }}
                                            </p>
                                        </div>
                                        <div
                                            v-if="props.latestDoc"
                                            class="text-red-500"
                                        >
                                            Последна
                                            {{
                                                latinToCyrillic(
                                                    props.documentType.type,
                                                )
                                            }}
                                            Бр:
                                            {{ props.latestDoc.document_no }}
                                        </div>
                                        <div v-else class="text-red-500">
                                            Ова е Прв документ од овој тип
                                        </div>
                                    </div>
                                    <div class="lg:col-span-2">
                                        <hr />
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6"
                                        >
                                            <!-- Is For Export -->
                                            <div
                                                class="py-4 mb-4 border-b border-gray-200 md:col-span-1"
                                            >
                                                <InputLabel
                                                    for="doc_is_for_export"
                                                    >Дали е за
                                                    Извоз?</InputLabel
                                                >

                                                <input
                                                    type="checkbox"
                                                    v-model="form.is_for_export"
                                                    id="doc_is_for_export"
                                                    class="w-8 h-8 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors
                                                            .is_for_export
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Is For Albanian Translation -->
                                            <div
                                                class="py-4 mb-4 border-b border-gray-200 md:col-span-1"
                                            >
                                                <InputLabel for="is_translation"
                                                    >Албански
                                                    Превод?</InputLabel
                                                >

                                                <input
                                                    type="checkbox"
                                                    v-model="
                                                        form.is_translation
                                                    "
                                                    id="is_translation"
                                                    class="w-8 h-8 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors
                                                            .is_translation
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Is For Advance Payment -->

                                            <div
                                                v-if="
                                                    props.documentType.id == 3
                                                "
                                                class="py-4 mb-4 border-b border-gray-200 md:col-span-1"
                                            >
                                                <InputLabel
                                                    for="is_for_advanced_payment"
                                                    >Дали е Авансна
                                                    {{
                                                        latinToCyrillic(
                                                            props.documentType
                                                                .type,
                                                        )
                                                    }}</InputLabel
                                                >

                                                <input
                                                    type="checkbox"
                                                    v-model="
                                                        form.is_for_advanced_payment
                                                    "
                                                    id="is_for_advanced_payment"
                                                    class="w-8 h-8 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors
                                                            .is_for_advanced_payment
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Print Price -->
                                            <div
                                                class="py-4 mb-4 border-b border-gray-200 md:col-span-1"
                                            >
                                                <InputLabel for="print_price"
                                                    >Принтај Цени
                                                    {{
                                                        latinToCyrillic(
                                                            props.documentType
                                                                .type,
                                                        )
                                                    }}</InputLabel
                                                >

                                                <input
                                                    type="checkbox"
                                                    v-model="form.print_price"
                                                    id="print_price"
                                                    class="w-8 h-8 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.print_price
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Document No -->
                                            <div
                                                class="py-4 mb-4 border-b border-gray-200 md:col-span-1"
                                            >
                                                <InputLabel for="document_no"
                                                    >Број на
                                                    {{
                                                        latinToCyrillic(
                                                            props.documentType
                                                                .type,
                                                        )
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

                                            <!-- Drawing_no -->
                                            <div
                                                class="py-4 mb-4 border-b border-gray-200 md:col-span-1"
                                            >
                                                <InputLabel for="drawing_no"
                                                    >Број на Цртеж</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.drawing_no"
                                                    type="text"
                                                    id="drawing_no"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.drawing_no
                                                    }}</span
                                                >
                                            </div>
                                            <!-- Date -->
                                            <div class="mb-4 md:col-span-1">
                                                <InputLabel
                                                    for="doc_is_for_export"
                                                    >Датум</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.date"
                                                    type="date"
                                                    id="date"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.date
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Firma Domakin -->
                                            <div class="md:col-span-2">
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
                                            <div class="md:col-span-3">
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

                                            <!-- Valuta -->
                                            <div class="md:col-span-2">
                                                <InputLabel for="curency_id"
                                                    >Избери Валута</InputLabel
                                                >
                                                <select
                                                    v-model="form.curency_id"
                                                    id="curency_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Валута ...
                                                    </option>
                                                    <option
                                                        v-for="curency in curencies"
                                                        :key="curency.id"
                                                        :value="curency.id"
                                                    >
                                                        {{ curency.symbol }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.curency_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- DDV -->
                                            <div class="md:col-span-2">
                                                <InputLabel for="tax_id"
                                                    >Избери ДДВ
                                                    Стапка</InputLabel
                                                >
                                                <select
                                                    v-model="form.tax_id"
                                                    id="tax_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="0">
                                                        ДДВ ...
                                                    </option>
                                                    <option
                                                        v-for="tax in taxes"
                                                        :key="tax.id"
                                                        :value="tax.id"
                                                    >
                                                        {{ tax.tax_rate }} %
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.tax_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Terms -->
                                            <div class="md:col-span-2">
                                                <InputLabel for="term_id"
                                                    >Услови за
                                                    плаќање</InputLabel
                                                >
                                                <select
                                                    v-model="form.term_id"
                                                    id="term_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Услови за плаќање ...
                                                    </option>
                                                    <option
                                                        v-for="term in terms"
                                                        :key="term.id"
                                                        :value="term.id"
                                                    >
                                                        {{ term.term }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.term_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- IncoTerms -->
                                            <div class="md:col-span-2">
                                                <InputLabel for="incoterm_id"
                                                    >Испорака /
                                                    Паритет</InputLabel
                                                >
                                                <select
                                                    v-model="form.incoterm_id"
                                                    id="incoterm_id"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Incoterms ...
                                                    </option>
                                                    <option
                                                        v-for="incoterm in incoterms"
                                                        :key="incoterm.id"
                                                        :value="incoterm.id"
                                                    >
                                                        {{ incoterm.shortcut }}
                                                        -
                                                        {{
                                                            incoterm.short_description
                                                        }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.incoterm_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- Delivery -->
                                            <div
                                                class="mb-4 border-gray-200 md:col-span-2"
                                            >
                                                <InputLabel for="drawing_no"
                                                    >Испорака</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.delivery"
                                                    type="text"
                                                    id="delivery"
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                />

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.delivery
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

                                            <!-- Line Break -->
                                            <div class="md:col-span-6">
                                                <hr />
                                            </div>

                                            <!-- Advanced Payment -->
                                            <div
                                                class="py-4 mb-4 border-b border-gray-200 md:col-span-2"
                                            >
                                                <InputLabel
                                                    for="advance_payment"
                                                    >Авансна Уплата</InputLabel
                                                >
                                                <div
                                                    class="flex items-center gap-2"
                                                >
                                                    <TextInput
                                                        v-model="
                                                            form.advance_payment
                                                        "
                                                        type="number"
                                                        step="0.01"
                                                        id="advance_payment"
                                                        class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                    />
                                                    <span
                                                        class="text-xl font-bolder"
                                                        >{{
                                                            selectedCurrencySymbol
                                                        }}</span
                                                    >
                                                </div>

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors
                                                            .advance_payment
                                                    }}</span
                                                >
                                            </div>

                                            <!-- DIscount -->
                                            <div
                                                class="py-4 mb-4 border-b border-gray-200 md:col-span-2"
                                            >
                                                <InputLabel for="discount"
                                                    >Попуст</InputLabel
                                                >
                                                <div
                                                    class="flex items-center gap-2"
                                                >
                                                    <TextInput
                                                        v-model="form.discount"
                                                        type="number"
                                                        step="0.01"
                                                        id="discount"
                                                        class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                    />
                                                    <span
                                                        class="text-xl font-bolder"
                                                        >%</span
                                                    >
                                                </div>

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.discount
                                                    }}</span
                                                >
                                            </div>

                                            <!-- INCOTERM / DELIVERY PLACE -->
                                            <div
                                                class="py-4 mb-4 border-b border-gray-200 md:col-span-2"
                                            >
                                                <InputLabel for="incoterm_place_id"
                                                    >INCOTERM Место на/за Испорака</InputLabel
                                                >
                                                <select
                                                    v-model="form.incoterm_place_id "
                                                    id="incoterm_place_id "
                                                    class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Incoterm Delivery Place...
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
                                                        form.errors.incoterm_place_id
                                                    }}</span
                                                >
                                            </div>

                                            <!-- note -->
                                            <div
                                                class="py-4 mb-4 border-b border-gray-200 md:col-span-6"
                                            >
                                                <InputLabel for="note"
                                                    >Забелешки</InputLabel
                                                >
                                                <div
                                                    class="flex items-center gap-2"
                                                >
                                                    <textarea
                                                        v-model="form.note"
                                                        class="w-full border px-4 py-2 rounded focus:border-blue-500 focus:shadow-outline outline-none"
                                                        rows="15"
                                                        placeholder="Забелешки ..."
                                                        id="note"
                                                    ></textarea>
                                                </div>

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.note
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
                                                        Зачувај и додај
                                                        производи
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
