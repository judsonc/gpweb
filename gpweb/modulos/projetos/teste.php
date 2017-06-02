<?php
    require_once BASE_DIR.'/lib/adodb/adodb.inc.php';

    $conn = NewADOConnection('oci8');
    $cstr = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.12.201)(PORT = 1521))
    )
    (CONNECT_DATA =
      (SID = ormtp6)
      (SERVER = DEDICATED)
    )
    )";

    if(!$conn->connect($cstr, 'sema', 'sema')){
        die('Não foi possivel conectar-se ao servidor');
    }

    $sql = "SELECT * FROM ACWVW0445 WHERE ROWNUM <= 3";


    $res = $conn->execute($sql);

    $lista = array();

    while ($res && $hash = $res->FetchRow()) {
        $lista[] = $hash;
        }

ver($lista);
?>