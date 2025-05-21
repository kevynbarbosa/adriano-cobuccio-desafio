import "../css/app.css";
import "./bootstrap";

import { createInertiaApp } from "@inertiajs/vue3";
import { Modal, ModalLink, renderApp } from "@inertiaui/modal-vue";
import Aura from "@primeuix/themes/aura";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import PrimeVue from "primevue/config";
import ToastService from "primevue/toastservice";
import { createApp } from "vue";
import VueTheMask from "vue-the-mask";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")),
    setup({ el, App, props, plugin }) {
        return createApp({ render: renderApp(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                ripple: true,
                theme: {
                    preset: Aura,
                },
            })
            .component("Modal", Modal)
            .component("ModalLink", ModalLink)
            .use(ToastService)
            .use(VueTheMask)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
