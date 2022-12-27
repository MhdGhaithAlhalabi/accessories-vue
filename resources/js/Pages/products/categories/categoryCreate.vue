<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2';
import {ref} from "vue";
defineProps(
    {
        types: Object,
    }
)
const selectedType = ref(null);
let form = useForm({
    category_name: '',
    type_id: selectedType,
    category_image: '',
});
let submit = () => {
    form.post('/products/categories/create', {
            onSuccess: () => Swal.fire({
                icon: 'success',
                title: 'success',
                text: 'تم اضافة الصنف بنجاح ',
            }),
            onError: () => Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'يوجد خطأ !',
            }),
        }
    );
};

</script>
<template>
    <div class="card card-secondary" style="direction: rtl">
        <div class="card-header">
            <h3 class="card-title">اضافة صنف</h3>
        </div>
        <div v-if="$page.props.flash.message" class="text-sm text-green">
            {{ $page.props.flash.message }}
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <div>
                            <label for="type_name">الاسم</label>
                            <label>
                                <input v-model="form.category_name" type="text" name="category_name"
                                       class="form-control" placeholder="الاسم" required>
                            </label>
                            <div v-if="form.errors.category_name" v-text="form.errors.category_name"
                                 class="text-sm text-red"></div>
                        </div>
                        <div>
                            <label for="type_id">النوع</label>
                            <select v-model="selectedType" name="type_id" class="form-control" id="type_id">
                                <option :value="null" selected disabled>اختر النوع</option>
                                <option v-for="type in types" :key="type.id"
                                        :value="type.id">{{ type.type_name }}
                                </option>
                            </select>
                            <div v-if="form.errors.type_id" v-text="form.errors.type_id" class="text-sm text-red"></div>
                        </div>
                        <div>
                            <label for="category_image">الصورة</label>
                            <label>
                                <input type="file" @input="form.category_image = $event.target.files[0]"/>
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                                <!--
                                                        <input v-model="form.category_image" type="file" name="image" class="form-control" >
                                -->
                            </label>
                            <div v-if="form.errors.category_image" v-text="form.errors.category_image"
                                 class="text-sm text-red"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-block" :disabled="form.processing">موافق</button>
                </form>

            </div>
        </div>
    </div>

</template>





