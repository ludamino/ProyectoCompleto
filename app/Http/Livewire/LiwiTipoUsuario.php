<?php

namespace App\Http\Livewire;

use App\Models\Mdl_tipo_usuario;
use Livewire\Component;
use Livewire\WithPagination;


class LiwiTipoUsuario extends Component
{
    use WithPagination;


      /** INICIO --- Variables para el controlador de TIPO DE USUARIO  --- INICIO **/
      public $modalFormVisible = false;
      public $modal_ConfirmDeleteVisible = false;
      public $modalId = null;
  
      public $tipo_usuario;
      public $Confirma = false;
  
      /** FIN --- Variables para el controlador de TIPO DE USUARIO  --- FIN **/
  
  
      /** ✢✢✢✢ INICIO --- Metodos de lectura  --- INICIO ✢✢✢✢ **/
  
  
      /**
       * Metodo que retorna los resultados en la vista.
       *
       * @return void
       */
      public function render()
      {
          $datos['data'] = $this->read();
          return view('livewire.liwi-tipo-usuario', $datos);
      }
  
      /**
       * Metodo que realiza la paginacion de lso resultados
       * Recibe un paramero que es el numero de resultaos por pagina.
       * @return void
       */
      public function read()
      {
          return Mdl_tipo_usuario::paginate(5);
      }
  
      /** ✢✢✢✢ FIN --- Metodos de lectura  --- FIN ✢✢✢✢ **/
  
  
      /** ✢☸✢☸✢ INICIO --- Ventanas modales para el CRUD de Analisis --- INICIO ✢☸✢☸✢ **/
  
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
          $data = Mdl_tipo_usuario::find($this->modalId);
          $this->modal_ConfirmDeleteVisible = true;
      }
  
      /** FIN --- Ventanas modales para el CRUD de Analisis --- FIN **/
  
      /** INICIO --- Metodos del CRUD --- INICIO **/
  
  
  
      /**
       * create
       * Metodo para INSERTAR a la base de datos
       * @return void
       */
      public function create()
      {
          $this->validate();
          if (Mdl_tipo_usuario::create($this->modelData())) {
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
          if (Mdl_tipo_usuario::find($this->modalId)->update($this->modelData())) {
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
          if (Mdl_tipo_usuario::destroy($this->modalId)) {
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
              'tipo_usuario' => $this->tipo_usuario,
          ];
      }
  
      /**
       * loadModel
       *  Metodo que carga los valores de un registro en el formulario de edicion
       * @return void
       */
      public function loadModel()
      {
          $data = Mdl_tipo_usuario::find($this->modalId);
          $this->tipo_usuario = $data->tipo_usuario;
      }
  
      /**
       * rules
       * Metodo de validacion de los campos del formulario
       * @return void
       */
      public function rules()
      {
          return [
  
              'tipo_usuario' => 'required',
  
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
        $this->tipo_usuario = null;
      }

      public function mount()
    {
        // Resets the pagination after reloading the page
        $this->resetPage();
    }
  
      /** ✢☸✢☸✢ FIN --- Metodos del CRUD --- FIN ✢☸✢☸✢ **/
}
