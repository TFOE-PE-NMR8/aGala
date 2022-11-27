<template>
 <div class="modal fade" id="largeModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Large Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Non omnis incidunt qui sed occaecati magni asperiores est mollitia. Soluta at et reprehenderit. Placeat autem numquam et fuga numquam. Tempora in facere consequatur sit dolor ipsum. Consequatur nemo amet incidunt est facilis. Dolorem neque recusandae quo sit molestias sint dignissimos.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div><!-- End Large Modal-->
</template>

<script>
  export default {
    name: "PaidModal",
    props: [
      "reg_id",
      "toggle",
    ],
    emits: ["paid-dialog"],
    data () {
      return {
        dialog: false,
        notifications: false,
        sound: true,
        widgets: false,
        research: {
          data:{
            scientific_name: ''
          }
        }
      }
    },
    methods: {
      viewRegistrants(id) {
        
      },
    },
    watch: {
      toggle(nv,ov) {
        if (nv) {
          this.viewRegistrants(this.reg_id)
        }
      },
      dialog(value) {
        if (value == false) {
          this.$emit('paid-dialog', false);
        }
      }
    }
  }
</script>