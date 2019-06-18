<template>
  <div class="photo-list">
    <div class="grid">
      <Definition
        class="grid__item"
        v-for="definition in definitions"
        :key="definition.id"
        :item="definition"
        @like="onLikeClick"
      />
    </div>
    <Pagination :current-page="currentPage" :last-page="lastPage" />
  </div>
</template>

<script>
import { OK } from '../util'
import Definition from '../components/Definition.vue'
import Pagination from '../components/Pagination.vue'

export default {
  components: {
    Definition,
    Pagination
  },
  props: {
    page: {
      type: Number,
      required: false,
      default: 1
    }
  },
  data() {
    return {
      definitions: [],
      currentPage: 0,
      lastPage: 0
    }
  },
  methods: {
    async fetchDefinitions () {
      const response = await axios.get(`/api/definitions/?page=${this.page}`)

      if(response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      
      this.definitions = response.data.data
      this.currentPage = response.data.current_page
      this.lastPage = response.data.last_page
    },
    onLikeClick ({id, liked}) {
      if (! this.$store.getters['auth/check']) {
        alert('ログインしてください')
        return false
      }

      if (liked) {
        this.unlike(id)
      } else {
        this.like(id)
      }
    },
    async like (id) {
      const response = await axios.put(`/api/definitions/${id}/like`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.definitions = this.definitions.map(definition => {
        if(definition.id === response.data.definition_id) {
          definition.likes_count += 1
          definition.liked_by_user = true
        }
        return definition
      })
    },
    async unlike (id) {
      const response = await axios.delete(`/api/definitions/${id}/like`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.definitions = this.definitions.map(definition => {
        if (definition.id === response.data.definition_id) {
          definition.likes_count -= 1
          definition.liked_by_user = false
        }
        return definition
      })

    }
  },
  watch: {
    $route: {
      async handler() {
        await this.fetchDefinitions()
      },
      immediate: true
    }
  }
}
</script>