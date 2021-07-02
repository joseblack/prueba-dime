@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-info">
                    <strong>Info!</strong> Los campos con (*) son obligatorios.
                </div>
            <div class="card">
                <div class="card-header">{{ __('Editar empleado') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('empleados.update', $empleado) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre completo *') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $empleado->nombre }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electronico *') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $empleado->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sexo" class="col-md-4 col-form-label text-md-right">{{ __('Sexo *') }}</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <label class="form-check-label" for="radio1">
                                      <input type="radio" class="form-check-input" id="radio1" name="sexo" value="M" checked>Masculino
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <label class="form-check-label" for="radio2">
                                      <input type="radio" class="form-check-input" id="radio2" name="sexo" value="F">Femenino
                                    </label>
                                  </div>
                    
                                @error('sexo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="area" class="col-md-4 col-form-label text-md-right">{{ __('Area *') }}</label>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select id="inputArea" name="areaId" class="form-control">
                                        <option>Chose...</option>
                                        @foreach ($areas as $area)
                                          @if($empleado->area_id == $area->id)
                                            <option selected value="{{ $area->id }}">{{ $area->nombre }}</option>
                                            @else
                                            <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                          @endif
                                            
                                        @endforeach
                                        <option>...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción *') }}</label>

                            <div class="col-md-6">
                                <textarea class="form-control" rows="3" id="descripcion" name="descripcion">{{ $empleado->descripcion }}
                                </textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-4"></div>
                            <div class=" col-md-6">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        @if($empleado->boletin)
                                        <input type="checkbox" class="form-check-input" id="boletin" name="boletin" value="{{$empleado->boletin}}" checked>Recibir boletin
                                        @else
                                        <input type="checkbox" class="form-check-input" id="boletin" name="boletin" value="1">Recibir boletin
                                        @endif 
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="roles" class="col-md-4 col-form-label text-md-right">{{ __('Roles *') }}</label>
                            @foreach ($roles as $rol)
                            <div class=" col-md-6">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        @php    
                                            $counter = 0;
                                        @endphp
                                        
                                        @foreach ($empRoles as $empRole)
                                            @if ($empRole->rol_id == $rol->id)
                                                @php 
                                                    $counter++;
                                                @endphp
                                                <input type="checkbox" class="form-check-input" name="roles[]" value="{{ $rol->id }}" checked>{{ $rol->nombre }}
                                            @endif                                         
                                        @endforeach
                                        
                                        @if ($counter == 0)
                                             <input type="checkbox" class="form-check-input" name="roles[]" value="{{ $rol->id }}">{{ $rol->nombre }}
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            @endforeach
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
