<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Диапазон наценок
            </h2>
        </template>

    <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-x-auto shadow-xl rounded-lg px-4 py-4">
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.message">
                      <div class="flex">
                        <div>
                          <p class="text-sm">{{ $page.props.flash.message }}</p>
                        </div>
                      </div>
                    </div>
                    <div v-if="$page.props.errors" class="text-red-500"><div v-for="error in $page.props.errors" v-bind:key="error"><p class="text-sm">{{ error }}</p></div></div>
                    <button @click="openModal()" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg my-3">Добавить диапазон</button>
                    <div class='overflow-x-auto rounded-xl scrolling-touch'>
                        <table class="w-full">
                        <thead>
                            <tr class="bg-gray-700 border text-white">
                                <th class="border px-4 py-2">От</th>
                                <th class="border px-4 py-2">До</th>
                                <th class="border px-4 py-2">Наценка</th>
                                <th class="border px-4 py-2">Действия</th>
                            </tr>
                        </thead>
                        
                        <tbody v-for="row in data" v-bind:key="row.id" class="border">
                            <tr>
                                <td class="border px-4 py-2">{{ row.from_price }}</td>
                                <td class="border px-4 py-2">{{ row.to_price }}</td>
                                <td class="border px-4 py-2">{{ row.procent }}</td>
                                <td class="border px-4 py-2">
                                    <div class='flex flex-row flex-wrap'> <button @click="edit(row)" class="flex-auto bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg mx-2 my-1">Изменить</button>
                                    <button @click="deleteRow(row)" class="flex-auto bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded-lg mx-2 my-1">Удалить</button></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        
                        <div class="fixed inset-0 transition-opacity">
                          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <!-- This element is to trick the browser into centering the modal contents. -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                          <form @submit.prevent="submit2">
                          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="">

                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">От:</label>
                                      <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="От" v-model="form.from_price">
                                  </div>
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">До:</label>
                                      <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="До" v-model="form.to_price">
                                  </div>
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Процент:</label>
                                      <input type="number" step="0.01" class="w-full shadow appearance-none border rounded py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Процент в цифрах" v-model="form.procent">
                                  </div>

                            </div>
                          </div>
                          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button  type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode == false" @click="save(form)">
                                Сохранить
                              </button>
                            </span>
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button  type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode == 1" @click="update(form)">
                                Изменить
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
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        props: ['data'],
        components: {
            AppLayout,
       
        },
        data() {
            return {
                editMode: false,
                isOpen: false,
                form: {
                    from_price: null,
                    to_price: null,
                    procent: null
                },
            }
        },
        methods: {
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            reset: function () {
                this.form = {
                    from_price: null,
                    to_price: null,
                    procent: null
                }
            },
            save: function (data) {
                this.$inertia.post('/dashboard/diapazon', data)
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = 1;
                this.openModal();
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post('/dashboard/diapazon/' + data.id, data)
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Вы уверены что хотите удалить?')) return;
                data._method = 'DELETE';
                this.$inertia.post('/dashboard/diapazon/' + data.id, data)
                this.reset();
                this.closeModal();
            },
        }
    }
</script>
