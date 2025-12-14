import axios from 'axios';
window.axios = axios;
import * as bootstrap from 'bootstrap/dist/js/bootstrap.bundle';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import { ZiggyVue } from 'ziggy-js'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(ZiggyVue, props.initialPage.props.ziggy)
            .use(plugin)
            .provide('bootstrap', bootstrap)
            .mount(el)
    },
})
