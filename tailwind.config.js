import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', 'sans-serif']
            },
            colors: {
                'midnight-blue': '#282239',
                'pure-white': '#FFFFFF',
                'peach': '#FAD7B2',
                'deep-black': '#0B0F12',
                'lavender-purple': '#7965AB',
                'sky-blue': '#00A8E8',
            },
        },
    },
    plugins: [],
};
