<?php
mysql_query("DROP FUNCTION IF EXISTS strmes;");

mysql_query("CREATE FUNCTION strmes(t1 datetime)
RETURNS VARCHAR(2)
DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
RETURN LPAD(MONTH(t1),2,'0');
END;");
?>
