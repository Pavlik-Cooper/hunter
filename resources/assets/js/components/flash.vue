<template>

</template>
<script>
    export default {
        props: ['message','type'],
        mounted(){
            if (this.message && this.type){
                this.$toastr[this.type](this.message);
            }
        }
    }
</script>