<template>
  <div v-if="definition" class="photo-detail">
    <d-card class="photo-detail__pane photo-detail__image">
      <d-card-body :title="`${ definition.word.word }`">
        {{ definition.definition}}
      </d-card-body>
    </d-card>
    <div class="photo-detail__pane">
      <button class="button button--like" title="Like photo">
        <i class="icon ion-md-heart"></i>12
      </button>
      <h2 class="photo-detail__title">
        <i class="icon ion-md-chatboxes"></i>Comments
      </h2>
    </div>
  </div>
</template>

<script>
import { OK } from '../util'

export default {
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      definition: ''
    }
  },
  methods: {
    async fetchDefinition() {
      const response = await axios.get(`/api/definitions/${this.id}`)

      if(response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      
      this.definition = response.data
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchDefinition()
      },
      immediate: true
    }
  }
}
</script>