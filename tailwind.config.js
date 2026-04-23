import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
  extend: {
    colors: {
      /* ── Brand: Coklat — Kehangatan & Premium ── */
      brand: {
        50:  '#FDF8F5',   /* Linen White     */
        100: '#F3E8E0',   /* Champagne Pink  */
        200: '#E0CDBD',   /* Desert Sand     */
        400: '#A67D5D',   /* Cafe Au Lait    */
        700: '#5C3A21',   /* Dark Sienna     */
        800: '#4A2A18',   /* Bistre Brown    */
        900: '#2E1503',   /* Chocolate Noir  */
      },
      /* ── Gold: Emas — Kemewahan & Eksklusivitas ── */
      gold: {
        50:  '#FAF3DC',   /* Cornsilk        */
        100: '#F3E2AF',   /* Wheat           */
        200: '#E8C97A',   /* Gold Crayola    */
        400: '#C9960F',   /* Dark Goldenrod  */
        500: '#B8860B',   /* Dark Goldenrod  */
      },
      /* ── Cream: Krem — Kenyamanan & Kebersihan ── */
      cream: {
        DEFAULT: '#F5F2EC', /* Eggshell       */
        2:       '#EDE8DF', /* Bone           */
        off:     '#FDFCFA', /* Floral White   */
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