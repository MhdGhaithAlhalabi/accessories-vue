import {createApp, h} from 'vue';
import {createInertiaApp, Link, Head} from '@inertiajs/inertia-vue3';
import Layout from "./Shared/Layout.vue";
import {InertiaProgress} from '@inertiajs/progress';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

createInertiaApp({
    resolve: name => {
        let page = require(`./Pages/${name}`).default;
        if (page.layout === undefined) {
            page.layout = Layout;
        }
        return page;
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(VueSweetalert2)
            .component('Link', Link)
            .component('Head', Head)
            .mount(el)
    },
});
InertiaProgress.init();
/*
import { createApp, h } from 'vue';
import {createInertiaApp, Link} from '@inertiajs/inertia-vue3';

import '../css/app.css';

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob('./Pages/!**!/!*.vue');

        return (await pages[`./Pages/${name}.vue`]()).default;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Link',Link)
            .mount(el)
    },
});
*/

/*import './bootstrap';
import { createApp } from "vue";
import App from "./layout/App.vue";
import login from "./auth/login.vue"
import router from "./router";
const app = createApp(App);
app.use(router);
app.mount("#app");
const app2 = createApp(login);
app2.mount("#login");*/
//createApp(App).use(router).mount('#app');
