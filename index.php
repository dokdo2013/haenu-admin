<?php

/*
    HAENU ADMIN 첫 페이지
    1. 이 페이지에 접속하면 무조건 기존 세션 초기화 (삭제 후 신규 세션 코드 부여)
    2. 기본적으로 신규 세션 코드를 부여함
*/

    session_start();

    /* =====================================
        1. Check Session Exist
            if exist -> error
    ===================================== */
    
    if(isset($_SESSION["SESSID"])){
        $_SESSION["ERRMSG"] = "비정상적인 경로로 접근하였습니다.";
        $_SESSION["ERRCODE"] = "01";
        header('Location: https://admin.haenu.com/error.php');
    }

    /* =====================================
        2. Make Session ID
    ===================================== */

    function GenerateString($length)  
    {  
        $characters  = "0123456789";  
        $characters .= "abcdefghijklmnopqrstuvwxyz";  
        $characters .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";  
        $characters .= "_";  
        
        $string_generated = "";  
          
        $nmr_loops = $length;  
        while ($nmr_loops--)  
        {  
            $string_generated .= $characters[mt_rand(0, strlen($characters) - 1)];  
        }  
          
        return $string_generated;  
    }  
    // 출처: https://jhrun.tistory.com/197 [JHRunning]
    $sessid = GenerateString(64);
    $_SESSION["SESSID"] = $sessid;

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAENU ADMIN</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <style>
        body, html{
            margin: 0;
            padding: 0;
            height: 100%;
            min-height: 100%;
            background-image: url("bgimg.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
        .click{
            display: flex;
            justify-content: center;
            line-height: 100vh;
            color: white;
            font-size: 2em;
            cursor: pointer;
        }
    </style>
    <script>
        $(document).ready(function(){
            $(".click").click(function(){
                location.href = "pass1.php";
            });
        });
    </script>
</head>
<body>
    <div class="click">Click to Login</div>
</body>
</html>