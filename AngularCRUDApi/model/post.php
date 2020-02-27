<?php
    class Post{

        private $conn;
        private $sql;
        private $result;
        private $data = array();
        private $info = [];

        public function __construct($db){
            $this->conn = $db;
        }

        // SQL Query Execution
        function queryWithRes($query){

            $this->result = $this->conn->query($query);
    
            if ($this->result->num_rows>0) {
                while($res = $this->result->fetch_assoc()){
                    array_push($this->data,$res);
                }
              
                return $this->info = array(
                    'status'=>array(
                        'remarks'=>true,
                        'message'=>'Data pulling success.'
                    ),
                    'data' =>$this->data,
                    'timestamp'=>date_create(),
                    'prepared_by'=>'Low Key'
                );
    
            } else {
                return $this->info = array('status'=>array(
                        'remarks'=>false,
                        'message'=>'No data pulled.'),
                    'timestamp'=>date_create(),
                    'prepared_by'=>'Low Key' );
            }

        }

        function queryWithoutRes($query){
            if ($this->conn->query($query)){
                return $this->info = array(
                    'status'=>array(
                        'remarks'=>true,
                        'message'=>'Query success.'
                    ),
                    'data' =>$this->data,
                    'timestamp'=>date_create(),
                    'prepared_by'=>'Low Key'
                );
            } else {
                return $this->info = array('status'=>array(
                        'remarks'=>false,
                        'message'=>'Query failed.'),
                    'timestamp'=>date_create(),
                    'prepared_by'=>'Low Key' );
            }
        }
    

    }
?>