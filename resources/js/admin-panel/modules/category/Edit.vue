<template>
    <vueForm :title="$t('editCategory')">
        <template slot="buttons">
            <router-link :to="{ name: 'admin-panel.category' }" class="btn btn-sm btn-secondary" exact>
                {{ $t('back') }}
            </router-link>
        </template>
        <template slot="content">
            <CategoryFrom :category="category" v-if="category.id">
            </CategoryFrom>
        </template>
    </vueForm>
</template>
<script>
    import CategoryFrom from './Form';
    import {mapActions} from "vuex";
    export default {
        components:{
            CategoryFrom
        },
        data(){
            return {
                category: {}
            }
        },
        created() {
            this.loadCategory();
        },
        methods:{
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            loadCategory(){
                this.showLoader();
                axios.get('/api/category/' + this.$route.params.id + '/edit').then(response => {
                    this.category = response.data.data;
                    this.hideLoader();
                }).catch(error => {
                    if (error.response.status !== 200) {
                        toastr.error(this.$t('anErrorHasOccurred'));
                        this.hideLoader();
                    }
                });
            }
        }
    }
</script>
