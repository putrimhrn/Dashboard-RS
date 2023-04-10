<?php
$conn = oci_connect("TB BASDAT", "220902", "//localhost/XE");
if(!$conn){
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}else{
    echo "connected\n";
}
oci_close($conn);
?>