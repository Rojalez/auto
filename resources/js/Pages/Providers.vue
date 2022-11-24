<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Заказы поставщикам
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
            <div class='mb-4 mx-4 md:mx-0'><span class='bg-yellow-400 hover:bg-yellow-500 rounded-md px-4 py-2 text-white cursor-pointer' @click="filter = !filter">Фильтр</span></div>
            <div class='flex flex-wrap justify-items-between mx-auto w-full items-center px-2 py-2 relative' v-if='filter'>
                <div class='flex-auto p-2 w-full lg:w-auto'><input type="number" class='rounded-md w-full lg:w-auto' name="" id="" placeholder="Номер заказа" v-model="form2.key"></div>
                <div class='flex-auto p-2 w-full lg:w-auto'><input type="search" class='rounded-md w-full lg:w-auto' name="" id="" placeholder="Артикул" v-model="form2.code"></div>
                <div class='flex-auto p-2 w-full lg:w-auto'><input type="search" class='rounded-md w-full lg:w-auto' name="" id="" placeholder="Бренд" v-model="form2.brand"></div>
                <div class='flex-auto p-2 w-full lg:w-auto'>
                    <select type="search" class='rounded-md w-full px-8 lg:w-auto' name="" id="" v-model="form2.postavshik">
                        <option value="" selected disabled>Поставщики</option>
                        <option v-for="provider in providers" :key="provider">{{provider.name}}</option>
                    </select>
                </div>
                <div class='flex-auto p-2 w-full lg:w-auto'>
                    <select type="search" class='rounded-md  w-full px-8 lg:w-auto' name="" id="" v-model="form2.status">
                        <option value="" selected disabled>Статус</option>
                        <option >Принят</option>
                        <option >Отказано</option>
                        <option >Активные</option>
                    </select>
                </div>
                <div class='flex-auto p-2 w-full lg:w-auto'><button @click="search" class='bg-yellow-400 hover:yellow-500 px-3 py-2 rounded-md text-white w-full lg:w-auto'>Поиск</button></div>
            </div>

                <div class="bg-transparent w-full sm:rounded-lg">
                    <div class='flex flex-col px-4 lg:px-0'>
                        <div
                            class="lg:grid hidden  grid-cols-10 gap-1 mt-1 md:mt-4 py-2 rounded-t-lg bg-gray-700 font-bold text-white">
                            <div class=' border-r sm:text-sm md:text-md  px-1 py-2 break-words'>Название</div>
                            <div class=' border-r sm:text-sm md:text-md  px-1 py-2 break-words'>Артикул</div>
                            <div class=' border-r sm:text-sm md:text-md  px-1 py-2 break-words'>Заказ</div>
                            <div class=' border-r sm:text-sm md:text-md  px-1 py-2 break-words'>Цена</div>
                            <div class=' border-r sm:text-sm md:text-md  px-1 py-2 break-words'>Количество</div>
                            <div class=' border-r sm:text-sm md:text-md  px-1 py-2 break-words'>Сумма</div>
                            <div class=' border-r sm:text-sm md:text-md  px-1 py-2 break-words'>Срок</div>
                            <div class=' border-r sm:text-sm md:text-md  px-1 py-2 break-words'>Статус</div>
                            <div class=' border-r sm:text-sm md:text-md  px-1 py-2 break-words'>Поставщик</div>
                            <div class=' sm:text-sm md:text-md  px-1 py-2 break-words'>Бренд</div>
                        </div>
              
                        <div class='lg:grid lg:grid-cols-10 flex flex-col gap-1 border py-2 border bg-white mb-2 hover:bg-gray-50 lg:rounded-none rounded-lg' v-for="part in data" :key='part'>
                                <div class='bg-gray-700 lg:bg-transparent text-center lg:text-left lg:text-gray-800 text-white  md:border-r sm:text-sm md:text-md px-1 py-2 ml-0 lg:ml-2 md:ml-0 md:border-b-0 border-b-2 break-words lg:-mt-0 -mt-2 lg:rounded-t-none rounded-t-lg font-bold'>{{part.name}}</div>
                                <div class='lg:border-r sm:text-sm md:text-md px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 break-words lg:mx-0 mx-2 '><span class='lg:hidden inline-block font-semibold'>Артикул:</span> {{part.code}}</div>
                                <div class='lg:border-r sm:text-sm md:text-md px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 break-words lg:mx-0 mx-2'><span class='lg:hidden inline-block font-semibold'>Заказ:</span> {{part.key}}</div>
                                <div class='lg:border-r sm:text-sm md:text-md px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 break-words lg:mx-0 mx-2'><span class='lg:hidden inline-block font-semibold'>Цена:</span> {{part.price}}</div>
                                <div class='lg:border-r sm:text-sm md:text-md px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 break-words lg:mx-0 mx-2'><span class='lg:hidden inline-block font-semibold'>Кол-во:</span> {{part.amount}}</div>
                                <div class='lg:border-r sm:text-sm md:text-md px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 break-words lg:mx-0 mx-2'><span class='lg:hidden inline-block font-semibold'>Сумма:</span> {{part.sum}}</div>
                                <div class='lg:border-r sm:text-sm md:text-md px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 break-words lg:mx-0 mx-2'><span class='lg:hidden inline-block font-semibold'>Срок:</span> {{part.srok}}</div>
                                <div class='lg:border-r flex flex-col sm:text-sm md:text-md px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 break-words lg:mx-0 mx-2'><span class='lg:hidden inline-block font-semibold'>Статус:</span><span class='animate-pulse text-yellow-500 md:ml-0 ml-1'>{{part.status}}</span>
                                    <button @click="edit(part)" class="px-2 py-1 w-full bg-yellow-400 hover:bg-yellow-500 rounded-md"><i class="fal fa-edit text-white"></i></button>
                    
                                </div>
                                <div class='lg:border-r sm:text-sm md:text-md px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 break-words lg:mx-0 mx-2'><span class='lg:hidden inline-block font-semibold'>Поставщик:</span> {{part.postavshik}}</div>
                                <div class='sm:text-sm md:text-md px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 break-words lg:mx-0 mx-2'><span class='lg:hidden inline-block font-semibold'>Бренд:</span> {{part.brand}}</div>
                        </div>
                   
                    </div>
                </div>
            </div>
        </div>

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
                                  <div class="mb-4">
                                      <select class="w-full border bg-white rounded px-3 py-2 outline-none" v-model="form.status">
                                            <option class="py-1">Принят</option>
                                            <option class="py-1">Отказано</option>
                                            <option class="py-1" value="3">Другое</option>
                                      </select>
                                  </div>
                          </div>
                        <div class="mb-4 bg-white px-4 pb-4 sm:p-6 " v-if="form.status == 3">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Описание статуса:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Введите статус" v-model="form.description">
                        </div>
                          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button  type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" @click="update()">
                                Сохранить
                              </button>
                            </span>
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
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        props: ['data', 'providers'],
        components: {
            AppLayout,
        },

        data() {
            return {
                isOpen: false,
                filter:false,
                form: {
                    id : null,
                    status: 'Принят',
                    description: null
                },
                form2: {
                    code : null,
                    key: null,
                    status: '',
                    brand: null,
                    postavshik: ''
                }
            }
        },
        methods: {
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.form.status = 'Принят';
                this.form.description = null;
            },
            edit: function (data) {
                this.id = data.id;
                this.openModal();
            },
            update: function () {
                this.$inertia.post('/dashboard/orders/' + this.id, this.form)
                this.closeModal();
                this.form.status = 'Принят';
                this.form.description = null;
            },
            search() {
                this.$inertia.get('/dashboard/providers', this.form2)
            }
        }
    }
</script>