const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            outline: {
                yellow: ['2px solid #FFFF00'],
              }
        },
    },

    variants: {
        outline: ["focus"],
        extend: {
            opacity: ['disabled'],
            animation: ['responsive', 'hover', 'focus'],
        },
    },

    
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
