<template>
        <div class="card" style="margin: 20px;" :style="{'margin-left': offset +'px'}">
            <div class="card-header">
                <a :href="'/profile'+data.owner.name"><img :src="data.owner.avatar" width="50" class="img-thumbnail mr-3"> {{data.owner.name}}</a> said
                {{data.created_at}}
            </div>

            <div class="card-body">
                <div v-if="editing">
                    <form>
                    <div class="form-group">
                        <div class="form-group">
                            <!--<wysiwyg name="body" v-model="body" :value="body"></wysiwyg>-->
                            <textarea class="form-control" v-model="body"></textarea>
                        </div>
                        <button class="btn btn-xs btn-primary" @click="update" type="button">Update</button>
                        <button class="btn btn-xs" @click="editing = false; body = data.body" type="button">Cancel</button>
                        <button class="btn btn-danger btn-small" @click="destroy">Delete</button>
                    </div>
                    </form>
                </div>
                <div v-else v-html="body"></div>
            </div>
            <div class="card-footer">

                <span v-if="authorize('update',reply)">
                    <a href="#" v-if="!editing && !isReplying"  @click.prevent="editing = true;">Edit</a>
                </span>
                <span class="float-right" v-if="!isReplying && signedIn">
                    <favorite :reply="data"></favorite>
                    <a href="#" @click.prevent="addReply">Reply</a>
                </span>
                <div v-if="isReplying">
                    <new-reply :reply="reply" :thread="reply.thread"></new-reply>
                </div>

            </div>
        </div>
</template>
<script>
    import  Favorite from './favorite';
    import NewReply from  './newreply.vue';
    export default {
        name: 'reply',
        props: ['data','offset'],
        components: { NewReply, Favorite },
        data(){
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id,
                reply: this.data,
                isReplying: false
            }
        },
        methods: {
            addReply(){
                this.editing = false;
                window.events.$emit('onReply');
                this.isReplying = true;
            },
          update: _.debounce(function(){
                    var vm = this;
                    axios.patch('/replies/' + this.data.id,{
                        body: vm.body
                    }).then(()=>{
                        vm.$toastr.s("Your reply has been updated");
                    }).catch((e)=>{
                        vm.body = this.data.body;
                        vm.$toastr.e(e.response.data,'danger');
                    });
                    vm.editing = false;
                },5),
            destroy(){
                axios.delete('/replies/' + this.data.id);
            },
        }
    }
</script>
