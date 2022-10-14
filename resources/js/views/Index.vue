<template>
    <div class="jumbotron">
        <div class="container">
            <h1>Welcome to Geek Bot!</h1>
            <p>
                Check Out our latest product that might be what you need for
                your next project in our product gallery
            </p>
        </div>
    </div>
        <div class="row g-0">
            <div class="col-md-1 col-sm-1 col-lg-1">
                <div class="bar w-100"></div>
            </div>
            <div class="col-md-10 col-sm-10 col-lg-10 px-4">
                <div class="row">
                    <h1>Geek Bot Shop</h1>
                </div>
                    <div class="shop-box p-0 mb-3">
                        <ul class="shop-list" v-if="products.length > 0">
                            <li v-for="product in products" :key="product.idProduk">
                                <div class="row justify-content-start">
                                    <div class="col-md-4 col-sm-4 col-lg-4">
                                        <h3 class="fw-bold">
                                                <span class="idproduk">{{ product.idProduk }}</span> - 
                                                <span class="namabarang">{{ product.namaProduk }}</span>
                                        </h3>
                                        <span>{{ product.beratProduk }} / {{ product.warnaProduk }} / {{ product.tanggalProduksi }}</span>
                                    </div>
                                    <div style="font-size: 20px;" class="col-md-4 col-sm-4 col-lg-4">
                                        <p class="m-0">
                                            @Rp. <span class="harga_produk">{{ Math.trunc(product.hargaProduk) }}</span>
                                        </p>
                                        <p class="kategori m-0">{{ product.kategori.namaKategori }}</p>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-lg-3">
                                        <input type="number" class="form-control" 
                                        value=0 
                                        @change="multiply($event, product.hargaProduk, product.idProduk)"
                                        @input="multiply($event, product.hargaProduk, product.idProduk)"
                                        autocomplete="off" min="0">
                                        <h4 class="m-0 fw-bold mt-2">Rp. <span>{{ product.totHargaProdukFormatted }}</span></h4>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="shop-list" v-else>
                            <li>
                                <h3 class="text-center">Tidak ada Barang</h3>
                            </li>
                        </ul>
                    </div>
            
                    <h1>Paket Pengiriman</h1>
                    <div class="row justify-content-between" style="border-bottom: 5px solid #b4faff">
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <h4>Pilih Paket</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-lg-6">
                                    <select class="w-100 form-control form-select" @change="calculatePaket" autocomplete="off" required v-model="tipePaket">
                                        <option value="List paket pengiriman" disabled>List paket pengiriman</option>
                                        <option v-for="kirim in kirims" :key="kirim.idKirim" :value="Math.trunc(kirim.hargaPaket)" >
                                            {{ kirim.namaPaket }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6 text-end">
                            <h1 class="text-end">
                                Rp. <span class="paket harga">{{ paket.hargaPaketFormatted }}</span>
                            </h1>
                        </div>
                    </div>
            
                    <br /><br />
                    <h1 style="text-align: right">
                        Total Harga : Rp. <span class="total">{{ totalHarga }}</span>
                    </h1>
            
                    <div class="text-center">
                        <button @click="cart" class="btn btn-success mt-3">Submit</button>
                    </div>
                    <br /><br />
            </div>
            
            <div class="col-md-1 col-sm-1 col-lg-1">
                <div class="bar w-100"></div>
            </div>
        </div>

        <Modal :isModalShow="showModal" @close-modal="closeModal" 
        :datas="carts" :jenisPaket="tipePaket" :hargaPaket="paket.hargaPaketFormatted" :totalHarga="totalHarga"
        @confirm-order="handlePayOrder" />
</template>

<script>
import Modal from '../components/Modal.vue'


export default {
    name: "Index",
    components: { Modal },
    data(){
        return {
            carts: [],
            kirims: [],
            products: [],
            paket: {
                hargaPaket: 0,
                hargaPaketFormatted: '0'
            },
            tipePaket: "List paket pengiriman",
            totalHarga: 0,
            showModal: false
        }
    },
    created(){
        this.getProducts()
        this.getKirims()
    },
    methods: {
        async getKirims() {

            try {

                const res = await fetch(base('/kirims'), {
                    method: 'GET',
                    ...fetchConf
                })
                const {data} = await res.json()
                this.kirims = data
                
            } catch (err) {
                console.error(err)
            }

        },
        async getProducts() {

            try {

                const res = await fetch(base('/products'), {
                    method: 'GET',
                    ...fetchConf
                })
                const { data } = await res.json()
                this.products = data
                this.products = this.products.map(product => {
                    product.totHargaProduk = 0;
                    product.totHargaProdukFormatted = '0';
                    product.qtyProduk = 0;
                    return product;
                });

            } catch (err) {
                console.error(err)
            }

        },
        multiply(event, price, idProduk){
            let tot = event.target.value * Math.trunc(price);         
            let produk = this.products.filter(prod => prod.idProduk == idProduk)[0];

            produk.totHargaProduk = tot
            produk.totHargaProdukFormatted = String(tot).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            produk.qtyProduk = event.target.value;

            this.getTotalHarga()
        },
        calculatePaket() {
            this.paket.hargaPaket = this.tipePaket
            this.paket.hargaPaketFormatted = String(this.tipePaket).replace(/\B(?=(\d{3})+(?!\d))/g, '.')
            this.getTotalHarga()
        },
        getTotalHarga(){
            let tot = 0;
            this.products.forEach((product) => {
                tot += product.totHargaProduk
            })
            tot = tot + + this.paket.hargaPaket;
            this.totalHarga = String(tot).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        },
        closeModal(){
            this.showModal = false
            this.carts = []
        },
        cart() {
            this.products.forEach(product => {
                if(product.qtyProduk > 0){
                    this.carts.push(product)
                }
            })

            if (localStorage.getItem('RlUsFcekR')) {
                alert('Role anda adalah admin, anda tidak bisa membeli barang!!')
            } else {
                if(this.carts.length > 0){
                    this.showModal = true
                } else {
                    alert("Anda belum memilih product!!")
                }
            }
            
        },
        async handlePayOrder(_data, paket) {
            if (!localStorage.getItem('token')) {
                this.$router.push('login')
            } else {
                if (_data.length > 0) {

                    // insert order and order detail
                    const idKirim = this.kirims.filter(kirim => kirim.hargaPaket == paket)[0].idKirim;
                    let d = new Date();
                    let datestring = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
                    try {
                        const res = await fetch(base('/orders'), {
                            method: 'POST',
                            body: JSON.stringify({
                                orderDate: datestring,
                                idCustomer: JSON.parse(localStorage.getItem('fakeCstm')).id,
                                idKirim: idKirim
                            }),
                            ...fetchConf
                        });
                        const {data} = await res.json()

                        const dt = _data.map(dt => {
                            return {
                                jumlahBarang: dt.qtyProduk,
                                totalHarga: dt.totHargaProduk,
                                idOrder: data.idOrder,
                                idProduk: dt.idProduk
                            }
                        })

                        await fetch(base('/order_details'), {
                            method: 'POST',
                            body: JSON.stringify(dt),
                            ...fetchConf
                        })

                    } catch (err) {
                        console.error(err)
                    }

                    this.showModal = false
                    this.resetValues()
                } else {
                    console.log('data kosong')
                }
            }
        },
        resetValues(){
            this.products = []
            this.paket.hargaPaket = 0
            this.paket.hargaPaketFormatted = '0'
            this.tipePaket = "List paket pengiriman"
            this.totalHarga = 0
            this.carts = []

            this.getProducts()
            this.getKirims()    
        }
    }
};
</script>
