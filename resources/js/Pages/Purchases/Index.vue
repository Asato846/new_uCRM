<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link } from '@inertiajs/vue3';
import { computed,reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia'; //

const props = defineProps({
  purchases: Array
})
const form = reactive({
    selectedItems: Object.fromEntries(props.purchases.map(item => [item.id, true])),
});

const total = computed(() => {
    return props.purchases.reduce((sum, purchase) => {
        if (form.selectedItems[purchase.id]) {
            return sum + (purchase.subtotal || 0);
        }
        return sum;
    }, 0);
});

const purchaseSelected = () => {
    const selectedIds = Object.keys(form.selectedItems).filter(id => form.selectedItems[id]);
    if (selectedIds.length === 0) {
        alert('購入する商品を選択してください');
        return;
    }
    Inertia.put(route('purchases.update'), {
        ids: selectedIds,
    });
};
</script>

<template>
    <Head title="Bungoカート" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bungoカート</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <section class="text-gray-600 body-font">
                          <div class="container px-5 py-8 mx-auto">
                            <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                              <div>
                              </div>
                            </div>
                            <div v-if="purchases.length > 0" class="lg:w-2/3 w-full mx-auto overflow-auto">
                              <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                  <tr>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">購入</th>
				    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
				    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">数量</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">小計</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="purchase in purchases" :key="purchase.id">
                                    <td class="border-b-2 border-gray-200 px-4 py-3">
                                      <input type="checkbox" v-model="form.selectedItems[purchase.id]" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                    </td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3">{{ purchase.item_name }}</td>
				    <td class="border-b-2 border-gray-200 px-4 py-3">{{ purchase.quantity }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3">&yen;{{ purchase.subtotal.toLocaleString() }}</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
			    <div v-else class="text-center text-gray-500 text-lg">
                                    カート情報はありません。
                            </div>
			    
			    <div v-if="purchases.length > 0">
                            <div class="w-full flex justify-end mt-4 text-black">
                                <span class="text-lg">合計金額:</span>
                                <span class="font-bold text-lg ml-2">&yen;{{ total.toLocaleString() }}</span>
                            </div>
			    <div class="flex justify-end mt-4">
                                <button
                                    @click="purchaseSelected"
                                    class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                    購入する
                                </button>
                            </div>
                            </div>

                          </div>
                        </section>

		    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
