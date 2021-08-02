<template>
    <ul id="Paginate">
        <li
            :class="['page-prev' , !isFirstPage() ? 'invisible' : '']"
            @click="pageRoutePrev()"
        >
            Prev
        </li>
        <li>
            <div
                v-for="n in last_page"
                :key="n"
                :class="['page-' + n , isCurrent( n ) ? 'paginate-current':'']"
                @click = "{isCurrent( n ) ? '':pageRoute( n )}"
            >
                {{ n }}
            </div>
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
    module.exports = {
        props: {
            last_page: Number
        },
        methods: {
            isCurrent: function (n) {
                let query = this.$route.query.page
                query = (query === null || query === 'undefined') ? 1 : query
                return n == query
            },
            isFirstPage: function () {
                return (this.last_page != 1 && this.$route.query.page != 1)
            },
            isLastPage: function () {
                return (this.last_page != 1 && this.$route.query.page != this.last_page)
            },
            pageRoute: function (n) {
                this.$router.push({ path: this.$route.path + '?page=' + n })
            },
            pageRouteNext: function () {
                let query = Number(this.$route.query.page) + 1
                let pages = query > this.last_page ? this.last_page : query
                this.$router.push({ path: this.$route.path + '?page=' + pages })
            },
            pageRoutePrev: function () {
                let query = Number(this.$route.query.page) - 1
                let pages = query < 1 ? 1 : query
                this.$router.push({ path: this.$route.path + '?page=' + pages })
            }
        }
    }
</script>

<style scoped>
    #Paginate {
        list-style:none;

        display:flex;
        align-items:center;
        justify-content:center;

        width: auto;

        margin:0 auto;
        padding:0;
    }
        #Paginate .invisible {
            pointer-events: none !important;
            opacity: 0 !important;
        }

        #Paginate li{
            display: flex;
            align-items: center;
            justify-content: center;
            width: auto;
        }

        #Paginate [class^="page-"] {
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
        }

        #Paginate .page-next , #Paginate .page-prev {
            padding: 0 1rem;
        }

    .paginate-current {
        cursor: default !important;
        color:white;
        background: #367678 !important;
    }
</style>