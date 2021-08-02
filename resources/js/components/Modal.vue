<template>
    <div class="{ modalName }">
        <div
            class="modal_button"
            @click = "modalToggleButton()"
        >
            <div class="Modal_button_line"><span></span></div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props:{
            modalName:String
        },
        data: function () {
            return {
                logo: 'head',
            }
        },
        methods:{
            modalToggleButton:function(){
                this.$emit(this.modalName)
            }
        }
    }
</script>

<style scoped>
div[class^="modal__"]{
    position: fixed;
    top:0;
    left: 100vw;

    overflow: hidden;

    opacity: 0;

    transition: all 0.3s;
}

</style>