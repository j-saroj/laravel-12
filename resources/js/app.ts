import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { initializeTheme } from './composables/useAppearance';
import Toast, { POSITION } from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import { createPinia } from 'pinia';

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}
const pinia = createPinia();
const appName = import.meta.env.VITE_APP_NAME || 'Website';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast, {
                position: POSITION.TOP_RIGHT, // Default position for the toast

                timeout: 5000, // Toast will disappear after 5 seconds
            })
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});


// This will set light / dark mode on page load...
initializeTheme();
