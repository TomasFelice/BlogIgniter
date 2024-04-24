<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url() ?>assets/img/logo.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Nombre</p>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                    <li><a href="../../index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Post</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>admin/post_save"><i class="fa fa-circle-o"></i> Crear</a></li>
                    <li><a href="<?php echo base_url() ?>admin/post_list"><i class="fa fa-circle-o"></i> Listar</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span>Categorías</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>admin/category_save"><i class="fa fa-circle-o"></i> Crear</a></li>
                    <li><a href="<?php echo base_url() ?>admin/category_list"><i class="fa fa-circle-o"></i> Listar</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>