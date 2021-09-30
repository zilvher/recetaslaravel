<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Receta;
use Illuminate\Http\Request;
use App\Models\CategoriaReceta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // auth()->user()->recetas; //otra manera sin usar la clase Auth
        $recetas = Auth::user()->recetas;
        return view('recetas/index')->with('recetas', $recetas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // obteer categorias sin modelo
        // DB::table('categoria_receta')->get()->pluck('nombre', 'id')->dd();
        //$categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');

        //categoria con modelo
        $categorias = CategoriaReceta::all('id', 'nombre');
        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'titulo' => 'required | min:6',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required | image',
            'categoria' => 'required'
        ]);

        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

        // Resize de la imagen
        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
        $img->save();

        //Guardar recetas sin modelo
        // DB::table('recetas')->insert([
        //     'titulo' => $data ['titulo'],
        //     'preparacion' => $data ['preparacion'],
        //     'ingredientes' => $data ['ingredientes'],
        //     'imagen' => $ruta_imagen,
        //     'user_id' => Auth::user()->id,
        //     'categoria_id' => $data['categoria']
        // ]);

        // Guardar recetas con modelo
        auth()->user()->recetas()->create([
            'titulo' => $data ['titulo'],
            'preparacion' => $data ['preparacion'],
            'ingredientes' => $data ['ingredientes'],
            'imagen' => $ruta_imagen,            
            'categoria_id' => $data['categoria']
        ]);

       // dd($request->all());

       //Redireccionar
       return redirect()->action([RecetaController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        return view('recetas.show', compact('receta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        //
        $categorias = CategoriaReceta::all('id', 'nombre');
        return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        $this->authorize('update', $receta);
        //
        $data = request()->validate([
            'titulo' => 'required | min:6',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'categoria' => 'required'
        ]);

        //Asignar los valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];
        
        if($request['imagen']){
            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

            // Resize de la imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
            $img->save();

            $receta->imagen = $ruta_imagen;
        }

        $receta->save();

        return redirect()->action([RecetaController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //Ejecutar policy
        $this->authorize('delete', $receta);

        //Eliminar receta
        $receta->delete();

        return redirect()->action([RecetaController::class, 'index']);
    }
}
