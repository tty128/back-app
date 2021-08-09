<template>
    <div class="modal--default">

        <!-- Loading -->
        <transition name="modal-default-loading">
            <div class="modal--default__loading"
                v-if="isNowLoading"
            >
                <div class="loading-object"></div>
            </div>
        </transition>
        <!-- Loading End -->

        <!-- CloseButton -->
        <div
            class="modal--default__close-button"
            @click="emitSwitch"
        >
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.9481 14.8285L10.5339 16.2427L6.29122 12L10.5339 7.7574L11.9481 9.17161L10.1196 11H17.6568V13H10.1196L11.9481 14.8285Z" /><path fill-rule="evenodd" clip-rule="evenodd" d="M4.22183 19.7782C-0.0739419 15.4824 -0.0739419 8.51759 4.22183 4.22183C8.51759 -0.0739419 15.4824 -0.0739419 19.7782 4.22183C24.0739 8.51759 24.0739 15.4824 19.7782 19.7782C15.4824 24.0739 8.51759 24.0739 4.22183 19.7782ZM5.63604 18.364C2.12132 14.8492 2.12132 9.15076 5.63604 5.63604C9.15076 2.12132 14.8492 2.12132 18.364 5.63604C21.8787 9.15076 21.8787 14.8492 18.364 18.364C14.8492 21.8787 9.15076 21.8787 5.63604 18.364Z" /></svg>
        </div>
        <!-- CloseButton End -->

        <!-- Button -->
        <button
            class="modal--default__button-circle--preview"
            @click="emitInvoke"
            v-if="action != 'preview' && !isEmpty(new_items.body)"
        >
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 18H17V16H7V18Z" /><path d="M17 14H7V12H17V14Z" /><path d="M7 10H11V8H7V10Z" /><path fill-rule="evenodd" clip-rule="evenodd" d="M6 2C4.34315 2 3 3.34315 3 5V19C3 20.6569 4.34315 22 6 22H18C19.6569 22 21 20.6569 21 19V9C21 5.13401 17.866 2 14 2H6ZM6 4H13V9H19V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V5C5 4.44772 5.44772 4 6 4ZM15 4.10002C16.6113 4.4271 17.9413 5.52906 18.584 7H15V4.10002Z" /></svg>
        </button>

        <button
            class="modal--default__button-circle--update"
            @click="itemUpdate"
            v-if="action == 'edit'"
        >
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.56079 10.6418L6.35394 3.94971L8.25402 5.84979C11.7312 3.6588 16.3814 4.07764 19.41 7.1063L17.9958 8.52052C15.7536 6.27827 12.3686 5.87519 9.71551 7.31128L11.2529 8.84869L4.56079 10.6418Z"  /><path d="M19.4392 13.3581L17.646 20.0502L15.7459 18.1501C12.2688 20.3411 7.61857 19.9223 4.58991 16.8936L6.00413 15.4794C8.24638 17.7217 11.6313 18.1247 14.2844 16.6887L12.747 15.1512L19.4392 13.3581Z" /></svg>
        </button>
        <!-- Button End -->


        <!-- ItemNewParam Input:create and edit action-->
        <div
            :class="['modal--default__input-body' , action ]"
            v-if="action == 'create' || action =='edit'"
        >

            <!-- ActionString -->
            <h2 class="action">
                {{ action.toUpperCase() }}
            </h2>
            <!-- ActionString -->

            <!-- ItemTitle -->
            <div
                v-if="action !== 'create'"
            >
                <h3>{{ getModalTitle }}</h3>
            </div>
            <!-- ItemTitle End -->

            <!-- APIs Msg -->
            <transition name="modal-default-api-message" mode="out-in">
                <p
                    class="error-message"
                    v-if="error_message.api"
                    key="error"
                >
                    {{ error_message.api }}
                </p>
                <p
                    class="success-message"
                    v-else-if="api_success"
                    key="success"
                >
                    {{ api_success }}
                </p>
            </transition>
            <!-- APIs Msg End -->

            <div
                class="input-item--text"
                v-if="isUseTitle"
            >
                <label for="Input-title">TITLE</label>
                <input id="Input-title" v-model="new_items.title" required>
                <p
                    class="error-message"
                    v-if="error_message.title"
                >
                    {{ error_message.title }}
                </p>
            </div>

            <div
                class="input-item--text"
                v-if="isUseBody"
            >
                <label for="Input-content">CONTENT</label>
                <textarea id="Input-content" v-model="new_items.body" required></textarea>
                <p
                    class="error-message"
                    v-if="error_message.body"
                >
                    {{ error_message.body }}
                </p>
            </div>

            <div
                class="input-item--radio"
                v-if="isUseStatus"
            >
                <label>STATUS</label>
                <div id="Input-status">
                    <input type="radio" id="status_private" value="private" v-model="new_items.status" required>
                    <label for="status_private">Private</label>
                    <input type="radio" id="status_member" value="member" v-model="new_items.status">
                    <label for="status_member">Member</label>
                    <input type="radio" id="status_public" value="public" v-model="new_items.status">
                    <label for="status_public">Public</label>
                </div>
                <p
                    class="error-message"
                    v-if="error_message.status"
                >
                    {{ error_message.status }}
                </p>
            </div>
            <div
                class="input-item--text"
                v-if="isUseEyecatch"
            >
                <label for="Input-eyecatch">EYECATCH IMAGE</label>
                <input id="Input-eyecatch" v-model="new_items.eyecatch">
                <!-- <p
                    class="error-message"
                    v-if="error_message.eyecatch"
                >
                    {{ error_message.eyecatch }}
                </p> -->
            </div>
            <div
                class="input-item--list"
                v-if="isUseCategory && data_name === 'post'"
            >
                <laravel-input-button
                    class="container"
                    v-model="new_items.category"
                    name="category"
                    :button-list="taxonomy_list['category']"
                />
            </div>

            <div
                class="input-item--list"
                v-if="isUseCategory && data_name === 'post'"
            >
                <laravel-input-button
                    v-for="key in Object.keys(getTaxonomyList)"
                    :key="key"
                    class="container"
                    v-model="taxonomy[key]"
                    :name="key"
                    :button-list="getTaxonomyList[key]"
                />
            </div>

            <div
                class="input-item--list"
                v-if="isUseCategory && data_name === 'term'"
            >
                <laravel-input-button
                    class="container"
                    v-model="new_items.category"
                    name="taxonomy"
                    :button-list="taxonomy_list_all"
                />
            </div>
        </div>
        <!-- ItemNewParam Input End -->

        <!-- Preview:preview action -->
        <div
            class="wrapper preview"
            v-if="action =='preview'"
        >
            <laravel-preview
                :content_text="new_items.body"
            />
        </div>
        <!-- Preview End -->

        <!-- Delete:delete action -->
        <div
            class="wrapper delete"
            v-if="action == 'delete'"
        >
            <p>この記事を消去します。消した記事はゴミ箱より復帰することが出来ます。</p>
        </div>
        <!-- Delete End -->

        <button
            class="modal--default__button--submit"
            @click="sendAPIs()"
            v-if="action != 'preview'"
        >
            submit
        </button>
    </div>
</template>

<script>
    //module.exports={
    export default {
        props: {
            token:String,
            action:String,
            data_id:Number,
            data_name:String,
        },
        data:function(){
            return {
                api_success:null,
                is_now_loading:true,
                is_now_sending:false,
                modal_title:null,
                old_items:{},
                new_items:{
                    title:null,
                    body:null,
                    status:null,
                    category:null,
                    eyecatch:null
                },
                taxonomy:null,
                taxonomy_list:[],
                taxonomy_list_all:[],
                error_message:{},
            }
        },
        computed:{
            getModalTitle:function(){
                return this.modal_title
            },
            isUseTitle:function(){
                return this.paramExists(this.new_items.title)
            },
            isUseBody:function(){
                return this.paramExists(this.new_items.body)
            },
            isUseStatus:function(){
                return this.paramExists(this.new_items.status)
            },
            isUseCategory:function(){
                return this.paramExists(this.new_items.category)
            },
            isUseEyecatch:function(){
                return this.paramExists(this.new_items.eyecatch)
            },
            isUseTaxonomy:function(){
                return this.taxonomy
            },
            getTaxonomyList: function(){
                const newObj = Object.assign({},this.taxonomy_list)
                delete newObj.category
                return newObj
            },
            isNowLoading:function(){
                return this.action === 'edit' ? this.is_now_loading : false
            },
            isNowSending:function(){
                return this.action !== 'preview' ? this.is_now_sending : false
            }
        },
        methods: {
            paramExists:function(param){
                return param || param === ''
            },
            isEmpty:function(param){
                return !param || param === ''
            },
            emitSwitch: function () {
                this.$emit('emit_siwtch')
            },
            emitInvoke: function () {
                this.$emit('emit_invoke',this.new_items)
            },
            emitPutObject: async function () {
                try{
                    const path = this.$appRootPath + this.$appApiPrefix + '/' + this.data_name
                    const obj = await axios.get(path,{params:{api_token:this.token}})
                    this.$emit('emit_put_object', obj.data )
                }catch(e){
                    console.error('getApiError' + ' : ' + e.message)
                }
            },
            itemUpdate:function () {
                this.is_now_loading = true
                this.getAPIs()
            },
            getAPIsPath:function(){
                const dataId = this.action !== 'create' && this.data_id ? '/' + this.data_id : '';
                const path = this.$appRootPath + this.$appApiPrefix + '/' + this.data_name + dataId
                return path
            },
            getAPIs:async function(){
                let eMsgObj = {}
                try{
                    const resTermTaxonomy = await axios.get(this.$appRootPath + '/api/term-taxonomy')
                    this.taxonomy_list = resTermTaxonomy.data

                    const resTaxonomy = await axios.get(this.$appRootPath + this.$appApiPrefix + '/taxonomy',{params:{api_token:this.token}})
                    this.taxonomy_list_all = resTaxonomy.data

                    if(this.action !== 'create' && this.data_id && this.token){
                        const response = await axios.get(this.getAPIsPath() ,{params:{api_token:this.token}})
                        this.old_items = response.data
                        this.contentItems().set()
                    }
                }
                catch(e){
                    e.name = "getApiError"
                    console.error(e.name + ' : ' + e.message)
                    eMsgObj.api = "Error : データの取得に失敗しました"
                }
                finally{
                    this.error_message = eMsgObj
                    this.is_now_loading = false
                }
            },
            sendAPIs:async function(){
                const path = this.getAPIsPath()
                let eMsgObj = {}
                try{
                    const eMsgObjOrNull = this.contentItems().validator()
                    if(eMsgObjOrNull){
                        eMsgObj = eMsgObjOrNull
                        const inputE = new Error("data is required")
                        inputE.name = 'InputError'
                        throw inputE
                    }
                    const params = this.contentItems().getObj()
                    try{
                        switch(this.action){
                            case 'edit':
                                await axios.put(path+'?api_token='+this.token,params)
                                break;
                            case 'delete':
                                await axios.delete(path+'?api_token='+this.token)
                                break;
                            case 'create':
                                await axios.post(path+'?api_token='+this.token,params)
                                break;
                            default:
                                const actionE = new Error("action is invalid value")
                                actionE.name = "ActionError"
                                throw actionE
                        }

                        if (this.data_name === 'post'){
                            let taxonomyStr = ''
                            const taxonomyKeys = Object.keys(this.getTaxonomyList)
                            const taxo = Object.create(this.taxonomy)
                            if(taxonomyKeys.length > 0){
                                taxonomyKeys.forEach((key) =>{
                                    if(Array.isArray(taxo[key])){
                                        taxo[key].forEach((term)  => {
                                            let termId = typeof term === 'object' ? term.id : term
                                            taxonomyStr = taxonomyStr === '' ? termId : taxonomyStr + ',' + termId
                                        })
                                    }
                                })
                            }
                            let post_id = this.data_id ? this.data_id : -1
                            await axios.post(this.$appRootPath + this.$appApiPrefix + '/post-term?api_token='+this.token,{post_id:post_id,term_id:taxonomyStr})
                        }

                        this.emitPutObject()
                        this.api_success = 'SUCCESS!'
                        const timer = msec => new Promise(resolve => setTimeout(resolve, msec))
                        timer(3500).then(res => this.api_success = null)
                    }catch(e){
                        eMsgObj.api = "Error : データの送信に失敗しました"
                        e.name = 'SendApiError'
                        throw e
                    }
                }catch(e){
                    console.error(e.name + ' : ' + e.message)
                }finally{
                    this.error_message = eMsgObj
                }
            },
            contentItems:function(){
                let eMsgObj = {}
                const statusArr = [
                    'private',
                    'public',
                    'member',
                ]
                let isStatusError = true
                statusArr.forEach(elem => {
                    if( this.new_items.status === elem ){
                        isStatusError = false
                    }
                })
                switch(this.data_name){
                    case 'post':
                        return {
                            getObj:() => {
                                return {
                                    title:this.new_items.title,
                                    body:this.new_items.body,
                                    status:this.new_items.status,
                                    category:this.new_items.category,
                                    eyecatch:this.new_items.eyecatch
                                }
                            },
                            set:() => {
                                this.taxonomy = Array.isArray(this.old_items.taxonomy) ? {} : Object.create(this.old_items.taxonomy)
                                this.new_items.title = this.modal_title = this.old_items.title
                                this.new_items.body = this.old_items.body
                                this.new_items.status = this.old_items.status
                                this.new_items.category = this.old_items.category
                                this.new_items.eyecatch = this.old_items.eyecatch ? this.old_items.eyecatch : ''
                            },
                            initialize:() => {
                                this.new_items.title = ''
                                this.new_items.body = ''
                                this.new_items.status = 'private'
                                this.new_items.eyecatch = ''
                                if(this.action === 'create'){
                                    this.new_items.category = 'uncategorized'
                                    this.taxonomy = {}
                                }
                            },
                            validator:() => {
                                if(this.isEmpty(this.new_items.title)){
                                    eMsgObj.title = 'ERROR：TITLEは必須項目です'
                                }
                                if(this.isEmpty(this.new_items.body)){
                                    eMsgObj.body = 'ERROR：CONTENTは必須項目です'
                                }
                                if(isStatusError){eMsgObj.status = 'ERROR：STATUSの値が不正です'}
                                return Object.keys(eMsgObj).length ? eMsgObj : null
                            },
                        }
                    case 'term':
                        return {
                            getObj:() => {
                                let id
                                this.taxonomy_list_all.forEach(obj => {
                                    if(obj.name == this.new_items.category){
                                        id = obj.id
                                    }
                                })
                                return {
                                    name:this.new_items.title,
                                    taxonomy_id:id
                                }
                            },
                            set:() => {
                                const taxonomyObj = this.taxonomy_list_all.find(obj => obj.id == this.old_items.taxonomy_id)

                                this.new_items.title = this.modal_title = this.old_items.name
                                this.new_items.category = taxonomyObj.name
                            },
                            initialize:() => {
                                this.new_items.title = ''
                                if(this.action === 'create'){
                                    this.new_items.category = 'category'
                                }
                            },
                            validator:() => {
                                if(this.isEmpty(this.new_items.title)){
                                    eMsgObj.title = 'ERROR：TITLEは必須項目です'
                                }
                                return Object.keys(eMsgObj).length ? eMsgObj : null
                            },
                        }
                }
            },
            fixedListPage : function(on){
                const sbar = window.scrollbars.visible
                const bs = document.body.style
                if(on){
                    const ws = -1 * window.scrollY
                    bs.position = 'fixed'
                    bs.top = ws +'px'
                    bs.width = '100%'
                    if(sbar){
                        bs.paddingRight = '15px'
                    }
                }
                else {
                    const top = bs.top
                    bs.position = ''
                    bs.top = ''
                    bs.width = ''
                    if(sbar){
                        bs.paddingRight = ''
                    }
                    window.scrollTo(0, parseInt(top , '0') * -1)
                }
            }
        },
        created:function(){
            this.fixedListPage(true)
            this.contentItems().initialize()
            this.getAPIs()
        },
        mounted:function(){
            if(this.new_items.status && (this.action !== 'preview' && this.action !== 'delete' )){
                const element = document.getElementById('status_' + this.new_items.status)
                element.checked = true
            }
        },
        destroyed:function(){
            this.fixedListPage(false)
        }
    }
</script>

<style scoped>
    /*
        Color
    */
    .modal--default {
        background: rgb(113, 202, 165);
        color:white;
        filter: drop-shadow(0px 0px 0.66rem rgba(47,72,88,.5));
    }
    .modal--default__loading{
        background: inherit;
    }
    .modal--default__close-button {
        color: rgb(113, 202, 165);
        fill: white;
    }
    .modal--default__close-button > span span,
    .modal--default__close-button > span::before,
    .modal--default__close-button > span::after {
        background: rgb(113, 202, 165);
    }
    .modal--default__button--submit{
        background: white;
        color: rgb(113, 202, 165);
    }
    [class^="modal--default__button-circle"]{
        background: white;
        fill: rgb(113, 202, 165);
    }
    .modal--default #Input-status{
        background: white;
    }
    .modal--default #Input-status label{
        background: white;
        color: rgb(113, 202, 165);
    }
    .modal--default input#status_private:checked +
    label{
        color: white !important;
        background: rgb(202, 113, 113) !important;
    }
    .modal--default input#status_member:checked +
    label{
        color: white !important;
        background: rgb(202, 193, 113) !important;
    }
    .modal--default input#status_public:checked +
    label{
        color: white !important;
        background: rgb(113, 202, 165) !important;
    }
    p.error-message{
        color: red;
        font-size:1.6rem;
        margin-top: 0.5rem;
    }
    p.success-message{
        color: white;
        font-size:1.6rem;
        font-weight: bold;
        margin-top: 0.5rem;
        transition: all 0.5s ease-in-out;
    }
    .modal-default-api-message-enter-to , .modal-default-api-message-leave {
        opacity: 1;
    }
    .modal-default-api-message-enter , .modal-default-api-message-leave-to {
        opacity: 0;
    }
    /*
        Block
    */
    .modal--default {
        position: relative;
        height: auto;
        min-height: 100%;
        padding: 3rem 3rem;
        transition:all 0.3s;
    }
    .modal--default__loading{
        z-index: 10;
        position: absolute;
        top:0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        transition: all 0.3s ease-in-out;
    }
    .modal-default-loading-enter-to , .modal-default-loading-leave {
        opacity: 1;
    }
    .modal-default-loading-enter , .modal-default-loading-leave-to {
        opacity: 0;
    }
    .loading-object {
        width: 4rem;
        height: 4rem;
        margin: 0;
        background-color: #fff;
        border-radius: 100%;
        animation: loading-object-scaleout 1.0s infinite ease-in-out;
    }
    @keyframes loading-object-scaleout {
        0% {
            transform: scale(0);
        } 100% {
            transform: scale(1.0);
            opacity: 0;
        }
    }
    .modal--default .modal--default__close-button {
        z-index: 20;
        position:absolute;
        top:3rem;
        left: 3rem;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 5rem;
        height: 5rem;
        float:left;
        border-radius: 2.5rem;
    }
        .modal--default .modal--default__close-button svg{
            fill: inherit;
            width: 100%;
            height: 100%;
        }
    .modal--default .action{
        display:flex;
        justify-content: flex-start;
        align-items: center;
        height:5rem;
        margin-bottom: 1rem ;
        color:inherit;
        font-family: 'Nunito';
        font-size: 4rem;
        font-weight: 900;
        transition-delay:1s;
        transition:all 0.3s;
    }
    .modal--default__input-body {
        display:flex;
        align-items:center;
        justify-content:flex-start;
        flex-direction:column;
        width:70%;
        margin: 0 auto;
    }
    .modal--default__input-body [class^="input-item"]{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        margin: 1rem 0;
        width: 100%;
    }
    .modal--default input#Input-title,
    .modal--default input#Input-eyecatch,
    .modal--default textarea{
        width: 100%;
        padding: 0.75rem;
        border:none;
        border-radius: 0.5rem;
        outline: none;
    }
    .modal--default textarea{
        resize: none;
        height: 15rem;
    }
    .modal--default__button--submit{
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        width: 9rem;
        height: 3rem;
        margin: 1rem auto 5rem;
        border-radius: 1.5rem;
    }
    [class^="modal--default__button-circle"]{
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        position: absolute;
        width: 4.7rem;
        height: 4.7rem;
        border-radius: 2.5rem;
    }
    .modal--default__button-circle--preview{
        top:10rem;
        left: 3.15rem;
    }
    .modal--default__button-circle--update{
        top:3.15rem;
        right:3.15rem;
    }
    [class^="modal--default__button-circle"] svg{
        fill:inherit;
        stroke: inherit;
        width: 50%;
        height: 50%;
    }
    .modal--default input[id^='status_']{
        display: none;
    }
    .modal--default #Input-status
    {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.25rem;
        border-radius: 0.5rem;
    }
    .modal--default #Input-status label{
        user-select: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 5rem;
        height: 2rem;
        margin: 0;
        margin-left: 0.25rem;
        padding:0 0.25rem;
        border-radius: 0.5rem;
        transition:all 0.3s;
    }
        .modal--default #Input-status :first-child + label{
            margin-left:0 !important;
        }
</style>
