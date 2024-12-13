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
import DocumentNewIcon from "@/Components/DocumentNewIcon.vue";
import { latinToCyrillic } from "@/helpers/latinToCyrillic"; // Adjust the path if needed

const props = defineProps({
    documentTypes: Array,
});

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

onMounted(() => {
    if (flashMessage.value) {
        setTimeout(() => {
            flashMessage.value = "";
        }, 3000);
    }
});

const colors = [
    "bg-red-500",
    "bg-fuchsia-600",
    "bg-lime-600",
    "bg-amber-600",
    "bg-sky-500",
    "bg-stone-600",
    "bg-teal-700",
    "bg-orange-300",
];

console.log(props.documentTypes);
</script>

<template>
    <Head title="Documents" />

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
                                Видови на Документи
                            </h2>
                        </div>

                        <!-- Card start -->
                        <div class="flex gap-4 flex-wrap">
                            <div
                                v-for="(
                                    documentType, index
                                ) in props.documentTypes"
                                :key="documentType.id"
                                class="group relative cursor-pointer overflow-hidden bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 transition-all duration-800 hover:-translate-y-1 hover:shadow-2xl sm:max-w-xs sm:rounded-lg sm:px-10"
                            >
                                <!-- Dynamic color -->
                                <span
                                    :class="`${colors[index % colors.length]} absolute top-10 z-0 h-20 w-20 rounded-full transition-all duration-800 group-hover:scale-[10]`"
                                ></span>
                                <div class="relative z-10 mx-auto max-w-md">
                                    <span
                                        :class="`grid h-20 w-20 place-items-center rounded-full transition-all duration-800 ${colors[index % colors.length]} group-hover:bg-${colors[index % colors.length].replace('bg-', 'lighter-')}`"
                                    >
                                        <DocumentNewIcon
                                            :class="`h-10 w-10 text-white transition-all group-hover:text-${colors[index % colors.length].replace('bg-', '')}`"
                                        />
                                    </span>
                                    <p
                                        class="mt-4 font-semibold text-zinc-400  group-hover:text-white"
                                        v-if="documentType.latest_document"
                                    >
                                        Последен Документ:
                                        {{
                                            documentType.latest_document
                                                .document_no
                                        }}
                                        {{
                                            new Date(
                                                documentType.latest_document.date,
                                            ).toLocaleDateString("en-GB")
                                        }}
                                    </p>
                                    <p
                                    class="mt-4 font-semibold text-sky-800 italic group-hover:text-white"
                                     v-else>Нема документ од овој тип.</p>
                                    <div
                                        class="space-y-6 pt-5 text-base leading-7 text-gray-600 transition-all duration-800 group-hover:text-white/90"
                                    >
                                        <p
                                            :class="`font-bold text-xl text-stone-500 group-hover:text-white`"
                                        >
                                            {{
                                                latinToCyrillic(
                                                    documentType.type,
                                                )
                                            }}
                                        </p>
                                    </div>
                                    <div
                                        class="pt-5 text-base font-semibold leading-7"
                                    >
                                        <p>
                                            <Link
                                                :href="`/documents/add/${documentType.id}`"
                                                :class="`text-black transition-all duration-800 group-hover:text-white`"
                                                >Направи нов документ &rarr;
                                            </Link>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card end -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
