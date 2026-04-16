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
    colors: {
      emerald: {
        50:  '#EDF7EF',
        100: '#D4EDD9',
        200: '#A8D5B5',
        400: '#2E8B57',
        700: '#256B47',
        800: '#1A4A33',
        900: '#0D2B20',
      },
      gold: {
        50:  '#FAF3DC',
        100: '#F3E2AF',
        200: '#E8C97A',
        400: '#C9960F',
        500: '#B8860B',
      },
      cream: {
        DEFAULT: '#F5F2EC',
        2:       '#EDE8DF',
        off:     '#FDFCFA',
      },
    },
    fontFamily: {
      cormorant: ['"Cormorant Garamond"', 'serif'],
      jost:      ['Jost', 'sans-serif'],
    },
  },
},

    plugins: [forms],
};
