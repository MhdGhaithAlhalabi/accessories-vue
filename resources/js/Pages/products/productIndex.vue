<script setup>
import ProductsLayout from "./productsLayout.vue";
import {Carousel, Navigation, Pagination, Slide} from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import {ref} from "vue";
import { useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
let form = useForm();

defineProps({
    products: Object,
    types: Object,
});
const selectedIRI = ref(0);
const selectColor = (iri) => {
    selectedIRI.value = iri;
};
const deleteProduct = (id)=>{
    return new  Swal({
        title: "هل انت متأكد ؟",
        text: "هل انت متأكد انك تريد حذف المنتج عند الحذف سوف يتم حذف المنتج واي تواجد له !!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "نعم, احذفه",
        cancelButtonText: "لا, الغاء",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then(
        function(isConfirm) {
            if (isConfirm.value === true) {
                form.delete("/product/delete/"+ id);
            }

        })
};
</script>

<template>
    <Head>
        <title>product</title>
    </Head>
    <ProductsLayout :types="types">
        <section style="background-color: #eee;">
            <div class="container py-5">
                <div class="row">

                    <div v-for="product in products" :key="product.id"
                         class="col-md-6 col-lg-4 mb-4 mb-md-0 d-flex align-items-stretch">
                        <div class="card text-black">
<!--                            <div v-for="color in product.color">
                                <div v-if="selectedIRI === color.id">
                                    <Carousel v-if="images !== null" dir="rtl">
                                        <Slide v-for="(image,index) in images" :key="index">
                                            <img :src="`/storage/color_images/${image.url}`"
                                                 alt="image"
                                                 class="card-img-top carousel__item">
                                        </Slide>
                                        <template #addons>
                                            <Navigation/>
                                            <Pagination/>
                                        </template>
                                    </Carousel>
                                </div>


                            </div>-->
                            <div class="card-body">
                                <div class="text-center mt-1">
                                    <h4 class="card-title">{{ product.category.category_name }}
                                        /{{ product.type.type_name }} </h4>
                                    <h6 class="text-primary mb-1 pb-3" v-if="product.status === '0'">
                                        ${{ product.price }}</h6>
                                    <h6 class="text-primary mb-1 pb-3" v-if="product.status === '1'">
                                        <del>${{ product.price }}</del>
                                    </h6>
                                    <h6 class="text-primary mb-1 pb-3" v-if="product.status === '1'">
                                        ${{ product.priceSale }}</h6>
                                    <h6 class="text-primary mb-1 pb-3" v-if="product.status === '0'">-</h6>
                                </div>
                                <div class="text-center">
                                    <div class="p-3 mx-n3 mb-4" style="background-color: #eff1f2;">
                                        <h5 class="mb-0">{{ product.name }}</h5>
                                    </div>
                                    <div class="d-flex flex-column mb-4" style="height: 100px">
                                        <span>{{ product.details }}</span>
                                    </div>

                                    <div class="d-flex flex-column mb-4">
                                        <span class="h1 mb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                            <div class="ratings">
                                            <i v-if="product.rate > 0" class="fa fa-star rating-color"></i>
                                            <i v-else class="fa fa-star"></i>
                                            <i v-if="product.rate > 1" class="fa fa-star rating-color"></i>
                                            <i v-else class="fa fa-star"></i>
                                            <i v-if="product.rate > 2" class="fa fa-star rating-color"></i>
                                            <i v-else class="fa fa-star"></i>
                                            <i v-if="product.rate > 3" class="fa fa-star rating-color"></i>
                                            <i v-else class="fa fa-star"></i>
                                            <i v-if="product.rate > 4" class="fa fa-star rating-color"></i>
                                            <i v-else class="fa fa-star"></i>
                            </div>
                                    </div>
                                         </span>
                                        <ul class="list-unstyled mb-0">
                                            <li aria-hidden="true">—</li>
                                            <li v-if="product.has_name === '0'">لا يمكن اختيار اسم للتفصيل</li>
                                            <li v-if="product.has_name === '1'">يمكن اختيار اسم واحد</li>
                                            <li v-if="product.has_name === '2'">يمكن اختيار اسمين</li>
                                            <li v-if="product.has_measure === '0'">القياس ثابت لا يمكن اختياره</li>
                                            <li v-if="product.has_measure === '1'">يمكن طلب قياس محدد</li>
                                            <li aria-hidden="true">—</li>
                                        </ul>
                                    </div>

                                    <div v-if="product.color" class="shoes-colors">
                                        <span
                                            v-for="color in product.color"
                                            :key="color.id"
                                            :class="{'active': color.id === selectedIRI }"
                                            :style="{ background: color.color_hex}"
                                            @click="selectColor(color.id)"
                                        >
                                        </span>
                                            <div v-for="color in product.color"
                                                 :key="color.id">
                                        <div v-if="selectedIRI === color.id">
                                            <Carousel v-if="color.image !== null" dir="rtl">
                                                <Slide v-for="image in color.image" :key="image.id">
                                                    <img :src="`/storage/color_images/${image.url}`"
                                                         alt="image"
                                                         class="card-img-top carousel__item">
                                                </Slide>
                                                <template #addons>
                                                    <Navigation/>
                                                    <Pagination/>
                                                </template>
                                            </Carousel>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column mb-4 lead">
                                        <span class="mb-2">{{ product.created_at_diff }}</span>
                                    </div>

                                <div class="d-flex flex-row" style="margin-top: auto;">
                                    <button type="button" class="btn btn-light flex-fill me-1"
                                            data-mdb-ripple-color="dark">
                                        تعديل
                                    </button>
                                    <button @click="deleteProduct(product.id)"
                                            type="button"
                                            class="btn btn-dark flex-fill ms-1">حذف</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

    </ProductsLayout>
</template>
<!--<style scoped>
.rating-color {
    color: #fbc634 !important;
}


.shoes-colors{
    margin-bottom: 40px;
    display: flex;
    justify-content: center;
}

.shoes-colors span{
    width: 14px;
    height: 14px;
    margin: 0 10px;
    border-radius: 50%;
    cursor: pointer;
    position: relative;
}


.shoes-colors .active:after{
    content: "";
    width: 22px;
    height: 22px;
    border: 2px solid #8888;
    position: absolute;
    border-radius: 50%;
    box-sizing: border-box;
    left: -4px;
    top: -4px;
}



</style>-->


<style scoped>
.rating-color {
    color: #fbc634 !important;
}

.shoes-colors span {
    display: inline-block;
    border-radius: 4px;
    border: 2px solid transparent;
    cursor: pointer;
    width: 25px;
    height: 25px;
    margin-right: 10px;
}

.shoes-colors .active {
    border: 2px solid black
}


</style>
