<ul id="slide-out" class="sidenav sidenav-fixed z-depth-0">
    <li>
        <div class="navbar_grid_Parent">
            <div class="navbar_sub_grid1"> 
                <div class="lema">
                    <div >
                        <b>PNC-DIDAE</b><br>
                    </div>
                    <div>
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
            <a href="#"><i class="material-icons"> search</i> Consultas</a>
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
    </div>
  </ul>


  @push('scripts')
    <script>
      $(document).ready(function(){
        $('.sidenav').sidenav();
      });
    </script>
  @endpush