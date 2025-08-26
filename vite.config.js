import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'], // Only JS input when cssCodeSplit is false
            refresh: true,
        }),
        tailwindcss(), // bật Tailwind v4 cho Vite
    ],
    css: {
        devSourcemap: true,
    },
    build: {
        cssCodeSplit: false, // Prevent CSS code splitting for faster load
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    const info = assetInfo.name.split('.');
                    const extType = info[info.length - 1];
                    if (/\.(css)$/.test(assetInfo.name)) {
                        return `css/[name]-[hash].${extType}`;
                    }
                    return `assets/[name]-[hash].${extType}`;
                },
            },
        },
    },
})
