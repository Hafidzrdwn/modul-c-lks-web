<template>
    <div class="row g-0">
      <div class="col-md-2 col-sm-2 col-lg-2">
        <div class="head">
          <h1 style="background:#002350;padding:10%;color:white;">
            Manage Product
          </h1>
        </div>
      </div>

      <div class="col-md-9 col-sm-9 col-lg-9 px-3 py-5">

        <!-- product table -->
        <h1>Product</h1>
        <button type="button" class="btn btn-primary my-2" @click="AddProduct">Add Product</button>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Berat</th>
                <th>Warna</th>
                <th>Tanggal Produksi</th>
                <th>Harga Produk</th>
                <th>Kategori</th>
              </tr>
            </thead>
            <tbody v-if="loading">
              <tr>
                <td colspan="7" class="text-center">
                  Load data...
                </td>
              </tr>
            </tbody>
            <tbody v-else-if="products.length > 0">
                <tr v-for="product in products" :key="product.idProduk">
                  <td>{{ product.idProduk }}</td>
                  <td>{{ product.namaProduk }}</td>
                  <td>{{ product.beratProduk }}</td>
                  <td>{{ product.warnaProduk }}</td>
                  <td>{{ product.tanggalProduksi }}</td>
                  <td>{{ Math.trunc(product.hargaProduk) }}</td>
                  <td>{{ product.kategori.namaKategori }}</td>
                  <td>
                    <button type="button" class="btn btn-success me-2" @click="editProduct(product.idProduk)">Edit</button>
                    <button type="button" class="btn btn-danger" @click="deleteProduct(product.idProduk)">Delete</button>
                  </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr> 
                  <td colspan="7" class="text-center text-muted">
                    Empty Products.
                  </td>
                </tr>
            </tbody>
          </table>
        </div>

        <!-- category table -->
        <h1 class="mt-3">Category</h1>
        <button type="button" class="btn btn-primary mt-2 mb-3" @click="AddCategory">Add Category</button>
        <div class="table-responsive">
          <table class="table">
            <table class="table">
              <thead>
                <tr>
                  <th>Category Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody v-if="loading">
                <tr>
                  <td colspan="2" class="text-center">Load data...</td>
                </tr>
              </tbody>
              <tbody v-else-if="categories.length > 0">
                <tr v-for="category in categories" :key="category.idKategori">
                  <td>{{ category.namaKategori }}</td>
                  <td>
                    <button type="button" class="btn btn-success me-2" @click="editCategory(category.idKategori)">Edit</button>
                    <button type="button" class="btn btn-danger" @click="deleteCategory(category.idKategori)">Delete</button>
                  </td>
                </tr>
                </tbody>
               <tbody v-else>
                <tr> 
                  <td colspan="2" class="text-center text-muted">
                    Category is empty.
                  </td>
                </tr>
              </tbody>
            </table>
          </table>
        </div>

      </div>
  
      <div class="col-md-1 col-sm-1 col-lg-1">
        <div class="head">
        </div>
      </div>
      
    </div>

    <!-- MODAL -->
    <ModalAdmin :isModalShow="modalShow" @close-modal="closeModal" :formData="formData" @submit-form="handleSubmitForm">
      <template v-slot:header>{{ headerName }}</template>
      <template v-slot:body>
        <div class="row justify-content-center" v-if="modalProduk">
          <div class="row justify-content-center mb-4">
            <div class="col-md-12">
              <div class="mb-3 row">
                <div class="col-6">
                  <label for="id_produk" class="mb-1">ID</label>
                  <input type="text" id="id_produk" class="w-100" v-model="formDataProduk.idProduk">
                </div>
                <div class="col-6">
                  <label for="nama_produk" class="mb-1">Nama Produk</label>
                  <input type="text" id="nama_produk" class="w-100" v-model="formDataProduk.namaProduk">
                </div>
              </div>
              <div class="mb-3 row">
                <div class="col-6">
                  <label for="berat_produk" class="mb-1">Berat Produk</label>
                  <input type="number" id="berat_produk" min="0" class="w-100" v-model="formDataProduk.beratProduk">
                </div>
                <div class="col-6">
                  <label for="warna_produk" class="mb-1">Warna Produk</label>
                  <input type="text" id="warna_produk" class="w-100" v-model="formDataProduk.warnaProduk">
                </div>
              </div>
              <div class="mb-3 row">
                <div class="col-6">
                  <label for="tanggal_produksi" class="mb-1">Tanggal Produksi</label>
                  <input type="date" id="tanggal_produksi" class="w-100" v-model="formDataProduk.tanggalProduksi">
                </div>
                <div class="col-6">
                  <label for="harga_produk" class="mb-1">Harga Produk</label>
                  <input type="number" id="harga_produk" min="0" class="w-100" v-model="formDataProduk.hargaProduk">
                </div>
              </div>  
              <div>
                <label for="kategori_produk" class="mb-1">Kategori Produk</label>
                <select id="kategori_produk" class="d-block w-100 form-select form-control" name="kategori" v-model="formDataProduk.idKategori">
                  <option value="Pilih Kategori">Pilih Kategori</option>
                  <option v-for="category in categories" :key="category.idKategori" :value="category.idKategori">
                    {{ category.namaKategori }}
                  </option>
                </select>
              </div>  
              <p class="m-0 mt-3 text-danger">{{ productError }}</p>
            </div>
          </div>
        </div>
        <!-- modal add category -->
        <div class="row justify-content-center mb-4" v-else>
          <div class="col-md-12">
            <h5>Category</h5>
            <input type="text" class="w-75" :class="{'border border-danger': categoryError}" v-model="formDataKategori.namaKategori">
            <p class="m-0 mt-3 text-danger" v-if="categoryError">{{ categoryError }}</p>
          </div>
        </div>
      </template>
    </ModalAdmin>
</template>

<script>
import ModalAdmin from '../components/ModalAdmin.vue'
import { ref } from '@vue/reactivity'
export default {
  name: 'Admin',
  setup() {
    const formData = ref({})
    const formDataProduk = ref({
      idProduk: '',
      namaProduk: '',
      beratProduk: '',
      warnaProduk: '',
      tanggalProduksi: '',
      hargaProduk: '0',
      idKategori: 'Pilih Kategori',
    })
    const productError = ref("")
    const formDataKategori = ref({ namaKategori: '' })
    const categoryError = ref("")
    const products = ref([])
    const categories = ref([])
    const modalProduk = ref(false)
    const methodSubmit = ref("add")
    const attrId = ref(null)
    const headerName = ref("")
    const modalShow = ref(false)
    const loading = ref(true)

    const AddCategory = () => {
      modalProduk.value = false
      categoryError.value = ""
      productError.value = ""
      methodSubmit.value = "add"
      modalShow.value = true
      headerName.value = "Add Category"
      formData.value = formDataKategori.value
    }

    const AddProduct = () => {
      modalProduk.value = true
      categoryError.value = ""
      productError.value = ""
      methodSubmit.value = "add"
      modalShow.value = true
      headerName.value = "Add Product"
      formData.value = formDataProduk.value
    }

    const editCategory = async (id) => {
      modalProduk.value = false
      categoryError.value = ""
      productError.value = ""
      methodSubmit.value = "edit"
      headerName.value = "Edit Category"
      modalShow.value = true

      const res = await fetch(base(`/categories/${id}`), {
        method: 'GET',
        ...fetchConf
      })
      const data = await res.json()

      formDataKategori.value.namaKategori = data.data.namaKategori
      formData.value = formDataKategori.value
      attrId.value = id
    }

    const editProduct = async (id) => {
      modalProduk.value = true
      categoryError.value = ""
      productError.value = ""
      methodSubmit.value = "edit"
      headerName.value = "Edit Product"
      modalShow.value = true

      const res = await fetch(base(`/products/${id}`), {
        method: 'GET',
        ...fetchConf
      })
      const data = await res.json()

      formDataProduk.value = data.data
      formDataProduk.value.hargaProduk = Math.trunc(data.data.hargaProduk)
      formData.value = formDataProduk.value
      attrId.value = id
    }

    const getProducts = async () => {
      loading.value = true
      try {

        const res = await fetch(base('/products'), {
          method: 'GET',
          ...fetchConf
        })
        const data = await res.json()
        if (data.status) {
          loading.value = false
          products.value = data.data
        }
        
      } catch (err) {
        console.error(err)
      }

    }

    const getCategories = async () => {
      formDataKategori.value.namaKategori = ''
      loading.value = true

      try {

        const res = await fetch(base('/categories', {
          method: 'GET',
          ...fetchConf
        }))
        const data = await res.json()
        if (data.status) {
          loading.value = false
          categories.value = data.data
        }
        
      } catch (err) {
        console.error(err)
      }

    }

    const handleSubmitForm = async (dt) => {
        loading.value = true
        let response = null
        let mtd = (methodSubmit.value === "add") ? 'POST' : 'PUT'
        let url = null
      
        if (modalProduk.value) {
          for (let key in dt) { 
            if (!dt[key]) {
              productError.value = `form should not be empty, fill all the input fields!!`
              loading.value = false
              return
            }
          }

          url = (methodSubmit.value === "add") ? '/products' : `/products/${attrId.value}`
          response = await fetch(base(url), {
            method: mtd,
            body: JSON.stringify(dt),
            ...fetchConf
          })
        } else {

          url = (methodSubmit.value === "add") ? '/categories' : `/categories/${attrId.value}`
          const body = (methodSubmit.value === "add") ? dt : { namaKategori: dt.namaKategori }
          response = await fetch (base(url), {
            method: mtd,
            body: JSON.stringify(body),
            ...fetchConf
          })

        }    

        const result = await response.json()

        if (result.status) {
          modalShow.value = false
          resetForm()

          if (result.type == "category") {
            getCategories()
          } else {
            getProducts()
          }
        } else {
          loading.value = false
          if (result.type == "category") {
            categoryError.value = result.errors.namaKategori[0]
          } else {
            productError.value = result.errors.idProduk[0];
          }
        }
    }

    const deleteCategory =  async (id) => {
      const kategori = categories.value.find(category => category.idKategori === id)
      if (confirm(`Apakah anda yakin ingin menghapus kategori ${kategori.namaKategori}?`)) {
        loading.value = true

        try {

          await fetch(base(`/categories/${id}`), {
            method: 'DELETE',
            ...fetchConf
          })
          getCategories()

        } catch (err) {
          console.error(err)
        }

      }
    }

    const deleteProduct = async (id) => {
      const product = products.value.find(product => product.idProduk === id)
      if (confirm(`Apakah anda yakin ingin menghapus produk ${product.namaProduk}?`)) {
        loading.value = true

        try {

          await fetch(base(`/products/${id}`), {
            method: 'DELETE',
            ...fetchConf
          })
          getProducts()
          
        } catch (err) {
          console.error(err)
        }

      }
    }

    const closeModal = () => {
      modalShow.value = false
      resetForm()
    }

    const resetForm = () => {
      formDataKategori.value = {
        namaKategori: ''
      }
      formDataProduk.value = {
        idProduk: '',
        namaProduk: '',
        beratProduk: '',
        warnaProduk: '',
        tanggalProduksi: '',
        hargaProduk: '0',
        idKategori: 'Pilih Kategori',
      }
    }

    getProducts()
    getCategories()

    return {
      formData,
      formDataProduk,
      formDataKategori,
      products,
      categories,
      modalProduk,
      headerName,
      modalShow,
      loading,
      AddProduct,
      editProduct,
      deleteProduct,
      productError,
      AddCategory,
      editCategory,
      deleteCategory,
      categoryError,
      handleSubmitForm,
      closeModal
    }
  },
  components: {
    ModalAdmin
  },
}
</script>

<style scoped>
  .head {
    background: url('../../assets/images/wallpaper.jpg') !important;
    height: 100%;
  }
</style>