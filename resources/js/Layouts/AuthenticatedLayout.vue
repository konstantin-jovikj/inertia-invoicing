<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ArrowDown from "@/Components/ArrowDown.vue";
import SettingsIcon from "@/Components/SettingsIcon.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import GearIcon from "@/Components/GearIcon.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="px-4 mx-auto max-w-11/12 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex items-center shrink-0">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <!-- START SETTINGS -->

                            <!-- <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </NavLink>
                            </div> -->

                            <div class="relative flex mt-4 ms-3">
                                <!-- DOKUMENTI -->
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none"
                                            >
                                                Документи

                                                <ArrowDown />
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('document.type.index')"
                                        >
                                            Нов Документ
                                        </DropdownLink>

                                        <DropdownLink
                                            :href="route('document.index')"
                                        >
                                            Листа на Документи
                                        </DropdownLink>
                                    </template>
                                </Dropdown>

                                <!-- END DOKUMENTI -->

                                <!-- //Komintenti (customers) -->

                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none"
                                            >
                                                Клиенти

                                                <ArrowDown />
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('customer.create')"
                                        >
                                            Додај нов Клиент
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('companies.index')"
                                        >
                                            Листа на Клиенти
                                        </DropdownLink>
                                    </template>
                                </Dropdown>


                            </div>
                        </div>

                        <!-- END SETTINGS -->

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3 flex gap-2">

                                
                                <!-- PODESUVANJA -->
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-1 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none"
                                            >
                                                <!-- <SettingsIcon /> -->
                                                 <GearIcon></GearIcon>

                                                <ArrowDown />
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('country.index')"
                                        >
                                            Држави
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('place.index')"
                                        >
                                            Места / Градови
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('manufacturers.index')"
                                        >
                                            Добавувачи
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('customertype.index')"
                                        >
                                            Тип на Клиенти
                                        </DropdownLink>

                                        <DropdownLink
                                            :href="route('banks.index')"
                                        >
                                            Банки
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('declarations.index')"
                                        >
                                            Декларации
                                        </DropdownLink>
                                        <hr />
                                        <DropdownLink
                                            :href="route('directives.index')"
                                        >
                                            Асоцијација на ЕУ Регулативи и
                                            Директиви со Категории
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('regulations.index')"
                                        >
                                            ЕУ Регулативи
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('directivesAll.index')"
                                        >
                                            ЕУ Директиви
                                        </DropdownLink>

                                        <DropdownLink
                                            :href="route('productmodels.index')"
                                        >
                                            Модели
                                        </DropdownLink>

                                        <hr />
                                        <DropdownLink
                                            :href="route('taxes.index')"
                                        >
                                            Стапки на ДДВ
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('currency.index')"
                                        >
                                            Валути
                                        </DropdownLink>
                                        <hr />
                                        <DropdownLink
                                            :href="route('drivers.index')"
                                        >
                                            Возачи
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('vehicles.index')"
                                        >
                                            Возила
                                        </DropdownLink>
                                        <hr />
                                        <DropdownLink
                                            :href="
                                                route(
                                                    'companies.notcustomer.index',
                                                )
                                            "
                                        >
                                            Сопствени Фирми
                                        </DropdownLink>
                                    </template>
                                </Dropdown>

                                <!-- END PODESUVANJA -->
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="flex items-center -me-2 sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="w-6 h-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
