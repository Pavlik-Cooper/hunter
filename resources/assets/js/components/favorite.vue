<template>
        <span class="mr-2" style="cursor: pointer; font-size: 16px;"><i :class="classes" @click="toggle"></i>{{ favoritesCount}}</span>
</template>

<script>
    export default {
        props: ['reply'],
        data(){
            return {
                favoritesCount: this.reply.FavoritesCount,
                isFavorited: this.reply.isFavorited
            }
        },
        computed: {
            classes() {
             return [this.isFavorited ? 'fas fa-thumbs-up' : 'far fa-thumbs-up'];
            }
        },
        methods: {
            toggle(){
                console.log(this.reply);
                if (this.isFavorited) {
                    axios.delete('/replies/' + this.reply.id + '/favorites');
                    this.isFavorited = false;
                    this.favoritesCount--;
                }else {
                    axios.post('/replies/' + this.reply.id + '/favorites');
                    this.isFavorited = true;
                    this.favoritesCount++;
                }
            }
        }
    }
</script>

<style scoped>

</style>
