<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->

  <a href="index3.html" class="brand-link">

    <?php
      $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
    ?>

    <img
      src="<?php if( $campus->Logo_photo_path){ echo asset('CampusLogos/' . $campus->Logo_photo_path); }else{ echo asset('userbackend/dist/img/AdminLTELogo.png'); } ?>"
      alt="" class="brand-image img-circle elevation-3" style="opacity: .8">

    <span class="brand-text font-weight-light">{{ $campus->CampusName }}</span>

  </a>



  <!-- Sidebar -->

  <div class="sidebar">

    <!-- Sidebar user panel (optional) -->

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">

      <div class="image">

        <img src="{{ asset('userbackend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">

      </div>

      <div class="info">

        <a href="#" class="d-block">{{ Auth::user()->name}}</a>

      </div>

    </div>



    <!-- SidebarSearch Form -->

    {{-- <div class="form-inline">

      <div class="input-group" data-widget="sidebar-search">

        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">

        <div class="input-group-append">

          <button class="btn btn-sidebar">

            <i class="fas fa-search fa-fw"></i>

          </button>

        </div>

      </div>

    </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column"
      data-widget="treeview" role="menu" data-accordion="false">
        <?php
        $campusid= Auth::user()->roleid;
         $roleid = Auth::user()->roleid;
        // dd($roleid);
      // $authId = Auth::User()->roleid;
      //  $a=$request->path();

$menuItemshead = DB::select("SELECT distinct page_head FROM pages p ,
role_pages r where r.campusid='$campusid' and role_id='$roleid'
and r.campusid=p.campusid
and p.page_id=r.pages_id");
   foreach ($menuItemshead  as  $value1) {

 ?>
        <li class="nav-item ">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>
              {{$value1->page_head}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <?php
            $ph=$value1->page_head;
            $menuItems = DB::select("SELECT * FROM pages p ,
             role_pages r where r.campusid='$campusid' and role_id='$roleid'
                and r.campusid=p.campusid
                and p.page_id=r.pages_id and page_head='$ph'");
   foreach ($menuItems  as  $value) {?>

            <li class="nav-item">
              <a href="{{ url($value->page_link) }}"
                class="nav-link {{(request()->is('admin/AddCampus')) ? 'active' : ''}}">
                <i class="far fa-circle nav-icon active"></i>
                <p>{{   $value->page_title }}</p>
              </a>
            </li>
            <?php } ?>
                   </ul> </li>

      <?php }  ?>
      </ul>

    </nav>

    <!-- /.sidebar-menu -->

  </div>

  <!-- /.sidebar -->

</aside>
