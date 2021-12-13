// module exports
module.exports = {
    mode: 'jit',
    purge: {
        content: [
            '../src/templates/**/*.{twig,html}',
            './src/vue/**/*.{vue,html}',
        ],
        layers: [
            'base',
            'components',
            'utilities',
        ],
        mode: 'layers',
        options: {
            whitelist: [
                './src/css/components/*.css',
            ],
        }
    },
    theme: {
        extend: {
            minHeight: (theme) => ({
                12: theme('height.12')
            })
        }
    },
    corePlugins: {},
    plugins: [],
};
