<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2';
const props = defineProps({
    color: Object,
});
let form = useForm({
    color_id: props.color.id,
    url: '',
});

let submit = () => {
    form.post('/products/images/create', {
            onSuccess: () => Swal.fire({
                icon: 'success',
                title: 'success',
                text: 'تم اضافة الصورة بنجاح ',
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


    اضافة لون جديد للون  {{ color.color  }}

    <div class="card card-secondary" style="direction: rtl">
        <div class="card-header">
            <h3 class="card-title">اضافة صورة</h3>
        </div>
        <div v-if="$page.props.flash.message" class="text-sm text-green">
            {{ $page.props.flash.message }}
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <label for="type_name">الصورة</label>
                        <label>
                            <input type="file" @input="form.url = $event.target.files[0]" required/>
                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress>
                        </label>
                        <div v-if="form.errors.url" v-text="form.errors.url"
                             class="text-sm text-red"></div>                    </div>


                    <button type="submit" class="btn btn-secondary btn-block" :disabled="form.processing">موافق</button>
                </form>

            </div>
        </div>
    </div>

</template>





