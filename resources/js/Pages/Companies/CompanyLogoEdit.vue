<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

const props = defineProps({
    company: {
        type: Object,
        required: true,
    },
    errors: Object,
});

// Initialize url as a ref
const url = ref(null);
const urlCert = ref(null);

const form = useForm({
    logo: null,
    cert: null,
});

const submit = () => {
    if (form.logo || form.cert) {
        form.post(route("company.logo.update", { id: props.company.id }), {
            forceFormData: true,
            onError: () => {
                form.reset();
            },
        });
    }
};

const previewImage = (e) => {
    const file = e.target.files[0];
    if (file) {
        url.value = URL.createObjectURL(file);
        form.logo = file;
    } else {
        url.value = null;
        form.logo = null;
    }
};

const previewCert = (e) => {
    const file = e.target.files[0];
    if (file) {
        urlCert.value = URL.createObjectURL(file);
        form.cert = file;
    } else {
        urlCert.value = null;
        form.cert = null;
    }
};


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div>
                                <label for="File"
                                    >Прикачи ново Лого и Сертификат</label
                                >
                                <div class="flex flex-col w-full gap-6 md:w-50 md:flex-row">
                                    <!-- logo -->
                                    <div>
                                        <input
                                            type="file"
                                            @change="previewImage"
                                            accept="image/*"
                                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                                        />
                                        <div
                                            class="p-4 my-4 border rounded-md border-slate-200"
                                        >
                                            <p>Ново Лого</p>
                                            <img
                                                v-if="url"
                                                :src="url"
                                                class="object-contain w-full h-40 mt-4"
                                            />
                                        </div>
                                        <div
                                            class="p-4 my-4 border rounded-md border-slate-200"
                                        >
                                            <p>Старо, Постоечко лого</p>
                                            <img
                                                v-if="props.company.logo"
                                                :src="`/storage/${props.company.logo}`"
                                                class="object-contain w-full h-40 mt-4"
                                            />
                                        </div>
                                    </div>

                                    <!-- Cert -->
                                    <div>
                                        <input
                                            type="file"
                                            @change="previewCert"
                                            accept="image/*"
                                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                                        />
                                        <div
                                            class="p-4 my-4 border rounded-md border-slate-200"
                                        >
                                            <p>Нов Сертификат</p>
                                            <img
                                                v-if="urlCert"
                                                :src="urlCert"
                                                class="object-contain w-full h-40 mt-4"
                                            />
                                        </div>
                                        <div
                                            class="p-4 my-4 border rounded-md border-slate-200"
                                        >
                                            <p>Стар, Постоечки Сертификат</p>
                                            <img
                                                v-if="props.company.cert"
                                                :src="`/storage/${props.company.cert}`"
                                                class="object-contain w-full h-40 mt-4"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-if="errors.cert"
                                    class="font-bold text-red-600"
                                >
                                    {{ errors.cert }}
                                </div>
                            </div>

                            <div class="flex items-center mt-4">
                                <button
                                    type="submit"
                                    class="px-6 py-2 text-white bg-gray-900 rounded"
                                >
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
