<template>
    <div class="row">
        <form class="form col-md-6 mx-auto" @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="tag">{{ $t('tag') }}</label>
                <input type="text" id="tag" v-model="tag.tag" class="form-control">
            </div>
            <div class="form-group">
                <label for="title">{{ $t('title') }}</label>
                <input type="text" id="title" v-model="tag.title" class="form-control">
            </div>
            <div class="form-group">
                <label for="editor">{{ $t('metaDesc') }}</label>
                <textarea id="editor" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    {{ tag.id ? this.$t('edit') : this.$t('create') }}
                </button>
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
            tag: {
                type: Object,
                default () {
                    return {}
                }
            }
        },
        computed: {
            mode() {
                return this.tag.id ? 'update' : 'create'
            },
        },
        watch: {
            tag() {
                if(this.tag.id){
                    this.simplemde.value(this.tag.meta_description);
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
                this.tag.meta_description = this.simplemde.value();
                let url = 'tag' + (this.tag.id ? '/' + this.tag.id : '');
                let method = this.tag.id ? 'patch' : 'post';
                axios[method]('/api/' + url, this.tag).then(response => {
                    toastr.success(this.$t('you') +' ' + this.$t(this.mode+'d') + this.$t('newTagInfo'));
                    this.hideLoader();
                    if(this.mode === 'create')
                        this.$router.push({ name: 'admin-panel.tag' });
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
