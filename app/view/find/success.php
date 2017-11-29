<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $config["project"];?>--发送成功</title>
	<link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/bootstrap/css/bootstrap.css">
</head>
<body>
	<div class="container">
		<h1>请登录你的网易邮箱查看邮件 :-)</h1>
		<h2>我们已经发送邮件至您的邮箱，请在15分钟<br>内通过邮件内的链接继续设置新的密码。 </h2>
		<div class="reg_activation_tip">
			<h2>提示：</h2>
			<p>若您长时间未收到邮件，请检查您的垃圾箱或广告箱，邮件有可能被误认为垃圾或广告邮件。<br>
			如果您一直未收到邮件，请重新尝试<a href="<?php echo $config['default_php']?>/user/findPwd" class="s4">找回密码。</a><br>
			如果您连续多次申请找回密码，请以最新收到的邮件为准！</p>
		</div>
	</div>
</body>
</html>