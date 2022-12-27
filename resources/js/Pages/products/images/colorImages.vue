<script setup>
import {ref} from "vue";
import Model from "../../../components/Model.vue";
import ImageCreate from "./imageCreate.vue";
let showModal1 = ref(false);
defineProps({
  color: Object,
  images: Object,
    }
)
</script>
<template>
  <Head title="images"/>
    <div class="numberCircle">3</div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link" role="button" @click="showModal1 = true"> صور جديدة </a>
      </li>
    </ul>
  </nav>

  <Model :show="showModal1" @close="showModal1 = false">
    <template #default>
      <p>انشاء صور جديد </p>
      <form class="mt-6">
        <div class="flex gap-2">
          <ImageCreate :color="color" />
        </div>
      </form>
    </template>
  </Model>



  صور هذا اللون :

  <table class="table table-dark table-striped">
    <thead>
    <tr>
      <th>
        اللون
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
    <tr v-for="image in images.data" :key="image.id">
      <td>
        <span>  {{ color.color }}</span>
      </td>


      <td>
          <img :src="`/storage/color_images/${image.url}`" alt="image" style="width: 200px" class="img-fluid img-thumbnail" >
      </td>

      <td>
        تعديل حذف
      </td>
    </tr>
    </tbody>
  </table>


  <div v-if="images.links.length > 3" class="flex justify-center mt-4 space-x-4">
    <Component
        :is="link.url ? 'Link' : 'span'"
        v-for="link in images.links"
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


