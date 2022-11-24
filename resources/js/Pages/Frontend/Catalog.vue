<template>
        <main1> 
              <div>
                <div class='bg-gray-700 h-64 w-full -mb-44'></div>
                <main class='p-2'>  
                  <div class='mb-4 sm:mb-16 lg:px-4'>
                    <section class="text-gray-600 body-font mb-24">
                      <div class="container pb-2 bg-gray-300 rounded-md mx-auto w-full items-start justify-center">
                          <div class="px-4 py-5 sm:px-6 w-full bg-yellow-500  mb-2 rounded-md">
                              <h3 class="lg:text-2xl leading-6 font-medium text-white">
                                  Каталоги автозапчастей
                              </h3>
                              <p class="mt-1 max-w-2xl text-sm text-white">
                                  Производители
                              </p>
                          </div>
                         <div class="flex flex-wrap p-2">
                            <div class="w-full">
                                <div class="mx-auto grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-2 bg-white rounded-lg  px-2 py-2 font-semibold">
                                    <div v-for="catalog in catalogs.mf" v-bind:key="catalog">
                                    <inertia-link  :href="'/catalogs/'+catalog.dbi+'?marka='+catalog.ds">
                                        <div class="p-2 hover:bg-yellow-100 hover:shadow-lg bg-gray-100 rounded-lg">
                                            {{catalog.ds}}
                                        </div>
                                    </inertia-link>
                                    </div> 
                                </div>
                            </div>
                        </div>
                      </div>
                  </section>
                  </div>
                  <!-- <tabs v-bind:catalogs="catalogs" ></tabs> -->
              </main>
            </div>
        </main1>
  </template>
<script>
import Main1 from '@/Pages/Frontend/Layouts/Main.vue'

      export default {
          props: ['catalogs'],

          components: {
                 Main1

          },
          data() {
            return {
                

            }
        },
        methods: {

        },

    }
</script>
  