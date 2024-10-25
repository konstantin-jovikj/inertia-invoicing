<script setup>
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-11/12 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-end mb-4">
                            <Link
                            href="#"
                                class="px-4 py-2 mr-10 text-3xl rounded-lg hover:bg-sky-400 bg-sky-200"
                                >+</Link
                            >
                            <TextInput
                                placeholder="Барај ..."
                                v-model="search"
                                type="search"
                            />
                        </div>



                        <!-- Pagination Links -->

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

