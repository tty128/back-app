<template>
    <div class="modal_element">
        <!-- CloseButton -->
        <div
            class="close_button"
            @click="EventOn(false)"
        >
            <span></span>
        </div>
        <!-- CloseButton End -->

        <!-- ActionString -->
        <h2
            class="action"
            v-if="action != null"
        >
            {{ action.toUpperCase() }}
        </h2>
        <!-- ActionString -->

        <!-- ItemTitle -->
        <div
            class="wrapper"
            v-if="action !== 'create'"
        >
            <h3>{{ title }}</h3>
        </div>
        <!-- ItemTitle End -->

        <!-- Preview:preview action -->
        <div
            class="wrapper preview"
            v-if="action =='preview'"
        >
            <laravel-preview
                :content_text="content"
            />
        </div>
        <!-- Preview End -->

    </div>
</template>

<script>
    export default {
        props: {
            action:String,
            title:String,
            content:String,
        },
        methods: {
            emitAction: function () {
                this.$emit('element_modal_action')
            },
            EventOn : function(on){
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
                else{
                    const top = bs.top
                    bs.position = ''
                    bs.top = ''
                    bs.width = ''
                    if(sbar){
                        bs.paddingRight = ''
                    }
                    window.scrollTo(0, parseInt(top , '0') * -1)
                    this.emitAction()
                }
            }
        }
    }
</script>

<style scoped>
    /*
        Color
    */
    .modal_element {
        background: rgb(113, 202, 165);
        color:white;
        filter: drop-shadow(0px 0px 0.66rem rgba(47,72,88,.5));
    }
    .modal_element .close_button {
        color: rgb(113, 202, 165);
        background: white;
    }
    .modal_element .close_button > span span,
    .modal_element .close_button > span::before,
    .modal_element .close_button > span::after {
        background: rgb(113, 202, 165);
    }

    .modal_element button{
        background: white;
        color: rgb(113, 202, 165);
    }

    .modal_element .input_radio{
        background: white;
    }
    .modal_element label.input_status{
        background: white;
        color: rgb(113, 202, 165);
    }
    .modal_element input#status_private:checked +
    label{
        color: white !important;
        background: rgb(202, 113, 113) !important;
    }
    .modal_element input#status_member:checked +
    label{
        color: white !important;
        background: rgb(202, 193, 113) !important;
    }
    .modal_element input#status_public:checked +
    label{
        color: white !important;
        background: rgb(113, 202, 165) !important;
    }

    /*
        Block
    */
    .modal_element {
        width: 750px;
        height: auto;
        min-height: 100%;

        margin:0 auto;
        padding: 7rem 2rem;
        transition:all 0.3s;
    }

    .modal_element .close_button {
        position:sticky;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 5rem;
        height: 5rem;
        float:left;
        border-radius: 2.5rem;
    }
        .modal_element .close_button > span::before,
        .modal_element .close_button > span::after {
            content: "";
        }
        .modal_element .close_button > span::before {
            transform: rotate(45deg) translateY(0.7rem);
        }
        .modal_element .close_button > span::after {
            transform:rotate(-45deg) translateY(-0.7rem);
        }
        .modal_element .close_button > span span,
        .modal_element .close_button > span::before,
        .modal_element .close_button > span::after {
            display: block;
            width: 2rem;
            height: 0.2rem;
            transition: all 0.3s;
        }

    .modal_element .action{

        display:flex;
        justify-content: flex-start;
        align-items: center;

        height:5rem;

        padding-left: 2rem;

        font-family: 'Nunito';
        font-size: 4rem;
        font-weight: 900;

        opacity:0;
        transition-delay:1s;
        transition:all 0.3s;
    }

    .modal_element.visible .action{
        opacity:1 !important;
    }

    .modal_element .wrapper{
        display:flex;
        align-items:center;
        justify-content:flex-start;
        flex-direction:column;

        width:65%;
        margin: 0 auto;
    }

    .modal_element .wrapper .container{
        width: 100%;
    }

    .modal_element input#input_title,
    .modal_element textarea{
        width: 100%;

        margin-bottom:2.5rem;
        padding: 0.75rem;

        border:none;
        border-radius: 0.5rem;

        outline: none;
    }

    .modal_element textarea{
        resize: none;

        height: 15rem;
    }

    .modal_element button{
        display: flex;
        align-items: center;
        justify-content: center;

        width: 9rem;
        height: 3rem;

        margin: 0 auto;
        margin-bottom: 5rem;

        border: none;
        border-radius: 1.5rem;
    }

    .modal_element input[id^='status_']{
        display: none;
    }

    .modal_element .input_radio,
    .modal_element .input_status {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal_element .input_radio{
        padding: 0.25rem;
        border-radius: 0.5rem;
        margin-bottom: 2.5rem;
    }

    .modal_element label.input_status{
        user-select: none;
        cursor: pointer;

        width: 5rem;
        height: 2rem;
        margin: 0;
        border-radius: 0.5rem;

        transition:all 0.3s;
    }


</style>
