<x-modal wire:model='open'>
    <!-- Mostrar mensaje de éxito -->
    <div wire:offline.remove>
        @if (session()->has('mensaje'))
        <div class="bg-green-500 text-white p-2 mb-4 rounded">
            {{ session('mensaje') }}
        </div>
        @endif
    </div>

    <!-- Mostrar mensaje de error -->
    <div wire:offline.remove>
        @if (session()->has('error'))
        <div class="bg-red-500 text-white p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
        @endif
    </div>

    <!-- ... -->
    <form wire:submit.prevent='create' class="bg-white dark:bg-gray-900">
        @csrf
        <!-- Modal con los datos del competidor/juez -->
        <div class="inset-0 items-center rounded-lg  z-50 m-5 border-1">
            <div class="bg-white dark:bg-gray-900 rounded-lg">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">

                    <h3 class="text-lg font-bold mb-4 text-white">Inscripción - Informacion sobre mi</h3>
                    <div class="mb-4">
                        <label for="nameTeam" class="block text-gray-700 dark:text-gray-300">Escuela: </label>
                        <select id="nameTeam" type="text" class="w-full border-gray-300 rounded-md p-2" wire:model="escuela" {{$editarEscuela}}>
                            @foreach($escuelas as $unaEscuela)
                            <option>{{$unaEscuela['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    @role('Competidor')
                    <div class="mb-4">
                        <label for="graduacion" class="block text-gray-700 dark:text-gray-300">Graduacion:</label>
                        <select id="graduacion" type="text" class="w-full border-gray-300 rounded-md p-2" wire:model="graduacion" {{$editarGraduacion}}>
                            @foreach($graduacionesCompetidor as $unaGraduacion)
                            <option>{{$unaGraduacion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="gal" class="block text-gray-700 dark:text-gray-300">GAL:</label>
                        <input id="gal" type="gal" class="w-full border-gray-300 rounded-md p-2" wire:model="gal" {{$editarGal}}>
                        <button wire:click="editar('gal')" id="actualizarGralBtn" type="button" class="inline-flex items-center mt-1 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                            {{$botonGal}}
                        </button>
                    </div>

                    @endrole
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-gray-300">Email:</label>
                        <input id="email" type="email" class="w-full border-gray-300 rounded-md p-2" wire:model="email" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 dark:text-gray-300">Nombre:</label>
                        <input id="nombre" type="Nombre" class="w-full border-gray-300 rounded-md p-2" wire:model="nombre" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="apellido" class="block text-gray-700 dark:text-gray-300">Apellido:</label>
                        <input id="apellido" type="Apellido" class="w-full border-gray-300 rounded-md p-2" wire:model="apellido" readonly>
                    </div>
                    @role('Competidor')
                    <div class="mb-4">
                        <label for="dni" class="block text-gray-700 dark:text-gray-300">DU:</label>
                        <input id="dni" type="email" class="w-full border-gray-300 rounded-md p-2" wire:model="du" readonly>
                    </div>
                    @endrole
                    <div class="flex justify-end">
                        <button wire:click="$set('open',false)" id="closeModal" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                            Cerrar
                        </button>
                        <button wire:click='create()' id="confirmModal" type="button" class="ml-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700 active:bg-indigo-700 transition ease-in-out duration-150">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-modal>