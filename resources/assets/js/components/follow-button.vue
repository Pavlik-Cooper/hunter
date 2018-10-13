<template>
    <button @click="toggleFollow" class="btn btn align-self-end ml-2 mb-2" :class="isFr ? 'btn-primary' : 'btn-secondary'">
        {{ text }}
    </button>
</template>

<script>
export  default {
    props: ['isFriend','profileUserId'],
    data(){
        return {
            isFr: this.isFriend
        }
    },
    computed: {
      text(){
          return this.isFr ? "Unfollow" : "Follow"
      }
    },
    methods: {
        toggleFollow(){
            let method = this.isFr ? 'delete' : 'post';
            this.isFr = !this.isFr;
            axios[method](`/api/chat/${this.profileUserId}/friends`);
            // console.log(this.profileUserId)
        }
    }
}
</script>

<style scoped>

</style>
