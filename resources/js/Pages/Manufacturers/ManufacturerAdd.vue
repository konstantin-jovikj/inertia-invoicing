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
    import { computed } from "vue";


    const auth = usePage().props.auth;

    const props = defineProps({

        places: {
            type: Array,
            required: true,
        },
        countries: {
            type: Array,
            required: true,
        },
    });


    const form = useForm({
        // id: '',
        place_id: '',
        country_id: '',
        address: '',
        name: '',
    });

    // Filter places based on selected country
    const filteredPlaces = computed(() => {
        return props.places.filter(place => place.country_id === form.country_id);
    });

    const submit = () => {
        console.log(form)
    }
</script>

<template>

    <Head title="Manufacturers" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form
                            @submit.prevent="form.post('/manufacturer/store/', {
                            onError: () => form.reset()
                        })">

                            <div class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8">
                                <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3">
                                    <div class="text-gray-600">
                                        <p class="text-lg font-medium">
                                            Измени го Производителот / Добавувачот
                                        </p>
                                        <p>
                                            Ажурирај ги податоците за Производителот / Добавувачот
                                        </p>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-6">
                                            <div class="md:col-span-3">
                                                <InputLabel for="name">Име</InputLabel>

                                                <TextInput v-model="form.name" type="text" id="name"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" />
                                                <span class="text-xs italic text-red-600">{{ form . errors . name }}</span>
                                            </div>

                                            <div class="md:col-span-3">
                                                <InputLabel for="address">Адреса</InputLabel>

                                                <TextInput v-model="form.address" type="text" id="address"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" />
                                                <span
                                                    class="text-xs italic text-red-600">{{ form . errors . address }}</span>
                                            </div>

                                            <!-- Country -->
                                            <div class="md:col-span-3">
                                                <InputLabel for="country">Одбери Држава</InputLabel>
                                                <select v-model="form.country_id" id="country"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                                                    <option value="" disabled>Избери држава</option>
                                                    <option v-for="country in countries" :key="country.id"
                                                        :value="country.id">
                                                        {{ country . name }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600">{{ form . errors . country_id }}</span>
                                            </div>

                                            <!-- Place -->
                                            <div class="md:col-span-3">
                                                <InputLabel for="place">Одбери Место</InputLabel>
                                                <select v-model="form.place_id" id="place"
                                                    class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                                                    <option value="" disabled>Избери Место</option>
                                                    <option v-for="place in filteredPlaces" :key="place.id"
                                                        :value="place.id">
                                                        {{ place . place }}
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-xs italic text-red-600">{{ form . errors . place_id }}</span>
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
