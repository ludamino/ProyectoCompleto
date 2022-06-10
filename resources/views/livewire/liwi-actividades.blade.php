<div class="p-6"> {{-- INICIO Cuerpo Actividad --}}

    <div class="items-center">

        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Panel</a></li>
                <li class="breadcrumb-item"><a>Actividades</a></li>
            </ol>
        </nav>

    </div>

    <x-alarmas-info />

    <div class="flex items-center justify-end px-4 text-right sm:px-6"> {{-- INICIO Boton de crear nuevo registro INICIO --}}

        <x-jet-button wire:click="createShowModal">
            {{ __('Nuevo Registro') }}
        </x-jet-button>

    </div> {{-- FIN Boton de crear nuevo registro FIN --}}

    {{-- The data table  INICIO --}}
    <br>
    <div class="container-fluid">
        <div class="table-responsive text-center">
            <table class="table table-striped  table-bordered">
                <thead>
                    <tr>
                        <th scope="col text-center">ID</th>
                        <th scope="col">Nombre</th>

                        <th scope="col">Fecha Limite</th>
                        <th scope="col">Materia</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->COUNT())
                    @foreach ($data AS $act)
                    <tr>
                        <th scope="row">{{ $act->id }}</th>
                        <td>{{ $act->nombre_actividad }}</td>

                        <td>{{ $act->fecha_entrega }}</td>
                        <td>{{ $act->materia }}</td>
                        <td>
                            @if ($act->estado == 'NA')
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <x-jet-danger-button class="btn">
                                    <a href="{{ route('actividad-contenido',$act->id) }}">
                                        <x-icon-revisar />
                                    </a>
                                </x-jet-danger-button>

                                <x-jet-danger-button class="btn" wire:click="updateShowModal({{ $act->id }})">
                                    <x-icon-update />
                                </x-jet-danger-button>

                                @endif
                                <x-jet-danger-button class="btn" wire:click="deleteShowModal({{ $act->id }})">
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



    {{ $data->links() }}

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
                <x-jet-label for="nombre_actividad" value="{{ __('Nombre de la actividad') }}" />
                <x-jet-input id="nombre_actividad" class="block mt-1 w-full" type="text" wire:model.debounde.800ms="nombre_actividad" />
                @error('nombre_actividad') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror

            </div>

            <div class="mt-4">
                <x-jet-label for="link_video" value="{{ __('Link del video') }}" />
                <x-jet-input id="link_video" class="block mt-1 w-full" type="text" wire:model.debounde.800ms="link_video" />
                @error('link_video') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="Documento" value="{{ __('Link del Documento') }}" />
                <x-jet-input id="Documento" class="block mt-1 w-full" type="text" wire:model.debounde.800ms="Documento" />
                @error('Documento') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
            </div>


            <div class="mt-4">
                <x-jet-label for="fecha_entrega" value="{{ __('Fecha limite de entrega') }}" />
                <x-jet-input id="fecha_entrega" class="block mt-1 w-full" type="date" wire:model.debounde.800ms="fecha_entrega" />
                @error('fecha_entrega') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="clv_materia" value="{{ __('Materia') }}" />

                <select class="form-select rounded-md shadow-sm mt-1 block w-full" id="clv_materia" wire:model.debounde.800ms="clv_materia">
                    <option placeholder> -- Asigar la materia -- </option>
                    @foreach ($selec_materia as $selec_materia)
                    <option value="{{ $selec_materia->id }}">{{ $selec_materia->materia }}</option>
                    @endforeach
                </select>
                @error('clv_materia') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-input id="clv_maestro" class="block mt-1 w-full" type="hidden" name="clv_maestro" wire:model.debounde.800ms="clv_maestro" />

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


</div>{{-- FIN  Cuerpo Actividad FIN --}}