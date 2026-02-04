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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Outfit', 'sans-serif'],
                body: ['Inter', 'sans-serif'],
            },
            colors: {
                emerald: {
                    900: '#022C22',
                    800: '#064E3B', // IPNU Primary
                    400: '#34D399',
                },
                amber: {
                    900: '#78350F',
                    700: '#B45309', // IPPNU Primary
                    400: '#FBBF24',
                },
                gold: {
                    500: '#C5A059', // Premium Accent
                    600: '#9F803A',
                },
                surface: {
                    light: '#F8F8F8',
                    dark: '#121212',
                    card: '#FFFFFF',
                }
            },
        },
    },
    plugins: [],
};
