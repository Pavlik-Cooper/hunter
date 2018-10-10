<template>
    <div class="direct-chat-msg" :class="right">
        <div class="direct-chat-info clearfix">
            <span class="direct-chat-name" :class="floats[0]">{{ user_name }}</span>
            <span class="direct-chat-timestamp" :class="floats[1]">{{ message.created_at }}</span>
        </div>
        <!-- /.direct-chat-info -->
        <!--https://bootdey.com/img/Content/user_1.jpg-->
        <img class="direct-chat-img" :src="avatar" alt="Message User Image"><!-- /.direct-chat-img -->
        <div class="direct-chat-text">
            <p style="overflow-wrap: break-word;">
                {{ message.message }}</p>
        </div>
        <!-- /.direct-chat-text -->
    </div>

    <!-- Message to the right -->
</template>

<script>
    export default {
        name: "message",
        props: ['message','user'],
        computed: {
            right(){
                return [this.isRight ? 'right':'']
            },
            floats(){
                return [this.isRight ? 'float-right':'float-left',this.isRight ? 'float-left' : 'float-right']
            },
            isRight(){
                return this.message.type == 0
            },
            user_name(){
                return this.message.type == 0 ? App.user.name : this.user.name
            },
            avatar(){
                return this.isRight ? App.user.avatar : this.user.avatar
            }
        }
    }
</script>

<style scoped>

</style>
