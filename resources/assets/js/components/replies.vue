<template>
    <div>
        <template v-for="(reply, index) in items">
            <div :id="'reply-'+reply.id" :key="reply.id">
                <reply :offset="offset" :data="reply" @deleted="remove(index)"></reply>
                <replies v-if="reply.replies.length" :items="reply.replies" :offset="Number(offset) + 25"></replies>
            </div>
        </template>

        <!--<paginator :dataSet="dataSet" @change="fetch"></paginator>-->
        <!--<p v-else>This thread has been locked. No more replies are allowed</p>-->
    </div>
</template>

<script>
    import Reply from './reply.vue';
    import Newreply from './newreply.vue';
    export default {
        name: 'replies',
        props: ['offset','items'],
        components: {
            Reply, Newreply
        },
        created(){
            window.events.$on('onReply',()=>{
                this.cancelReplying();
            });
            window.events.$on('onCancel',()=>{
               this.cancelReplying();
            });
            window.events.$on('replyAdded',(data)=>{
                this.$store.dispatch('addReply',data);
            });

        },
        methods: {
            remove(index){
                this.items.splice(index,1);
                this.$emit('removed');
            },
            cancelReplying(){
                let reply = this.$children.find((el)=> el.isReplying == true);
                if (reply) reply.isReplying = false;
            },
        url(page = false){
         //     if (!page){
         //         let query = location.search.match(/page=(\d+)/);
         //         page = query ? query[1] : 1;
         //     }
         // return `${location.pathname}/replies?page=${page}`
            return `${location.pathname}/replies`
        }
        }

    }
</script>

<style scoped>

</style>
