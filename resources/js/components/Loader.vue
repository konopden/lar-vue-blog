<template>
    <i v-if="isLoading" class="fas fa-spinner fa-4x fa-spin loader mt-4"></i>
</template>
<script>
    export default {
        computed: {
            isToggle() {
                return this.$store.state.sidebar.opened
            },
            isLoading() {
                return this.$store.state.loader.visible
            }
        }
    }
</script>
