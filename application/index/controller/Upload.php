<?php
namespace app\index\controller;

class Upload{
    public $upload_name;                    //上传文件名
    public $upload_tmp_name;                //上传临时文件名
    public $upload_final_name;              //上传文件的最终文件名
    public $upload_target_dir;              //文件被上传到的目标目录
    public $upload_target_path;             //文件被上传到的最终路径
    public $upload_filetype ;               //上传文件类型
    public $allow_uploadedfile_type;        //允许的上传文件类型
    public $upload_file_size;               //上传文件的大小
    public $allow_uploaded_maxsize=10000000;//允许上传文件的最大值
    //构造函数
    public function __construct()
    {
        // $this->upload_name = $_FILES["file"]["name"]; //取得上传文件名
        // $this->upload_filetype = $_FILES["file"]["type"];
        // $this->upload_tmp_name = $_FILES["file"]["tmp_name"];
        // $this->allow_uploadedfile_type = array('jpeg','silk','jpg','png','gif','bmp','doc','xls','csv','zip','rar','txt','wps');
        // $this->upload_file_size = $_FILES["file"]["size"];
        // $this->upload_target_dir="/webdata/api/upload/silk-v3-decoder-master/upload";
    }
    //文件上传
    public function index()
    {
        // var_dump(is_file($this->upload_tmp_name));die;
        header("Content-Type:text/html; charset=utf-8");
        $upload_filetype = $this->getFileExt($this->upload_name);//获取文件扩展名
        if(in_array($upload_filetype,$this->allow_uploadedfile_type))//判断文件类型是否符合要求
        {
            if($this->upload_file_size < $this->allow_uploaded_maxsize)//判断文件大小是否超过允许的最大值
            {
                if(!is_dir($this->upload_target_dir))//如果文件上传目录不存在
                {
                    mkdir($this->upload_target_dir);//创建文件上传目录
                    chmod($this->upload_target_dir,0777);//改权限
                }
                $this->upload_final_name = date("YmdHis").rand(0,100).'.'.$upload_filetype;//生成随机文件名
                $this->upload_target_path = $this->upload_target_dir."/".$this->upload_final_name;//文件上传目标目录
                if(!move_uploaded_file($this->upload_tmp_name,$this->upload_target_path))//文件移动失败
                {
                    echo("<font color=red>上传失败，请检查文件夹权限！</font>");
                    exit('success');
                }
                else
                {
                  //上传成功，将.silk文件转换为.wav格式;
                  $this->silkToWav($this->upload_target_dir, $this->upload_final_name);
                }
            }
            else
            {
                echo("<font color=red>文件太大,上传失败！</font>");
            }
        }
        else
        {
            echo("<font color=red>仅支持一下文件类型，请重新选择：<br>".implode('，',$this->allow_uploadedfile_type)."</font>");
        }
    }
    /**
    *获取文件扩展名
    *@param String $filename 要获取文件名的文件
    */
    private function getFileExt($filename){
        $info = pathinfo($filename);
        return @$info["extension"];
    }

    /**
    *将.silk格式的文件转换成.wav格式
    *@param String $filePath要获取文件的绝对路径
    */
    public function silkToWav($filePath, $fileName) {
      $filePath = 'webdata/api/upload/silk-v3-decoder-master/upload';
      $fileName = '2017092720320224.silk';
      $tmpPath = '/webdata/api/upload/silk-v3-decoder-master/';
      $file = $filePath.'/'.$fileName;
      $cmd  = $tmpPath.'converter.sh '.$file.' wav';
      $name = date("YmdHis").'wav';
      exec($cmd, $output);
      $cmd  = "ffmpeg -f s16le -ar 24000 -i $file -f wav -ar 16000 -b:a 16 -ac 1 $filePath".$name;
      exec($cmd, $output);
      //转码成功
      $wavFile = $filePath.'/'.$name;
      $this->voiceToText($wavFile);
    }

    public function voiceToText($file) {
      $handle    = fopen($file,"rb");
      $content   = fread($handle,filesize($file));
      $tmp       = base64_encode($content);
      $text      = 'data='.$tmp;
      $timestamp = time();
      $param     = array('auf' => '16k', 'aue' => 'raw', 'scene' => 'main');
      $param     = base64_encode(json_encode($param));
      $checkSum  = md5('daa3e49549c8481389ef01d2a4488f88'.$timestamp.$param.$text);
      $url       = 'http://api.xfyun.cn/v1/aiui/v1/iat';
      $data     = array(
        'timestamp' => $timestamp,
        'checkSum'  => $checkSum,
        'param'     => $param,
        'text'      => $text
      );
      $this->doCurl($url, 'post', $data);
    }

    private function doCurl($url, $method = 'get', $data = null) {
      $header = [
        "X-Appid:59c37565",
        "X-CurTime:".$data['timestamp'],
        "X-Param:".$data['param'],
        "X-CheckSum:".$data['checkSum'],
      ];
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    	if($method == 'post') {
    		curl_setopt($ch, CURLOPT_POST, 1);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $data['text']);
    	}
    	$response = curl_exec($ch);
    	if(curl_errno($ch)){
    		print curl_error($ch);
    	}
    	curl_close($ch);
      $data = json_decode($response, true);
      $data = json_encode($data, JSON_UNESCAPED_UNICODE);
      exit($data);
    }
}
?>
