<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      Liberate
    </RouterLink>
    <div class="navbar__menu">
      <div v-if="isLogin" class="navbar__item">
        <button class="button" @click="showForm = ! showForm">
          <i class="icon ion-md-add"></i>
          Submit a word
        </button>
      </div>
      <span v-if="isLogin" class="navbar__item">
        {{ username }}
      </span>
      <div v-else class="navbar__item">
        <RouterLink class="button button--link" to="/login">
          Login / Register
        </RouterLink>
      </div>
    </div>
    <DefinitionForm v-model="showForm" />
  </nav>
</template>

<script>
import { OK } from '../util'
import DefinitionForm from './DefinitionForm.vue'

export default {
  components: {
    DefinitionForm
  },
  data () {
    return {
      showForm: false,
    }
  },
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
    },
    username () {
      return this.$store.getters['auth/username']
    }
  },
}
</script>
