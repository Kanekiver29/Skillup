/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  safelist: [
    // Staff type dynamic colors (blue, green, purple, yellow)
    ...['blue', 'green', 'purple', 'yellow'].flatMap(color => [
      `bg-${color}-50`,
      `bg-${color}-100`,
      `text-${color}-600`,
      `text-${color}-700`,
      `border-${color}-500`,
      `hover:bg-${color}-50`,
    ]),
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
}

