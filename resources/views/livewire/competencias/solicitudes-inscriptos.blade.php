<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administrar Inscriptos') }} de: <span style="color: #ef4444">{{$competencia->titulo}}</span>
        </h2>
    </x-slot>
    {{-- MOSTRAMOS SOLICITUDES --}}
    <div class='max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8'>
        <a href="{{route('competencias.administrar-competencias')}}">
            <x-button class="ml-4  bg-grey-600 disabled:opacity-25">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>                  
                Volver a competencias
            </x-button>
        </a>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <p class="text-gray-500 text-center m-2">Solicitudes ({{count($inscriptosPendientes)}})</p>
            @if (count($inscriptosPendientes) > 0)
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">

                <thead class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Nombre y Apellido
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Escuela
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Graduacion
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                GAL
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Para
                            </span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">-</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inscriptosPendientes as $inscripto )
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            <!-- @if (isset($inscripto->actualizacion))
                            <span class="text-xs font-bold text-black bg-orange-200">Hay datos editados</span><br> 
                            @endif -->
                            {{$inscripto->user->name}} {{$inscripto->user->apellido}}
                        </td>
                        <td class="px-6 py-4">
                            @if (isset($inscripto->actualizacion)&& $inscripto->actualizacion->id_escuela_nueva != null)
                            <span style="color: #d97706;">{{$inscripto->actualizacion->team->name}}</span>
                            @else
                            {{$inscripto->user->team->name}}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if (isset($inscripto->actualizacion) && $inscripto->actualizacion->id_graduacion_nueva != null)
                            <span<span style="color: #d97706;">{{$inscripto->actualizacion->graduacion->nombre}}</span>
                            @else
                            @if($inscripto->user->graduacion !== null)
                            {{$inscripto->user->graduacion->nombre}}
                            @else
                            -
                            @endif
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if (isset($inscripto->actualizacion) && $inscripto->actualizacion->gal_nuevo != null)
                            <span<span style="color: #d97706;">{{$inscripto->actualizacion->gal_nuevo}}</span>
                            @else
                            @if($inscripto->user->gal !== null)
                            {{$inscripto->user->gal}}
                            @else
                            -
                            @endif
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{$inscripto->rol}}
                        </td>

                        <td class="px-6 py-4">
                            <button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800 disabled:opacity-25" wire:click="aceptar('{{ $inscripto->rol }}', {{ $inscripto->id }}, {{$inscripto->actualizacion}})" wire:loading.attr='disabled' wire:target='aceptar'>  
                                <span @popper(Aceptar) class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>                                      
                                </span>
                            </button>
                            <button @popper(Rechazar) class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 ml-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-orange-500 to-red-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800 mt-2 disabled:opacity-25" wire:click="rechazar('{{ $inscripto->rol }}', {{ $inscripto->id }}, {{$competencia->id}}, {{$inscripto->actualizacion}})" wire:loading.attr='disabled' wire:target='rechazar'>
                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>                                      
                                </span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 px-6 py-3 text-dark">
                <h3>
                    No se encuentran solicitudes
                </h3>
            </div>

            @endif
        </div>
    </div>


    <hr class="m-5">

    {{-- MOSTRAMOS JUECES --}}
    <div class='max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8'>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <p class="text-gray-500 text-center m-2">Jueces ({{count($jueces)}})</p>
            @if (count($jueces) > 0)
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">

                <thead class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Nombre y Apellido
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Escuela
                            </span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">-</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jueces as $juez )
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{$juez->user->name}} {{$juez->user->apellido}}
                        </td>
                        <td class="px-6 py-4">
                            @if (isset($juez->modificacion))
                            {{$juez->actualizacion->team->name}}
                            @else
                            {{$juez->user->team->name}}
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <button class="relative inline-flex items-center justify-center p-0.5 mb-2 ml-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-orange-500 to-red-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800 mt-2" wire:click="eliminarJuez({{$juez->id}})">
                                <span @popper(Eliminar juez) class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                    <svg fill="none" stroke="currentColor" class="w-5 m-auto" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="false">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                    </svg>
                                </span>
                            </button>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
            @else
            <div class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 px-6 py-3 text-dark">
                <h3>
                    Aun no hay jueces
                </h3>
            </div>

            @endif
        </div>
    </div>


    <hr class="m-5">

    {{-- MOSTRAMOS COMPETIDORES --}}
    <div class='max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8'>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <p class="text-gray-500 text-center m-2">Participantes ({{count($competidores)}})</p>
            @if (count($competidores) > 0)
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">

                <thead class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Nombre y Apellido
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Escuela
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Graduacion
                            </span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">-</span>
                        </th>
                    </tr>
                </thead>
                @livewire('competencias.modal-solicitud')
                <tbody>
                    @foreach ($competidores as $competidor )
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{$competidor->user->name}} {{$competidor->user->apellido}}
                        </td>
                        <td class="px-6 py-4">
                            @if (isset($competidor->modificacion))
                            {{$competidor->actualizacion->team->name}}
                            @else
                            {{$competidor->user->team->name}}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{$competidor->user->graduacion->nombre}}
                        </td>

                        <td class="px-6 py-4">
                            <button class="relative inline-flex items-center justify-center p-0.5 mb-2 ml-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-orange-500 to-red-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800 mt-2" wire:click="eliminarCompetidor({{$competidor->id}})">
                                <span @popper(Eliminar competidor) class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                    <svg fill="none" stroke="currentColor" class="w-5 m-auto" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="false">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                    </svg>
                                </span>
                            </button>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
            @else
            <div class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 px-6 py-3 text-dark">
                <h3>
                    Aun no hay competidores
                </h3>
            </div>

            @endif
        </div>
    </div>


</div>