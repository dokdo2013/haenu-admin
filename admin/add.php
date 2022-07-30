<?
    /*
        HAENU ADMIN 관리자 페이지
        DB 추가용 플러그인
    */

    session_start();

    /* =====================================
        1. Check Session Exist
            if exist -> error
    ===================================== */
    
    if(!isset($_SESSION["SESSID"])){
        $_SESSION["ERRMSG"] = "접속 정보가 없습니다.";
        $_SESSION["ERRCODE"] = "02";
        header('Location: https://admin.haenu.com/error.php');
    }

    /* =====================================
        2. Check Right Process
            if not exist -> error
    ===================================== */
    
    if(!isset($_SESSION["PASS1"])){
        $_SESSION["ERRMSG"] = "비정상적인 경로로 접근하였습니다.";
        $_SESSION["ERRCODE"] = "01";
        header('Location: https://admin.haenu.com/error.php');
    }
    if(!isset($_SESSION["PASS2"])){
        $_SESSION["ERRMSG"] = "비정상적인 경로로 접근하였습니다.";
        $_SESSION["ERRCODE"] = "01";
        header('Location: https://admin.haenu.com/error.php');
    }
    if(!isset($_SESSION["SUCCESS"])){
        $_SESSION["ERRMSG"] = "비정상적인 경로로 접근하였습니다.";
        $_SESSION["ERRCODE"] = "01";
        header('Location: https://admin.haenu.com/error.php');
    }

    /* =====================================
        3. POST 요청 처리
    ===================================== */

    $mysqli = new mysqli('localhost', '', '', '');
    $mysqli->query("set session character_set_connection=utf8;");
    $mysqli->query("set session character_set_results=utf8;");
    $mysqli->query("set session character_set_client=utf8;");

    if((!isset($_POST['target'])) || (!isset($_POST['type']))){
        $_SESSION["ERRMSG"] = "비정상적인 경로로 접근하였습니다.";
        $_SESSION["ERRCODE"] = "01";
        header('Location: https://admin.haenu.com/error.php');
    }else{
        $target = $_POST['target'];
        $type = $_POST['type'];
        if($type == '0'){
            // key-value 구조
            $key = $_POST['key'];
            $value = $_POST['value'];
            $query = "INSERT INTO $target(`key`, `value`) VALUES('$key', '$value')";
        }else{
            // key-value1-value2-value3 구조
            $key = $_POST['key'];
            $value1 = $_POST['value1'];
            $value2 = $_POST['value2'];
            $value3 = $_POST['value3'];
            $query = "INSERT INTO $target(`key`, `value1`, `value2`, `value3`) VALUES('$key', '$value1', '$value2', '$value3')";
        }
        $mysqli->query($query);
        header("Location: https://admin.haenu.com/admin/$target.php");
    }
