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
            colors: {
                gray: {
                    550: '#5a6875',
                }
            },
            boxShadow: {
                selected: '0 0 0 3px #ffffff, 0 0 0 7px #5a6875',
            },
            maxWidth: {
                40: '10rem',
            }
        }
    },
    corePlugins: {},
    plugins: [
        require('@tailwindcss/line-clamp'),
    ],
};