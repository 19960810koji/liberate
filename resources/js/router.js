import Vue from 'vue'
import VueRouter from 'vue-router'

import DefinitionList from './pages/DefinitionList.vue'
import Login from './pages/Login.vue'
import SystemError from './pages/errors/SystemError.vue'
import NotFound from './pages/errors/NotFound.vue'

import store from './store'
import DefinitionDetail from './pages/DefinitionDetail.vue'

Vue.use(VueRouter)

const routes = [
	{
		path: '/',
		component: DefinitionList,
		props: route => {
			const page = route.query.page
			return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1 }
		}
	},
	{
	  path: '/definitions/:id',
	  component: DefinitionDetail,
	  props: true
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
	scrollBehavior() {
		return { x: 0, y: 0 }
	},
	routes
})

export default router