<template>
    <div class="flex flex-wrap p-2">
        <div class="w-full">
            <div class="mx-auto grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-2 bg-white rounded-lg  px-2 py-2 font-semibold">
                <div v-for="catalog in catalogs.mf"
                                v-bind:key="catalog">
                <inertia-link 
                                :href="'/catalogs/'+catalog.dbi+'?marka='+catalog.ds">
                    <div class="p-2 hover:bg-indigo-100 hover:shadow-lg bg-gray-100 rounded-lg">
                        {{catalog.ds}}
                    </div>
                </inertia-link>
                </div>
                
                
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['catalogs'],

    }
</script>