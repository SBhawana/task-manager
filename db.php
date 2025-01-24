<?php

$host = "localhost" ;
$username = "root" ;
$password = "" ;
$database_name = "task_manager" ;

$conn = mysqli_connect($host , $username , $password , $database_name) or die('Connection Not Estalished') ;

function prx($array){
   echo "<pre>" ; 
   print_r($array) ;
   die ;
}