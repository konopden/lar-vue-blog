<template>
    <form @submit.prevent="submit" class="search-form" :class="{ 'loaded': !loaded }">
        <div class="form-group">
            <span class="icon icon-search"></span>
            <input type="text" class="form-control" :placeholder="$t('search.search')" v-model="q">
            <div class="dropdown-menu" :class="{ 'show': success }" v-if="q.length > 2">
                <span v-if="articles.length == 0">{{ $t('search.notFound') }}</span>
                <a v-else v-for="article in articles"
                   :href="rootDir + article.category.path + '/' + article.slug"
                   class="dropdown-item"
                >{{ article.title }}</a>
            </div>
        </div>
    </form>
</template>
<script>
    export default {
        data() {
            return {
                q: '',
                articles: {},
                success: false,
                loaded: true,
                rootDir: '/' + window.Language + '/'
            }
        },
        watch: {
            q() {
                if(this.q){
                    this.submit();
                }
            }
        },
        methods: {
            submit() {
                if (this.loaded && this.q.length > 2) {
                    this.loaded = false;
                    this.success = false;
                    axios.post(this.rootDir + 'search/' + this.q).then(response => {
                        this.loaded = true;
                        this.success = true;
                        this.articles = response.data;
                    });
                }
            }
        }
    }
</script>
