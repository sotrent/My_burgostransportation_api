<?php
namespace Modules;

class AGENTS{

  static function getList($params=""){

    switch ($params["mode"]) {
      case 'target':
        $filter=" where name like '%".$params["info"]."%' OR user like '%".$params["info"]."%' OR mode like '%".$params["info"]."%' OR email like '%".$params["info"]."%'";
        break;
      case 'unique':
        $filter=" where id=".$params["id"];
        break;
      case 'uniqueBycode':
        $filter=" where user='".$params["code"]."'";
        break;
      case 'selectlist':
        $filter=" where status=1 and mode='agente'";
        break;
      default:
        $filter="";
        break;
    }
    $sql="select id,user,name,email,modules,area, mode as tipo,status from crm_users".$filter;
    $result=DB::procesedQuery($sql);
    return $result;

  }

  static function setAgent($params=""){
    if(empty($params)){ return "ERR"; }
    switch ($params["agtTipo"]) {
      case 'agente':
        $modulos="RES";
        $permisos='{"RES":{"CAT":"W","PAY":"R"}}';
        $permisos=addslashes($permisos);
      break;
      case 'trafico':
        $modulos="RES;DRV;BIN";
        $permisos='{"RES":{"CAT":"W","PAY":"R"},"DRV":{"CAT":"W"},"BIN":{"OPC":"W"}}';
        $permisos=addslashes($permisos);
      break;
      case 'administrador':
        $modulos="TAR;ADM;RES;AGT;DRV;BIN;PAY";
        $permisos='{"TAR":{"TBA":"W"},"RES":{"CAT":"W","PAY":"W"},"ADM":{"FRM":"W","AGT":"W"},"DRV":{"CAT":"W"},"AGT":{"OPC":"W"},"BIN":{"OPC":"W"}}';
        $permisos=addslashes($permisos);
      break;
      default:
        $modulos="";
        $permisos="";
      break;
    }
    $fecha=date('Y-m-d');
    $pass=md5($params["agtPass"]);
    $sql="
      Insert Into crm_users
      (user,name,email,password,modules,actions,area,status,mode,creationDate) values
      ('{$params["agtCode"]}','{$params["agtName"]}','{$params["agtEmail"]}','$pass','$modulos','$permisos','Operacion',1,'{$params["agtTipo"]}','$fecha')
    ";
    $result=DB::simpleQuery($sql);
    return $result;
  }

  static function editAgent($params=""){
    if(empty($params)){ return "ERR"; }
    switch ($params["agtEdtTipo"]) {
      case 'agente':
        $modulos="RES";
        $permisos='{"RES":{"CAT":"W","PAY":"R"}}';
        $permisos=addslashes($permisos);
      break;
      case 'trafico':
        $modulos="RES;DRV;BIN";
        $permisos='{"RES":{"CAT":"W","PAY":"R"},"DRV":{"CAT":"W"},"BIN":{"OPC":"W"}}';
        $permisos=addslashes($permisos);
      break;
      case 'administrador':
        $modulos="TAR;ADM;RES;AGT;DRV;BIN;PAY";
        $permisos='{"TAR":{"TBA":"W"},"RES":{"CAT":"W","PAY":"W"},"ADM":{"FRM":"W","AGT":"W"},"DRV":{"CAT":"W"},"AGT":{"OPC":"W"},"BIN":{"OPC":"W"}}';
        $permisos=addslashes($permisos);
      break;
      default:
        $modulos="";
        $permisos="";
      break;
    }
    $fecha=date('Y-m-d');
    $isEditPass="";
    if($params["agtEdtPass"]!="******"){
      $pass=md5($params["agtEdtPass"]);
      $isEditPass=",password='".$pass."'";
    }

    $sql="Update crm_users set
            name='{$params["agtEdtName"]}',email='{$params["agtEdtEmail"]}',modules='$modulos',actions='$permisos',status={$params["agtEdtStat"]},mode='{$params["agtEdtTipo"]}' $isEditPass
          where  user='{$params["agtEdtCode"]}'";
    $result=DB::simpleQuery($sql);
    return $result;
  }

  static function delAgent($params=""){
    if(empty($params["code"])){ return "ERR"; }
    $sql="Delete from crm_users where id={$params["id"]} and user='{$params["code"]}'";
    $result=DB::simpleQuery($sql);
    return $result;
  }

}

?>
