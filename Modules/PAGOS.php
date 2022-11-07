<?
namespace Modules;

class PAGOS{

  static function getListPayments($filtros){
    if(!empty($filtros)){
      $filtros=" where (idReservation like '%$filtros%' OR idOperacion like '%$filtros%')";
    }
    $sql="Select
              *
          From
              cat_prepagos
          $filtros
          ";
    $result=DB::procesedQuery($sql);
    if(!$result){
      return "ERR";
    }
    return $result;
  }




}




?>
