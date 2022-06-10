<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class LiwiAlumnoCursos extends Component
{
    use WithPagination;
    /** INICIO --- Variables para el controlador de Materia --- INICIO **/

    /** FIN --- Variables para el controlador de Materia  --- FIN **/



    /** ✢✢✢✢ INICIO --- Metodos de lectura  --- INICIO ✢✢✢✢ **/


    /**
     * Metodo que retorna los resultados en la vista.
     *
     * @return void
     */
    public function render()
    {

        return view('livewire.liwi-alumno-cursos', [
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
            ->join('users', 'mdl_asignars.clv_usuario', '=', 'users.id')
            ->join('mdl_actividads', 'mdl_asignars.clv_actividad', '=', 'mdl_actividads.id')
            ->join('mdl_materias', 'mdl_actividads.clv_materia', '=', 'mdl_materias.id')
            ->where('mdl_asignars.clv_usuario', '=', auth()->id())
            ->select(
                'mdl_materias.id AS id_materia',
                'mdl_materias.materia'
            )->distinct()->get();
    }

        /**
     * Metodo que retorna los resultados en la vista de la tabla actividad
     *
     * @return void
     */
    public function act_asignadas_mas_datos()
    {
        return
            DB::table('mdl_asignars')
            ->join('users', 'mdl_asignars.clv_usuario', '=', 'users.id')
            ->join('mdl_actividads', 'mdl_asignars.clv_actividad', '=', 'mdl_actividads.id')
            ->join('mdl_materias', 'mdl_actividads.clv_materia', '=', 'mdl_materias.id')
            ->where('mdl_asignars.clv_usuario', '=', auth()->id())
            ->select(
                'mdl_asignars.id AS id_asignar',
                'mdl_asignars.clv_actividad',
                'mdl_asignars.clv_usuario',
                'users.id AS id_alumno',
                'users.name',
                'users.email',
                'users.telefono',
                'users.clv_tipo_usuario',
                'mdl_actividads.nombre_actividad',
                'mdl_actividads.id AS id_actividad',
                'mdl_actividads.link_video',
                'mdl_actividads.fecha_entrega',
                'mdl_actividads.clv_maestro',
                'mdl_actividads.clv_materia',
                'mdl_materias.id AS id_materia',
                'mdl_materias.materia'
            )->get();
    }
    /** ✢✢✢✢ FIN --- Metodos de lectura  --- FIN ✢✢✢✢ **/

    /** INICIO --- Metodos del CRUD --- INICIO **/

    public function mount()
    {
        // Resets the pagination after reloading the page


        $this->resetPage();
    }
    /** ✢☸✢☸✢ FIN --- Metodos del CRUD --- FIN ✢☸✢☸✢ **/
}
