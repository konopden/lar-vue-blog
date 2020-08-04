<template>
    <div class="row ">
        <div class="col card bg-light">
            <div class="card-title h3 border-bottom p-1">{{ $t('articles') }}</div>
            <div class="card-body h1 text-secondary">
                <i class="fas fa-newspaper"></i>
                {{statistics.articles}}
                <i class="fas fa-spinner fa-spin" v-if="!statistics.articles"></i>
            </div>
        </div>
        <div class="col card bg-light">
            <div class="card-title h3 border-bottom p-1">{{ $t('comments') }}</div>
            <div class="card-body h1 text-secondary">
                <i class="fas fa-comments"></i>
                {{statistics.comments}}
                <i class="fas fa-spinner fa-spin" v-if="!statistics.comments"></i>
            </div>
        </div>
        <div class="col card bg-light">
            <div class="card-title h3 border-bottom p-1">{{ $t('users') }}</div>
            <div class="card-body h1 text-secondary">
                <i class="fas fa-users"></i>
                {{statistics.users}}
                <i class="fas fa-spinner fa-spin" v-if="!statistics.users"></i>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                statistics: {}
            }
        },
        mounted() {
            axios.get('/statistics').then(response => {
                this.statistics = response.data;
            });
        }
    }
</script>
