/** @type {import('tailwindcss').Config} */
export default {
  corePlugins: {
    preflight: false,
  },
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#1d4ed8',   // bg-primary, text-primary
        secondary: '#fbbf24', // bg-secondary, text-secondary
      },
      fontFamily: {
        sans: ['Figtree', 'sans-serif'],
      },
      spacing: {
        128: '32rem', // mt-128, p-128 etc.
      },
    },
  },
  
  plugins: [],
}
