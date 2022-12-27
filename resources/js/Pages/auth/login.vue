<script>
export default {
    layout: null,
};

</script>
<script setup>
import {useForm} from "@inertiajs/inertia-vue3";

let form = useForm({
    email: '',
    password: ''
});
let submit = () => {
    form.post('/login');
};
</script>
<template>
    <Head title="Login"/>
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="/public" class="h1"><b>Admin</b>Accessories</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">سجل دخول لبدء الجلسة</p>

                    <form @submit.prevent="submit">
                        <div class="input-group mb-3">
                            <input v-model="form.email" type="email" name="email" class="form-control"
                                   placeholder="البريد الالكتروني" required/>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <div v-if="form.errors.email" v-text="form.errors.email" class="text-sm text-red"></div>
                        </div>


                        <div class="input-group mb-3">
                            <input v-model="form.password" type="password" name="password" class="form-control"
                                   placeholder="كلمة المرور" required/>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div v-if="form.errors.password" v-text="form.errors.password"
                                 class="text-sm text-red"></div>
                        </div>

                        <div class="row">

                            <!-- /.col -->
                            <div style="flex: auto;">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="form.processing">
                                    تسجيل الدخول
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</template>

