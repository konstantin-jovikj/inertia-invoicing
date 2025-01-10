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
        reactive
    } from "vue";
    import {
        useForm,
        usePage
    } from "@inertiajs/vue3";
    import {
        toRefs
    } from "vue";
    import {
        computed
    } from "vue";

    const auth = usePage().props.auth;

    const props = defineProps({
        categories: {
            type: Array,
            required: true,
        },
        productModel: {
            type: Object,
            required: true,
        },
    });

    const form = useForm({
        id: props.productModel.id,
        category_id: props.productModel.category_id,
        model: props.productModel.model,
        description: props.productModel.description,
    });


    const submit = () => {
        console.log(form);
    };
</script>

<template>

    <Head title="Manufacturers" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form
                            @submit.prevent="form.put('/productmodels/update/' + form.id, {
                            onError: () => form.reset()
                        })">
                            <div class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8">
                                <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3">
                                    <div class="text-gray-600">
                                        <p class="text-lg font-medium">
                                            Додај Модел
                                        </p>
                                        <p>
                                            Внеси Нов Модел на Производ
                                        </p>
                                    </div>

                                    <div class="lg:col-span-2">

                                        <!-- Category -->
                                        <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6">
                                            <div class="md:col-span-3">
                                                <InputLabel for="country">Одбери Категорија</InputLabel>
                                                <select v-model="form.category_id" id="country"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                                                    <option value="" disabled>
                                                        Избери Категорија
                                                    </option>
                                                    <option v-for="category in categories" :key="category.id"
                                                        :value="category.id">
                                                        {{ category . name }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600">{{ form . errors . category_id }}</span>
                                            </div>




                                            <div class="md:col-span-3">
                                                <InputLabel for="name">Име на Моделот</InputLabel>

                                                <TextInput v-model="form.model" type="text" id="name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" />
                                                <span
                                                    class="text-xs italic text-red-600">{{ form . errors . model }}</span>
                                            </div>

                                        </div>


                                        <!-- Опис -->
                                        <div class="md:col-span-6 mt-8">
                                            <InputLabel for="description">Опис</InputLabel>
                                            <textarea v-model="form.description" id="notes"
                                                class="w-full border px-4 py-2 rounded focus:border-blue-500 focus:shadow-outline outline-none" rows="5"
                                                placeholder="Опис ..."></textarea>
                                            <span
                                                class="text-xs italic text-red-600">{{ form . errors . description }}</span>
                                        </div>

                                        <div class="text-right md:col-span-5">
                                            <div class="inline-flex items-end">
                                                <button type="submit"
                                                    class="px-4 py-2 font-bold text-white rounded bg-sky-500 hover:bg-sky-700">
                                                    Зачувај
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
