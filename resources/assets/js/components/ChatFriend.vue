<template>
    <li>
        <a href="#">
            <img class="contacts-list-img" :src="friend.avatar">

            <div class="contacts-list-info">
                <span class="contacts-list-name">
                 {{ friend.name }} <small v-if="friend.online" class="ml-2"><i class="fa fa-circle text-success"></i></small>
                    <small v-if="friend.session && friend.session.unreadCount > 0" class="text-danger ml-2">{{friend.session.unreadCount }}</small>
                  <small class="contacts-list-date float-right">2/28/2015</small>
                </span>
                <span class="contacts-list-msg">{{ friend.last_msg | last_message }}</span>
            </div>
            <!-- /.contacts-list-info -->
        </a>
    </li>
</template>

<script>
    export default {
        name: "chat-friend",
        props: ['friend','user'],
        data(){
            return {
                fr: this.friend
            }
        },
        filters: {
            last_message(val){
                return _.isEmpty(val) ? "No messages" : val.substr(0,15);
            }
        }
    }
</script>

<style scoped>

</style>
