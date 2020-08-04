<template>
    <div class="row">
        <form class="form col-md-6 mx-auto" @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="name">{{ $t('name') }}</label>
                <input type="text" id="name" v-model="category.name" class="form-control">
            </div>
            <div class="form-group">
                <label for="path">{{ $t('path') }}</label>
                <input type="text" id="path" v-model="category.path" class="form-control">
            </div>
            <div class="form-group">
                <label for="image_url">{{ $t('image') }}</label>
                <input type="text" id="image_url" class="form-control" name="image_url"
                       v-model="category.image_url" placeholder="ex: public/images/img-not-found.png">
                <img v-if="category.image_url != null && category.image_url !== ''" :src="category.image_url"
                     :alt="category.name" width="35" height="35">
                <button class="btn py-1 px-3 btn-primary btn-upload mt-1 file">
                    {{ $t('uploadNewImage') }}
                    <input type="file" name="avatar" :accept="imageType" @change="imageUploader">
                </button>
            </div>
            <div class="form-group">
                <label for="editor">{{ $t('description') }}</label>
                <textarea id="editor" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    {{ category.id ? this.$t('edit') : this.$t('create') }}
                </button>
            </div>
        </form>
    </div>
</template>
<script>
    import {mapActions} from "vuex";
    import FineUploader from 'fine-uploader/lib/traditional'
    import { default as SimpleMDE } from 'simplemde/dist/simplemde.min'

    export default {
        data() {
            return {
                imageType: 'image/png,image/gif,image/jpeg,image/jpg,image/tiff',
                simplemde: '',
            }
        },
        props: {
            category: {
                type: Object,
                default () {
                    return {
                        image_url: ''
                    }
                }
            }
        },
        computed: {
            mode() {
                return this.category.id ? 'update' : 'create'
            },
        },
        watch: {
            category() {
                if(this.category.id){
                    this.simplemde.value(this.category.description);
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
            this.contentUploader()
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            onSubmit() {
                this.showLoader();
                this.category.description = this.simplemde.value();
                let url = 'category' + (this.category.id ? '/' + this.category.id : '');
                let method = this.category.id ? 'patch' : 'post';
                axios[method]('/api/' + url, this.category).then(response => {
                    toastr.success(this.$t('you') + ' ' + this.$t(this.mode+'d') + this.$t('aNewCategoryInfo'));
                    this.hideLoader();
                    if(this.mode === 'create')
                        this.$router.push({ name: 'admin-panel.category' });
                }).catch(error => {
                    if (error.response.status !== 200) {
                        toastr.error(this.$t('anErrorHasOccurred'));
                        this.hideLoader();
                    }
                });
            },
            imageUploader(e){
                let image = e.target.files[0];
                let formData = new FormData();

                formData.append('image', image);
                formData.append('strategy', 'article');
                axios.post('/file/upload', formData).then(response => {
                    toastr.success(this.$t('uploadFileSuccess'));
                    this.category.image_url = response.data.webPath;
                }).catch(error => {
                    if (error.response.status !== 200) {
                        toastr.error(this.$t('anErrorHasOccurred'))
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
</style>
