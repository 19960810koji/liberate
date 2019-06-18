<template>
  <div class="photo box11">
		<d-card style="max-width: 300px">
			<d-card-header>Card header</d-card-header>
			<!-- <d-card-img src="https://place-hold.it/300x200"/> -->
			<d-card-body :title="`${ item.word.word }`">
				<p class="definition-sentence">{{ item.definition }}</p>
			</d-card-body>
			<d-card-footer>{{ item.contributor.name }}</d-card-footer>
		</d-card>

			<RouterLink
				class="photo__overlay"
				:to="`/definitions/${item.id}`"
				:title="`View the photo by ${item.contributor.name}`"
			>
				<div class="photo__controls">
					<button
						class="photo__action photo__action--like"
						:class="{ 'photo__action--liked': item.liked_by_user }"
						title="Like definition"
						@click.prevent="like"
					>
						<i class="icon ion-md-heart"></i>{{ item.likes_count }}
					</button>
				</div>
			</RouterLink>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true
    }
	},
	methods: {
		like () {
			this.$emit('like', {
				id: this.item.id,
				liked: this.item.liked_by_user
			})
		}
	},
}
</script>
