import vue from '@vitejs/plugin-vue'
import ViteRestart from 'vite-plugin-restart';
import { nodeResolve } from '@rollup/plugin-node-resolve';
import path from 'path';

// https://vitejs.dev/config/
export default ({ command }) => ({
    base: command === 'serve' ? '' : '/dist/',
    build: {
        manifest: true,
        outDir: '../src/web/assets/dist',
        rollupOptions: {
            input: {
                swatches: '/src/js/swatches.ts',
            },
            output: {
                sourcemap: true
            },
        }
    },
    plugins: [
        nodeResolve({
            moduleDirectories: [
                path.resolve('./node_modules'),
            ],
        }),
        ViteRestart({
            reload: [
                '../src/templates/**/*',
            ],
        }),
        vue(),
    ],
    publicDir: '../src/web/assets/public',
    resolve: {
        alias: {
            '@': '/src',
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    server: {
        host: '0.0.0.0',
        port: 3001,
        strictPort: true,
    }
});
