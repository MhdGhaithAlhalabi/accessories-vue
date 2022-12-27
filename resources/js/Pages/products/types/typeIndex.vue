<script setup>
import ProductsLayout from "../productsLayout.vue";
import { useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
let form = useForm();

defineProps({
    types: Object,
    types2:Object
});
const deleteType = (id)=>{
    return new  Swal({
        title: "هل انت متأكد ؟",
        text: "هل انت متأكد انك تريد حذف النوع عند الحذف سوف يتم حذف الاصناف المرتبطة به والمنتجات المرتبطة بهذه الاصناف",
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
                form.delete("/type/delete/"+ id);
            }

        }
    );

}
</script>
<template>
    <Head>
        <title>types</title>
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
                    تعديل\حذف
                </th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="type in types2.data" :key="type.id">
                <td>
                    <span>  {{ type.type_name }}</span>
                </td>

                <td>
                    <span> {{ type.created_at }}</span>
                </td>

                <td>
                    <button type="button" class="btn btn-light flex-fill me-1"
                            data-mdb-ripple-color="dark">
                        تعديل
                    </button>
                    <button @click="deleteType(type.id)" type="button" class="btn btn-dark flex-fill ms-1">حذف</button>
                </td>
            </tr>
            </tbody>
        </table>


        <div v-if="types2.links.length > 3" class="flex justify-center mt-4 space-x-4">
            <Component
                :is="link.url ? 'Link' : 'span'"
                v-for="link in types2.links"
                :href="link.url"
                v-html="link.label"
                class="px-2 py-1 text-sm leading-4 bg-white rounded hover:bg-white focus:text-indigo-500 hover:shadow"
                :class="{'bg-indigo-400 text-white font-weight-bold': link.active }"
                preserve-scroll
            />
        </div>

    </ProductsLayout>
</template>



