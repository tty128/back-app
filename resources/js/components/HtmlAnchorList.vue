<template>
        <li class="anchor-li">
            <span class="wrapper">
                <a
                    v-if="!isEmptyItemText"
                    :class="'tag-' + item.tag"
                    @click="scrollToAnchorPoint('#' + item.id )"
                >
                    {{ item.text }}
                </a>
                <span
                    class="anchor-button"
                    v-if="isExistsChildren && isButton"
                    @click="buttonClick()"
                >
                    <span v-if="isEmptyItemText">[{{ isButtonOn ? 'close':'open' }}]</span>
                    <svg v-if="!isButtonOn" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 14.5V16.5H13V14.5H15V12.5H13V10.5H11V12.5H9V14.5H11Z" /><path fill-rule="evenodd" clip-rule="evenodd" d="M4 1.5C2.89543 1.5 2 2.39543 2 3.5V4.5C2 4.55666 2.00236 4.61278 2.00698 4.66825C0.838141 5.07811 0 6.19118 0 7.5V19.5C0 21.1569 1.34315 22.5 3 22.5H21C22.6569 22.5 24 21.1569 24 19.5V7.5C24 5.84315 22.6569 4.5 21 4.5H11.874C11.4299 2.77477 9.86384 1.5 8 1.5H4ZM9.73244 4.5C9.38663 3.9022 8.74028 3.5 8 3.5H4V4.5H9.73244ZM3 6.5C2.44772 6.5 2 6.94772 2 7.5V19.5C2 20.0523 2.44772 20.5 3 20.5H21C21.5523 20.5 22 20.0523 22 19.5V7.5C22 6.94772 21.5523 6.5 21 6.5H3Z"/></svg>
                    <svg v-if="isButtonOn" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 14.5V12.5H15V14.5H9Z" fill="currentColor" /><path fill-rule="evenodd" clip-rule="evenodd" d="M4 1.5C2.89543 1.5 2 2.39543 2 3.5V4.5C2 4.55666 2.00236 4.61278 2.00698 4.66825C0.838141 5.07811 0 6.19118 0 7.5V19.5C0 21.1569 1.34315 22.5 3 22.5H21C22.6569 22.5 24 21.1569 24 19.5V7.5C24 5.84315 22.6569 4.5 21 4.5H11.874C11.4299 2.77477 9.86384 1.5 8 1.5H4ZM9.73244 4.5C9.38663 3.9022 8.74028 3.5 8 3.5H4V4.5H9.73244ZM3 6.5C2.44772 6.5 2 6.94772 2 7.5V19.5C2 20.0523 2.44772 20.5 3 20.5H21C21.5523 20.5 22 20.0523 22 19.5V7.5C22 6.94772 21.5523 6.5 21 6.5H3Z"/></svg>
                </span>
            </span>
            <transition name="anchor-button" mode="out-in">
                <ul 
                    :class="['anchor-ul', 'anchor-level__' + getLevel ]"
                    v-if="isExistsChildren"
                    v-show="!isButton || isButtonOn "
                >
                        <html-anchor-list
                            v-for="child in item.children"
                            :key="child.id"
                            :item="child"
                            :level="getLevel"
                            :is_button="is_button"
                            :btn_nest="btn_nest"
                            :is_default_open="!(child.text && child.text != '')"
                        />
                </ul>
            </transition>
        </li>
</template>

<script>
//import HtmlAnchorList from './HtmlAnchorList.vue'

// export default {
module.exports = {
    // name:html-anchor-list,
    // components:{
    //     HtmlAnchorList
    // },
    props:{
        item:Object,
        level:{type:[Number],default:1},
        is_button:{type:[Boolean],default:false},
        btn_nest:{type:[Number],default:1},
        is_default_open:{type:[Boolean],default:false}
    },
    data:function(){
        return {
            is_button_on:false,
        }
    },
    computed:{
        isExistsChildren:function(){
            return this.item.children.length ? true :false
        },
        isEmptyItemText:function(){
            return !this.item.text || this.item.text == ''
        },
        isButton:function(){
            return this.is_button && this.level >= this.btn_nest
        },
        isButtonOn:function(){
            return this.is_button_on !== this.is_default_open
        },
        getLevel:function(){
            return this.level + 1
        }
    },
    methods:{
        scrollToAnchorPoint(ref) {
            const elem = document.querySelector(ref)
            elem.scrollIntoView({ behavior: 'smooth' , block: 'center'})
        },
        buttonClick(){
            this.is_button_on = this.is_button_on ? false : true
        },
    },
}
</script>

<style scoped>


</style>