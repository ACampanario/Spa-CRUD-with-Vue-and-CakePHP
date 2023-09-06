import Vue from 'vue';
import VueMeta from 'vue-meta';
import PortalVue from 'portal-vue';
import { InertiaApp } from '@inertiajs/inertia-vue';

const AppName = 'My Vue App';

Vue.config.productionTip = false;

Vue.use(InertiaApp);
Vue.use(PortalVue);
Vue.use(VueMeta);

let app = document.getElementById('app');

console.log('vue app');

new Vue({
    metaInfo: {
        titleTemplate: (title) => title ? `${title} - ` + AppName : AppName
    },
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => import(`@/Components/Pages/Dashboard`).then(module => module.default),
        },
    }),
}).$mount(app);
