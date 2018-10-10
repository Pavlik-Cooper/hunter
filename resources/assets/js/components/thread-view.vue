<script>
    import replies from './replies.vue';
    import pagination from './pagination.vue';
    import SubscribeButton from './subscribe-button.vue';
    export default {
        props: ['thread'],
        components: {replies,pagination,SubscribeButton},
        data(){
            return {
                RepliesCount: this.thread.replies_count,
                editing: false,
                body: this.thread.body,
                title: this.thread.title,
                locked: false,
                pagination: {
                    'current_page': 1
                }
            }
        },
        computed: {
            items(){
                return this.$store.getters.replies
            },
            editButton(){
               return this.editing ? 'Cancel' : 'Edit'
            },
            disabled(){
                return this.body == "" || this.title == "";
            }
        },
        methods: {
            update(){
                if (this.disabled){
                    return this.$toastr.e("Please, fill all the fields");
                }
                axios.put('/threads/' + this.thread.channel.slug + '/' + this.thread.slug,{
                    body: this.body,
                    title: this.title
                }).then(response => {
                    this.editing = false;
                    this.$toastr.s("You have successfully updated the thread");
                }).catch(e => {
                    console.log(e);
                    this.cancel();
                    this.$toastr.e("Sorry, there was an error, try again later");
                });
            },
            cancel(){
                this.editing = false;
                this.body = this.thread.body;
                this.title = this.thread.title;
            },
            fetchPosts() {
                return axios.get(`${location.pathname}/replies?page=` + this.pagination.current_page)
                    .then(response => {
                        // this.posts = response.data.data.data;
                        this.$store.dispatch('setReplies',response.data.data.data);
                        this.pagination = response.data.pagination;
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            }
        },
        mounted(){
            this.fetchPosts().then(()=>{
                let isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
                if (window.location.hash && isChrome) {
                    let hash = window.location.hash;
                    window.location.hash = "";
                    window.location.hash = hash;
                }
            });
            window.events.$on('onReply',()=>{
               let activeNewReplyComponent =  this.$children.find((el)=> el.isActive == true);
               if (activeNewReplyComponent) activeNewReplyComponent.isActive = false;
            });
            window.events.$on('onCancel',()=>{
                this.$refs.first.isActive = true;
            });
        }
    }
</script>
