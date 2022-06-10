<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Responder actividad') }}
        </h2>
    </x-slot>



    <div class="container-fluid">
        <br>
        <div class="">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('liwi-contestar-actividad',['post' => $datos])
            </div>
        </div>
    </div>

  


</x-app-layout>