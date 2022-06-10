<div class="p-6"> {{-- INICIO Cuerpo Actividad --}}

    <div class="items-center">

        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Panel</a></li>
                <li class="breadcrumb-item"><a>Asignar Actividad</a></li>
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
                        <th scope="col">Actividad</th>

                        <th scope="col"></th>
                        <th scope="col">Alumno</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($asignar_data->COUNT())
                    @foreach ($asignar_data AS $asignar)
                    <tr>
                        <th scope="row">{{ $asignar->id_asignar }}</th>
                        <td>{{ $asignar->nombre_actividad }}</td>

                        <td class="text-center"> → </td>
                        <td>{{ $asignar->name }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <x-jet-danger-button class="btn">
                                    <a href="{{ route('vista-actividad',$asignar->clv_actividad .'-' . $asignar->clv_usuario) }}">
                                        <x-icon-ver-actividad />
                                    </a>
                                </x-jet-danger-button>
                                <x-jet-danger-button class="btn" wire:click="updateShowModal({{ $asignar->id_asignar }})">
                                    <x-icon-update />
                                </x-jet-danger-button>
                                <x-jet-danger-button class="btn" wire:click="deleteShowModal({{ $asignar->id_asignar }})">
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
            {{ __('Actualizar Asignacion') }}
            @else
            {{ __('Insertar Asignación') }}
            @endif


        </x-slot>

        <x-slot name="content">

            <div class="mt-4">
                <div class="form-floating">
                    <select class="form-select" name="clv_actividad" id="clv_actividad" aria-label="Floating label select" wire:model.debounde.800ms="clv_actividad">

                        <option placeholder> -- Seleccionar la actividad -- </option>
                        @foreach ($actividad_data as $actividad_data)
                        <option value="{{ $actividad_data->id }}">{{ $actividad_data->nombre_actividad }}</option>
                        @endforeach
                    </select>
                    <label for="clv_actividad">Elija la actividad</label>
                </div>
                @error('clv_actividad') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
            </div>


            <div class="mt-4">
                <div class="form-floating">
                    <select class="form-select" name="clv_usuario" id="clv_usuario" aria-label="Floating label select" wire:model.debounde.800ms="clv_usuario">
                        <option placeholder=""> -- Asigar a un Usuario -- </option>
                        @foreach ($usuarios_data as $usuarios_data)
                        <option value="{{ $usuarios_data->id }}">{{ $usuarios_data->name }}</option>
                        @endforeach

                    </select>
                    <label for="clv_usuario">Elije el usuario a asignar</label>
                </div>
                @error('clv_usuario') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
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