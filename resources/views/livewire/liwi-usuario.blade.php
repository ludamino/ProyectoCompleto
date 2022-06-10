<div class="p-6"> {{-- INICIO Cuerpo Usuario INICIO --}}

    <div class="items-center">

        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Panel</a></li>
                <li class="breadcrumb-item"><a >Usuario</a></li>
            </ol>
        </nav>

    </div>

    <x-alarmas-info />


    <div class="row">

        <div class="col">
            <x-jet-label for="clv_tipo_usuario" value="{{ __('Tipo de Usuario') }}" />

            <select class="form-select rounded-md shadow-sm mt-1 block w-full" id="busqueda_id" wire:model.debounde.800ms="busqueda_id">
                <option value="todos">Todos</option>
                @foreach ($Tipo_user as $busqueda_tipo_user)
                <option value="{{ $busqueda_tipo_user->id }}">{{ $busqueda_tipo_user->tipo_usuario }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <br>
            <div class="flex items-center justify-end px-4 text-right sm:px-6"> {{-- INICIO Boton de crear nuevo registro INICIO --}}

                <x-jet-button wire:click="createShowModal">
                    {{ __('Nuevo Registro') }}
                </x-jet-button>

            </div>
        </div>


    </div>


    <br>

    {{-- INICIO Tabla de contenido INICIO --}}

    <br>

    <div class="container-fluid">
        {{-- The data table  INICIO --}}
        <div class="table-responsive text-center">
            <table class="table table-striped  table-bordered">
                <thead>
                    <tr>
                        <th scope="col text-center">ID</th>
                        <th scope="col">Tipo de Usuario</th>
                        <th scope="col">Nombre del usuario</th>
                        <th scope="col">Rango solicitado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->count())
                    @foreach ($data as $usuario)
                    <tr>
                        <th scope="row">{{ $usuario->id}}</th>
                        <td>{{ $usuario->tipo_usuario}}</td>
                        <td>{{ $usuario->name}}</td>
                        <td>
                            @if($usuario->solicitud == 'Administrador')
                            <span class="badge bg-danger">{{ $usuario->solicitud }}</span>
                            @elseif ($usuario->solicitud == 'Alumno')
                            <span class="badge bg-primary">{{ $usuario->solicitud }}</span>
                            @else
                            <span class="badge bg-info text-dark">{{ $usuario->solicitud }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <x-jet-danger-button class="btn" wire:click="updateShowModal({{ $usuario->id }})">
                                    <x-icon-update />
                                </x-jet-danger-button>
                                <x-jet-danger-button class="btn" wire:click="deleteShowModal({{ $usuario->id }})">
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
    {{-- FIN Tabla de contenido FIN --}}


    {{-- INICIO Modal Nuevo Usuario INICIO --}}

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-jet-validation-errors class="mb-4" />
        <x-slot name="title" class="text-center">

            @if ($modalId)
            {{ __('Actualizar Usuario') }}
            @else
            {{ __('Insertar Usuario') }}
            @endif


        </x-slot>

        <x-slot name="content">

            <div class="row">
                <div class="col">
                    <div class="mt-4">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" wire:model.debounde.800ms="name" />
                        @error('name') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="mt-4">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required wire:model.debounde.800ms="email" />
                        @error('email') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>


            <br>
            @if ($modalId)

            <div class="alert alert-danger" role="alert">
                ¡¡ Las contraseñas estan cifradas !! y no se puede descifrar , en caso de querer actualizar marque el check y genera una nueva contraseña.
            </div>

            <button type="button" class="btn btn-primary btn-sm" wire:click="activar_pass">Activar Contraseña</button>


            @if ($check_password_update) {{-- Activo --}}
            <div class="row">
                <div class="col">
                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" wire:model.debounde.800ms="password" />
                        @error('password') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="mt-4">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" wire:model.debounde.800ms="password_confirmation" />
                        @error('password_confirmation') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <br>
            <x-jet-button wire:click="generar_password">
                {{ __('Generar pass') }}
            </x-jet-button>
            <br>
            @else {{-- NO Activo --}}

            @endif

            @else
            <div class="row">
                <div class="col">
                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" wire:model.debounde.800ms="password" />
                        @error('password') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="mt-4">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" wire:model.debounde.800ms="password_confirmation" />
                        @error('password_confirmation') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <br>
            <x-jet-button wire:click="generar_password">
                {{ __('Generar pass') }}
            </x-jet-button>
            <br>
            @endif
            <br>
            <div class="mt-4">
                <x-jet-label for="telefono" value="{{ __('Telefono') }}" />
                <x-jet-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required autocomplete="new-telefono" wire:model.debounde.800ms="telefono" />
                @error('telefono') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
            </div>

            <div class="row">
                <div class="col">

                    <div class="mt-4">
                        <x-jet-label for="clv_tipo_usuario" value="{{ __('Tipo de Usuario') }}" />

                        <select class="form-select rounded-md shadow-sm mt-1 block w-full" id="clv_tipo_usuario" wire:model.debounde.800ms="clv_tipo_usuario">
                            <option placeholder> -- Asigar un tipo de Usuario -- </option>
                            @foreach ($Tipo_user as $Tipo_user)
                            <option value="{{ $Tipo_user->id }}">{{ $Tipo_user->tipo_usuario }}</option>
                            @endforeach
                        </select>
                        @error('clv_tipo_usuario') <span class="text-sm text-red-500 italic">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-jet-label for="terms">
                    <div class="flex items-center">
                        <x-jet-checkbox name="terms" id="terms" />

                        <div class="ml-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-jet-label>
            </div>
            @endif

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

    {{-- FIN Modal Nuevo Usuario  FIN --}}

    {{-- INICIO Modal Eliminar Usuario INICIO --}}
    <x-jet-dialog-modal wire:model="modal_ConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Eliminar Usuario') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Estas seguro de eliminar este Usuario.') }}
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
    {{-- FIN Modal Eliminar Usuario FIN --}}


</div>{{-- FIN  Cuerpo Usuarios FIN --}}