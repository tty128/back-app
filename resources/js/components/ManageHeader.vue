<template>
    <div id="Manage__header">
        <router-link
                :to="{path:$appPath}"
                tag="a"
                id="Manage__Logo"
        >
            {{ appName }}
        </router-link>

        <div class="manage__container">
            <ul class="manage__header_ul">
                <li>
                    <input type="checkbox" name="username" id="Button__UserName">
                    <label for="Button__UserName"
                        class="label_button"
                    >
                        {{ userName }}
                        <span class="caret"></span>
                    </label>

                    <ul class="manage__dropdown_menu">
                        <li>
                            <a
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            >
                                LOGOUT
                            </a>

                            <form id="logout-form" :action="route_logout" method="POST" style="display: none;">
                                <laravel-vue-csrf
                                    :csrf="CSRFtoken"
                                ></laravel-vue-csrf>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    module.exports={
        props:{
            app_name:String,
            user_name:String,
            route_logout:String,
            csrf:String,
        },
        data: function() {
            return{
            }
        },
        computed:{
            appName:function(){
                return this.app_name
            },
            userName:function(){
                return this.user_name
            },
            routeLogout:function(){
                return this.route_logout
            },
            CSRFtoken:function(){
                return this.csrf
            },
        },
    }
</script>

<style scoped>

#Manage__header{
    color:white;
    background: red;
}
#Manage__header >.manage__container{background : green;}
#Manage__Logo{background: blue;}
.manage__header_ul .manage__dropdown_menu{background: cornflowerblue;}
.manage__header_ul .label_button{background: coral;}

#Manage__header *{
    list-style: none;

    margin: 0;
    padding:0;
}

#Manage__header a:link,
#Manage__header a:visited{
    color:inherit;
    text-decoration: none;
}

#Manage__header{
    display: flex;
    align-items: center;
    justify-content: space-between;

    height: 100%;

    padding: 0 2rem;
}

#Manage__Logo{
    display: flex;
    align-items: center;
    justify-content: center;

    min-width: 8rem;
    height: 100%;

}

#Manage__header>.manage__container{
    height: 100%;
}

.manage__header_ul{
    user-select:none;
    height: 100%;
}

.manage__header_ul > li{
    height: 100%;
    width:100%;
}

.manage__header_ul input{
    display: none;
}

.manage__header_ul .manage__dropdown_menu{
    z-index: 0;

    pointer-events: none;

    position: relative;
    top:-100%;

    height: 100%;

    opacity: 0;

    transition:all 0.3s;
}

.manage__header_ul .manage__dropdown_menu li{
    height: 100%;
}

.manage__header_ul .manage__dropdown_menu a{
    display: flex;
    align-items: center;
    justify-content: center;

    height: 100%;
}

.manage__header_ul .label_button{
    z-index: 10;

    position: relative;

    display: flex;
    align-items: center;
    justify-content: center;

    width:100%;
    min-width: 7.5rem;
    height: 100%;
}

input#Button__UserName:checked ~ .manage__dropdown_menu{
    cursor: pointer;
    pointer-events: all;
    opacity: 1;
    transform: translateY(100%);
}
</style>
