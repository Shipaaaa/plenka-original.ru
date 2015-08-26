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
      $subject = 'Заказ звонка.';
      $message = 'Заказ звонка:';
      $success_url = './Successzv.php';
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
<title>Заказать звонок</title>
<meta name="author" content="Shipugin Vlad">
<link href="button_ok_3795.ico" rel="shortcut icon">
<link href="Zvonok.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function ValidateСallForm1(theForm)
{
   var regexp;
   if (theForm.СallEditbox1.value == "")
   {
      alert("Некорректный ввод, Повторите попытку!");
      theForm.СallEditbox1.focus();
      return false;
   }
   if (theForm.СallEditbox1.value.length < 2)
   {
      alert("Некорректный ввод, Повторите попытку!");
      theForm.СallEditbox1.focus();
      return false;
   }
   if (theForm.СallEditbox1.value.length > 40)
   {
      alert("Некорректный ввод, Повторите попытку!");
      theForm.СallEditbox1.focus();
      return false;
   }
   if (theForm.СallEditbox2.value == "")
   {
      alert("Некорректный ввод, Повторите попытку!");
      theForm.СallEditbox2.focus();
      return false;
   }
   if (theForm.СallEditbox2.value.length < 5)
   {
      alert("Некорректный ввод, Повторите попытку!");
      theForm.СallEditbox2.focus();
      return false;
   }
   if (theForm.СallEditbox2.value.length > 20)
   {
      alert("Некорректный ввод, Повторите попытку!");
      theForm.СallEditbox2.focus();
      return false;
   }
   return true;
}
</script>
</head>
<body>
   <div id="container">
      <div id="wb_СallText1" style="position:absolute;left:18px;top:21px;width:392px;height:52px;z-index:5;text-align:left;">
         <span style="color:#ffd700;font-family:impact;font-size:21px;">Введите своё имя и номер телефона, в ближайшее время мы с вами свяжемся.</span>
      </div>
      <div id="wb_СallShape1" style="position:absolute;left:27px;top:129px;width:368px;height:177px;z-index:6;">
         <img src="images/img0003.png" id="СallShape1" alt="" style="border-width:0;width:368px;height:177px;">
      </div>
      <div id="wb_СallForm1" style="position:absolute;left:28px;top:128px;width:369px;height:177px;z-index:7;">
         <form name="СallForm1" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" accept-charset="UTF-8" id="СallForm1" onsubmit="return ValidateСallForm1(this)">
            <input type="submit" id="СallButton1" name="" value="Заказать звонок" style="position:absolute;left:163px;top:123px;width:183px;height:35px;z-index:0;">
            <input type="text" id="СallEditbox1" style="position:absolute;left:159px;top:19px;width:190px;height:31px;line-height:31px;z-index:1;" name="Name:" value="" placeholder="&#1042;&#1074;&#1077;&#1076;&#1080;&#1090;&#1077; &#1080;&#1084;&#1103;:">
            <input type="text" id="СallEditbox2" style="position:absolute;left:159px;top:63px;width:190px;height:33px;line-height:33px;z-index:2;" name="Phone:" value="" placeholder="&#1042;&#1074;&#1077;&#1076;&#1080;&#1090;&#1077; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;:">
            <div id="wb_СallText2" style="position:absolute;left:21px;top:25px;width:140px;height:20px;z-index:3;text-align:left;">
               <span style="color:#000000;font-family:impact;font-size:16px;">Введите имя:</span></div>
            <div id="wb_СallText3" style="position:absolute;left:16px;top:67px;width:164px;height:20px;z-index:4;text-align:left;">
               <span style="color:#000000;font-family:impact;font-size:16px;">Введите телефон:</span></div>
         </form>
      </div>
   </div>
</body>
</html>