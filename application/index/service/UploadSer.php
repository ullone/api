<?php
namespace app\index\service;

use app\index\service\Func;
use app\index\service\Comprehensions;
use app\index\service\Voice2text;

class UploadSer{

    //文件上传
    public static function upload($file)
    {
        $upload_target_dir = "/webdata/api/upload/silk-v3-decoder-master/upload";
        $allow_uploaded_maxsize=10000000;
        header("Content-Type:text/html; charset=utf-8");
        if($file['upload_tmp_name'] === null) Func::callBack(101,'上传文件为空');
        $upload_filetype = self::getFileExt($file['upload_name']);//获取文件扩展名
        if(in_array($upload_filetype,$file['allow_uploadedfile_type']))//判断文件类型是否符合要求
        {
            if($file['upload_file_size'] < $allow_uploaded_maxsize)//判断文件大小是否超过允许的最大值
            {
                if(!is_dir($upload_target_dir))//如果文件上传目录不存在
                {
                    mkdir($upload_target_dir);//创建文件上传目录
                    chmod($upload_target_dir, 0777);//改权限
                }
                $upload_final_name = date("YmdHis").rand(0,100).'.'.$upload_filetype;//生成随机文件名
                $upload_target_path = $upload_target_dir."/".$upload_final_name;//文件上传目标目录
                if(!move_uploaded_file($file['upload_tmp_name'], $upload_target_path))//文件移动失败
                {
                    Func::callBack(104, '上传文件失败，请检查文件权限');
                }
                else
                {
                  //上传成功，返回文件绝对路径
                  return array(
                    'dir'  => $upload_target_dir,
                    'name' => $upload_final_name
                  );
                }
            }
            else Func::callBack(103, '上传文件不能超过10M，请重新上传');
        }
        else Func::callBack(102, '上传的文件类型不支持，请上传.silk文件');
    }
    /**
    *获取文件扩展名
    *@param String $filename 要获取文件名的文件
    */
    public static function getFileExt($filename){
        $info = pathinfo($filename);
        return @$info["extension"];
    }

    /**
    *将.silk格式的文件转换成.wav格式
    *@param String $filePath要获取文件的绝对路径
    */
    public static function silkToWav($filePath, $fileName) {
      $tmpPath = '/webdata/api/upload/silk-v3-decoder-master/';
      $file    = $filePath.'/'.$fileName;
      var_dump($file);die;
      if(!is_file($file)) Func::callBack(105, '文件不存在，请重新上传');
      $cmd     = $tmpPath.'converter.sh '.$file.' wav';
      exec($cmd, $output);
      $wavName = basename($fileName, ".silk");
      $wavName = $wavName.'.wav';
      $file    = $filePath.'/'.$wavName;
      if(!is_file($file)) Func::callBack(105, '文件转码失败');
      $name    = date("YmdHis").'.wav';
      $cmd     = "ffmpeg -f s16le -ar 24000 -i $file -f wav -ar 16000 -b:a 16 -ac 1 $filePath/".$name;
      exec($cmd, $output);
      //转码成功
      $wavFile = $filePath.'/'.$name;
      if(!is_file($wavFile)) Func::callBack(106, '文件频率转换失败');
      return $wavFile;
    }
}
?>
