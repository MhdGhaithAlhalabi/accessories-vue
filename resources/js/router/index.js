import { createRouter, createWebHistory } from "vue-router";
import Types from '../Pages/products/types/typeIndex.vue'

const routes = [
  {
        path: '/products/types',
        name:'Types',
        component: Types
    },

];

export default createRouter({
    history: createWebHistory(),
    routes
});
