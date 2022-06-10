<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\mdl_materia;
use Livewire\WithPagination;

class LiwiMaterias extends Component
{
    
    use WithPagination;


    /** INICIO --- Variables para el controlador de Materia --- INICIO **/
    public $modalFormVisible = false;
    public $modal_ConfirmDeleteVisible = false;
    public $modalId = null;

    public $materia;
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
        $datos['data'] = $this->read();
        return view('livewire.liwi-materias', $datos);
    }

    /**
     * Metodo que realiza la paginacion de lso resultados
     * Recibe un paramero que es el numero de resultaos por pagina.
     * @return void
     */
    public function read()
    {
        return mdl_materia::paginate(5);
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
        $data = mdl_materia::find($this->modalId);
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
        if (mdl_materia::create($this->modelData())) {
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
        if (mdl_materia::find($this->modalId)->update($this->modelData())) {
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
        if (mdl_materia::destroy($this->modalId)) {
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
            'materia' => $this->materia,
        ];
    }

    /**
     * loadModel
     *  Metodo que carga los valores de un registro en el formulario de edicion
     * @return void
     */
    public function loadModel()
    {
        $data = mdl_materia::find($this->modalId);
        $this->materia = $data->materia;
    }

    /**
     * rules
     * Metodo de validacion de los campos del formulario
     * @return void
     */
    public function rules()
    {
        return [

            'materia' => 'required',

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
      $this->materia = null;
    }

    public function mount()
  {
      // Resets the pagination after reloading the page
      $this->resetPage();
  }

    /** ✢☸✢☸✢ FIN --- Metodos del CRUD --- FIN ✢☸✢☸✢ **/
}
