<?php

class Database {   
   private $driver;
   private $logsys;
   public function __construct($options){
      
      $options = array_merge([
         "ip" => "192.168.0.110",
         "port" => "1433",
         "username" => "teste",
         "database" => "teste",
         "pwd" => "teste",
         "driver_name" => "mssql"         
      ],$options);
            
      try {         
         switch ($options["driver_name"]) {
            case 'mssql':
               $this->driver = "sqlsrv";
               $this->conn = new PDO(
                  sprintf(
                     "sqlsrv:server=%s,%s ; Database =%s", 
                     $options["ip"],$options["port"],$options["database"]
                  ),
                  $options["username"],
                  $options["pwd"]
               );             


            break;
            case 'pgsql':
               $this->driver = "pgsql";
               $this->conn = new PDO(
                  sprintf(
                     "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
                     $options["ip"],$options["port"],$options["database"],$options["username"],$options["pwd"]
                  )
               
               );

            break;
            default: 
               return $this->conn = false;
         }
         
         $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
         
     } catch (PDOException $e) {
         $this->logsys .= "Failed to get DB handle: " . $e->getMessage() . "\n";
         return false;
     }                

   } 
   
   function query($sql) {
      $data =  $this->conn->query($sql);   
      $arrRetorno = $data->fetchAll();
      $data->closeCursor();
      return $arrRetorno;
   }
   
   function execute($sql,$params){
      
      $sth = $this->conn->prepare($sql);

      $count = 0;
      foreach ($params as $param) {
         $count += $sth->execute($param);
      }
      return $count;
   }
}



echo "Query()<br>";

$bdConn = new Database([]);
echo print_r(
   $bdConn->query("select * from teste.dbo.teste")
);


echo "execute()<br>";

$params[0]["id"] = 1;
echo $bdConn->execute("delete from teste.dbo.teste where id = :id",$params);


echo "<BR>------------- PGSQL -------------------------<BR>";

$options =[
   "ip" => "192.168.0.110",
   "port" => "5432",
   "username" => "teste",
   "database" => "postgres",
   "pwd" => "teste",
   "driver_name" => "pgsql"         
];

$pgConn = new Database($options);

echo print_r(
   $pgConn->query("select * from teste")
);


