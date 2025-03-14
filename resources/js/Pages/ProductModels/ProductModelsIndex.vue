<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import { computed, ref, watch, onMounted } from "vue";
import { debounce } from "lodash";
import EditIcon from "../../Components/EditIcon.vue";
import DeleteIcon from "../../Components/DeleteIcon.vue";
import AddIcon from "../../Components/AddIcon.vue";

const props = defineProps({
    productModels: Object,
});

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

// Delete manufacturer function
const deleteProductModel = (id) => {
    if (confirm("Дали сигурно сакаш да го избришеш овој Модел на Производ?")) {
        router.delete("/productmodels/delete/" + id, {
            preserveState: false,
            onSuccess: () => {
                flashMessage.value = props.flash.message;
            },
        });
    }
};

onMounted(() => {
    if (flashMessage.value) {
        setTimeout(() => {
            flashMessage.value = "";
        }, 3000);
    }
});
</script>

<template>
    <Head title="Модели на Производи" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <!-- message -->
                <div
                    v-if="flashMessage"
                    class="px-4 py-2 rounded-md bg-sky-200"
                >
                    {{ flashMessage }}
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between mb-4">
                            <h2 class="font-bold text-sky-800">
                                Модели на Производи
                            </h2>
                            <div class="flex">
                                <Link
                                    href="productmodels/create"
                                    class="mx-4 mt-2 text-5xl hover:text-sky-500 text-slate-500"
                                >
                                    <AddIcon />
                                </Link>
                            </div>
                        </div>

                        <table
                            class="min-w-full divide-y divide-gray-200 shadow table-auto sm:rounded-lg"
                        >
                            <thead class="bg-primary">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        index
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Категорија
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Модел
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Опис
                                    </th>


                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Акција
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    class="hover:bg-slate-100"
                                    v-for="productModel in productModels"
                                    :key="productModel.id"
                                >
                                    <td class="text-xs text-slate-300">
                                        {{ productModel.id }} {{}}
                                    </td>

                                    <td class="font-bold text-emerald-700">
                                        {{ productModel.category.name }}
                                    </td>
                                    <td class="font-sm italic text-zinc-500">
                                        {{ productModel.model }}
                                    </td>

                                    <td class="font-sm italic text-zinc-500">
                                        {{ productModel.description }}
                                    </td>
                                    

                                    <td class="">
                                        <div class="flex gap-2">
                                            <Link
                                                class="hover:text-green-600 text-slate-300"
                                                :href="
                                                    route(
                                                        'productmodels.edit',
                                                        productModel.id,
                                                    )
                                                "
                                            >
                                                <EditIcon
                                                    v-tippy="{
                                                        content: 'Измени',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"
                                                />
                                            </Link>

                                            <button
                                                class="hover:text-red-700 text-slate-300"
                                                @click="
                                                    () =>
                                                        deleteProductModel(
                                                            productModel.id,
                                                        )
                                                "
                                            >
                                                <DeleteIcon
                                                    v-tippy="{
                                                        content: 'Избриши',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"
                                                />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
