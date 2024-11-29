<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import { reactive, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

const auth = usePage().props.auth;

const props = defineProps({
    customer: {
        type: Object,
        required: true,
    },
    places: {
        type: Array,
        required: true,
    },
});

// console.log(places);

const form = useForm({
    user_id: auth.user ? auth.user.id : null,
    customer_id: props.customer.id,
    place_id: "",
    address: "",
    name: "",
    reg_number: "",
    tax_number: "",
    logo: null, // Define logo for file upload
    cert: null, // Define cert for file upload
    web: "",
    phone: "",
    mobile: "",
    email: "",
    notes: "",
});

const submit = () => {
    console.log(form);
};

const selectedLogo = ref("");
const LogoPreview = ref(null);

const handleLogoUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Update form and filename
        form.logo = file;
        selectedLogo.value = file.name;

        // Create image preview
        const reader = new FileReader();
        reader.onload = (e) => {
            LogoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const clearLogo = () => {
    form.logo = null;
    selectedLogo.value = "";
    LogoPreview.value = null;
    document.getElementById("logo").value = "";
};

const selectedCert = ref("");
const CertPreview = ref(null);

const handleCertUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Update form and filename
        form.cert = file;
        selectedCert.value = file.name;

        // Create image preview
        const reader = new FileReader();
        reader.onload = (e) => {
            CertPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const clearCert = () => {
    form.cert = null;
    selectedCert.value = "";
    CertPreview.value = null;
    document.getElementById("cert").value = "";
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form
                            @submit.prevent="
                                form.post('/companies/store', {
                                    forceFormData: true,
                                    onError: () => form.reset(),
                                })
                            "
                        >
                            <div
                                class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8"
                            >
                                <div
                                    class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3"
                                >
                                    <div class="mb-6 text-gray-600">
                                        <p class="text-lg font-medium">
                                            Додај Нова Фирма
                                        </p>
                                        <p>
                                            Внеси ги основните информации за
                                            фирмата
                                        </p>
                                    </div>

                                    <div class="lg:col-span-3">
                                        <div
                                            class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-12"
                                        >
                                            <div class="md:col-span-4">
                                                <InputLabel for="name"
                                                    >Назив на Фирма</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.name"
                                                    type="text"
                                                    id="name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.name
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel for="reg_number"
                                                    >ЕМБС (Матичен /
                                                    Регистрациски
                                                    Број)</InputLabel
                                                >
                                                <TextInput
                                                    v-model="form.reg_number"
                                                    type="text"
                                                    id="code"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.code
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel
                                                    for="form.tax_number"
                                                    >ЕДБ (Даночен
                                                    Број)</InputLabel
                                                >
                                                <TextInput
                                                    v-model="form.tax_number"
                                                    type="text"
                                                    id="tax_number"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.tax_number
                                                    }}</span
                                                >
                                            </div>
                                        </div>

                                        <div
                                            class="grid grid-cols-1 gap-4 mt-4 text-sm gap-y-2 md:grid-cols-12"
                                        >
                                            <div class="md:col-span-4">
                                                <InputLabel for="address"
                                                    >Адреса</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.address"
                                                    type="text"
                                                    id="address"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.address
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel for="place"
                                                    >Одбери Место</InputLabel
                                                >
                                                <select
                                                    v-model="form.place_id"
                                                    id="place"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                >
                                                    <option value="" disabled>
                                                        Избери место
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
                                                        form.errors.place
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel for="web"
                                                    >Web</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.web"
                                                    type="text"
                                                    id="web"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{ form.errors.web }}</span
                                                >
                                            </div>
                                        </div>

                                        <div
                                            class="grid grid-cols-1 gap-4 mt-4 text-sm gap-y-2 md:grid-cols-12"
                                        >
                                            <div class="md:col-span-4">
                                                <InputLabel for="phone"
                                                    >Телефон</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.phone"
                                                    type="text"
                                                    id="phone"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.phone
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel for="mobile"
                                                    >Мобилен</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.mobile"
                                                    type="text"
                                                    id="mobile"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.mobile
                                                    }}</span
                                                >
                                            </div>

                                            <div class="md:col-span-4">
                                                <InputLabel for="email"
                                                    >Е-маил</InputLabel
                                                >

                                                <TextInput
                                                    v-model="form.email"
                                                    type="email"
                                                    id="email"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50"
                                                />
                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.email
                                                    }}</span
                                                >
                                            </div>
                                        </div>

                                        <!-- Logo and CErt Upload -->
                                        <div
                                            class="grid grid-cols-1 gap-4 mt-8 text-sm gap-y-2 md:grid-cols-12"
                                        >
                                            <div class="md:col-span-6">
                                                <InputLabel for="notes"
                                                    >Забелешки</InputLabel
                                                >
                                                <textarea
                                                    v-model="form.notes"
                                                    id="notes"
                                                    class="w-full border px-4 py-2 rounded focus:border-blue-500 focus:shadow-outline outline-none"
                                                    rows="5"
                                                    placeholder="Забелешки ..."
                                                ></textarea>

                                                <span
                                                    class="text-xs italic text-red-600"
                                                    >{{
                                                        form.errors.notes
                                                    }}</span
                                                >
                                            </div>
                                            <div class="md:col-span-6  mt-4">
                                                <!-- Logo -->
                                                <div class="mb-6">
                                                    <label
                                                        for="logo"
                                                        class="items-center block gap-2 px-4 py-2 transition-colors bg-white border border-gray-300 rounded-md shadow-sm cursor-pointer hover:bg-gray-50"
                                                    >
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="w-5 h-5 text-gray-400"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                                            />
                                                        </svg>
                                                        <span
                                                            class="text-sm font-medium text-gray-700"
                                                            >Прикачи Лого</span
                                                        >
                                                    </label>

                                                    <input
                                                        type="file"
                                                        id="logo"
                                                        class="hidden"
                                                        @change="
                                                            handleLogoUpload
                                                        "
                                                        accept="image/*"
                                                    />

                                                    <!-- Selected file name with delete option -->
                                                    <div
                                                        v-if="selectedLogo"
                                                        class="flex items-center gap-2 mt-2 text-sm text-gray-600"
                                                    >
                                                        <span>{{
                                                            selectedLogo
                                                        }}</span>
                                                        <button
                                                            @click="clearLogo"
                                                            type="button"
                                                            class="text-red-500 hover:text-red-700"
                                                        >
                                                            ×
                                                        </button>
                                                    </div>

                                                    <!-- Image Preview -->
                                                    <div
                                                        v-if="LogoPreview"
                                                        class="mt-4"
                                                    >
                                                        <img
                                                            :src="LogoPreview"
                                                            alt="Preview"
                                                            class="object-contain w-40 h-40 border border-gray-200 rounded-lg"
                                                        />
                                                    </div>

                                                    <span
                                                        class="text-xs italic text-red-600"
                                                        >{{
                                                            form.errors.logo
                                                        }}</span
                                                    >
                                                </div>

                                                <!-- Cert -->

                                                <div class="">
                                                    <label
                                                        for="cert"
                                                        class="items-center block gap-2 px-4 py-2 transition-colors bg-white border border-gray-300 rounded-md shadow-sm cursor-pointer hover:bg-gray-50"
                                                    >
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="w-5 h-5 text-gray-400"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                                            />
                                                        </svg>
                                                        <span
                                                            class="text-sm font-medium text-gray-700"
                                                            >Прикачи
                                                            Сертификат</span
                                                        >
                                                    </label>

                                                    <input
                                                        type="file"
                                                        id="cert"
                                                        class="hidden"
                                                        @change="
                                                            handleCertUpload
                                                        "
                                                        accept="image/*"
                                                    />

                                                    <!-- Selected file name with delete option -->
                                                    <div
                                                        v-if="selectedCert"
                                                        class="flex items-center gap-2 mt-2 text-sm text-gray-600"
                                                    >
                                                        <span>{{
                                                            selectedCert
                                                        }}</span>
                                                        <button
                                                            @click="clearCert"
                                                            type="button"
                                                            class="text-red-500 hover:text-red-700"
                                                        >
                                                            ×
                                                        </button>
                                                    </div>

                                                    <!-- Image Preview -->
                                                    <div
                                                        v-if="CertPreview"
                                                        class="mt-4"
                                                    >
                                                        <img
                                                            :src="CertPreview"
                                                            alt="Preview"
                                                            class="object-contain w-40 h-40 border border-gray-200 rounded-lg"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="mt-4 text-right md:col-span-9"
                                        >
                                            <div class="inline-flex items-end">
                                                <button
                                                    type="submit"
                                                    class="px-4 py-2 font-bold text-white rounded bg-sky-500 hover:bg-sky-700"
                                                >
                                                    Додај
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
        </div>
    </AuthenticatedLayout>
</template>
