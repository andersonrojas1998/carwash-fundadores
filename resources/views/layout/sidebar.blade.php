<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile not-navigation-link">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img src="{{ url('images/user1.png') }}" alt="profile image">
          </div>
          <div class="text-wrapper">
            <p class="profile-name">{{Auth::user()->name }}</p>
            <div class="dropdown" data-display="static">
              <a href="#" class="nav-link d-flex user-switch-dropdown-toggler" id="UsersettingsDropdown"  data-toggle="dropdown" aria-expanded="false">
                <small class="designation text-muted">online</small>
                <span class="status-indicator online"></span>
              </a>              
            </div>
          </div>
        </div>        
      </div>
    </li>
 @php 
 $idUser=Auth::user()->id;
 $menus=\DB::SELECT("SELECT DISTINCT(tb1.id),tb1.nombre,tb1.logo FROM system_menu as tb1
          INNER join system_menu_role as tb2  on tb1.id=tb2.id_menu
          INNER JOIN role_user as tb3 ON tb2.id_role=tb3.role_id
          where tb3.user_id='$idUser' ORDER BY tb1.nombre ASC ");
 @endphp
 
 @foreach($menus as $menu)
 <li class="nav-item {{ active_class(['basic-ui/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#{{$menu->nombre}}" aria-expanded="{{ is_active_route(['basic-ui/*']) }}" aria-controls="basic-ui">
        <i class="menu-icon {{$menu->logo}}"></i>
        <span class="menu-title">{{ $menu->nombre }}</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['basic-ui/*']) }}" id="{{$menu->nombre}}">
      @php      
        $submenus=\DB::SELECT("SELECT nombre,url,logo FROM `system_submenu` where id_menu='$menu->id' ");     
       @endphp
       @foreach($submenus as $sub)
       <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ active_class(['icons/material']) }}">            
            <a class="nav-link" href='{{ url("$sub->url") }}'><i class="menu-icon {{ $sub->logo }}"></i> {{$sub->nombre }}</a>
          </li>          
        </ul>
       @endforeach
      </div>
    </li>
 @endforeach
  </ul>
</nav>