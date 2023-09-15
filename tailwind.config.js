const theme = require('./src/renderer/resources/theme')
const safelist = require('./src/renderer/resources/tailwind.savelist')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['src/renderer/src/**/*.{js,vue,html}'],
  safelist: safelist,
  theme: theme,
  plugins: [require('@tailwindcss/forms'), require('tailwind-scrollbar')({ nocompatible: true })]
}
