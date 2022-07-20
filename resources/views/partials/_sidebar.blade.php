<nav class="mt-2">

  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <li class="nav-item">
      <a href="{{ URL::to('/home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">

        <i class="fa fa-calendar nav-icon"></i>
        <p>Calendar</p>
      </a>
    </li>

    <!-- DC FOR MY APPROVAL   -->
    @if (Auth::user()->user_type == 2)
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link {{ request()->is('messengerial/dc/approval') ? 'active' : '' }} {{ request()->is('vehicle/dc/approval') ? 'active' : '' }}">
          <i class="nav-icon fa fa-thumbs-up"></i>
          <p>
            For My Approval
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview" style="display: block;">
          <li class="nav-item">
            <a href="{{ URL::to('/messengerial/dc/approval') }}" class="nav-link {{ request()->is('messengerial/dc/approval') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-envelope nav-icon"></i>
              <p style="position:absolute;width:65%;">
                <span style="float: left;"> Messengerial</span>
                <span style="float: right;margin-top:0.35em" class="badge badge-danger">{{App\Messengerial::dc_messengerial()}}</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('/vehicle/dc/approval') }}" class="nav-link {{ request()->is('vehicle/dc/approval') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-truck nav-icon"></i>
              <p style="position:absolute;width:65%;">
                <span style="float: left;"> Vehicle</span>
                <span style="float: right;margin-top:0.35em" class="badge badge-danger">{{App\Vehicle::dc_vehicle()}}</span>
              </p>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    @endif
    <!-- ED DC FOR APPROVAL -->
    @if (Auth::user()->user_type == 4)
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link {{ request()->is('messengerial/all') ? 'active' : '' }} {{ request()->is('vehicle/all') ? 'active' : '' }}"">
          <i class=" nav-icon fa fa-thumbs-up"></i>
          <p>
            All Requests
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview" style="display: block;">
          <li class="nav-item">
            <a href="{{ URL::to('/messengerial/all') }}" class="nav-link {{ request()->is('messengerial/all') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-envelope nav-icon"></i>
              <p>Messengerial</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('/vehicle/all') }}" class="nav-link {{ request()->is('vehicle/all') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-truck nav-icon"></i>
              <p>Vehicle</p>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    @endif

    <!-- //CAO APPROVAL -->
    @if (Auth::user()->user_type == 6)
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link {{ request()->is('messengerial/cao/approval') ? 'active' : '' }} {{ request()->is('vehicle/cao/approval') ? 'active' : '' }}">
          <i class="nav-icon fa fa-thumbs-up"></i>
          <p>
            For My Approval
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview" style="display: block;">
          <li class="nav-item">
            <a href="{{ URL::to('/messengerial/cao/approval') }}" class="nav-link {{ request()->is('messengerial/cao/approval') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-envelope nav-icon"></i>
              <p style="position:absolute;width:65%;">
                <span style="float: left;"> Messengerial</span>
                <span style="float: right;margin-top:0.35em" class="badge badge-danger">{{App\Messengerial::cao_messengerial()}}</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('/vehicle/cao/approval') }}" class="nav-link {{ request()->is('vehicle/cao/approval') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-truck nav-icon"></i>
              <p style="position:absolute;width:65%;">
                <span style="float: left;"> Vehicle</span>
                <span style="float: right;margin-top:0.35em" class="badge badge-danger">{{App\Vehicle::cao_vehicle()}}</span>
              </p>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    @endif


    <!-- TO ACCOMPLISH -->
    @if (Auth::user()->user_type == 3)
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link {{ request()->is('vehicle/accomplish') ? 'active' : '' }} {{ request()->is('messengerial/accomplish') ? 'active' : '' }}">
          <i class="nav-icon fa fa-clipboard-list"></i>
          <p>
            To Accomplish
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview" style="display: block;">
          <li class="nav-item">
            <a href="{{ URL::to('/messengerial/accomplish') }}" class="nav-link {{ request()->is('messengerial/accomplish') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="nav-icon fa fa-envelope"></i>
              <p style="position:absolute;width:65%;">
                <span style="float: left;"> Messengerial</span>
                <span style="float: right;margin-top:0.35em" class="badge badge-danger">{{App\Messengerial::agent_messengerial()}}</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('/vehicle/accomplish') }}" class="nav-link {{ request()->is('vehicle/accomplish') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-truck nav-icon"></i>
              <p style="position:absolute;width:65%;">
                <span style="float: left;"> Vehicle</span>
                <span style="float: right;margin-top:0.35em" class="badge badge-danger">{{App\Vehicle::agent_vehicle()}}</span>
              </p>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    @endif

    <!--ALL MESSENGERIAL-->
    @if (Auth::user()->user_type == 5)
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link {{ request()->is('messengerial/all') ? 'active' : '' }} {{ request()->is('vehicle/all') ? 'active' : '' }}"">
          <i class=" nav-icon fa fa-thumbs-up"></i>
          <p>
            All Requests
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview" style="display: block;">
          <li class="nav-item">
            <a href="{{ URL::to('/messengerial/all') }}" class="nav-link {{ request()->is('messengerial/all') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="nav-icon fa fa-envelope"></i>
              <p style="position:absolute;width:65%;">
                <span style="float: left;"> Messengerial</span>
                <span style="float: right;margin-top:0.35em" class="badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('/vehicle/all') }}" class="nav-link {{ request()->is('vehicle/all') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-truck nav-icon"></i>
              <p>Vehicle</p>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    @endif

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link {{ request()->is('messengerial') ? 'active' : '' }} {{ request()->is('vehicle') ? 'active' : '' }}">
          <i class="nav-icon fa fa-file-import"></i>
          <p>
            My Requests
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview" style="display: block;">
          <li class="nav-item">
            <a href="{{ URL::to('messengerial') }}" class="nav-link {{ request()->is('messengerial') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="nav-icon fa fa-envelope"></i>
              <p style="position:absolute;width:65%;">
                <span style="float: left;"> Messengerial</span>
                <span style="float: right;margin-top:0.35em" class="badge badge-danger">{{App\Messengerial::staff_messengerial()}}</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('vehicle') }}" class="nav-link {{ request()->is('vehicle') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-truck nav-icon"></i>
              <p style="position:absolute;width:65%;">
                <span style="float: left;"> Vehicle</span>
                <span style="float: right;margin-top:0.35em" class="badge badge-danger">{{App\Vehicle::staff_vehicle()}}</span>
              </p>
            </a>
          </li>
        </ul>
    </ul>

    <!--REPORTS-->
    @if (Auth::user()->user_type == 3)
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link {{ request()->is('messengerial/report') ? 'active' : '' }} {{ request()->is('vehicle/report') ? 'active' : '' }}">
          <i class="nav-icon fa fa-folder-open"></i>
          <p>
            Reports
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview" style="display: block;">
          <li class="nav-item">
            <a href="{{ URL::to('/messengerial/report') }}" class="nav-link {{ request()->is('messengerial/report') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-envelope nav-icon"></i>
              <p>Messengerial</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ URL::to('/vehicle/report') }}" class="nav-link {{ request()->is('vehicle/report') ? 'active' : '' }}">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <i class="fa fa-truck nav-icon"></i>
              <p>Vehicle</p>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    @endif

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