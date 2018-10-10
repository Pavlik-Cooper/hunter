<template>
    <div v-if="signedIn && isActive" class="card">
        <div class="card-body">
                <div class="form-group">
                    <textarea v-model="body" rows="5" class="form-control" placeholder="Add new reply"></textarea>
                    <!--<wysiwyg name="body" v-model="body"></wysiwyg>-->
                </div>
                <button class="btn btn-default" @click="addReply">Submit</button>
                <button v-if="!isFirst" class="btn btn-primary" @click="cancel">Cancel</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'newreply',
        props: ['reply','thread','isFirst'],
        data(){
            return {
                body: '',
                parent_id: this.reply ? this.reply.id : null,
                completed: false,
                isActive: true
            }
        },
        mounted(){
            console.log(this.reply)
        },
        methods: {
            addReply(){
                axios.post(location.pathname + '/replies', {
                    body: this.body,
                    parent_id: this.parent_id,
                    user_id: window.App.user.id,
                    thread_id: this.thread.id
                }).then(({data}) => {
                    window.events.$emit('replyAdded',data.reply);
                    this.cancel();
                    this.$toastr.s('Your reply has been posted');
                }).catch((e)=>{
                    console.log(e.response.data)
                });
            },
            cancel(){
                this.body = '';
                this.isActive = false;
                window.events.$emit('onCancel')
            }
        },
        computed: {
            signedIn(){
                return window.App.signedIn;
            }
        }
    }
</script>

<style scoped>

</style>
