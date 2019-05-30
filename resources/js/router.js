import Vue from 'vue'
import VueRouter from 'vue-router'

import WordList from './pages/WordList.vue'
import Login from './pages/Login.vue'
import SystemError from './pages/errors/SystemError.vue'
import NotFound from './pages/errors/NotFound.vue'

import store from './store'

Vue.use(VueRouter)

const routes = [
	{
		path: '/',
		component: WordList
	},
	{
		path: '/login',
		component: Login,
		beforeEnter(to, from, next) {
			if (store.getters['auth/check']) {
				next('/')
			} else {
				next()
			}
		}
	},
	{
		path: '/SystemError',
		component: SystemError
	},
	{
		path: '*',
		component: NotFound
	}
]

const router = new VueRouter({
	mode: 'history',
	routes
})

export default router