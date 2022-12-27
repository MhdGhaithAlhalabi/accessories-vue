<template>

    <div class="wrapper">

        <!-- Preloader -->
        <preloader></preloader>
        <!-- Navbar -->
        <nav-bar></nav-bar>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <SideBar></SideBar>

        <!-- Content Wrapper. Contains page content -->
        <content></content>
        <!-- /.content-wrapper -->
        <footer></footer>


    </div>
    <!-- ./wrapper -->

</template>
<script>
import SideBar from "@/layout/SideBar.vue";
import NavBar from "@/layout/NavBar.vue";
import Preloader from "@/Shared/Preloader.vue";
import Content from "@/Shared/content.vue";

export default {
    components: {Content, Preloader, NavBar, SideBar}
}
</script>
