<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        item : Object,
	errors: Object
    })

    const form = useForm({
        _method: 'put',
	id: props.item.id,
        name: props.item.name,
        author: props.item.author,
        memo: props.item.memo,
        price: props.item.price,
        file: null,
	is_selling: props.item.is_selling
    })

    const updateItem = id => {
        form.post(route('items.update', { item: form.id }))
    }

</script>
<template>

    <Head title="商品編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品編集
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <BreezeValidationErrors :errors="errors"/>
                        <section class="text-gray-600 body-font relative">

                            <form @submit.prevent="updateItem" enctype="multipart/form-data">
                                <div class="container px-5 py-8 mx-auto">

                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="name"
                                                        class="leading-7 text-sm text-gray-600">商品名</label>
                                                    <input type="text" id="name" name="name" v-model="form.name"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="author"
                                                        class="leading-7 text-sm text-gray-600">著者名</label>
                                                    <input type="text" id="author" name="author" v-model="form.author"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                                    <textarea id="memo" name="memo" v-model="form.memo"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="price"
                                                        class="leading-7 text-sm text-gray-600">商品価格</label>
                                                    <input type="number" id="price" name="price" v-model="form.price" 
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="submitted_file"
							   class="leading-7 text-sm text-gray-600">登録されている画像</label>
						    <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded"
                                                       :src="item.image_url" >
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="file"
                                                        class="leading-7 text-sm text-gray-600">画像を変更する場合は選択</label>
                                                    <input type="file" id="file" name="file" @change="form.file = $event.target.files[0]"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                           </div>


<div class="p-2 w-full">
  <div class="relative">
    <label class="leading-7 text-sm text-gray-600 mb-2 block">ステータス</label>
    <div class="flex gap-10">
      <!-- 販売中 -->
      <div class="inline-flex items-center">
        <label class="relative flex cursor-pointer items-center rounded-full p-3" for="selling">
          <input
            type="radio"
            id="selling"
            name="is_selling"
            value="1"
            v-model="form.is_selling"
            class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all"
          />
          <span class="absolute bg-indigo-600 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></span>
        </label>
        <label for="selling" class="text-slate-600 cursor-pointer text-sm">販売中</label>
      </div>

      <!-- 停止中 -->
      <div class="inline-flex items-center">
        <label class="relative flex cursor-pointer items-center rounded-full p-3" for="stopped">
          <input
            type="radio"
            id="stopped"
            name="is_selling"
            value="0"
            v-model="form.is_selling"
            class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all"
          />
          <span class="absolute bg-indigo-600 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></span>
        </label>
        <label for="stopped" class="text-slate-600 cursor-pointer text-sm">停止中</label>
      </div>
    </div>
  </div>
</div>

                                            <div class="p-2 w-full">
                                                <button
                                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" type="submit">更新する</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
