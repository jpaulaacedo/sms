<nav class="mt-2">

  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <li class="nav-item">
      <a href="{{ URL::to('/budget_mngt') }}" class="nav-link {{ request()->is('budget_mngt') ? 'active' : '' }}">
        <i class="fa fa-wallet nav-icon"></i>
        <p>Budget Management</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ URL::to('/ap_ar') }}" class="nav-link {{ request()->is('ap_ar') ? 'active' : '' }}">
        <i class="fa fa-receipt nav-icon"></i>
        <p>AP/AR</p>
      </a>
      <ul class="nav nav-treeview" style="display: block;">
        <li class="nav-item">
          <a href="{{ URL::to('/ap') }}" class="nav-link {{ request()->is('ap') ? 'active' : '' }}">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <i class="fa fa-file-invoice nav-icon"></i>
            <p style="position:absolute;width:65%;">
              <span style="float: left;"> AP</span>
              <span style="float: right;margin-top:0.35em" class="badge badge-danger"></span>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ URL::to('/ar') }}" class="nav-link {{ request()->is('ar') ? 'active' : '' }}">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <i class="fa fa-file-invoice nav-icon"></i>
            <p style="position:absolute;width:65%;">
              <span style="float: left;"> AR</span>
              <span style="float: right;margin-top:0.35em" class="badge badge-danger"></span>
            </p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="{{ URL::to('/disbursement') }}" class="nav-link {{ request()->is('disbursement') ? 'active' : '' }}">
        <i class="fa fa-comments-dollar nav-icon"></i>
        <p>Disbursement</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ URL::to('/collection') }}" class="nav-link {{ request()->is('collection') ? 'active' : '' }}">
        <i class="fa fa-folder-open nav-icon"></i>
        <p>Collection</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ URL::to('/general_ledger') }}" class="nav-link {{ request()->is('general_ledger') ? 'active' : '' }}">
        <i class="fa fa-chart-pie nav-icon"></i>
        <p>General Ledger</p>
      </a>
    </li>
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