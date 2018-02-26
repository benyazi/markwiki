<template>
    <div class="b_pageNav bg-dark text-light p-2">
        <ul class="list-unstyled">
            <li v-for="page in pages">
                <a href="#" @click.stop="goto(page)">{{page.title}}</a>
                 | <a :href="page.url" target="_blank" v-if="page.url !== null">URL</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['pages'],
        data() {
            return {}
        },
        methods: {
            getPagesByParent(parentId) {
                return this.pages.filter(function() {

                });
            },
            refreshList() {

            },
            goto(page) {
                this.$emit('goto', page);
            },
        },
        mounted() {
        }
    }
</script>
