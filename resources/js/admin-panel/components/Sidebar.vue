<template>
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <div class="user">
                <div class="avatar">
                    <img class="img-fluid rounded-circle"
                         :src="user.avatar ? user.avatar : '/images/img-not-found.png'">
                </div>
                <div class="nickname">
                    <p>{{ user.name }}</p>
                </div>
                <div class="buttons">
                    <a :href="mainPage"><i class="fas fa-home"></i></a>
                    <a :href="userInfo"><i class="fas fa-user"></i></a>
                    <a :href="otherLangLink">
                        <i class="fas">{{otherLang}}</i>
                    </a>
                </div>
            </div>
            <li v-for="menu in menus">
                <router-link :to="menu.uri">
                    <i :class="menu.icon"></i> {{ menu.label }}
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    import menusEn from '../config/en/menu'
    import menusRu from '../config/ru/menu'

    export default {
        data() {
            return {
                menus: (window.Language === 'en') ? menusEn : menusRu,
                user: {}
            }
        },
        mounted() {
            this.user = window.User
        },
        computed: {
            userInfo() {
                return this.mainPage + '/user/' + this.user.id
            },
            mainPage(){
                return '/' + window.Language;
            },
            otherLang(){
                return (window.Language === 'en') ? 'ru' : 'en';
            },
            otherLangLink(){
                return this.$route.fullPath.replace('/' + window.Language + '/', '/' + this.otherLang + '/');
            }
        }
    }
</script>

<style lang="scss" scoped>
    .sidebar-nav {
        position: absolute;
        top: 0;
        width: 250px;
        margin: 0;
        padding: 0;
        list-style: none;

        i {
            font-size: .9rem;
        }
    }

    .sidebar-nav li {
        text-indent: 20px;
        line-height: 40px;

        i {
            font-size: .6rem;
        }
    }

    .navbar {
        margin-bottom: 0;
    }

    .sidebar-nav li .user {
        display: block;
        text-align: center;
        width: 100%;
        background-color: #9fa0a1;
        padding-top: 20px;
        padding-bottom: 10px;
        color: #fff;
    }

    .user {
        text-align: center;
        padding-top: 15px;
    }

    .user .avatar {
        width: 80px;
        margin: 10px auto;
    }

    .nickname {
        color: #fff;
    }

    .buttons {
        height: 50px;
    }

    .buttons a {
        display: inline-block;
        font-size: 20px;
        width: 40px;
        height: 40px;
        line-height: 40px;
        margin-right: 5px;
        color: #fff;
        opacity: .5;
    }

    .buttons a:hover {
        opacity: 1;
    }

    .sidebar-nav li a {
        display: block;
        text-decoration: none;
        color: #fff;
        opacity: .5;
    }

    .sidebar-nav li a:hover {
        opacity: 1;
        text-decoration: none;
        background: #9fa0a1;
    }

    .sidebar-nav li .active {
        opacity: 1;
    }

    .sidebar-nav li a i {
        padding-right: 10px;
    }

    .sidebar-nav li a:active,
    .sidebar-nav li a:focus {
        text-decoration: none;
    }

    .active {
        background-color: #9fa0a1;
        border-right: 4px solid #000;
    }

    .active a {
        color: #fff !important;
    }
</style>
