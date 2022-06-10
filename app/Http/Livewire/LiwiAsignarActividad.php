<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\mdl_actividad;
use App\Models\mdl_asignar;
use Livewire\WithPagination;

class LiwiAsignarActividad extends Component
{
    use WithPagination;

    /** INICIO --- Variables para el controlador de Asignar --- INICIO **/
    public $modalFormVisible = false;
    public $modal_ConfirmDeleteVisible = false;
    public $modalId = null;


    public $clv_actividad;
    public $clv_usuario;



    /** FIN --- Variables para el controlador de Asignar  --- FIN **/

    /** ✢✢✢✢ INICIO --- Metodos de lectura  --- INICIO ✢✢✢✢ **/


    /**
     * Metodo que retorna los resultados en la vista.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.liwi-asignar-actividad', [
            'asignar_data' => $this->tabla_asignar(),
            'usuarios_data' => $this->usuarios_info(),
            'actividad_data' => $this->actividad_info(),
        ]);
    }



    /**
     * Metodo que retorna los resultados en la vista de la tabla usuarios
     *
     * @return void
     */
    public function usuarios_info()
    {
        return DB::table('users')->where('clv_tipo_usuario', '=', 3)->get();
    }


    /**
     * Metodo que retorna los resultados en la vista de la tabla usuarios
     *
     * @return void
     */
    public function actividad_info()
    {
        return DB::table('mdl_actividads')->where('clv_maestro', '=', auth()->id())->get();
    }


    /**
     * Metodo que retorna una consulta compuesta de la tabla de contenido de la actividad.
     *
     * @return void
     */
    public function tabla_asignar()
    {
        return
            DB::table('mdl_asignars')
            ->join('mdl_actividads', 'mdl_asignars.clv_actividad', '=', 'mdl_actividads.id')
            ->join('users', 'mdl_asignars.clv_usuario', '=', 'users.id')
            ->where('mdl_actividads.clv_maestro', '=', auth()->id())
            ->select(
                'mdl_asignars.id AS id_asignar',
                'mdl_asignars.clv_actividad',
                'mdl_asignars.clv_usuario',
                'users.id AS id_usuario',
                'users.name',
                'mdl_actividads.id AS id_tabla_actividad',
                'mdl_actividads.nombre_actividad',
                'mdl_actividads.clv_maestro'
            )->get();
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
        $data = mdl_asignar::find($this->modalId);
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
        if (mdl_asignar::create($this->modelData())) {
            session()->flash('message_t_c', 'Registro Insertado');
            if (mdl_actividad::find($this->clv_actividad)->update($this->modelData_dos())) {
                session()->flash('message_t_cd', 'Registro Actualizado');
            } else {
                session()->flash('message_dd', 'Error al Actualizar');
            }
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
        if (mdl_asignar::find($this->modalId)->update($this->modelData())) {
            session()->flash('message_t_u', 'Registro Actualizado');
            if (mdl_actividad::find($this->clv_actividad)->update($this->modelData_dos())) {
                session()->flash('message_t_cd', 'Registro Actualizado');
            } else {
                session()->flash('message_dd', 'Error al Actualizar');
            }
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
        if (mdl_asignar::destroy($this->modalId)) {
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
            'clv_usuario' => $this->clv_usuario,
            'clv_actividad' => $this->clv_actividad,
        ];
    }

    /**
     * loadModel
     *  Metodo que carga los valores de un registro en el formulario de edicion
     * @return void
     */
    public function loadModel()
    {
        $data = mdl_asignar::find($this->modalId);

        $this->clv_usuario = $data->clv_usuario;
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

            'clv_usuario' => 'required',
            'clv_actividad' => 'required',
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
        $this->clv_usuario = null;
        $this->clv_actividad = null;
    }

        /**
     * modelData
     * Metodo que recolecta los valores del formulario y las asigna a las varaibles del controlador
     * @return void
     */
    public function modelData_dos()
    {
        return [
            'estado' => 'Asignada',

        ];
    }


    public function mount()
    {
        // Resets the pagination after reloading the page
        $this->resetPage();
    }

    /** ✢☸✢☸✢ FIN --- Metodos del CRUD --- FIN ✢☸✢☸✢ **/
}
