<template>
    <section>
        <!-- PageTop UI -->
        <div
             class="create"
             @click ="childCardAction(null,'create','editer')"
        >
            Create New {{ this.data_name.toUpperCase() }}
        </div>

        <laravel-pagination-limit
            @element_limit_action="childLimitAction"
            :limits="limits"
        ></laravel-pagination-limit>

        <laravel-pagination
            :last_page="lastPage"
            :max_view_pages="paginate_max_pages"
        ></laravel-pagination>
        <!-- PageTop UI End -->

        <!-- itemBody -->
        <transition name="main-list" mode="out-in" appear>
            <ul class='item_all'
                v-if="data_name == 'post'"
            >
                <li
                    v-for="item in limitArray"
                    :key="item.id"
                    class="item_body"
                >
                    <laravel-element-card
                        @element_card_action="childCardAction"
                        :created_at="item.created_at"
                        :updated_at="item.updated_at"
                        :status="item.status"
                        :name="item.title"
                        :id="item.id"
                    ></laravel-element-card>
                </li>
            </ul>

            <ul class='item_all'
                v-if="data_name == 'term'"
            >
                <li
                    v-for="item in limitArray"
                    :key="item.term_id"
                    class="item_body"
                >
                    <laravel-element-card
                        @element_card_action="childCardAction"
                        status="public"
                        :name="item.name"
                        :id="item.id"
                    ></laravel-element-card>
                </li>
            </ul>
        </transition>
        <!-- itemBody End-->

        <!-- PageFooter UI -->
        <laravel-pagination
            :last_page="lastPage"
            :max_view_pages="paginate_max_pages"
        ></laravel-pagination>
        <!-- PageFooter UI End -->

        <!-- Fixed Element -->
        <transition name="modal-editer" appear>
            <div
                class="modal-container"
                v-if="modal.editer"
            >
                <laravel-modal
                    class="modal-container__body"
                    @emit_siwtch="childModalAction('editer')"
                    @emit_invoke="childModalActionSimple"
                    @emit_put_object="childItemsUpdate"
                    :token="token"
                    :action="modal_action"
                    :data_id="modal_post_id"
                    :data_name="data_name"
                ></laravel-modal>
            </div>
        </transition>

        <transition name="modal-viewer" appear>
            <div
                class="modal-container"
                v-if="modal.viewer"
            >
                <laravel-modal
                    class="modal-container__body"
                    @emit_siwtch="childModalAction('viewer')"
                    :token="token"
                    action='preview'
                    :data_id="modal_post_id"
                    :data_name="data_name"
                ></laravel-modal>
            </div>
            <div
                class="modal-container"
                v-if="modal.simple"
            >
                <simple-modal
                    class="modal-container__body"
                    @element_modal_action="childModalAction('simple')"
                    action="preview"
                    :title="new_title"
                    :content="new_content"
                />
            </div>
        </transition>
        <!-- Fixed Element End -->
    </section>
</template>

<script>
    import SimpleModal from './ElementSimpleModal.vue'
    export default {
        props: {
            token: String,
            obj: Object,
        },
        components:{
            SimpleModal
        },
        data: function () {
            return {
                items: null,
                data_name: String,
                paginate_max_pages: 5,
                limits:[12,24,36],
                limit: 12,
                modal:{
                    editer:false,
                    viewer:false,
                    simple:false
                },
                modal_post_id:null,
                modal_action:null,
                new_title:"",
                new_content:"",
            }
        },
        watch:{
            $route(to,from){
                this.changeItemObj(to.path)
            }
        },
        computed:{
            currentPage:function(){
                return isNaN(Number(this.$route.query.page)) ? 1 : Number(this.$route.query.page)
            },
            lastPage:function(){
                return this.items ? Math.ceil(this.items.length / this.limit) : 0
            },
            limitArray:function(){
                const itemObj = this.items ? this.items : this.obj[this.data_name]
                return itemObj.slice((this.currentPage - 1) * this.limit , this.currentPage * this.limit )
            },
            getItems: function(){
                return this.items
            }
        },
        methods: {
            childLimitAction:function(num){
                // Component:PaginateLimitButtonから戻ってきた数値を変数に代入する
                this.limit = num
            },
            childCardAction: function(...arg){
                // Component:ElementCardから戻ってきたidおよびaction名を各変数に代入（modalで使用）する
                // その後、modalを起動
                let [id, action,key] = arg
                this.modal_post_id=id
                if(action != 'preview'){
                    this.modal_action=action
                }
                this.modal[key] = true
            },
            childModalAction:function (key){
                // Component:ElementModalから戻ってきたBoolean（基本false）
                // Modalで自身を閉じるための関数
                if(key == 'simple'){
                    this.new_title = ""
                    this.new_content = ""
                }
                this.modal[key] = false
            },
            childModalActionSimple:function(...arg){
                let [title, content] = arg
                this.new_title = title
                this.new_content = content
                this.modal['simple'] = true
            },
            childItemsUpdate:function(obj){
                this.items = Object.create(obj[this.data_name])
            },
            getAPIs:async function () {
                let path = this.$appRootPath + this.$appApiPrefix
                try {
                    const res =  await axios.get(path + '/post' ,{params:{api_token:this.token}}).catch(e => { throw 'get1 error '+e.message})
                } catch(err) {
                    console.log(err);
                }
                return res.data[this.data_name]
            },
            changeItemObj: function(path){
                this.items = null
                Object.keys(this.obj).forEach(key =>{
                    if(path.includes(key)){
                        this.data_name = key
                        this.items = this.obj[key]
                    }
                })

                if(!this.items){
                    this.data_name = Object.keys(this.obj)[0]
                    this.items = this.obj[this.data_name]
                }
            }
        },
        created:function(){
            this.changeItemObj(this.$route.path)
        }
    }
</script>

<style lang="scss" scoped>
    /*
        section
    */
    @media screen and (min-width:480px) {
        section {width: 100%;}
    }
    @media screen and (min-width:1024px) {
        section {width: 768px;}
    }
    section {
        margin: 0 auto;
        transition: all 0.5s;
    }
    section .create {
        backface-visibility: hidden;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20rem;
        height: 4rem;
        margin: 1rem auto;
        font-size:1.3rem;
        color: white;
        border-radius: 2rem;
        background: #367678;
        transition: all 0.2s;
    }
        section .create:hover {
            transform: scale(1.01);
            filter: drop-shadow(0px 0px 0.66rem rgba(47,72,88,.5));
        }
    section .item_all {
        list-style: none;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        flex-wrap: wrap;
        width: 100%;
        height: auto;
        margin: 0px auto;
        padding: 0px;
    }
    /*
        modal
    */
    .modal-editer-enter,.modal-editer-leave-to,
    .modal-viewer-enter,.modal-viewer-leave-to
    {
        transform: translateX(100vw);
    }
    .modal-editer-enter-to,.modal-editer-leave,
    .modal-viewer-enter-to,.modal-viewer-leave
    {
        transform: translateX(0);
    }
    .modal-container{
        overflow-y: auto;
        position:fixed;
        top:6rem;
        left:0;
        bottom:0;
        width: 100%;
        transition: all 0.5s;
        &__body{
            width: 60%;
            margin: 0 auto;
        }
    }
</style>
