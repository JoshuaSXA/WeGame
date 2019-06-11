<?php

include_once "DBController.php";


class NewsInfoController {

    private $DBController;

    public function __construct() {

        $this->DBController = new DBController();

    }

    public function  __destruct() {
        // TODO: Implement __destruct() method.
        $this->DBController->disConnDatabase();
    }

    public function getNewsDetail() {


    }

    public function getNewsList() {

        $sql = "SELECT * FROM news";

        $retval = mysqli_query( $this->DBController->getConnObject(), $sql );
        if($retval){
            $posts =  mysqli_fetch_all($retval, MYSQLI_ASSOC);
            echo json_encode(array("success" => TRUE, "data" => $posts));
        }else{
            echo json_encode(array("success" => FALSE, "data" => array()));
        }
    }

}