<?php
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($contentType === "application/json") {
  //the data from the user
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

  //If json_decode failed, the JSON is invalid.
    if (!is_array($decoded)) {
        echo "Please try again";
    } else {
        //check if you're validating code
        if (isset($decoded['code'])) {
            if ($decoded['code'] === totp()) {
                //code is correct and within time frame
                echo 0;
            } else {
                echo 1;
            }
        } else {
            //generating code
            echo totp();
        }
    }
} else {
    header('Location: index.html');
}

function totp()
{
    $cutOff = 30;
    $secretKey = 'MKBSWN3DPEHPK2PXZ';
    $time = floor(microtime(true) / $cutOff);
    $te = hash_hmac('sha1', $time, $secretKey);

    $offset = ord(substr($te, -1)) & 0xF;
    $dbc1 = unpack('N', substr($te, $offset, 4))[1];

    // Use the last 6 dgits by using modulo 10^6
    $code = (string)($dbc1 % pow(10, 6));//HOTP_value = HOTP(K, C) mod 10d

    return str_pad($code, 6, 0, STR_PAD_LEFT);
}



?>