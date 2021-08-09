<template>
    <input type="hidden" name="_token" v-bind:value="csrf">
</template>

<script>
  export default {
    props:  {
      csrf: {
        type: String,
        required: true,
      }
    }
  }
</script>