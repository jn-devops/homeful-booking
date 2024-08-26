/** @type {import('tailwindcss').Config} */
export default {
    content: [
      './app/Filament/**/*.php',
      './resources/views/filament/**/*.blade.php',
      './vendor/filament/**/*.blade.php',

      './resources/views/**/*.blade.php',
      './resources/js/**/*.vue',
      'node_modules/preline/dist/*.js',
    ],
    theme: {
      extend: {
        extend: {
          screens: {
              'xs': '320px', // Add custom breakpoint
          },
      },
      },
    },
    plugins: [
      require('preline/plugin'),
    ],
  }
