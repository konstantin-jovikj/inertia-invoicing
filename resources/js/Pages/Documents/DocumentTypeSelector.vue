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
    documentTypes: Object,
});

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

// Delete bank function
const deleteTax = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш оваа ДДВ Ставка?")) {
        router.delete("/taxes/delete/" + id, {
            preserveState: false,
            onSuccess: () => {
                flashMessage.value = pageProps.flash?.message || ""; // Use pageProps.flash
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
                        <div class="flex gap-4 flex-wrap">
                            <div
                                v-for="documentType in documentTypes.data"
                                :key="documentType.id"
                                class="group relative cursor-pointer overflow-hidden bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl sm:max-w-xs sm:rounded-lg sm:px-10"
                            >
                                <span
                                    class="absolute top-10 z-0 h-20 w-20 rounded-full bg-sky-500 transition-all duration-300 group-hover:scale-[10]"
                                ></span>
                                <div class="relative z-10 mx-auto max-w-md">
                                    <span
                                        class="grid h-20 w-20 place-items-center rounded-full bg-sky-500 transition-all duration-300 group-hover:bg-sky-400"
                                    >
                                    <DocumentNewIcon 
                                        class="h-10 w-10 text-white transition-all"
                                    ></DocumentNewIcon>
                                    
                                    </span>
                                    <div
                                        class="space-y-6 pt-5 text-base leading-7 text-gray-600 transition-all duration-300 group-hover:text-white/90"
                                    >
                                        <p class="font-bold text-xl text-sky-700">
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
                                                class="text-sky-500 transition-all duration-300 group-hover:text-white"
                                                >Направи нов документ &rarr;
                                            </Link>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
