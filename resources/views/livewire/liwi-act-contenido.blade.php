<div class="p-6"> {{-- INICIO Cuerpo Contenido Actividad --}}



    <div class="items-center">

        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('actividad') }}">Actividad</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contenido de la actividad</li>
            </ol>
        </nav>

    </div>
    
 
    <x-alarmas-info />


    <div class="text-center">
        @foreach ($actividad_data as $actividad)
        <h3 class="text-center"> {{$actividad->nombre_actividad}} </h3>
        @endforeach
    </div>

    <div class="flex items-center justify-end px-4 text-right sm:px-6"> {{-- INICIO Boton de crear nuevo registro INICIO --}}

        <x-jet-button wire:click="createShowModal">
            {{ __('Nuevo Registro') }}
        </x-jet-button>

    </div> {{-- FIN Boton de crear nuevo registro FIN --}}

    {{-- The data table  INICIO --}}
    <br>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped  table-bordered">
                <thead>
                    <tr>
                        <th scope="col text-center">ID</th>
                        <th scope="col">Pregunta</th>
                        <th scope="col">Tipo de campo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($contenido_data->COUNT())
                    @foreach ($contenido_data AS $contenido)
                    <tr>
                        <th scope="row">{{ $contenido->id_act_contenido }}</th>
                        <td>{{ $contenido->pregunta }}</td>
                        <td>{{ $contenido->tipo_campo }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <x-jet-danger-button class="btn" wire:click="updateShowModal({{ $contenido->id_act_contenido }})">
                                    <x-icon-update />
                                </x-jet-danger-button>
                                <x-jet-danger-button class="btn" wire:click="deleteShowModal({{ $contenido->id_act_contenido }})">
                                    <x-icon-delete />
                                </x-jet-danger-button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td><span class="text-xs text-black-500 italic">{{ 'No hay resultados' }}</span>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- The data table  FIN --}}

   

    {{-- INICIO Modal Actividad INICIO --}}

    <x-jet-dialog-modal wire:model="modalFormVisible">

        <x-slot name="title" class="text-center">

            @if ($modalId)
            {{ __('Actualizar Actividad') }}
            @else
            {{ __('Insetar Actividad') }}
            @endif


        </x-slot>

        <x-slot name="content">

            <div class="mt-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="pregunta" name="pregunta" wire:model.debounde.800ms="pregunta">
                    <label for="pregunta">Pregunta</label>
                    @error('pregunta') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
                </div>

            </div>

            <div class="mt-4">
                <div class="form-floating">
                    <select class="form-select" name="tipo_campo" id="tipo_campo" aria-label="Floating label select example" wire:model.debounde.800ms="tipo_campo">
                        <option placeholder> -- Asigar un tipo de Usuario -- </option>
                        <option value="text">Texto</option>
                        <option value="textarea">Area de texto</option>

                    </select>
                    <label for="tipo_campo">Elije el tipo de campo de la respuesta</label>
                </div>
                @error('tipo_campo') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
            </div>




            <br> <br>
        </x-slot>

        <x-slot name="footer">
            <hr>
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>
            @if ($modalId)
            <x-jet-danger-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                {{ __('Actualizar') }}
            </x-jet-danger-button>
            @else
            <x-jet-danger-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                {{ __('Insertar') }}
            </x-jet-danger-button>
            @endif

        </x-slot>
    </x-jet-dialog-modal>

    {{-- FIN Modal Actividad  FIN --}}

    {{-- INICIO Modal Eliminar Actividad INICIO --}}
    <x-jet-dialog-modal wire:model="modal_ConfirmDeleteVisible">
        <x-slot name="title">
            <center>
                {{ __(' ⊗  Eliminar esta Actividad  ⊗') }}
            </center>
        </x-slot>

        <x-slot name="content">
            <br><br>
            <center>
                {{ __('Estas seguro de eliminar esta Actividad') }}
                <br>

            </center>
            <br><br>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modal_ConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Eliminar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- FIN Modal Eliminar Actividad FIN --}}




</div>{{-- FIN  Cuerpo Contenido Actividad FIN --}}