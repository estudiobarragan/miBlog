const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');
const { Container } = require('postcss');

module.exports = {
    mode: '',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

  theme: {
    colors: {
      ...colors,
      transparent: 'transparent',
      blue: {
        50: "#daf8ff",
        100: "#aee5ff",
        200: "#7ed2ff",
        300: "#4dc0ff",
        400: "#23aefe",
        500: "#1095e5",
        600: "#0083ca",
        700: "#005381",
        800: "#003250",
        900: "#001220",
      },
      darkBlue: {
        50: '#e3f5ff',
        100: '#bfe0f1',
        200: '#99c9e5',
        300: '#73b3da',
        400: '#4e9ece',
        500: '#3684b5',
        600: '#27678d',
        700: '#17415a',
        800: '#0b2c3f',
        900: '#001019',
      },  
      red: {
        50: "#ffe3e7",
        100: "#ffb5bd",
        200: "#fa8591",
        300: "#f75566",
        400: "#F2142B",
        500: "#d90c21",
        600: "#aa0519",
        700: "#7a0312",
        800: "#4b0008",
        900: "#1f0002",
      },
      green: {
        50: "#e2fbef",
        100: "#c1ecd6",
        200: "#9ddfbc",
        300: "#79d1a2",
        400: "#55c489",
        500: "#3baa6f",
        600: "#2c8455",
        700: "#1d5f3d",
        800: "#0d3a23",
        900: "#001506",
      },
      orange: 
      {
        50: '#fff4db',
        100: '#ffe2af',
        200: '#fccf80',
        300: '#fabb50',
        400: '#ffd300',
        500: '#df8e07',
        600: '#ad6f02',
        700: '#7d4f00',
        800: '#4b2e00',
        900: '#1e0f00',
      },
      yellow: 
      {
        50: '#fffbda',
        100: '#fff2ad',
        200: '#ffe97d',
        300: '#ffe04b',
        400: '#ffd71a',
        500: '#ffd300',
        600: '#b39400',
        700: '#806a00',
        800: '#4d3f00',
        900: '#1c1500',
      },
    },
    extend: {
          fontFamily: {
              sans: ['Nunito', ...defaultTheme.fontFamily.sans],
          },
      },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
    
  corePlugins: {
    container: false,
  },
};
