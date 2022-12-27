<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2';
import {ref} from "vue";
import axios from "axios";
import NavLink from "../../Shared/NavLink.vue";

const selectedType = ref(0);
const selectedCategory = ref(0);
const categories = ref(0);
defineProps({
    types: Array,
});
let form = useForm({
    name: '',
    details: '',
    price: '',
    status: '',
    priceSale: '',
    has_measure: '',
    type_id: selectedType,
    category_id: selectedCategory,
    has_name: '',
});
let submit = () => {
    form.post('/products/create', {
            onSuccess: () => Swal.fire({
                icon: 'success',
                title: 'success',
                text: 'تم اضافة المنتج بنجاح ',
            }),
            onError: () => Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'يوجد خطأ !',
            }),
        }
    );
};

let getType = () => {
    axios.get('/findTypeByName/' + selectedType.value)
        .then(response => categories.value = response.data)
        .catch(error => console.log(error));
};

</script>
<template>
    <Head><title>products create</title></Head>
    <div class="numberCircle">1</div>
    <NavLink href="/products"> رجوع</NavLink>
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">اضافة منتج</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>الاسم</label>
                            <input v-model="form.name" type="text" name="name" class="form-control" placeholder="الاسم">
                        </div>
                        <div v-if="form.errors.name" v-text="form.errors.name" class="text-sm text-red"></div>
                    </div>
                    <div class="col-sm-6">
                        <!-- textarea -->
                        <div class="form-group">
                            <label>التفاصيل</label>
                            <textarea v-model="form.details" class="form-control" name="details" rows="3"
                                      placeholder="التفاصيل"></textarea>
                        </div>
                        <div v-if="form.errors.details" v-text="form.errors.details" class="text-sm text-red"></div>
                    </div>
                </div>
                <!-- input states -->
                <div class="form-group">
                    <!-- text input -->
                    <div class="form-group">
                        <label>السعر</label>
                        <input type="text" v-model="form.price" name="price" class="form-control" placeholder="السعر">
                    </div>
                    <div v-if="form.errors.price" v-text="form.errors.price" class="text-sm text-red"></div>
                </div>
                <div class="col">
                    <!-- radio -->
                    <div class="form-group">
                        <div class="form-check">
                            <input v-model="form.status" class="form-check-input" type="radio" :value="1" name="status">
                            <label class="form-check-label"> يوجد عرض </label>
                        </div>
                        <div class="form-check">
                            <input v-model="form.status" class="form-check-input" type="radio" :value="0" name="status">
                            <label class="form-check-label">لا يوجد عرض</label>
                        </div>
                    </div>
                    <div v-if="form.errors.status" v-text="form.errors.status" class="text-sm text-red"></div>
                </div>
                <div v-if="form.status == 1" class="form-group">
                    <!-- text input -->
                    <div class="form-group">
                        <label>السعر الجديد بعد العرض</label>
                        <input v-model="form.priceSale" type="text" name="priceSale" class="form-control"
                               placeholder="السعر الجديد بعد العرض">
                    </div>
                    <div v-if="form.errors.priceSale" v-text="form.errors.priceSale" class="text-sm text-red"></div>
                </div>
                <div class="col">
                    <!-- radio -->
                    <div class="form-group">
                        <div class="form-check">
                            <input v-model="form.has_measure" class="form-check-input" type="radio" :value="1"
                                   name="has_measure">
                            <label class="form-check-label">يوجد قياس</label>
                        </div>
                        <div class="form-check">
                            <input v-model="form.has_measure" class="form-check-input" type="radio" :value="0"
                                   name="has_measure">
                            <label class="form-check-label">لا يوجد قياس</label>
                        </div>
                        <div v-if="form.errors.has_measure" v-text="form.errors.has_measure"
                             class="text-sm text-red"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- select -->
                        <div class="form-group">
                            <label>النوع</label>
                            <select v-model="selectedType" @change="getType()" name="type_id" class="form-control">
                                <option value="0" selected disabled>اختر النوع</option>
                                <option v-for="type in types" :key="type.id" :value="type.id"> {{ type.type_name }}
                                </option>
                            </select>
                        </div>
                        <div v-if="form.errors.type_id" v-text="form.errors.type_id" class="text-sm text-red"></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>الصنف</label>
                            <select v-model="selectedCategory" name="category_id" class="form-control">
                                <option value="0" selected disabled>اختر الصنف</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.category_name }}
                                </option>
                            </select>
                        </div>
                        <div v-if="form.errors.category_id" v-text="form.errors.category_id"
                             class="text-sm text-red"></div>

                    </div>
                    <div class="col">
                        <!-- radio -->
                        <div class="form-group">
                            <div class="form-check">
                                <input v-model="form.has_name" class="form-check-input" type="radio" :value="0"
                                       name="has_name">
                                <label class="form-check-label">لا يوجد اسم</label>
                            </div>
                            <div class="form-check">
                                <input v-model="form.has_name" class="form-check-input" type="radio" :value="1"
                                       name="has_name">
                                <label class="form-check-label">اسم واحد</label>
                            </div>
                            <div class="form-check">
                                <input v-model="form.has_name" class="form-check-input" type="radio" :value="2"
                                       name="has_name">
                                <label class="form-check-label">اسمين</label>
                            </div>
                        </div>
                        <div v-if="form.errors.has_name" v-text="form.errors.has_name" class="text-sm text-red"></div>

                    </div>
                    <button type="submit" style="margin-block: 2px" class="btn btn-secondary btn-block"
                            :disabled="form.processing">موافق
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<style scoped>
.numberCircle {
    width: 80px;
    line-height: 80px;
    border-radius: 50%;
    text-align: center;
    font-size: 32px;
    border: 2px solid #666;
}
</style>

