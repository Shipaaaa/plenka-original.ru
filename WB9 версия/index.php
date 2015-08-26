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
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Зaщитные пленкина на гос. номер от камер ГИБДД.</title>
<meta name="description" content="Купить наноплёнки сейчас!">
<meta name="keywords" content="Нано плёнки, штрафы.">
<meta name="author" content="Shipugin Vlad">
<link href="button_ok_3795.ico" rel="shortcut icon">
<link href="index.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="fancybox/jquery.easing-1.3.pack.js"></script>
<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.0.css" type="text/css">
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.0.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript">
function ValidateForm3(theForm)
{
   var regexp;
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
   return true;
}
</script>
<script type="text/javascript">
function ValidateForm2(theForm)
{
   var regexp;
   if (theForm.indexEditbox3.value == "")
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox3.focus();
      return false;
   }
   if (theForm.indexEditbox3.value.length < 2)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox3.focus();
      return false;
   }
   if (theForm.indexEditbox3.value.length > 100)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox3.focus();
      return false;
   }
   if (theForm.indexEditbox4.value == "")
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox4.focus();
      return false;
   }
   if (theForm.indexEditbox4.value.length < 6)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox4.focus();
      return false;
   }
   if (theForm.indexEditbox4.value.length > 20)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox4.focus();
      return false;
   }
   if (theForm.indexEditbox2.value == "")
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox2.focus();
      return false;
   }
   if (theForm.indexEditbox2.value.length < 2)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox2.focus();
      return false;
   }
   if (theForm.indexEditbox2.value.length > 40)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox2.focus();
      return false;
   }
   return true;
}
</script>
<script type="text/javascript">
function ValidateForm1(theForm)
{
   var regexp;
   if (theForm.indexEditbox1.value == "")
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox1.focus();
      return false;
   }
   if (theForm.indexEditbox1.value.length < 2)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox1.focus();
      return false;
   }
   if (theForm.indexEditbox1.value.length > 40)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox1.focus();
      return false;
   }
   if (theForm.indexEditbox8.value == "")
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox8.focus();
      return false;
   }
   if (theForm.indexEditbox8.value.length < 2)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox8.focus();
      return false;
   }
   if (theForm.indexEditbox8.value.length > 100)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox8.focus();
      return false;
   }
   if (theForm.indexEditbox9.value == "")
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox9.focus();
      return false;
   }
   if (theForm.indexEditbox9.value.length < 6)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox9.focus();
      return false;
   }
   if (theForm.indexEditbox9.value.length > 20)
   {
      alert("Некорректный ввод, Исправте ошибки.");
      theForm.indexEditbox9.focus();
      return false;
   }
   return true;
}
</script>
<script type="text/javascript" src="wwb9.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
   $('#indexInlineFrame1').click(function()
   {
      $.fancybox(
      {
         'padding' : 0,
         'autoScale' : false,
         'transitionIn' : 'none',
         'transitionOut' : 'none',
         'title' : this.title,
         'width' : 605,
         'height' : 420,
         'href' : this.href,
         'type' : 'iframe'
      });
      return false;
   });
});
</script>
<script>
$(document).ready(function(){
	$('a[href^="#"]').on('click',function (e) {
	    e.preventDefault();
	    var target = this.hash,
	    $target = $(target);
	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
	});
});
</script>
</head>
<body>
   <div id="container">
      <div id="wb_indexImage41" style="position:absolute;left:1px;top:6242px;width:1002px;height:708px;z-index:21;">
         <img src="images/lvl9.png" id="indexImage41" alt="" style="width:1002px;height:708px;">
      </div>
      <div id="wb_indexImage27" style="position:absolute;left:1px;top:4152px;width:1002px;height:1080px;z-index:22;">
         <img src="images/lvl7.png" id="indexImage27" alt="" style="width:1002px;height:1080px;">
      </div>
      <div id="wb_indexImage22" style="position:absolute;left:0px;top:3180px;width:1003px;height:1076px;z-index:23;">
         <img src="images/lvl6.png" id="indexImage22" alt="" style="width:1003px;height:1076px;">
      </div>
      <div id="wb_indexImage12" style="position:absolute;left:0px;top:2289px;width:1003px;height:954px;z-index:24;">
         <img src="images/lvl5.png" id="indexImage12" alt="" style="width:1003px;height:954px;">
      </div>
      <div id="wb_indexImage10" style="position:absolute;left:0px;top:937px;width:1003px;height:1397px;z-index:25;">
         <div id="kak"><img src="images/lvl4.png" id="indexImage10" alt="" style="width:1003px;height:1397px;"></div>
      </div>
      <div id="wb_indexImage5" style="position:absolute;left:0px;top:716px;width:1003px;height:262px;z-index:26;">
         <img src="images/lvl3.png" id="indexImage5" alt="" style="width:1003px;height:262px;">
      </div>
      <div id="wb_indexImage1" style="position:absolute;left:0px;top:80px;width:1004px;height:655px;z-index:27;">
         <img src="images/lvl2fon.png" id="indexImage1" alt="" style="width:1004px;height:655px;">
      </div>
      <div id="wb_indexImage2" style="position:absolute;left:0px;top:0px;width:1006px;height:78px;z-index:28;">
         <img src="images/header.png" id="indexImage2" alt="" style="width:1006px;height:78px;">
      </div>
      <div id="wb_header1" style="position:absolute;left:89px;top:89px;width:829px;height:43px;text-align:center;z-index:29;">
<span style="color:#e6e6fa;font-family:'trebuchet ms';font-size:35px;"><strong>НАНОПЛЕНКИ НА НОМЕРА</strong></span>
      </div>
      <div id="wb_Text2" style="position:absolute;left:166px;top:131px;width:675px;height:22px;text-align:center;z-index:30;">
<span style="color:#ffffff;font-family:'trebuchet ms';font-size:16px;">ЗАБУДЬ ПРО ШТРАФЫ НАВСЕГДА!</span>
      </div>
      <div id="wb_indexImage4" style="position:absolute;left:71px;top:553px;width:542px;height:122px;z-index:31;">
         <img src="images/blok-sale.png" id="indexImage4" alt="" style="width:542px;height:122px;">
      </div>
      <div id="wb_Image5" style="position:absolute;left:690px;top:617px;width:88px;height:69px;z-index:32;">
         <img src="images/countdown_bg.png" id="Image5" alt="" style="width:88px;height:69px;">
      </div>
      <div id="wb_Image6" style="position:absolute;left:780px;top:618px;width:88px;height:69px;z-index:33;">
         <img src="images/countdown_bg.png" id="Image6" alt="" style="width:88px;height:69px;">
      </div>
      <div id="wb_Image7" style="position:absolute;left:871px;top:618px;width:88px;height:69px;z-index:34;">
         <img src="images/countdown_bg.png" id="Image7" alt="" style="width:88px;height:69px;">
      </div>
      <div id="wb_Text3" style="position:absolute;left:704px;top:657px;width:60px;height:18px;text-align:center;z-index:35;">
         <span style="color:#ffffff;font-family:'trebuchet ms';font-size:13px;"><strong>часов</strong></span>
      </div>
      <div id="wb_Text4" style="position:absolute;left:795px;top:658px;width:60px;height:18px;text-align:center;z-index:36;">
         <span style="color:#ffffff;font-family:'trebuchet ms';font-size:13px;"><strong>минут</strong></span>
      </div>
      <div id="wb_Text5" style="position:absolute;left:886px;top:658px;width:60px;height:18px;text-align:center;z-index:37;">
         <span style="color:#ffffff;font-family:'trebuchet ms';font-size:13px;"><strong>секунд</strong></span>
      </div>
      <iframe name="InlineFrame1" id="InlineFrame1" style="position:absolute;left:717px;top:618px;width:56px;height:37px;z-index:38;" src="./countdown_hours.html" scrolling="no"></iframe>
      <iframe name="InlineFrame1" id="InlineFrame2" style="position:absolute;left:802px;top:619px;width:56px;height:37px;z-index:39;" src="./countdown_minutes.html" scrolling="no"></iframe>
      <iframe name="InlineFrame1" id="InlineFrame3" style="position:absolute;left:895px;top:619px;width:56px;height:37px;z-index:40;" src="./countdown_seconds.html" scrolling="no"></iframe>
      <div id="wb_indexText1" style="position:absolute;left:698px;top:577px;width:283px;height:26px;z-index:41;text-align:left;">
         <span style="color:#ffd700;font-family:impact;font-size:21px;">ВРЕМЯ ДО ОКОНЧАНИЯ АКЦИИ</span>
      </div>
      <div id="wb_indexImage6" style="position:absolute;left:199px;top:753px;width:113px;height:170px;z-index:42;">
         <img src="images/oplata.png" id="indexImage6" alt="" style="width:113px;height:170px;">
      </div>
      <div id="wb_indexImage7" style="position:absolute;left:361px;top:755px;width:113px;height:170px;z-index:43;">
         <img src="images/price.png" id="indexImage7" alt="" style="width:113px;height:170px;">
      </div>
      <div id="wb_indexImage8" style="position:absolute;left:533px;top:756px;width:113px;height:170px;z-index:44;">
         <img src="images/dostavka.png" id="indexImage8" alt="" style="width:113px;height:170px;">
      </div>
      <div id="wb_indexImage9" style="position:absolute;left:708px;top:753px;width:113px;height:170px;z-index:45;">
         <img src="images/original.png" id="indexImage9" alt="" style="width:113px;height:170px;">
      </div>
      <div id="wb_indexText2" style="position:absolute;left:153px;top:998px;width:700px;height:60px;text-align:center;z-index:46;">
         <span style="color:#000000;font-family:impact;font-size:48px;">КАК ЭТО РАБОТАЕТ?</span>
      </div>
      <div id="wb_indexYouTube1" style="position:absolute;left:67px;top:1082px;width:393px;height:281px;z-index:47;">
         <iframe width="393" height="281" src="http://www.youtube.com/embed/H7fi6UVP97U?rel=0&amp;version=3&amp;autohide=0&amp;fs=1&amp;theme=dark" allowfullscreen=""></iframe>
      </div>
      <div id="wb_indexYouTube2" style="position:absolute;left:546px;top:1082px;width:393px;height:281px;z-index:48;">
         <iframe width="393" height="281" src="http://www.youtube.com/embed/nDMp4N-d9os?rel=0&amp;version=3&amp;autohide=0&amp;fs=1&amp;theme=dark" allowfullscreen=""></iframe>
      </div>
      <div id="wb_indexText3" style="position:absolute;left:72px;top:1392px;width:865px;height:216px;z-index:49;text-align:left;">
         <span style="color:#000000;font-family:'arial black';font-size:19px;">Наша пленка уникальна! Она накладывается на цифры номера и делает его невидимым для камер ГИБДД. Плёнка незаметна для человеческого глаза и обычных видеокамер. А вот камеры автоматической фиксации правонарушений &quot;Стрелка СТ&quot; и другие камеры снимающие в инфракрасном (ИК) спектре, улавливают вместо номера лишь БЛИК!<br><br>Наша нанопленка изготовлена в Германии, в отличии от китайских подделок, она не боится моек и погодных условий! </span>
      </div>
      <div id="wb_indexImage11" style="position:absolute;left:55px;top:1620px;width:893px;height:557px;z-index:50;">
         <img src="images/img0001.png" id="indexImage11" alt="" style="width:893px;height:557px;">
      </div>
      <div id="wb_indexText4" style="position:absolute;left:73px;top:2044px;width:865px;height:135px;z-index:51;text-align:left;">
         <span style="color:#000000;font-family:'arial black';font-size:19px;">За последние гогды в России значительно увеличилсь штрафы за превышение, (до 5000р). Зачастую, нам приходятся платить за нарушение ругого водителя, ведь не всегда камера фиксирует именно ВАШУ скорость. ХВАТИТ ПЛАТИТЬ ЧУЖИЕ ШТРАФЫ! В Европе давно практикуют данные плёнки. </span><span style="color:#ff0000;font-family:'arial black';font-size:19px;">Почему бы не начать нам?</span>
      </div>
      <div id="wb_indexText5" style="position:absolute;left:46px;top:2184px;width:915px;height:36px;text-align:center;z-index:52;">
         <span style="color:#ff0000;font-family:impact;font-size:29px;">ЗАКАЖИ НАШУ НАНОПЛЕНКУ И ЗАБУДЬ ПРО ШТРАФЫ!</span>
      </div>
      <div id="wb_indexInlineFrame1" style="position:absolute;left:363px;top:2238px;width:280px;height:56px;z-index:53;">
         <a id="indexInlineFrame1" title="" href="./Zakazz.php?iframe"><img src="images/btnz.png" style="width:280px;height:56px;" alt=""></a>
      </div>
      <div id="wb_indexText6" style="position:absolute;left:85px;top:2376px;width:837px;height:60px;text-align:center;z-index:54;">
         <span style="color:#000000;font-family:impact;font-size:48px;">ПОЧЕМУ ИМЕННО МЫ?</span>
      </div>
      <div id="wb_indexImage13" style="position:absolute;left:48px;top:2438px;width:198px;height:161px;z-index:55;">
         <img src="images/vozvrat_deneg.png" id="indexImage13" alt="" style="width:198px;height:161px;">
      </div>
      <div id="wb_indexImage14" style="position:absolute;left:234px;top:2430px;width:249px;height:171px;z-index:56;">
         <img src="images/dostavka%20_car.png" id="indexImage14" alt="" style="width:249px;height:171px;">
      </div>
      <div id="wb_indexImage15" style="position:absolute;left:557px;top:2448px;width:195px;height:155px;z-index:57;">
         <img src="images/info.gif" id="indexImage15" alt="" style="width:195px;height:155px;">
      </div>
      <div id="wb_indexImage16" style="position:absolute;left:776px;top:2435px;width:180px;height:170px;z-index:58;">
         <img src="images/best_price.png" id="indexImage16" alt="" style="width:180px;height:170px;">
      </div>
      <div id="wb_indexImage17" style="position:absolute;left:44px;top:2614px;width:196px;height:217px;z-index:59;">
         <img src="images/blok-podcherk.png" id="indexImage17" alt="" style="width:196px;height:217px;">
      </div>
      <div id="wb_indexImage18" style="position:absolute;left:288px;top:2613px;width:196px;height:217px;z-index:60;">
         <img src="images/blok-podcherk.png" id="indexImage18" alt="" style="width:196px;height:217px;">
      </div>
      <div id="wb_indexImage19" style="position:absolute;left:767px;top:2614px;width:196px;height:217px;z-index:61;">
         <img src="images/blok-podcherk.png" id="indexImage19" alt="" style="width:196px;height:217px;">
      </div>
      <div id="wb_indexImage20" style="position:absolute;left:528px;top:2614px;width:196px;height:217px;z-index:62;">
         <img src="images/blok-podcherk.png" id="indexImage20" alt="" style="width:196px;height:217px;">
      </div>
      <div id="wb_indexText7" style="position:absolute;left:82px;top:2619px;width:140px;height:68px;z-index:63;text-align:left;">
         <span style="color:#ffffff;font-family:impact;font-size:27px;">ГАРАНТИЯ ВОЗВРАТА</span>
      </div>
      <div id="wb_indexText8" style="position:absolute;left:292px;top:2616px;width:188px;height:68px;text-align:center;z-index:64;">
         <span style="color:#ffffff;font-family:impact;font-size:27px;">БЕСПЛАТНАЯ&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ДОСТАВКА</span>
      </div>
      <div id="wb_indexText9" style="position:absolute;left:533px;top:2642px;width:188px;height:26px;text-align:center;z-index:65;">
         <span style="color:#ffffff;font-family:impact;font-size:21px;">ИНФОРМИРОВАНИЕ</span>
      </div>
      <div id="wb_indexText10" style="position:absolute;left:769px;top:2639px;width:188px;height:34px;text-align:center;z-index:66;">
         <span style="color:#ffffff;font-family:impact;font-size:27px;">НИЗКИЕ ЦЕНЫ</span>
      </div>
      <div id="wb_indexText11" style="position:absolute;left:52px;top:2697px;width:181px;height:109px;z-index:67;text-align:left;">
         <span style="color:#ffffff;font-family:arial;font-size:16px;">&#1045;сли Вам не понравится &#1090;&#1086;&#1074;&#1072;&#1088; &#1084;&#1099; </span><span style="color:#ffd700;font-family:arial;font-size:16px;"><strong>&#1074;&#1077;&#1088;&#1085;&#1077;&#1084; &#1042;&#1072;&#1084; &#1076;&#1077;&#1085;&#1100;&#1075;&#1080;</strong>.</span><span style="color:#ffffff;font-family:arial;font-size:16px;"><br><br>&#1043;арантия возврата<br>1&#1075;&#1086;д.</span>
      </div>
      <div id="wb_indexText12" style="position:absolute;left:295px;top:2699px;width:181px;height:110px;z-index:68;text-align:left;">
         <span style="color:#ffd700;font-family:arial;font-size:16px;"><strong>При заказе от 3х цифр.<br></strong></span><span style="color:#ffffff;font-family:arial;font-size:16px;"> <br>При заказе мене 3х цифр стоимость доставки всего 99 руб.</span>
      </div>
      <div id="wb_indexText13" style="position:absolute;left:536px;top:2699px;width:181px;height:93px;z-index:69;text-align:left;">
         <span style="color:#ffffff;font-family:arial;font-size:16px;">После отправления<br>заказа </span><span style="color:#ffd700;font-family:arial;font-size:16px;"><strong>Вы получаете<br>свой личный трэк- номер</strong></span><span style="color:#ffffff;font-family:arial;font-size:16px;"><strong> </strong>для отслеживания заказа.</span>
      </div>
      <div id="wb_indexText14" style="position:absolute;left:774px;top:2689px;width:181px;height:133px;z-index:70;text-align:left;">
         <span style="color:#ffffff;font-family:arial;font-size:15px;">Мы работаем </span><span style="color:#ffd700;font-family:arial;font-size:15px;">напрямую<br>с немецким производителем</span><span style="color:#ffffff;font-family:arial;font-size:15px;">, поэтому у нас самые низкие цены.</span><span style="color:#ffffff;font-family:arial;font-size:13px;"><br><br><strong>ОСТЕРЕГАЙТЕСЬ КИТАЙСКОЙ ПОДДЕЛКИ!</strong></span>
      </div>
      <div id="wb_indexImage21" style="position:absolute;left:191px;top:2870px;width:582px;height:300px;z-index:71;">
         <img src="images/map.png" id="indexImage21" alt="" style="width:582px;height:300px;">
      </div>
      <div id="wb_indexImage23" style="position:absolute;left:131px;top:4067px;width:88px;height:69px;z-index:72;">
         <img src="images/countdown_bg.png" id="indexImage23" alt="" style="width:88px;height:69px;">
      </div>
      <iframe name="InlineFrame1" id="indexInlineFrame3" style="position:absolute;left:158px;top:4068px;width:56px;height:37px;z-index:73;" src="./countdown_hours.html" scrolling="no"></iframe>
      <div id="wb_indexText18" style="position:absolute;left:145px;top:4107px;width:60px;height:18px;text-align:center;z-index:74;">
         <span style="color:#ffffff;font-family:'trebuchet ms';font-size:13px;"><strong>часов</strong></span>
      </div>
      <div id="wb_indexImage25" style="position:absolute;left:221px;top:4068px;width:88px;height:69px;z-index:75;">
         <img src="images/countdown_bg.png" id="indexImage25" alt="" style="width:88px;height:69px;">
      </div>
      <iframe name="InlineFrame1" id="indexInlineFrame4" style="position:absolute;left:243px;top:4069px;width:56px;height:37px;z-index:76;" src="./countdown_minutes.html" scrolling="no"></iframe>
      <div id="wb_indexText19" style="position:absolute;left:236px;top:4108px;width:60px;height:18px;text-align:center;z-index:77;">
         <span style="color:#ffffff;font-family:'trebuchet ms';font-size:13px;"><strong>минут</strong></span>
      </div>
      <div id="wb_indexImage26" style="position:absolute;left:312px;top:4068px;width:88px;height:69px;z-index:78;">
         <img src="images/countdown_bg.png" id="indexImage26" alt="" style="width:88px;height:69px;">
      </div>
      <iframe name="InlineFrame1" id="indexInlineFrame5" style="position:absolute;left:336px;top:4069px;width:56px;height:37px;z-index:79;" src="./countdown_seconds.html" scrolling="no"></iframe>
      <div id="wb_indexText20" style="position:absolute;left:327px;top:4108px;width:60px;height:18px;text-align:center;z-index:80;">
         <span style="color:#ffffff;font-family:'trebuchet ms';font-size:13px;"><strong>секунд</strong></span>
      </div>
      <div id="wb_indexText21" style="position:absolute;left:58px;top:4021px;width:406px;height:34px;z-index:81;text-align:left;">
         <span style="color:#ffd700;font-family:impact;font-size:27px;">СПЕШИ! АКЦИЯ СКОРО ЗАКОНЧИТСЯ!</span>
      </div>
      <div id="wb_cheni" style="position:absolute;left:114px;top:3356px;width:778px;height:80px;text-align:center;z-index:82;">
         <span style="color:#000000;font-family:impact;font-size:64px;">НАШИ ЦЕНЫ</span>
      </div>
      <div id="wb_indexText23" style="position:absolute;left:137px;top:4304px;width:733px;height:53px;text-align:center;z-index:83;">
         <span style="color:#000000;font-family:impact;font-size:43px;">НАШИ НАНОПЛЕНКИ - ЭТО</span>
      </div>
      <div id="wb_indexImage28" style="position:absolute;left:14px;top:4406px;width:298px;height:220px;z-index:84;">
         <img src="images/blok-podcherk2.png" id="indexImage28" alt="" style="width:298px;height:220px;">
      </div>
      <div id="wb_indexImage29" style="position:absolute;left:203px;top:4350px;width:135px;height:135px;z-index:85;">
         <img src="images/pesoch_chasi.png" id="indexImage29" alt="" style="width:135px;height:135px;">
      </div>
      <div id="wb_indexText24" style="position:absolute;left:24px;top:4443px;width:229px;height:43px;z-index:86;text-align:left;">
         <span style="color:#ffffff;font-family:impact;font-size:35px;">БЕЗОПАСНОСТЬ</span>
      </div>
      <div id="wb_indexImage32" style="position:absolute;left:56px;top:4719px;width:313px;height:235px;z-index:87;">
         <img src="images/blok-podcherk2.png" id="indexImage32" alt="" style="width:313px;height:235px;">
      </div>
      <div id="wb_indexImage33" style="position:absolute;left:666px;top:4408px;width:298px;height:220px;z-index:88;">
         <img src="images/blok-podcherk2.png" id="indexImage33" alt="" style="width:298px;height:220px;">
      </div>
      <div id="wb_indexImage30" style="position:absolute;left:338px;top:4403px;width:298px;height:220px;z-index:89;">
         <img src="images/blok-podcherk2.png" id="indexImage30" alt="" style="width:298px;height:220px;">
      </div>
      <div id="wb_indexImage31" style="position:absolute;left:529px;top:4356px;width:127px;height:127px;z-index:90;">
         <img src="images/ger.png" id="indexImage31" alt="" style="width:127px;height:127px;">
      </div>
      <div id="wb_indexText25" style="position:absolute;left:353px;top:4431px;width:187px;height:53px;z-index:91;text-align:left;">
         <span style="color:#ffffff;font-family:impact;font-size:43px;">КАЧЕСТВО</span>
      </div>
      <div id="wb_indexText27" style="position:absolute;left:684px;top:4446px;width:226px;height:36px;z-index:92;text-align:left;">
         <span style="color:#ffffff;font-family:impact;font-size:29px;">ДОЛГОВЕЧНОСТЬ</span>
      </div>
      <div id="wb_indexImage34" style="position:absolute;left:865px;top:4354px;width:137px;height:137px;z-index:93;">
         <img src="images/infinity.png" id="indexImage34" alt="" style="width:137px;height:137px;">
      </div>
      <div id="wb_indexText26" style="position:absolute;left:57px;top:4734px;width:247px;height:68px;text-align:center;z-index:94;">
         <span style="color:#ffffff;font-family:impact;font-size:27px;">БЫСТРАЯ И ПРОСТАЯ УСТАНОВКА</span>
      </div>
      <div id="wb_indexImage35" style="position:absolute;left:297px;top:4680px;width:130px;height:130px;z-index:95;">
         <img src="images/clock.png" id="indexImage35" alt="" style="width:130px;height:130px;">
      </div>
      <div id="wb_indexYouTube3" style="position:absolute;left:522px;top:4722px;width:393px;height:281px;z-index:96;">
         <iframe width="393" height="281" src="http://www.youtube.com/embed/sTkVSyJBumU?rel=0&amp;version=3&amp;autohide=0&amp;fs=1&amp;theme=dark" allowfullscreen=""></iframe>
      </div>
      <div id="wb_indexImage36" style="position:absolute;left:1px;top:5232px;width:1002px;height:1078px;z-index:97;">
         <img src="images/lvl8.png" id="indexImage36" alt="" style="width:1002px;height:1078px;">
      </div>
      <div id="wb_indexText28" style="position:absolute;left:165px;top:5306px;width:676px;height:60px;text-align:center;z-index:98;">
         <span style="color:#000000;font-family:impact;font-size:48px;">НАМ ДОВЕРЯЮТ!</span>
      </div>
      <div id="wb_indexImage37" style="position:absolute;left:59px;top:5442px;width:768px;height:157px;z-index:99;">
         <img src="images/blok-podcherk3.png" id="indexImage37" alt="" style="width:768px;height:157px;">
      </div>
      <div id="wb_indexText29" style="position:absolute;left:65px;top:5384px;width:816px;height:34px;z-index:100;text-align:left;">
         <span style="color:#000000;font-family:impact;font-size:27px;">ПОСЛЕДНИЕ ОТЗЫВЫ НАШИХ ПОКУПАТЕЛЕЙ:</span>
      </div>
      <div id="wb_indexImage38" style="position:absolute;left:58px;top:5618px;width:768px;height:165px;z-index:101;">
         <img src="images/blok-podcherk3.png" id="indexImage38" alt="" style="width:768px;height:165px;">
      </div>
      <div id="wb_indexImage39" style="position:absolute;left:58px;top:5799px;width:768px;height:163px;z-index:102;">
         <img src="images/blok-podcherk3.png" id="indexImage39" alt="" style="width:768px;height:163px;">
      </div>
      <div id="wb_indexImage40" style="position:absolute;left:58px;top:5981px;width:768px;height:164px;z-index:103;">
         <img src="images/blok-podcherk3.png" id="indexImage40" alt="" style="width:768px;height:164px;">
      </div>
      <div id="wb_indexText30" style="position:absolute;left:69px;top:6183px;width:461px;height:18px;z-index:104;text-align:left;">
&nbsp;
      </div>
      <div id="wb_indexText31" style="position:absolute;left:61px;top:6161px;width:863px;height:22px;z-index:105;text-align:left;">
         <span style="color:#000000;font-family:'trebuchet ms';font-size:16px;">Присылайте свои отзывы на comment@plenka-original.ru . Ваш отзыв очень важен для нас!</span>
      </div>
      <div id="wb_indexText32" style="position:absolute;left:116px;top:6204px;width:774px;height:26px;text-align:center;z-index:106;">
         <span style="color:#000000;font-family:impact;font-size:21px;">БОЛЕЕ </span><span style="color:#ffd700;font-family:impact;font-size:21px;">1000 ЧЕЛОВЕК</span><span style="color:#000000;font-family:impact;font-size:21px;"> УЖЕ ПРИОБРЕЛИ НАШИ ПЛЁНКИ НА НОМЕРА.</span>
      </div>
      <div id="wb_indexImage42" style="position:absolute;left:618px;top:6502px;width:330px;height:366px;z-index:107;">
         <img src="images/blok-forma.png" id="indexImage42" alt="" style="width:330px;height:366px;">
      </div>
      <div id="wb_indexText35" style="position:absolute;left:109px;top:6362px;width:788px;height:53px;text-align:center;z-index:108;">
         <span style="color:#ffffff;font-family:impact;font-size:43px;">ЗАКАЖИ ПРЯМО СЕЙЧАС</span>
      </div>
      <div id="wb_indexText36" style="position:absolute;left:107px;top:6412px;width:792px;height:34px;text-align:center;z-index:109;">
         <span style="color:#ffffff;font-family:impact;font-size:27px;">И ЗАБУДЬ О ШТРАФАХ НАВСЕГДА!</span>
      </div>
      <div id="wb_indexImage43" style="position:absolute;left:0px;top:6932px;width:1002px;height:86px;z-index:110;">
         <img src="images/lvl10%2Cfooter.png" id="indexImage43" alt="" style="width:1002px;height:86px;">
      </div>
      <div id="wb_indexText37" style="position:absolute;left:18px;top:0px;width:710px;height:53px;z-index:111;text-align:left;">
         <span style="color:#ffd700;font-family:impact;font-size:43px;">P</span><span style="color:#ffffff;font-family:impact;font-size:43px;">lenka-</span><span style="color:#ffd700;font-family:impact;font-size:43px;">O</span><span style="color:#ffffff;font-family:impact;font-size:43px;">riginal.</span><span style="color:#ffd700;font-family:impact;font-size:43px;">RU</span>
      </div>
      <div id="wb_indexText38" style="position:absolute;left:2px;top:53px;width:373px;height:18px;text-align:center;z-index:112;">
         <span style="color:#ffffff;font-family:'trebuchet ms';font-size:13px;">ЗАЩИТНЫЕ ПЛЕНКИ НА ГОС.НОМЕР ОТ КАМЕР ГИБДД.</span>
      </div>
      <div id="wb_indexText39" style="position:absolute;left:380px;top:16px;width:124px;height:50px;text-align:center;z-index:113;">
         <span style="color:#ffffff;font-family:impact;font-size:20px;"><a href="#kak" class="style2">КАК ЭТО РАБОТАЕТ</a></span>
      </div>
      <div id="wb_indexText40" style="position:absolute;left:517px;top:30px;width:115px;height:36px;z-index:114;text-align:left;">
         <span style="color:#000000;font-family:'trebuchet ms';font-size:13px;">Double click to edit</span>
      </div>
      <div id="wb_indexText41" style="position:absolute;left:492px;top:25px;width:172px;height:26px;text-align:center;z-index:115;">
         <span style="color:#ffffff;font-family:impact;font-size:21px;"><a href="#wb_cheni" class="style2">НАШИ ЦЕНЫ</a></span>
      </div>
      <div id="wb_indexText42" style="position:absolute;left:589px;top:137px;width:445px;height:58px;text-align:center;z-index:116;">
         <span style="color:#ffffff;font-family:impact;font-size:24px;">ЗАКАЗАТЬ ПО АКЦИИ<br></span><span style="color:#ffd700;font-family:impact;font-size:24px;">ПРЯМО СЕЙЧАС!</span>
      </div>
      <div id="wb_indexText43" style="position:absolute;left:82px;top:563px;width:537px;height:86px;z-index:117;text-align:left;">
         <span style="color:#ff0000;font-family:impact;font-size:21px;">АКЦИЯ!</span><span style="color:#000000;font-family:impact;font-size:21px;"> Комплект &quot;Полная защита&quot;&nbsp; из 6-ти цифр&nbsp; +Бесплатная доставка первым классом! </span><span style="color:#000000;font-family:impact;font-size:16px;"><br></span><span style="color:#000000;font-family:impact;font-size:21px;">ВСЕГО ЗА </span><span style="color:#ff0000;font-family:impact;font-size:21px;"><strike>1980</strike></span><span style="color:#ff0000;font-family:impact;font-size:27px;"><strike>&nbsp; </strike>1490р.</span>
      </div>
      <div id="wb_indexText44" style="position:absolute;left:24px;top:4497px;width:277px;height:76px;text-align:center;z-index:118;">
         <span style="color:#ffffff;font-family:arial;font-size:17px;">Наши пленки не видны человеческому глазу, не выступают за края, </span><span style="color:#ffd700;font-family:arial;font-size:17px;">не отличаются</span><span style="color:#ffffff;font-family:arial;font-size:17px;"> по виду от привычных номеров.</span>
      </div>
      <div id="wb_indexText45" style="position:absolute;left:344px;top:4487px;width:278px;height:124px;text-align:center;z-index:119;">
         <span style="color:#ffffff;font-family:arial;font-size:15px;">Наши пленки произведены в Германии, ОНИ ДЕЙСТВИТЕЛЬНО ЗАЩИТЯТ ВАШ НОМЕР!</span><span style="color:#ffffff;font-family:arial;font-size:16px;"><br><br></span><span style="color:#ffd700;font-family:arial;font-size:16px;"><strong>НЕ ПРИОБРЕТАЙТЕ<br>китайскую подделку!</strong></span><span style="color:#ffffff;font-family:arial;font-size:16px;"><strong> </strong></span><span style="color:#ffffff;font-family:arial;font-size:15px;">ОНА <br>НЕ РЕШИТ ВАШЕЙ ПРОБЛЕМЫ!</span>
      </div>
      <div id="wb_indexText46" style="position:absolute;left:674px;top:4493px;width:278px;height:106px;text-align:justify;z-index:120;">
         <span style="color:#ffffff;font-family:arial;font-size:15px;">Наша пленка не боится погодных условий и моек! Она прослужит вам очень долго!</span><span style="color:#ffffff;font-family:arial;font-size:16px;"> </span><span style="color:#ffd700;font-family:arial;font-size:15px;"><strong>СРОК СЛУЖБЫ ДО 7 ЛЕТ! </strong><br></span><span style="color:#ffffff;font-family:arial;font-size:15px;">Приобретая наш продукт один раз- </span><span style="color:#ffd700;font-family:arial;font-size:15px;"><strong>Вы значительно экономите</strong></span><span style="color:#ffffff;font-family:arial;font-size:15px;"> на штрафах!</span>
      </div>
      <div id="wb_indexText47" style="position:absolute;left:65px;top:4822px;width:293px;height:98px;z-index:121;text-align:left;">
         <span style="color:#ffffff;font-family:arial;font-size:17px;">В среднем, нашу пленку<br>можно установить </span><span style="color:#ffd700;font-family:arial;font-size:17px;"><strong>за 5 минут.<br></strong></span><span style="color:#ffffff;font-family:arial;font-size:19px;"><br></span><span style="color:#ffffff;font-family:arial;font-size:16px;">Следуйте инструкции, что </span><span style="color:#ffd700;font-family:arial;font-size:16px;"><strong>входит в комплект с заказом!</strong></span>
      </div>
      <div id="wb_indexText48" style="position:absolute;left:529px;top:4655px;width:441px;height:25px;z-index:122;text-align:left;">
         <span style="color:#000000;font-family:impact;font-size:20px;">КАК<u> ПРАВИЛЬНО</u> УСТАНОВИТЬ НАШУ ПЛЕНКУ?</span>
      </div>
      <div id="wb_indexText49" style="position:absolute;left:529px;top:4679px;width:363px;height:37px;z-index:123;text-align:left;">
         <span style="color:#000000;font-family:arial;font-size:16px;"><em>* Более подробную инструкцию <strong></strong>Вы получите в комплекте с заказом!</em></span>
      </div>
      <div id="wb_indexText50" style="position:absolute;left:6px;top:6935px;width:354px;height:43px;z-index:124;text-align:left;">
         <span style="color:#ffd700;font-family:impact;font-size:35px;">P</span><span style="color:#ffffff;font-family:impact;font-size:35px;">lenka-</span><span style="color:#ffd700;font-family:impact;font-size:35px;">O</span><span style="color:#ffffff;font-family:impact;font-size:35px;">riginal</span>
      </div>
      <div id="wb_indexText51" style="position:absolute;left:6px;top:6979px;width:366px;height:36px;z-index:125;text-align:left;">
         <span style="color:#ffffff;font-family:'trebuchet ms';font-size:12px;">МАКСИМАЛЬНАЯ ЗАЩИТА ОТ ШТРАФА!<br>100% ОРИГИНАЛ! Германия.</span>
      </div>
      <div id="wb_indexText52" style="position:absolute;left:478px;top:6947px;width:288px;height:23px;z-index:126;text-align:left;">
         <span style="color:#ffffff;font-family:impact;font-size:19px;">НЕ ДОЗВОНИЛИСЬ?</span>
      </div>
      <div id="wb_indexText53" style="position:absolute;left:480px;top:6981px;width:337px;height:23px;z-index:127;text-align:left;">
         <span style="color:#ffffff;font-family:impact;font-size:19px;">ЗАКАЖИТЕ ОБРАТНЫЙ ЗВОНОК!</span>
      </div>
      <div id="wb_indexForm3" style="position:absolute;left:618px;top:6501px;width:330px;height:365px;z-index:128;">
         <form name="Form3" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" accept-charset="UTF-8" id="indexForm3" onsubmit="return ValidateForm3(this)">
            <input type="hidden" name="filesize" value="4096">
            <input type="text" id="indexEditbox5" style="position:absolute;left:21px;top:56px;width:289px;height:42px;line-height:42px;z-index:0;" name="FIO" value="" placeholder="&#1042;&#1072;&#1096;&#1077; &#1060;&#1048;&#1054; &#1087;&#1086;&#1083;&#1085;&#1086;&#1089;&#1090;&#1100;&#1102;:">
            <input type="text" id="indexEditbox6" style="position:absolute;left:23px;top:167px;width:288px;height:89px;line-height:89px;z-index:1;" name="Dannie" value="" placeholder="&#1053;&#1091;&#1078;&#1085;&#1099;&#1077; &#1094;&#1080;&#1092;&#1088;&#1099; &#1080; &#1072;&#1076;&#1088;&#1077;&#1089; &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1080;.">
            <div id="wb_indexText33" style="position:absolute;left:45px;top:10px;width:246px;height:27px;text-align:center;z-index:2;">
<span style="color:#000000;font-family:'trebuchet ms';font-size:21px;"><strong>Просто оставьте заявку</strong></span></div>
            <div id="wb_indexText34" style="position:absolute;left:16px;top:265px;width:295px;height:36px;z-index:3;text-align:left;">
               <span style="color:#000000;font-family:'trebuchet ms';font-size:13px;"><em>* Мы гарантируем 100%, что Ваши данные не будут переданы в третьи руки.</em></span></div>
            <div id="wb_indexImage46" style="position:absolute;left:55px;top:309px;width:206px;height:38px;z-index:4;">
               <img src="images/btnz.png" id="indexImage46" alt="" style="width:206px;height:38px;"></div>
            <input type="text" id="indexEditbox7" style="position:absolute;left:23px;top:111px;width:287px;height:44px;line-height:44px;z-index:5;" name="Mob" value="" placeholder="&#1042;&#1072;&#1096;  &#1085;&#1086;&#1084;&#1077;&#1088; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;&#1072;:">
            <input type="submit" id="indexButton3" name="Zakaz" value="" style="position:absolute;left:58px;top:309px;width:202px;height:37px;z-index:6;">
         </form>
      </div>
      <div id="wb_indexImage48" style="position:absolute;left:746px;top:6979px;width:253px;height:30px;z-index:129;">
         <img src="images/but.png" id="indexImage48" alt="" style="width:253px;height:30px;">
      </div>
      <div id="wb_indexText55" style="position:absolute;left:756px;top:6982px;width:239px;height:21px;text-align:center;z-index:130;">
         <span style="color:#000000;font-family:impact;font-size:17px;"><a href="javascript:displaylightbox('./Zvonok.php',{})" target="_self" class="style1">Заказать обратный звонок</a></span>
      </div>
      <div id="wb_indexImage47" style="position:absolute;left:742px;top:42px;width:253px;height:30px;z-index:131;">
         <img src="images/but.png" id="indexImage47" alt="" style="width:253px;height:30px;">
      </div>
      <div id="wb_indexText54" style="position:absolute;left:752px;top:45px;width:239px;height:21px;text-align:center;z-index:132;">
         <span style="color:#000000;font-family:impact;font-size:17px;"><a href="javascript:displaylightbox('./Zvonok.php',{})" target="_self" class="style1">Заказать обратный звонок</a></span>
      </div>
      <div id="wb_indexImage24" style="position:absolute;left:567px;top:3767px;width:330px;height:366px;z-index:133;">
         <img src="images/blok-forma.png" id="indexImage24" alt="" style="width:330px;height:366px;">
      </div>
      <div id="wb_indexImage3" style="position:absolute;left:650px;top:208px;width:330px;height:366px;z-index:134;">
         <img src="images/blok-forma.png" id="indexImage3" alt="" style="width:330px;height:366px;">
      </div>
      <div id="wb_indexForm1" style="position:absolute;left:567px;top:3767px;width:330px;height:365px;z-index:135;">
         <form name="Form2" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" accept-charset="UTF-8" id="indexForm1" onsubmit="return ValidateForm2(this)">
            <input type="hidden" name="filesize" value="4096">
            <input type="text" id="indexEditbox3" style="position:absolute;left:23px;top:169px;width:286px;height:85px;line-height:85px;z-index:7;" name="Dannie" value="" placeholder="&#1053;&#1091;&#1078;&#1085;&#1099;&#1077; &#1094;&#1080;&#1092;&#1088;&#1099; &#1080; &#1072;&#1076;&#1088;&#1077;&#1089; &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1080;.">
            <div id="wb_indexText16" style="position:absolute;left:45px;top:10px;width:246px;height:27px;text-align:center;z-index:8;">
<span style="color:#000000;font-family:'trebuchet ms';font-size:21px;"><strong>Просто оставьте заявку</strong></span></div>
            <div id="wb_indexText17" style="position:absolute;left:20px;top:265px;width:295px;height:36px;z-index:9;text-align:left;">
               <span style="color:#000000;font-family:'trebuchet ms';font-size:13px;"><em>* Мы гарантируем 100%, что Ваши данные не будут переданы в третьи руки.</em></span></div>
            <div id="wb_indexImage45" style="position:absolute;left:55px;top:309px;width:206px;height:38px;z-index:10;">
               <img src="images/btnz.png" id="indexImage45" alt="" style="width:206px;height:38px;"></div>
            <input type="text" id="indexEditbox4" style="position:absolute;left:23px;top:111px;width:287px;height:43px;line-height:43px;z-index:11;" name="Mob" value="" placeholder="&#1042;&#1072;&#1096;  &#1085;&#1086;&#1084;&#1077;&#1088; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;&#1072;:">
            <input type="submit" id="indexButton2" name="Zakaz" value="" style="position:absolute;left:58px;top:309px;width:202px;height:37px;z-index:12;">
            <input type="text" id="indexEditbox2" style="position:absolute;left:21px;top:54px;width:289px;height:42px;line-height:42px;z-index:13;" name="FIO" value="" placeholder="&#1042;&#1072;&#1096;&#1077; &#1060;&#1048;&#1054; &#1087;&#1086;&#1083;&#1085;&#1086;&#1089;&#1090;&#1100;&#1102;:">
         </form>
      </div>
      <div id="wb_indexForm2" style="position:absolute;left:650px;top:207px;width:330px;height:365px;z-index:136;">
         <form name="Form1" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" accept-charset="UTF-8" id="indexForm2" onsubmit="return ValidateForm1(this)">
            <input type="hidden" name="filesize" value="4096">
            <input type="text" id="indexEditbox1" style="position:absolute;left:21px;top:59px;width:289px;height:42px;line-height:42px;z-index:14;" name="FIO" value="" placeholder="&#1042;&#1072;&#1096;&#1077; &#1060;&#1048;&#1054; &#1087;&#1086;&#1083;&#1085;&#1086;&#1089;&#1090;&#1100;&#1102;:">
            <input type="text" id="indexEditbox8" style="position:absolute;left:23px;top:168px;width:286px;height:88px;line-height:88px;z-index:15;" name="Dannie" value="" placeholder="&#1053;&#1091;&#1078;&#1085;&#1099;&#1077; &#1094;&#1080;&#1092;&#1088;&#1099; &#1080; &#1072;&#1076;&#1088;&#1077;&#1089; &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1080;.">
            <div id="wb_indexText15" style="position:absolute;left:45px;top:10px;width:246px;height:27px;text-align:center;z-index:16;">
<span style="color:#000000;font-family:'trebuchet ms';font-size:21px;"><strong>Просто оставьте заявку</strong></span></div>
            <div id="wb_indexText56" style="position:absolute;left:16px;top:265px;width:295px;height:36px;z-index:17;text-align:left;">
               <span style="color:#000000;font-family:'trebuchet ms';font-size:13px;"><em>* Мы гарантируем 100%, что Ваши данные не будут переданы в третьи руки.</em></span></div>
            <div id="wb_indexImage44" style="position:absolute;left:55px;top:309px;width:206px;height:38px;z-index:18;">
               <img src="images/btnz.png" id="indexImage44" alt="" style="width:206px;height:38px;"></div>
            <input type="text" id="indexEditbox9" style="position:absolute;left:23px;top:111px;width:287px;height:44px;line-height:44px;z-index:19;" name="Mob" value="" placeholder="&#1042;&#1072;&#1096;  &#1085;&#1086;&#1084;&#1077;&#1088; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;&#1072;:">
            <input type="submit" id="indexButton1" name="Zakaz" value="" style="position:absolute;left:58px;top:309px;width:202px;height:37px;z-index:20;">
         </form>
      </div>
   </div>
</body>
</html>