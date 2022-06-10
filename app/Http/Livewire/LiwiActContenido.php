<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\mdl_materia;
use App\Models\mdl_actividad_contenido;
use App\Models\mdl_actividad;
use Livewire\WithPagination;


class LiwiActContenido extends Component
{
    use WithPagination;

    /** INICIO --- Variables para el controlador de Materia --- INICIO **/
    public $modalFormVisible = false;
    public $modal_ConfirmDeleteVisible = false;
    public $modalId = null;

    public $pregunta;
    public $tipo_campo;
    public $clv_actividad;


    public $Confirma = false;

    public $id_actividad;

    /** FIN --- Variables para el controlador de Materia  --- FIN **/



    /** ✢✢✢✢ INICIO --- Metodos de lectura  --- INICIO ✢✢✢✢ **/


    public function mount($post)
    {
        // Resets the pagination after reloading the page

        $this->id_actividad = $post;
        $this->resetPage();
    }

    /**
     * Metodo que retorna los resultados en la vista de la tabla actividad
     *
     * @return void
     */
    public function actividad()
    {
        return DB::table('mdl_actividads')->where('id', '=', $this->id_actividad)->get();
    }

    /**
     * Metodo que retorna una consulta compuesta de la tabla de contenido de la actividad.
     *
     * @return void
     */
    public function contenidos_de_actividad()
    {
      
        return
            DB::table('mdl_actividad_contenidos')
            ->join('mdl_actividads', 'mdl_actividad_contenidos.clv_actividad', '=', 'mdl_actividads.id')
            ->join('mdl_materias', 'mdl_actividads.clv_materia', '=', 'mdl_materias.id')
            ->where('clv_actividad', '=', $this->id_actividad)
            ->select(
                'mdl_actividad_contenidos.id AS id_act_contenido',
                'mdl_actividad_contenidos.pregunta',
                'mdl_actividad_contenidos.tipo_campo',
                'mdl_actividad_contenidos.clv_actividad',
                'mdl_actividads.id AS id_actividads',
                'mdl_actividads.nombre_actividad',
                'mdl_actividads.link_video',
                'mdl_actividads.Documento',
                'mdl_actividads.fecha_entrega',
                'mdl_actividads.clv_materia',
                'mdl_materias.id AS id_materia',
                'mdl_materias.materia'
            )->get();

           
    }


    /**
     * Metodo que retorna los resultados en la vista.
     *
     * @return void
     */
    public function render()
    {

        return view('livewire.liwi-act-contenido', [
            'contenido_data' => $this->contenidos_de_actividad(),
            'actividad_data' => $this->actividad(),
        ]);
    }



    /** ✢✢✢✢ FIN --- Metodos de lectura  --- FIN ✢✢✢✢ **/


    /** ✢☸✢☸✢ INICIO --- Ventanas modales para el CRUD de Materia --- INICIO ✢☸✢☸✢ **/

    /**
     * createShowModal
     *  Crea el modal para inserter un nuevo registro.
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->limpiar();
        $this->modalFormVisible = true;
    }

    /**
     * updateShowModal
     * Metodo para abrir la ventana modal de edicion
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->limpiar();
        $this->modalId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }

    /**
     * deleteShowModal
     * Metodo para la ventana modal de eliminar
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modalId = $id;
        $data = mdl_actividad_contenido::find($this->modalId);
        $this->modal_ConfirmDeleteVisible = true;
    }

    /** FIN --- Ventanas modales para el CRUD de Materia --- FIN **/

    /** INICIO --- Metodos del CRUD --- INICIO **/

    /**
     * create
     * Metodo para INSERTAR a la base de datos
     * @return void
     */
    public function create()
    {
        $this->validate();
        if (mdl_actividad_contenido::create($this->modelData())) {
            session()->flash('message_t_c', 'Registro Insertado');
        } else {
            session()->flash('message_f', 'Error al Insertar');
        }

        $this->modalFormVisible = false;
        $this->limpiar();
    }

    /**
     * update
     * Metodo para ACTUALIZAR en la base de datos
     * @return void
     */
    public function update()
    {
        $this->validate();
        if (mdl_actividad_contenido::find($this->modalId)->update($this->modelData())) {
            session()->flash('message_t_u', 'Registro Actualizado');
        } else {
            session()->flash('message_f', 'Error al Actualizar');
        }

        $this->modalFormVisible = false;
    }

    /**
     * delete
     * Metodo para ELIMIAR en la base de datos
     * @return void
     */
    public function delete()
    {
        if (mdl_actividad_contenido::destroy($this->modalId)) {
            session()->flash('message_t_d', 'Registro Eliminado');
        } else {
            session()->flash('message_f', 'Error al Eliminar');
        }

        $this->modal_ConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * modelData
     * Metodo que recolecta los valores del formulario y las asigna a las varaibles del controlador
     * @return void
     */
    public function modelData()
    {
        return [
            'pregunta' => $this->pregunta,
            'tipo_campo' => $this->tipo_campo,
            'clv_actividad' => $this->id_actividad,


        ];
    }

    /**
     * loadModel
     *  Metodo que carga los valores de un registro en el formulario de edicion
     * @return void
     */
    public function loadModel()
    {
        $data = mdl_actividad_contenido::find($this->modalId);
        $this->pregunta = $data->pregunta;
        $this->tipo_campo = $data->tipo_campo;
        $this->clv_actividad = $data->clv_actividad;
    }


    /**
     * rules
     * Metodo de validacion de los campos del formulario
     * @return void
     */
    public function rules()
    {
        return [

            'pregunta' => 'required',
            'tipo_campo' => 'required',
        ];
    }

    /**
     * limpiar
     *  Metodo para limpiar los campos despues de realizar una accion.
     * @return void
     */
    public function limpiar()
    {
        $this->modalId = null;
        $this->pregunta = null;
        $this->tipo_campo = null;
        $this->clv_actividad = null;
    }

    /** ✢☸✢☸✢ FIN --- Metodos del CRUD --- FIN ✢☸✢☸✢ **/
}
