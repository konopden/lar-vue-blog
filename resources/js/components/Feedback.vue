<template>
    <form @submit.prevent="submit" class="bg-light p-5 contact-form">
        <input type="hidden" name="_token" :value="csrf">
        <div class="form-group">
            <input type="text" class="form-control" :placeholder="$t('feedback.name')" v-model="fields.name">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" :placeholder="$t('feedback.email')" v-model="fields.email">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" :placeholder="$t('feedback.subject')" v-model="fields.subject">
        </div>
        <div class="form-group">
            <textarea name="" id="" cols="30" rows="7" class="form-control" :placeholder="$t('feedback.message')" v-model="fields.message"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" :value="$t('feedback.send')" class="btn btn-primary py-3 px-5">
        </div>
    </form>
</template>
<script>
    export default {
        data() {
            return {
                fields: {},
                success: false,
                loaded: true,
                action: 'feedback/add',
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
                        toastr.success('Subscribe successfully added.')
                    }).catch(error => {
                        this.loaded = true;
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                            for (var error in this.errors) {
                                toastr.error(this.errors[error])
                            }

                        }
                    });
                }
            }
        }
    }

</script>
