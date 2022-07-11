
import Swatches from '~/vue/Swatches.vue'
import { createApp } from 'vue'

// App main
const swatchesField = async () => {

    const swatchesFields = document.querySelectorAll('[id$=_swatches]')
    const swatchesFieldsToMount = new Object()

    swatchesFields.forEach( (swatchesField) => {

        let field = swatchesField.id.replace('-', '')

        // @ts-ignore
        swatchesFieldsToMount[field] = {
            'id': '#' + swatchesField.id,
            'swatch': createApp({ ...Swatches })
        }

    })

    const root = Object.entries(swatchesFieldsToMount).map(entry => {
        let field = entry[1]
        return field.swatch.mount(field.id)
    })

    return swatches

}

swatchesField().then( () => {
    console.log()
})

// Accept HMR as per: https://vitejs.dev/guide/api-hmr.html
if (import.meta.hot) {
    import.meta.hot.accept(() => {
        console.log('HMR')
    })
}