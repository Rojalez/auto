<template>
    <main1>
        <div>
            <div>
                <main class='p-2'>
                    <div class='mt-16 container mx-auto'>
                        <div class='w-full bg-yellow-300 rounded-lg'>
                            <div
                                class="flex flex-wrap py-5 px-5 sm:justify-start justify-center sm:items-start items-center">
                                <p class='py-6 px-2 text-xl sm:text-2xl font-bold'>{{model}}</p>
                                <i class="hidden sm:block py-5 px-2 text-4xl fal fa-long-arrow-right"></i>
                                <p class='py-7 px-2 font-bold'>{{tree_name}}</p>
                            </div>
                        </div>
                         <div class="main-images w-full bg-gray-200 mb-8">
                             <div v-for="group in tree" v-bind:key="group.header"
                                 class="images my-2">
                                 <div class="bg-white w-full rounded-lg shadow-lg">
                                     <inertia-link class='flex'
                                         :href="'/vin/'+link+'/'+ssd+'/'+group.node+'/?path='+path">
                                         <img class='object-contain h-48 w-full flex-1 rounded-lg' v-bind:src="group.image" >
                                         <span
                                             class="flex hover:bg-indigo-600 items-stretch justify-center flex-1  text-center p-2 bg-indigo-500 sm:text-lg text-sm w-full text-white font-bold rounded-r-lg">
                                             <p class='self-center'>{{group.header}}</p>
                                         </span>
                                     </inertia-link>
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
        props: ['tree', 'link', 'ssd', 'path', 'tree_name', 'model'],
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