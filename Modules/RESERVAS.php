<?php
namespace Modules;

class RESERVAS{

  static function getInfoReservas($filtros){
      $DBCHECKED="lst_reservations";
        $campos="
        a.id,
        a.idReservation as idReserva,
        a.fisrtName as nombre,
        a.lastName as apellido,
        a.email,
        a.mobile,
        a.typeService as servicio,
        a.zone as zonaNum,
        a.zoneName as zona,
        a.vcode as vcode,
        a.pax as seats,
        a.total,
        a.isAirlineArr,
        a.isAirlineDep,
        a.isPrepay,
        a.originOnArrival as origenA,
        a.destinationOnArrival as destinoA,
        a.dateOnArrival as pickupA,
        a.originOnDeparture as origenB,
        a.destinationOnDeparture as destinoB,
        a.dateOnDeparture as pickupB,
        if(ISNULL(b.agentCode),'NA',b.agentCode) as agentAsignado,
        if(ISNULL(b.driverCode),'NA',b.driverCode) as driverAsignado";

      if(!empty($filtros["tipo"])){
        switch ($filtros["tipo"]) {
          case 'target':
            $cad=$filtros["info"];
            $filtros=" where (a.fisrtName like '%$cad%' OR a.lastName like '%$cad%' OR a.idReservation like '%$cad%' )";
            $campos="
            a.id,
            a.idReservation as idReserva,
            a.fisrtName as nombre,
            a.lastName as apellido,
            a.email,
            a.mobile,
            a.typeService as servicio,
            a.zone as zonaNum,
            a.zoneName as zona,
            a.vcode as vcode,
            a.pax as seats,
            a.total,
            a.isAirlineArr,
            a.isAirlineDep,
            a.isPrepay,
            a.originOnArrival as origenA,
            a.destinationOnArrival as destinoA,
            a.dateOnArrival as pickupA,
            a.originOnDeparture as origenB,
            a.destinationOnDeparture as destinoB,
            a.dateOnDeparture as pickupB,
            if(ISNULL(b.agentCode),'NA',b.agentCode) as agentAsignado,
            if(ISNULL(b.driverCode),'NA',b.driverCode) as driverAsignado";
          break;
          case 'especific':
            $cad=$filtros["info"];
            $filtros=" where a.id='$cad'";
            $campos="a.*,
            if(ISNULL(b.agentCode),'NA',b.agentCode) as agentAsignado,
            if(ISNULL(b.driverCode),'NA',b.driverCode) as driverAsignado";
          break;
          case 'binnacle':
            $fechas=$filtros["info"];
            $fechaIni=$fechas["filtro"]["inicio"];
            $filtros=" where a.creationDate>='{$fechaIni}'";
            if(!empty($fechas["filtro"]["fin"])){ $filtros.=" and a.creationDate<='{$fechas["filtro"]["fin"]}'"; }
          break;
          default:
            $filtros="";
          break;
        }
      }else{
        $filtros="";
      }
      //$filtros="";
      $sql="Select
              $campos
            From
                $DBCHECKED a
            left Join crm_asigned_reservations b on (b.idReservation=a.idReservation)
            $filtros
            order by a.id DESC
            ";
      $result=DB::procesedQuery($sql);
      if(!$result){
        return "ERR";
      }
      return $result;
    }


  static function asingDriverToRes($params=""){
    if(empty($params)){ return "ERRs"; }
    $fecha=date('Y-m-d');
    $resp=DRIVERS::getList(array('mode'=>'uniqueBycode','code'=>$params["idDrvToAsing"]));
    $namedriver=$resp[0]["name"];

    $id=self::isAsignedExist($params["idResAtAsign"]);

    if($id==0){
      $sql="
      Insert Into crm_asigned_reservations
      (idReservation,driverCode,driverName,dateSetDriver) values
      ('{$params["idResAtAsign"]}','{$params["idDrvToAsing"]}','$namedriver','$fecha')
      ";
    }else{
      $sql="update crm_asigned_reservations set driverCode='{$params["idDrvToAsing"]}',driverName='$namedriver',dateSetDriver='$fecha' where id=$id";
    }
    $result=DB::simpleQuery($sql);
    if(empty($result)){ $result="ERR"; }
    return $result;
  }

  static function asingAgentToRes($params=""){
      if(empty($params)){ return "ERRs"; }
      $fecha=date('Y-m-d');
      $resp=AGENTS::getList(array('mode'=>'uniqueBycode','code'=>$params["idAgtToAsing"]));
      $nameagent=$resp[0]["name"];

      $id=self::isAsignedExist($params["idResAtAsign"]);

      if($id==0){
        $sql="
        Insert Into crm_asigned_reservations
        (idReservation,agentCode,agentName,dateSetAgent) values
        ('{$params["idResAtAsign"]}','{$params["idAgtToAsing"]}','$nameagent','$fecha')
        ";
      }else{
        $sql="update crm_asigned_reservations set agentCode='{$params["idAgtToAsing"]}',agentName='$nameagent',dateSetAgent='$fecha' where id=$id";
      }
      $result=DB::simpleQuery($sql);
      if(empty($result)){ $result="ERR"; }
      return $result;
  }

  static function isAsignedExist($idReserva){
    $sql="Select id from crm_asigned_reservations where idReservation='$idReserva'";
      $result=DB::procesedQuery($sql);
      if(!empty($result[0]["id"])){
        return $result[0]["id"];
      }else{
        return 0;
      }
  }


}

?>
