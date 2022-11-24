<template>
    <main1>
        <div>
            <div>
                <main class='p-2'>
                    <div class='mt-16'>
                        <div class='w-full container mx-auto bg-yellow-300 rounded-lg'>
                            <div
                                class="flex flex-wrap sm:py-5 sm:px-5 py-0 px-0 sm:justify-start justify-center sm:items-start items-center">
                                <img class='my-2 object-cover rounded-full sm:h-24 sm:w-24 h-12 w-12'
                                    :src="tree.model_image">
                                <i class="hidden sm:block py-9 px-2 text-4xl fal fa-long-arrow-right"></i>
                                <p class='sm:py-10 py-2 px-2 text-center text-xl sm:text-2xl font-bold'>Классификатор
                                    для <br class='sm:hidden block'> {{tree.client.model}}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap container mx-auto rounded-md bg-gray-300 mt-2 py-4 px-4">
                            <div>
                                <ul>
                                    <li class='ml-4 caret cursor-pointer' v-for="(tree1, index1) in tree.tree"
                                        v-bind:key="index1">
                                        <a v-if="tree1.leaf == 1"
                                            :href="'/vin/'+tree.mod_link+'/'+tree.client.ssd+'?path='+index+'&tree_name='+tree1.name">{{tree1.name}}</a><span
                                            v-on:click="showRaw(tree1)" v-if="tree1.leaf == 0">{{tree1.name}}</span>
                                        <ul v-show="tree1.isShow" v-if="tree1.leaf == 0">
                                            <li v-for="(tree2, index2) in tree1.data" v-bind:class="caret(tree2.leaf)"
                                                v-bind:key="index2">
                                                <a v-if="tree2.leaf == 1"
                                                    :href="'/vin/'+tree.mod_link+'/'+tree.client.ssd+'?path='+index1+'->'+index2+'&tree_name='+tree2.name">{{tree2.name}}</a><span
                                                    v-on:click="showRaw(tree2)"
                                                    v-if="tree2.leaf == 0">{{tree2.name}}</span>
                                                <ul v-show="tree2.isShow" v-if="tree2.leaf == 0">
                                                    <li v-for="(tree3, index3) in tree2.data" v-bind:key="index3"
                                                        v-bind:class="caret(tree3.leaf)">
                                                        <a v-if="tree3.leaf == 1"
                                                            :href="'/vin/'+tree.mod_link+'/'+tree.client.ssd+'?path='+index1+'->'+index2+'->'+index3+'&tree_name='+tree3.name">{{tree3.name}}</a><span
                                                            v-on:click="showRaw(tree3)"
                                                            v-if="tree3.leaf == 0">{{tree3.name}}</span>
                                                        <ul v-show="tree3.isShow" v-if="tree3.leaf == 0">
                                                            <li v-for="(tree4, index4) in tree3.data"
                                                                v-bind:key="index4" v-bind:class="caret(tree4.leaf)">
                                                                <a v-if="tree4.leaf == 1"
                                                                    :href="'/vin/'+tree.mod_link+'/'+tree.client.ssd+'?path='+index1+'->'+index2+'->'+index3+'->'+index4+'&tree_name='+tree4.name">{{tree4.name}}</a><span
                                                                    v-on:click="showRaw(tree4)"
                                                                    v-if="tree4.leaf == 0">{{tree4.name}}</span>
                                                                <ul v-show="tree4.isShow" v-if="tree4.leaf == 0">
                                                                    <li v-for="(tree5, index5) in tree4.data"
                                                                        v-bind:key="index5"
                                                                        v-bind:class="caret(tree5.leaf)">
                                                                        <a v-if="tree5.leaf == 1"
                                                                            :href="'/vin/'+tree.mod_link+'/'+tree.client.ssd+'?path='+index1+'->'+index2+'->'+index3+'->'+index4+'->'+index5+'&tree_name='+tree5.name">{{tree5.name}}</a><span
                                                                            v-on:click="showRaw(tree5)"
                                                                            v-if="tree5.leaf == 0">{{tree5.name}}</span>
                                                                        <ul v-show="tree5.isShow"
                                                                            v-if="tree6.leaf == 0">
                                                                            <li v-for="(tree6, index6) in tree6.data"
                                                                                v-bind:key="index6"
                                                                                v-bind:class="caret(tree6.leaf)"><a
                                                                                    v-if="tree6.leaf == 1"
                                                                                    :href="'/vin/'+tree.mod_link+'/'+tree.client.ssd+'?path='+index1+'->'+index2+'->'+index3+'->'+index4+'->'+index5+'->'+index6+'&tree_name='+tree6.name">{{tree6.name}}</a><span
                                                                                    v-if="tree6.leaf == 0">{{tree6.name}}</span>
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
            },
            caret(data) {
                if (data == '0') {
                    return 'ml-4 caret';
                } else {
                    return 'ml-8 font-bold hover:text-indigo-500';
                }
            },

        }

    }
</script>