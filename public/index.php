<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

//服务器校验
$token = sha1("8b0b255ffb10cd97");
echo $token;
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
fwrite($myfile, $token.'\n');
$txt = "Steve Jobs\n";
fwrite($myfile, $txt);
fclose($myfile);
exit();

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
