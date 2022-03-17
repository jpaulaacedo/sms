<nav class="mt-2">

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="/dc_approval" class="nav-link {{ request()->is('/dc_approval') ? 'active' : '' }}">
        <i class="nav-icon fa fa-thumbs-up"></i>
        <p style="position:absolute;width:75%;margin-left:5px">
          <span style="float: left;"> To Approve</span>
          <span style="float: right;margin-top:0.35em" class="badge badge-danger">2</span>
        </p>
      </a>
    </li>
  </ul>

  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="/messengerial" class="nav-link {{ request()->is('/DC_messengerial') ? 'active' : '' }}">
        <i class="nav-icon fa fa-envelope"></i>
        <p style="position:absolute;width:75%;margin-left:5px">
          <span style="float: left;"> Messengerial</span>
          <span style="float: right;margin-top:0.35em" class="badge badge-danger">2</span>
        </p>
      </a>
    </li>
  </ul>

  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="/vehicle" class="nav-link {{ request()->is('/DC_vehicle') ? 'active' : '' }}">
        <i class="nav-icon fa fa-truck"></i>
        <p style="position:absolute;width:75%;margin-left:5px">
          <span style="float: left;"> Vehicle</span>
          <span style="float: right;margin-top:0.35em" class="badge badge-danger">5</span>
        </p>
      </a>
    </li>
  </ul>

  <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Log Out</p>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>
  </ul>
</nav>