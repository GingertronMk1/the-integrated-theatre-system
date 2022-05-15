/**
 * Vue and inertia imports
 */
import { createApp, h, ref } from "vue";
import { createInertiaApp, Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

/**
 * Vuetify imports
 */
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import Authenticated from "@/Layouts/Authenticated.vue";

require("./bootstrap");

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

const vuetify = createVuetify({
    components,
    directives,
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const createdApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(vuetify)
            .component("Authenticated", Authenticated)
            .component("Head", Head)
            .component("Link", Link)
            .mixin({ methods: { ref, route, useForm } });

        return createdApp.mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
