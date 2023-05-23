<ul id="slide-out" class="sidenav sidenav-fixed z-depth-0">
    <li>
        <div class="navbar_grid_Parent">
            <div class="navbar_sub_grid1">
                <div class="lema">
                    <div class="textLema">
                        <b>PNC-DIDAE</b><br>
                        <b>SISTEMA ARMAS Y EXPLOSIVOS</b>
                    </div>
                </div>
            </div>
            <div class="navbar_sub_grid2">
                 <img  class="circle responsive-img logo" src="{{asset('./img/logodidae.png')}}" alt="">
             </div>
        </div>
    </li>
    <div class="navbar_list">
        <li>
            <a href="{{route('sae.inicio')}}"><i class="material-icons">home</i>Inicio</a>
        </li>
        <li>
            <a href="{{route('consulta.index')}}"><i class="material-icons"> search</i> Consultas</a>
        </li>
        <li>
            <a href="{{route('denuncia.index')}}"> <i class="material-icons">create</i> Denuncias</a>
        </li>
        <li>
            <a href="#"> <i class="material-icons">fingerprint</i> Incautacion</a>
        </li>
        <li>
            <a href="#"> <i class="material-icons">work</i>  Reporte</a>
        </li>
        <li id="user-account">
          <a href="#" class="dropdown-trigger hoverable" data-target='dropdown-user' style=" background-color: transparent !important;">
            <i class="material-icons left">
              account_circle
            </i>
            {{ucwords(auth()->user()->user)}}
          </a>
        </li>
    </div>
  </ul>

<ul id='dropdown-user' class='dropdown-content'>
  <li><a href="{{route('logout')}}"><i class="material-icons left">power_settings_new</i>Cerrar sesion</a></li>
  <li><a href="#!"><i class="material-icons left">settings</i>Ajustes</a></li>
</ul>


  @push('scripts')
    <script>
      $(document).ready(function(){
        $('.sidenav').sidenav();
        $('.dropdown-trigger').dropdown();
      });
    </script>
  @endpush
