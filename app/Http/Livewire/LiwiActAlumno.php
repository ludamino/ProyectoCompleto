<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\mdl_materia;
use App\Models\mdl_actividad_contenido;
use App\Models\mdl_actividad;
use App\Models\mdl_act_alumno;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\User as Authenticatable;


class LiwiActAlumno extends Component
{

    use WithPagination;


    /** INICIO --- Variables para el controlador de Materia --- INICIO **/

    public $id_materia;

    /** FIN --- Variables para el controlador de Materia  --- FIN **/



    /** ✢✢✢✢ INICIO --- Metodos de lectura  --- INICIO ✢✢✢✢ **/
    public function mount($post)
    {
        // Resets the pagination after reloading the page
        $this->id_materia = $post;

        $this->resetPage();
    }

    /**
     * Metodo que retorna los resultados en la vista.
     *
     * @return void
     */
    public function render()
    {

        return view('livewire.liwi-act-alumno', [
            'asignar_data' => $this->act_asignadas(),

        ]);
    }

    /**
     * Metodo que retorna los resultados en la vista de la tabla actividad
     *
     * @return void
     */
    public function act_asignadas()
    {
        return
            DB::table('mdl_asignars')
            ->join('mdl_actividads', 'mdl_actividads.id', '=', 'mdl_asignars.clv_actividad')
            ->join('mdl_materias', 'mdl_materias.id', '=', 'mdl_actividads.clv_materia')
            ->where('mdl_asignars.clv_usuario', '=', auth()->id())
            ->where('mdl_actividads.clv_materia', '=', $this->id_materia)
            ->select(
                'mdl_asignars.id AS id_asignar',
                'mdl_asignars.clv_actividad',
                'mdl_asignars.clv_usuario',
                'mdl_asignars.estado',
                'mdl_actividads.id AS id_actividad',
                'mdl_actividads.nombre_actividad',
                'mdl_actividads.link_video',
                'mdl_actividads.Documento',
                'mdl_actividads.fecha_entrega',
                'mdl_actividads.clv_materia',
                'mdl_materias.id AS id_materia',
                'mdl_materias.materia'
            )->get();
    }

    /** ✢✢✢✢ FIN --- Metodos de lectura  --- FIN ✢✢✢✢ **/

    /** INICIO --- Metodos del CRUD --- INICIO **/

    
    /** ✢☸✢☸✢ FIN --- Metodos del CRUD --- FIN ✢☸✢☸✢ **/
}
