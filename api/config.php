<?php
    session_start();
    date_default_timezone_set("Asia/Jakarta");
    // get formatter
    foreach($_GET as $key => $val) {
        ${'get_'.$key}=$val;
    }
    // post_formatter
    foreach($_POST as $key => $val) {
        ${'post_'.$key}=$val;
    }

    require "rb.php";
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    $monRoman = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];

    $DB_HOST = 'localhost';
    $DB_USER = 'root';
    $DB_PASS = '';
    $DB_NAME = 'undangan';
    // $DB_USER = 'kecpedur_rizal';
    // $DB_PASS = '$GUw1zA1;+)d';
    // $DB_NAME = 'kecpedur_arsip';

    R::setup(
        "mysql:host=$DB_HOST;dbname=$DB_NAME",
        $DB_USER,
        $DB_PASS,
        true
    );
    R::freeze(TRUE);

    R::ext('xdispense', function( $type ){
        return R::getRedBean()->dispense( $type );
    });

    function response($message = "", $success = true, $data = [])
    {
        header('Content-Type: application/json');
        http_response_code($success ? 200 : 400);

        $json = array(
            'message'   => $message,
            'data'      => $data,
        );

        die(json_encode($json));
    }

    set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context) {
        throw new ErrorException( $err_msg, 0, $err_severity, $err_file, $err_line );
    }, E_WARNING);

    function send($chatID, $messaggio, $message_id = null) {
        $token = "1735600138:AAEZIlU-0R52PbiXVf6lww1jhqstUWuk2oE";
        echo "sending message to " . $chatID . "\n";

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID."&reply_to_message_id=".$message_id;
        $url = $url . "&parse_mode=Markdown&text=" . urlencode($messaggio);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }



?>
