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
      <ul v-if="definition.comments.length > 0" class="photo-detail__comments">
        <li
          v-for="comment in definition.comments"
          :key="comment.content"
          class="photo-detail__commentItem"
        >
          <p class="photo-detail__commentBody">
            {{ comment.content }}
          </p>
          <p class="photo-detail__commentInfo">
            {{ comment.author.name }}
          </p>
        </li>
      </ul>
      <p v-else>No comments yet.</p>
      <form v-if="isLogin" @submit.prevent="addComment" class="form">
        <div v-if="commentErrors" class="errors">
        <ul v-if="commentErrors.content">
          <li v-for="msg in commentErrors.content" :key="msg">{{ msg }}</li>
        </ul>
        </div>
        <textarea class="form__item" v-model="commentContent"></textarea>
        <div class="form__button">
          <button type="submit" class="button button--inverse">submit comment</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

export default {
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      definition: '',
      commentContent: '',
      commentErrors: null
    }
  },
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
    }
  },
  methods: {
    // 定義詳細を取得
    async fetchDefinition() {
      const response = await axios.get(`/api/definitions/${this.id}`)

      if(response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      
      this.definition = response.data
    },
    // コメント投稿
    async addComment () {
      const response = await axios.post(`/api/definitions/${this.id}/comment`, {
        content: this.commentContent
      }) 

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.commentErrors = response.data.commentErrors
        return false
      }

      this.commentContent = ''
      this.commentErrors = null
      
      if (response.status !== CREATED) {
        this.$store.commit('error/setCode'. response.status)
        return false
      }

      this.$set(this.definition, 'comments', [
        response.data,
        ...this.definition.comments
      ])
    },
    // いいね済みか判定
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
    // いいね追加
    async like () {
      const response = await axios.put(`/api/definitions/${this.id}/like`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.$set(this.definition, 'likes_count', this.definition.likes_count + 1)
      this.$set(this.definition, 'liked_by_user', true)
    },
    // いいね削除
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