<?php

namespace App\Http\Livewire\Puntuador;

use Livewire\Component;
use App\Models\PasadaJuez;
use App\Models\Pasada;
use App\Events\EnviarPasada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Pulsador extends Component {

    public $pasada = null;
    public $tipoPuntaje = 1;
    public $puntaje = 10;
    public $puntajeExactitud;
    public $puntajePresentacion;

    protected $listeners = ['render' => 'render'];

    public function render() {
        return view('livewire.puntuador.pulsador');
    }


    public function traerPasada()
    {
        $pasada = Pasada::where('seleccionado', 1)->first();
        if ($pasada != null){
            $this->pasada = $pasada;
            $this->emit('render');
        }
    }

    public function store() {
        $this->puntajePresentacion = $this->puntaje;
        $idJuez = Auth::id();
        $pasada = $this->pasada;
        $pasadaJuez = PasadaJuez::where('id_juez', $idJuez)->where('id_pasada', $idPasada)->first();
        $pasadaJuez->puntaje_exactitud = $this->puntajeExactitud;
        $pasadaJuez->puntaje_presentacion = $this->puntajePresentacion;
        $pasadaJuez->save();
    }

    public function resto1() {
        $puntaje = $this->puntaje;
        if ($puntaje > 0.1){
            $this->puntaje = $puntaje - 0.1;
        } else{
            $this->puntaje = 0;
        }
    }

    public function resto3() {
        $puntaje = $this->puntaje;
        if ($puntaje > 0.3){
            $this->puntaje = $puntaje - 0.3;
        } else{
            $this->puntaje = 0;
        }
    }

    public function enviar() {
        $tipoPuntaje = $this->tipoPuntaje;
        if ($tipoPuntaje == 1){
            $this->puntajeExactitud = $this->puntaje;
            $this->puntaje = 10;
            $this->tipoPuntaje = 2;
        } elseif ($tipoPuntaje == 2){
            $this->puntajePresentacion = $this->puntaje;
            $this->store();
        }
    }

    /**
     * Método para consultar la cantidad de jueces por pasada
     */
    public function cantJueces( $idPasada ){
        $cantJuecesPasada = DB::table('pasada_juez')
            ->where('id_pasada', $idPasada)
            ->count();
        return $cantJuecesPasada;
    }

}
