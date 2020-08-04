<template>
    <form @submit.prevent="submit" class="colorlib-subscribe-form">
        <input type="hidden" name="_token" :value="csrf">
        <div class="form-group d-flex">
            <a class="icon" @click="submit"><span class="icon-paper-plane"></span></a>
            <input type="text" class="form-control" :placeholder="$t('subscribe.emailPlaceholder')"
                   v-model="fields.email">
        </div>
    </form>
</template>
<script>
    import SubscribeMixin from '../mixins/SubscribeMixin';

    export default {
        mixins: [SubscribeMixin]
    }
</script>
