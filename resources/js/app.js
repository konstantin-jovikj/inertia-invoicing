import '../css/app.css';
import './bootstrap';
import 'tippy.js/dist/tippy.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import VueTippy from 'vue-tippy'
import { renderApp } from '@inertiaui/modal-vue'
// import { Modal, ModalLink, renderApp } from '@inertiaui/modal-vue'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // return createApp({ render: () => h(App, props) })
        return createApp({ render: renderApp(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(VueTippy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
