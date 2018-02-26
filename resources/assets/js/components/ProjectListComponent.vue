<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Project's list</div>

                    <div class="card-body">
                        <table class="table table-bordered table-responsive table-dark d-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Project</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="project in projects">
                                <td>{{project.id}}</td>
                                <td>
                                    <a :href="project.url">{{project.title}}</a>
                                </td>
                                <td><button class="btn btn-primary">Edit</button></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="3">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" v-model="newProject.title" placeholder="Project's title" aria-label="Project's title" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" @click="addProject()" type="button">Add</button>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                'isLoading': false,
                'projects': [],
                'newProject': {
                    'title': ""
                }
            }
        },
        methods: {
            getList() {
                let _this = this;
                axios.get('/api/projects').then((response) => {
                    _this.projects = response.data;
                }).catch((e)=>{
                    alert(e);
                });
            },
            addProject() {
                let _this = this;

                if(_this.newProject.title !== "" && !_this.isLoading) {
                    _this.isLoading = true;
                    axios.post('/api/project', {'title': _this.newProject.title}).then((response) => {
                        _this.projects = response.data;
                        _this.isLoading = false;
                        _this.newProject.title = "";
                    }).catch((e)=>{
                        alert(e);
                        _this.isLoading = false;
                    });
                }
            },
        },
        mounted() {
            this.getList();
        }
    }
</script>
