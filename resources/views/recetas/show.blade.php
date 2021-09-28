@extends('layouts.app')

@section('content')
    {{-- <h1>{{ $receta }}</h1> --}}
    <section class="contenido-receta">
        <h1 class="text-center mb-4">
            {{ $receta->titulo}}
        </h1>

        <div class="imagen-receta">
            <img src="/storage/{{$receta->imagen}}" alt="" class="w-100">
        </div>

        <div class="receta-meta">
            <p>
                <span class="font-weight-bold text-primary">
                    Escrito en:
                </span>
                {{$receta->categoria->nombre}}
            </p>
            <p>
                <span class="font-weight-bold text-primary">
                    Autor:
                </span>
                {{$receta->autor->name}}
            </p>
            <p>
                <span class="font-weight-bold text-primary">
                    Fecha:
                </span>
                @php
                    $fecha = $receta->created_at    
                @endphp
                
            </p>

            <fecha-receta fecha="{{$fecha}}"></fecha-receta>

            <div class="ingredientes">
                <h2 class="my-3 text-primary">
                    Ingredientes
                </h2>
                {!! $receta->ingredientes !!}
            </div>
            <div class="preparacion">
                <h2 class="my-3 text-primary">
                    Preparacion
                </h2>
                {!! $receta->preparacion !!}
            </div>
        </div>
    </section>
@endsection