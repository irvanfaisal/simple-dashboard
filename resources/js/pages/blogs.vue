<template>
    <div>
        <DeleteModal id="deleteModal" v-bind="deleteModalProps"  />
        <EditModal id="editModal" v-bind="editModalProps"  />
        <section class="section">
            <div class="d-block d-md-flex justify-content-between mb-4">
                <div class="pagetitle d-flex gap-4 my-auto">
                    <button class="my-auto btn btn-success" @click.prevent="openEditModal()"><i class="bx bx-plus"></i> New Blog</button>
                </div>            
                <div class="my-auto">
                    <form @submit.prevent="">
                            <div class="d-flex gap-2">
                                <div>
                                    <input placeholder="Search Title" v-model="form.title" type="text" class="form-control"/>
                                </div>
                                <div>
                                    <button @click.prevent="getResults()" type="button" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <table class="table table-striped table-responsive small">
                <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Title</th>
                    <th>Article</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody v-if="blogs && blogs.length > 0">
                    <tr v-for="(blog,index) in blogs" :key="index">
                        <td class="text-center align-middle">{{ pagination.per_page*(pagination.current_page-1)+index+1}}</td>
                        <td class="align-middle">{{ blog.title }}</td>
                        <td class="align-middle">{{ blog.article.substring(0, 100) }} ...</td>
                        <td class="align-middle text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="btn btn-sm small btn-warning" @click.prevent="editResult(blog)">
                                    <span class="d-flex gap-1">
                                        <i class="my-auto bx bx-pencil"></i>
                                        <span>Edit</span>
                                    </span>
                                </button>
                                <button class="btn btn-sm small btn-danger" @click.prevent="openDeleteModal(blog.id)">
                                    <span class="d-flex gap-1">
                                        <i class="my-auto bx bx-trash"></i>
                                        <span>Delete</span>
                                    </span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td align="center" colspan="4">No record found.</td>
                    </tr>
                </tbody>
            </table>
              <Bootstrap5Pagination 
                    size="small"
                    align="right"
                    :limit="3"
                    :data="pagination"
                    @pagination-change-page="getResults"
              />            
        </section>
    </div>
</template>
<script>
    import DeleteModal from "../components/DeleteModal.vue";
    import EditModal from "../components/EditModal.vue";
    import { Bootstrap5Pagination } from 'laravel-vue-pagination';

    export default {
        components: {
            DeleteModal,
            EditModal,
            Bootstrap5Pagination
        },
        data() {
            return {
                blogs: [],
                pagination:{
                    type:Object,
                    default:null
                },
                form: {
                    id: ""
                },
                deleteModalProps: {
                    record: {
                        id: ""
                    }
                },
                editModalProps: {
                    isEdit: false,
                    record: {
                        id: "",
                        title: "",
                        article: ""
                    }
                }
            }
        },
        mounted() {
            this.getResults()
            this.deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            this.editModal = new bootstrap.Modal(document.getElementById('editModal'));
        },    
        methods: {
            openDeleteModal(id){
                this.deleteModalProps.record.id = id;
                this.deleteModal.show()
            },
            resetEditModalProps() {
                this.editModalProps.title = 'New Blog'
                this.editModalProps.isEdit = false
                
                for(let field in this.editModalProps.record){
                    // Not object, set it to empty string
                    if(typeof this.editModalProps.record[field] !== 'object'){
                        this.editModalProps.record[field] = ''
                        continue
                    }
                    // Reaching here is an object, further drill into the object fields
                    for(let numField in this.editModalProps.record[field]){
                        this.editModalProps.record[field][numField] = ''
                    }
                    
                }
            },        
            openEditModal(id){
                this.resetEditModalProps()
                this.editModal.show()
            },
            editResult(item) {
                this.editModalProps.title = 'Edit Blog'
                this.editModalProps.isEdit = true
                this.editModalProps.record = JSON.parse(JSON.stringify(item))

                this.editModal.show()
            },
           async getResults(page=1){
                await axios.get(`/list?page=${page}`, { params: this.form }).then(({data})=>{
                    this.blogs = data.data.data
                    this.pagination = data.data
                }).catch(({ response })=>{
                    console.error(response)
                })
            }
        },    
  };
</script>
  