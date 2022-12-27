<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <Link href="/" class="brand-link">
            <img src="/assets/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">

            <span class="brand-text font-weight-light">Accessories</span>
        </Link>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">

                    <img src="/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

                </div>
                <div class="info">
                    <Link href="/" class="d-block">{{ username }}</Link>
                </div>
            </div>
            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="البحث"
                           aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <NavLink href="/" :active="$page.component === 'dashboard'">
                            <slot name="ico"><i class="nav-icon fas fa-tachometer-alt"></i></slot>
                            الرئيسية
                        </NavLink>
                    </li>
                    <li class="nav-item">
                        <NavLink href="/customers" :active="$page.component === 'customers'">
                            <slot name="ico"><i class="nav-icon fa fa-address-card" aria-hidden="true"></i>
                            </slot>
                            الزبائن
                        </NavLink>
                    </li>
                    <li class="nav-item">
                        <NavLink href="/products" :active="$page.url.startsWith('/products')">
                            <slot name="ico">
                                <i class="nav-icon fas fa-th"></i>
                            </slot>
                            المنتجات
                        </NavLink>
                    </li>
                    <li class="nav-item">
                        <NavLink href="/menu" :active="$page.component === 'menu'">
                            <slot name="ico">
                                <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>

                            </slot>
                            المنتجات اليومية
                        </NavLink>
                    </li>
                    <li class="nav-item">
                        <NavLink href="/feedback" :active="$page.component === 'feedback'">
                            <slot name="ico">
                                <i class="nav-icon fa fa-paper-plane" aria-hidden="true"></i>

                            </slot>
                            رسائل التواصل
                        </NavLink>
                    </li>
                    <li class="nav-item">
                        <NavLink href="/" :active="$page.component === ''">
                            <slot name="ico">
                                <i class="nav-icon fas fa-chart-pie"></i>
                            </slot>
                            الاحصائيات
                        </NavLink>
                    </li>
                    <footer style="bottom: 0;position:fixed;">
                        <li class="nav-item">
                            <NavLink href="/logout"  method="post" >
                                <slot name="ico">
                                    <i class="nav-icon fa fa-sign-out"></i>
                                </slot>
                                تسجيل الخروج
                            </NavLink>
                        </li>
                    </footer>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>
<script>
import NavLink from "../Shared/NavLink.vue";
export default {
    components: {NavLink},
    computed: {
        username() {
            return this.$page.props.auth.user.username;
        }
    }
}
</script>
