<template>
    <div id="ModalEditor" class="modal" :class="{'d-block': isModalShow }" @click.prevent="closeModal">

      <div class="modal-dialog modal-lg" @click.stop="">
        <!-- Modal content -->
        <div class="modal-content">
          <div class="modal-header p-3 px-4">
            <h2 class="m-0">Confirm Order</h2>
            <span class="close" @click="closeModal">&times;</span>
          </div>
          <div class="modal-body">
            <form @submit.prevent="handlePayProduk">
              <h2>List Barang</h2>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Jumlah</th>
                      <th>Harga total</th>
                    </tr>
                  </thead>
                  <tbody v-if="datas.length > 0">
                    <tr v-for="data in datas" :key="data.idProduk">
                      <td>{{ data.idProduk }}</td>
                      <td>{{ data.namaProduk }}</td>
                      <td>{{ data.qtyProduk }}</td>
                      <td>Rp. {{ data.totHargaProdukFormatted }}</td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="4" class="text-center text-muted">Tidak ada barang dalam cart. Silahkan tambahkan terlebih dahulu</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <h4>Biaya Paket Pengiriman : Rp. <span class="paket">{{ hargaPaket }}</span> </h4>
              <h3 class="mt-4">Total Harga : Rp. <span class="total">{{ totalHarga }}</span> </h3>
              
              <p class="mt-0">
                Lanjutkan ke pembayaran?
              </p>
      
              <button class="me-2" type="submit">Yes</button>
              <button type="button" @click="closeModal">No</button>
            </form>
          </div>
        </div>
      </div>
    
    </div>
</template>

<script>
export default {
  props: ['isModalShow', 'datas', 'hargaPaket', 'totalHarga', 'jenisPaket'],
  methods: {
    closeModal() {
      this.$emit('close-modal');
    },
    handlePayProduk() {
        this.$emit('confirm-order', this.datas, this.jenisPaket);
    },
  }
}
</script>

<style scoped>
/* Modal Content */
.modal-content {
  position: relative;
  margin: auto;
  padding: 0;
  border-radius: 10px;
  width: 100%;
}

/* Modal Body */
.modal-body {
  padding: 20px 30px;
}

.btn-cancel-modal {
  background: #fff !important;
  border: 1px solid #000;
  color: #000;
  transition: .3s;
}
.btn-cancel-modal:hover {
  background: #000 !important;
  border: 1px solid black;
  color: #fff;
}
</style>