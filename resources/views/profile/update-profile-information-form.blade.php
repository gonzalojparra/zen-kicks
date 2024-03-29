<x-form-section submit="updateProfileInformation" id="formUpdate">
    <x-slot name="title">
        <span class="text-slate-100 text-xl">{{ __('Información del perfil') }}</span> <br>
        <span class="text-slate-200 text-lg">{{ __('Actualiza la información de tu perfil') }}</span>
        <x-section-border />
    </x-slot>

    
    <x-slot name="form">

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nombre') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" require wire:model.defer="state.name" autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
            <div id="nombreFeedback" class="input-feedback" for="name">&nbsp;</div>
        </div>


        <!-- Apellido -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="apellido" value="{{ __('Apellido') }}" />
            <x-input id="apellido" type="text" class="mt-1 block w-full" require wire:model.defer="state.apellido" autocomplete="apellido" />
            <x-input-error for="apellido" class="mt-2" />
            <div id="apellidoFeedback" class="input-feedback" for="apellido">&nbsp;</div>
        </div>

        @role('Juez')
        <!-- Escuelas -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="escuela" value="{{ __('Escuela') }}" />
            <x-input readonly id="escuela" class="block mt-1 w-full bg-gray-200" disabled type="text" name="escuela" value="{{$this->user->team->name}} " />
            <x-input-error for="escuela" class="mt-2" />
            <div id="escuelaFeedback" class="input-feedback" for="escuelaUsuario">&nbsp;</div>
        </div>
        @endrole

        @role('Competidor')
        <!-- Escuelas -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="escuela" value="{{ __('Escuela') }}" />
            <x-input readonly id="escuela" class="block mt-1 w-full bg-gray-200" disabled type="text" name="escuela" value="{{$this->user->team->name}} " />
            <x-input-error for="escuela" class="mt-2" />
            <div id="escuelaFeedback" class="input-feedback" for="escuelaUsuario">&nbsp;</div>
        </div>

        <!-- DU -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="du" value="{{ __('DU') }}" />
            <x-input id="du" type="text" class="mt-1 block w-full" min="1960-01-01" require wire:model.defer="state.du" autocomplete="du" />
            <x-input-error for="du" class="mt-2" />
            <div id="duFeedback" class="input-feedback" for="du">&nbsp;</div>
        </div>

        <!-- Nacimiento -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="fecha_nac" value="{{ __('Fecha de nacimiento') }}" />
            <x-input id="fecha_nac" class="block mt-1 w-full" type="date" name="fecha_nac" require wire:model.defer="state.fecha_nac" autocomplete="fecha_nac" min="1960-01-01" />
            <x-input-error for="fecha_nac" class="mt-2" />
            <div id="fechaNacFeedback" class="input-feedback" for="fechaNacCompetidor">&nbsp;</div>
        </div>

        <!-- Genero -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="genero" value="{{ __('Género') }}" />
            <x-input id="genero" class="block mt-1 w-full" type="text" name="genero" require wire:model.defer="state.genero" autocomplete="genero"/>
            <x-input-error for="genero" class="mt-2" /> 
            <div  class="input-feedback" id="generoFeedback" for="genero">&nbsp;</div>
        </div>

        <!-- Graduacio -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="graduacion" value="{{ __('Graduacion') }}" />
            <x-input readonly id="graduacion" class="block mt-1 w-full bg-gray-200" disabled type="text" name="graduacion" value="{{ $this->user->graduacion->nombre }}" />
            <x-input-error for="graduacion" class="mt-2" />
            <div id="graduacionFeedback" class="input-feedback" for="graduacionCompetidor">&nbsp;</div>
        </div>


        <!-- GAL si es un cinturon negro -->
        @if($this->user->gal != null)
        <div id="cinturonNegro" class="col-span-6 sm:col-span-4">
            <x-label for="galCompetidor" value="{{ __('GAL') }}" />
            <x-input id="galCompetidor" class="block mt-1 w-full bg-gray-200 uppercase" disabled type="text" name="gal" :value="old('gal')" autocomplete="gal" wire:model.defer="state.gal" require readonly />
            <x-input-error for="galCompetidor" class="mt-2" />
            <div id="galFeedback" class="input-feedback" for="galCompetidor">&nbsp;</div>
        </div>
        @endif

        @endrole

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" require wire:model.defer="state.email" autocomplete="email" />
            <x-input-error for="email" class="mt-2" />
            <div id="emailFeedback" class="input-feedback" for="email">&nbsp;</div>
        </div>

    </x-slot>

    <x-slot name="actions">

        <x-action-message class="close cursor-pointer rounded flex items-center my-3 justify-between w-full p-2 border border-green-500 bg-green-100 shadow text-green-500" role="alert" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>


        <x-button wire:loading.attr="disabled" wire:target="photo" id="guardarDatos">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
    
</x-form-section>
<script src="{{ asset('js/updatePerfil.js') }}"></script>