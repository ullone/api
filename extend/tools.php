<?php

  /**
  * 遍历指定目录下的所有文件与目录，并存储在数组中
  * @param $dirName 目录的绝对路径
  * @param $data    已定义的外部变量，用于存储遍历结果
  */
  function listFile($dirName) {
    global $data;
    $dir  = opendir($dirName);
    readdir($dir); //读取当前目录文件
    readdir($dir); //读取上级目录文件
    while($filename = readdir($dir)){
      //要判断的是$dirName下的路径是否是目录
      $newfile=$dirName."/".$filename;
      //is_dir()函数判断的是当前脚本的路径是不是目录
      if(is_dir($newfile)){
        //通过递归函数再遍历其子目录下的目录或文件
        $data[''.$dirName]["dir"][] = $filename;
        listFile($newfile);
      }else{
        $data[''.$dirName]["file"][] = $filename;
      }
    }
    closedir($dir);
  }
