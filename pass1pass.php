<?

session_start();

$userid = 'userid';
$userpw = 'userpassword';
$getid = $_POST['userid'];
$getpw = $_POST['userpw'];

if($userid == $getid && $userpw == $getpw){
    // success
    $_SESSION["PASS1"] = '1';
    header('Location: https://admin.haenu.com/pass2.php');
}else{
    // fail
    $_SESSION["ERRMSG"] = "인증에 실패하였습니다.";
    $_SESSION["ERRCODE"] = "04";
    header('Location: https://admin.haenu.com/error.php');
}
