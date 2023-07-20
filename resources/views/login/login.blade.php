@extends('layouts.plantilla')
  @section('title','Ingresar')

  @section('content')
    <form method="POST" action="{{route('acceso')}}" id="login-form" autocomplete="off">
      @csrf

      <div class="row valign-wrapper" id="form_login" >
        <div class="col s12">

            <div class="card" style="border-radius: 8px">
              <div class="card-action" style="border-radius: 20px">
                <div class="row">

                  <div class="col s12">
                    <div class="row">
                      <div class="center-align">
                        <img src="{{ asset('img/logodidae.png') }}" height="110px">
                      </div>
                      <h5 class="center">
                        <font face="Segoe UI" color="#2B0808"><b>SAE - SGTIC</b></font>
                      </h5>
                      <h6 class="center">
                        <font face="Segoe UI" color="#2B0808">Ingrese sus credenciales</font>
                      </h6>
                      <div class="col s12 center-align">
                        <span class="red-text">
                          @error('msg')
                          {{$message}}
                          @enderror
                          @error('user')
                          {{$message}}
                          @enderror
                          <br>
                          @error('password')
                          {{$message}}
                          @enderror
                        <span>
                      </div>
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

                      <div class="center">
                        <button class="btn btn-medium waves-effect" type="submit">Ingresar</button>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 center">
                    <span>Si aun no tienes cuenta  </span>
                    <a href="{{route('registro')}}" class="blue-text" >Registrate</a>
                  </div>
                </div>
              </div>
            </div>

        </div>
      </div>
    </form>

  @endsection
