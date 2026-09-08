import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './public/assets/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                canvas: {
                    base: '#F8F9FA',      // Luminous warm canvas
                    subtle: '#F4F5F7',
                },
                surface: {
                    base: '#F8F6F2',      // Warm Alabaster / Bone
                    card: '#FFFFFF',      // Pure Crisp White
                    pedestal: '#F8F9FA',  // Soft Warm Pedestal for watches
                    hover: '#EFEAE4',     // Subtle Hover
                    border: '#E5E7EB',    // Border tone
                    champagne: '#EADBCC', // Warm Champagne Border
                },
                gold: {
                    champagne: '#C5A059', // Primary Satin Champagne Gold
                    satin: '#B38E44',     // Rich Satin Gold
                    bronze: '#8C7355',    // Warm Bronze
                    dark: '#7A5E2E',
                    DEFAULT: '#C5A059',
                },
                obsidian: {
                    DEFAULT: '#18181B',   // Obsidian Espresso Headings & Key text
                    secondary: '#52525B', // Clean readable subtext
                    muted: '#71717A',     // Specs and details
                },
                espresso: {
                    main: '#18181B',
                    secondary: '#52525B',
                    muted: '#71717A',
                },
                emerald: {
                    wa: '#25D366',        // WhatsApp official green
                },
                rose: {
                    promo: '#E11D48',     // Discount red
                },
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', '"Readex Pro"', ...defaultTheme.fontFamily.sans],
                royal: ['Cinzel', 'serif'],
                arabic: ['"Readex Pro"', 'sans-serif'],
                display: ['Cinzel', 'serif'],
            },
            borderRadius: {
                'card': '1rem',
                'btn': '0.75rem',
                'pill': '9999px',
            },
            boxShadow: {
                'card-luxury': '0 4px 20px rgba(0, 0, 0, 0.04)',
                'card-hover': '0 10px 30px rgba(0, 0, 0, 0.08)',
                'gold-subtle': '0 4px 16px rgba(197, 160, 89, 0.18)',
                'gold-glow': '0 0 20px rgba(197, 160, 89, 0.25)',
            },
            keyframes: {
                'marquee-scroll': {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
                'pulse-subtle': {
                    '0%, 100%': { transform: 'scale(1)', opacity: '1' },
                    '50%': { transform: 'scale(1.05)', opacity: '0.9' },
                }
            },
            animation: {
                'marquee': 'marquee-scroll 25s linear infinite',
                'pulse-subtle': 'pulse-subtle 2s infinite ease-in-out',
            },
        },
    },

    plugins: [forms],
};

