<template>
    <div id="wrapper" :class="{ toggled: isToggle }">
        <template v-if="isLoading">
            <i class="fas fa-spinner fa-4x fa-spin loader mt-4"></i>
        </template>
        <sidebar></sidebar>
        <div id="page-content-wrapper">
            <navbar></navbar>
            <div class="container-fluid">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
    import Sidebar from './components/Sidebar';
    import Navbar from './components/Navbar';
    export default {
        components: {
            Sidebar,
            Navbar
        },
        computed: {
            isToggle() {
                return this.$store.state.sidebar.opened
            },
            isLoading(){
                return this.$store.state.loader.visible
            }
        }
    }
</script>
<style lang="scss">
    $sidebarColor: #828e9a;
    $sidebarBar: darken($sidebarColor, 3%);
    $sidebarRoll: darken($sidebarColor, 8%);

    body {
        overflow-x: hidden;
    }

    /* Toggle Styles */

    #wrapper {
        padding-left: 0;
        transition: all 0.5s ease;
        #wrapper.toggled {
            padding-left: 250px;
        }
    }

    #sidebar-wrapper {
        z-index: 1000;
        position: fixed;
        left: 250px;
        width: 0;
        height: 100%;
        margin-left: -250px;
        overflow-y: auto;
        background-color: transparent;
        background-image: linear-gradient(360deg, #000, #6d6d6e);
        transition: all 0.5s ease;
    }

    #wrapper.toggled #sidebar-wrapper {
        width: 250px;
    }

    #page-content-wrapper {
        width: 100%;
        position: absolute;

        .container-fluid {
            .row {
                margin: 15px;
            }
        }
    }

    #wrapper.toggled #page-content-wrapper {
        position: absolute;
        margin-right: -250px;
    }

    @media(max-width: 768px) {
        #page-content-wrapper {
            padding-left: 0;
            transition: all 0.5s ease;
        }
        #wrapper.toggled #page-content-wrapper {
            transition: all 0.5s ease;
            padding-left: 250px;
            margin-right: -250px;
        }
    }

    @media(min-width:768px) {
        #wrapper {
            padding-left: 250px;
        }

        #wrapper.toggled {
            padding-left: 0;
        }

        #sidebar-wrapper {
            width: 250px;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 0;
        }

        #page-content-wrapper {
            position: relative;
        }

        #wrapper.toggled #page-content-wrapper {
            position: relative;
            margin-right: 0;
        }
    }

    .hr {
        margin-left: 1px;
        margin-right: 1px;
        border: 1px solid $sidebarBar;
    }

    .profile {
        margin: 15px auto;
        text-align: center;
        img {
            height: 125px;
            border: 3px solid lightgrey;
            border-radius: 200px;
        }
        h1 {
            margin-top: 10px;
            color: white;
            font-size: 1.3em;
        }
    }

    .btn.btn-edit {
        color: #fff !important;
        background-color: #3498db;
        border-color: #3498db;
    }
    .btn.btn-delete {
        color: #fff !important;
        background-color: #ff0028;
        border-color: #ff0028;
    }
    .actions a {
        display: inline-block;
        border-radius: 50%;
        width: 2.2rem;
        height: 2.2rem;
        line-height: 2rem;
        padding: 0;
        margin-left: 5px;
        margin-right: 5px;
        cursor: pointer;
        i {
            font-size: 0.8rem;
        }
    }
    a{
        cursor: pointer;
    }
</style>
