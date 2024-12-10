<?php

namespace Model;

class Admin extends ActiveRecord{
   //Conexión a la BBDD
   protected static $db;
   //Tabla
   protected static $tabla = 'usuarios';
   //Columnas BBDD
   protected static $columnasDB = ['id', 'email', 'password'];

   //Atributos
   public $id;
   public $email;
   public $password;

   //Constructor
   public function __construct($args=[]){
      $this->id = $args['id'] ?? null;
      $this->email = $args['email'] ?? '';
      $this->password = $args['password'] ?? '';
   }

   //Validar campos formulario
   public function validarAdmin(){
      if(!$this->email){
         self::setAlerta('error', 'El email es obligatorio');
      }
      if(!$this->password){
          self::setAlerta('error', 'El password es obligatorio');
      }
      return self::getAlertas();
   }

   //Hashear Password con password_hash
   public function hashPassword(){
      //reescribimos el password
      $this->password= password_hash($this->password, PASSWORD_BCRYPT);
   }

   //Verificar Password con password_verify
   public function verificarPassword($resultado){
      $autenticado = password_verify($this->password, $resultado->password);
      return $autenticado;
   }

   //Autenticar
   public function autenticar(){
      session_start();
      //Llenar el arreglo de sesión
      $_SESSION['auth'] = $this->email;
      $_SESSION['login'] = true;

      header('Location: /admin');

   }
}