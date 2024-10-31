<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import EditIcon from "../../Components/EditIcon.vue";
import DeleteIcon from "../../Components/DeleteIcon.vue";

import { computed, ref, watch, onMounted } from "vue";

const props = defineProps({
    company: Object,
    searchTerm: String,
});

const companyContacts = props.company.contacts;
console.log("Company:", props.company);

const { props: pageProps } = usePage();
const flashMessage = ref(pageProps.flash?.message || "");

// Delete contact function
const deleteContact = (id) => {
    if (confirm("Дали сигурно сакаш да го избришеш овој контакт?")) {
        router.delete("/contacts/delete/" + id, {
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

const websiteDomain = computed(() => {
    try {
        const url = new URL(
            props.company.web.startsWith("http")
                ? props.company.web
                : `http://${props.company.web}`
        );
        return {
            href: url.href, // Complete URL with protocol
            hostname: url.hostname, // Just the domain, e.g., "www.frigosan.com.mk"
        };
    } catch (error) {
        return {
            href: props.company.web,
            hostname: props.company.web,
        };
    }
});
console.log(props.company.web);
</script>

<template>
    <Head title="Companies" />

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
                            <h2 class="px-6 text-sky-800">
                                Детални информации
                            </h2>
                        </div>

                        <div class="flex flex-col gap-2 lg:flex-row">
                            <div
                                class="w-full p-4 border border-blue-500 rounded md:w-50"
                            >
                                <div>
                                    <div class="pb-2">
                                        <Link
                                            class="hover:text-green-600 text-slate-300"
                                            :href="
                                                route(
                                                    'company.edit',
                                                    company.id
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
                                    </div>
                                    <h2
                                        class="text-xl font-bold"
                                        v-if="company.name"
                                    >
                                        {{ company.name }}
                                    </h2>
                                    <p v-if="company.address">
                                        {{ company.address }}
                                    </p>
                                    <p v-if="company.place">
                                        {{ company.place.zip }} -
                                        {{ company.place.place }}
                                    </p>
                                    <p
                                        v-if="
                                            company.place &&
                                            company.place.country
                                        "
                                    >
                                        {{ company.place.country.name }}
                                    </p>
                                    <hr class="py-2" />
                                    <p v-if="company.tax_number">
                                        <span class="text-sm italic"
                                            >Даночен Бр : </span
                                        >{{ company.tax_number }}
                                    </p>
                                    <p v-if="company.reg_number">
                                        <span class="text-sm italic"
                                            >Рег Бр / ЕМБС : </span
                                        >{{ company.reg_number }}
                                    </p>
                                    <p v-if="company.web">
                                        <span class="text-sm italic"
                                            >Web :
                                        </span>
                                        <a
                                            :href="websiteDomain.href"
                                            target="_blank"
                                            class="text-sky-600"
                                        >
                                            {{ websiteDomain.href }}
                                        </a>
                                    </p>
                                </div>
                                <hr class="my-4" />
                                <h2
                                    class="px-6 py-2 mb-4 text-lg font-bolder bg-slate-100"
                                >
                                    Контакти
                                </h2>
                                <div class="px-6">
                                    <!-- <hr class="my-4" /> -->
                                    <ul class="list-disc">
                                        <p
                                            class="text-red-500"
                                            v-if="companyContacts.length === 0"
                                        >
                                            Не се пронајдени контакти.
                                        </p>
                                        <li
                                            class="p-4 mb-6 hover:bg-slate-50"
                                            v-for="contact in companyContacts"
                                            :key="contact.id"
                                        >
                                            <div class="flex justify-between">
                                                <div>
                                                    <span class="font-bold"
                                                        >{{
                                                            contact.first_name
                                                        }}
                                                        {{
                                                            contact.last_name
                                                        }}</span
                                                    >

                                                    <span> - </span>
                                                    <span
                                                        class="text-teal-800"
                                                        >{{
                                                            contact.position
                                                        }}</span
                                                    >
                                                </div>
                                                <div class="flex justify-end">
                                                    <Link
                                                        class="hover:text-green-600 text-slate-300"
                                                        :href="
                                                            route(
                                                                'contact.edit',
                                                                contact.id
                                                            )
                                                        "
                                                    >
                                                        <EditIcon
                                                            v-tippy="{
                                                                content:
                                                                    'Едитирај Контакт',
                                                                arrow: true,
                                                                theme: 'light',
                                                            }"
                                                        />
                                                    </Link>

                                                    <button
                                                        class="hover:text-red-700 text-slate-300"
                                                        @click="
                                                            () =>
                                                                deleteContact(
                                                                    contact.id
                                                                )
                                                        "
                                                    >
                                                        <DeleteIcon
                                                            v-tippy="{
                                                                content:
                                                                    'Избриши Контакт',
                                                                arrow: true,
                                                                theme: 'light',
                                                            }"
                                                        />
                                                    </button>
                                                </div>
                                            </div>
                                            <p>
                                                <span class="text-xs italic"
                                                    >емаил: </span
                                                ><a
                                                    :href="`mailto:${contact.email}`"
                                                    ><span
                                                        class="text-sky-600"
                                                        >{{
                                                            contact.email
                                                        }}</span
                                                    ></a
                                                >
                                            </p>

                                            <p>
                                                <span class="text-xs italic"
                                                    >телефон: </span
                                                >{{ contact.phone }}
                                            </p>
                                            <p>
                                                <span class="text-xs italic"
                                                    >мобилен:
                                                </span>
                                                {{ contact.mob }}
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div
                                class="w-full p-4 border border-blue-500 rounded md:w-50"
                            >
                                <h2>Листа на документи</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
