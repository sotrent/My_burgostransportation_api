<?php
namespace Modules;
class AUTH{

  static function checkPermisos($modulo,$nivel){
    if(!empty($_SESSION["submodules"])){
      $submodulesRAW=$_SESSION["submodules"];
    }
    $submodules=json_decode($submodulesRAW);
    $permiso="";
    if(!empty($submodules->$modulo)){
      $permisos=$submodules->$modulo;
      $permiso=$permisos->$nivel;
    }
    return $permiso;
  }


  static function exist($quien,$pass){
    $find=0;
    $consulta="SELECT id,password FROM crm_users where user='$quien'";
    $result=DB::simpleQuery($consulta);
    //print_r($result);
    if($result->num_rows==0){
      $find="404";
    }else {
      $passmd=md5($pass);
      $passorg=$result->fetch_object()->password;
      if($passorg==$passmd){
        $find="200";
      }else{
        $find="401";
      }
      //print_r($result->num_rows);
    }
    return $find;
  }

  static function initsess($user,$contra){
    $permisos=self::getCredentialInfo($user,$contra);
    session_start();
    $_SESSION['code']="ACTIVE";
    if(!empty($permisos)){
      $_SESSION['modules']=$permisos->modules;
      $_SESSION['submodules']=$permisos->actions;
      $_SESSION['nick']=$permisos->user;
      $_SESSION['userMail']=$permisos->email;
      $_SESSION['modo']=$permisos->mode;
    }
    //print_r($_SESSION);
    return true;
  }

  static function getCredentialInfo($quien,$pass){
    $params="";
    $passmd=md5($pass);
    $consulta="SELECT user,email,modules,actions,mode FROM crm_users where user='$quien' and password='$passmd'";
    $result=DB::simpleQuery($consulta);
    if($result){
      $params=$result->fetch_object();
      //print_r($params);
    }
    return $params;
  }

  static function crushsesion(){
    session_start();
    session_destroy();
  }
}
