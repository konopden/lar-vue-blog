<template>
    <div class="pt-5 mt-5 comments">
        <h3 class="mb-5 font-weight-bold">{{ $tc('comment.comment', comments.length) }}</h3>
        <ul class="comment-list" v-show="comments">
            <li class="comment" v-for="comment in comments">
                <div class="vcard bio">
                    <img :src="comment.user.avatar?comment.user.avatar:'/images/img-not-found.png'"
                         alt="comment.user.name">
                </div>
                <div class="comment-body">
                    <h3>{{comment.user.name}}</h3>
                    <div class="meta">{{comment.created_at}}</div>
                    <p>{{comment.content}}</p>
                </div>
            </li>
        </ul>

        <div class="comment-form-wrap pt-5">
            <h3 class="mb-5">{{ $t('comment.leaveComment') }}</h3>
            <form @submit.prevent="submit" class="p-3 p-md-5 bg-light">
                <input type="hidden" name="_token" :value="csrf">
                <div class="form-group">
                    <label for="content">{{ $t('comment.message') }}</label>
                    <textarea name="" id="content" cols="30" rows="10"
                              class="form-control" v-model="fields.content" @change="changeField"></textarea>
                    <div v-if="errors && errors.content" class="text-danger">{{ errors.content[0] }}</div>
                </div>
                <div class="form-group">
                    <input type="submit" :value="$t('comment.post')" class="btn py-3 px-4 btn-primary">
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import {mapActions} from "vuex";
    export default {
        props: {
            articleId: {
                type: String,
                default () {
                    return 0
                }
            }
        },
        data() {
            return {
                comments: [],
                fields: {},
                errors: {},
                action: '/comments/' + this.articleId + '/add',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            var url = '/comments/' + this.articleId + '/show';
            axios.get(url).then(response => {
                this.comments = response.data;
            });
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            changeField(){
                for (var fieldName in this.fields) {
                    if(this.fields[fieldName]){
                        this.errors[fieldName] = '';
                    }
                }
            },
            submit() {
                this.showLoader();
                axios.post(this.action, this.fields).then(response => {
                    this.fields = {}; //Clear input fields.
                    toastr.success(this.$t('comment.success'));
                    this.hideLoader();
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        toastr.error(this.$t('comment.error'));
                        this.hideLoader();
                    }
                });

            }
        }
    }
</script>
<style lang="scss" scoped>
    .comments{
        width: 100%;
    }
</style>
