<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { nl2br } from '@/common'
    import { Inertia } from '@inertiajs/inertia'
    import { useForm } from '@inertiajs/vue3';
    import { reactive } from 'vue';

    const deleteItem = id => {
        Inertia.delete(route('items.destroy', { item: id }), {
            onBefore: () => confirm('本当に削除しますか?')
        })
    }


const props = defineProps({
    item: Object
})

const form = useForm({
  item_id: props.item.id,
  quantity: 1,
  is_selling: props.item.is_selling
})

const purchaseItem = id => {
    Inertia.get(route('purchases.store', { item: id }), form)
}

</script>

<template>

    <Head title="商品詳細" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品詳細
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font overflow-hidden">
		        <form @submit.prevent="form.post(route('purchases.store'))">
                            <div class="container px-5 py-24 mx-auto">
                                <div class="lg:w-4/5 mx-auto flex flex-wrap">
                                    <img alt="ecommerce"
                                        class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded"
                                        :src="item.image_url" >
                                    <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                                        <h2 class="text-sm title-font text-gray-500 tracking-widest">{{ item.author }}
                                        </h2>
                                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ item.name }}
                                        </h1>
                                        <div class="flex mb-4">
                                            <span v-if="item.is_selling === 1">販売中</span>
                                            <span v-if="item.is_selling === 0">停止中</span>
                                        </div>
                                        <div id="memo" v-html="nl2br(item.memo)" class="leading-relaxed">
                                        </div>
                                        <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
                                            <div class="flex ml-6 items-center">
                                                <span class="mr-3">数量</span>
                                                <div class="relative">
                                                    <select v-model="form.quantity"
                                                        class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                                        <option :value="1">1</option>
                                                        <option :value="2">2</option>
                                                        <option :value="3">3</option>
                                                        <option :value="4">4</option>
                                                    </select>
                                                    <span
                                                        class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                                                        <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" class="w-4 h-4"
                                                            viewBox="0 0 24 24">
                                                            <path d="M6 9l6 6 6-6"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <span class="title-font font-medium text-2xl text-gray-900">&yen{{
                                                item.price.toLocaleString() }}</span>

                                            <button type="submit"
                                                class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">購入する</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
			    </form>
                                        <div class="p-2 w-full">
                                            <Link v-if="$page.props.auth.user.name === 'root'" as="button" :href="route('items.edit', { item: item.id })"
                                                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg btn btn-primary">編集する</Link>
                                        </div>
                                        <div class="mt-20 p-2 w-full">
                                            <button v-if="$page.props.auth.user.name === 'root'" @click="deleteItem(item.id)" class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除する</button>
                                        </div>

                        </section>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
