<?php
	echo "亲爱的用户 " .$user->username
	. " 您好!<br>";
	echo "您于 ".date('Y-m-d H:i:s')." 提交了密码充值的请求.<br>";
	echo "请在24小时内点击下面的链接重设您的密码:<br><br>";
	echo "请点击该验证链接 <a target='_blank' href='". \Yii::$app->urlManager->createAbsoluteUrl(['site/reset','_'=>$model->random])."'>重置密码</a> (该链接在24小时内有效)";
	echo "<br><br><br>";
	echo "若您无法直接点击链接,也可以复制以下地址到浏览器地址栏中<br>";
	echo "";
	echo \Yii::$app->urlManager->createAbsoluteUrl(['site/reset','_'=>$model->random]);
?>