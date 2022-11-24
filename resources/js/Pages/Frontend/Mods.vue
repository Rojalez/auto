<template>
    <main1>
        <div>
            <div>
                <main class='p-2'>
                    <div class='mt-24'>
                        <div class='w-full bg-yellow-300 rounded-lg'>
                            <div class="flex flex-wrap py-5 px-5 sm:justify-start justify-center sm:items-start items-center">    
                                <h4 class='py-4 px-2 text-4xl font-bold'>Выберите модификацию</h4>
                            </div>
                            <div class='py-2 px-2'>
                                <div class="flex flex-wrap ">
                                    <div class="w-full">
                                        <div class="mx-auto grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-2 bg-white rounded-lg  px-2 py-2 font-semibold">
                                        
                                            <div v-for="modification in modifications.m" :key='modification'>
                                                <inertia-link :href="'/catalogs/tree/'+modification.dbi">
                                                    <div class="p-2 my-1 md:my-2 hover:bg-yellow-100 h-16 hover:shadow-lg bg-gray-100 rounded-lg">
                                                        {{modification.fd}}
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
        props: ['modifications'],
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