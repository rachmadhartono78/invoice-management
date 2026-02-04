@php
$configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu " style="background: rgb(97,73,206);
background: linear-gradient(3deg, rgba(97,73,206,1) 0%, rgba(156,98,244,1) 100%); color:white;" width="70%">

  <!-- ! Hide app brand if navbar-full -->
  @if(!isset($navbarFull))
  <div class="app-brand ps-0 demo" style="height: 136px;">
    <a href="{{url('/')}}" class="app-brand-link ps-0">
      <img alt="Logo" src="{{ asset('assets/img/Logo B-MApps.png') }}" width="70%" class="ms-0" />
    </a>
  </div>
  @endif


  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @foreach ($menuData[0]->menu as $menu)

    {{-- adding active and open class if child is active --}}

    {{-- menu headers --}}
    @if (isset($menu->menuHeader))
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
    </li>

    @else

    {{-- active menu method --}}
    @php
    $activeClass = null;
    $currentRouteName = Route::currentRouteName();
    $backgroundColor = '';
    if ($currentRouteName === $menu->slug) {
        $activeClass = 'active';
        $backgroundColor = '#6049CD';
    }elseif (isset($menu->submenu)) {
      if (gettype($menu->submenu) === 'array') {
        $stringRepresentation= json_encode($menu->submenu);
        if (str_contains($stringRepresentation,  $currentRouteName)) { 
          $activeClass = 'active open';
        }
    }else{
      if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
        $activeClass = 'active open';
      }
    }

    }
    @endphp

    {{-- main menu --}}
    <li class="menu-item {{$activeClass}}" style="background-color: {{$backgroundColor}}">
      @if($menu->slug == 'pages-to-do' || $menu->slug == "pages-home")
      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }} text-white"><div class="d-flex"> <i class="{{ $menu->icon }}"></i>{{ isset($menu->name) ? __($menu->name) : '' }}</div></a>
      @else  
      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }} text-white" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
        @isset($menu->icon)
        <i class="{{ $menu->icon }}"></i>
        @endisset

        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        @isset($menu->badge)
        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
        @endisset
      </a>
      @endif

      {{-- submenu --}}
      @isset($menu->submenu)
      @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
      @endisset
    </li>
    @endif
    @endforeach
  </ul>

</aside>