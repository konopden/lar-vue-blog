<template>
    <div class="row">
        <div class="container-fluid">
            <div class="bg-light p-2 d-flex border rounded-top">
                <h5 class="align-self-center font-weight-normal" v-if="title">{{ title }}</h5>
                <div class="ml-auto d-flex flex-row">
                    <slot name="buttons"></slot>
                </div>
            </div>
            <div class="box-content no-padding">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default() {
                    return ''
                }
            }
        }
    }
</script>
