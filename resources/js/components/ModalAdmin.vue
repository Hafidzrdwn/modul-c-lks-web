<template>
  <!-- The Modal Admin -->
  <div id="ModalAdmin" class="modal" :class="{'d-block': isModalShow }" @click.prevent="closeModal">
  
    <div class="modal-dialog modal-lg" @click.stop="">
      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="fw-bold m-0"><slot name="header"></slot></h3>
          <span class="close" @click="closeModal">&times;</span>
        </div>
        <div class="modal-body">
          <form>

            <div class="row justify-content-center text-center">
              <slot name="body">
              </slot>
              
              <button type="submit" class="w-50" @click.prevent="handleSubmit">Submit</button>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  
  </div>
</template>

<script>
export default {
  name: 'ModalAdmin',
  props: {
    isModalShow: {
      type: Boolean,
      default: false
    },
    formData: {
      type: Object,
      default: () => ({})
    }
  },
  methods: {
    closeModal() {
      this.$emit('close-modal');
    },

    handleSubmit() {
      this.$emit('submit-form', this.formData);
    }
  },
}
</script>

<style scoped>
.modal-header {
  padding: 10px 20px;
}
.modal-content {
  width: 80%;
  margin: auto;
}
</style>