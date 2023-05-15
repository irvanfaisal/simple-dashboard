<template>
    <div class="modal fade" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">{{title}}</h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
            <form @submit.prevent="submitEditRequest()" class="row g-3">
                <div class="modal-body">
                    <div class="mb-3">
                        <input
                        type="hidden"
                        class="form-control"
                        placeholder=""
                        v-model="record.id"
                        />
                    </div>
                    
                    <div class="mb-3">
                        <label for="" class="form-label">Title</label>
                        <input
                        required
                        type="text"
                        class="form-control"
                        placeholder=""
                        v-model="record.title"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Article</label>
                        <textarea 
                        rows=5
                        required
                        class="form-control"
                        placeholder=""
                        v-model="record.article"
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                    >
                    Close
                    </button>
                    
                    <input type="submit" class="btn btn-success" value="save">
                </div>
            </form>
        </div>
      </div>
    </div>
  </template>
  <script>
  
  export default {
  
      props: {
        title: {
            type: String,
            default: "New Blog",
        },
        isEdit: {
            type: Boolean,
            default: false,
        },        
        record: {
            type: Object,
            default: {
                id: "",
                title: "",
                article: ""
            },
        }
      },    
      methods: {
        async submitEditRequest() {
            try {
                let axRsp = await axios.post("/blogs", this.record );
                const index = this.$parent.blogs.findIndex(blog => blog.id === this.record.id);
                if (~index)
                    this.$parent.blogs[index] = axRsp.data.data;
                else
                    this.$parent.blogs.unshift(axRsp.data.data);
                this.$parent.editModal.hide()
            } catch (err) {
                console.log(err);
            }
        },
      
    },
  };
  </script>
  