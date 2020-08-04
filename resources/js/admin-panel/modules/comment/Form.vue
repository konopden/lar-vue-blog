<template>
    <div class="row">
        <form class="form col-md-6 mx-auto" @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="editor">{{ $t('content') }}</label>
                <textarea id="editor" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ $t('edit') }}</button>
            </div>
        </form>
    </div>
</template>
<script>
    import {mapActions} from "vuex";
    import { default as SimpleMDE } from 'simplemde/dist/simplemde.min'

    export default {
        data() {
            return {
                simplemde: '',
            }
        },
        props: {
            comment: {
                type: Object,
                default () {
                    return {}
                }
            }
        },
        watch: {
            comment() {
                if(this.comment.id){
                    this.simplemde.value(this.comment.content);
                }
            }
        },
        mounted() {
            this.simplemde = new SimpleMDE({
                element: document.getElementById("editor"),
                autoDownloadFontAwesome: true,
                forceSync: true,
                previewRender(plainText, preview) {
                    preview.className += ' markdown';
                },
            });
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            onSubmit() {
                this.showLoader();
                this.comment.content = this.simplemde.value();
                let url = 'comment' + (this.comment.id ? '/' + this.comment.id : '');
                let method = this.comment.id ? 'patch' : 'post';
                axios[method]('/api/' + url, this.comment).then(response => {
                    toastr.success(this.$t('youUpdatedNewCommentInfo'));
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
