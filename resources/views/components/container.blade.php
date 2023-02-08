<div class="row container_content-global" >
  <div class="col s12" z-depth-4 >
    <div class="card grey lighten-5">
      <div class="card-content  white-text">
        {{-- Card Titulo --}}
        <span class="card-title card-title_mod" style="">
            @yield('titulo_card')
        </span>
        {{-- Fin Card Titulo --}}
        <div class="divider"></div>
        {{-- Card Contenido --}}
        <div class="card-content" style="padding: 0px">
          @yield('contenido_card')
        </div>
        <div class="divider"></div>
        {{-- Fin Card Contenido --}}
      </div>
    </div>
  </div>
</div>