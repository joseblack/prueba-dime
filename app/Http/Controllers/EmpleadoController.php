<?php

namespace App\Http\Controllers;

use App\Models\Empleado,
    App\Models\Area,
    App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $empleados = Empleado::join('areas', 'empleados.area_id', '=', 'areas.id')
                ->select('empleados.*', 'areas.nombre as area')
                ->orderBy('id')
                ->paginate(8);
        return view('empleados.index', ['empleados' => $empleados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $areas = Area::all();
        $roles = Role::all();
        return view('empleados.create', ['areas' => $areas, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        try {
            $empleado = new Empleado;
            $empleado->nombre = $request->name;
            $empleado->email = $request->email;
            $empleado->sexo = $request->sexo;
            $empleado->area_id = $request->areaId;
            $empleado->boletin = $request->boletin ? 1 : 0;
            $empleado->descripcion = $request->descripcion;
            $empleado->save();

            $this->storeEmpARol($empleado->id, $request->roles);

            return redirect()->route('empleados.index')->with('succes', 'Empleado registrado con exito!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('warning', 'No se pudo registrar este registro!' . $ex);
        }
    }

    /**
     * Created new resource in empleado_rol roles por usuario.
     * 
     * @param type $id int
     * @param type $roles array()
     */
    public function storeEmpARol($id, $roles = []) {
        foreach ($roles as $value) {
            if ($value != null) {
                DB::insert('INSERT INTO empleado_rol (empleado_id, rol_id) VALUES (?, ?)', [$id, $value]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado) {
        $areas = Area::all();
        $roles = Role::all();
        $empRoles = DB::table('empleado_rol')->where('empleado_id', $empleado->id)->get();
     
        return view('empleados.edit', [
            'empleado' => $empleado, 'areas' => $areas, 'roles' => $roles, 'empRoles' => $empRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado) {
        
        try {
            $empleado->nombre = $request->name;
            $empleado->email = $request->email;
            $empleado->sexo = $request->sexo;
            $empleado->area_id = $request->areaId;
            $empleado->descripcion = $request->descripcion;
            $empleado->boletin = $request->boletin ? 1 : 0;
            $empleado->save();
            $this->updateEmpleRoles($empleado->id, $request->roles);
            return redirect()->route('empleados.index')->with('succes', 'Empleado actualizado con exito!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('warning', 'No se pudo actualizar este registro!' . $ex);
        }
    }
    
    public function updateEmpleRoles($id, $roles = []) {
        $affect = DB::table('empleado_rol')->where('empleado_id', $id)->delete();
        if ($roles != null) {
            foreach ($roles as $rol) {
                DB::table('empleado_rol')
                    ->updateOrInsert(
                        ['empleado_id' => $id, 'rol_id' => $rol],
                        ['empleado_id' => $id, 'rol_id' => $rol]
                    );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado) {
        try {
            $empleado->delete();
            return redirect()->route('empleados.index')->with('succes', 'Registro eliminado !');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('warning', 'El registro no pudo ser eliminado!' . $ex);
        }
    }

}
