<template>
  
    <div class="row g-0">
      <div class="col-md-1 col-sm-1 col-lg-1">
        <div class="bar"></div>
      </div>
      <div class="col-md-10 col-sm-10 col-lg-10">
        <div class="row p-4">
          <h1 class="mb-4">
            {{ namaUser }}
          </h1>
          <br>
          <h2 class="mt-3">Shopping History</h2>
          <div class="shop-box p-0" style="height: 80vh;">
            <ul class="p-0" v-if="orders.length > 0">
              
                  <li style="border:2px solid gray; margin:5px;" class="p-4 mb-3" v-for="order in orders" :key="order.idOrder">
                    <h1>{{ order.orderDate }} - {{ order.kirim.namaPaket }} : {{ Math.trunc(order.kirim.hargaPaket) }}</h1>
                    <h3>Order detail</h3> 
                    <div class="table-responsive">          
                      <table class="table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                          </tr>
                        </thead>
                        <tbody class="listbarang">
                            <tr v-for="details in order.order_details" :key="details.idOrderDetail">
                              <td>{{ details.idProduk }}</td>
                              <td>{{ details.product.namaProduk }}</td>
                              <td>{{ details.jumlahBarang }}</td>
                              <td>{{ String(Math.trunc(details.totalHarga)).replace(/\B(?=(\d{3})+(?!\d))/g, '.') }}</td>      
                            </tr> 
                        </tbody>
                      </table>
                      <h1>Harga Total :  {{ String(order.totalSemuaHarga).replace(/\B(?=(\d{3})+(?!\d))/g, '.') }}</h1>
                      </div>
                  </li>
                
            </ul>
            <ul class="p-0" v-else>
              <li style="border:2px solid gray; margin-top: 30px; padding:20%; text-align:center; height:200px; border-radius:10px;">
                <h1>
                  You have not ordered any item.
                </h1>
              </li>
            </ul>
          </div>
        </div>
  
      </div>
  
      <div class="col-md-1 col-sm-1 col-lg-1">
        <div class="bar"></div>
      </div>
  
    </div>
</template>

<script>

export default {
  name: "User",
  computed() {
    getTotalHarga() 
  },
  data() {
    return {
      namaUser: JSON.parse(localStorage.getItem("fakeCstm")).name,
      orders: []
    }
  },
  created() {
    this.getOrders()
  },
  methods: {
    async getOrders() {
      const id = JSON.parse(localStorage.getItem('fakeCstm')).id
      const res = await axios.get(`/customers/${id}`)
      this.orders = res.data.data
      console.log(res.data.data)
    }
  }
}
</script>

<style scoped>
.bar {
  background: url('../../assets/images/wallpaper.jpg') !important;
}
</style>