<?php
namespace Modules;

class DB{
  const DEVMODE="n";

  const IP='localhost';
  const USERBASE="root";
  //const USERBASE="loscigjp_burgtranspAdmin";
  const PASSBASE="admin";
  //const PASSBASE="Ww0LqEfUN7HbdK62TID1";
  //const BASE="db_burgtransp1001";
  const BASE="loscigjp_db_burgtransp1001";


  static function simpleQuery($sql,$modo="prod"){
    if($modo=="prods"){
      $conn = mysqli_connect(self::IP2, self::USERBASE2, self::PASSBASE2,self::BASE2);
    }else{
      $conn = mysqli_connect(self::IP, self::USERBASE, self::PASSBASE,self::BASE);
    }
    mysqli_set_charset($conn, "utf8");
    if(! $conn ){ return 'Could not connect: ' . mysqli_error($conn); }
      $result = mysqli_query($conn, $sql);
    		/*$db = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
    		$db->set_charset("UTF8");*/
        //if(!mysqli_query($conn, $sql)){
      if(!$result){
        $result="ERR";
        if(self::DEVMODE=='s'){
          $result=mysqli_error($conn);
        }
      }
  	return $result;
	}

  static function procesedQuery($sql,$modo="prod"){
    if($modo=="prods"){
      $conn = mysqli_connect(self::IP2, self::USERBASE2, self::PASSBASE2,self::BASE2);
    }else{
      $conn = mysqli_connect(self::IP, self::USERBASE, self::PASSBASE,self::BASE);
    }
    mysqli_set_charset($conn, "utf8");
    if(! $conn ){ return 'Could not connect: ' . mysqli_error($conn); }
    $result = mysqli_query($conn, $sql);
    if(!$result){
      if(self::DEVMODE=='s'){
        $result=mysqli_error($conn);
      }else{
        $result="ERR";
      }
      return $result;
    }
    if($result->num_rows>0){
      while($row = mysqli_fetch_array($result)){  $obj[]=$row;  }
    }else{
      return false;
    }
    return $obj;
	}

    static function procesedQueryClear($sql,$modo="prod"){
    $conn = mysqli_connect(self::IP2, self::USERBASE2, self::PASSBASE2,self::BASE2);
    mysqli_set_charset($conn, "utf8");
    if(! $conn ){ return 'Could not connect: ' . mysqli_error($conn); }
    $result = mysqli_query($conn, $sql);
    $obj=array();
    if($result->num_rows>0){
      while($row = $result->fetch_array(MYSQLI_ASSOC)){
        //array_push($obj,$row[0]);
        array_push($obj,$row);
      }
    }else{
      return false;
    }
    return $obj;
	}

}

?>
