/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./dashboard/**/*.{php, html}",
    "./*.{php,html}",
    "./dashboard/admin/**/*.{php, html}",
    "./rooms/**/*.{php, html}",
    "./reservation/**/*.{php, html}",
    "./create-room/**/*.{php, html}",
    "./booking/**/*.{php, html}",
  ],
  theme: {
    extend: {
      colors: {
        background: "var(--background-color)",
        header: "var(--header-color)",
        accent: "var(--accent-color)",
        card: "var(--card-color)",
        cardText: "var(--card-text-color)",
      },
      fontFamily: {
        accent: "var(--accent-font)",
        regular: "var(--regular-font)",
        secondary: "var(--secondary-font)",
      },
    },
  },
  plugins: [],
};
