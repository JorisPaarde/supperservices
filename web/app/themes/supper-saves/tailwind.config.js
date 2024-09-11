module.exports = {
    content: ['./resources/**/*.blade.php', './resources/**/*.ts', './resources/**/*.vue'],
    theme: {
        fontFamily: {
            sans: ['Bilo', 'UI-system'],
            title: ['Titling', 'UI-system'],
        },
        extend: {
            colors: {
                primary: '#14332A',
                secondary: '#6A9173',
                'carousel-pink': '#fdf4f5',
                'heavy-metal': '#1D1D1B',
                'petite-orchid': '#da8B8e',
                'au-chico': '#985c5e',
                cinnabar: '#e45e33',
                'cinnabar-dark': '#b64b28',
                whisper: '#ededf5',
            },
            fontSize: {
                xxs: '10px',
                xs: '12px',
            },
            spacing: {
                30: '7.5rem',
                40: '10rem',
            },
        },
    },
    plugins: [],
};
