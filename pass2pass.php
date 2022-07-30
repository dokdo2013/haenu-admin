<?

session_start();

$real_auth = $_SESSION["PASS2AUTH"];
$get_auth = $_POST['auth'];

if($real_auth == $get_auth){
    // success
    $_SESSION["PASS2"] = '1';
    $_SESSION["SUCCESS"] = '1';
    header('Location: https://admin.haenu.com/admin/index.php');
}else{
    // fail
    $_SESSION["ERRMSG"] = "인증에 실패하였습니다.";
    $_SESSION["ERRCODE"] = "04";
    header('Location: https://admin.haenu.com/error.php');
}