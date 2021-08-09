<template>
    <header id="Header">
        <p>{{ datatitle }}</p>
        <router-link tag="div" to="/">{{ logo }}</router-link>
    </header>
</template>

<script>
    module.exports = {
        props: ['title']
        ,
        data: function () {
            return {
                logo: 'head',
                datatitle:this.title
            }
        }
    }
</script>

<style scoped>
    #Header {
        z-index:100;

        position:fixed;
        
        display:flex;
        align-items:center;
        justify-content:flex-start;

        width:100%;
        height:50px;

        background:gray;
    }

    #Header > div {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 19%;
        height: 100%;

        color: white;

        font-size: 1.4rem;
        text-decoration: none;
    }

</style>