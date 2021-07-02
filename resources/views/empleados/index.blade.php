@extends('layouts.app')

@section('content')
<div class="container">
    <div class="loader row justify-content-center col-md-12 d-none" id="loader">
        <img src="{{asset('img/Fidget-spinner.gif')}}" class="" id='img-loading' name='img-loading'>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Employees') }}</div>

                <div class="card-body">
                    <div class="row justify-content-end">
                        <div class="col-md-6 d-flex justify-content-start">
<!--                            <a class="btn btn-sm btn-outline-info btn-square mb-3" href="">
                                <i class="fa fa-fw fa-plus mr-1"></i> @lang('Create')
                            </a>-->
                        </div>

                        <div class="col-md-6 d-flex justify-content-end">
                            <a class="btn btn-sm btn-outline-info btn-square mb-3" href="{{ route('empleados.create') }}">
                                <i class="fa fa-fw fas fa-user mr-1"></i> @lang('Crear')
                            </a>
                        </div>
                    </div>    

                    <table class="table table-hover table-vcenter table-responsive-sm">
                        <thead>
                            <tr>
                                <th><i class="fa fa-fw fas fa-user mr-1"></i>Nombre</th>
                                <th><i class="fa fa-fw fas fa-mail-bulk"></i>Email</th>
                                <th><i class="fa fa-fw fas fa-venus-mars"></i>Sexo</th>
                                <th><i class="fa fa-fw fas fa-chart-area"></i>Area</th>
                                <th><i class="fa fa-fw fas fa-train"></i>Boletin</th>
                                <th>Modificar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empleados as $empleado)
                            <tr>
                                <td>{{ $empleado->nombre }}</td>
                                <td>{{ $empleado->email }}</td>
                                <td>{{ $empleado->sexo }}</td>
                                <td>{{ $empleado->area }}</td>
                                <td>{{ $empleado->boletin ? "Si" : "No" }}</td>
                                <td> 
                                    <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-warning btn-sm">                                       
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <!-- Button trigger modal -->
                                <form action="{{ route('empleados.destroy', $empleado) }}" id="from1" name="from1" method="post">
                                    @csrf
                                    @method('DELETE')                                                                  
                                    <button class="btn btn-danger btn-sm" type="submit" 
                                    onclick="return confirm('Una vez eliminado, no podrá recuperar este archivo. \n ¿Esta seguro?')">                                               
                                        <span class="far fa-trash-alt" aria-hidden="true"></span>
                                    </button>
                                </form> 
                                </td> 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!--$empleados->appends(request()->all())->links()-->
                <!--{{ $empleados->appends(request()->input())->links() }}-->
                {{ $empleados->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>


@endsection

@section('js_after')
<script src="{{ asset('js/employees/employeedelete.js') }}" defer></script>
@endsection
