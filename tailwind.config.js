/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  // Bootstrap/AdminLTE remain active during the transition. Disabling
  // preflight prevents Tailwind's reset from changing existing screens.
  corePlugins: {
    preflight: false,
  },
  theme: {
    extend: {},
  },
  plugins: [],
}
