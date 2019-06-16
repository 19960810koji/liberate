import './bootstrap'
import Vue from 'vue'
import router from './router'
import store from './store'
import App from './App.vue'
import ShardsVue from 'shards-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'shards-ui/dist/css/shards.css'

Vue.use(ShardsVue);

const createApp = async () => {
    await store.dispatch('auth/currentUser').catch(() => { })

    new Vue({
        el: '#app',
        router,
        store,
        components: { App },
        template: '<App />'
    })
}

createApp()