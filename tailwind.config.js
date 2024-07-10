/** @type {import('tailwindcss').Config} */
export default {
  content: ['./src/**/*.{html,js,svelte,ts}'],
  theme: {
    extend: {
      colors: {
        'brand-dark': '#2563EB',
        'brand-light': '#FFDD87'
      }
    },
  },
  daisyui: {
    themes: [
      {
        light: {
          ...require("daisyui/src/theming/themes")["[data-theme=light]"],
          primary: '#FFDD87',
          '.btn-primary': {
            'color': '#000',
          },
        }
      }
    ],
  },
  plugins: [require("daisyui")],
}

