<template>

    <div class="card card-secondary" style="direction: rtl">
        <div class="card-header">
            <h3 class="card-title">اضافة نوع</h3>
        </div>
        <div v-if="$page.props.flash.message" class="text-sm text-green">
            {{ $page.props.flash.message }}
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <label for="type_name">الاسم</label>
                        <label>
                            <input v-model="form.type_name" type="text" name="type_name" class="form-control"
                                   placeholder="الاسم" required>
                        </label>
                        <div v-if="form.errors.type_name" v-text="form.errors.type_name" class="text-sm text-red"></div>
                    </div>

                    <button type="submit" class="btn btn-secondary btn-block" :disabled="form.processing">موافق</button>
                </form>

            </div>
        </div>
    </div>

</template>
<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2';

let form = useForm({
    type_name: '',
});
let submit = () => {
    form.post('/products/types/create', {
            onSuccess: () => Swal.fire({
                icon: 'success',
                title: 'success',
                text: 'تم اضافة النوع بنجاح ',
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




