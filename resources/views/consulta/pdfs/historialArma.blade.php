<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<style>
    body {
        box-sizing: border-box;
				font-family: Arial, Helvetica, sans-serif;
    }
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        /* height: 10cm; */
        /* color: white; */
        /* text-align: center; */
        line-height: 30px;
    }
		.container{
			display: flex;
			/* border: 1px solid black; */
			justify-content: flex-end;
		}
		.container > span{
			width: 49%;
			display: inline-block;
			/* border: 1px solid red; */
		}
		.container > span:last-child{
			text-align: right
		}

    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
        text-align: right;
        line-height: 35px;
    }

    .titulo {
      /* border: 1px solid black; */
      display: flex;
      justify-content: center;
      text-align: center;
    }

		.collection-evento{
			/* border: 1px solid black; */
			/* width: 100%; */
			display: flex;	
			/* justify-content: flex-end; */
			margin-top: 1rem;	
		}

		.item-detalle{

			display: inline-block;
			width: 49%; 
			/* padding: 2px; */
			/* border: 1px solid red; */
			/* max-width: 49%; */
		}
		.item-detalle:first-child{
			width: 99%;
			margin-bottom:0.2cm; 
			background-color: #d4d4d4; 
		}
		.item-detalle:last-child{
			width: 99%;
			margin-bottom:0.2cm; 
			/* background-color: #d4d4d4;  */
		}
		main{
			position: relative;
			top: 0.5cm;
		}
		h1{
			font-size: 1.5rem;
		}

		

</style>
</head>
<body>
	<header>
		<div class="container">
				<span>
					Historial
				</span> 
				<span>
					SAE
				</span> 
		</div>
		<hr style="position: relative; top: -15px">
	</header>

	<main>
			{{-- @dump($data->tipo_procedimiento) --}}
			{{-- {{$data->arma['registro']}} --}}

			<div class="titulo">
					<h1>ARMA SERIE NO. {{ $data->arma['registro'] }}</h1>
			</div>

			<div class="contenedor-eventos">
				@foreach ($data->historial as $evento )
					<div class="collection-evento">
						<div class="item-detalle">
							@foreach ( $data->tipo_procedimiento as  $tipo )
								@if( $tipo['id_item'] == ($evento['id_tipo_procedimiento']) )
								 <span><b> Procedimiento: </b> {{$tipo['descripcion']}}</span>
								@endif
							@endforeach
						</div>
						@isset($evento['numero_documento'])		
							<div class="item-detalle">
								<span><b>Documento No:</b> {{$evento['numero_documento']}}</span>
							</div>
						@endisset
						<div class="item-detalle">
							@foreach($data->usuarios as $usuario)
								@if($usuario['id_user'] == $evento['id_autor'])
								 <b> Responsable: </b> {{ucwords( $usuario['user'] )}}
								@endif
							@endforeach
						</div>
						<div class="item-detalle item-fecha">
							<b>Fecha registro:</b>{{date('d/m/Y',strtotime($evento['fecha_creacion']))}}
							<b>Hora:</b> {{date('H:i:s'), strtotime($evento['fecha_creacion'])}}
						</div>
						<div class="item-detalle">
							<b>Descripcion:</b> {{$evento['descripcion']}}
						</div>
					</div>
				@endforeach
			</div>
	</main>

	<footer>
		<hr style="position: relative; top: 15px">
		Fecha impresion: {{date('d/m/Y H:i')}}
	</footer>
</body>
</html>
