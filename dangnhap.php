<?php
    require 'wp-config.php';
    //$_SESSION['username']
    $username = $_POST["username"];
    $password = $_POST["password"];
    $user = get_user_by('login', $username);
    // if(is_user_logged_in()) {
    //  echo "bạn đã đăng nhập rồi, không cần đăng nhập lại";
    // } else echo "bạn chưa đăng nhập";
if ($user && wp_check_password($password, $user->data->user_pass, $user->ID)) {
    // $_SESSION['username']= $username;
    echo "login successed";
    // echo "$username";

    // nếu đúng user vs pass thì lưu session lại 14 ngày
    // wp_set_auth_cookie($user->ID, true, false);
    // update_user_caches($user);
    // clean_user_cache($user->ID);
    // wp_clear_auth_cookie();
    // wp_set_current_user($user->ID);
    // wp_set_auth_cookie($user->ID, true, false);
    // update_user_caches($user);

    // xóa cookie để logout
    // wp_clear_auth_cookie();
    //
    // kiểm tra user có đang login
    // if (is_user_logged_in()) {
    //     echo "You're logged.";
    // } else {
    //     echo "You're not logged";
    // }
} else {
    echo "Wrong pass or user";
}
    require_once ABSPATH . WPINC . '/class-phpass.php';
    // $wp_hasher = new PasswordHash(8, true);
    // $pass = $wp_hasher->HashPassword(trim($password));
    // $strSql = "SELECT user_pass FROM wp_users WHERE user_login = '$username'";
    // $resultpwd = mysqli_query($conn, $strSql);
    // $row = mysqli_fetch_array($resultpwd);
    // $password_hashed = $username[$pass];
    // if ($wp_hasher->CheckPassword($pass, $password_hashed)) {
    //     echo "Yes password is correct" ;
    // } else {
    //     echo "Entered Password is wrong";
    // }

    // $mysql_qry = "select * from wp_users where user_login like '$user' and user_pass like '$pass';";
    // $result = mysqli_query($conn, $mysql_qry);
    // if (mysqli_num_rows($result) > 0) {
    //     echo "đăng nhập thành công";
    // } else {
    //     echo "đăng nhập thất bại";
    // }
