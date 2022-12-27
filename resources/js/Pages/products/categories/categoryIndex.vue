<script setup>
import ProductsLayout from "../productsLayout.vue";
import { useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
let form = useForm();

defineProps({
    types: Object,
    categories: Object
});
const deleteCategory = (id)=>{
  return new  Swal({
            title: "هل انت متأكد ؟",
            text: "هل انت متأكد انك تريد حذف الصنف عند الحذف سوف يتم حذف المنتجات المرتبطة به",
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
                form.delete("/category/delete/"+ id);
            }

        }
    );

}
</script>
<template>
    <Head>
        <title>category</title>
    </Head>
    <ProductsLayout :types="types">
        <table class="table table-dark table-striped">
            <thead>
            <tr>
                <th>
                    الاسم
                </th>

                <th>
                    التاريخ
                </th>
                <th>
                    النوع
                </th>
                <th>
                    الصورة
                </th>
                <th>
                    تعديل\حذف
                </th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="category in categories.data" :key="category.id">
                <td>
                    <span>  {{ category.category_name }}</span>
                </td>

                <td>
                    <span> {{ category.created_at }}</span>
                </td>
                <td>
                    <span> {{ category.type.type_name }}</span>
                </td>

                <td>
                    <img :src="`/storage/categories_images/${category.category_image}`" alt="image" style="width: 200px" class="img-fluid img-thumbnail" >
                </td>
                <td>
                    <button type="button" class="btn btn-light flex-fill me-1"
                            data-mdb-ripple-color="dark">
                        تعديل
                    </button>
                    <button @click="deleteCategory(category.id)" type="button" class="btn btn-dark flex-fill ms-1">حذف</button>
                </td>
            </tr>
            </tbody>
        </table>


        <div v-if="categories.links.length > 3" class="flex justify-center mt-4 space-x-4">
            <Component
                :is="link.url ? 'Link' : 'span'"
                v-for="link in categories.links"
                :href="link.url"
                v-html="link.label"
                class="px-4 py-3 text-sm leading-4 bg-white rounded hover:bg-white focus:text-indigo-500 hover:shadow"
                :class="{'bg-indigo-400 text-white font-weight-bold': link.active }"
                preserve-scroll
            />
        </div>
    </ProductsLayout>
</template>



