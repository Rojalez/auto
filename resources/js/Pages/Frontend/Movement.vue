<template>
    <main1>
        <div>
            <div>
                <main>            
                    <div class='sm:p-4 p-2'>      
                    <div class='mt-16'>
                        <div class='w-full bg-gray-700 rounded-lg'>
                            <div class="py-5 px-5 justify-start items-start"> 
                                <p class='px-2 text-2xl sm:text-4xl font-bold text-white'>Движение заказа</p>
                                <p v-if="data.length != 0" class='px-2 text-md sm:text-xl font-thin text-white flex flex-wrap'>Ваш заказ прибудет с минуты на минуту</p>
                            </div>
                        </div>

                        <!--Если пусто-->
                        <div v-if="data.length == 0" class='px-4 py-6 bg-yellow-200 my-2 mx-2 rounded relative'>
                            <h3 class='text-gray-600 text-2xl text-center py-auto px-auto align-middle'><i class="fal fa-times-circle mr-1"></i>Заказов нет</h3>
                        </div>
                        <!---->

        <div class="py-6" v-if="data.length != 0">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-transparent overflow-hidden sm:rounded-lg">
                    <div class='flex flex-col sm:-mt-12 md:-mt-0 lg:-mt-0 -mt-16 md:px-0 px-2'>
                        <div
                            class="md:visible invisible grid grid-cols-3 gap-1 mt-1 md:mt-4 py-2 rounded-t-lg bg-gray-700 text-white tracking-tighter">
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2 '>ID заказа</div>
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2'>Цена</div>
                            <div class=' sm:text-md md:text-lg  px-1 py-2'>Дата</div>
                        </div>
                        <div class='bg-gray-50 border-b' v-for="order in data" v-bind:key="order">
                        <div class="md:grid md:grid-cols-3 px-2 flex flex-col gap-1 md:border-0  border-b-0  md:border-b-1 py-2 relative rounded-lg md:rounded-none rounded-b-lg bg-gray-50 md:mb-0 mb-1 ">
                            <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block'>ID:</span>{{order.id}}</div>
                            <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block'>Цена:</span> <i class="fas fa-ruble-sign"></i>{{order.price}}</div>
                            <div class='md:border-r-0 sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block'>Дата заказа:</span> <span>{{order.created_at}}</span><span class='float-right'> </span>
                            </div>
                        </div>
                        <div @click="showText(order)" class='mx-auto md:w-1/12 w-1/6 text-center cursor-pointer'>
                            <p class='w-full bg-yellow-400 rounded  hover:bg-yellow-500 text-md text-white text-center md:py-0 py-2 my-1' title="Раскрыть"><i v-show="!order.isShow" class="fal fa-chevron-down"></i> <i v-show='order.isShow' class="fal fa-chevron-up"></i></p>
                        </div>
                        <transition enter-active-class="transition ease-out duration-200"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                        <div class='mx-2 py-1 px-2' v-show="order.isShow">
                        <div class="md:visible invisible grid grid-cols-6 -mb-16 md:-mb-0 gap-1 mt-1 md:mt-2 py-0 px-2 m-2 bg-gray-600 text-white tracking-tighter rounded-t-lg">
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2 '>Название товара</div>
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2'>Кол-во</div>
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2'>Статус</div>
                            <div class='border-r sm:text-md md:text-lg  px-1 py-2'>Цена</div>
                            <div class='border-r sm:text-md md:text-lg  px-1 py-2'>Скидка</div>
                            <div class='sm:text-md md:text-lg  px-1 py-2'>Итого:</div>
                        </div>
                        <div class='bg-gray-100 md:bg-white md:grid md:grid-cols-6 flex flex-col gap-1 md:border border-0 md:rounded-none rounded-lg  m-2 mt-0 py-2 px-2 md:mb-0 mb-1 tracking-tighter' v-for="part in order.parts" :key="part">
                                <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block'>Товар:</span> {{part.name}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block'>Кол-во:</span> {{part.amount}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1'>Статус:</span><span class='animate-pulse text-yellow-400 font-bold'>{{part.status}}</span></div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 ' v-if="$page.props.auth.role.can"><span class='md:hidden inline-block'>Цена:</span> <i class="fas fa-ruble-sign"></i> {{part.price}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 ' v-else><span class='md:hidden inline-block'>Цена:</span> <i class="fas fa-ruble-sign"></i> {{part.price_n}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block'>Скидка:</span> <i class="fas fa-ruble-sign"></i> {{part.skidka}}</div>
                                <div class='sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block'>Итого:</span> <i class="fas fa-ruble-sign"></i> {{part.total}}</div>
                        </div>
                        <div class='hidden bg-gray-600 mx-2 md:grid md:grid-cols-5 gap-1 rounded-b-lg py-2 px-2 md:mb-0 -mb-1 tracking-tighter'>
                        </div>
                        </div>
                        </transition>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        props: ['data'],
        components: {
            Main1
        },
        data() {
            return {
               
            }
        },
        methods: {
            showText(data) { data.isShow = !data.isShow },
        },
        computed: {

        }

    }
</script>