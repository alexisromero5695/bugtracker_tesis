<ul class="nk-menu-sub" style="display: none;">
    @if(isset($menu))
        @foreach ($menu as $submenu)
             @if(!isset($submenu->submenu))      
            <li class="nk-menu-item">                           
                <a href="<?php echo ( $submenu->url != "" && $submenu->url != null) ? "/".$submenu->url."/".$submenu->id_modulo : "javascript:void(0)"?>" class="nk-menu-link">
                    <span class="nk-menu-icon"><em class="icon {{$submenu->icono}}"></em></span>
                    <span class="nk-menu-text">{{$submenu->nombre }}</span>
                </a>     
            </li>            
            @else
            <li class="nk-menu-item has-sub {{ request()->is('sites/*/edit') ? 'active' : '' }}">
                <a href="<?php echo ( $submenu->url != "" && $submenu->url != null) ? "/".$submenu->url."/".$submenu->id_modulo : "javascript:void(0)"?>" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-icon"><em class="icon {{$submenu->icono}}"></em></span><span class="nk-menu-text">{{$submenu->nombre }}</span></a>                                     
                @include('pages.sidebar-submenu',['menu'=>$submenu->submenu])                                          
            </li>
            @endif
        @endforeach
    @endif
</ul>