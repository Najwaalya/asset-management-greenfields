import defaultTheme from 'tailwindcss/defaultTheme';

export default {
    theme: {
        extend: {
            colors: {
                green: {
                    50: '#f0f9f4',
                    100: '#e0f4e8',
                    200: '#c1e8d2',
                    300: '#a5d6a7',
                    400: '#81c784',
                    500: '#66bb6a',
                    600: '#2e7d32',
                    700: '#1b5e20',
                    800: '#145a0c',
                    900: '#0d3818',
                },
                greenfields: {
                    dark: '#1B5E20',
                    natural: '#2E7D32',
                    light: '#A5D6A7',
                    50: '#f0f9f4',
                    100: '#e0f4e8',
                },
            },
            fontFamily: {
                sans: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                lg: '0.75rem',
                xl: '1rem',
            },
            boxShadow: {
                sm: '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                md: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                lg: '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
                xl: '0 20px 25px -5px rgba(0, 0, 0, 0.1)',
                '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.1)',
            },
            animation: {
                'fade-in': 'fadeIn 0.3s ease-in-out',
                'slide-in': 'slideIn 0.3s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideIn: {
                    '0%': { transform: 'translateY(-10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
            },
            transitionDuration: {
                150: '150ms',
                200: '200ms',
                300: '300ms',
            },
        },
    },
};
