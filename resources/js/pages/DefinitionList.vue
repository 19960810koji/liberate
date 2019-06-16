<template>
  <div class="photo-list">
    <div class="grid">
      <Definition
        class="grid__item"
        v-for="definition in definitions"
        :key="definition.id"
        :item="definition"
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
      console.log(`/api/definitions/?page=${this.page}`)
      const response = await axios.get(`/api/definitions/?page=${this.page}`)

      if(response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      
      this.definitions = response.data.data
      this.currentPage = response.data.current_page
      this.lastPage = response.data.last_page
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