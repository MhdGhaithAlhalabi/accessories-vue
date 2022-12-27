<template>

    <div class="wrapper">
        <!-- Preloader -->
        <!-- Navbar -->
        <nav-bar></nav-bar>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <SideBar></SideBar>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#"></a></li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <div class="container-fluid">
            <div  style="margin-right: 5%;margin-left: 5%;">
                <slot />
                </div>
            </div>

            <!-- /.content -->
        </div>

        <!-- /.content-wrapper -->
        <footer></footer>


    </div>
    <!-- ./wrapper -->

</template>
<script>
import SideBar from "../layout/SideBar.vue";
import NavBar from "../layout/NavBar.vue";
export default {
    components: {  NavBar, SideBar}
}
</script>
