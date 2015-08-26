<?php
   function ValidateEmail($email)
   {
      $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
      return preg_match($pattern, $email);
   }
   if ($_SERVER['REQUEST_METHOD'] == 'POST')
   {
      $mailto = 'offer@plenka-original.ru';
      $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
      $subject = 'Новая заявка.';
      $message = 'Заявка от:';
      $success_url = './Sucсess.php';
      $error_url = './Error.php';
      $error = '';
      $eol = "\n";
      $max_filesize = isset($_POST['filesize']) ? $_POST['filesize'] * 1024 : 1024000;
      $boundary = md5(uniqid(time()));
      $header  = 'From: '.$mailfrom.$eol;
      $header .= 'Reply-To: '.$mailfrom.$eol;
      $header .= 'MIME-Version: 1.0'.$eol;
      $header .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'.$eol;
      $header .= 'X-Mailer: PHP v'.phpversion().$eol;
      if (!ValidateEmail($mailfrom))
      {
         $error .= "The specified email address is invalid!\n<br>";
      }
      if (!empty($error))
      {
         $errorcode = file_get_contents($error_url);
         $replace = "##error##";
         $errorcode = str_replace($replace, $error, $errorcode);
         echo $errorcode;
         exit;
      }
      $internalfields = array ("submit", "reset", "send", "captcha_code");
      $message .= $eol;
      $message .= "IP Address : ";
      $message .= $_SERVER['REMOTE_ADDR'];
      $message .= $eol;
      foreach ($_POST as $key => $value)
      {
         if (!in_array(strtolower($key), $internalfields))
         {
            if (!is_array($value))
            {
               $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
            }
            else
            {
               $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
            }
         }
      }
      $body  = 'This is a multi-part message in MIME format.'.$eol.$eol;
      $body .= '--'.$boundary.$eol;
      $body .= 'Content-Type: text/plain; charset=UTF-8'.$eol;
      $body .= 'Content-Transfer-Encoding: 8bit'.$eol;
      $body .= $eol.stripslashes($message).$eol;
      if (!empty($_FILES))
      {
          foreach ($_FILES as $key => $value)
          {
             if ($_FILES[$key]['error'] == 0 && $_FILES[$key]['size'] <= $max_filesize)
             {
                $body .= '--'.$boundary.$eol;
                $body .= 'Content-Type: '.$_FILES[$key]['type'].'; name='.$_FILES[$key]['name'].$eol;
                $body .= 'Content-Transfer-Encoding: base64'.$eol;
                $body .= 'Content-Disposition: attachment; filename='.$_FILES[$key]['name'].$eol;
                $body .= $eol.chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))).$eol;
             }
         }
      }
      $body .= '--'.$boundary.'--'.$eol;
      if ($mailto != '')
      {
         mail($mailto, $subject, $body, $header);
      }
      header('Location: '.$success_url);
      exit;
   }
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Безымянная страница</title>
<meta name="author" content="Shipugin Vladislav">
<link href="button_ok_3795.ico" rel="shortcut icon">
<link href="Zakazz.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function ValidateForm1z(theForm)
{
   var regexp;
   if (theForm.indexEditbox6.value == "")
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox6.focus();
      return false;
   }
   if (theForm.indexEditbox6.value.length < 2)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox6.focus();
      return false;
   }
   if (theForm.indexEditbox6.value.length > 100)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox6.focus();
      return false;
   }
   if (theForm.indexEditbox7.value == "")
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox7.focus();
      return false;
   }
   if (theForm.indexEditbox7.value.length < 6)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox7.focus();
      return false;
   }
   if (theForm.indexEditbox7.value.length > 20)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox7.focus();
      return false;
   }
   if (theForm.indexEditbox5.value == "")
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox5.focus();
      return false;
   }
   if (theForm.indexEditbox5.value.length < 2)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox5.focus();
      return false;
   }
   if (theForm.indexEditbox5.value.length > 40)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox5.focus();
      return false;
   }
   return true;
}
</script>
</head>
<body>
   <div id="container">
      <div id="wb_indexImage42" style="position:absolute;left:0px;top:0px;width:330px;height:366px;z-index:7;">
         <img src="images/blok-forma.png" id="indexImage42" alt="" style="width:330px;height:366px;">
      </div>
      <div id="wb_indexForm3" style="position:absolute;left:0px;top:0px;width:330px;height:365px;z-index:8;">
         <form name="Form1z" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" accept-charset="UTF-8" id="indexForm3" onsubmit="return ValidateForm1z(this)">
            <input type="hidden" name="filesize" value="4096">
            <input type="text" id="indexEditbox6" style="position:absolute;left:23px;top:169px;width:287px;height:84px;line-height:84px;z-index:0;" name="Dannie" value="" placeholder="&#1053;&#1091;&#1078;&#1085;&#1099;&#1077; &#1094;&#1080;&#1092;&#1088;&#1099; &#1080; &#1072;&#1076;&#1088;&#1077;&#1089; &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1080;.">
            <div id="wb_indexText33" style="position:absolute;left:45px;top:10px;width:246px;height:27px;text-align:center;z-index:1;">
<span style="color:#000000;font-family:'trebuchet ms';font-size:21px;"><strong>Просто оставьте заявку</strong></span></div>
            <div id="wb_indexText34" style="position:absolute;left:16px;top:264px;width:295px;height:36px;z-index:2;text-align:left;">
               <span style="color:#000000;font-family:'trebuchet ms';font-size:13px;"><em>* Мы гарантируем 100%, что Ваши данные не будут переданы в третьи руки.</em></span></div>
            <div id="wb_indexImage46" style="position:absolute;left:55px;top:309px;width:206px;height:38px;z-index:3;">
               <img src="images/btnz.png" id="indexImage46" alt="" style="width:206px;height:38px;"></div>
            <input type="text" id="indexEditbox7" style="position:absolute;left:23px;top:110px;width:287px;height:44px;line-height:44px;z-index:4;" name="Mob" value="" placeholder="&#1042;&#1072;&#1096;  &#1085;&#1086;&#1084;&#1077;&#1088; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;&#1072;:">
            <input type="text" id="indexEditbox5" style="position:absolute;left:22px;top:54px;width:289px;height:45px;line-height:45px;z-index:5;" name="FIO" value="" placeholder="&#1042;&#1072;&#1096;&#1077; &#1060;&#1048;&#1054; &#1087;&#1086;&#1083;&#1085;&#1086;&#1089;&#1090;&#1100;&#1102;:">
            <input type="submit" id="indexButton3" name="Zakaz" value="" style="position:absolute;left:54px;top:310px;width:206px;height:37px;z-index:6;">
         </form>
      </div>
   </div>
</body>
</html>