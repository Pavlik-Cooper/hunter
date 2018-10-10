<template>
    <button :class="classes" @click="toggle" v-text="text"></button>
</template>

<script>
    export default {
        props: ['active'],
        data(){
            return {
                isActive: this.active
            }
        },
        computed: {
          classes(){
              return ['btn',this.isActive ? 'btn-primary' : 'btn-default']
          },
          text(){
            return this.isActive ? 'Unsubscribe' : 'Subscribe';
          }
        },
        methods: {
            toggle(){
                let requestType = this.isActive ? 'delete' : 'post';
                axios[requestType](location.pathname + '/subscriptions');
                this.isActive = !this.isActive;
            }
        }
    }
</script>

<style scoped>

</style>
