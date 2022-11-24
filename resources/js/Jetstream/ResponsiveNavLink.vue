<template>
    <div>
        <button :class="classes" class="w-full text-left" v-if="as == 'button'">
            <slot></slot>
        </button>

        <inertia-link :href="href" :class="classes" v-else>
            <slot></slot>
        </inertia-link>
    </div>
</template>

<script>
    export default {
        props: ['active', 'href', 'as'],

        computed: {
            classes() {
                return this.active
                            ? 'block pl-3 pr-4 py-2 border-l-4 border-yellow-400 text-base font-medium text-indigo-700 bg-yellow-400 focus:outline-none focus:text-indigo-800 focus:bg-yellow-100 focus:border-yellow-700 transition duration-150 ease-in-out'
                            : 'block pl-3 pr-4 py-2 border-l-4 border-yellow-400 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-yellow-500 focus:outline-none focus:text-gray-800  focus:border-yellow-300 transition duration-150 ease-in-out'
            }
        }
    }
</script>
