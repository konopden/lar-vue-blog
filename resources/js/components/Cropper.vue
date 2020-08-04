<template>
    <div :class="wrapper">
        <div :class="cropperWrapper">
            <img id="cropImage" style="width:100%" :src="image.webPath">
        </div>
        <span slot="footer" class="footer">
      <button class="btn btn-outline-secondary" @click="cancel">{{ $t('cropper.cancel') }}</button>
      <button class="btn btn-primary" @click="upload">{{ $t('cropper.ok') }}</button>
    </span>
    </div>
</template>

<script>
    import 'cropperjs/dist/cropper.css'
    import Cropper from 'cropperjs'

    export default {
        components: { Cropper },
        props: {
            image: {
                type: Object,
                default() {
                    return {}
                }
            },
            wrapper: {
                type: String,
                default() {
                    return ''
                }
            },
            cropperWrapper: {
                type: String,
                default() {
                    return ''
                }
            },
        },
        data() {
            return {
                cropper: null,
            }
        },
        mounted() {
            this.createCropper()
        },
        watch: {
            image(val) {
                this.replaceUrl()
            }
        },
        methods: {
            replaceUrl() {
                this.cropper.replace(this.image.url)
            },
            createCropper() {
                var image = document.getElementById('cropImage');
                this.cropper = new Cropper(image, {
                    aspectRatio: 1,
                    autoCropArea: 0.2,
                    movable: false,
                    zoomable: false,
                    cropBoxResizable : false
                })
            },
            upload(e) {
                let that = this

                let formData = {
                    'image': this.image,
                    'data': this.cropper.getData()
                };
                axios.post('/crop/avatar', formData).then(response => {
                    that.$emit('succeed');
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        toastr.error('An error has occurred.')
                    }
                });
            },
            cancel() {
                this.$emit('canceled')
            },
        },
    }
</script>

<style lang="scss" scoped>
    .footer {
        margin-top: 30px;
        display: block;
        text-align: center;
        background-color: transparent;

        button {
            margin-left: 40px;
            margin-right: 40px;
        }
    }
</style>
