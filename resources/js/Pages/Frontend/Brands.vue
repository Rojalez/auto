<style>
    @media (min-width: 640px) {
        table {
            display: inline-table !important;
            border: none;
        }

        thead tr:not(:first-child) {
            display: none;
        }
    }
</style>
<template>
    <main1>

        <div>
            <div class="flex items-center justify-center">
                <div class="container mt-24">
                             <div
                                class="flex flex-wrap py-5 px-5 sm:justify-start justify-center sm:items-start items-center bg-gray-700 rounded-lg">
                                <i class="hidden sm:block py-4 px-2 text-4xl fal fa-long-arrow-right text-yellow-500"></i>
                                <h4 class='py-5 px-2 text-center sm:text-2xl text-lg text-white'>Результаты поиска по запросу: <span class='font-bold text-yellow-500'> {{code}}</span></h4>
                            </div>

                    <div class='hidden sm:block' v-if="brands.length != 0">
                        <table
                            class="w-full flex flex-row flex-no-wrap rounded-lg overflow-hidden sm:shadow-lg my-5">
                            <thead class="text-black bg-gray-300">

                                <tr class="bg-teal-400 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                    <th class="p-3 text-left">Бренд</th>
                                    <th class="p-3 text-left">№ запчасти</th>
                                    <th class="p-3 text-left">Название</th>
                                </tr>
                                
                            </thead>
                             
                            <tbody class="flex-1 sm:flex-none bg-white">
                                <tr  class="flex flex-col flex-no cursor-pointer wrap sm:table-row mb-2 sm:mb-0 border-b hover:bg-gray-200" v-for="brand in brands"  v-bind:key="brand" v-on:click="href(brand)">
                                    <td class=" p-3">{{brand['brand']}}</td>
                                    <td class=" p-3 truncate font-bold" v-if="brand['code']">{{brand['code']}}</td>
                                    <td class=" p-3 truncate font-bold" v-if="brand['art']">{{brand['art']}}</td>
                                    <td class=" p-3 hover:font-medium">{{brand['name']}}</td>
                                    
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    <div v-if="brands.length == 0" class='bg-white rounded-lg my-2 px-2 py-4 text-center md:text-xl text-lg text-gray-600'>
                        <p><i class="fal fa-times-circle mr-1"></i>По вашему запросу ничего не найдено!</p>
                    </div>
                    <div v-if="brands.length != 0">
                        <div class='block sm:hidden p-2' v-for="brand in brands" v-bind:key="brand">
                            <table
                                class="w-full flex flex-row flex-no-wrap rounded-t-lg overflow-hidden sm:shadow-lg my-5">
                                <thead class="text-black bg-gray-300">
                                    <tr class="bg-teal-400 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                        <th class="p-3 text-left">Бренд</th>
                                        <th class="p-3 text-left">№ запчасти</th>
                                        <th class="p-3 text-left">Название</th>
                                        
                                     
                                    </tr>
                                </thead>
                                <tbody class="flex-1 sm:flex-none bg-white">
                                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 ">
                                        <td class=" p-3">{{brand['brand']}}</td>
                                        <td class=" p-3 truncate font-bold" v-if="brand['code']">{{brand['code']}}</td>
                                        <td class=" p-3 truncate font-bold" v-if="brand['art']">{{brand['art']}}</td>
                                        <td class=" p-3 hover:font-medium">{{brand['name']}}</td>
                                    </tr>
                                </tbody>
                                              
                            </table>
                            <a v-if="brand['code']" v-bind:href="'/parts/brands-list/'+brand['code']+'/brand?brand='+brand['brand']" class="p-3 text-center hover:bg-indigo-500 bg-indigo-400 rounded-b text-white block  -mt-6 font-bold">Выбор</a>
                            <a v-if="brand['art']" v-bind:href="'/parts/brands-list/'+brand['art']+'/brand?brand='+brand['brand']" class="p-3 text-center hover:bg-indigo-500 bg-indigo-400 rounded-b text-white block -mt-6 font-bold">Выбор</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </main1>
</template>

<script>
    import Main1 from '@/Pages/Frontend/Layouts/Main.vue'

    export default {
        props: ['brands', 'code'],
        components: {
            Main1
        },

        methods:{
            href:function(brand){
                if(brand['art']) {
                   this.$inertia.get("/parts/brands-list/"+brand['art']+"/brand?brand="+brand['brand']);
                } else{
                    this.$inertia.get("/parts/brands-list/"+brand['code']+"/brand?brand="+brand['brand']);
                }
                
            }

        
        }
    }
</script>