<div class="p-6"> {{-- INICIO Cuerpo Tipo Usuario --}}

    <div class="items-center">

        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Panel</a></li>
                <li class="breadcrumb-item"><a>Tipos de Usuario</a></li>
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
        {{-- The data table  INICIO --}}
        <div class="table-responsive">
            <table class="table table-striped  table-bordered">
                <thead>
                    <tr>
                        <th scope="col text-center">ID</th>
                        <th scope="col">Tipo de Usuario</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->count())
                    @foreach ($data as $tipo_usu)
                    <tr>
                        <th scope="row">{{ $tipo_usu->id }}</th>
                        <td>{{ $tipo_usu->tipo_usuario }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <x-jet-danger-button class="btn" wire:click="updateShowModal({{ $tipo_usu->id }})">
                                    <x-icon-update />
                                </x-jet-danger-button>
                                <x-jet-danger-button class="btn" wire:click="deleteShowModal({{ $tipo_usu->id }})">
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
    <br />
    {{ $data->links() }}

    {{-- The data table  FIN --}}

    {{-- INICIO Modal Tipo de Usuario INICIO --}}

    <x-jet-dialog-modal wire:model="modalFormVisible">

        <x-slot name="title" class="text-center">

            @if ($modalId)
            {{ __('Actualizar Tipo de Usuario') }}
            @else
            {{ __('Insetar Tipo de Usuario') }}
            @endif


        </x-slot>

        <x-slot name="content">

            <div class="mt-4">
                <x-jet-label for="tipo_usuario" value="{{ __('Tipo de Usuario') }}" />
                <x-jet-input id="tipo_usuario" class="block mt-1 w-full" type="text" wire:model.debounde.800ms="tipo_usuario" />
                @error('tipo_usuario') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
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

    {{-- FIN Modal Tipo de Usuario  FIN --}}

    {{-- INICIO Modal Eliminar Tipo Usuario INICIO --}}
    <x-jet-dialog-modal wire:model="modal_ConfirmDeleteVisible">
        <x-slot name="title">
            <center>
                {{ __(' ⊗  Eliminar un Tipo de Usuario  ⊗') }}
            </center>
        </x-slot>

        <x-slot name="content">
            <br><br>
            <center>
                {{ __('Estas seguro de eliminar este Tipo de Usuario ') }}
                <br>
                ☞ {{ $tipo_usu->tipo_usuario }} ☜
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
    {{-- FIN Modal Eliminar Tipo Usuario FIN --}}


</div>{{-- FIN  Cuerpo Tipo Usuario FIN --}}