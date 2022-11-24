<template>
    <main1>
        <div>
            <div>
                <main class='p-2'>
                    <div class='mt-24'>
                        <div class='w-full bg-yellow-300 rounded-lg'>
                            <div
                                class="flex flex-wrap py-5 px-5 sm:justify-start justify-center sm:items-start items-center">
                                <i class="hidden sm:block py-4 px-2 text-4xl fal fa-long-arrow-right"></i>
                                <p class='py-6 px-2 font-bold'>Выберите нужный вариант автомобиля</p>
                            </div>
                        </div>
                        <div
                            class="flex flex-wrap mx-auto rounded-md items-center justify-around bg-gray-300 mt-6 max-w-screen-xl">

                            <div v-for=" modification in vin.models" v-bind:key=" modification"
                                class="flex-shrink-0 m-2 relative overflow-hidden bg-indigo-500 w-72 rounded-lg max-w-xs shadow-lg hover:bg-indigo-600">

                                <div v-for="(mod, index) in modification" v-bind:key="index"
                                    class="relative text-white ">
                                    <span v-if="index == 'Марка' ||index == 'Серия' || index == 'Модель' || index == 'Руль' || index == 'Тип Трансмиссии' || index == 'Регион' || index == 'Руль' || index == 'Рынок' || index == 'Цвет Кузова' || index == 'Руль' || index == 'Дата Выпуска'" 
                                    class="block opacity-75 -mb-1 px-3 py-1">
                                        <span class='text-white font-bold'>{{index}}: </span>
                                        <span class=''>{{mod}}</span>
                                    </span>

                                </div>
                                <div
                                    class='bg-white  w-full text-center content-center py-2 px-2 text-indigo-400 hover:text-indigo-600'>
                                    <inertia-link
                                        v-bind:href="'/vin/'+modification.link"
                                        class=' font-bold'>Перейти</inertia-link>
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
        props: ['vin'],
        components: {
            Main1
        },
        data() {
            return {
            
            }
        },
        methods: {


        }

    }
</script>