<script setup>
import {ref} from "vue";
import Model from "../../../components/Model.vue";
import ProductCreateColor from "./productCreateColor.vue";
let showModal1 = ref(false);
defineProps({
        product: Object,
        colors: Object,
    }
)
</script>
<template>
    <Head title="colors"/>
    <div class="numberCircle">2</div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" role="button" @click="showModal1 = true"> الوان جديدة </a>
            </li>
        </ul>
    </nav>

    <Model :show="showModal1" @close="showModal1 = false">
        <template #default>
            <p>انشاء الوان جديد </p>
            <form class="mt-6">
                <div class="flex gap-2">
                    <ProductCreateColor :product="product" />
                </div>
            </form>
        </template>
    </Model>



    الوان هذا المنتج :

    <table class="table table-dark table-striped">
        <thead>
        <tr>
            <th>
                اللون
            </th>

            <th>
                اللون بالهيكس
            </th>


            <th>
                تعديل\حذف
            </th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="color in colors.data" :key="color.id">
            <td>
                <span>  {{ color.color }}</span>
            </td>


            <td>
                <span> {{ color.color_hex }}</span>
            </td>

            <td>
                تعديل حذف
            </td>
        </tr>
        </tbody>
    </table>


    <div v-if="colors.links.length > 3" class="flex justify-center mt-4 space-x-4">
        <Component
            :is="link.url ? 'Link' : 'span'"
            v-for="link in colors.links"
            :href="link.url"
            v-html="link.label"
            class="px-2 py-1 text-sm leading-4 bg-white rounded hover:bg-white focus:text-indigo-500 hover:shadow"
            :class="{'bg-indigo-400 text-white font-weight-bold': link.active }"
            preserve-scroll
        />
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
