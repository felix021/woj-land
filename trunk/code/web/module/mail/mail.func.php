<?php

function get_mail_by_mail_id(&$conn, $mail_id)
{
    $sql = 'SELECT * FROM `mails` WHERE `mail_id`=' . (int)$mail_id;

    $conn = db_connect();
    fail_test($conn, false);

    $mail = db_fetch_line($conn, $sql);
    fail_test($mail, false);

    return $mail;
}

?>
