<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Models\mdl_respuestas;

use App\Models\mdl_asignar;

class LiwiContestarActividad extends Component
{

    use WithPagination;



    public $clv_actividad;
    public $id_asignar;
    public $id_materia;
    public $respuesta = [];
    public $id_cont = '';
    public $datospartidos;
    public $reglaarray = [];
    public  $errorid = -1;

    public function render()
    {
        return view('livewire.liwi-contestar-actividad', [
            'datos_data' => $this->contenidos_de_actividad(),
            'solo_id_data' => $this->ids_contenidos_de_actividad(),
            'asignar_data' => $this->datos_de_asignar(),
            'respuestas_data' => $this->solo_ver_respuestas(),

            

        ]);
    }

    public function mount($post)
    {
        // Resets the pagination after reloading the page

        $datos = explode('-', $post);

        $this->clv_actividad = $datos[0];
        $this->id_asignar = $datos[1];
        $this->id_materia = $datos[2];
        $this->resetPage();
    }

    public function contenidos_de_actividad()
    {

        return
            DB::table('mdl_actividads')
            ->join('mdl_actividad_contenidos', 'mdl_actividad_contenidos.clv_actividad', '=', 'mdl_actividads.id')
            ->where('mdl_actividads.id', '=', $this->clv_actividad)
            ->select(
                'mdl_actividads.id AS id_actividad',
                'mdl_actividads.nombre_actividad',
                'mdl_actividads.link_video',
                'mdl_actividads.Documento',
                'mdl_actividads.fecha_entrega',
                'mdl_actividads.clv_materia',
                'mdl_actividads.clv_maestro',
                'mdl_actividad_contenidos.id AS id_contenido',
                'mdl_actividad_contenidos.pregunta',
                'mdl_actividad_contenidos.tipo_campo',
                'mdl_actividad_contenidos.clv_actividad'
            )->get();
    }



    public function solo_ver_respuestas()
    {

        return
            DB::table('mdl_actividads')
            ->join('mdl_actividad_contenidos', 'mdl_actividad_contenidos.clv_actividad', '=', 'mdl_actividads.id')
            ->join('mdl_respuestas', 'mdl_actividad_contenidos.id', '=', 'mdl_respuestas.clv_contenido')
            ->join('users', 'mdl_respuestas.clv_alumno', '=', 'users.id')
            ->where('mdl_actividads.id', '=', $this->clv_actividad)
            ->where('users.id', '=', auth()->id())
            ->select(
                'mdl_actividads.id AS id_actividad',
                'mdl_actividad_contenidos.id AS id_contenido',
                'mdl_actividad_contenidos.pregunta',
                'mdl_actividad_contenidos.tipo_campo',
                'mdl_actividad_contenidos.clv_actividad',
                'mdl_respuestas.id AS id_respuesta',
                'mdl_respuestas.respuesta',
                'mdl_respuestas.clv_contenido',
                'mdl_respuestas.clv_alumno'
            )->get();
    }

    public function datos_de_asignar()
    {

        return
            DB::table('mdl_asignars')
            ->where('mdl_asignars.id', '=', $this->id_asignar)
            ->select(
                'mdl_asignars.id AS id_asignacion',
                'mdl_asignars.clv_actividad',
                'mdl_asignars.clv_usuario',
                'mdl_asignars.estado'
            )->get();
    }


    public function ids_contenidos_de_actividad()
    {

        return
            DB::table('mdl_actividad_contenidos')
            ->where('mdl_actividad_contenidos.clv_actividad', '=', $this->clv_actividad)
            ->select(
                'mdl_actividad_contenidos.id',
            )->get();
    }


    public  function insertar()
    {
        $vueltas = 1;
        $this->validate();
        foreach ($this->respuesta as $pathGaleria) {
            $path = $pathGaleria;
            $this->datospartidos = explode('-', $this->id_cont);

            if (mdl_respuestas::create([
                'clv_actividad' => $this->clv_actividad,
                'clv_contenido' =>   $this->datospartidos[$vueltas],
                'clv_alumno' => auth()->id(),
                'respuesta' => $path

            ])) {
                session()->flash('message_t_c', 'Registro Insertado');
            } else {
                session()->flash('message_f', 'Error al Insertar');
            }

            $vueltas++;
        }

        if (mdl_asignar::find($this->id_asignar)->update($this->modelData())) {
            session()->flash('message_t_cd', 'Registro Actualizado');
        } else {
            session()->flash('message_dd', 'Error al Actualizar');
        }

        $this->limpiar();
    }

    /**
     * modelData
     * Metodo que recolecta los valores del formulario y las asigna a las varaibles del controlador
     * @return void
     */
    public function modelData()
    {
        return [
            'estado' => 'Terminado',

        ];
    }


    /**
     * rules
     * Metodo de validacion de los campos del formulario
     * @return void
     */
    public function rules()
    {
        return $this->reglaarray;
    }

    /**
     * limpiar
     *  Metodo para limpiar los campos despues de realizar una accion.
     * @return void
     */
    public function limpiar()
    {
        $this->respuesta = null;
        $this->id_cont = null;
        $this->datospartidos = null;
    }
}
