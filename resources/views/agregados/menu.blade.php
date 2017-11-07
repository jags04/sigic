<ul class="page-sidebar-menu  page-header-fixed  page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
    <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
            <span></span>
        </div>
    </li>
    <!-- END SIDEBAR TOGGLER BUTTON -->
    <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element
    <li class="sidebar-search-wrapper">
        <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box
    <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
        <a href="javascript:;" class="remove">
            <i class="icon-close"></i>
        </a>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                        <a href="javascript:;" class="btn submit">
                            <i class="icon-magnifier"></i>
                        </a>
                    </span>
        </div>
    </form>
    <!-- END RESPONSIVE QUICK SEARCH FORM
</li>-->
    <li class="nav-item start @if(empty(Request::segment(1))) active open @endif">
        <a href="{{ URL::to('/') }}" class="nav-link nav-toggle">
            <i class="icon-home"></i>
            <span class="title">Inicio</span>
            @if(empty(Request::segment(1)))
                <span class="selected"></span>
            @endif
        </a>
    </li>
    <!--<li class="heading">
        <h3 class="uppercase">Features</h3>
    </li>-->
    <li class="nav-item @if( Request::segment(1) == 'mapas' ) active open @endif">
        <a href="{{ route('sistema.mapas') }}" class="nav-link nav-toggle">
            <i class="fa fa-map-o"></i><!-- icon-pointer-->
            <span class="title">Mapas</span>
            @if( Request::segment(1) == 'mapas' )
                <span class="selected"></span>
        @endif
        <!--<span class="selected"></span>open
                            <span class="arrow "></span>-->
        </a>
    </li>
    <li class="nav-item @if( Request::segment(1) == 'empresas' || Request::segment(1) == 'plantas' ) active open @endif">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-industry"></i>
            <span class="title">Empresas / Plantas</span>
            @if( Request::segment(1) == 'empresas' ||  Request::segment(1) == 'plantas' )
                <span class="selected"></span>
            @endif
        </a>
        <ul class="sub-menu">
            <li class="nav-item  @if( Request::segment(1) == 'empresas') active open @endif">
                <a href="{{ route('sistema.empresas') }}" class="nav-link ">
                    <span class="title">Empresas</span>
                    @if( Request::segment(1) == 'empresas' )
                        <span class="selected"></span>
                    @endif
                </a>
            </li>
            <li class="nav-item  @if( Request::segment(1) == 'plantas' ) active open @endif">
                <a href="{{ route('sistema.plantas') }}" class="nav-link ">
                    <span class="title">Plantas</span>
                    @if( Request::segment(1) == 'plantas' )
                        <span class="selected"></span>
                    @endif
                </a>
            </li>
            @if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 2)
            <!--<li class="nav-item  @if( Request::segment(1) == 'preportes' ) active open @endif">
                <a href="{{ route('sistema.preportes') }}" class="nav-link ">
                    <span class="title">Reportes (Plantas)</span>
                    @if( Request::segment(1) == 'prepo' )
                        <span class="selected"></span>
                    @endif
                </a>
            </li>-->
            @endif
        </ul>

    </li>

    <li class="nav-item @if( Request::segment(1) == 'ambitos' ) active open @endif">
        <a href="{{ route('sistema.ambitos') }}" class="nav-link nav-toggle">
            <i class="fa fa-object-group"></i><!-- icon-pointer-->
            <span class="title">Ambitos</span>
            @if( Request::segment(1) == 'mapas' )
                <span class="selected"></span>
        @endif
        <!--<span class="selected"></span>open
                            <span class="arrow "></span>-->
        </a>
    </li>

    <li class="nav-item @if( Request::segment(1) == 'comercios' ) active open @endif">
        <a href="{{ route('sistema.comercios') }}" class="nav-link nav-toggle">
            <i class="fa fa-shopping-cart"></i>
            <span class="title">Comercios</span>
            @if( Request::segment(1) == 'comercios' )
                <span class="selected"></span>
            @endif
        </a>
    </li>

    <!-- <ul class="sub-menu">
         <li class="nav-item  active open">
             <a href="maps_google.html" class="nav-link ">
                 <span class="title">Google Maps</span>
                 <span class="selected"></span>
             </a>
         </li>
         <li class="nav-item  ">
             <a href="maps_vector.html" class="nav-link ">
                 <span class="title">Vector Maps</span>
             </a>
         </li>
     </ul>-->
    </li>

    @if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 2)
        <li class="nav-item  @if( Request::segment(1) == 'preportes' || Request::segment(1) == 'ereportes' ) active open @endif">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-list-ol"></i>
                <span class="title">Reportes</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                @if(Auth::user()->rol == 10 || Auth::user()->rol == 1 )
                    <li class="nav-item  @if( Request::segment(1) == 'ereportes') active open @endif">
                        <a href="{{ route('sistema.ereportes') }}" class="nav-link ">
                            <span class="title">Empresas</span>
                            @if( Request::segment(1) == 'ereportes' )
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="nav-item  @if( Request::segment(1) == 'preportes' ) active open @endif">
                    <a href="{{ route('sistema.preportes') }}" class="nav-link ">
                        <span class="title">Plantas</span>
                        @if( Request::segment(1) == 'preportes' )
                            <span class="selected"></span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>
    @endif


    @if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 2)
        <li class="nav-item  @if( Request::segment(1) == 'usuarios' || Request::segment(1) == 'logs' ) active open @endif">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">Configuración</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                @if(Auth::user()->rol == 10 || Auth::user()->rol == 1 )
                    <li class="nav-item  @if( Request::segment(1) == 'usuarios') active open @endif">
                        <a href="{{ route('sistema.usuarios') }}" class="nav-link ">
                            <span class="title">Usuarios</span>
                            @if( Request::segment(1) == 'usuarios' )
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="nav-item  @if( Request::segment(1) == 'logs' ) active open @endif">
                    <a href="{{ route('sistema.logs') }}" class="nav-link ">
                        <span class="title">Logs</span>
                        @if( Request::segment(1) == 'logs' )
                            <span class="selected"></span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>
    @endif
</ul>
