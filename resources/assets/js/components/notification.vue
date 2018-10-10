<template>
    <li class="nav-item dropdown">
        <a class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div id="ex4">
              <span class="p1 fa-stack fa-1x" :class="{'has-badge': count }" v-bind="attrs">
                <i class="p3 fa fa-bell fa-stack-1x xfa-inverse" data-count="4b"></i>
              </span>
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-notification custom">
            <li class="head text-light bg-dark">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-12">
                        <span>Notifications ({{ count }})</span>
                        <a href="#" class="float-right text-light" @click.prevent="markAsRead">Mark all as read</a>
                    </div>
                </div>
            </li>
            <li>
                <ul class="notifications">
                    <template v-for="(item,index) in notifications">
                        <li :key="item.id" class="notification-box" :class="{'bg-gray': item.read_at !== null}">
                            <div class="row">
                                <div class="col-lg-3 col-sm-3 col-3 text-center">
                                    <img :src="item.data.reply.owner.avatar" class="w-50 rounded-circle">
                                </div>
                                <div class="col-lg-8 col-sm-8 col-8">
                                    <strong class="text-info">{{ item.data.reply.owner.name }}</strong>
                                    <div>
                                        <a :href="item.data.link"
                                           @click="markAsRead(item,index)"
                                        >{{ item.data.message | slice }}</a>
                                    </div>
                                    <small class="text-danger">{{ item.created_at | date}}</small>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </li>

            <li class="footer bg-dark text-center">
                <a href="#" class="text-light">View All</a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
    data(){
        return {
            notifications: [],
        }
    },
    computed: {
        attrs(){
            return {
                ['data-count']: this.count
            }
        },
        count(){
            return this.notifications.filter(el => el.read_at == null).length
        }
    },
    filters: {
      slice(str){
          return str = str.slice(0,30);
      },
      date(d){
          return moment(d).format("DD.M.YYYY, H")
      }
    },
    mounted(){
        axios.get('/profiles/' + window.App.user.id + '/notifications').
            then(response => {
                this.notifications = response.data.map((not)=>{
                    not.data.reply = JSON.parse(not.data.reply);
                    return not
            })
        }).catch(e => console.log(e))
    },
    methods: {
        markAsRead(item = null){
            let param = '';
            if (item.id) {
                param = item.id;
                let noty = this.notifications.find(el => el.id == item.id);
                if (noty) noty.read_at = moment();
            }
            else this.notifications.forEach(el => el.read_at = moment());
            axios.delete('/profiles/' + window.App.user.id + '/notifications/' + param);
        }
    }
    }
</script>

<style scoped>
.notify {
    font-size: 13px!important;}
#ex4 .p1.has-badge:after{
    position:absolute;
    right:-6%;
    top:0;
    content: attr(data-count);
    font-size:70%;
    padding:.1em;
    border-radius:50%;
    line-height:1em;
    color: white;
    background:rgba(255,0,0,.85);
    text-align:center;
    min-width: 1em;
}
.notification-box {
    border-bottom: 1px solid gray;
}
.dropdown-menu ul {
    /*overflow-x: scroll;*/
    list-style-type: none;
    padding: 0 !important;
}
.notifications {
    max-height: 400px;
    overflow-y: scroll;
    overflow-x: hidden;
}
.dropdown-menu-notification {
    width: 400px!important;
}
</style>
