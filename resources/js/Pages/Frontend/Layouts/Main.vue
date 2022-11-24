<style scoped>
    #menu-toggle:checked+#menu {
        display: block;
    }
</style>
<template>
    <div>
        <header
            class='fixed max-w-screen-2xl z-50 w-full lg:px-10 px-6 bg-gray-700 shadow-md flex flex-wrap items-center lg:py-0 py-2'>
            <div class='flex-1 flex justify-between items-center'>
                <inertia-link href="/" class='rounded-full'>
                    <img class="h-10 w-auto rounded-full" src="/img/logo.png" alt="">
                </inertia-link>
            </div>
            <jet-dropdown>
                <template #trigger>
                    <span class="sr-only">Open user menu</span>
                    <i class="fas fa-user-circle text-4xl text-white lg:hidden block hover:text-yellow-400 cursor-pointer"></i>
                </template>    
                <template #content>
                    <div v-if="$page.props.auth.user.loggedIn">
                    <inertia-link href="/user/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Личный
                        кабинет</inertia-link>
                    <inertia-link v-if="$page.props.auth.role.can" href="/dashboard/users" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem">Админ панель</inertia-link>
                    <jet-responsive-nav-link @click="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        Выход
                    </jet-responsive-nav-link>
                    </div>
                    <div v-else>
                        <inertia-link href="/register" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Регистрация</inertia-link>
                        <inertia-link href="/login" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Вход</inertia-link>
                    </div>
                </template>
            </jet-dropdown>
            <label for="menu-toggle" class='cursor-pointer lg:hidden block'>
                <i class="pl-4 text-2xl focus:outline-none fal fa-bars text-white"></i>
            </label>
            <input type="checkbox" class='hidden' id='menu-toggle' />
            <div class='hidden lg:flex lg:items-center lg:w-auto w-full' id="menu">
                
                <nav>
                    
                    <ul class='lg:flex items-center justify-between text-base text-white pt-4 lg:pt-0'>
                        <li>
                            <inertia-link href="/catalog"
                                class='transition ease-in-out duration-300 lg:p-4 py-3 px-0 block border-b-2  border-transparent hover:border-yellow-400'>Каталог</inertia-link>
                        </li>
                        <li>
                            <inertia-link href="/faq"
                                class='transition ease-in-out duration-300 lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-yellow-400'>Справка</inertia-link>
                        </li>
                        <li>
                            <inertia-link href="/movement"
                                class='transition ease-in-out duration-300 lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-yellow-400'>Движение
                                заказов</inertia-link>
                        </li>
                        <li>
                            <inertia-link href="/contacts"
                                class='transition ease-in-out duration-300 lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-yellow-400'>Контакты</inertia-link>
                        </li>
                         
                        <li>
                            <inertia-link href="/basket"
                                class='transition ease-in-out duration-300 lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-yellow-400'>Корзина<slot name='alert'></slot></inertia-link>
                            
                        </li>

                   
                     
                  <jet-dropdown>
                        <template #trigger>
                            <span class="sr-only">Open user menu</span>
                            <i class="fas fa-user-circle text-3xl lg:block hidden hover:text-yellow-400 cursor-pointer"></i>
                        </template>
                           <template #content>
                                <div v-if="$page.props.auth.user.loggedIn">
                                    <inertia-link href="/user/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Личный
                                        кабинет</inertia-link>
                                    <inertia-link v-if="$page.props.auth.role.can" href="/dashboard/users" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Админ панель</inertia-link>
                                                     

                                        <jet-responsive-nav-link @click="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        Выход
                                        </jet-responsive-nav-link>
                                </div>
                                <div v-else>
                                    <inertia-link href="/register" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Регистрация</inertia-link>
                                    <inertia-link href="/login" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Вход</inertia-link>
                                </div>
                           </template>
                    </jet-dropdown>    
                    </ul>
                  
                </nav>


            </div>

            <!-- Поиск по вин-коду -->
             
         
            <!-- End -->
        </header>
    <div class='h-full min-h-screen'>
        <slot></slot>
    </div>    
    <div> 
            <footer-component></footer-component>
    </div>      
    </div>


</template>



<script>
    import FooterComponent from '@/components/FooterComponent.vue'
    import Tabs from '@/components/Tabs.vue'
    import JetDropdown from '@/Jetstream/Dropdown'


    export default {
        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        components: {
            FooterComponent,
            Tabs,
            JetDropdown

        },
        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },
        }

    }
</script>