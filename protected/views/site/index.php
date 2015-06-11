<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Congratulations! You have successfully created your Yii application.</p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <code><?php echo __FILE__; ?></code></li>
	<li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
</ul>

<p>For more details on how to further develop this application, please read
the <a href="http://www.yiiframework.com/doc/">documentation</a>.
Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
should you have any questions.</p>


<?php
	$imgpath = Yii::app()->baseUrl."/images/go.jpg";
	$msg = 'Success - College Registration <br><center>'. CHtml::image($imgpath,'alt', array('height'=>'100', 'width'=>'100')).'</center>';
	Yii::app()->user->setFlash('register',$msg);
	echo "baseUrl--- " . Yii::app()->baseUrl;
	echo "<br>request->baseUrl--- " . Yii::app()->request->baseUrl;
	/*Yii::app()->user->setFlash('success', "Data1 saved!");
	Yii::app()->user->setFlash('error', "Data2 failed!");
	Yii::app()->user->setFlash('notice', "Data3 ignored.");
	
	
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
	*/
?>
<?php if(Yii::app()->user->hasFlash('register')):?>
        <div class="flash-error">
                <?php echo Yii::app()->user->getFlash('register'); ?>
                <?php
                Yii::app()->clientScript->registerScript(
                'myHideEffect',
                '$(".flash-error").animate({opacity: 1.0}, 5000).fadeOut("slow");
                $(".flash-error").css({position:absolute, top:100, left:100})',
                CClientScript::POS_READY
);
        ?>
        </div>
<?php endif; ?>
<?php 
if(!Yii::app()->user->isGuest) {	
	echo  Yii::app()->session->add('emprole', 'Traine');  // after login session variable setup
}
?>

