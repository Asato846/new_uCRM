<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue'; 

const props = defineProps({
    purchases: Array
});

const total = computed(() => {
    return props.purchases.reduce((sum, purchase) => {
        const subtotal = purchase.subtotal || 0;
        return sum + subtotal;
    }, 0);
});
</script>

<template>
    <Head title="購入履歴" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">購入履歴</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <section class="text-gray-600 body-font">
                          <div class="container px-5 py-8 mx-auto">
                            <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                            </div>
                            <div v-if="purchases.length > 0" class="lg:w-2/3 w-full mx-auto overflow-auto">
                              <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                  <tr>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">数量</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">小計</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">購入日</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="purchase in purchases" :key="purchase.id">
                                    <td class="border-b-2 border-gray-200 px-4 py-3">{{ purchase.item_name }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3">{{ purchase.quantity }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3">&yen;{{ purchase.subtotal.toLocaleString() }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3">{{ new Date(purchase.updated_at).toLocaleString() }}</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
			    <div v-else class="text-center text-gray-500 text-lg">
                                    購入情報はありません。
                                </div>
                            <div v-if="purchases.length > 0" class="w-full flex justify-end mt-4 text-black">
                                <span class="text-2xl">合計金額:</span>
                                <span class="font-bold text-2xl ml-2">&yen;{{ total.toLocaleString() }}</span>
                            </div>
                          </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
