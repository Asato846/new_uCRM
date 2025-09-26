<script setup>
    import WelcomeLayout from '@/Layouts/WelcomeLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import Pagination from '@/Components/Pagination.vue';
    import { Inertia } from '@inertiajs/inertia'
    import { ref } from 'vue'

    defineProps({
        items: Object
    })

    const search = ref('')
    const searchItems = () => {
        Inertia.get(route('items.index', { search: search.value }))
    }
</script>

<template>

    <Head title="商品一覧" />

    <WelcomeLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品一覧</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex w-full justify-center items-end mt-6">
                        <div class="relative mr-4 lg:w-full xl:w-1/2 w-2/4 md:w-full text-left">
                            <input input type="text" name="search" v-model="search"
                                class="w-full bg-gray-100 bg-opacity-50 rounded focus:ring-2 focus:ring-indigo-200 focus:bg-transparent border border-gray-300 focus:boorder-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <button @click="searchItems"
                            class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">検索</button>
                    </div>

                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 p-4">
                            <div v-for="item in items.data" :key="item.id"
                                class="bg-white shadow rounded-lg p-4 flex flex-col items-center">
                                <img alt="image" class="object-cover object-center w-full h-full block"
                                    :src="item.image_url" />
                                <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ item.author }}</h3>
                                <p class="mt-1">&yen{{ item.price.toLocaleString() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center mb-4">
                        <Pagination class="mt-6" :links="items.links"></Pagination>
                    </div>
                </div>
            </div>
        </div>
    </WelcomeLayout>
</template>
