<style>
    @media (max-width: 640px) {
        table {
            display: inline-table !important;
            border: none;
            width:768px!important;
            
        }

        thead tr:not(:first-child) {
            display: none;
        }
    }

</style>
<template>
    <main1>

        <div class='relative w-full'>
              <div class="fixed  top-20 right-0 bg-white ring ring-yellow-400 ring-offset-0 font-semibold  rounded-lg px-2 py-2 mx-2 animate-bounce" v-if="isOpen">Товар добавлен в корзину!</div>
            <div class="flex items-center justify-center">
                <div class="container mt-24 mb-6 px-2">
                     <div class='w-full bg-gray-700 rounded-lg'>
                    <h4 class='p-2  text-left sm:text-4xl text-white text-2xl font-bold'>{{parts['brand']}}: <span class='text-yellow-500'> {{parts['code']}}</span></h4>
                    <p class='p-2 sm:text-2xl text-md text-white'>{{parts['name']}}</p>
                    </div>

<!--Искомый товар--> 


                   
    <!--Десктопная версия-->
                    <div class='' v-if="parts['parts'].length != 0">
                        <h4 class='px-2 mt-6 text-left sm:text-3xl text-xl font-bold'>Искомый товар</h4>
                        <div class='overflow-x-auto overflow-y-hidden'>
                            <table
                            class="w-full rounded-lg overflow-hidden sm:shadow-lg my-6">
                            <thead class="text-black bg-gray-300 border-b">
                                <tr class="bg-gray-700 text-white rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                    <th class="p-3 text-left">Запчасть </th>
                                    <th class="p-3 text-left">Поставщик</th>
                                    <th class="p-3 text-left">Номер</th>
                                    <th class="p-3 text-left">Наличие шт.</th>
                                    <th class="p-3 text-left">Доставка</th>
                                    <th class="p-3 text-left">Цена за шт.</th>
                                    <th class="p-3 text-left"></th>
                                </tr>
                                
                            </thead>
                             
                            <tbody class=" bg-white">
                                <tr class="mb-2 sm:mb-0 border-b hover:bg-gray-200" v-for="(part, index) in ordered(parts['parts'])" v-bind:key="index">
                                    <td v-if="parts['parts'].isShow == true || index < 2" class=" p-3">{{part['name']}}</td>
                                    <td v-if="parts['parts'].isShow == true || index < 2" class=" p-3">{{part['postav']}}</td>
                                    <td v-if="parts['parts'].isShow == true || index < 2" class=" p-3 truncate font-bold">{{part['code']}}</td>
                                    <td v-if="parts['parts'].isShow == true || index < 2" class=" p-3 hover:font-medium">{{part['amount']}}</td>
                                    <td v-if="parts['parts'].isShow == true || index < 2" class=" p-3 hover:font-medium">{{part['srok']}}</td>
                                    <td v-if="parts['parts'].isShow == true || index < 2" class=" p-3 hover:font-medium"><span v-if="$page.props.auth.role.can && $page.props.user_id == false">{{part['price']}}</span><span v-else>{{Math.round(part['price'] + part['price'] * part['diapazon'] / 100)}}</span></td>
                                    <td v-if="parts['parts'].isShow == true || index < 2" class=" hover:bg-yellow-400 cursor-pointer bg-gray-700 p-3 hover:font-medium text-center text-white" @click="openModal" v-on:click="save(part)">В корзину</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        
                        <div v-if="parts['parts'].length > 2" class='text-center'><a class='text-center cursor-pointer hover:text-gray-700 p-2 font-bold text-gray-500'  v-on:click="showText(parts['parts'])">{{ parts['parts'].isShow ? 'Свернуть.' : 'Показать ещё предложения.' }}</a></div>
                    </div>
                    <!-- Если товар не найден-->                           
    <div class='bg-gray-300 p-2 my-4 rounded-lg' v-if="parts['parts'].length == 0"><h4 class='text-center text-lg sm:text-2xl text-gray-600'>Товара в данном разделе нет в наличии<i class="fal fa-dolly-flatbed-empty"></i></h4></div>                          
<!---->

<!-- Замена от производителя-->
                 
                    <div class='' v-if="parts['crosses_brand'].length != 0">
                            <h4 class='px-2 mt-6 text-left sm:text-3xl text-xl font-bold'>Аналоги от того же производителя</h4>
                    <div class='overflow-x-auto overflow-y-hidden'>
                        <table
                            class="w-full  rounded-lg overflow-hidden sm:shadow-lg my-6">
                            <thead class="text-black bg-gray-300">
                                <tr class="bg-yellow-400  rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                    <th class="p-3 text-left">Запчасть </th>
                                    <th class="p-3 text-left">Поставщик</th>
                                    <th class="p-3 text-left">Номер</th>
                                    <th class="p-3 text-left">Наличие шт.</th>
                                    <th class="p-3 text-left">Доставка</th>
                                    <th class="p-3 text-left">Цена за шт.</th>
                                    <th class="p-3 text-left"></th>
                                </tr>
                                
                            </thead>
                             
                            <tbody class=" bg-white">
                                <tr class=" mb-2 sm:mb-0 border-b hover:bg-gray-200" v-for="(part, index) in ordered(parts['crosses_brand'])" v-bind:key="index">
                                    <td v-if="parts['crosses_brand'].isShow == true || index < 2" class=" p-3">{{part['name']}}</td>
                                    <td v-if="parts['crosses_brand'].isShow == true || index < 2" class=" p-3">{{part['postav']}}</td>
                                    <td v-if="parts['crosses_brand'].isShow == true || index < 2" class=" p-3 truncate font-bold">{{part['code']}}</td>
                                    <td v-if="parts['crosses_brand'].isShow == true || index < 2" class=" p-3 hover:font-medium">{{part['amount']}}</td>
                                    <td v-if="parts['crosses_brand'].isShow == true || index < 2" class=" p-3 hover:font-medium">{{part['srok']}}</td>
                                    <td v-if="parts['crosses_brand'].isShow == true || index < 2" class=" p-3 hover:font-medium"><span v-if="$page.props.auth.role.can && $page.props.user_id == false">{{part['price']}}</span><span v-else>{{Math.round(part['price'] + part['price'] * part['diapazon'] / 100)}}</span></td>
                                    <td v-if="parts['crosses_brand'].isShow == true || index < 2" class="bg-yellow-400 hover:bg-gray-700 p-3 cursor-pointer  hover:font-medium text-center text-white" @click="openModal" v-on:click="save(part)">В корзину</td>
                                </tr>
                                <hr>
                            </tbody>
                        </table>
                    </div>
                        
                        <div v-if="parts['crosses_brand'].length > 2" class='text-center'><a class='text-center cursor-pointer hover:text-gray-700 p-2 font-bold text-gray-500' v-on:click="showText(parts['crosses_brand'])">{{ parts['crosses_brand'].isShow ? 'Свернуть.' : 'Показать ещё предложения.' }}</a></div>
                    </div>

<!--Аналоги от других производителей-->

                
                <div v-for="(item, index) in parts['crosses']" v-bind:key="index">
                <h4 class='px-2  mt-6 text-left sm:text-3xl text-xl font-bold'>Аналоги от {{index}}</h4>
                    <div class='overflow-x-auto overflow-y-hidden'>

                        <table
                            class="w-full rounded-lg overflow-hidden sm:shadow-lg my-6">
                            <thead class="text-black bg-gray-300">
                                <tr class="bg-yellow-400 rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                    <th class="p-3 text-left">Запчасть </th>
                                    <th class="p-3 text-left">Поставщик</th>
                                    <th class="p-3 text-left">Номер</th>
                                    <th class="p-3 text-left">Наличие</th>
                                    <th class="p-3 text-left">Доставка</th>
                                    <th class="p-3 text-left">Цена за шт.</th>
                                    <th class="p-3 text-left"></th>
                                </tr>
                                
                            </thead>
                             
                            <tbody class="flex-1 sm:flex-none bg-white" >
                                <tr class="mb-2 sm:mb-0 border-b hover:bg-gray-200" v-for="(part, index) in ordered(item)" v-bind:key="index">
                                    <td v-if="item.isShow == true || index < 2" class=" p-3">{{part['name']}}</td>
                                    <td v-if="item.isShow == true || index < 2" class=" p-3">{{part['postav']}}</td>
                                    <td v-if="item.isShow == true || index < 2" class=" p-3 truncate font-bold">{{part['code']}}</td>
                                    <td v-if="item.isShow == true || index < 2" class=" p-3 hover:font-medium">{{part['amount']}}</td>
                                    <td v-if="item.isShow == true || index < 2" class=" p-3 hover:font-medium">{{part['srok']}}</td>
                                    <td v-if="item.isShow == true || index < 2" class=" p-3 hover:font-medium"><span v-if="$page.props.auth.role.can && $page.props.user_id == false">{{part['price']}}</span><span v-else>{{Math.round(part['price'] + part['price'] * part['diapazon'] / 100)}}</span></td>
                                    <td  v-if="item.isShow == true || index < 2" class="bg-yellow-400 hover:bg-gray-700 border-t p-3 cursor-pointer hover:font-medium text-center text-white" @click="openModal" v-on:click="save(part)">В корзину</td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <div v-if="item.length > 2" class='text-center'><a class='text-center cursor-pointer hover:text-gray-700 p-2 font-bold text-gray-500' v-on:click="showText(item)">{{ item.isShow ? 'Свернуть.' : 'Показать ещё предложения.' }}</a></div>
                    </div>


                </div>
<!--Конец-->
                </div>
            </div>
        </div>

<!-- Модальное окно при добавлении товара в корзину -->
                   
                        
                  


            <template #alert>
                <span v-if="$page.props.basket.basket && $page.props.basket.basket.length != 0" class='relative'><i class="fas fa-circle text-sm ml-1 text-yellow-300 animate-pulse"></i></span>
            </template>
    </main1>
    
</template>

<script>
    import Main1 from '@/Pages/Frontend/Layouts/Main.vue'
    export default {
        props: ['parts'],
        components: {
            Main1,

        },
         data() {
              return {
                  isHidden1: true,
                  isHidden2: true,
                  isHidden3: true,
                  isOpen: false,
              }
          },
           methods: {
            save: function (data) {
                this.$inertia.post('/basket', data)
            },
            ordered: function (data) {
                return _.orderBy(data, ['srok', 'price'])
            },
            showText(data) { data.isShow = !data.isShow },
            openModal: function () {
                this.isOpen = true;
            setTimeout(() => this.isOpen = false, 2000);
            },

        },
    }
</script>