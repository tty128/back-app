<template>
    <ul
        class="radio__limits"
        v-if="limits.length > 1"
    >
        <li class="radio__limit"
            v-for="n in limits.length"
            :key="n"
        >
            <input type="radio" name="limit"
                :id="'limit-' + n"
                :value="limits[n-1]"
                v-model="input_limit"
            >
            <label :for="'limit-' + n">
                {{ limits[n-1] }}
            </label>
        </li>
    </ul>
</template>

<script>
    module.exports={
		props:{
			limits:Array
		},
		data:function(){
			return {
				input_limit:null
			}
		},
        watch:{
            input_limit:function(){
                this.$emit('element_limit_action',this.input_limit)
            }
        },
        mounted:function(){
            let element = document.getElementById("limit-1")
            element.checked = true
        }
    }
</script>

<style scoped>
    .radio__limits .radio__limit label{
        color: #367678;
        background: #E6F6D1;
    }

    .radio__limits .radio__limit input:checked +
    label{
        color: #E6F6D1 !important;
        background: #367678 !important;
    }


    .radio__limits input{
        display: none;
    }

    .radio__limits{
        list-style: none;

        display: flex;
        align-items: center;
        justify-content: flex-end;

        width:100%;

        margin: 0.5rem 0;
        padding:0;
    }



    .radio__limits li:nth-child(1) label{
        width: 2.75rem;
        justify-content: flex-end;
        padding-right: 0.75rem;
        border-radius: 1.25rem 0 0 1.25rem;
    }

    .radio__limits li:nth-last-child(1) label{
        width: 2.75rem;
        justify-content: flex-start;
        padding-left: 0.75rem;
        border-radius: 0 1.25rem 1.25rem 0;
    }

    .radio__limits .radio__limit{
        margin: 0;
        margin-left: 0.15rem ;
        padding:0;
    }

    .radio__limits .radio__limit label{
        user-select: none;
        cursor: pointer;

        display: flex;
        align-items: center;
        justify-content: center;

        width: 2.5rem;
        height: 2.5rem;

        transition:all 0.3s;
    }


</style>
