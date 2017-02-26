import Home         from './components/Home.vue'

import VueRouter    from 'vue-router'
import Vue          from 'vue'

// Use plugin.
// This installs <router-view> and <router-link>,
// and injects $router and $route to all router-enabled child components
Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    base: __dirname,
    linkActiveClass: 'active',
    routes: [
        { path: '/home', component: Home },
    ]
});