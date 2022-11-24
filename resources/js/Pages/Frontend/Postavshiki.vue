<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Поставщики
            </h2>
        </template>

    <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-x-auto shadow-xl sm:rounded-lg px-4 py-4">
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.message">
                      <div class="flex">
                        <div>
                          <p class="text-sm">{{ $page.props.flash.message }}</p>
                        </div>
                      </div>
                    </div>
                    <div v-if="$page.props.errors" class="text-red-500"><div v-for="error in $page.props.errors" v-bind:key="error"><p class="text-sm">{{ error }}</p></div></div>

                    
                    <div class='overflow-x-auto rounded-xl'>
                        <table class="w-full">
                        <thead >
                            <tr class="bg-gray-700 text-white border">
                                <th class="border px-4 py-2">Название скидки</th>
                                <th class="border px-4 py-2">Статус</th>
                                <th class="border px-4 py-2">Действия</th>
                            </tr>
                        </thead>
                        
                        <tbody v-for="row in data" v-bind:key="row.id" class="border">
                            <tr>
                                <td class="border px-4 py-2">{{ row.name }}</td>
                                <td class="border px-4 py-2 text-center">{{ row.status }}</td>
                                <td class="border px-4 py-2">
                                    <div class='flex flex-col flex-wrap'> 
                                    <button @click="TernOn(row)" v-if="row.status == 'Выключен'" class="flex-auto bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg mx-2 my-1">Включить</button>
                                    <button v-else @click="TernOff(row)" class="flex-auto bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded-lg mx-2 my-1">Выключить</button></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
        data() {
            return {
                editMode: false,
                isOpen: false,
                form: {
                    name: null,
                    procent: null
                },
            }
        },
        methods: {
            TernOn: function (row) {
                if (!confirm('Вы уверены что хотите включить этого поставщика?')) return;
                this.$inertia.get('/dashboard/postavshiki/on/'+row.id)

            },
            TernOff: function (row) {
                if (!confirm('Вы уверены что хотите выключить этого поставщика?')) return;
                this.$inertia.get('/dashboard/postavshiki/off/'+row.id)
 
            },
        }
    }
</script>
