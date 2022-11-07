<?php
namespace Modules;

class BITACORA{

  static function setNewBinnacle($params=""){
    if(empty($params)){ return "ERR"; }
    $fecha=date('Y-m-d');
    session_start();
    $code=self::makeBitCode(1);
    $coordinador=$_SESSION["nick"];
    $sql="
      Insert Into crm_binnacle_cat
      (code,nameBinnacle,dateStart,dateEnd,status,ownerCode,dateCreation) values
      ('$code','{$params["nombre"]}','{$params["inicio"]}','{$params["fin"]}','{$params["stat"]}','$coordinador','$fecha')";
    //return $sql;
    $result=DB::simpleQuery($sql);
    $params["codeBin"]=$code;
    $params["coordinador"]=$coordinador;
    if(empty($result)){  return "ERR"; }
    $done=self::makeBitCode(2);
    $resp=self::setDataAtBinnacle($params);
    return $resp;
  }

  static function setDataAtBinnacle($params=""){
    if(empty($params)){ return "ERR"; }
    $fecha=date('Y-m-d');
    $listReservas=$params["reservas"];
    foreach ($listReservas as $key => $value) {
      $sql="Insert into crm_binnacle_data
      (codeBinnacle,idReservation, coordiantor,dateCreation) values
      ('{$params["codeBin"]}','$value','{$params["coordinador"]}','$fecha')";
      $result=DB::simpleQuery($sql);
    }
    return 1;
  }

  static function makeBitCode($opc=1){
    $fecha=date('Ymd');
    if($opc==2){
      $sql="insert into op_consecutivo_bin (creationDate) value('$fecha')";
      $result=DB::simpleQuery($sql);
      if(!$result){ return "ERR"; }
      return true;
    }else{
      $sql="select id from op_consecutivo_bin order by id desc limit 1";
      $result=DB::procesedQuery($sql);
      if(!$result){ return "ERR"; }
      $consecutivo=$result[0]["id"];
      $consecutivo++;
      $code="BIT".$fecha.$consecutivo;
      return $code;
    }
  }

  static function getListBinnacle($params=""){

    if(!empty($filtros["tipo"])){
      switch ($params["tipo"]) {
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
    }else{
      $filter="";
    }
    $sql="select * from crm_binnacle_cat".$filter;
    $result=DB::procesedQuery($sql);
    return $result;
  }


  static function getDetBinnacle($params=""){
// if(res.originOnArrival='San Jose del Cabo Airport','ARR1',if(res.destinationOnArrival='San Jose del Cabo Airport','DEP1',))
    $sql="select
            bin.id,
            res.idReservation as idReserva,
            res.creationDate as fecha,
            res.pickupTimeA as pickup,
            bin.codeBinnacle,
            concat(res.fisrtName,' ',res.lastName) as name,
            res.pax,
            res.vcode as tipo,
            if(res.destinationOnArrival='San Jose del Cabo Airport','Departure','Arrival') as service,
            if(res.originOnArrival='San Jose del Cabo Airport',res.flightArrival,res.flightDeparture) as flinfo,
            res.originOnArrival as origin,
            res.destinationOnArrival as destination,
            ifnull((select tmp.driverName from crm_asigned_reservations tmp where tmp.idReservation=bin.idReservation),'NA') as conductor,
            bin.comments,
            bin.coordiantor as cordinator
          from crm_binnacle_data bin
          inner join lst_reservations res on (res.idReservation=bin.idReservation)
          where bin.codeBinnacle='{$params["code"]}'";
    $result=DB::procesedQuery($sql);
    return $result;
  }

//////////////
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
