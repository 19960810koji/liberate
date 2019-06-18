<template>
  <div v-if="definition" class="photo-detail">
    <d-card class="photo-detail__pane photo-detail__image">
      <d-card-body :title="`${ definition.word.word }`">
        {{ definition.definition}}
      </d-card-body>
    </d-card>
    <div class="photo-detail__pane">
      <button 
        class="button button--like" 
        :class="{ 'button--liked': definition.liked_by_user }"
        title="Like definition"
        @click="onLikeClick"
      >
        <i class="icon ion-md-heart"></i>{{ definition.likes_count }}
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
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
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
    },
    onLikeClick () {
      if (! this.isLogin) {
        alert('ログインしてください。')
        return false
      }

      if (this.definition.liked_by_user) {
        this.unlike()
      } else {
        this.like()
      }
    },
    async like () {
      const response = await axios.put(`/api/definitions/${this.id}/like`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.$set(this.definition, 'likes_count', this.definition.likes_count + 1)
      this.$set(this.definition, 'liked_by_user', true)
    },
    async unlike () {
      const response = await axios.delete(`/api/definitions/${this.id}/like`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.$set(this.definition, 'likes_count', this.definition.likes_count - 1)
      this.$set(this.definition, 'liked_by_user', false)

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