<?php
namespace Model;
use Model\ActiveRecord;
class Usuario extends ActiveRecord {
    protected static $tabla='usuarios'; 
    protected static $columnasDB=['id','nombre','usuario','surcursal','password','status','telefono','email','nivel'];

    public $id;
    public $nombre;
    public $usuario;
    public $password;
    public $password2;
    public $status;
    public $nivel;
    public $surcursal;
    public $telefono;
    public $email;

    public function __construct($args=[]){
        $this->id=$args['id']??null;
        $this->nombre=$args['nombre']??'';
        $this->usuario=$args['usuario']??'';
        $this->password=$args['password']??'';
        $this->password2=$args['password2']??'';
        $this->status=$args['status']??'0';
        $this->nivel=$args['nivel']??'0';
        $this->surcursal=$args['surcursal']??'';
        $this->telefono=$args['telefono']??'';
        $this->email=$args['email']??'';

    }

    public function validarLogin(){

        if(!$this->usuario){
            self::$alertas['error'][]='El nombre de usuario es obligatorio';
        }

        if(!$this->password){
            self::$alertas['error'][]='El password no puede ir vacio';
        }

        if(strlen($this->password)<6){
            self::$alertas['error'][]='El password debe contener al menos 6 carácteres';
        }

        return self::$alertas;
    }

    public function validarCuenta()
    {

        if(!$this->usuario){
            self::$alertas['error'][]='El nombre del Usuario es Obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][]='El email del Usuario es Obligatorio';
        }

        if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][]='Email no válido';
        }


        if(!$this->password){
            self::$alertas['error'][]='El password no puede ir vacio';
        }

        if(strlen($this->password)<6){
            self::$alertas['error'][]='El password debe contener al menos 6 carácteres';
        }
        if($this->password !== $this->password2){
            self::$alertas['error'][]='Los password son diferentes';
        }

        if(!$this->nombre){
            self::$alertas['error'][]='El nombre del Empleado es Obligatorio';
        }

        if(!$this->telefono){
            self::$alertas['error'][]='El telefono es Obligatorio';
        }

        if(!$this->surcursal){
            self::$alertas['error'][]='La surcursal es obligatoria';
        }

        if(!$this->status){
            self::$alertas['error'][]='El status es obligatorio';
        }

        return self::$alertas;
    }
    


   public function hashearPassword(){
        $this->password=password_hash($this->password,PASSWORD_BCRYPT);
    }

   

    public function validarPerfil(){
        if(!$this->usuario){
            self::$alertas['error'][]='El Nombre es Obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][]='El Email es Obligatorio';
        }

        if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][]='Email no válido';
        }

        return self::$alertas;

    }

    public function nuevo_password(){
        if(!$this->passwordActual){
            self::$alertas['error'][]='El Password Actual no puede ir vacio';
        }

        if(!$this->passwordNuevo){
            self::$alertas['error'][]='El Password Nuevo no puede ir vacio';
        }
        if(strlen($this->passwordNuevo)<6){
            self::$alertas['error'][]='El Password Nuevo debe tener al menos 6 carácteres';
        }

        return self::$alertas;
    }

    public function comprobarPassword(){
      return  password_verify($this->passwordActual,$this->password);
    }
}