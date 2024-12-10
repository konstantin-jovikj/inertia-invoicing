<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { ModalLink } from "@inertiaui/modal-vue";
import { computed, ref, watch, onMounted } from "vue";
import { debounce } from "lodash";
import EditIcon from "../../../Components/EditIcon.vue";
import DeleteIcon from "../../../Components/DeleteIcon.vue";
import AddIcon from "../../../Components/AddIcon.vue";

const props = defineProps({
    declarations: Object,

});

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");


// Delete bank function
const deleteDeclaration = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш оваа Декларација?")) {
        router.delete("/declaration/delete/" + id, {
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

const getPaginationLabel = (label) => {
    // Handle special cases for prev/next arrows
    if (label === "&laquo; Previous") return "<<";
    if (label === "Next &raquo;") return ">>";
    return label;
};


// console.log(declarations);
</script>

<template>
    <Head title="Banks" />

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
                            <h2 class="font-bold text-sky-800">Декларации</h2>
                            <div class="flex">
                                <ModalLink
                                    href="declaration/create"
                                    class="mx-4 mt-2 text-5xl hover:text-sky-500 text-slate-500"
                                    ><AddIcon
                                /></ModalLink>

  
      
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
                                        Бр
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Наслов
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-sky-700"
                                    >
                                        Содржина
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
                                    v-for="(declaration, index) in declarations.data"
                                    :key="declaration.id"
                                >
                                    <td class="text-xs text-slate-300">
                                        {{ declaration.id }}
                                    </td>
                                    <td class="">
                                        {{ declarations.from + index }} 
                                    </td>
                                    <td class="">{{ declaration.title }}</td>
                                    <td class="">{{ declaration.content }}</td>

                                    <td class="">
                                        <div class="flex gap-2">
                                            <ModalLink
                                                class="hover:text-green-600 text-slate-300"
                                                :href="
                                                    route(
                                                        'declaration.edit',
                                                        declaration.id
                                                    )
                                                "
                                            >
                                                <EditIcon v-tippy="{
                                                        content:
                                                            'Измени Декларација',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"/>
                                            </ModalLink>

                                            <button
                                                class="hover:text-red-700 text-slate-300"
                                                @click="
                                                    () =>
                                                        deleteDeclaration(declaration.id)
                                                "
                                            >
                                                <DeleteIcon v-tippy="{
                                                        content:
                                                            'Избриши Декларација',
                                                        arrow: true,
                                                        theme: 'light',
                                                    }"/>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div
                            v-if="declarations && declarations.links"
                            class="flex flex-col lg:flex-row lg:justify-around"
                        >
                            <div class="mt-2">
                                <Link
                                    v-for="link in declarations.links"
                                    :key="link.label"
                                    :href="link.url || '#'"
                                    class="p-1 mx-1 hover:bg-sky-200"
                                    :class="{
                                        'text-slate-300': !link.url,
                                        'text-sky-500 font-bold': link.active,
                                    }"
                                >
                                    {{ getPaginationLabel(link.label) }}
                                </Link>
                            </div>

                            <p class="mt-3 text-xs text-gray-500">
                                Прикажани се од {{ declarations.from }} до
                                {{ declarations.to }} од вкупно
                                {{ declarations.total }} записи
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>



