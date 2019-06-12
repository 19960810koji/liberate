<template>
  <div v-show="value" class="photo-form">
    <h2 class="title">Submit a definition</h2>
    <div v-show="loading" class="panel">
      <Loader>Sending your photo...</Loader>
    </div>
    <form v-show="! loading" class="form" @submit.prevent="submit">
      <div class="errors" v-if="errors">
        <ul v-if="errors.word_id">
          <li v-for="msg in errors.word_id" :key="msg">{{ msg }}</li>
        </ul>
        <ul v-if="errors.definition">
          <li v-for="msg in errors.definition" :key="msg">{{ msg }}</li>
        </ul>
      </div>
      <label>word</label>
      <select v-model="word_id" class="form__item">
        <option value="">Please select a word</option>
        <option v-for="word in words" v-bind:value="word.id">
          {{ word.word }}
        </option>
      </select>
      <label>Definition</label>
      <textarea v-model="definition" class="form__item" name="definition" rows="2" cols="75"></textarea>
      <div class="form__button">
        <button type="submit" class="button button--inverse">submit</button>
      </div>
    </form>
  </div>
</template>

<script>
import Loader from './Loader.vue'
import { CREATED, UNPROCESSABLE_ENTITY } from '../util'

export default {
  components: {
    Loader
  },
  data() {
    return {
      words: [],
      loading: false,
      word_id: null,
      definition: null,
      errors: null
    }
  },
  created() {
    const res = axios.get('api/words').then(res => { this.words = res.data })
  },
	props: {
		value: {
			type: Boolean,
			required: true,
		}
	},
  methods: {
    reset () {
      this.photo = null
      this.definition = null
    },
    async submit() {
      this.loading = true

      const formData = new FormData()
      formData.append('word_id', this.word_id)
      formData.append('definition', this.definition)
      console.log(this.word_id)
      console.log(this.definition)
      const response = await axios.post('api/definitions', formData)

      this.loading = false

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.errors = response.data.errors
        return false
      }

      this.reset()
      this.$emit('input', false)

      if (response.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      if (response.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.$store.commit('message/setContent', {
        content: '定義を投稿しました！',
        timeout: 6000
      })

      this.$router.push(`/definitions/${response.data.id}`)
    },
  },
}
</script>