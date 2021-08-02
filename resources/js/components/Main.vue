<template>
    <section>

        <h1>TEST</h1>
        <div
             class="post_create"
             @click ="elementCardAction()"
        >
            Create New Post
        </div>
        <ul class="post_all">
            <li 
                v-for="(item,index) in items.data" 
                class="post_body"
            >
                <div class="wrapper">
                    <p class="post_at">
                        <span>{{ item.created_at }}</span>
                        <span v-if="item.updated_at !== null && item.updated_at !== 'undefined'"> : {{ item.updated_at }}</span>
                    </p>
                    <div v-bind:class="'post_status_' + item.post_status"></div>
                    <h2>{{ item.post_title }}</h2>
                </div>
                <ul class="post_command">
                    <li @click="editPostUrl(item.post_id)" class="edit"><span>E</span></li>
                    <li class="preview"><span>P</span></li>
                    <li @click="deletePostUrl(item.post_id)" class="delete"><span>D</span></li>
                </ul>
            </li>
        </ul>
        <vue-element-card
            @element_card_action="elementCardAction"
            created_at = 'test-te-te'
            updated_at = 'test-te-te'
            status = 'public'
            name = 'test_title'
            :id = "12"
        >
        </vue-element-card>
        <vue-pagination
            :last_page = "items.last_page"
        ></vue-pagination>

        <vue-element-modal
            :event_on="modal"
            @element_modal_action="elementModalAction"
        ></vue-element-modal>
    </section>
</template>

<script>

    module.exports = {
        props: {
            token: String
        },
        data: function () {
            return {
                items: null,
                pages: null,
                limit: 12,
                query: 0,
                modal:false,
            }
        },
        beforeRouteUpdate(to, from, next) {
            this.pages = to.query.page
            this.getAPIs()
            next()
        },
        methods: {
            elementCardAction: function(...arg){
                let [id, action] = arg
                console.log( id, action )

                switch(action){
                    case 'preview':
                        console.log( 'pre' )
                        break;
                    case 'edit':
                        console.log( 'edi' )
                        break;
                    case 'delete':
                        console.log( 'del' )
                        break;
                    default:
                        console.log( 'cre' )
                        break;
                }
                this.modal = true
            },
            elementModalAction:function (aaa){
                this.modal = aaa
            },
            getAPIs: function () {
                axios
                    .get('http://localhost/api' + this.$route.path + '/test',{params:
                        {
                            page:this.pages,
                            limit:this.limit,
                            api_token:this.token
                        }
                    })
                    .then(response => (this.items = response.data))
            },
            nextUrl: function (id) {
                this.$router.push({ path: `/post/${id}` })

            },
            editPostUrl: function (id) {
                this.$router.push({ path: `/post/edit/${id}` })

            },
            deletePostUrl: function (id) {
                this.$router.push({ path: `/post/delete/${id}` })

            },
            createPostUrl: function () {
                this.$router.push({ path: `/post/create` })

            },
        },
        created: function () {
            this.pages = this.$route.query.page
            this.getAPIs()
        }


    }
</script>

<style scoped>
    section {
        transition: all 0.5s;
    }

    .post_create {
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

        .post_create:hover {

            transform: scale(1.01);
            filter: drop-shadow(0px 0px 0.66rem rgba(47,72,88,.5));
        }

    .post_all {
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

    .post_body {
        backface-visibility: hidden;

        display: flex;
        align-items: center;
        justify-content: space-between;

        min-height: 5rem;
        margin-bottom: 1.5rem;

        width: 22rem;
        min-height: 15rem;
        height: auto;

        margin: 0.75rem;
        padding: 1rem 2rem;

        border-radius: 2rem;

        background: #E6F6D1;
        transition: all 0.2s;
    }
        .post_body:hover {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            backface-visibility: hidden;
            transform: translateX(-1rem);
            filter: drop-shadow(0px 0px 0.66rem rgba(47,72,88,.5));
        }

    .post_command {
        list-style:none;

        display:flex;
        align-items:center;
        justify-content:flex-end;
        flex-wrap:nowrap;

        width:30%;
        height:auto;
    }

        .post_command > li {
            cursor:pointer;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 3rem;
            height: 3rem;
            margin: 0 0.25rem;

            border-radius: 1.5rem;
            background: #367678;
        }
        .post_command .delete {
            background: #DE7358 !important;
        }

    .post_at {
        margin: 0 0.25rem;
    }
</style>