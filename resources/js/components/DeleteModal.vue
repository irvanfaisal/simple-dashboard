<template>
  <div class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Confirmation</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this record?</p>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Close
          </button>
          <button type="button" class="btn btn-danger" @click.prevent="deleteBlog()">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

export default {

    props: {
        record: {
            type: Object,
            default: {
                id: ""
            },
        }
    },    
    methods: {
        deleteBlog() {
            axios.delete('/blogs/' + this.record.id)
                .then(response => {
                    const index = this.$parent.blogs.findIndex(blog => blog.id === this.record.id);
                    if (~index)
                        this.$parent.blogs.splice(index, 1);
                    this.$parent.deleteModal.hide()
                });
        },
    
  },
};
</script>
