<?php

include_once 'DBController.php';

class UserInfoController {

    private $openID;

    private $DBController;

    public function __construct()
    {

        $this->openID = $_REQUEST['open_id'];

        $this->DBController = new DBController();

    }

    // 获取消息中心
    public function getUserMessage() {

        $sql = "SELECT msg_id, content, msg_time FROM message WHERE open_id = (?)";

        // 创建预处理语句
        $stmt = mysqli_stmt_init($this->DBController->getConnObject());
        if(mysqli_stmt_prepare($stmt, $sql)){
            // 绑定参数
            mysqli_stmt_bind_param($stmt, "s", $this->openID);
            // 执行查询
            if(!mysqli_stmt_execute($stmt)) {
                echo json_encode(array("success" => FALSE, "data" => array()));
                return;
            }
            // 获取查询结果
            $result = mysqli_stmt_get_result($stmt);
            // 获取值
            $retValue =  mysqli_fetch_all($result, MYSQLI_ASSOC);
            // 返回结果
            echo json_encode(array("success" => TRUE, "data" => $retValue), JSON_UNESCAPED_UNICODE);
            // 释放结果
            mysqli_stmt_free_result($stmt);
            // 关闭mysqli_stmt类
            mysqli_stmt_close($stmt);
        } else {
            //echo $this->DBController->getErrorCode();
            echo json_encode(array("success" => FALSE, "data" => array()));
        }

    }

    // 获取个人信息
    public function getUserInfo() {

        $sql = "SELECT s.nickname, s.avatar, s.phone, s.points, (SELECT COUNT(*) FROM message a WHERE a.open_id = (?)) AS message_num, (SELECT COUNT(*) FROM favor b WHERE b.open_id = (?)) AS favor_num FROM user s WHERE s.open_id = (?)";

        // 创建预处理语句
        $stmt = mysqli_stmt_init($this->DBController->getConnObject());
        if(mysqli_stmt_prepare($stmt, $sql)){
            // 绑定参数
            mysqli_stmt_bind_param($stmt, "sss", $this->openID, $this->openID, $this->openID);
            // 执行查询
            if(!mysqli_stmt_execute($stmt)) {
                echo json_encode(array("success" => FALSE, "data" => array()));
                return;
            }
            // 获取查询结果
            $result = mysqli_stmt_get_result($stmt);
            // 获取值
            $retValue =  mysqli_fetch_all($result, MYSQLI_ASSOC);
            // 返回结果
            echo json_encode(array("success" => TRUE, "data" => $retValue), JSON_UNESCAPED_UNICODE);
            // 释放结果
            mysqli_stmt_free_result($stmt);
            // 关闭mysqli_stmt类
            mysqli_stmt_close($stmt);
        } else {
            //echo $this->DBController->getErrorCode();
            echo json_encode(array("success" => FALSE, "data" => array()));
        }

    }


    public function getUserFavor() {

        $sql = "SELECT s.favor_id, s.favor_time, s.game_id, (SELECT a.title FROM game a WHERE a.game_id = s.game_id) AS title, (SELECT b.url FROM swiper_img b WHERE b.game_id = s.game_id) AS swiper_img FROM favor s WHERE s.open_id = (?)";

        // 创建预处理语句
        $stmt = mysqli_stmt_init($this->DBController->getConnObject());
        if(mysqli_stmt_prepare($stmt, $sql)){
            // 绑定参数
            mysqli_stmt_bind_param($stmt, "s", $this->openID);
            // 执行查询
            if(!mysqli_stmt_execute($stmt)) {
                echo json_encode(array("success" => FALSE, "data" => array()));
                return;
            }
            // 获取查询结果
            $result = mysqli_stmt_get_result($stmt);
            // 获取值
            $retValue =  mysqli_fetch_all($result, MYSQLI_ASSOC);
            // 返回结果
            echo json_encode(array("success" => TRUE, "data" => $retValue), JSON_UNESCAPED_UNICODE);
            // 释放结果
            mysqli_stmt_free_result($stmt);
            // 关闭mysqli_stmt类
            mysqli_stmt_close($stmt);
        } else {
            //echo $this->DBController->getErrorCode();
            echo json_encode(array("success" => FALSE, "data" => array()));
        }

    }


    public function getIfUserCommented() {

        $gameID = $_GET['game_id'];

        $sql = "SELECT title, content, rate FROM comment WHERE open_id = (?) AND game_id = (?)";

        // 创建预处理语句
        $stmt = mysqli_stmt_init($this->DBController->getConnObject());
        if(mysqli_stmt_prepare($stmt, $sql)){
            // 绑定参数
            mysqli_stmt_bind_param($stmt, "si", $this->openID, $gameID);
            // 执行查询
            if(!mysqli_stmt_execute($stmt)) {
                echo json_encode(array("success" => FALSE, "data" => array()));
                return;
            }
            // 获取查询结果
            $result = mysqli_stmt_get_result($stmt);
            // 获取值
            $retValue =  mysqli_fetch_all($result, MYSQLI_ASSOC);
            if(count($retValue)) {
                $retValue['commented'] = TRUE;
            } else {
                $retValue['commented'] = FALSE;
            }
            // 返回结果
            echo json_encode(array("success" => TRUE, "data" => $retValue), JSON_UNESCAPED_UNICODE);
            // 释放结果
            mysqli_stmt_free_result($stmt);
            // 关闭mysqli_stmt类
            mysqli_stmt_close($stmt);
        } else {
            //echo $this->DBController->getErrorCode();
            echo json_encode(array("success" => FALSE, "data" => array()));
        }

    }
    
}