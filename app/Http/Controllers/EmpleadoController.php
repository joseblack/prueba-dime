<?php

namespace App\Http\Controllers;

use App\Models\Empleado,
App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::paginate(10);
        return view('empleados.index', ['empleados' => $empleados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::all();
        return view('empleados.create', ['areas' => $areas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        try {            
            $empleado = new Empleado;
            $empleado->nombre    = $request->name;
            $empleado->email     = $request->email;
            $empleado->sexo      = $request->sexo;
            $empleado->area_id   = $request->areaId;
            $empleado->boletin   = $request->boletin;
            $empleado->descripcion = $request->descripcion;
            $empleado->save();
            return redirect()->route('empleados.index')->with('succes', 'Empleado registrado con exito!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('warning', 'No se pudo registrar este registro!' . $ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        $areas = Area::all();
        return view('empleados.edit', ['empleado' => $empleado, 'areas' => $areas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        try {
            $empleado->nombre      = $request->name;
            $empleado->email       = $request->email;
            $empleado->sexo        = $request->sexo;
            $empleado->area_id     = $request->areaId;
            $empleado->descripcion = $request->descripcion;
            $empleado->boletin     = $request->boletin;
            
            $empleado->save();
            return redirect()->route('empleados.index')->with('succes', 'Empleado actualizado con exito!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('warning', 'No se pudo actualizar este registro!' . $ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        try {
            $empleado->delete();
            return redirect()->route('empleados.index')->with('succes', 'Registro eliminado !');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('warning', 'El registro no pudo ser eliminado!' . $ex);
            
        }
    }
}
