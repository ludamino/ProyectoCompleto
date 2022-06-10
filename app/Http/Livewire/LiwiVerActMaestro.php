<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class LiwiVerActMaestro extends Component
{

    public $id_alumno;
    public $id_actividad;

    public function render()
    {
        return view('livewire.liwi-ver-act-maestro', [
            'datos_data' => $this->contenidos_de_actividad(),
            'respuestas_data' => $this->solo_ver_respuestas(),
        ]);
    }

    public function mount($post)
    {
        // Resets the pagination after reloading the page

        $datos = explode('-', $post);

        $this->id_actividad = $datos[0];
        $this->id_alumno = $datos[1];
    }

    public function contenidos_de_actividad()
    {

        return
            DB::table('mdl_actividads')
            ->join('mdl_actividad_contenidos', 'mdl_actividad_contenidos.clv_actividad', '=', 'mdl_actividads.id')
            ->where('mdl_actividads.id', '=', $this->id_actividad)
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
            ->where('mdl_actividads.id', '=', $this->id_actividad)
            ->where('users.id', '=', $this->id_alumno)
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
}
