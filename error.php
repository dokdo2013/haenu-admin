<?php

/*
    ERROR CODE : ERROR MESSAGE

    01 : 비정상적인 경로로 접근하였습니다.
    02 : 접속 정보가 없습니다.
    03 : 이미 처리된 순서입니다.
    04 : 인증에 실패하였습니다.
*/

session_start();

if(!isset($_SESSION["ERRCODE"])){
    header('Location: https://admin.haenu.com');
}

$code = $_SESSION["ERRCODE"];
$msg = $_SESSION["ERRMSG"];

session_destroy();

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
        p{
            font-size: 0.5em;
            text-align: center;
            line-height: 40px;
        }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="inner">
            <form method="post">
                <p>에러코드 : <?=$code?><br>에러메세지 : <?=$msg?><br><a href="index.php">홈으로 이동</a></p>
            </form>
        </div>
    </div>
</body>
</html>