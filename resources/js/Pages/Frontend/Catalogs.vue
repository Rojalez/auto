<template>
    <main1>
        <div>
            <div>
                <main class='p-2'>
                    <div class='mt-24'>
                        <div class='w-full bg-yellow-300 rounded-lg'>
                            <div class="flex flex-wrap py-5 px-5 sm:justify-start justify-center sm:items-start items-center">    
                                <h4 class='py-4 px-2 text-4xl font-bold'>{{marka}}</h4>
                                <i class="hidden sm:block py-4 px-2 text-4xl fal fa-long-arrow-right"></i>
                                <p class='py-6 px-2 font-bold'>Выберите модель {{marka }}</p>
                            </div>
                            <div class='py-2 px-2'>
                                <div class="flex flex-wrap ">
                                    <div class="w-full">
                                        <div class="mx-auto grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-2 bg-white rounded-lg  px-2 py-2 font-semibold">
                                            <div v-for="model in models.m" :key="model">
                                                <inertia-link :href="'/catalogs/modifications/'+model.i">
                                                    <div class="p-2 my-1 md:my-2 hover:bg-yellow-100 h-16 text-center hover:shadow-lg bg-gray-100 rounded-lg">
                                                        {{model.fd}}
                                                    </div>
                                                </inertia-link>
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
        props: ['models', 'marka'],
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