<?php
namespace Modules;

class DRIVERS{

  static function getList($params=""){
    switch ($params["mode"]) {
      case 'target':
        $filter=" where name like '%".$params["info"]."%' OR codeDriver like '%".$params["info"]."%' OR email like '%".$params["info"]."%'";
        break;
      case 'unique':
        $filter=" where id=".$params["id"];
        break;
      case 'uniqueBycode':
        $filter=" where codeDriver='".$params["code"]."'";
        break;
      case 'selectlist':
        $filter=" where status=1";
        break;
      default:
        $filter="";
        break;
    }
    $sql="select id,codeDriver,name,email,celphone,status from crm_cat_drivers".$filter;
    $result=DB::procesedQuery($sql);
    return $result;
  }

  static function setDriver($params=""){
    if(empty($params)){ return "ERR"; }
    $fecha=date('Y-m-d');
    $sql="
      Insert Into crm_cat_drivers
      (codeDriver,name,email,celphone,status,creationDate) values
      ('{$params["drvCode"]}','{$params["drvName"]}','{$params["drvEmail"]}','{$params["drvTel"]}',1,'$fecha')
    ";
    $result=DB::simpleQuery($sql);
    if(empty($result)){ $result="ERR"; }
    return $result;
  }

  static function editDriver($params=""){
    if(empty($params)){ return "ERR"; }
    $fecha=date('Y-m-d');
    $sql="Update crm_cat_drivers set
            name='{$params["drvEdtName"]}',email='{$params["drvEdtEmail"]}',celphone='{$params["drvEdtTel"]}',status={$params["drvEdtStat"]}
          where  codeDriver='{$params["drvEdtCode"]}'";
    $result=DB::simpleQuery($sql);
    return $result;
  }

  static function delDriver($params=""){
    if(empty($params["code"])){ return "ERR"; }
    $sql="Delete from crm_cat_drivers where id={$params["id"]} and codeDriver='{$params["code"]}'";
    $result=DB::simpleQuery($sql);
    return $result;
  }

}

?>
