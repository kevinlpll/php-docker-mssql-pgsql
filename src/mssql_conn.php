<?php


//Docker localhost
$serverName = "host.docker.internal";
$connectionInfo = [
   "Database" => "teste",
   "UID" => "teste",
   "PWD" => "teste"
];

$arrRetorno = [];
    
//Establishes the connection
$conn = new PDO("sqlsrv:server=$serverName ; Database =". $connectionInfo["Database"] , $connectionInfo["UID"] ,$connectionInfo["PWD"]);

//Select Query
$sql = "select * from teste.dbo.teste";

//Executes the query
$getProducts = $conn->query($sql);

//Error handling
FormatErrors($conn->errorInfo());
    	 	 	 
while ($row = $getProducts->fetch(PDO::FETCH_ASSOC)) {   
   $arrRetorno[] = $row;   
}


echo json_encode($arrRetorno);


function FormatErrors($error)
{

   if($error){
      /* Display error. */
      echo "Error information: <br/>";

      echo "SQLSTATE: ".$error[0]."<br/>";
      echo "Code: ".$error[1]."<br/>";
      echo "Message: ".$error[2]."<br/>";
   }
   
}

?>