import '../css/app.css';

import Heading from '@/components/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import ConfirmAlertDialog from '@/usable/ConfirmAlertDialog.vue';
import Dialog from '@/usable/Dialog.vue';
import Modal from '@/usable/Modal.vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
const appName = 'Tiptip Event and Project Management System';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('Toaster', Toaster)
            .component('AppLayout', AppLayout)
            .component('Heading', Heading)
            .component('ConfirmAlertDialog', ConfirmAlertDialog)
            .component('Dialog', Dialog)
            .component('Modal', Modal)

            .mount(el);
    },
    progress: {
        color: '#20a418',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
