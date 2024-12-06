<script setup>
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({
    product: Object,
    packingList: Object,
    manufacturers: Array,
});
// console.log(props.packingList.id);

const form = useForm({
    // packing_list_id: props.packingList.id,
    product_code: props.product?.product_code || "",
    serial_no: props.product?.serial_no || "",
    manufacturer_id: props.product?.manufacturer_id || "",
    description: props.product?.description || "",
    qty: props.product?.qty || "",
    length: props.product?.length || "",
    width: props.product?.width || "",
    height: props.product?.height || "",
    weight: props.product?.weight || "",
});
// serial_no: props.product?.serial_no || "",

// Use `props.models` directly or assign it to a reactive ref
const models = ref(props.models);

const modalRef = ref(null);

const closeModal = () => {
    if (modalRef.value) {
        modalRef.value.close();
    }
};
</script>
<template>
    <Modal ref="modalRef" max-width="5xl">
        <form
            @submit.prevent="
                form.put(`/products/packinglist/update/${product.id}`, {
                    onSuccess: () => {
                        form.reset();
                        closeModal();
                    },
                    onError: (errors) => {
                        console.error(errors);
                    },
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

            <!-- Description + Q-ty-->
            <div class="flex flex-col w-full gap-2 py-2 mb-2 lg:flex-row">
                <div class="w-full lg:w-1/4">
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

                <div class="w-full lg:w-3/4">
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
