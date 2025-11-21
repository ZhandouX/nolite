/** @type {import('tailwindcss').Config} */
export default {
  darkMode: "class",

  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./resources/**/*.ts",
    "./resources/**/*.tsx",
    "./public/assets/js/**/*.js",
  ],

  theme: {
    extend: {
      colors: {
        primary: {
          50: "#f0f9ff",
          100: "#e0f2fe",
          500: "#0ea5e9",
          600: "#0284c7",
          700: "#0369a1",
        },
      },
      keyframes: {
        fadeIn: {
          "0%": { opacity: "0" },
          "100%": { opacity: "1" },
        },
        slideIn: {
          "0%": { transform: "translateX(-100%)" },
          "100%": { transform: "translateX(0)" },
        },
        springIn: {
          '0%': { transform: 'scale(0.6)' },
          '40%': { transform: 'scale(1.25)' },
          '60%': { transform: 'scale(0.9)' },
          '100%': { transform: 'scale(1)' },
        },
        springOut: {
          '0%': { transform: 'scale(1)' },
          '60%': { transform: 'scale(0.75)' },
          '100%': { transform: 'scale(1)' },
        },
      },
      animation: {
        "fade-in": "fadeIn 0.5s ease-in-out",
        "slide-in": "slideIn 0.3s ease-out",
        "pulse-slow": "pulse 3s infinite",
        "springIn": "springIn 0.3s ease-out",
        "springOut": "springOut 0.3s ease-out",
      },
    },
  },

  plugins: [],
}
