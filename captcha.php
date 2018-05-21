<?php
    session_start();
    $str = (string)chr(rand(97,122)).(string)chr(rand(97,122));
    $codestr= $str.(string)rand(111,999);
    $_SESSION['codestr']=$codestr;
    $im = imagecreatetruecolor(50, 24);
    $bg = imagecolorallocate($im, 22, 86, 165); //background color blue
    $fg = imagecolorallocate($im, 255, 255, 255);//text color white
    imagefill($im, 0, 0, $bg);
    imagestring($im, 5, 5, 5,  $codestr, $fg);
    header("Cache-Control: no-cache, must-revalidate");
    header('Content-type: image/png');
    imagepng($im);
    imagedestroy($im);
?>