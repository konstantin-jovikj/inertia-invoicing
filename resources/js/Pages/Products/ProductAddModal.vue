<script setup>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import {
        Head,
        Link,
        router
    } from "@inertiajs/vue3";
    import TextInput from "../../Components/TextInput.vue";
    import InputLabel from "../../Components/InputLabel.vue";
    import {
        reactive,
        ref
    } from "vue";
    import {
        useForm,
        usePage
    } from "@inertiajs/vue3";
    import {
        Modal
    } from "@inertiaui/modal-vue";
    // import {Modal, ModalLink } from "vendor/inertiaui/modal/vue/src/ModalLink.vue";

    const props = defineProps({
        document: Object,
        // products: Array,
    });

    const form = useForm({
        document_id: props.document.id,
        description: "",
        qty: "",
        single_price: "",
        total_price: "",
    });

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
                    form.post('/products/store', {
                        onSuccess: () => {
                            form.reset();
                            closeModal();
                        },
                        onError: () => form.reset(),
                    })
                ">
                <!-- Description -->
                <div class="py-4 mb-4 border-b border-gray-200 md:col-span-2">
                    <InputLabel for="description">Опис
                    </InputLabel>

                    <TextInput v-model="form.description" type="text" id="description"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" />

                    <span class="text-xs italic text-red-600">{{ form . errors . description }}</span>
                </div>

                <!-- Quantity -->
                <div class="py-4 mb-4 border-b border-gray-200 md:col-span-2">
                    <InputLabel for="qty">Количина
                    </InputLabel>

                    <TextInput v-model="form.qty" type="number" id="qty"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" />

                    <span class="text-xs italic text-red-600">{{ form . errors . qty }}</span>
                </div>

                <!-- Price -->
                <div class="py-4 mb-4 border-b border-gray-200 md:col-span-2">
                    <InputLabel for="single_price">Цена
                    </InputLabel>

                    <TextInput v-model="form.single_price" type="number" id="single_price"
                        class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" />

                    <span class="text-xs italic text-red-600">{{ form . errors . single_price }}</span>
                </div>


                <button class="px-4 py-2 text-white rounded-md bg-slate-900" type="submit">Додај</button>
            </form>

    </Modal>
</template>
