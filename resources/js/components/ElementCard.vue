<template>
    <div
        :class="['card__wrapper','card__element_status_' + status]"
        @click = "emitAction( 'edit' , 'editer')"
    >
        <div class="card__element_at">
            <p>created : {{ createdAt }}</p>
            <p v-if="updatedAt" >updated : {{ updatedAt }}</p>
        </div>

        <div class="card__container">
            <h2>{{ name }}</h2>
        </div>

        <ul class="card__element_command">
            <li
                class="preview"
                @click.stop="emitAction( 'preview' , 'viewer')"
            >
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 18H17V16H7V18Z" /><path d="M17 14H7V12H17V14Z" /><path d="M7 10H11V8H7V10Z" /><path fill-rule="evenodd" clip-rule="evenodd" d="M6 2C4.34315 2 3 3.34315 3 5V19C3 20.6569 4.34315 22 6 22H18C19.6569 22 21 20.6569 21 19V9C21 5.13401 17.866 2 14 2H6ZM6 4H13V9H19V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V5C5 4.44772 5.44772 4 6 4ZM15 4.10002C16.6113 4.4271 17.9413 5.52906 18.584 7H15V4.10002Z" /></svg>
            </li>
            <li
                class="delete"
                @click.stop="emitAction( 'delete' , 'editer' )"
            >
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" /><path d="M9 9H11V17H9V9Z" /><path d="M13 9H15V17H13V9Z" /></svg>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
    // module.exports={
        props: {
            created_at: {type:[String],default:'1111-01-01'},
            updated_at: {type:[String],default:'1111-01-01'},
            status: {type:[String],default:'private'},
            name: {type:[String],default:'TesttextTesttextTesttextTesttextTesttext'},
            id: Number,
        },
        computed:{
            createdAt:function(){
                const date = new Date(this.created_at)
                return isNaN(date) ? '' : this.toDateString(date)
            },
            updatedAt:function(){
                const date = new Date(this.updated_at)
                return isNaN(date) ? '' : this.toDateString(date)
            }
        },
        methods: {
            toDateString:function(date){
                const y = date.getFullYear()
                const m = date.getMonth() + 1
                const d = date.getDate()

                return y + ' / ' + m + ' / ' + d
            },
            emitAction: function (action,key) {
                this.$emit('element_card_action', this.id , action ,key )
            }
        }
    }
</script>

<style scoped>
    .card__element_status_public{
        background: #E6F6D1;
    }
    .card__element_status_member{
        background: #E6F6D1;
    }
    .card__element_status_private{
        background: #E6F6D1;
    }


    .card__wrapper {
        backface-visibility: hidden;

        display: flex;
        align-items: flex-start;
        justify-content: flex-start;
        flex-direction: column;

        margin-bottom: 1.5rem;

        width: 30rem;
        min-height: 12.5rem;
        height: auto;

        margin: 0.75rem;
        padding: 1rem;

        transition: all 0.2s;
    }
        .card__wrapper:hover {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            backface-visibility: hidden;
            transform: translateX(-1rem);
            filter: drop-shadow(0px 0px 0.66rem rgba(47,72,88,.5));
        }

    .card__wrapper h2{
        margin: 0;
        word-break: break-all;
    }

    .card__container {
        display: flex;
        align-items: flex-start;
        justify-content: flex-start;
        flex-direction: column;

        margin: auto 0;
        padding:1rem;
    }

    .card__element_command {
        list-style:none;

        display:flex;
        align-items:center;
        justify-content:flex-end;
        flex-wrap:nowrap;

        margin-left: auto;
        margin-bottom:0;
        padding:0;
    }

        .card__element_command > li {
            cursor:pointer;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 3rem;
            height: 3rem;
            margin: 0 0.25rem;

            border-radius: 1.5rem;
            background: #367678;
            fill:white;
        }
        .card__element_command .delete {
            background: #DE7358 !important;
        }
        .card__element_command svg{
            /* stroke: inherit; */
            width: 1.5rem;
            height: 1.5rem;
            fill: inherit;
        }

    .card__element_at {
        margin: 0;
    }
        .card__element_at p {
            font-size: 1rem;
            margin: 0;
        }
</style>
