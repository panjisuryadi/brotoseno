module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        container: {
            center: true,
            screens: {
                "2xl": { max: "1536px" },
                xl: { max: "1280px" },
                lg: { max: "1023px" },
                md: { max: "767px" },
                sm: { max: "639px" },
            },
            padding: {
                DEFAULT: "1rem",
                sm: "2rem",
                lg: "4rem",
                xl: "5rem",
                "2xl": "6rem",
            },
        },
        extend: {
            colors: {},
            fontSize: {
                vl: "76px",
            },
            fontFamily: {
                display: ["Poppins", "Inter", "system-ui", "sans-serif"],
                body: ["Poppins", "Inter", "system-ui", "sans-serif"],
            },
        },
    },
    plugins: [],
};
