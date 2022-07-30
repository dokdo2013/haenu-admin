<?php

    /*
        HAENU ADMIN 인증 1단계
        기본 ID/PW 인증을 통한 로그인
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
            if exist -> error
    ===================================== */
    
    if(isset($_SESSION["PASS1"])){
        $_SESSION["ERRMSG"] = "이미 처리된 순서입니다.";
        $_SESSION["ERRCODE"] = "03";
        header('Location: https://admin.haenu.com/error.php');
    }

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
        .main{
            width: 300px;
            height: 300px;
            font-size: 2em;
            background-color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 5px;
        }
        .inner > form{
            padding: 15px;
        }
        #userid{
            width: 260px;
            height: 40px;
            margin-top: 30px;
        }
        #userpw{
            width: 260px;
            height: 40px;
            margin-top: 10px;
            margin-bottom: 30px;
        }
        #submit{
            width: 100px;
            height: 35px;
            background-color: #00AAFF;
            border-radius: 3px;
            border: 0;
            display: block;
            margin: 0 auto;
            color: white;
        }
        p{
            font-size: 0.75em;
            text-align: center;
            margin-bottom: 0;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="inner">
            <form action="pass1pass.php" method="post">
                <p>HAENU ADMIN</p>
                <input type="text" name="userid" id="userid" placeholder="아이디">
                <input type="password" name="userpw" id="userpw" placeholder="비밀번호">
                <input type="submit" id="submit" value="로그인">
            </form>
        </div>
    </div>
</body>
</html>