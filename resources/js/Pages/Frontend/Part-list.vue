<template>
    <main1>
        <div>
            <div>
                <main>
                    
                    <div class='sm:p-6 p-2'>

                    <div class='mt-16 overflow-x-auto overflow-y-hidden'>
                        <table class="w-full rounded-lg overflow-hidden sm:shadow-lg my-5">
                            <thead class="text-black bg-gray-300">
                                <tr class="bg-gray-700 text-white rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                    <th class="p-3 text-left">Бренд</th>
                                    <th class="p-3 text-left">Артикул</th>
                                    <th class="p-3 text-left">Запчасть</th>
                                    <th class="p-3 text-left"></th>
                                </tr>
                            </thead>
                             
                            <tbody class="bg-white" v-for="part in parts" v-bind:key="part">
                                <tr class=" mb-2 sm:mb-0 border-b hover:bg-gray-200" >
                                    <td  class="p-3">{{part.mfd}}</td>
                                    <td  class="p-3">{{part.n}}</td>
                                    <td  class="p-3">{{part.d}}</td>
                                    <td  class="px-0">
                                        <a class='hover:font-medium text-center text-white block w-full h-full p-3 hover:bg-yellow-400 bg-gray-700 ' v-bind:href="'/parts/brands-list/'+part.n+'/brand?brand='+part.mfd">Узнать цену</a>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
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
        props: ['parts'],
        components: {
            Main1
        },
        data() {
            return {

            }
        }

    }
</script>