@extends('layouts.plantilla')
@section('title','Registrarse')

@section('content')

  <form method="POST" action="{{route('registro')}}" id="login-form" autocomplete="off">
    @csrf
{{--    @method('POST')--}}

    <div class="row " id="form_login">
      <div class="col s12">

        <div class="card" style="border-radius: 8px">
          <div class="card-action" style="border-radius: 20px">
            <div class="row">

              <form class="col s12">
                <div class="row">
                  <div align="center">
                    <img src="{{ asset('img/logodidae.png') }}" height="110px">
                  </div>
                  <h5 class="center">
                    <font face="Segoe UI" color="#2B0808"><b>SAE - SGTIC</b></font>
                  </h5>
                  <h6 class="center">
                    <font face="Segoe UI" color="#2B0808">Crear usuario</font>
                  </h6>
                  @error('user')
                  {{$message}}
                  @enderror
                  @error('password')
                  {{$message}}
                  @enderror
                </div>

                <div class="row col s12">
                  <div class="input-field col s12 ">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="user" name="user" type="text" class="validate">
                    <label for="user">Usuario</label>
                  </div>
                  <div class="input-field col s12">
                    <i class="material-icons prefix">lock</i>
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password">Contraseña</label>
                  </div>
                  <div class="input-field col s12">
                    <i class="material-icons prefix">lock</i>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="validate">
                    <label for="password_confirmation">Confirmar contraseña</label>
                  </div>

                  <div class="center">
                    <button class="btn btn-medium waves-effect" type="submit">Registrarse</button>
                  </div>
                </div>
              </form>
              <div class="col s12 center">
                <span>Si ya tienes cuenta  </span>
                <a href="{{route('login')}}" class="blue-text" >Inicia sesion</a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </form>


@endsection
