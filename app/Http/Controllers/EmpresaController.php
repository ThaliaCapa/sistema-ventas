<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EmpresaController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $paises = DB::table('countries')->orderBy('name')->get();
        $monedas = DB::table('currencies')->get();

        return view('admin.empresas.create', compact('paises', 'monedas'));
    }

    // País → Departamentos
    public function buscar_pais($id)
    {
        try {
            $estados = DB::table('states')
                ->where('country_id', $id)
                ->orderBy('name')
                ->get();

            return response()->json($estados);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar departamentos'], 500);
        }
    }

    // Departamento → Provincias
    public function buscar_ciudad($id)
    {
        try {
            $ciudades = DB::table('cities')
                ->where('state_id', $id)
                ->orderBy('name')
                ->get();

            return response()->json($ciudades);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar provincias'], 500);
        }
    }

    // Provincia → Distritos
    public function buscar_distrito($id)
    {
        try {
            $distritos = DB::table('districts')
                ->where('city_id', $id)
                ->orderBy('name')
                ->get();

            return response()->json($distritos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar distritos'], 500);
        }
    }

    // Buscar RUC en SUNAT (vía Decolecta)
    public function buscarRuc($ruc)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('SUNAT_TOKEN'),
                'Content-Type'  => 'application/json',
            ])->get('https://api.decolecta.com/v1/sunat/ruc?numero=' . $ruc);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'RUC no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required',
            'ruc'            => 'required',
            'telefono'       => 'required',
            'correo' => 'required|email|unique:users,email',
            'direccion'      => 'required',
        ]);

        $logoPath = 'sin_logo.png';
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $pais         = DB::table('countries')->where('id', $request->pais_id)->value('name');
        $departamento = DB::table('states')->where('id', $request->estado_id)->value('name');
        $provincia    = DB::table('cities')->where('id', $request->ciudad_id)->value('name');
        $distrito     = DB::table('districts')->where('id', $request->distrito_id)->value('name');

        $empresaId = DB::table('empresas')->insertGetId([
            'país'          => $pais ?? 'Peru',
            'nombre_empresa' => $request->nombre_empresa,
            'tipo_empresa'  => $request->tipo_empresa,
            'nit'           => $request->ruc,
            'telefono'      => $request->telefono,
            'correo'        => $request->correo,
            'moneda'        => $request->moneda,
            'direccion'     => $request->direccion,
            'departamento'  => $departamento,
            'provincia'     => $provincia,
            'distrito'      => $distrito,
            'codigo_postal' => $request->codigo_postal,
            'logo'          => $logoPath,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // Crear usuario administrador
        $user = new User();
        $user->name = 'Administrador';
        $user->email = $request->correo;
        $user->password = Hash::make($request->ruc);
        $user->empresa_id = $empresaId;
        $user->save();

        // Redireccionar a la vista de éxito con un mensaje
        return redirect()->route('admin.empresas.create')
            ->with('success', 'Empresa registrada correctamente.');
    }

    public function show(Empresa $empresa)
    {
        //
    }

    public function edit(Empresa $empresa)
    {
        //
    }

    public function update(Request $request, Empresa $empresa)
    {
        //
    }

    public function destroy(Empresa $empresa)
    {
        //
    }
}
