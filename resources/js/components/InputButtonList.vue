<template>
  <div class="input_list">
    <label v-if="name !== ''" :for="'input_list__' + forId">
      {{ name.toUpperCase() }}
      <span @click="setSw()">AddItem: {{ !sw ? 'OPEN' : 'CLOSE' }}</span>
    </label>
    <input
      type="hidden"
      :id="'input_list__' + forId"
      v-model="buttons"
      required
      readonly
    >
    <!-- <div class="input_list__add-item-button">

    </div> -->

    <div class="input_list__selected">
      <span> Select:
        <ul class="list-items">
          <li
              v-for="button in buttons"
              :key="button.name"
              @click="DeleteButton(button)"
              class="list-item"
          >
              {{ button.name }}
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.3394 9.32245C16.7434 8.94589 16.7657 8.31312 16.3891 7.90911C16.0126 7.50509 15.3798 7.48283 14.9758 7.85938L12.0497 10.5866L9.32245 7.66048C8.94589 7.25647 8.31312 7.23421 7.90911 7.61076C7.50509 7.98731 7.48283 8.62008 7.85938 9.0241L10.5866 11.9502L7.66048 14.6775C7.25647 15.054 7.23421 15.6868 7.61076 16.0908C7.98731 16.4948 8.62008 16.5171 9.0241 16.1405L11.9502 13.4133L14.6775 16.3394C15.054 16.7434 15.6868 16.7657 16.0908 16.3891C16.4948 16.0126 16.5171 15.3798 16.1405 14.9758L13.4133 12.0497L16.3394 9.32245Z" fill="currentColor" /><path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" fill="currentColor" /></svg>
          </li>
        </ul>
      </span>
    </div>
    <div
      class="input_list__add-items"
      v-if="sw"
    >
      <span> AddItem:
        <ul class="list-items">
          <li
            v-for="button in buttonList"
            :key="button.name"
            @click="UpdateButton(button)"
            class="list-item"
          >
            {{ button.name }}
          </li>
        </ul>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    name: { type: String, default: '' },
    value: Array | String,
    items: Array,
    forId: { type: String, default: 'for-id' },
    buttonList: Array,
  },
  data:function(){
    return {
      buttons: [],
      ids: Array | String,
      sw: false
    }
  },
  methods: {
    setSw: function () {
      this.sw = !this.sw
    },
    UpdateButton: function (obj) {
        if (typeof this.value === 'string') {
            this.buttons = [obj]
            this.ids = obj.name
            this.$emit('input', this.ids)
        } else {
            let found = false
            this.buttons.forEach(button => {
                if (button.id === obj.id) { found = true }
            })
            if (!found) {
                this.buttons = this.buttons.concat(obj)
                this.ids = this.ids.concat(obj.id)
                this.$emit('input', this.ids)
            }

        }
    },
    DeleteButton: function (obj) {
        if (typeof this.value === 'string') {
            this.buttons = []
            this.ids = 'uncategorized'
            this.$emit('input', this.ids)
        } else {
            for (let i = 0; i < this.buttons.length; i++) {
                if (this.buttons[i].id === obj.id) {
                    this.buttons.splice(i,1)
                    this.ids.splice(i,1)
                    this.$emit('input', this.ids)
                }
            }
        }

    }

  },
  created:function(){
    if(typeof this.value === 'string'){
        this.buttons = [{ name:this.value }]
        this.ids = this.value ? this.value : []
    } else {
        this.buttons = this.value ? this.value : []
        this.ids = this.value ? [this.value[0].id] : []
    }
  }
}
</script>

<style lang="scss" scoped>
    /*
        Color
    */
    .list-item {
        background: white !important;
        color: rgb(113, 202, 165) !important;
        svg {
            fill: rgb(113, 202, 165);
        }
    }

    /*
        Block
    */

    .input_list{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 100%;
        &__selected, &__add-items {
            display: flex;
            margin-top: 0.75rem;
            width: 100%;
            min-height: 3rem;
            padding: 0.75rem;
            padding-bottom: 0;
            border: solid 2px;
            border-radius: 0.5rem;

            > span {
                display: inline-flex;
            }
        }
        > label{
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

            > span {
                cursor: pointer;
                padding: 0 0.5rem;
                font-size: 0.75rem;
                background: white !important;
                color: rgb(113, 202, 165) !important;
                border-radius: 2rem;
            }
        }

        .list-items {
            display: inline-flex;
            list-style: none;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;

            .list-item {
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-left: 0.75rem;
                margin-bottom: 0.75rem;
                padding: 0 0.75rem;
                border-radius: 2rem;
                font-size: 1.25rem;
                svg {
                    vertical-align: middle;
                    margin-left: 0.5rem;
                    width: 1.2rem;
                    height: 1.2rem;
                }
            }
        }
    }

</style>

