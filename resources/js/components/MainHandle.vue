<template>
    <article>
        <keep-alive>
            <router-view
                :token="token"
                :item_obj="item_obj"
                :data_name="data_name"
            ></router-view>
        </keep-alive>
    </article>
</template>

<script>

    export default {
        props: {
            token: String,
            obj:Object,
        },
        data: function () {
            return {
                item_obj:null,
                data_name:null,
            }
        },
        watch:{
            $route(to,from){
                this.changeitemObj(to.path)
            }
        },
        beforeRouteUpdate(to, from, next) {
            this.current_page = to.query.page
            next()
        },
        methods: {
            changeitemObj:function(path){
                Object.keys(this.obj).forEach(key =>{
                    if(path.includes(key)){
                        this.data_name = key
                        this.item_obj = this.obj[key]
                    }
                })
            }
        },
        created: function () {
            this.changeitemObj(this.$route.path)
        }


    }
</script>

<style scoped>
</style>
