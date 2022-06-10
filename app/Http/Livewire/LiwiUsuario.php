<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Mdl_tipo_usuario;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\PasswordValidationRules;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class LiwiUsuario extends Component
{

    use WithPagination;
    use PasswordValidationRules;

    /** INICIO --- Variables para el controlador de USUARIOS  --- INICIO **/
    public $modalFormVisible = false;
    public $modal_ConfirmDeleteVisible = false;
    public $modalId = null;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $telefono;
    public $clv_tipo_usuario;
    public $solicitud;

    public $terms;

    public $check_password_update = null;
    public $check_password_insert = null;

    public $busqueda_id;


    /** FIN --- Variables para el controlador de USUARIOS  --- FIN **/



    /** INICIO --- Metodos de lectura  --- INICIO **/

    /**
     * render
     * Metodo que retorna los resultados en la vista.
     * @return void
     */
    public function render()
    {

        return view('livewire.liwi-usuario', [
            'data' => $this->read(),
            'Tipo_user' => Mdl_tipo_usuario::all(),

        ]);
    }




    /**
     * read
     * Metodo que realiza la paginacion de lso resultados
     * Recibe un paramero que es el numero de resultaos por pagina.
     * @return void
     */
    public function read()
    {

        if ($this->busqueda_id == null || $this->busqueda_id == 'todos'  ) {

            return
                DB::table('users')
                ->join('mdl_tipo_usuarios', 'users.clv_tipo_usuario', '=', 'mdl_tipo_usuarios.id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.password',
                    'users.telefono',
                    'users.solicitud',
                    'users.clv_tipo_usuario',
                    'mdl_tipo_usuarios.tipo_usuario'
                )->paginate(5);
        } else {
            return
                DB::table('users')
                ->join('mdl_tipo_usuarios', 'users.clv_tipo_usuario', '=', 'mdl_tipo_usuarios.id')
                ->where('users.clv_tipo_usuario', '=', $this->busqueda_id)
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.password',
                    'users.telefono',
                    'users.solicitud',
                    'users.clv_tipo_usuario',
                    'mdl_tipo_usuarios.tipo_usuario'
                )->paginate(5);
        }
    }

    /** FIN --- Metodos de lectura  --- FIN **/


    /** INICIO --- Ventanas modales para el CRUD de Usuarios --- INICIO **/


    /**
     * createShowModal
     * Crea el modal para inserter un nuevo registro.
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->limpiar();
        $this->check_password_insert = 2;
        $this->modalFormVisible = true;
    }


    /**
     * updateShowModal
     * Metodo para abrir la ventana modal de edicio
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
     * etodo para la ventana modal de eliminar
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modalId = $id;
        $data = User::find($this->modalId);
        $this->modal_ConfirmDeleteVisible = true;
    }

    /** FIN --- Ventanas modales para el CRUD de Usuarios --- FIN **/

    /** INICIO --- Metodos del CRUD --- INICIO **/


    /**
     * create
     * Metodo para INSERTAR a la base de datos
     * @return void
     */
    public function create()
    {
        $this->validate();
        if (User::create($this->modelData())) {
            session()->flash('message_t_c', 'Registro Insertado');
        } else {
            session()->flash('message_f', 'Error al Insertar');
        }

        $this->modalFormVisible = false;
    }

    /**
     * update
     * Metodo para ACTUALIZAR en la base de datos
     * @return void
     */
    public function update()
    {
        $this->validate();
        if (User::find($this->modalId)->update($this->modelData())) {
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
        if (User::destroy($this->modalId)) {
            session()->flash('message_t_d', 'Registro Eliminado');
        } else {
            session()->flash('message_f', 'Error al Eliminar');
        }

        $this->modal_ConfirmDeleteVisible = false;
    }



    /**
     * modelData
     * Metodo que recolecta los valores del formulario y las asigna a las varaibles del controlador
     * @return void
     */
    public function modelData()
    {
        if ($this->check_password_insert == 2) {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'telefono' => $this->telefono,
                'clv_tipo_usuario' => $this->clv_tipo_usuario,


            ];
        }

        if ($this->check_password_update == 1) {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'telefono' => $this->telefono,
                'clv_tipo_usuario' => $this->clv_tipo_usuario,


            ];
        } else {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'clv_tipo_usuario' => $this->clv_tipo_usuario,


            ];
        }
    }

    /**
     * loadModel
     * Metodo que carga los valores de un registro en el formulario de edicion
     * @return void
     */
    public function loadModel()
    {
        $data = User::find($this->modalId);
        $this->name = $data->name;
        $this->email = $data->email;
        /* $this->password = $data->password;*/
        $this->telefono = $data->telefono;
        $this->clv_tipo_usuario = $data->clv_tipo_usuario;
    }

    /**
     * rules
     * Metodo de validacion de los campos del formulario
     * @return void
     */
    public function rules()
    {

        if ($this->modalId) {
            if ($this->check_password_update == 1) {
                return [

                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->modalId)],
                    'password' => $this->passwordRules(),
                    'clv_tipo_usuario' => ['required', 'integer', 'max:255'],
                    'telefono' => ['required', 'string', 'max:255'],

                    'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',

                ];
            } else {
                return [

                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->modalId)],
                    'clv_tipo_usuario' => ['required', 'integer', 'max:255'],
                    'telefono' => ['required', 'string', 'max:255'],
                    'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',

                ];
            }
        } else {


            return [

                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'clv_tipo_usuario' => ['required', 'integer', 'max:255'],
                'telefono' => ['required', 'string', 'max:255'],

                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',

            ];
        }
    }



    /**
     * limpiar
     *  Metodo para limpiar los campos despues de realizar una accion.
     * @return void
     */
    public function limpiar()
    {

        $this->modalId = null;
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->password_confirmation = null;
        $this->clv_tipo_usuario = null;
        $this->telefono = null;


        $this->check_password_update = null;
        $this->check_password_insert = null;
    }

    /**
     * generar_password
     * Metodo para generar una contraseña
     * @return void
     */
    public function generar_password()
    {
        //Carácteres para la contraseña
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $passwordgenerate = "";
        //Reconstruimos la contraseña segun la longitud que se quiera
        for ($i = 0; $i < 10; $i++) {
            //obtenemos un caracter aleatorio escogido de la cadena de caracteres
            $passwordgenerate .= substr($str, rand(0, 62), 1);
        }
        //Mostramos la contraseña generada
        $this->password = $passwordgenerate;
        $this->password_confirmation = $passwordgenerate;
    }

    public function mount()
    {
        // Resets the pagination after reloading the page
        $this->resetPage();
    }



    /**
     * activar_pass
     *
     * @return void
     */
    public function activar_pass()
    {


        if ($this->check_password_update == null) {
            $this->check_password_update = 1;
        } else {
            $this->check_password_update = null;
        }
    }

    /** FIN --- Metodos del CRUD --- FIN **/
}
