<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user-id" content="{{ Auth::user()->id }}" />

  <title>Admin Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper" id="app">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="{{asset('assets/admin/default/logo.png')}}"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/admin/default/admin.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <router-link to="/home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
               <p>Dashboard</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/category-list" class="nav-link">
                <i class="nav-icon fa fa-th"></i>
                <p>
                  Category
                </p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/post-list" class="nav-link">
              <i class="nav-icon fas fa-thumbtack"></i>
               <p>Posts</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/all-media" class="nav-link">
              <i class="nav-icon fas fa-photo-video"></i>
               <p>Media</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/post-list" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
               <p>Pages</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/post-list" class="nav-link">
              <i class="nav-icon fas fa-comments"></i>
               <p>Comments</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/tags" class="nav-link">
               <i class="nav-icon fa fa-tags"></i>
               <p>Tags</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/post-list" class="nav-link">
               <i class="nav-icon fa fa-users"></i>
               <p>Users</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/post-list" class="nav-link">
               <i class="nav-icon fa fa-cog"></i>
               <p>Setting</p>
            </router-link>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Blank Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

      <!-- Content Header (Page header) -->
          <admin-main></admin-main>

  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0-alpha
    </div>
    <strong>Copyright &copy; 2014-2018 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
