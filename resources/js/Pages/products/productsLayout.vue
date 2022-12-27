<script setup>
import {ref} from "vue";
import Model from "../../components/Model.vue";
import TypeCreate from "./types/typeCreate.vue";
import NavLink from "../../Shared/NavLink.vue";
import CategoryCreate from "./categories/categoryCreate.vue";
defineProps({
    types: Object,
    categories: Object,
});
let showModal1 = ref(false);
let showModal2 = ref(false);
</script>

<template>
    <Head title="products"/>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <NavLink href="/products" :active="$page.url === '/products'">
                    المنتجات
                </NavLink>
            </li>
            <li class="nav-item">
                <NavLink href="/products/types" :active="$page.url.startsWith('/products/types')">
                    الانواع
                </NavLink>
            </li>
            <li class="nav-item">
                <NavLink href="/products/categories" :active="$page.url.startsWith('/products/categories')">
                    الاصناف
                </NavLink>
            </li>
            <li class="nav-item">
                <NavLink href="/products/create" :active="$page.url === '/products/create'">
                    منتج جديد
                </NavLink>
            </li>
            <li class="nav-item">
                <a class="nav-link" role="button" @click="showModal1 = true"> نوع جديد </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" role="button" @click="showModal2 = true"> صنف جديد </a>
            </li>
        </ul>
    </nav>
<Teleport to="body">
    <Model :show="showModal1" @close="showModal1 = false">
        <template #default>
            <p>انشاء نوع جديد </p>
            <form class="mt-6">
                <div class="flex gap-2">
                    <TypeCreate/>
                </div>
            </form>
        </template>
    </Model>
    <Model :show="showModal2" @close="showModal2 = false">
        <template #default>
            <p>انشاء صنف جديد </p>
            <CategoryCreate :types="types"/>
        </template>
    </Model>
</Teleport>
    <slot/>
</template>
