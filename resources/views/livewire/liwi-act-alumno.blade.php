<div class="p-6"> {{-- INICIO Cuerpo Actividad --}}



    <div class="items-center">

        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('mis-cursos') }}">Cursos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Actividades</li>
            </ol>
        </nav>

    </div>

    <x-alarmas-info />

    {{-- Tarjeta de actividades  INICIO --}}
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @if ($asignar_data->COUNT())
        @foreach ($asignar_data AS $asignar)
        <div class="col">
            <div class="card h-100 text-center">

                <div class="card-body">

                    <h5 class="card-title"><span class="badge bg-info text-dark">{{ $asignar->materia }}</span></h5>
                    <br>
                    <p class="card-text"><strong>Actividad </strong>: {{ $asignar->nombre_actividad }}</p>
                    <br>
                    @if($asignar->estado == 'Pendiente')
                    <p class="card-text"><strong>Estado </strong>: <span class="badge bg-warning text-dark">{{ $asignar->estado }}</span></p>
                    @else
                    <p class="card-text"><strong>Estado </strong>: <span class="badge bg-success "> {{ $asignar->estado }}</span></p>
                    @endif
                    <br>
                    
                    <a href="{{ route('contesta-actividad',$asignar->clv_actividad .'-' . $asignar->id_asignar .'-' . $asignar->clv_materia) }}" class="btn btn-success">Ver actividad</a>
                    

                </div>
                <div class="card-footer">
                    Fecha de entrega : <span class="badge rounded-pill bg-dark">{{ $asignar->fecha_entrega }}</span>
                </div>
            </div>
        </div>
        @endforeach
        @else

        <div class="col">
            <div class="card h-100">

                <div class="card-body">
                    <h5 class="card-title"><span class="badge bg-warning text-dark"> No tienes actividades asignadas</span></h5>
                    <br>
                    <p class="card-text"></p>
                    <br>

                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>

        @endif
    </div>
    {{-- Tarjeta de actividades FIN --}}
</div>{{-- FIN  Cuerpo Actividad FIN --}}