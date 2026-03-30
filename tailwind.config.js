import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#6366F1',
                'primary-dark': '#4F46E5',
                'accent': '#EC4899',
                'accent-light': '#F472B6',
                'success': '#10B981',
                'warning': '#F59E0B',
                'danger': '#EF4444',
            },
            backgroundImage: {
                'gradient-primary': 'linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%)',
                'gradient-vibrant': 'linear-gradient(135deg, #EC4899 0%, #6366F1 100%)',
                'gradient-success': 'linear-gradient(135deg, #10B981 0%, #059669 100%)',
                'gradient-warm': 'linear-gradient(135deg, #F59E0B 0%, #F97316 100%)',
                'gradient-cool': 'linear-gradient(135deg, #06B6D4 0%, #3B82F6 100%)',
            },
        },
    },

    plugins: [forms],
};

