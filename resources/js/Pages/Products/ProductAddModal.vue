<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { reactive } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Modal } from '@inertiaui/modal-vue'
// import {Modal, ModalLink } from "vendor/inertiaui/modal/vue/src/ModalLink.vue";

// const props = defineProps({
//     document: Object,
//     // products: Array,
// });

// const form = useForm({
//     document_id: props.document.id,
//     description: "",
//     qty: "",
//     single_price: "",
//     total_price: "",
// });


// const modalRef = ref(null);


</script>
<!-- <template>

        <Modal ref = "modalRef">
        <div class="py-12">
            <form
                @submit.prevent="
                    form.post('/products/store', {
                        onSuccess: () => {
                            form.reset();
                        },
                        onError: () => form.reset(),
                    })
                "
            >
                <label for="">Description</label>
                <input v-model="form.description" type="text" />

                <label for="">Q-ty</label>
                <input v-model="form.qty" type="number" />

                <label for="">Price</label>
                <input v-model="form.single_price" type="number" />

                <button type="submit">Add</button>
            </form>
        </div>
    </Modal>
</template> -->

<template>
    <Modal>
        <h1>Create User</h1>
        <form>
            <!-- Form fields -->
        </form>
    </Modal>
</template>
