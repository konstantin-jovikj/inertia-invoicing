<script setup>
import TextInput from "../../../Components/TextInput.vue";
import InputLabel from "../../../Components/InputLabel.vue";
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";


const form = useForm({
    title: "",
    content: "",

});



const modalRef = ref(null);

const closeModal = () => {
    if (modalRef.value) {
        modalRef.value.close();
    }
};

</script>
<template>
    <Modal ref="modalRef" max-width="3xl">
        <div class="border-b border-gray-300 p-2 mx-4">
            <h3 class="text-lg font-semibold uppercase ">Додај Нова Декларација за потекло</h3>
        </div>
        <form
        class=""
            @submit.prevent="
                form.post('/declaration/store', {
                    onSuccess: () => {
                        form.reset();
                        closeModal();
                    },
                    onError: () => form.reset(),
                })
            "
        >
            <!-- Description -->
            <div class="py-4 mb-4  border-gray-200 md:col-span-2">
                <InputLabel for="title">Наслов </InputLabel>

                <TextInput
                    v-model="form.title"
                    type="text"
                    id="title"
                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                />

                <span class="text-xs italic text-red-600">{{
                    form.errors.title
                }}</span>
            </div>

            <div class="md:col-span-6 border-gray-200">
                <InputLabel for="content">Текст</InputLabel>
                <textarea
                    v-model="form.content"
                    id="notes"
                    class="w-full border px-4 py-2 rounded focus:border-blue-500 focus:shadow-outline outline-none"
                    rows="5"
                    placeholder="Текст ..."
                ></textarea>

                <span class="text-xs italic text-red-600">{{
                    form.errors.content
                }}</span>
            </div>

            <button
                class="px-4 py-2 text-white rounded-md bg-slate-900"
                type="submit"
            >
                Додај
            </button>
        </form>
    </Modal>
</template>
