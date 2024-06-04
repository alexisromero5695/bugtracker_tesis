
@php
    $MenuString = Session::get('menu');
    $Menu = json_decode($MenuString);
@endphp

<div class="nk-sidebar nk-sidebar-fixed is-soluciones " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
        <div class="nk-sidebar-brand">
            <a href="/inicio/1" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="/images/logo-bugtracker-negativo-total.svg" srcset="/images/logo-bugtracker-negativo-total.svg 2x" style="max-width: 12rem;" alt="logo">
                <img class="logo-dark logo-img" src="/images/logo-bugtracker-negativo.svg" srcset="/images/logo-bugtracker-negativo.svg 2x" style="max-width: 12rem;" alt="logo-dark">
            </a>
        </div>
    </div>
    <div class="">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    @if(Session::get('id_perfil') == "" && isset($Menu->menu))
                        @foreach ($Menu->menu as $menu)
                            @if(!isset($menu->submenu))      
                                <li class="nk-menu-item {{ request()->is('sites/*/edit') ? 'active' : '' }}">                        
                                    <a href="<?php echo ( $menu->url != "" && $menu->url != null) ? "/".$menu->url."/".$menu->id_modulo : "javascript:void(0)"?>" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon {{$menu->icono}}"></em></span>
                                        <span class="nk-menu-text">{{$menu->nombre }}</span>
                                    </a>     
                                </li>            
                            @else
                                <li class="nk-menu-item has-sub {{ request()->is('sites/*/edit') ? 'active' : '' }}">
                                    <a href="<?php echo ( $menu->url != "" && $menu->url != null) ? "/".$menu->url."/".$menu->id_modulo : "javascript:void(0)"?>" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon"><em class="icon {{$menu->icono}}"></em></span><span class="nk-menu-text">{{$menu->nombre }}</span></a>                                     
                                    @include('pages.sidebar-submenu',['menu'=>$menu->submenu])                                          
                                </li>
                            @endif
                        @endforeach
                    @endif         
                </ul>
            </div>
        </div>
    </div>
</div> 

