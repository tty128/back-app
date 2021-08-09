<template>
    <ul
        class="vue_paginate"
        v-if="lastPage > 1"
    >
        <li
            :class="['page-prev' , !isFirstPage() ? 'invisible' : '']"
            @click="pageRoutePrev()"
        >
            Prev
        </li>
        <li
            :class="['page-prev' , startPage <= 0 ? 'invisible' : '']"
            @click="pageRoute(1)"
        >
            First
        </li>
        <li>
            <div
                v-for="n in  maxViewPages"
                :key="n"
                :class="['page-' + ( n + startPage ) , isCurrent( n + startPage ) ? 'paginate-current':'']"
                @click = "[isCurrent( n + startPage) ? '':pageRoute( n + startPage )]"
            >
                {{ n + startPage }}
            </div>
        </li>
        <li
            :class="['page-next' , startPage + maxViewPages >= lastPage  ? 'invisible' : '']"
            @click="pageRoute(lastPage)"
        >
            Last
        </li>
        <li
            :class="['page-next' , !isLastPage() ? 'invisible' : '']"
            @click="pageRouteNext()"
        >
            Next
        </li>
    </ul>
</template>

<script>
    export default {
        props: {
            last_page: Number,
            max_view_pages:Number,
        },
        computed:{
            lastPage:function(){
                return this.$isSetable(this.last_page) ? this.last_page : 1
            },
            maxViewPages:function(){
                return this.max_view_pages > this.last_page ? this.last_page : this.max_view_pages
            },
            startPage:function(){
                const mvp = this.max_view_pages
                const half_view_pages = Math.ceil(mvp/2)
                const last_page = this.last_page

                const num = (typeof(this.$route.query.page) == 'object' || typeof(this.$route.query.page) === "undefined") ? 1 : Number(this.$route.query.page)

                let start = 0
                if( num <= half_view_pages || mvp >= last_page){ start = 0 }
                else if( num + half_view_pages > last_page ){ start = last_page - mvp}
                else{ start = num - half_view_pages}

                return start
            },
        },
        methods: {
            currentPage:function(){
                // query params['page']が Number ならそのまま取得し、それ以外なら1を返す
                return (typeof(this.$route.query.page) == 'object' || typeof(this.$route.query.page) === "undefined") ? 1 : Number(this.$route.query.page)
            },
            isCurrent: function (n) {
                let current_page = this.currentPage()
                return n == (typeof(current_page) == 'number' ? current_page : 1)
            },
            isFirstPage: function () {
                return (this.last_page != 1 && this.currentPage() != 1)
            },
            isLastPage: function () {
                const page_num = this.last_page
                return (page_num != 1 && this.currentPage() != page_num)
            },
            pageRoute: function (n) {
                this.$router.push({ path: this.$route.path + '?page=' + n })
            },
            pageRouteNext: function () {
                let query = this.currentPage() + 1
                let pages = query > this.last_page ? this.last_page : query
                this.pageRoute(pages)
            },
            pageRoutePrev: function () {
                let query = this.currentPage() - 1
                let pages = query < 1 ? 1 : query
                this.pageRoute(pages)
            }
        },
        created : function() {
            this.pageRoute(this.currentPage())
        }
    }
</script>

<style scoped>
    .vue_paginate {
        list-style:none;

        display:flex;
        align-items:center;
        justify-content:center;

        width: auto;

        margin:0 auto;
        padding:0;
    }

        .vue_paginate .invisible {
            pointer-events: none !important;
            opacity: 0 !important;
        }

        .vue_paginate li{
            display: flex;
            align-items: center;
            justify-content: center;
            width: auto;
        }

        .vue_paginate [class^="page-"] {
            user-select:none;
            cursor:pointer;

            display: flex;
            align-items: center;
            justify-content: center;

            width: auto;
            min-width: 2.5rem;
            height: 2.5rem;
            border-radius:1.25rem;

            margin:0 0.2rem;

            background: #E6F6D1;

            transition: all 0.3s;
        }

        .vue_paginate [class^="page-"]:hover{
            background: red;
        }

        .vue_paginate .page-next , .vue_paginate .page-prev {
            padding: 0 1rem;
        }

    .paginate-current {
        cursor: default !important;
        color:white;
        background: #367678 !important;
    }
</style>
