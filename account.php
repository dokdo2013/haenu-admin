<?
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
        3. Find Get Method
    ===================================== */

    $mysqli = new mysqli('localhost', '', '', '');
    $mysqli->query("set session character_set_connection=utf8;");
    $mysqli->query("set session character_set_results=utf8;");
    $mysqli->query("set session character_set_client=utf8;");

    $target_str = '검색결과가 없습니다.';

    if(isset($_GET["sch"]) && $_GET["sch"] != ''){
        $target_text = $_GET["sch"];
        $target_str = '';
        // account result
        $result = $mysqli->query("SELECT * FROM account WHERE `key` like '%$target_text%' or `value1` like '%$target_text%' or `value2` like '%$target_text%' or `value3` like '%$target_text%'");
        $row = mysqli_num_rows($result);
        $target_str = $target_str . '<h3>account result ('.$row.')</h3><div class="table-wrapper"><table>';
        while($data = mysqli_fetch_array($result, MYSQLI_BOTH)){
            $target_str = $target_str . '<tr><td>'.$data['key'].'</td><td>'.$data['value1'].'</td><td>'.$data['value2'].'</td><td>'.$data['value3'].'</td></tr>';
        }
        $target_str = $target_str . '</table></div><br>';
    }

    // account result str
    $result = $mysqli->query("SELECT * FROM account");
    $row = mysqli_num_rows($result);
    $real_str = '<h2>Account Information ('.$row.')</h2><table>';
    while($data = mysqli_fetch_array($result, MYSQLI_BOTH)){
        $real_str = $real_str . '<tr><td>'.$data['key'].'</td><td>'.$data['value1'].'</td><td>'.$data['value2'].'</td><td>'.$data['value3'].'</td></tr>';
    }
    $real_str = $real_str . '</table><br>';


?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAENU ADMIN</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js" integrity="sha512-M+hXwltZ3+0nFQJiVke7pqXY7VdtWW2jVG31zrml+eteTP7im25FdwtLhIBTWkaHRQyPrhO2uy8glLMHZzhFog==" crossorigin="anonymous"></script>
    <style>
        body, html{
            margin: 0;
            padding: 0;
            min-height: 100%;
            background-image: url("../bgimg.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
        tr, td{
            border: 1px solid black;
            padding: 5px;
        }
        a{
            text-decoration: none;
            color: black;
        }
        .icon{
            color: purple !important;
        }
        .wrapper{
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            min-height: calc(100vh - 40px);
        }
        .middle{
            padding-top: 3px;
        }
        .button{
            display: inline-block;
            border: 1px solid grey;
            padding: 5px;
            border-radius: 5px;
        }
        .button:hover{
            background-color: grey;
            color: white;
        }
        hr{
            margin: 20px 0;
        }
        .table-wrapper{
            width: auto;
            overflow: scroll;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="top">
            <h2><a href="./index.php">HAENU ADMIN</a> <a href="logout.php"><i class="fas icon fa-sign-out-alt"></i></a> </h2>
            <div class="buttons">
                <a href="personal.php"><span class="button"><i class="fas fa-user"></i> Personal Information</span></a>
                <a href="card.php"><span class="button"><i class="fas fa-credit-card"></i> Card Information</span></a>
                <a href="account.php"><span class="button"><i class="fas fa-sign-in-alt"></i> Account Information</span></a>
                <a href="etc.php"><span class="button"><i class="fas fa-ellipsis-h"></i> Etc. Information</span></a>
            </div>
        </div>
        <hr>
        <div class="middle">
            <form action="./account.php" method="get">
                <input type="text" name="sch" id="sch" placeholder="검색어를 입력하세요.">
                <input type="submit" value="검색">
            </form>
        </div>
        <div class="bottom">
            <?=$target_str?>
        </div>
        <hr>
        <div class="input">
            <form action="./add.php" method="post">
                <input type="text" name="key" id="key" placeholder="사이트명">
                <input type="text" name="value1" id="value1" placeholder="아이디">
                <input type="text" name="value2" id="value2" placeholder="비밀번호">
                <input type="text" name="value3" id="value3" placeholder="2차/기타">
                <input type="hidden" name="target" value="account">
                <input type="hidden" name="type" value="1">
                <input type="submit" value="추가">
            </form>
        </div>
        <hr>
        <div class="main">
            <?=$real_str?>
        </div>
    </div>
</body>
</html>
