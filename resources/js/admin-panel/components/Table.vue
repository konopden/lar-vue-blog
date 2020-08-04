<template>
    <div :class="wrapperClass" class="container-fluid">
        <div class="bg-light p-2 d-flex border rounded-top">
            <h5 class="align-self-center font-weight-normal" v-if="title">{{ title }}</h5>
            <div class="ml-auto d-flex flex-row">
                <div class="input-group input-group-sm mr-2">
                    <input type="text" class="form-control" v-model="searchable[searchKey]"
                           :placeholder="this.$t('searchText')" @keyup.enter="onSearch()">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" @click="onSearch()">
                            <span class="fa fa-search"></span>
                        </button>
                    </div>
                </div>
                <slot name="buttons"></slot>
            </div>
        </div>
        <div class="box-content no-padding">
            <table :class="tableClass">
                <thead>
                    <tr>
                        <th v-for="field in fields" :class="field.titleClass">
                            {{field.title}}
                        </th>
                    </tr>
                </thead>
                <tbody v-cloak>
                <template v-if="items.length > 0">
                    <tr v-for="item in items">
                        <template v-for="field in fields">
                            <template v-if="field.action">
                                <td :class="field.dataClass">
                                    <template v-for="action in itemActions">
                                        <a @click="callAction(action.name, item)" :class="action.class">
                                            <i :class="action.icon"></i>
                                        </a>
                                    </template>
                                </td>
                            </template>
                            <template v-if="field.component">
                                <td :class="field.dataClass">
                                    <custom-action :api-url="apiUrl" :row-data="item"></custom-action>
                                </td>
                            </template>
                            <template v-else>
                                <td v-if="field.callback" :class="field.dataClass"
                                    v-html="callCallback(field.callback, item[field.name])">
                                </td>
                                <td :class="field.dataClass" v-else>
                                    {{ item[field.name] }}
                                </td>
                            </template>
                        </template>
                    </tr>
                </template>
                </tbody>
            </table>
            <table-pagination ref="pagination" v-on:loadPage="loadPage" v-if="showPaginate && items.length > 0"></table-pagination>
        </div>
    </div>
</template>
<script>
    import TablePagination from './TablePagination';
    import {mapActions} from "vuex";
    import CustomAction from './CustomAction';

    export default {
        props: {
            wrapperClass: {
                type: String,
                default() {
                    return null
                }
            },
            title: {
                type: String,
                default() {
                    return ''
                }
            },
            searchKey: {
                type: String,
                default: 'keyword'
            },
            apiUrl: {
                type: String,
                required: true
            },
            tableClass: {
                type: String,
                default: 'table table-striped table-hover'
            },
            fields: {
                type: Array,
                required: true
            },
            itemActions: {
                type: Array,
                default () {
                    return [
                        { name: 'edit-item', icon: 'fas fa-pencil-alt', class: 'btn btn-edit' },
                        { name: 'delete-item', icon: 'fas fa-trash-alt', class: 'btn btn-delete' }
                    ]
                }
            },
            showPaginate: {
                type: Boolean,
                default () {
                    return false
                }
            },
        },
        components:{
            TablePagination, CustomAction
        },
        data() {
            return {
                items: [],
                params: {},
                searchable: {
                    [this.searchKey]: ''
                },
                totalPage: 0,
                currentPage: 0,
                pagination: null
            }
        },
        created() {
            if (this.$route.query[this.searchKey]) {
                this.searchable[this.searchKey] = this.$route.query[this.searchKey]
            }

            this.onSearch()
        },
        mounted() {
            this.$parent.$on('reload', () => {
                this.onSearch(this.$route.query.page)
            })
        },
        watch: {
            $route() {
                let pageNum = 1

                if (this.$route.query.page) {
                    pageNum = this.$route.query.page
                }

                this.loadPage(pageNum)
            }
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            loadPage(page) {
                if (page == 'prev') {
                    this.goPreviousPage()
                } else if (page == 'next') {
                    this.goNextPage()
                } else {
                    this.goPage(page)
                }
            },
            goPreviousPage() {
                if (this.currentPage > 1) {
                    this.currentPage--
                    this.loadData()
                }
            },
            goNextPage() {
                if (this.currentPage < this.totalPage) {
                    this.currentPage++
                    this.loadData()
                }
            },
            goPage(page) {
                if (page != this.currentPage && (page > 0 && page <= this.totalPage)) {
                    this.currentPage = page
                    this.loadData()
                }
            },
            onSearch(page) {
                this.currentPage = page ? page : 1;

                this.params = this.searchable;

                setTimeout(() => {
                    this.loadData()
                }, 10)
            },
            loadData() {
                this.showLoader();
                let url = this.apiUrl;
                let params = {};
                if (this.currentPage) {
                    params = Object.assign(this.params, {
                        page: this.currentPage
                    })
                } else {
                    params = this.params
                }

                this.$router.push({ name: this.$route.name, query: params });

                axios.get(url,  { params: params}).then(response => {
                    this.pagination = {
                        'current_page':response.data.meta.pagination.current_page,
                        'total_pages': response.data.meta.pagination.total_pages
                    };
                    this.totalPage = response.data.meta.pagination.total_pages;
                    this.currentPage = response.data.meta.pagination.current_page;
                    this.items = response.data.data;
                    if (this.showPaginate && this.items.length !== 0) {
                        this.$nextTick(() => {
                            this.$refs.pagination.$data.pagination = this.pagination
                        })
                    }
                    this.hideLoader();
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        toastr.error('An error has occurred.');
                        this.hideLoader();
                    }
                });
            },
            callCallback(field, item){
                return this.$parent[field].call(this.$parent, item);
            },
            callAction(action, data) {
                this.$emit('table-action', action, data)
            }
        }
    }
</script>
