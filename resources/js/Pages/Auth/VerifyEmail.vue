<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Спасибо за регистрацию! Прежде чем начать, не могли бы вы подтвердить свой номер телефона, введя шестизначный номер, которую мы вам только что отправили? Если вы не получили письмо, мы с радостью отправим вам другое.
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
            Отправлен новый код, для подтверждения номера телефона.
        </div>
        <div class="mb-4 font-medium text-sm text-green-600" v-if="$page.props.flash.message" >
            <p class="text-sm">{{ $page.props.flash.message }}</p>
        </div>

        <form action="/users/verification" method="post">
        
<div class="flex w-full justify-center items-end">
                                <div class="relative mr-4 lg:w-full xl:w-1/2 w-2/4 md:w-full text-left">
                                    <label for="codeid" class="leading-7 text-sm text-gray-600">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">Код подтверждения</font>
                                        </font>
                                    </label>
                                    <input type="text" id="hero-field" name="codeid"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded focus:ring-2 focus:ring-indigo-200 focus:bg-transparent border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required>
                                </div>
                                <button
                                    class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg" type="submit">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Подтвердить</font>
                                    </font>
                                </button>
                            </div>
        </form>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Отправить заново
                </jet-button>

                <inertia-link :href="route('logout')" method="post" as="button" class="underline text-sm text-gray-600 hover:text-gray-900">Выйти</inertia-link>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form(),
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('verification.send'))
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === 'verification-link-sent';
            }
        }
    }
</script>
