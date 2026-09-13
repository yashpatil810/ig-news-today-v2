import { defineConfig } from 'vite';
// import legacy from '@vitejs/plugin-legacy';
import { ViteImageOptimizer } from 'vite-plugin-image-optimizer';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        // legacy({
        //     targets: ['defaults', 'not IE 11']
        // }),
        ViteImageOptimizer({
            jpg: {
                quality: 80,
            },
            png: {
                quality: 80,
            },
            webp: {
                quality: 80,
            },
        }),
    ],
    
    // Build configuration
    build: {
        manifest: true,
        outDir: 'assets/dist',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                main: resolve(__dirname, 'assets/src/js/main.js'),
            },
            output: {
                entryFileNames: 'js/[name].[hash].js',
                chunkFileNames: 'js/[name].[hash].js',
                assetFileNames: (assetInfo) => {
                    const info = assetInfo.name.split('.');
                    const ext = info[info.length - 1];
                    
                    if (/\.(css)$/.test(assetInfo.name)) {
                        return 'css/[name].[hash][extname]';
                    }
                    
                    if (/\.(png|jpe?g|svg|gif|webp|avif)$/.test(assetInfo.name)) {
                        return 'images/[name].[hash][extname]';
                    }
                    
                    if (/\.(woff2?|eot|ttf|otf)$/.test(assetInfo.name)) {
                        return 'fonts/[name].[hash][extname]';
                    }
                    
                    return 'assets/[name].[hash][extname]';
                },
            },
        },
    },
    
    // Development server configuration
    server: {
        host: 'localhost',
        port: 5173,
        strictPort: true,
        cors: true,
        hmr: {
            host: 'localhost',
            protocol: 'ws',
        },
    },
    
    // CSS configuration
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler'
            }
        },
        devSourcemap: true,
    },
    
    // Base public path - use relative so assets work in subdirectory installs (e.g. /ig-news-today/)
    base: process.env.NODE_ENV === 'production' 
        ? './' 
        : '/',
});

