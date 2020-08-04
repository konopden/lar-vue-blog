<template>
    <span :style="{color: color}" @click="setStatus(rowData)"><i class="fas fa-circle"></i></span>
</template>
<script>
    import {mapActions} from "vuex";
    export default {
        props: {
            apiUrl: {
                type: String,
                required: true
            },
            rowData: {
                type: Object,
                required: true
            },
        },
        computed: {
            color() {
                return this.rowData.status ? '#28a745' : '#9fa0a1'
            }
        },
        data() {
            return {}
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            setStatus(rowData) {
                this.showLoader();
                axios.post('/api/comment/' + rowData.id + '/status', {status: !rowData.status}).then(response => {
                    this.rowData.status = !this.rowData.status;
                    this.hideLoader();
                    if (this.rowData.status) {
                        toastr.success(this.$t('commentEnabled'))
                    } else {
                        toastr.warning(this.$t('commentDisabled'))
                    }
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        toastr.error('An error has occurred.');
                        this.hideLoader();
                    }
                });
            }
        }
    }
</script>
<style lang="scss" scoped>
    span {
        cursor:pointer;
    }
</style>
