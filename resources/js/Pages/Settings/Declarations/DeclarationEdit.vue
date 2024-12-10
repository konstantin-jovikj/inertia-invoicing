<script setup>
import TextInput from "../../../Components/TextInput.vue";
import InputLabel from "../../../Components/InputLabel.vue";
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({
    declaration: Object, // The resource to edit
});

const form = useForm({
    title: props.declaration.title,
    content: props.declaration.content,
});

const modalRef = ref(null);

const closeModal = () => {
    if (modalRef.value) {
        modalRef.value.close();
    }
};

// Submit form using Inertia
const submitForm = () => {
    form.put(`/declaration/update/${props.declaration.id}`, {
        onSuccess: () => {
            closeModal();
        },
        onError: () => {
            // Errors are already available in `form.errors`
        },
    });
};

</script>

<template>
    <Modal ref="modalRef" max-width="3xl">
        <div class="border-b border-gray-300 p-2 mx-4">
            <h3 class="text-lg font-semibold uppercase">Ажурирај Декларација за потекло</h3>
        </div>
        <form @submit.prevent="submitForm">
            <!-- Title -->
            <div class="py-4 mb-4 border-gray-200 md:col-span-2">
                <InputLabel for="title">Наслов</InputLabel>
                <TextInput
                    v-model="form.title"
                    type="text"
                    id="title"
                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                />
                <span v-if="form.errors.title" class="text-xs italic text-red-600">
                    {{ form.errors.title }}
                </span>
            </div>

            <!-- Content -->
            <div class="md:col-span-6 border-gray-200">
                <InputLabel for="content">Текст</InputLabel>
                <textarea
                    v-model="form.content"
                    id="content"
                    class="w-full border px-4 py-2 rounded focus:border-blue-500 focus:shadow-outline outline-none"
                    rows="5"
                    placeholder="Текст ..."
                ></textarea>
                <span v-if="form.errors.content" class="text-xs italic text-red-600">
                    {{ form.errors.content }}
                </span>
            </div>

            <!-- Submit Button -->
            <button
                class="px-4 py-2 text-white rounded-md bg-slate-900"
                type="submit"
            >
                Ажурирај
            </button>
        </form>
    </Modal>
</template>
