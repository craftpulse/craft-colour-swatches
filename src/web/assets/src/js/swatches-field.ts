import Swatches from '@/vue/swatches.vue'
import { createApp } from 'vue'

// App main
const main = async () => {

    const swatchFields = document.querySelectorAll('[id$=_swatches]')
    const swatchFieldsToMount = new Object()

    swatchFields.forEach( (swatchField) => {

        let field = swatchField.id.replace('-', '')

        swatchFieldsToMount[field] = {
            'id': '#' + swatchField.id,
            'app': createApp({ ...Swatches })
        }

    })

    const root = Object.entries(swatchFieldsToMount).map(entry => {
        let field = entry[1]
        return field.app.mount(field.id)
    })

    return root

}

main().then( (root) => {})