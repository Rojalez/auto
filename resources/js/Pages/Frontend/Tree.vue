<template>
    <main1>
        <div>
            <div>
                <main class='p-2'>
                    <div class='mt-24'>
                        <div class='w-full mx-auto max-w-4xl'>
                            <div class="flex flex-wrap py-5 bg-gray-700 rounded-lg  sm:justify-start justify-center sm:items-start items-center">    
                                <h4 class='py-4 px-4 text-4xl text-white font-bold'>Выберите деталь</h4>
                            </div>
                     
                        <div class="flex flex-wrap container mx-auto rounded-md bg-white mt-2 py-4 px-2 ">
                      
                                <ul class='w-full'>
                                    <li class='mx-4 bg-gray-100 hover:shadow-md px-2 py-1 uppercase text-gray-600 rounded my-2 cursor-pointer font-semibold' v-for="tre in tree" :key="tre">
                                        <span class='block h-full w-full font-bold' v-on:click="showRaw(tre)" v-if="tre.pod">{{tre.d}}</span>
                                        <a class='block h-full w-full'  v-else :href="'/catalogs/parts/'+tre.i+'/'+tre.mi">{{tre.d}}</a>
                                        <ul class='w-full' v-if="tre.pod && tre.isShow">
                                            <li class='ml-4 caret cursor-pointer font-semibold'   v-for="tr in tre.pod" :key="tr">
                                                <span v-on:click="showRaw(tr)" v-if="tr.pod">{{tr.d}}</span>
                                                <a v-else :href="'/catalogs/parts/'+tr.i+'/'+tr.mi">{{tr.d}}</a>
                                                <ul class='w-full' v-if="tr.pod && tr.isShow">
                                                    <li class='ml-4 caret cursor-pointer font-semibold'   v-for="t in tr.pod" :key="t">
                                                        <span v-on:click="showRaw(t)" v-if="t.pod">{{t.d}}</span>
                                                        <a v-else :href="'/catalogs/parts/'+t.i+'/'+t.mi">{{t.d}}</a>
                                                        <ul class='w-full' v-if="t.pod && t.isShow" >
                                                            <li class='ml-4 caret cursor-pointer font-semibold'   v-for="t2 in t.pod" :key="t2">
                                                                <span v-on:click="showRaw(t2)" v-if="t2.pod">{{t2.d}}</span>
                                                                <a v-else :href="'/catalogs/parts/'+t2.i+'/'+t2.mi">{{t2.d}}</a>
                                                                <ul class='w-full' v-if="t2.pod && t2.isShow">
                                                                    <li class='ml-4 caret cursor-pointer font-semibold'   v-for="t3 in t2.pod" :key="t3">
                                                                        <span v-on:click="showRaw(t3)" v-if="t3.pod">{{t3.d}}</span>
                                                                        <a v-else :href="'/catalogs/parts/'+t3.i+'/'+t3.mi">{{t3.d}}</a>
                                                                        <ul class='w-full' v-if="t3.pod && t3.isShow">
                                                                            <li class='ml-4 caret cursor-pointer font-semibold'   v-for="t4 in t3.pod" :key="t4">
                                                                                <span v-if="t4.pod && t4.isShow">{{t4.d}}</span>
                                                                                <a v-else :href="'/catalogs/parts/'+t4.i+'/'+t4.mi">{{t4.d}}</a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                        
                        </div>
                      
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </main1>
</template>
<style>
    .caret::before {
        content: "\25B6";
        color: rgb(94, 94, 94);
        display: inline-block;
        margin-right: 6px;
    }

    .caret-down::before {
        transform: rotate(45deg);
    }
</style>
<script>
    import Main1 from '@/Pages/Frontend/Layouts/Main.vue'

    export default {
        props: ['tree'],
        components: {
            Main1
        },
        data() {
            return {
               
            }
        },
        methods: {
            showRaw(data) {
                data.isShow = !data.isShow
            }
        }
       

        }

  
</script>