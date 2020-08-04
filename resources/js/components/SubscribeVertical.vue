<template>
    <form @submit.prevent="submit" class="subscribe-form">
        <input type="hidden" name="_token" :value="csrf">
        <div class="form-group">
            <input type="text" class="form-control" v-model="fields.email" :placeholder="$t('subscribe.emailPlaceholder')">
            <input type="submit" :value="$t('subscribe.subscribe')" class="mt-2 btn btn-white submit">
        </div>
    </form>
</template>
<script>
    import SubscribeMixin from '../mixins/SubscribeMixin';

    export default {
        mixins: [SubscribeMixin]
    }
</script>
