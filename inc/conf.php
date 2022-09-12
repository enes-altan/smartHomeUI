<?php

header("X-Frame-Options: deny");
header("Strict-Transport-Security: max-age=16070400; includeSubDomains");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-cache, no-store, must-revalidate");
header_remove("X-Powered-By");
header_remove("Server");

function form_security_control($value)
{
    $attacked = "H";
    #vt sizma girişimi için
    $value = str_replace("'", "`", $value);
    $value = str_replace("", "`", $value);
    $value = str_replace("", "`", $value);
    $value = str_replace("", "`", $value);
    $value = str_replace("\"", "`", $value);

    #xss atak için
    $value = str_replace(">", "&gt;", $value);
    $value = str_replace("<", "&lt;", $value);
    $value = str_replace("%3E", "&gt;", $value);
    $value = str_replace("%3C", "&lt;", $value);

    if (substr_count(@strtoupper($value), "UNİON") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "UNION") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "EXECUTE") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "EXEC") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "ALTER(") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "SYSTEM") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "LOAD_FILE") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "FUNCTION") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "FROMCHARCODE") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "HTTPURITYPE") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "SLEEP") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "CHR") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "ASCII") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "SUBSTR") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "BITAND") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "LOWER") > 0) $attacked = "E";
    if (substr_count(@strtoupper($value), "REQUEST") > 0) $attacked = "E";

    if ($attacked == "E") {
        $value = str_replace("UNİON", "U_N_I_O_N", strtoupper($value));
        $value = str_replace("UNION", "U_N_I_O_N", strtoupper($value));
        $value = str_replace("EXECUTE", "E_X_E_C_U_T_E", strtoupper($value));
        $value = str_replace("EXEC", "E_X_E_C", strtoupper($value));
        $value = str_replace("ALTER", "A_L_T_E_R_(", strtoupper($value));
        $value = str_replace("SYSTEM", "S_Y_S_T_E_M", strtoupper($value));
        $value = str_replace("LOAD_FILE", "L_O_A_D___F_I_L_E", strtoupper($value));
        $value = str_replace("FUNCTION", "F_U_N_C_T_I_O_N", strtoupper($value));
        $value = str_replace("FROMCHARCODE", "F_R_O_M_C_H_A_R_C_O_D_E", strtoupper($value));
        $value = str_replace("HTTPURITYPE", "H_T_T_P_U_R_I_T_Y_P_E", strtoupper($value));
        $value = str_replace("SLEEP", "S_L_E_E_P", strtoupper($value));
        $value = str_replace("CHR", "C_H_R", strtoupper($value));
        $value = str_replace("ASCII", "A_S_C_I_I", strtoupper($value));
        $value = str_replace("SUBSTR", "S_U_B_S_T_R", strtoupper($value));
        $value = str_replace("BITAND", "B_I_T_A_N_D", strtoupper($value));
        $value = str_replace("LOWER", "L_O_W_E_R", strtoupper($value));
        $value = str_replace("REQUEST", "R_E_Q_U_E_S_T", strtoupper($value));
    }

    return $value;
}

define ('_BASE_','http://127.0.0.1/smartHome');
define ('_FILEBASE_','C:/xampp/htdocs/smartHome');
define ('_HOSTNAME_','127.0.0.1');
define ('_USERNAME_','root');
define ('_PASSWORD_','');
define ('_DATABASE_','smart_home');

include(_FILEBASE_."/inc/db.php");
include(_FILEBASE_."/inc/version.php");
$mysqli = db_connect();
