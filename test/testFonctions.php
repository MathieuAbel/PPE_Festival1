<?php

//include("_gestionErreurs.inc.php");
$m1 = '/[^a-z]/';
$m0 = '/[^0-9]/';
$motif = $m0;
$v1 = "44650";
$v2 = "2B420";
$v3 = "ANTHONy";
echo "resu 1 : ".preg_match($motif, $v1)."<br/>";
echo "resu 2 : ".preg_match($motif, $v2)."<br/>";
echo "resu 3 : ".preg_match($motif, $v3)."<br/>";
