<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="b_pageActions">
                    <button class="btn btn-success" @click="saveCurrentPage()">Save current page</button>
                    <button class="btn btn-primary" @click="addNewPage()">Add new page</button>
                </div>
                <page-nav-component :pages="pages" @goto="goto($event)"></page-nav-component>
            </div>
            <div class="col">
                <div v-if="currentPage != null" class="b_pageEditor">
                    <div>
                        <input class="form-control" v-model="currentPage.title"/>
                    </div>
                    <editable-component :text="currentPage.content" @update="currentPage.content = $event"></editable-component>
                    <div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Parent page</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="currentPage.parent_id">
                                    <option :value="null">Not parent</option>
                                    <option :value="page.id" v-for="page in pages" v-if="page.id !== currentPage.id">{{page.id}} # {{page.title}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div v-if="currentPage != null" class="b_pagePreview">
                    <h2>{{currentPage.title}}</h2>
                    <vue-markdown :source="currentPage.content"></vue-markdown>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueMarkdown from 'vue-markdown';
    export default {
        components: {'vue-markdown': VueMarkdown},
        props: [
            'projectId'
        ],
        data() {
            return {
                'pages': [],
                'currentPage': null
            }
        },
        methods: {
            goto(page) {
                console.log('go to page '+ page.title);
                if(this.checkUnsavedData()) {
                    alert('You have unsaved data');
                } else {
                    this.currentPage = page;
                }
            },
            addNewPage(parentId) {
                if(parentId === undefined) {
                    parentId = null;
                }
                this.pages.push({
                    'id': null,
                    'parent_id': parentId,
                    'title': "Page title",
                    'url': null,
                    'content': "**Content**"
                });
            },
            saveCurrentPage() {
                let _this = this;
                axios.post('/api/page/', {currentPage: _this.currentPage, projectId: _this.projectId}).then((response) => {
                    _this.currentPage = response.data.page;
                    alert("Success saved!");
                }).catch((e)=>{
                    alert(e);
                });
            },
            checkUnsavedData() {
                return false;
            },
            loadCurrentPage() {
                if(this.pages.length > 0) {
                    this.currentPage = this.pages[0];
                }
            },
            getPages() {
                let _this = this;
                axios.get('/api/pages/' + this.projectId).then((response) => {
                    _this.pages = response.data;
                    _this.loadCurrentPage();
                }).catch((e)=>{
                    alert(e);
                });
            },
        },
        mounted() {
            this.getPages();
        }
    }
</script>
