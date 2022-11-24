<template>
    <main1>
        <div>
            <div>
                <main>
                  <div class='sm:p-4 p-2'>   

<div class="min-w-screen  flex items-center justify-center px-5 py-5 mt-10">

        <section class="rounded-3xl shadow-xl w-full py-2 bg-gray-700 text-center" data-pg-collapsed>    
            <div class="container mx-auto px-4 relative" data-pg-collapsed> 
    <div class="flex flex-wrap -mx-4 leading-relaxed"> 
        <div class="p-4 w-full md:w-4/12"> 
            <div class="lg:px-8"> 
                <span class="bg-gray-600 inline-block mb-6 p-8 rounded-full text-white"> <svg viewBox="0 0 24 24" fill="currentColor" class="h-12 w-12"> 
                        <path d="M9.366 10.682a10.556 10.556 0 0 0 3.952 3.952l.884-1.238a1 1 0 0 1 1.294-.296 11.422 11.422 0 0 0 4.583 1.364 1 1 0 0 1 .921.997v4.462a1 1 0 0 1-.898.995c-.53.055-1.064.082-1.602.082C9.94 21 3 14.06 3 5.5c0-.538.027-1.072.082-1.602A1 1 0 0 1 4.077 3h4.462a1 1 0 0 1 .997.921A11.422 11.422 0 0 0 10.9 8.504a1 1 0 0 1-.296 1.294l-1.238.884zm-2.522-.657l1.9-1.357A13.41 13.41 0 0 1 7.647 5H5.01c-.006.166-.009.333-.009.5C5 12.956 11.044 19 18.5 19c.167 0 .334-.003.5-.01v-2.637a13.41 13.41 0 0 1-3.668-1.097l-1.357 1.9a12.442 12.442 0 0 1-1.588-.75l-.058-.033a12.556 12.556 0 0 1-4.702-4.702l-.033-.058a12.442 12.442 0 0 1-.75-1.588z"/> 
                    </svg></span> 
                <h5 class="font-bold mb-2 text-white text-lg uppercase">Номер</h5> 
                <ul> 
                    <li> 
                        <a href="tel:+0 123-456-789" class="text-white hover:text-yellow-400">+0 123-456-789</a> 
                    </li>                     
                    <li> 
                        <a href="tel:+0 123-456-789" class="text-white hover:text-yellow-400">+0 123-456-789</a> 
                    </li>                     
                </ul>                 
            </div>             
        </div>         
        <div class="p-4 w-full md:w-4/12"> 
            <div class="lg:px-8"> 
                <span class="bg-gray-600 inline-block mb-6 p-8 rounded-full text-white"> <svg viewBox="0 0 24 24" fill="currentColor" class="h-12 w-12"> 
                        <path d="M12 20.9l4.95-4.95a7 7 0 1 0-9.9 0L12 20.9zm0 2.828l-6.364-6.364a9 9 0 1 1 12.728 0L12 23.728zM12 13a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 2a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"></path>                         
                    </svg></span> 
                <h5 class="font-bold mb-2 text-white text-lg uppercase">Адрес</h5> 
                <div class='text-white'>9056 Fairground Ave.                         
                    <br>                         Dearborn, MI 48124                         
                    <br>                         United States of America                     
                </div>                 
            </div>             
        </div>         
        <div class="p-4 w-full md:w-4/12"> 
            <div class="lg:px-8"> 
                <span class="bg-gray-600 inline-block mb-6 p-8 rounded-full text-white"> <svg viewBox="0 0 24 24" fill="currentColor" class="h-12 w-12"> 
                        <path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm17 4.238l-7.928 7.1L4 7.216V19h16V7.238zM4.511 5l7.55 6.662L19.502 5H4.511z"></path>                         
                    </svg></span> 
                <h5 class="font-bold mb-2 text-white text-lg uppercase">Эл/почта</h5> 
                <a href="mailto:info@company.com" class="text-white hover:text-yellow-400">info@company.com</a> 
                <div>
                    <div class="flex-wrap inline-flex mt-2 py-1 space-x-1"> 
                        <a href="#" class="hover:text-white w-8 h-8 text-white hover:bg-yellow-400 bg-gray-500 rounded-full text-center"> <i class="my-2 mx-auto fab fa-whatsapp"></i></a> 
                        <a href="#" class="hover:text-white w-8 h-8  text-white hover:bg-yellow-400 bg-gray-500 rounded-full text-center"> <i class="my-2 mx-auto fab fa-telegram-plane"></i></a> 
                        <a href="#" class="hover:text-white w-8 h-8  text-white hover:bg-yellow-400 bg-gray-500 rounded-full text-center"> <i class="my-2 mx-auto fab fa-youtube"></i></a> 
                        <a href="#" class="hover:text-white w-8 h-8  text-white hover:bg-yellow-400 bg-gray-500 rounded-full text-center"> <i class="my-2 mx-auto fab fa-instagram"></i></a> 
                    </div>
                </div>                 
            </div>             
        </div>         
    </div>     
</div>
        </section>

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