<?php

namespace App\Http\Livewire\Competencias;

use App\Mail\EnvioMail;
use App\Models\Competencia;
use App\Models\CompetenciaCategoria;
use App\Models\Poomsae;
use App\Models\PoomsaeCompetenciaCategoria;
use App\Models\Graduacion;
use App\Models\Categoria;
use App\Models\CompetenciaCompetidor;
use App\Models\CompetenciaJuez;
use App\Models\Pasada;
use App\Models\PasadaJuez;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Exception;
use Illuminate\Support\Facades\Mail;

class Agregar extends Component
{
    use WithFileUploads;

    public $competencia;
    protected $categorias;
    public $open = false;
    public $boton, $accionForm, $cambioEstado, $nombreBoton;
    public $titulo, $flyer, $bases, $descripcion, $fecha_inicio, $fecha_fin, $idCompetencia, $invitacion;
    public $categoria = array();

    protected $listeners = [
        'abrirModal',
        'mostrarDatos' => 'show'
    ];

    public function render()
    {
        $this->categorias = Categoria::get();
        $categorias = $this->categorias;
        return view('livewire.competencias.agregar', ['categorias' => $categorias]);
    }

    public function abrirModal($accion)
    {
        $this->resetValidation();
        $this->reset();
        $this->boton = $accion;
        $this->accionForm = 'create';
        $this->open = true;
    }
    public function cerrarModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->open = false;
    }

    public function create()
    {

        $validate = $this->validate([
            'titulo' => ['required', 'max:120', 'unique:competencias'],
            'flyer' => ['required', 'image', 'max:2048'],
            'bases' => ['required', 'mimes:pdf,docx'],
            'invitacion' => ['required', 'mimes:pdf,docx'],
            'descripcion' => ['required', 'max:120'],
            'fecha_inicio' => ['required', 'date', 'after_or_equal:today'],
            'fecha_fin' => ['required', 'date', 'after:fecha_inicio'],
            'categoria' => ['required', 'array'],
        ]);
        // Definimos las rutas de los archivos.
        $urlImagen = $this->flyer->store('competencias', 'public');
        $urlBases = $this->bases->store('competencias', 'public');
        $urlInvitacion = $this->bases->store('competencias', 'public');
        // guardamos el array con las categorias asignadas a la competencia.
        $categoria = $validate['categoria'];

        // Iniciamos la transaccion para multiples operaciones.
        DB::beginTransaction();

        try {

            // Creamos una competencia.
            $competencia = Competencia::create([
                'titulo' => $validate['titulo'],
                'flyer' => $urlImagen,
                'bases' => $urlBases,
                'invitacion' => $urlInvitacion,
                'descripcion' => $validate['descripcion'],
                'fecha_inicio' => $validate['fecha_inicio'],
                'fecha_fin' => $validate['fecha_fin'],
            ]);


            if (count($categoria) > 0) {
                // Obtenemos todas las graduaciones para asignarle 2 poomsaes a cada una.
                $graduaciones = Graduacion::get();

                // Creamos un registro por cada categoria que se asigno a la competencia.
                foreach ($categoria as $idCategoria) {

                    // Crear registros en la tabla CompetenciaCategoria, segun las categorias asignadas a la competencia creada.
                    $competenciaCategoria = CompetenciaCategoria::create([
                        'id_competencia' => $competencia->id,
                        'id_categoria' => $idCategoria,
                    ]);


                    // Sorteamos los poomsaes para cada graduacion de cada categoria.
                    if (count($graduaciones) > 0) {
                        foreach ($graduaciones as $graduacion) {

                            // Obtenemos un poomsae aleatorio para la primer pasada.
                            $poomsaeRandom1 = Poomsae::inRandomOrder()->first();
                            // Obtenemos un poomsae aleatorio para la segunda pasada.
                            $poomsaeRandom2 = Poomsae::inRandomOrder()->first();

                            $poomsaeC = PoomsaeCompetenciaCategoria::create([
                                'id_competencia_categoria' => $competenciaCategoria->id,
                                'id_poomsae1' => $poomsaeRandom1->id,
                                'id_poomsae2' => $poomsaeRandom2->id,
                                'id_graduacion' => $graduacion->id,
                            ]);
                        }
                    } else {
                        throw new Exception("Error al agregar competencia. Agrega graduaciones e intenta de nuevo.");
                    }
                }
            } else {
                throw new Exception("Error al agregar competencia. Agrega categorias e intenta de nuevo.");
            }




            session()->flash('msj', 'Competencia creada exitosamente.');
            // Confirmamos las transacciones si no hubo ningun error.
            DB::commit();
            $this->emit('msjAccion', [true, 'Se agrego la competencia']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('msjAccion', [false, $e->message]);
            // session()->flash('msj', [$e->getMessage(), false]);
        }

        $this->reset();
        $this->emit('recarga');
    }

    public function update()
    {

        $validate = $this->validate([
            'titulo' => ['required', 'max:120'],
            'descripcion' => ['required', 'max:120'],
        ]);

        $competencia = Competencia::find($this->idCompetencia);
        $competencia->titulo = $validate['titulo'];
        $competencia->descripcion = $validate['descripcion'];



        $competencia->save() ? $this->emit('msjAccion', [true, 'Se actualizo la competencia']) : $this->emit('msjAccion', [false, 'Error al actualizar, intente de nuevo.']);
        $this->open = false;
        $this->emit('recarga');
    }

    public function show($parametros)
    {
        $this->resetValidation();
        $this->boton = $parametros[1];
        $this->accionForm = 'update';

        $competencia = Competencia::find($parametros[0]);
        $this->competencia = $competencia;
        $this->idCompetencia = $competencia->id;
        $this->titulo = $competencia->titulo;
        $this->descripcion = $competencia->descripcion;
        $this->fecha_inicio = $competencia->fecha_inicio;
        $this->fecha_fin = $competencia->fecha_fin;

        // $this->manejoEstadosCompetencias($competencia->estado);

        $this->open = true;
    }

    // Competencia en estado 1 la modificamos a estado 2
    public function abrirInscripciones($id)
    {
        $cantJueces = CompetenciaJuez::where('id_competencia', $id)->count();
        // Verificamos que esta la cantidad de jueces necesaria para pasar de estado.
        if ($cantJueces == 3 || $cantJueces == 5 || $cantJueces == 7){
            $competencia = Competencia::find($id);
            $competencia->estado = 2;
            $competencia->save();
            $this->emit('recarga');
            $this->emit('msjAccion', [true, 'Se abrieron las inscripciones correctamente.']);
            $this->open = false;
        } else{
            $msj = 'Se deben inscribir 3, 5 o 7 jueces para abrir inscripciones. Hay '.$cantJueces.' Inscriptos';
            $this->emit('msjAccion', [false, $msj]);
            $this->open = false;
        }
    }

    // Competencia en estado 2 la modificamos a estado 3
    public function cerrarConvocatoria($id)
    {
        $bool = false;
        $competencia = Competencia::find($id);
        $competencia->estado = 3;

        if ($competencia->save()) {
            $this->enviarMailPoomsae($id);
            $this->crearPasadasJuez($id);
            $competenciaCompetidor = CompetenciaCompetidor::where('id_competencia', $id)->where('aprobado', 0)->delete();
            $this->emit('msjAccion', [true, 'Se cerro la convocatoria correctamente']);
            $bool = true;
        } else {
            $this->emit('msjAccion', [false, 'Error al cambiar de estado la competencia']);
        }

        if ($bool) {
            $this->open = false;
        }

        $this->emit('recarga');
    }

    // Competencia en estado 3 la modificamos a estado 4
    public function iniciarCompetencia($id)
    {
        $competencia = Competencia::find($id);
        $fechaActual = date('Y-m-d');
        $competencia->estado = 4;
        $competencia->fecha_inicio = $fechaActual;
        $competencia->save();
        $this->emit('recarga');
        $this->emit('msjAccion', [true, 'Empezo la competencia correctamente.']);
        $this->open = false;
    }

    // Competencia en estado 4 la modificamos a estado 5
    public function terminarCompetencia($id)
    {
        $competencia = Competencia::find($id);
        $fechaActual = date('Y-m-d');
        $competencia->estado = 5;
        $competencia->fecha_fin = $fechaActual;
        $competencia->save();
        $this->emit('recarga');
        $this->emit('msjAccion', [true, 'Finalizo la competencia correctamente.']);
        $this->open = false;
    }

    // Competencia en estado 5 la modificamos a estado 0
    public function delete($id) {
        $competencia = Competencia::find($id);
        $competencia->estado = 0;
        $competencia->save();
        $this->emit('recarga');
        $this->emit('msjAccion', [true, 'Se elimino la competencia correctamente.']);
        $this->open = false;
    }


    public function crearPasadasJuez($id){
        $competenciaJuez = CompetenciaJuez::where('id_competencia', $id)->get();
        $pasadas = Pasada::where('id_competencia', $id)->get();
        foreach ($competenciaJuez as $juez) {
            foreach ($pasadas as $pasada) {
                PasadaJuez::create([
                    'id_juez' => $juez->id_juez,
                    'id_pasada' => $pasada->id,
                ]);
            }
        }
    }



    private function enviarMailPoomsae($idCompetencia)
    {
        $competidores = CompetenciaCompetidor::where('id_competencia', $idCompetencia)->join('users', 'users.id', 'competencia_competidor.id_competidor')->select('email', 'users.id')->get();
        foreach ($competidores as $competidor) {
            Mail::to($competidor->email)->send(new EnvioMail($competidor->id, 5, $idCompetencia));
        }
    }

    private function manejoEstadosCompetencias($estado)
    {

        switch ($estado) {
            case '2':
                $this->nombreBoton = "Cerrar Convocatoria";
                $this->cambioEstado = "cerrarConvocatoria";
                break;
            case '3':
                $this->nombreBoton = "Iniciar Competencia";
                $this->cambioEstado = "iniciarCompetencia";
                break;
            case '4':
                $this->nombreBoton = "Terminar Competencia";
                $this->cambioEstado = "terminarCompetencia";
                break;
        }
    }
}
