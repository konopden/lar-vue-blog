<template>
    <div class="row files">
        <div class="container-fluid">
            <div class="bg-light p-2 d-flex border rounded-top">
                <h5 class="align-self-center font-weight-normal">Files</h5>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" v-for="(disp, path) in files.breadcrumbs">
                            <a @click="goToFolder(path)">
                                {{ disp }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ files.folderName }}</li>
                    </ol>
                </nav>
                <div class="ml-auto d-flex flex-row">
                    <button type="button" class="btn btn-sm btn-success" @click="createFolder = true">
                        <i class="fas fa-folder-plus"></i> {{ $t('createFolder') }}
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" @click="uploadFile = true">
                        <i class="fas fa-file-upload"></i> {{ $t('uploadFile') }}
                    </button>
                </div>
            </div>
            <div class="box-content no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-left">
                            {{ $t('name') }}
                        </th>
                        <th class="text-left">
                            {{ $t('type') }}
                        </th>
                        <th class="text-left">
                            {{ $t('modified') }}
                        </th>
                        <th class="text-left">
                            {{ $t('size') }}
                        </th>
                        <th class="text-left width-10-percent">
                            {{ $t('actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(subFolder, index) in files.subFolders" :class="{ selected: editFolder[subFolder.path] }">
                        <td class="text-left">
                            <i class="fas fa-folder"></i>
                            <a @click="goToFolder(subFolder.path)" v-if="!editFolder.hasOwnProperty(subFolder.path)">
                                {{ subFolder.name }}
                            </a>
                            <input v-model="files.subFolders[index].name" v-if="editFolder.hasOwnProperty(subFolder.path)" class="edit-field">
                        </td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="actions text-left">
                            <a class="btn btn-edit" @click="renameFolder(subFolder.path, index)">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-delete" @click="deleteFolder(subFolder.path, index)">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr v-for="(file, index) in files.files" class="file" :class="{ selected: editFile[file.path] }">
                        <td class="text-left">
                            <i class="fas fa-file"></i>
                            <a :href="file.webPath" target="_blank" v-if="!editFile.hasOwnProperty(file.path)">
                                {{ file.filename }}
                            </a>
                            <input v-model="files.files[index].filename" v-if="editFile.hasOwnProperty(file.path)" class="edit-field">
                        </td>
                        <td class="text-left">{{ file.mime }}</td>
                        <td class="text-left">{{ file.modified }}</td>
                        <td class="text-left">{{ file.size }}</td>
                        <td class="actions text-left">
                            <a class="btn btn-edit" @click="renameFile(file.path, index)">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-delete" @click="deleteFile(file.path, index)">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                        <td>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="ml-auto d-flex flex-row" v-if="controlButtons">
                    <button type="button" class="btn btn-sm btn-success" @click="saveFields">
                        <i class="far fa-save"></i> {{ $t('save') }}
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" @click="cancelRename">
                        <i class="far fa-window-close"></i> {{ $t('cancel') }}
                    </button>
                </div>
            </div>
        </div>
        <modal :show="createFolder" @cancel="createFolder = false" @confirm="confirmNewFolder" :showFooter="true">
            <div slot="title">{{ $t('createFolder') }}</div>
            <form class="form mx-auto">
                <div>
                    <input type="text" v-model="newFolderName" :placeholder="'Folder name'" class="form-control">
                </div>
            </form>
        </modal>
        <modal :show="uploadFile" @cancel="uploadFile = false" @confirm="confirmUploadFiles" :showFooter="true">
            <div slot="title">{{ $t('uploadFiles') }}</div>
            <form class="form mx-auto">
                <div v-for="n in 5">
                    <input type="text" v-model="uploadFilesNames[n]" :placeholder="'File name'"
                           class="form-control w-60 file-name">
                    <button class="btn py-1 px-3 btn-primary btn-upload">
                        {{ $t('selectFile') }}
                        <input type="file" @change="fileUploader(n, $event.target.files[0])">
                    </button>
                </div>
            </form>
        </modal>
    </div>
</template>
<script>
    import Modal from '../../../components/Modal.vue';
    import {mapActions} from "vuex";

    export default {
        components: {Modal},
        data() {
            return {
                files: {},
                uploadFiles: {},
                uploadFilesNames: {},
                editFolder: {},
                editFile: {},
                controlButtons: false,
                createFolder: false,
                uploadFile: false,
                newFolderName: '',
            }
        },
        created() {
            this.getFolderContents();
        },
        watch:{
            $route (){
                this.getFolderContents();
            }
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            goToFolder(path) {
                this.$router.push({name: 'admin-panel.file', query: {folder: path}});
            },
            getFolderContents(){
                this.showLoader();
                let folder = this.$route.query.folder;
                let path = (folder) ? folder : '/';
                axios.get('/api/files?folder='+ path).then(response => {
                    this.files = response.data;
                    this.hideLoader();
                }).catch(error => {
                    if (error.response.status !== 200) {
                        toastr.error(this.$t('anErrorHasOccurred'));
                        this.hideLoader();
                    }
                });
            },
            confirmNewFolder() {
                if (!this.newFolderName) {
                    toastr.error(this.$t('folderNameIsRequired'));
                    return;
                }
                this.pathForNewFolder = ((this.files.folder == '/') ? '' : this.files.folder) + '/' + this.newFolderName;
                this.showLoader();
                axios.post('/api/folder/create', {folder: this.pathForNewFolder}).then(response => {
                    toastr.success(this.$t('folderCreated'));
                    this.files.subFolders.push({name: this.newFolderName, path: this.pathForNewFolder});
                    this.newFolderName = '';
                    this.hideLoader();
                }).catch(error => {
                    if (error.response.status !== 200) {
                        toastr.error(this.$t('anErrorHasOccurred'));
                        this.hideLoader();
                    }
                });
                this.createFolder = false;
            },
            confirmUploadFiles() {
                let formData = new FormData();
                for (let num in this.uploadFiles) {
                    if(this.uploadFilesNames[num]){
                        formData.append('files[]', this.uploadFiles[num]);
                        formData.append('names[]', this.uploadFilesNames[num]);
                    }
                }
                formData.append('folder', this.files.folder);
                this.showLoader();
                axios.post('/api/files/upload', formData).then(response => {
                    console.log(response);
                    toastr.success(this.$t('filesUploaded'));
                    for (let num in response.data) {
                        if(response.data[num])
                            this.files.files.push(response.data[num]);
                    }
                    this.uploadFiles = {};
                    this.uploadFilesNames = {};
                    this.uploadFile = false;
                    this.hideLoader();
                }).catch(error => {
                    if (error.response.status !== 200) {
                        toastr.error(this.$t('anErrorHasOccurred'));
                        this.hideLoader();
                    }
                });
            },
            fileUploader(n, e) {
                this.$set(this.uploadFiles, n, e);
                this.$set(this.uploadFilesNames, n, e.name);
            },
            renameFolder(path, index) {
                if(!this.editFolder[path]) {
                    this.$set(this.editFolder, path, index);
                    this.controlButtons = true;
                }
                else {
                    this.controlButtons = false;
                    this.$delete(this.editFolder, path);
                }
            },
            cancelRename(){
                this.controlButtons = false;
                this.editFolder = {};
                this.editFile = {};
            },
            saveFields(){
                this.showLoader();
                for (let editFolderPath in this.editFolder) {
                    let index = this.editFolder[editFolderPath];
                    let folder = this.files.subFolders[index];
                    axios.post('/api/files/rename', {path: folder.path, new_name: folder.name}).then(response => {
                        this.$delete(this.editFolder, editFolderPath);
                        folder.path =  response.data.newPath;
                        this.$set(this.files.subFolders, index, folder);
                        this.hideLoader();
                    }).catch(error => {
                        toastr.error(error.response.status + ' : Resource ' + error.response.data.messages);
                        this.hideLoader();
                    });
                }
                for (let editFilePath in this.editFile) {
                    let index = this.editFile[editFilePath];
                    let file = this.files.files[index];
                    axios.post('/api/files/rename', {path: file.path, new_name: file.filename}).then(response => {
                        this.$delete(this.editFile, editFilePath);
                        file.path = response.data.newPath;
                        file.webPath = response.data.webPath;
                        this.$set(this.files.files, index, file);
                        this.hideLoader();
                    }).catch(error => {
                        toastr.error(error.response.status + ' : Resource ' + error.response.data.messages);
                        this.hideLoader();
                    });
                }
                this.controlButtons = false;
            },
            deleteFolder(path, index) {
                this.showLoader();
                axios.post('/api/folder/delete', {del_folder: path}).then(response => {
                    toastr.success(this.$t('deleteFolderSuccess'));
                    this.$delete(this.files.subFolders, index);
                    this.hideLoader();
                }).catch(error => {
                    toastr.error(error.response.status + ' : Resource ' + error.response.data.messages);
                    this.hideLoader();
                });
            },
            renameFile(path, index) {
                if(!this.editFile.hasOwnProperty(path)) {
                    this.$set(this.editFile, path, index);
                    this.controlButtons = true;
                }
                else {
                    this.controlButtons = false;
                    this.$delete(this.editFile, path);
                }
            },
            deleteFile(path, index) {
                this.showLoader();
                axios.post('/api/file/delete', {del_file: path}).then(response => {
                    toastr.success(this.$t('deleteFileSuccess'));
                    this.files.files.splice(index, 1);
                    this.hideLoader();
                }).catch(error => {
                    toastr.error(error.response.status + ' : Resource ' + error.response.data.messages);
                    this.hideLoader();
                });
            }
        }
    }
</script>
<style lang="scss" scoped>
    .breadcrumb {
        padding: 0 0.75rem;
        margin-bottom: 0.5rem;
        background-color: inherit;
    }

    .btn {
        margin: 0 0.5rem;
    }

    .file a {
        color: #464646;
    }

    [type="file"] {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        width: 100%;
        height: 35px;
        opacity: 0;
    }

    .form-control.file-name {
        display: inline-block;
    }

    .w-60 {
        width: 60%;
    }

    .btn-upload {
        vertical-align: inherit;
        position: relative;
    }

    .selected{
        background-color: rgba(0, 0, 0, 0.05);
    }

    .edit-field{
        margin: 0;
        padding: 0;
    }

    .fas.fa-folder, .fas.fa-file{
        padding: 7px 0;
    }
</style>
