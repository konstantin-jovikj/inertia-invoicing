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
    regulations: Array,
    directives: Array,
    category: Object,
});

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

// Delete bank function
const deleteBank = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш оваа банка?")) {
        router.delete("/bank/delete/" + id, {
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

// Update association for regulation
const toggleRegulationAssociation = (regulationId, isChecked) => {
    router.post(`/categories/${props.category.id}/toggle-regulation`, {
        regulation_id: regulationId,
        associate: isChecked,
    });
};

// Update association for directive
const toggleDirectiveAssociation = (directiveId, isChecked) => {
    router.post(`/categories/${props.category.id}/toggle-directive`, {
        directive_id: directiveId,
        associate: isChecked,
    });
};
</script>

<template>
    <Head title="EU regulatives and Directives" />

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
                        <div class="mb-4">
                            <div>
                                <h2 class="font-semibold text-sky-800">
                                    Поврзување/Асоцијација на ЕУ регулативи и
                                    Директиви со Категорија
                                </h2>
                            </div>
                            <div
                                class="my-6 mx-auto w-full text-center bg-gray-100 py-4 rounded-md"
                            >
                                <div
                                    class="flex justify-center align-middle content-center"
                                >
                                    <span
                                        class="text-normal font-semibold text-slate-700 block"
                                        >{{ category.name }}</span
                                    >
                                </div>
                            </div>

                            <div class="my-2">
                                <h3 class="text-sky-700 font-semibold ps-6">
                                    ЕУ Регулативи
                                </h3>
                            </div>
                            <table
                                class="min-w-full divide-y divide-gray-200 shadow table-auto sm:rounded-lg"
                            >
                                <thead class="bg-primary">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                        >
                                            Бр
                                        </th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                        >
                                            Регулативи
                                        </th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                        >
                                            Опис
                                        </th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                        >
                                            Асоцијации
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr
                                        class="hover:bg-slate-100"
                                        v-for="regulation in regulations"
                                        :key="regulation.id"
                                    >
                                        <td class="text-lg text-slate-600">
                                            {{ regulation.id }}
                                        </td>
                                        <td
                                            class="text-md text-purple-700 font-bold"
                                        >
                                            {{ regulation.regulation }}
                                        </td>
                                        <td class="text-xs text-slate-600 px-2">
                                            {{ regulation.description }}
                                        </td>
                                        <td>
                                            <input
                                                type="checkbox"
                                                @change="
                                                    toggleRegulationAssociation(
                                                        regulation.id,
                                                        $event.target.checked,
                                                    )
                                                "
                                                :checked="
                                                    category.regulations.some(
                                                        (r) =>
                                                            r.id ===
                                                            regulation.id,
                                                    )
                                                "
                                                id="is_for_export"
                                                class="w-4 h-4 mt-1 border rounded bg-gray-50"
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-8">
                                <div class="my-2">
                                    <h3
                                        class="text-emerald-700 font-semibold ps-6"
                                    >
                                        ЕУ Директиви
                                    </h3>
                                </div>
                                <table
                                    class="min-w-full divide-y divide-gray-200 shadow table-auto sm:rounded-lg"
                                >
                                    <thead class="bg-primary">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-emerald-700"
                                            >
                                                Бр
                                            </th>
                                            <th
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-emerald-700"
                                            >
                                                Директиви
                                            </th>
                                            <th
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-emerald-700"
                                            >
                                                Опис
                                            </th>
                                            <th
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-emerald-700"
                                            >
                                                Асоцијации
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200"
                                    >
                                        <tr
                                            class="hover:bg-slate-100"
                                            v-for="directive in directives"
                                            :key="directive.id"
                                        >
                                            <td class="text-lg text-slate-600">
                                                {{ directive.id }}
                                            </td>
                                            <td
                                                class="text-md text-purple-700 font-bold"
                                            >
                                                {{ directive.directive }}
                                            </td>
                                            <td
                                                class="text-xs text-slate-600 px-2"
                                            >
                                                {{ directive.description }}
                                            </td>
                                            <td>
                                                <input
                                                    type="checkbox"
                                                    :checked="
                                                        category.directives.some(
                                                            (d) =>
                                                                d.id ===
                                                                directive.id,
                                                        )
                                                    "
                                                    @change="
                                                        toggleDirectiveAssociation(
                                                            directive.id,
                                                            $event.target
                                                                .checked,
                                                        )
                                                    "
                                                />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
