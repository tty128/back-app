<template>
    <div id="HtmlAnchor"
        v-if='autoAnchor'
    >
        <keep-alive>
            <ul class="anchor-ul anchor-level__1">   
                <html-anchor-list
                    v-for="items in autoAnchor"
                    :key="items.id"
                    :item="items"
                    :is_button="is_button"
                ></html-anchor-list>
            </ul>
        </keep-alive>
    </div>
</template>

<script>
// import HtmlAnchorList from './HtmlAnchorList.vue';
// export default {
module.exports = {
    // components:{
    //     HtmlAnchorList
    // },
    props:{
        dom_string:{type:[String],default:''},
        query_select:{type:[String],default:"h1,h2,h3"},
        is_button:{type:[Boolean],default:true}
    },
    computed:{
        autoAnchor:function(){
            if(this.dom_string === ''){ return null }
            const doc = new DOMParser().parseFromString(this.dom_string, "text/html")
            const querys = doc.querySelectorAll(this.query_select)
            if (querys.length <= 0) { return null }

            const queryArrayToSet = this.query_select.split(',')
            const queryArray = [...new Set(queryArrayToSet)]

            const resultArr = []
            let resultRef = resultArr;

            const isCreatedArr = []
            queryArray.forEach(element => {isCreatedArr.push(false)})

            querys.forEach(query => {
                if(query.id !== null && query.id !== "" ){
                    let qTag = query.tagName.toLowerCase()
                    let nestIndex = queryArray.findIndex(elem => elem == qTag)

                    // main start
                    for(let i = 0 ; i < queryArray.length ; i++){
                        if ( i == nestIndex ) {
                            resultRef.push({
                                tag:qTag,
                                id:query.id,
                                text:query.innerHTML,
                                children:[]
                            })

                            isCreatedArr[i] = true
                            resultRef = resultArr

                        } else if ( i < nestIndex ) {
                            if(!isCreatedArr[i]){
                                resultRef.push({ 
                                    children:[] 
                                })
                                isCreatedArr[i] = true
                            }
                            resultRef = resultRef[resultRef.length - 1].children

                        } else {
                            isCreatedArr[i] = false
                        }

                    }
                    // main end

                }
            })

            return resultArr
            
        }
    },
}
</script>

<style scoped>
    #HtmlAnchor{
        background: cadetblue;
        width: 100%;
        height: auto;

        padding: 1.6rem;
        border-radius: 1rem;

        word-break: normal;
    }

    /* .anchor-li{
        margin-top: 0.2rem;
    } */

    .anchor-ul{
        list-style: none;
        user-select: none;

        margin-left: 1.4rem;
    }

    .anchor-ul a{
        cursor: pointer;
        word-break: break-word;
    }

    .anchor-level__1{
        margin: 0;
        font-size: 1.8rem ;
    }
    .anchor-level__1 > li {
        margin-top: 0.6rem;
    }
    .anchor-level__1 > li:first-child {
        margin-top: 0;
    }

    .anchor-level__1 > li > span.wrapper{
        display: inline-block;
        width: 100%;

        border-bottom: dotted 1px;
    }
    .anchor-level__1 > li > span.wrapper a{
        margin-left: 1rem;
    }

    .anchor-level__2{
        list-style: disc;
        margin-left: 3.6rem;
        font-size: 1.6rem ;
    }

    .anchor-level__2 > li {
        margin-top: 0.5rem;
    }

    .anchor-level__3{
        list-style: circle;
        margin-left: 1.8rem;
        font-size: 1.4rem ;
    }
    .anchor-level__3 > li {
        margin-top: 0.4rem;
    }

    .anchor-button{
        transition: all 0.3s;
    }
    .anchor-button svg{
        width: 1.5rem;
        height: 1.5rem;

        margin-left: 0.35rem;

        stroke: inherit;
        fill: inherit;

        vertical-align: middle;

    }

    .anchor-button > span{
        color: inherit;
    }

    .anchor-button:hover{
        color:blueviolet;
        /* stroke: blueviolet; */
        fill: blueviolet;
    }

    .anchor-button-enter-active {
    transition: all .3s ease;
    }
    .anchor-button-leave-active {
    transition: all .5s ease;
    }
    .anchor-button-enter , .anchor-button-leave-to 
    {
        transform: translateX(1rem);
        opacity: 0;
    }
</style>