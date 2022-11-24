<template>
        <main1> 
              <div>
                <div class='bg-gray-700 h-64 w-full -mb-64'></div>
                <main class='p-2'>  
                  <div class='mb-4 sm:mb-16 lg:px-4'>
                      <section class="sm:px-5 px-2 lg:py-24 py-24 mt-8 lg:mt-20 main-bg rounded-xl items-center text-center">
                                          
                <div v-if="$page.props.auth.role.can">
                    <select v-model="user_id" @change="changeUser()">
                        <option :value="null">Админ</option>
                        <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
                    </select>
                </div>                         


                          <div class="bg-gray-600 bg-opacity-30 bg-blur-xl rounded-2xl py-4">
                              <h4 class='lg:text-5xl text-3xl font-bold text-white mb-2'>Автозапчасти АвтоРУ - Выгодные
                                  цены и скидки 
                                  </h4>
                                <p class='lg:text-2xl  text-1xl font-bold text-white'>Автозапчасти по актуальным
                                    ценам напрямую от
                                    производителей. Привезем в пункт выдачи или напрямую курьером к вам.</p>
                                <div class="md:block hidden container sm:px-0 px-2 py-2   my-12 mx-auto w-full items-start justify-center">
                                    <div class="w-full relative max-w-4xl mx-auto">
                                        <form @submit.prevent="submit" class='shadow-lg rounded-lg'>
                                            <input v-model.trim="inputValue" v-model="part_code" class="focus:placeholder-gray-400 focus:bg-gray-50 focus:ring-transparent w-full py-4 rounded-lg bg-gray-200 border-0" type="search"  placeholder="Поиск по артикулу (123456) или артикулу и бренду (123456@OPEL)" />
                                            <button type="submit" class='absolute right-0 top-0 focus:outline-none focus:bg-yellow-500 sm:px-6 py-1 h-full px-4 font-bold bg-yellow-300 rounded-lg rounded-l-none'>Найти</button>
                                        </form>   
                                    </div>
                                </div>
                                <div class="block md:hidden container sm:px-0 px-2 py-2 mx-auto w-full items-start justify-center">
                                    <div class="w-full relative max-w-4xl mx-auto">
                                        <form @submit.prevent="submit" class='shadow-lg rounded-lg'>
                                            <input id="label" v-model.trim="inputValue" v-model="part_code" class="focus:placeholder-gray-400 focus:bg-gray-50 focus:ring-transparent w-full text-sm py-4 rounded-lg bg-gray-200 border-0" type="search"  placeholder="Поиск" />
                                            <button type="submit" class='absolute right-0 top-0 focus:outline-none focus:bg-yellow-500 sm:px-6 py-1 h-full px-4 font-bold bg-yellow-300 rounded-lg rounded-l-none'>Найти</button>
                                        </form>   
                                    </div>
                                </div>
                            <label class="block md:hidden mx-4 font-bold text-white text-sm" for="label">Введите артикул (123456) или артикул и бренд (123456@OPEL)</label>
                        </div>
                      </section>
                  </div>
              </main>
            </div>

     

     
        </main1>
  </template>

<script>
    import Main1 from '@/Pages/Frontend/Layouts/Main'

      export default {
          props: ['catalogs', 'users'],

          components: {
                Main1,
            
          },
          data() {
            return {
                part_code: null,
                user_id: null,
            }
        },
        methods: {
            submit() {
                this.$inertia.get('/parts/brands-list/'+this.part_code);
            },
            changeUser() {
                this.$inertia.post('/changeuser', {user_id:this.user_id});
            },
            checkedUser(){
                if (this.$page.props.user_id) {
                    this.user_id = this.$page.props.user_id;
                }
            }
        },
        mounted() {
            this.checkedUser();
        }

    }
</script>
  