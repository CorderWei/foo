<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"E:\WWW\foo\public/../application/../template/pc/Public\dispatch_jump.html";i:1507875161;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>跳转提示</title>
		<style type="text/css">
            html{font-size:10px}
            @media screen and (min-width:321px) and (max-width:375px){html{font-size:11px}}
            @media screen and (min-width:376px) and (max-width:414px){html{font-size:12px}}
            @media screen and (min-width:415px) and (max-width:639px){html{font-size:15px}}
            @media screen and (min-width:640px) and (max-width:719px){html{font-size:20px}}
            @media screen and (min-width:720px) and (max-width:749px){html{font-size:22.5px}}
            @media screen and (min-width:750px) and (max-width:799px){html{font-size:23.5px}}
            @media screen and (min-width:800px){html{font-size:25px}}

			*{ padding: 0; margin: 0; }
			body{ background: #fff; font-family: '微软雅黑'; color: #333; }
			.message{width: 666px;height: 214px;margin:auto;border:1px solid #2D7DEA;margin-top: 30px;}
			.head{width: 100%;height: 50px;background: #669FEC;text-align: center;line-height:50px;color:#fff;font-weight: 600}
			.content{height: 120px;width: 100%;}
			.success ,.error{text-align: center;margin-top: 30px;font-size:1.4rem;}
			.jump{text-align: center;margin-top: 20px;font-size:1.4rem;}
            .system-message{position:fixed;top:30%;left:0;width:100%;}
		</style>

    </head>

    <body>
		<div class="system-message">
        <?php switch ($code) {case 1:?>
            <p class="success"><?php echo(strip_tags($msg));?></p>
            <?php break;case 0:?>
            <p class="error"><?php echo(strip_tags($msg));?></p>
            <?php break;} ?>
        <p class="detail"></p>
        <p class="jump">
            页面自动 <a id="href" href="<?php echo($url);?>">跳转</a> 等待时间： <b id="wait"><?php echo($wait);?></b>
        </p>
    </div>
    <script type="text/javascript">
        (function(){
            var wait = document.getElementById('wait'),
                href = document.getElementById('href').href;
            var interval = setInterval(function(){
                var time = --wait.innerHTML;
                if(time <= 0) {
                    location.href = href;
                    clearInterval(interval);
                };
            }, 1000);
        })();
    </script>

    </body>

</html>