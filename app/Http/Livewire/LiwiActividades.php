<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\mdl_actividad;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\mdl_materia;


class LiwiActividades extends Component
{

    use WithPagination;


    /** INICIO --- Variables para el controlador de Materia --- INICIO **/
    public $modalFormVisible = false;
    public $modal_ConfirmDeleteVisible = false;
    public $modalId = null;

    public $nombre_actividad;
    public $link_video;
    public $Documento;
    public $fecha_entrega;
    public $materia;
    public $clv_materia;
    public $clv_maestro;


    public $Confirma = false;

    /** FIN --- Variables para el controlador de Materia  --- FIN **/


    /** ✢✢✢✢ INICIO --- Metodos de lectura  --- INICIO ✢✢✢✢ **/


    /**
     * Metodo que retorna los resultados en la vista.
     *
     * @return void
     */
    public function render()
    {


        return view('livewire.liwi-actividades', [
            'data' => $this->read(),
            'selec_materia' => mdl_materia::all(),

        ]);
    }

    /**
     * Metodo que realiza la paginacion de lso resultados
     * Recibe un paramero que es el numero de resultaos por pagina.
     * @return void
     */
    public function read()
    {
        return
            DB::table('mdl_actividads')
            ->join('mdl_materias', 'mdl_actividads.clv_materia', '=', 'mdl_materias.id')
            ->where('mdl_actividads.clv_maestro', '=', auth()->id())
            ->select(
                'mdl_actividads.id',
                'mdl_actividads.nombre_actividad',
                'mdl_actividads.link_video',
                'mdl_actividads.Documento',
                'mdl_actividads.fecha_entrega',
                'mdl_actividads.clv_materia',
                'mdl_actividads.clv_maestro',
                'mdl_actividads.estado',
                'mdl_materias.id AS idmat',
                'mdl_materias.materia'
            )->paginate(5);
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
        $data = mdl_actividad::find($this->modalId);
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
        if (mdl_actividad::create($this->modelData())) {
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
        if (mdl_actividad::find($this->modalId)->update($this->modelData())) {
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
        if (mdl_actividad::destroy($this->modalId)) {
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
            'nombre_actividad' => $this->nombre_actividad,
            'link_video' => $this->link_video,
            'fecha_entrega' => $this->fecha_entrega,
            'Documento' => $this->Documento,
            'clv_materia' => $this->clv_materia,
            'clv_maestro' => auth()->id(),

        ];
    }

    /**
     * loadModel
     *  Metodo que carga los valores de un registro en el formulario de edicion
     * @return void
     */
    public function loadModel()
    {
        $data = mdl_actividad::find($this->modalId);
        $this->nombre_actividad = $data->nombre_actividad;
        $this->link_video = $data->link_video;
        $this->Documento = $data->Documento;
        $this->fecha_entrega = $data->fecha_entrega;
        $this->clv_materia = $data->clv_materia;
        $this->clv_maestro = $data->clv_maestro;
    }


    /**
     * rules
     * Metodo de validacion de los campos del formulario
     * @return void
     */
    public function rules()
    {
        return [

            'nombre_actividad' => 'required',
            'fecha_entrega' => 'required',
            'clv_materia' => 'required',
            

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
        $this->nombre_actividad = null;
        $this->link_video = null;
        $this->Documento = null;
        $this->fecha_entrega = null;
        $this->materia = null;
        $this->clv_materia = null;
        $this->clv_maestro = null;
    }
    public function mount()
    {
        // Resets the pagination after reloading the page
        $this->resetPage();
    }




    /** ✢☸✢☸✢ FIN --- Metodos del CRUD --- FIN ✢☸✢☸✢ **/
}
