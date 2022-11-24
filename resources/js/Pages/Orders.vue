<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Заказы
            </h2>
        </template>
        <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">

                <div class='mb-2 mx-2 md:mx-0'><span class='bg-yellow-500 hover:bg-yellow-600 rounded-md px-4 py-2 text-white cursor-pointer' @click="filter = !filter">Фильтр</span></div>
                <div class='flex flex-wrap justify-items-between mx-auto w-full items-center px-2 py-2 relative' v-if='filter'>
                    <div class='flex-auto p-2 w-full lg:w-auto'><input type="number" class='rounded-md w-full lg:w-auto ring ring-yellow-200 offset-0' name="" id="" placeholder="ID заказа" v-model="form.id"></div>
                    <div class='flex-auto p-2 w-full lg:w-auto'><input type="number" class='rounded-md w-full lg:w-auto ring ring-yellow-200 offset-0' name="" id="" placeholder="Номер телeфона" v-model="form.phone"></div>
                    <div class='flex-auto p-2 w-full lg:w-auto relative'><label for="ot" class='absolute top-0 bg-yellow-400 rounded-full w-5 h-5 text-sm text-center text-white ring ring-yellow-200 offset-0' >от</label><input v-model="form.from" class='rounded-md w-full lg:w-auto ring ring-yellow-200 offset-0' type="date" name="" id="ot"></div>
                    <div class='flex-auto p-2 w-full lg:w-auto relative'><label for="ot" class='absolute top-0 bg-yellow-400 rounded-full w-5 h-5 text-sm text-center text-white ring ring-yellow-200 offset-0' >до</label><input v-model="form.to" class='rounded-md w-full lg:w-auto ring ring-yellow-200 offset-0' type="date" name="" id="do"></div>
                    <div class='flex-auto p-2 w-full lg:w-auto'><button @click="submit" class='bg-yellow-400 px-3 py-2 rounded-md text-white w-full lg:w-auto'>Поиск</button></div>
                </div>

                <div class="bg-transparent overflow-hidden sm:rounded-lg">
                    <div class='flex flex-col sm:-mt-12 md:-mt-0 lg:-mt-0 -mt-16 md:px-0 px-2'>
                        <div
                            class="md:visible invisible grid grid-cols-9 gap-1 mt-1 md:mt-4 py-2 rounded-t-lg bg-gray-700 text-white tracking-tighter">
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2 '>ID заказа</div>
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2 '>Имя</div>
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2 '>Номер</div>
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2'>Цена</div>
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2'>С наценкой</div>
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2'>Скидка</div>
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2'>Сумма скидки</div>
                            <div class=' border-r sm:text-md md:text-lg  px-1 py-2'>Итого</div>
                            <div class=' sm:text-md md:text-lg  px-1 py-2'>Дата</div>
                        </div>
                        <div class='bg-gray-50 md:border-b' v-for="order in data" v-bind:key="order">
                        <div class="md:grid md:grid-cols-9 flex flex-col gap-1 md:border-0  border-b-0  md:border-b-1 py-2 text-white md:text-gray-700 md:px-0 px-2 relative rounded-lg md:rounded-none rounded-b-lg bg-gray-700 md:bg-gray-50 md:mb-0 mb-1 ">
                            <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block mr-1 font-bold'>ID:</span>{{order.id}}</div>
                            <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block mr-1 font-bold'>Имя:</span>{{order.user.name}}</div>
                            <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block mr-1 font-bold'>Тел:</span>{{order.user.phone}}</div>
                            <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block mr-1 font-bold'>Цена:</span><i class="fas fa-ruble-sign mr-1"></i>{{order.price}}</div>
                            <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block mr-1 font-bold'>С наценкой:</span><i class="fas fa-ruble-sign mr-1"></i>{{order.price_n}}</div>
                            <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block mr-1 font-bold'>Скидка:</span><i class="fas fa-ruble-sign mr-1"></i>{{order.skidka}}</div>
                            <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block mr-1 font-bold'>Сумма скидки:</span><i class="fas fa-ruble-sign mr-1"></i>{{order.skidka_s}}</div>
                            <div class='md:border-r sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block mr-1 font-bold'>Итого:</span><i class="fas fa-ruble-sign mr-1"></i>{{order.total}}</div>
                            <div class='md:border-r-0 sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2'><span class='md:hidden inline-block mr-1 font-bold'>Дата заказа:</span><span>{{order.created_at }}</span><span class='float-right'></span>
                            </div>
                        </div>
                        <div @click="showText(order)" class='mx-auto md:w-1/12 w-1/6 text-center cursor-pointer'>
                            <p class='w-full bg-yellow-400 rounded  hover:bg-yellow-500 text-md text-white text-center md:py-0 py-2 my-1 shadow-xl' title="Раскрыть"><i v-show="!order.isShow" class="fal fa-chevron-down"></i> <i v-show='order.isShow' class="fal fa-chevron-up"></i></p>
                        </div>
                        <transition enter-active-class="transition ease-out duration-200"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                        <div class='mx-2 py-1 px-2 mb-4' v-show="order.isShow">
                        <div class="md:visible invisible grid grid-cols-10 -mb-16 md:-mb-2 gap-1 mt-1 md:mt-2 py-0 px-2 m-2 bg-yellow-400 text-white tracking-tighter rounded-t-lg">
                            <div class=' border-r sm:text-md text-sm  px-1 py-2 '>Название товара</div>
                            <div class=' border-r sm:text-md text-sm  px-1 py-2'>Кол-во</div>
                            <div class=' border-r sm:text-md text-sm  px-1 py-2'>Статус</div>
                            <div class=' border-r sm:text-md text-sm  px-1 py-2'>Цена</div>
                            <div class=' border-r sm:text-md text-sm  px-1 py-2'>C наценкой:</div>
                            <div class=' border-r sm:text-md text-sm  px-1 py-2'>Сумма:</div>
                            <div class=' border-r sm:text-md text-sm  px-1 py-2'>С наценкой:</div>
                            <div class=' border-r sm:text-md text-sm  px-1 py-2'>Скидка:</div>
                            <div class=' border-r sm:text-md text-sm  px-1 py-2'>Сумма скидки:</div>
                            <div class=' sm:text-md text-sm  px-1 py-2'>Итого:</div>
                        </div>
                        <div class='bg-gray-200 md:bg-gray-100 md:bg-white md:grid md:grid-cols-10 flex flex-col gap-1 md:border border-0 md:rounded-none rounded-lg  md:m-2 m-1 mt-0 py-2 px-2 md:mb-0 mb-1 tracking-tighter' v-for="part in order.parts" :key="part">
                                <div class='md:border-r sm:text-md text-sm px-1 py-1 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1 font-bold'>Товар:</span>{{part.name}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-1 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1 font-bold'>Кол-во:</span>{{part.amount}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-1 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1 font-bold'>Статус:</span><span class='animate-pulse text-yellow-500'>{{part.status}}</span></div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-1 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1 font-bold'>Цена:</span> <i class="fas fa-ruble-sign mr-1"></i>{{part.price}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-1 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1 font-bold'>С наценкой:</span><i class="fas fa-ruble-sign mr-1"></i>{{part.price_n}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-1 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1 font-bold'>Сумма:</span> <i class="fas fa-ruble-sign mr-1"></i>{{part.sum}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-1 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1 font-bold'>С наценкой:</span><i class="fas fa-ruble-sign mr-1"></i>{{part.sum_n}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-1 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1 font-bold'>Скидка:</span><i class="fas fa-percent mr-1"></i>{{part.skidka}}</div>
                                <div class='md:border-r sm:text-md text-sm px-1 py-1 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1 font-bold'>Сумма скидки:</span><i class="fas fa-ruble-sign mr-1"></i>{{part.sum_s}}</div>
                                <div class='sm:text-md text-sm px-1 py-2 ml-2 md:ml-0 md:border-b-0 border-b-2 '><span class='md:hidden inline-block mr-1 font-bold'>Итого:</span><i class="fas fa-ruble-sign mr-1"></i>{{part.total}}</div>
                                
                        </div>
                        <div class='hidden bg-yellow-400 mx-2 md:grid md:grid-cols-5 gap-1 rounded-b-lg py-2 px-2 md:mb-0 -mb-1 tracking-tighter'>
                        </div>
                        </div>
                        </transition>
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
        methods: {
            showText(data) { data.isShow = !data.isShow },
            submit() {
                this.$inertia.get('/dashboard/orders', this.form)
            }
        },
        data() {
            return {
                open: false,
                filter: false,
                form: {
                    id: null,
                    phone: null,
                    from: null,
                    to: null,
                },
            }
        }
    }
</script>