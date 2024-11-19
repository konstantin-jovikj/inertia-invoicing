<script setup>
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({
    document: Object,
    manufacturers: Array,
    voltages: Array,
    categories: Array,
    models: Array,
    refrigerants: Array,
});

const form = useForm({
    document_id: props.document.id,
    product_code: "",
    serial_no: "",
    manufacturer_id: "",
    description: "",
    qty: "",
    single_price: "",
    total_price: "",
    length: "",
    width: "",
    height: "",
    weight: "",
    voltage_id: "",
    current: "",
    power: "",
    category_id: null,
    model_id: "",
    refrigerant_id: "",
});

// Use `props.models` directly or assign it to a reactive ref
const models = ref(props.models);
const refrigerants = ref(props.refrigerants);

const modalRef = ref(null);

const closeModal = () => {
    if (modalRef.value) {
        modalRef.value.close();
    }
};

// Computed property to filter models based on category_id
const filteredModels = computed(() => {
    if (form.category_id == null) {
        return [];
    }
    return models.value.filter((model) => model.category_id === form.category_id);
});

const filteredRefrigerants = computed(() => {
    if (!form.model_id) {
        return [];
    }

    // Find the selected model
    const selectedModel = models.value.find((model) => model.id === form.model_id);

    // If the model has a refrigerant_id, return that refrigerant
    if (selectedModel && selectedModel.refrigerant_id) {
        return refrigerants.value.filter(
            (refrigerant) => refrigerant.id === selectedModel.refrigerant_id
        );
    }

    // If no refrigerant_id is associated, return an empty array
    return [];
});






</script>
<template>
    <Modal ref="modalRef" max-width="5xl">
        <form
            @submit.prevent="
                form.post('/products/store', {
                    onSuccess: () => {
                        form.reset();
                        closeModal();
                    },
                    onError: () => form.reset(),
                })
            "
        >
            <!-- Code  + SN  + Manufacturer-->
            <div class="flex flex-col w-full gap-2 py-2 mb-2 lg:flex-row">
                <div class="w-full lg:w-1/3">
                    <InputLabel for="product_code">Код / Шифра </InputLabel>

                    <TextInput
                        v-model="form.product_code"
                        type="text"
                        id="product_code"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                    />

                    <span class="text-xs italic text-red-600">{{
                        form.errors.product_code
                    }}</span>
                </div>
                <div class="w-full lg:w-1/3">
                    <InputLabel for="serial_no">Сериски Број </InputLabel>

                    <TextInput
                        v-model="form.serial_no"
                        type="text"
                        id="serial_no"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                    />

                    <span class="text-xs italic text-red-600">{{
                        form.errors.serial_no
                    }}</span>
                </div>

                <div class="w-full lg:w-1/3">
                    <InputLabel for="serial_no">Производител</InputLabel>

                    <select
                        v-model="form.manufacturer_id"
                        id="manufacturer_id"
                        class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                    >
                        <option value="" disabled>Производител...</option>
                        <option
                            v-for="manufacturer in manufacturers"
                            :key="manufacturer.id"
                            :value="manufacturer.id"
                        >
                            {{ manufacturer.name }}
                        </option>
                    </select>

                    <span class="text-xs italic text-red-600">{{
                        form.errors.manufacturer_id
                    }}</span>
                </div>
            </div>

            <!-- Description -->
            <div class="py-4 mb-4 border-b border-gray-200 md:col-span-2">
                <InputLabel for="description">Опис </InputLabel>

                <TextInput
                    v-model="form.description"
                    type="text"
                    id="description"
                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                />

                <span class="text-xs italic text-red-600">{{
                    form.errors.description
                }}</span>
            </div>

            <!-- Quantity  + Single Price -->
            <div class="flex flex-col w-full gap-2 py-2 mb-2 lg:flex-row">
                <div class="w-full lg:w-1/2">
                    <InputLabel for="qty">Количина </InputLabel>

                    <TextInput
                        v-model="form.qty"
                        type="number"
                        id="qty"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                    />

                    <span class="text-xs italic text-red-600">{{
                        form.errors.qty
                    }}</span>
                </div>
                <div class="w-full lg:w-1/2">
                    <InputLabel for="single_price">Цена </InputLabel>

                    <TextInput
                        v-model="form.single_price"
                        type="number"
                        id="single_price"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                    />

                    <span class="text-xs italic text-red-600">{{
                        form.errors.single_price
                    }}</span>
                </div>
            </div>

            <!-- Length + Width + Height + Weight-->
            <div class="flex flex-col w-full gap-2 py-2 mb-2 lg:flex-row">
                <div class="w-full lg:w-1/4">
                    <InputLabel for="qty">Должина(cm)</InputLabel>

                    <TextInput
                        v-model="form.length"
                        type="number"
                        id="length"
                        step="0.1"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                    />

                    <span class="text-xs italic text-red-600">{{
                        form.errors.length
                    }}</span>
                </div>
                <div class="w-full lg:w-1/4">
                    <InputLabel for="single_price"
                        >Ширина/Длабина(cm)</InputLabel
                    >

                    <TextInput
                        v-model="form.width"
                        type="number"
                        id="width"
                        step="0.1"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                    />

                    <span class="text-xs italic text-red-600">{{
                        form.errors.width
                    }}</span>
                </div>

                <div class="w-full lg:w-1/4">
                    <InputLabel for="height">Висина(cm)</InputLabel>

                    <TextInput
                        v-model="form.height"
                        type="number"
                        id="height"
                        step="0.1"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                    />

                    <span class="text-xs italic text-red-600">{{
                        form.errors.height
                    }}</span>
                </div>

                <div class="w-full lg:w-1/4">
                    <InputLabel for="weight">Тежина/Маса(Kg)</InputLabel>

                    <TextInput
                        v-model="form.weight"
                        type="number"
                        id="weight"
                        step="0.01"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                    />

                    <span class="text-xs italic text-red-600">{{
                        form.errors.weight
                    }}</span>
                </div>
            </div>

            <!-- Voltage + Curent + Power -->
            <div class="flex flex-col w-full gap-2 py-2 mb-2 lg:flex-row">
                <div class="w-full lg:w-1/3">
                    <InputLabel for="voltage_id ">Напон</InputLabel>

                    <select
                        v-model="form.voltage_id"
                        id="voltage_id "
                        class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                    >
                        <option value="" disabled>Напон...</option>
                        <option
                            v-for="voltage in voltages"
                            :key="voltage.id"
                            :value="voltage.id"
                        >
                            {{ voltage.voltage }}
                        </option>
                    </select>

                    <span class="text-xs italic text-red-600">{{
                        form.errors.voltage_id
                    }}</span>
                </div>
                <div class="w-full lg:w-1/3">
                    <InputLabel for="current">Струја</InputLabel>

                    <TextInput
                        v-model="form.current"
                        type="number"
                        id="current"
                        step="0.01"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                    />

                    <span class="text-xs italic text-red-600">{{
                        form.errors.current
                    }}</span>
                </div>

                <div class="w-full lg:w-1/3">
                    <InputLabel for="power">Снага/Моќност(kW)</InputLabel>

                    <TextInput
                        v-model="form.power"
                        type="number"
                        id="power"
                        step="0.01"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                    />

                    <span class="text-xs italic text-red-600">{{
                        form.errors.power
                    }}</span>
                </div>
            </div>

            <!-- Category + Model + Refrigerant -->
            <div class="flex flex-col w-full gap-2 py-2 mb-2 lg:flex-row">
                <div class="w-full lg:w-1/3">
                    <InputLabel for="voltage_id ">Категорија</InputLabel>

                    <select
                        v-model="form.category_id"
                        id="category_id "
                        class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                    >
                        <option value="">Категорија...</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>

                    <span class="text-xs italic text-red-600">{{
                        form.errors.category_id
                    }}</span>
                </div>
                <div class="w-full lg:w-1/3">
                    <InputLabel for="current">Модел</InputLabel>

                    <select
                        v-model="form.model_id"
                        id="category_id "
                        class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"
                        :disabled="!form.category_id"
                    >
                        <option value="">Модел...</option>
                        <option
                            v-for="model in filteredModels"
                            :key="model.id"
                            :value="model.id"
                        >
                            {{ model.model }}
                        </option>
                    </select>

                    <span class="text-xs italic text-red-600">{{
                        form.errors.model_id
                    }}</span>
                </div>

                <div class="w-full lg:w-1/3">
                    <InputLabel for="refrigerant_id">Фреон</InputLabel>

                    <select
                        v-model="form.refrigerant_id"
                        id="refrigerant_id "
                        class="w-full h-10 px-4 mt-1 text-sm border rounded bg-gray-50"

                    >
                        <option value="">Фреон...</option>
                        <option
                            v-for="refrigerant in filteredRefrigerants"
                            :key="refrigerant.id"
                            :value="refrigerant.id"
                        >
                            {{ refrigerant.short_name }}
                        </option>
                    </select>

                    <span class="text-xs italic text-red-600">{{
                        form.errors.refrigerant_id
                    }}</span>
                </div>
            </div>

            <!-- Price -->
            <div class="py-4 mb-4 border-b border-gray-200 md:col-span-2"></div>

            <button
                class="px-4 py-2 text-white rounded-md bg-slate-900"
                type="submit"
            >
                Додај
            </button>
        </form>
    </Modal>
</template>
