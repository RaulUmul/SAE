{{-- @dump($hecho) --}}
{{-- @dump($detalle) --}}

<div class="row">
  <div class="col s12">
    {{-- {{$hecho}} --}}
    <ul>
      {{-- Detalle --}}
      <li><b>Recuperacion</b></li>
      <li><em>Tipo de documento:
        @foreach ($tipo_documento as $value)
            @if ($value->id_item == $detalle['recuperacion']['id_tipo_documento'])
            {{$value->descripcion}}
            @endif
        @endforeach
      </em></li>
{{--      @dump($detalle)--}}
      <li><em>Numero de documento: {{$detalle['recuperacion']['numero_documento']}}</em></li>
      <li><em>Dependencia policial: {{$detalle['recuperacion']['dependencia_policial']}}</em></li>

      {{-- Hecho --}}
      <li><span><b>Hecho</b></span></li>
      <li><em>Fecha: {{$hecho->fecha_hecho}}</em></li>
      <li><em>Hora: {{$hecho->hora_hecho}}</em></li>
      <li><em>Narracion: {{$hecho->narracion}}</em></li>

      {{-- Direccion Hecho --}}
      <li><b>Direccion: </b></li>
      <li>
        <em>
          @empty(!$hecho->direccion->id_departamento)
            @foreach ($departamento as $value)
              @if ($value->id_departamento == $hecho->direccion->id_departamento)
                {{$value->departamento }},
              @endif
            @endforeach
          @endempty
        </em>
        <em>
          @empty(!$hecho->direccion->id_municipio)
            @foreach ($municipio as $value)
                @if ($value->id_municipio == $hecho->direccion->id_municipio)
                {{ $value->municipio}}
                @endif
            @endforeach
          @endempty
        </em>
        <em>
          @empty(!$hecho->direccion->zona)
          Zona {{$hecho->direccion->zona}}
          @endempty
        </em>
        <em>
          @empty(!$hecho->direccion->calle)
            Calle: {{$hecho->direccion->calle }}
          @endempty
        </em>
        <em>
          @empty(!$hecho->direccion->avenida)
            Avenida:  {{$hecho->direccion->avenida }}
          @endempty
        </em>
        <em>
          @empty(!$hecho->direccion->numero_casa)
          {{$hecho->direccion->numero_casa }}
          @endempty
        </em>
      </li>
      <li>{{$hecho->direccion->direccion_exacta}}</li>
      <li>
        <em>
        @empty(!$hecho->id_demarcacion)
        @foreach ($demarcacion as $value)
          @if($value->id_item == $hecho->id_demarcacion )
          Demarcacion: {{$value->descripcion}}
          @endif
        @endforeach
        @endempty
        </em>
      </li>

      {{-- Detenidos --}}
      <li><b>Detenidos: </b></li>
      @foreach($detenidos as $key => $detenido)
        <li>
          {{$key + 1}}. <b> Nombre:</b><em>{{" $detenido->primer_nombre $detenido->segundo_nombre $detenido->tercer_nombre $detenido->primer_apellido $detenido->segundo_apellido $detenido->apellido_casada   "}}</em>
          <b> DPI: </b><em>{{$detenido->cui}} </em>
        </li>
      @endforeach
    </ul>
  </div>
</div>
