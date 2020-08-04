<template>
    <div class="cover-avatar text-center" :class="{ 'uploading': !loaded }">
        <img :src="src" class="avatar">
        <button class="btn py-1 px-3 btn-primary btn-upload mt-1">
            Change Avatar
            <input type="file" name="avatar" :accept="imageType" @change="upload">
        </button>
        <modal :show="dialogVisible" @cancel="dialogVisible = false">
            <div slot="title">Crop Avatar</div>
            <cropper :image="cropImage" @canceled="dialogVisible = false" @succeed="succeed"></cropper>
        </modal>
    </div>
</template>
<script>
    import Modal from './Modal.vue';
    import Cropper from './Cropper.vue';
    export default {
        components: { Modal, Cropper },
        props: {
            src: {
                type: String,
                default () {
                    return ''
                }
            }
        },
        data() {
            return {
                cropImage: undefined,
                imageType: 'image/png,image/gif,image/jpeg,image/jpg,image/tiff',
                loaded: true,
                dialogVisible: false
            }
        },
        methods: {
            upload(e){
                let image = e.target.files[0];
                let formData = new FormData();

                formData.append('image', image);
                formData.append('strategy', 'avatar');
                this.loaded = false;
                axios.post('/file/upload', formData).then(response => {
                    this.loaded = true;
                    this.dialogVisible = true;
                    this.cropImage = response.data;
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        toastr.error('An error has occurred.')
                    }
                });
            },
            succeed() {
                this.dialogVisible = true;
                window.location = '/' + window.Language + '/user/profile';
            },
        }
    }
</script>
