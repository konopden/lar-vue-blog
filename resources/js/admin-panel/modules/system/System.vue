<template>
    <div class="row system">
        <div class="container-fluid">
            <div class="bg-light p-2 d-flex border rounded-top">
                <h5 class="align-self-center font-weight-normal">{{ $t('system') }}</h5>
            </div>
            <div class="row p-2">
                <div class="col-2">
                    <div>
                        <a @click="type='server'" class="group-item p-2">
                            <i class="fas fa-server"></i> {{ $t('server') }}
                        </a>
                        <a @click="type='php'" class="group-item p-2">
                            <i class="fab fa-php"></i> PHP
                        </a>
                        <a @click="type='site'" class="group-item p-2">
                            <i class="fab fa-laravel"></i> {{ $t('site') }}
                        </a>
                    </div>
                </div>
                <div class="col-9 p-2">
                    <div v-if="type === 'server'">
                        <table>
                            <tr>
                                <th>{{ $t('os') }}</th>
                                <td>{{system.os}}</td>
                            </tr>
                            <tr>
                                <th>{{ $t('server') }}</th>
                                <td>{{system.server}}</td>
                            </tr>
                            <tr>
                                <th>{{ $t('domain') }}</th>
                                <td>{{system.http_host}}</td>
                            </tr>
                        </table>
                    </div>
                    <div v-if="type === 'php'">
                        <table>
                            <tr>
                                <th>{{ $t('version') }}</th>
                                <td>{{system.php}}</td>
                            </tr>
                            <tr>
                                <th>{{ $t('interfaceType') }}</th>
                                <td>{{system.php_sapi_name}}</td>
                            </tr>
                            <tr>
                                <th>{{ $t('extensions') }}</th>
                                <td>{{system.extensions}}</td>
                            </tr>
                        </table>
                    </div>
                    <div v-if="type === 'site'">
                        <table>
                            <tr>
                                <th>{{ $t('numberOfArticlesPerPage') }}</th>
                                <td>{{system.articles_an_page}}</td>
                            </tr>
                            <tr>
                                <th>{{ $t('sortForArticles') }}</th>
                                <td>{{system.articles_sort}}</td>
                            </tr>
                            <tr>
                                <th>{{ $t('imageByDefault') }}</th>
                                <td><img :src="system.image_cap" alt=""></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapActions} from "vuex";

    export default {
        data() {
            return {
                system: {},
                type: 'server'
            }
        },
        created() {
            this.showLoader();
            axios.get('/api/system').then(response => {
                this.system = response.data;
                this.hideLoader();
            }).catch(error => {
                if (error.response.status !== 200) {
                    toastr.error(this.$t('anErrorHasOccurred'));
                    this.hideLoader();
                }
            });
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
        }
    }
</script>
<style lang="scss" scoped>
    .group-item {
        display: block;
        color: #000000;
        cursor: pointer;
    }
    img{
        max-width: 50px;
    }
    .system td{
        padding: 20px 50px;
    }
</style>
