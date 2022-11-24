<template>
    <main1>
        <div>
            <div>
                <main>
                    
                    <div class='sm:p-6 p-2'>
                        
                    <div class='mt-16'>
                        <div class='w-full bg-gray-700 rounded-lg'>
                            <div class="py-5 px-5 justify-start items-start"> 
                                <p class='px-2 text-2xl sm:text-4xl font-bold text-white'>Корзина {{client}}</p>
                                <div v-if="$page.props.basket.basket">
                                    <div v-if="$page.props.basket.basket.length != 0">
                                        <p class='px-2 text-md sm:text-xl font-thin flex flex-wrap text-white'>Вы выбрали выгодные предложения, оформите заказ пока они есть в наличии и не изменилась стоимость</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div>
                                 <div v-if="$page.props.basket.basket && $page.props.basket.basket.length != 0">
                                <div class='flex flex-col sm:-mt-12 md:-mt-0 lg:-mt-0 -mt-12'>
                                <div class="md:visible invisible grid grid-cols-6 gap-1 mt-1 md:mt-4 py-2 rounded-t-lg bg-yellow-400">
                                  <div class=' border-r sm:text-md md:text-lg  px-1 py-2 '>Товар</div>
                                  <div class=' border-r sm:text-md md:text-lg  px-1 py-2 '>Артикул</div>
                                  <div class=' border-r sm:text-md md:text-lg  px-1 py-2 '>Поставщик</div>
                                  <div class=' border-r sm:text-md md:text-lg  px-1 py-2'>Доставка в ПВЗ</div>
                                  <div class=' border-r sm:text-md md:text-lg  px-1 py-2'>Кол-во, шт.</div>
                                  <div class='  sm:text-md md:text-lg px-1 py-2'>Стоимость</div>
                                </div>
                                <div v-for="part in $page.props.basket.basket" v-bind:key='part' class="md:grid md:grid-cols-6 flex flex-col gap-1 border border-b-1 py-2   bg-white md:mb-0 mb-1">

                                  <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><i class="fal fa-wrench"></i> {{part.info[0].name}}</div>
                                  <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><i class="fal fa-wrench"></i> {{part.info[0].code}}</div>
                                  <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><i class="fal fa-truck-loading"></i> {{part.info[0].postav}}</div>
                                  <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><i class="fal fa-calendar-alt"></i> {{part.info[0].srok}} дн.</div>
                                  <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='font-bold'> {{part.mount[0]}} шт.</span><span class='float-right'> <button @click="update(part.info[0])" class='bg-yellow-400 w-6 h-6 rounded-full text-white'>-</button> <button @click="save(part.info[0])" class='bg-yellow-400 w-6 h-6 rounded-full text-white'>+</button></span><span class='flex flex-wrap text-red-500'>Осталось<span class='ml-1 mr-1'>{{part.info[0].amount - part.mount[0]}}</span> шт.</span></div>
                                  <div class='md:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 font-bold'><i class="fas fa-ruble-sign mr-1"></i><span v-if="$page.props.auth.role.can && $page.props.user_id == false">{{part.info[0].price}}</span><span v-else>{{Math.round(part.info[0].price + part.info[0].price * part.info[0].diapazon / 100)}}</span><a class='cursor-pointer'><span @click="deleteRow(part.info[0])" class='float-right w-8 h-8 rounded-full mr-3 bg-red-500 text-center'><i class="mt-2 text-white fad fa-trash-alt"></i></span></a></div>
                                </div>
                                 <div class="md:grid md:grid-cols-4 md:gap-1 flex flex-col py-2 rounded-b-lg bg-gray-700 -mt-1 shadow-lg">
                                  <div class='md:border-r flex flex-col sm:text-md md:text-lg  px-1 py-2 text-center'>
                                      <a class='bg-yellow-400 my-1 md:py-3 py-2 md:px-6 px-4 font-bold  md:text-xl text-sm rounded-sm hover:bg-yellow-300 cursor-pointer' @click="createOrder($page.props.basket.basket)">Заказать</a>
                                      <a class='bg-white my-1 md:py-3 py-2 md:px-6 px-4 font-bold  text-sm rounded-sm hover:bg-gray-300 cursor-pointer' @click="openModal()" v-if="$page.props.auth.role.can && $page.props.user_id == false">{{user_name}}</a>
  
                                        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                          
                                          <div class="fixed inset-0 transition-opacity">
                                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                          </div>
                                          <!-- This element is to trick the browser into centering the modal contents. -->
                                          <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                                          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                            <form>
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                              <div class="">
                                             <div class="w-full">
                                                <div class="relative">
                                                    <div class="rounded border my-2 relative pin-t pin-l">
                                                        <ul class="list-reset" >
                                                          <li class="p-2"><input type="search" v-model="inputStr" @keyup="sortArray" placeholder="Введите имя" class="border-2 rounded h-8 w-full" ><br></li>
                                                          <div class="max-h-64 overflow-y-auto">
                                                          <li>
                                                            <p class="p-2 block text-black hover:bg-gray-200 cursor-pointer" v-for="user in users_list" :key="user" @click="change_client(user)" :value="user">{{user.name}}</p>
                                                          </li>

                                                          </div>
                                                          
                                                        </ul>
                                                    </div>
                                                </div>
                                              </div>
                                              
                                              </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                          
                                            
                                              <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                                
                                                <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                 Отмена
                                                </button>
                                              </span>
                                            </div>
                                            </form>
                                            
                                          </div>
                                        </div>
                                      </div>

                                </div>
                                  <div class=' sm:text-md md:text-lg text-center  px-1 py-2 font-bold text-white'>Сумма: <i class="fas fa-ruble-sign ml-1"></i><span v-if="$page.props.auth.role.can && $page.props.user_id == false" >{{total}}</span><span v-else class='mx-1'>{{diapazon}}</span></div>
                                  <div class=' sm:text-md md:text-lg text-center  px-1 py-2 font-bold text-white' v-if="$page.props.basket.basket[Object.keys($page.props.basket.basket)[0]].info[0].skidka != 0">Скидка ({{$page.props.basket.basket[Object.keys($page.props.basket.basket)[0]].info[0].skidka}}%):<i class="fas fa-ruble-sign mx-1"></i><span>{{Math.round(diapazon*$page.props.basket.basket[Object.keys($page.props.basket.basket)[0]].info[0].skidka/100)}}</span></div>
                                  <div class=' sm:text-md md:text-lg text-center  px-1 py-2 font-bold text-white' v-if="$page.props.basket.basket[Object.keys($page.props.basket.basket)[0]].info[0].skidka != 0">Итого:<i class="fas fa-ruble-sign mx-1"></i><span>{{Math.round(diapazon - diapazon*$page.props.basket.basket[Object.keys($page.props.basket.basket)[0]].info[0].skidka/100)}}</span></div>
                                </div>
                                </div>
                                </div>
                            <div v-else  class='px-4 py-12 bg-yellow-200 my-2 mx-2 rounded relative'>
                                <h3 class='text-gray-600 text-2xl text-center py-auto px-auto align-middle'><i class="fad fa-dolly-empty"></i> Ваша корзина пуста</h3>
                            </div>
                            </div>

                            <!---->
                    </div>
                    </div>
                </main>
            </div>
        </div>


                    

    </main1>
</template>


<script>
    import Main1 from '@/Pages/Frontend/Layouts/Main.vue'



    export default {
        props: ['basket', 'users'],
        components: {
            Main1,
         
        },
        data() {
            return {
                client: 0,
                user_name: 'Своя корзина',
                isOpen: false,
                showList: false,
                inputStr: '',
                users_list: this.users
            }
        },
        methods: {
           
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
            },
            save: function (data) {
                this.$inertia.post('/basket', data)
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post('/basket/' + data.code, data)
            },
            deleteRow: function (data) {
                data._method = 'DELETE';
                this.$inertia.post('/basket/' + data.code, data)
            },
            createOrder: function (data) {
                this.$inertia.post('/basket/createOrder', {'data': data,'client':this.client})
            },
            change_client: function (user) {
              
              this.client = user.id;
              this.user_name = user.name;
              this.closeModal();

            },
            sortArray() {
              this.users_list = this.users.filter(item => {
                return item.name.includes(this.inputStr);
              });
            },
            checkedUser(){
                if (this.$page.props.user_id) {
                    this.client = this.$page.props.user_id;
                }
            }
        },
          computed : {
            total: function() {
                let sum = 0;
                let obj = this.$page.props.basket.basket;
                Object.keys(obj).forEach(function(key){
                  sum += obj[key].info[0].price * obj[key].mount[0];
                });
                
                return sum;
            },
            diapazon: function() {
                let sum = 0;
                let price;
                let obj = this.$page.props.basket.basket;
                Object.keys(obj).forEach(function(key){
                    price = Math.round(obj[key].info[0].price) + Math.round(obj[key].info[0].price) * obj[key].info[0].diapazon / 100;
                    sum += price * obj[key].mount[0];
                });
                
                return Math.round(sum);
            },
            
        },
        mounted() {
            this.checkedUser();
        }

            

    }
</script>

