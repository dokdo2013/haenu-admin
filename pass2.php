<?php
    /*
        HAENU ADMIN 인증 2단계
        문자 인증을 통한 로그인
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
    
    if(!isset($_SESSION["PASS1"])){
        $_SESSION["ERRMSG"] = "비정상적인 경로로 접근하였습니다.";
        $_SESSION["ERRCODE"] = "01";
        header('Location: https://admin.haenu.com/error.php');
    }
    if(isset($_SESSION["PASS2"])){
        $_SESSION["ERRMSG"] = "이미 처리된 순서입니다.";
        $_SESSION["ERRCODE"] = "03";
        header('Location: https://admin.haenu.com/error.php');
    }


    if(!isset($_SESSION["ERRCODE"])){

        /* =====================================
            3. Make Auth Code
        ===================================== */

        $random_base = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 
        'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
        'U', 'V', 'W', 'X', 'Y', 'Z', '!', '@', '#', '$', '%', '?', '/'];
        $random_base_num = sizeof($random_base);
        $authcode_tmp = [];
        for($i=0;$i<8;$i++){
            $tmp_random = mt_rand();
            $tmp_random = $tmp_random % $random_base_num;
            array_push($authcode_tmp, $tmp_random);
        }
        $authcode = $random_base[$authcode_tmp[0]] . $random_base[$authcode_tmp[1]] . $random_base[$authcode_tmp[2]] . $random_base[$authcode_tmp[3]]
        . $random_base[$authcode_tmp[4]] . $random_base[$authcode_tmp[5]] . $random_base[$authcode_tmp[6]] . $random_base[$authcode_tmp[7]];
        $msg = "해누닷컴 인증코드는 [" . $authcode . "] 입니다.";
        $_SESSION["PASS2AUTH"] = $authcode;
    
        /* =====================================
            4. Send Message
        ===================================== */
    
        $url = "https://api-sms.cloud.toast.com/sms/v2.3/appKeys/HkJhi9PvZV1Nq0mJ/sender/sms";
        $key = 'appKey=';
        $data = array(
            'body' => $msg,
            'sendNo' => '01012345678',
            'recipientList' => [[
                'recipientNo' => '01012345678'
            ]]
        );
        $ch = curl_init();                                 //curl 초기화
        curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
        curl_setopt($ch, CURLOPT_POSTFIELDS, $key);        //키값 지정
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json')); //헤더 지정
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));       //POST data
        curl_setopt($ch, CURLOPT_POST, true);              //true시 post 전송 
        
        $response = curl_exec($ch);
        curl_close($ch);
    
        /* =====================================
            5. Check Code
        ===================================== */
    
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
        #auth{
            width: 260px;
            height: 40px;
            margin-top: 20px;
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
            font-size: 0.625em;
            text-align: center;
            margin-top: 30px;
        }
        #time{
            color: red;
        }
    </style>
    <script>
        $(document).ready(function(){
            setInterval(function(){ 
                var time = $("#time").text();
                time = time - 1;
                if(time == 0){
                    alert("제한시간이 초과되었습니다.");
                    location.href = "error.php";
                }else if(time < 0){
                    time = 0;
                }
                $("#time").html(time);
            }, 1000);
            
        });
    </script>
</head>
<body>
    <div class="main">
        <div class="inner">
            <form action="pass2pass.php" method="post">
                <p>휴대폰으로 도착한 인증코드를 입력해주세요. <span style="color: red">(0:<span id="time">59</span>)</span></p>
                <input type="text" name="auth" id="auth" placeholder="인증코드">
                <input type="submit" id="submit" value="확인">
            </form>
        </div>
    </div>
</body>
</html>
