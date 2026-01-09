import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class', 
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'nasdem-navy': '#001F3F',
                'nasdem-red': '#e31b23',
                'nasdem-gold': '#FFD700',
                'nasdem-blue': '#0a2f5a',
                'nasdem-orange': '#fdb717',
            },
        },
    },
    plugins: [],
}