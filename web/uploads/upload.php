<?php
$filename=uniqid('f_').'.'.$_GET['filetype'];
$fileData=file_get_contents('php://input');
if (!file_exists('uploads')) {
    mkdir('uploads', 777, true);
}
    $fhandle=fopen("reclamation_image/".$filename, 'wb');
fwrite($fhandle, $fileData);
fclose($fhandle);
echo($filename);
?>