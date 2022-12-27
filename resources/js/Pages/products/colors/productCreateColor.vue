<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2';
const props = defineProps({
    product: Object,
});
let form = useForm({
    color: '',
    color_hex: '',
    product_id: props.product.id,
});

let submit = () => {
    form.post('/product/color/create', {
            onSuccess: () => Swal.fire({
                icon: 'success',
                title: 'success',
                text: 'تم اضافة اللون بنجاح ',
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
    <Head title="colorCreate"/>


اضافة لون جديد لمنتج من شوي ضفتو {{ product.name  }}

    <div class="card card-secondary" style="direction: rtl">
        <div class="card-header">
            <h3 class="card-title">اضافة لون</h3>
        </div>
        <div v-if="$page.props.flash.message" class="text-sm text-green">
            {{ $page.props.flash.message }}
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <label for="type_name">اللون</label>
                        <label>
                            <input v-model="form.color" type="text" name="color" class="form-control"
                                   placeholder="الاسم" required>
                        </label>
                        <div v-if="form.errors.color" v-text="form.errors.color" class="text-sm text-red"></div>
                    </div>
                    <div class="form-group">
                            <div class="color-picker" style="direction: ltr"></div>
                    </div>
                    <div class="form-group">
                        <label for="type_name">اللون ارقام</label>
                        <label>
                            <input v-model="form.color_hex" type="color" name="color_hex" required>
                        </label>
                        <div v-if="form.errors.color_hex" v-text="form.errors.color_hex" class="text-sm text-red"></div>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-block" :disabled="form.processing">موافق</button>
                </form>

            </div>
        </div>
    </div>



</template>





