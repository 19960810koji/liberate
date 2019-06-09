import Vue from 'vue'
import Vuex from 'vuex'
import message from './message'

import auth from './auth'
import error from './error'

Vue.use(Vuex)

const store = new Vuex.Store({
	modules: {
		auth,
		error,
		message
	}
})

export default store