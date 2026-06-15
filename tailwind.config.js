import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Outfit', 'sans-serif'],
                body: ['Inter', 'sans-serif'],
            },
            colors: {
                emerald: {
                    900: '#051a12',
                    800: '#08332c', // IPNU Primary — design system
                    700: '#0f4a3a',
                    400: '#34D399',
                },
                amber: {
                    900: '#78350F',
                    700: '#B45309',
                    400: '#FBBF24',
                },
                gold: {
                    500: '#ba9e6f', // Design system gold
                    400: '#d4bc91', // Design system gold-light
                    600: '#9a8050',
                },
                surface: {
                    light: '#f4f4f4', // Design system bg-page
                    dark: '#051a14ff',
                    card: '#FFFFFF',
                }
            },
        },
    },
    plugins: [],
};
