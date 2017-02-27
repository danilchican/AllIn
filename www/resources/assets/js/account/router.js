import Home         from './components/Home.vue'
import Posting      from './components/Posting.vue'
import Calendar     from './components/Calendar.vue'
import Statistic    from './components/Statistic.vue'
import Settings     from './components/Settings.vue'

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
        { path: '/home',            component: Home },
        { path: '/home/post',       component: Posting },
        { path: '/home/calendar',   component: Calendar },
        { path: '/home/statistics', component: Statistic },
        { path: '/home/settings',   component: Settings }
    ]
});