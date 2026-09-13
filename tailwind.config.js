const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './vendor/wire-elements/modal/src/ModalComponent.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Space Grotesk"', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Brand primary — aliases Tailwind's `indigo-*` utilities (used
                // throughout the app) to the studio's teal/cyan identity color.
                indigo: colors.teal,
                // Warm secondary accent for discount badges, ratings and price
                // call-outs — used sparingly, never as the page's main hue.
                accent: {
                    DEFAULT: '#dd7f31',
                    soft: '#fbeada',
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
