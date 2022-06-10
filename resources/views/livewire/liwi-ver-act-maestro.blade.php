<div class="container-fluid"> {{-- INICIO Cuerpo Actividad --}}
<x-alarmas-info />
    <div class="items-center">
        <br>
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('asignar-actividad') }}">Asignar</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a >Vista actividad</a></li>
               
            </ol>
        </nav>
        <br>

    </div>

    <div class="container-fluid">
        <div class="row align-items-start">
            <div class="col-4 text-center">

                @foreach ($datos_data AS $documentos)
                <div class="ratio ratio-16x9">
                    <iframe width="1199" height="674" src="{{$documentos->link_video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
               
                </div>
                <br>
                @if($documentos->Documento == null)
                @else
                <a href="{{$documentos->Documento}}" target="_blanck" class="btn btn-outline-info">Ver Documento</a>
                @endif


                @break
                @endforeach


                <br><br>
            </div>
            <div class="col border border-5">

                <br>


                @foreach ($datos_data AS $nombre)
                <h1 class="text-center"> {{$nombre->nombre_actividad }}</h1>
                @break
                @endforeach

                <br>
            
                @foreach ($respuestas_data AS $solo_respuestas)

                @if($solo_respuestas->tipo_campo == 'text')
                <div class="mt-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{$solo_respuestas->respuesta}}" disabled>
                        <label>{{$solo_respuestas->pregunta}}</label>
                    </div>

                </div>

                @else
                <div class="mt-4">
                    <div class="form-floating">
                        <textarea class="form-control" style="height: 100px" disabled>{{$solo_respuestas->respuesta}} </textarea>
                        <label>{{$solo_respuestas->pregunta}}</label>
                    </div>


                </div>
                @endif


                @endforeach


                <br>
            </div>
        </div>
    </div>


</div>{{-- FIN  Cuerpo Actividad FIN --}}