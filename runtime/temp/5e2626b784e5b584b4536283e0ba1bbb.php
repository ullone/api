<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"F:\web\www\movehouse\public/../application/index\view\index\index.html";i:1499955948;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>test</title>
    <!-- <link rel="stylesheet" href="http://res.wx.qq.com/open/libs/weui/1.0.0/weui.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="https://weui.io/weui.css"> -->
    <!-- <link href="static/css/jquery.city.bootstrap.css" rel="stylesheet" />
    <link href="static/css/animate.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="static/css/index.css">
    <link rel="stylesheet" href="static/css/${static_feat}.css"> -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
      function test () {
        $.post('api/Test/show',{
        },function (data) {
          alert('success');
        });
      }
    </script>
  </head>
  <body class="global">
    <div>
      <button onclick="test()">submit</button>
    </div>
    <br><br><br>
    <!-- <script src="https://res.wx.qq.com/open/libs/weuijs/1.0.0/weui.min.js"></script> -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- <script src="https://github.com/think2011/localResizeIMG/issues/6"></script> -->
    <!-- <script src="localResizeIMG/dist/lrz.bundle.js"></script>
    <script src="static/js/bootstrap.js"></script>
    <script src="static/js/jquery.city.js"></script> -->
    <!-- <script src="static/js/LocalResizeIMG.js" type="text/javascript"></script> -->

    <!-- mobileBUGFix.js 兼容修复移动设备 -->
    <!-- <script src="static/patch/mobileBUGFix.mini.js" type="text/javascript"></script> -->
    <!-- <script src="static/js/index.js"></script>
    <script src="static/js/${static_feat}.js"></script> -->
  </body>
</html>
