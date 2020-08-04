export default {
    data() {
        return {
            fields: {},
            success: false,
            loaded: true,
            action: '/' + window.Language + '/subscribe/add',
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                axios.post(this.action, this.fields).then(response => {
                    this.fields = {}; //Clear input fields.
                    this.loaded = true;
                    this.success = true;
                    toastr.success(this.$t('subscribe.success'))
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        var errorMessage = (error.response.data.errors.email[0])
                            ? error.response.data.errors.email[0] : this.$t('subscribe.fail');
                        toastr.error(errorMessage)
                    }
                });
            }
        }
    }
}
