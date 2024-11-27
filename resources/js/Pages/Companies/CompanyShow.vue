<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import EditIcon from "../../Components/EditIcon.vue";
import DeleteIcon from "../../Components/DeleteIcon.vue";
import AddAccountIcon from "@/Components/AddAccountIcon.vue";
import AddContactIcon from "@/Components/AddContactIcon.vue";
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
                : `http://${props.company.web}`,
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

const toggleActive = (id) => {
    router.patch(
        `/activate/account/${id}`,
        {},
        {
            preserveState: true, // Keeps current component state (like pagination, sorting)
            onSuccess: (page) => {
                flashMessage.value = page.props.flash.message;
            },
            onError: (errors) => {
                console.error("Error toggling active status:", errors);
            },
        },
    );
};

// Delete Account function
const deleteAccount = (id) => {
    if (confirm("Дали сигурно сакаш да ја избришеш оваа банкарска сметка?")) {
        router.delete("/accounts/delete/" + id, {
            preserveState: false,
            onSuccess: () => {
                flashMessage.value = props.flash.message;
            },
        });
    }
};
</script>

<template>
    <Head :title="company.name" />

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
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg border-red-600 border-2"
                >
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
                                                    company.id,
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
                                <div
                                    class="flex items-center justify-between px-6 mb-4 bg-slate-100"
                                >
                                    <span class="text-lg font-bolder">
                                        Контакти
                                    </span>
                                    <div>
                                        <Link
                                            class="px-1 hover:text-orange-600 text-slate-300"
                                            :href="
                                                route(
                                                    'contacts.create',
                                                    company.id,
                                                )
                                            "
                                        >
                                            <AddContactIcon
                                                v-tippy="{
                                                    content: 'Додај Контакт',
                                                    arrow: true,
                                                    theme: 'light',
                                                }"
                                            />
                                        </Link>
                                    </div>
                                </div>
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
                                                <div
                                                    class="flex justify-end gap-2"
                                                >
                                                    <Link
                                                        class="hover:text-green-600 text-slate-300"
                                                        :href="
                                                            route(
                                                                'contact.edit',
                                                                contact.id,
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
                                                                    contact.id,
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
                                <Link
                                    class="hover:text-sky-600 text-slate-300"
                                    :href="route('account.create', company.id)"
                                >
                                    <AddAccountIcon
                                        v-tippy="{
                                            content:
                                                'Додај Нова Банкарска Сметка',
                                            arrow: true,
                                            theme: 'light',
                                        }"
                                    />
                                </Link>
                                <h2 class="mt-4 font-bold">Банкарски Сметки</h2>
                                <hr />
                                <!-- BANKARSKI SMETKI TABELA -->
                                <div
                                    class="container p-2 mx-auto sm:p-4 dark:text-gray-800"
                                >
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-xs">
                                            <colgroup>
                                                <col />
                                                <col />
                                                <col />
                                                <col class="w-24" />
                                            </colgroup>
                                            <thead class="dark:bg-gray-300">
                                                <tr class="text-left">
                                                    <th class="p-3">Банка</th>
                                                    <th class="p-3">Статус</th>
                                                    <th class="p-3">Тип</th>
                                                    <th class="p-3">Акција</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="account in company.accounts"
                                                    :key="account.id"
                                                    class="border-b border-opacity-20 dark:border-gray-300 dark:bg-gray-50"
                                                >
                                                    <td class="p-3">
                                                        <p
                                                            v-if="
                                                                account.is_for_export
                                                            "
                                                        >
                                                            {{
                                                                account.bank
                                                                    .name_lat
                                                            }}
                                                        </p>
                                                        <p v-else>
                                                            {{
                                                                account.bank
                                                                    .name_cyr
                                                            }}
                                                        </p>
                                                    </td>
                                                    <td class="p-3">
                                                        <div
                                                            class="inline-flex items-center gap-2"
                                                        >
                                                            <label
                                                                class="text-sm cursor-pointer text-slate-600"
                                                                >Неактивна</label
                                                            >

                                                            <div
                                                                class="relative inline-block h-5 w-11"
                                                            >
                                                                <input
                                                                    type="checkbox"
                                                                    :checked="
                                                                        account.is_active
                                                                    "
                                                                    @change="
                                                                        toggleActive(
                                                                            account.id,
                                                                        )
                                                                    "
                                                                    class="h-5 transition-colors duration-300 rounded-full appearance-none cursor-pointer peer w-11 bg-slate-100 checked:bg-emerald-700"
                                                                />
                                                                <label
                                                                    class="absolute top-0 left-0 w-5 h-5 transition-transform duration-300 bg-white border rounded-full shadow-sm cursor-pointer border-slate-300 peer-checked:translate-x-6 peer-checked:border-green-800"
                                                                ></label>
                                                            </div>

                                                            <label
                                                                :class="
                                                                    account.is_active
                                                                        ? ' text-green-600 font-bold'
                                                                        : ' text-slate-600'
                                                                "
                                                                class="text-sm cursor-pointer"
                                                                >Активна</label
                                                            >
                                                        </div>
                                                    </td>
                                                    <td class="p-3">
                                                        <p
                                                            class="dark:text-gray-600"
                                                            v-if="
                                                                account.is_for_export
                                                            "
                                                        >
                                                            Девизна (извоз)
                                                        </p>
                                                        <p
                                                            class="dark:text-gray-600"
                                                            v-else
                                                        >
                                                            Денарска
                                                        </p>
                                                    </td>

                                                    <td class="p-3 text-right">
                                                        <div class="flex gap-2">
                                                            <Link
                                                                class="hover:text-green-600 text-slate-300"
                                                                :href="
                                                                    route(
                                                                        'account.edit',
                                                                        account.id,
                                                                    )
                                                                "
                                                            >
                                                                <EditIcon
                                                                    v-tippy="{
                                                                        content:
                                                                            'Измени',
                                                                        arrow: true,
                                                                        theme: 'light',
                                                                    }"
                                                                />
                                                            </Link>
                                                            <!-- //Delete -->
                                                            <button
                                                                class="hover:text-red-700 text-slate-300"
                                                                @click="
                                                                    () =>
                                                                        deleteAccount(
                                                                            account.id,
                                                                        )
                                                                "
                                                            >
                                                                <DeleteIcon
                                                                    v-tippy="{
                                                                        content:
                                                                            'Избриши Сметка',
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
                        <div class="flex justify-between mb-4">
                            <h2 class="p-6 text-sky-800">Документи</h2>
                        </div>
                        <div
                            class="w-full p-4 border border-blue-500 rounded md:w-50"
                        >
                            <table
                                class="min-w-full text-sm font-light text-center border-collapse text-surface border-e"
                            >
                                <thead
                                    class="font-medium border-b border-neutral-200"
                                >
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-2 py-1 text-gray-400"
                                        >
                                            Id
                                        </th>
                                        <th scope="col" class="px-2 py-1">
                                            Бр
                                        </th>
                                        <th scope="col" class="px-2 py-1">
                                            Опис
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        class="border-b border-neutral-200 border-e"
                                    >
                                        <td
                                            class="px-2 py-1 text-right whitespace-nowrap border-e"
                                        >
                                            1
                                        </td>
                                        <td
                                            class="px-2 py-1 text-right whitespace-nowrap border-e"
                                        >
                                            2
                                        </td>
                                        <td
                                            class="px-2 py-1 text-right whitespace-nowrap border-e"
                                        >
                                            3
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
