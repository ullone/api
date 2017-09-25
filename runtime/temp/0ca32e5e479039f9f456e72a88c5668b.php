<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:60:"D:\web\tp5\public/../application/index\view\index\index.html";i:1503559164;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>test</title>
    <script src="https://unpkg.com/vue"></script>
  </head>
  <body class="global">
    <div id="app-2">
      <span v-bind:title="message">
        鼠标悬停几秒钟查看此处动态绑定的提示信息！
      </span>
    </div>
  </body>
  <script type="text/javascript">
  var app2 = new Vue({
    el: '#app-2',
    data: {
      message: '页面加载于 ' + new Date().toLocaleString()
    }
  })
  </script>
</html>
