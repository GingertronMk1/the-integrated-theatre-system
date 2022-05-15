/**
 * Vue and inertia imports
 */
import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

/**
 * Vuetify imports
 */
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { aliases, mdi } from "vuetify/iconsets/mdi";
import "@mdi/font/css/materialdesignicons.css"; // Ensure you are using css-loader
import "vuetify/styles";

/**
 * Default components/layouts
 */
import DefaultLayout from "@/Layouts/Default.vue";

require("./bootstrap");

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: "mdi",
        aliases,
        sets: {
            mdi,
        },
    },
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const createdApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(vuetify)
            .component("DefaultLayout", DefaultLayout)
            .component("Head", Head)
            .component("Link", Link)
            .mixin({
                methods: {
                    route,
                },
            });

        return createdApp.mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
