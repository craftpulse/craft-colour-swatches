<script lang="ts">
    import { defineComponent } from 'vue'

    export default defineComponent({

        props: {
            options: {
                type: Object,
                required: true,
            }
        },

        methods: {
            generateBackground(colors) {

                if ( colors.length === 1 ) {
                    return 'background-color: ' + colors[0].color
                } else {
                    const percentage = (100 / colors.length)
                    let gradient = ''

                    colors.forEach( (color, index, colors) => {
                        gradient += (color.color + ' ' + (percentage * index) + '%,' + color.color + ' ' + (percentage * (index + 1)) + '%')
                        if (index !== colors.length - 1) {
                            gradient += ','
                        }
                    })

                    return 'background: linear-gradient(to right, ' + gradient + ')'
                }

            }
        }

    })
</script>

<template>

    <div class="grid grid-cols-6 gap-8">
        
        <div class="mb-8 max-w-40">

            <h3 class="text-gray-550 text-sm font-bold pb-2 mb-0">
                Current Selection
            </h3>

            <hr class="h-px bg-gray-550 mb-6 mt-1" />

            <div class="h-40 w-40 rounded-xl overflow-hidden bg-slate-100 flex flex-col">
                
                <div
                    :style="generateBackground(options.selectedSwatch.color)"
                    class="w-full flex-grow"
                >
                </div>

                <div class="py-1 px-2 flex-grow-0">
                    <span class="text-gray-550 font-bold text-sm line-clamp-2">
                        {{ options.selectedSwatch.label }}
                    </span>
                </div>

            </div>
        </div>

        <div class="col-span-5">

            <h3 class="border border-b-2 border-gray-550 text-gray-550 text-sm font-bold pb-2 mb-0">
                Palette
            </h3>

            <hr class="h-px bg-gray-550 mb-6 mt-1" />

            <div class="flex flex-row space-x-2">

                <div 
                    v-for="(swatch, index) in options.palette" 
                    :key="index"
                    :class="[
                        'w-11 h-11 rounded-md overflow-hidden cursor-pointer',
                        options.selectedSwatch.label === swatch.label ? 'shadow-selected' : ''
                    ]"
                >

                    <div
                        :style="generateBackground(swatch.color)"
                        class="w-full h-full"
                    >
                    </div>

                </div>

            </div>

        </div>
    </div>

    <div class="bg-emerald-200 px-8 py-16 rounded-lg border-2 border-black">
        {{ options }}
    </div>

</template>