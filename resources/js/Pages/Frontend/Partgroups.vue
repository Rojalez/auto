<template>
    <main1>
        <div>
            <div>
                <main>
                    
                    <div class='sm:p-6 p-2'>

                    <div class='mt-16'>
                        <table
                            class="w-full rounded-lg overflow-hidden sm:shadow-lg my-5">
                            <thead class="text-black bg-gray-300">
                                <tr class="bg-teal-400  rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                    <th class="p-3 text-left">Название группы</th>
                                    <th class="p-3 text-left"></th>

                                </tr>
                                
                            </thead>
                             
                            <tbody class=" bg-white">
                                <tr v-for="group in orderedGroups" v-bind:key="group.group_name" class=" mb-2 sm:mb-0 border-b hover:bg-gray-200" >
                                    <td class=" p-3">{{group.full_name}}</td>
                                     <td class="hover:bg-indigo-500 bg-indigo-400 p-3 hover:font-medium text-center text-white"><a v-if="partgroups.next == '1'" v-bind:href="'/partgroups/'+partgroups.client.ssd+'/'+partgroups.link+'?group='+group.group_name"><div class='w-full h-full'>Выбрать</div></a>
                                     <a v-if="partgroups.next == '0'" v-bind:href="'/partgroups/'+partgroups.client.ssd+'/'+partgroups.link+'/'+group.group_name"><div class='w-full h-full'>Выбрать</div></a></td>

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
        props: ['partgroups'],
        components: {
            Main1
        },
        data() {
            return {

            }
        },
        methods: {

        },
        computed: {
            orderedGroups: function () {
                return _.orderBy(this.partgroups.groups, 'group_name')
            }
        }

    }
</script>