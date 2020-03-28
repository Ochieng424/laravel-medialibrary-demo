<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 bg-white p-3 mt-4">
                <form method="post" @submit.prevent="createProduct" autocomplete="off">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input v-model="form.name" type="text" name="name"
                               placeholder="Enter Name"
                               class="form-control">
                        <small style="color: red" v-if="error && errors.name">{{ errors.name[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input v-model="form.price" type="number" name="price"
                               placeholder="Enter Price"
                               class="form-control">
                        <small style="color: red" v-if="error && errors.price">{{ errors.price[0] }}</small>
                    </div>
                    <div class="form-group justify-content-center">
                        <label for="files">Select Image(s)</label>
                        <input type="file" multiple class="form-control-file" @change="fieldChange"
                               id="files">
                        <small style="color: red" v-if="error && errors.files">{{ errors.files[0] }}</small>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success btn-sm">Save Product</button>
                </form>
            </div>
        </div>
        <div class="vld-parent">
            <loading name="loader" :active.sync="isLoading"
                     :can-cancel="false"
                     :is-full-page="fullPage"></loading>
        </div>
    </div>
</template>

<script>
    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
        name: "Home",
        components: {
            Loading
        },
        data() {
            return {
                products: [],
                formProduct: new FormData(),
                attachments: [],
                isLoading: false,
                fullPage: true,
                errors: {},
                error: false,
                form: {
                    name: '',
                    price: ''
                }
            }
        },
        methods: {
            getProducts(){
                axios.get('/products').then((data)=>{
                    this.products = data.data
                })
            },
            createProduct() {
                this.isLoading = true;
                for (let i = 0; i < this.attachments.length; i++) {
                    this.formProduct.append('files[]', this.attachments[i]);
                }
                this.formProduct.append('name', this.form.name);
                this.formProduct.append('price', this.form.price);
                const config = {headers: {'Content-Type': 'multipart/form-data'}};
                axios.post('/products', this.formProduct, config).then(response => {
                    this.isLoading = false;
                    swal.fire({
                        type: 'success',
                        title: 'Success!!',
                        text: 'Product Created Successfully',
                    })
                })
                    .catch(error => {
                        this.isLoading = false;
                        this.error = true;
                        this.errors = error.response.data.errors;
                    });
            },
            fieldChange(e) {
                let selectedFiles = e.target.files;
                if (!selectedFiles.length) {
                    return false;
                }
                for (let i = 0; i < selectedFiles.length; i++) {
                    this.attachments.push(selectedFiles[i]);
                }
            },
        },
        created() {
            this.getProducts();
        }
    }
</script>

<style scoped>

</style>
