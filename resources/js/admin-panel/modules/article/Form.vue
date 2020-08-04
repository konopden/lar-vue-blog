<template>
    <div class="row">
        <form class="form col-md-6 mx-auto" @submit.prevent="onSubmit">
            <div class="form-group">
                <label>{{ $t('category') }}</label>
                <multiselect v-model="selected" :options="categories" label="name" placeholder="select category"
                             track-by="name">
                </multiselect>
            </div>
            <div class="form-group">
                <label for="title">{{ $t('title') }}</label>
                <input type="text" id="title" v-model="article.title" class="form-control">
            </div>
            <div class="form-group">
                <label for="subtitle">{{ $t('subtitle') }}</label>
                <input type="text" id="subtitle" v-model="article.subtitle" class="form-control">
            </div>
            <div class="form-group">
                <label for="page_image">{{ $t('image') }}</label>
                <input type="text" id="page_image" class="form-control" name="page_image"
                       v-model="article.page_image" placeholder="ex: public/images/img-not-found.png">
                <img v-if="article.page_image != null && article.page_image !== ''" :src="article.page_image"
                     :alt="article.title" width="35" height="35">
                <button class="btn py-1 px-3 btn-primary btn-upload mt-1 file">
                    {{ $t('uploadNewImage') }}
                    <input type="file" name="avatar" :accept="imageType" @change="imageUploader">
                </button>
            </div>
            <div class="form-group">
                <label for="editor">{{ $t('content') }}</label>
                <textarea id="editor" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>{{ $t('tags') }}</label>
                <multiselect v-model="tags" :options="allTags" :multiple="true" :searchable="true" :hide-selected="true"
                             :close-on-select="false" :clear-on-select="false" :limit="5" placeholder="select tags"
                             label="tag" track-by="tag">
                </multiselect>
            </div>
            <div class="form-group">
                <label for="meta_description">{{ $t('metaDesc') }}</label>
                <textarea id="meta_description" v-model="article.meta_description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>{{ $t('publishTime') }}</label>
                <Datepicker :date="startTime" :option="option"></Datepicker>
            </div>
            <div class="form-group row">
                <div class="col-sm-2 col-form-label">
                    {{ $t('isDraft') }}
                </div>
                <div class="col-sm-2">
                    <div class="togglebutton">
                        <label>
                            <input type="checkbox" name="is_draft" v-model="article.is_draft">
                            <span class="toggle"></span>
                        </label>
                    </div>
                </div>
                <div class="col-sm-2 col-form-label">
                    {{ $t('isOriginal') }}
                </div>
                <div class="col-sm-2">
                    <div class="togglebutton">
                        <label>
                            <input type="checkbox" name="is_original" v-model="article.is_original">
                            <span class="toggle"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    {{ article.id ? $t('edit') : $t('create') }}
                </button>
            </div>
        </form>
    </div>
</template>
<script>
    import {mapActions} from "vuex";
    import Datepicker from 'vue-datepicker';
    import Multiselect from 'vue-multiselect';
    import FineUploader from 'fine-uploader/lib/traditional'
    import { default as SimpleMDE } from 'simplemde/dist/simplemde.min'

    export default {
        components: {
            Datepicker,
            Multiselect
        },
        data() {
            return {
                selected: null,
                tags: null,
                categories: [],
                allTags: [],
                imageType: 'image/png,image/gif,image/jpeg,image/jpg,image/tiff',
                simplemde: '',
                startTime: {
                    time: ''
                },
                option: {
                    type: 'min',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD HH:mm:ss',
                    placeholder: 'published time',
                    inputStyle: {
                        'display': 'block',
                        'width': '100%',
                        'height': 'calc(1.5em + 0.75rem + 2px)',
                        'padding': '0.375rem 0.75rem',
                        'font-weight': '400',
                        'line-height': '1.5',
                        'color': '#495057',
                        'background-color': '#fff',
                        'background-clip': 'padding-box',
                        'border': '1px solid #ced4da',
                        'border-radius': '0.25rem',
                        '-webkit-transition': 'border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out',
                        'transition': 'border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out',
                    },
                    color: {
                        header: '#495057',
                        headerText: '#fff'
                    },
                    buttons: {
                        ok: 'Ok',
                        cancel: 'Cancel'
                    },
                    overlayOpacity: 0.5,
                    dismissible: true
                }
            }
        },
        props: {
            article: {
                type: Object,
                default () {
                    return {
                        page_image: ''
                    }
                }
            }
        },
        computed: {
            mode() {
                return this.article.id ? 'update' : 'create'
            },
        },
        watch: {
            article() {
                if(this.article.id){
                    this.selected = this.article.category.data;
                    this.tags = this.article.tags.data;
                    this.simplemde.value(this.article.content);
                    this.startTime.time = this.article.published_time
                }
            }
        },
        created() {
            this.loadCategories()
            this.loadTags()
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
            this.contentUploader()
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            onSubmit() {
                if (!this.tags || !this.selected) {
                    toastr.error(this.$t('categoryAndTagMustSelect'))
                    return;
                }
                this.showLoader();
                let tagIDs = [];
                for (var i = 0; i < this.tags.length; i++) {
                    tagIDs[i] = this.tags[i].id
                }
                this.article.content = this.simplemde.value();
                this.article.category_id = this.selected.id;
                this.article.tags = JSON.stringify(tagIDs);
                this.article.published_at = this.startTime.time;
                let url = 'article' + (this.article.id ? '/' + this.article.id : '');
                let method = this.article.id ? 'patch' : 'post';
                axios[method]('/api/' + url, this.article).then(response => {
                    toastr.success(this.$t('you') + ' ' + this.$t(this.mode+'d') + this.$t('newArticleInformation'));
                    this.hideLoader();
                    if(this.mode === 'create')
                        this.$router.push({ name: 'admin-panel.article' });
                }).catch(error => {
                    if (error.response.status !== 200) {
                        toastr.error(this.$t('anErrorHasOccurred'));
                        this.hideLoader();
                    }
                });
            },
            loadCategories() {
                axios.get('/api/categories').then(response => {
                    this.categories = response.data;
                });
            },
            loadTags(){
                axios.get('/api/tags').then(response => {
                    this.allTags = response.data;
                });
            },
            imageUploader(e){
                let image = e.target.files[0];
                let formData = new FormData();

                formData.append('image', image);
                formData.append('strategy', 'articles');
                axios.post('/file/upload', formData).then(response => {
                    toastr.success(this.$t('uploadFileSuccess'));
                    this.article.page_image = response.data.webPath;
                }).catch(error => {
                    if (error.response.status !== 200) {
                        toastr.error('An error has occurred.')
                    }
                });
            },
            contentUploader(){
                let vm = this
                let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let contentUploader = new FineUploader.FineUploaderBasic({
                    paste: {
                        targetElement: document.querySelector('.CodeMirror')
                    },
                    request: {
                        endpoint: '/file/upload',
                        inputName: 'image',
                        customHeaders: {
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        params: {
                            strategy: 'article'
                        }
                    },
                    validation: {
                        allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
                    },
                    callbacks: {
                        onPasteReceived(file) {
                            let promise = new FineUploader.Promise()

                            if (file == null || typeof file.type == 'undefined' || file.type.indexOf('image/')) {
                                toastr.error(this.$t('onlyCanUploadImage'));
                                return promise.failure('not a image.')
                            }

                            return promise.then(() => {
                                vm.createdImageUploading('image.png')
                            }).success('image')
                        },
                        onComplete(id, name, responseJSON) {
                            vm.replaceImageUploading(name, responseJSON.url)
                        },
                    },
                });

                let dragAndDropModule = new FineUploader.DragAndDrop({
                    dropZoneElements: [document.querySelector('.CodeMirror')],
                    callbacks: {
                        processingDroppedFilesComplete(files, dropTarget) {
                            files.forEach((file) => {
                                vm.createdImageUploading(file.name)
                            })
                            contentUploader.addFiles(files); // this submits the dropped files to Fine Uploader
                        }
                    }
                })
            },
            getImageUploading() {
                return '\n![Uploading ...]()\n'
            },
            createdImageUploading(name) {
                this.simplemde.value(this.simplemde.value() + this.getImageUploading())
            },
            replaceImageUploading(name, url) {
                let result = '\n![' + name + '](' + url + ')\n'
                this.simplemde.value(this.simplemde.value().replace(this.getImageUploading(), result))
            },
        }
    }
</script>
<style lang="scss" scoped>
    .file {
        position:relative;
        input {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            width: 100%;
            height: 35px;
            opacity: 0;
        }
    }
    .cov-vue-date{
        display: block;
    }
</style>
