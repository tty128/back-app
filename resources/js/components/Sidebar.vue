<template>
    <ul class="sidebar">
        <router-link
            :to="{name: 'post.list'}"
            tag="li"
        >
            Post
        </router-link>
        <router-link
            :to="{name: 'term.list'}"
            tag="li"
        >
            term
        </router-link>
    </ul>
</template>

<script>

</script>

<style scoped>
    .router-link-active{
        background: rgb(113, 202, 165);
        color:white;
    }

    ul.sidebar {
        list-style: none;

        width: 100%;
        height: auto;

        margin: 0;
        padding: 0;
    }

    ul.sidebar li {
        cursor: pointer;
        user-select:none;

        display: flex;
        align-items: center;
        justify-content: center;

        width: 100%;
        min-height: 4rem;

        transition:all 0.3s;
    }

</style>
