<template>
    
</template>

<script>

    export default {
        props: {
            token: String
        },
        data: function () {
            return {
                items:null,
                posts:null,
                terms:null,
                data_name:null,
            }
        },
        beforeRouteUpdate(to, from, next) {
            this.current_page = to.query.page
            next()
        },
        methods: {
            getAPIs:async function () {
                // 要検討
                // 結局すべてのresponceを待機することになりPromise.allでawaitする必要性が薄く
                // 使用頻度の高いと思われるpostを優先して先にawaitし即代入した方がユーザー利便性に優れると思われる

                let path = this.$appRootPath + this.$appApiPrefix

                let res1,res2

                try {
                    [res1,res2] = await Promise.all([
                    axios
                        .get(path + '/post' ,{params:{api_token:this.token}})
                        .catch(e => { throw 'get1 error '+e.message}),

                    axios
                        .get(path + '/term' ,{params:{api_token:this.token}})
                        .catch(e => { throw 'get2 error '+e.message}),
                    ]);
                } catch(err) {
                    console.log(err);
                }

                this.posts = res1.data
                this.terms = res2.data

                let rootPath = this.$route.path
                if(this.$appPath != rootPath){
                    if(rootPath.includes(this.$appPath + '/post')){
                        this.changeItems('post')
                    }
                    else if(rootPath.includes(this.$appPath + '/term')){
                        this.changeItems('term')
                    }
                }
            },
            changeItems:function($str){
                // MainComponentへ渡すitemsの切り替えを行う
                this.data_name = $str
                switch($str){
                    case 'post':
                        this.items=this.posts
                        break;
                    case 'term':
                        this.items=this.terms
                        break;
                    default:
                        this.items=this.posts
                        break;
                }
            }
        },
        created: function () {
            this.getAPIs()
        }


    }
</script>

<style scoped>
    .router-link-active{
        background: rgb(113, 202, 165);
        color:white;
    }

    .mainhandle__container {
        margin-top:5rem;
    }

    aside{
        position: fixed;
        left: 0;

        width: 20%;
    }

    article{
        position: relative;
        top:2rem;
        left: 20%;

        width: 80%;
    }

    aside ul {
        list-style: none;

        width: 100%;

        margin: 0;
        padding: 0;
    }

    aside ul li {
        cursor: pointer;
        user-select:none;

        display: flex;
        align-items: center;
        justify-content: center;

        width: 100%;
        min-height: 4rem;

        transition:all 0.3s;
    }

</style>
