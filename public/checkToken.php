<?php

//服务器校验
$token = sha1("8b0b255ffb10cd97");
echo $token;
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
fwrite($myfile, $token.'\n');
$txt = "Steve Jobs\n";
fwrite($myfile, $txt);
fclose($myfile);
exit();

?>
