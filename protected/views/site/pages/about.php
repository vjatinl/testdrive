<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>

<p>This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.</p>

<?php 
if(!Yii::app()->user->isGuest) {
	echo "SESSION SETUP @ LOGIN TIME : ".Yii::app()->user->uname."<br>"; //login time session variable set
	echo  "SESSION SETUP AFTER LOGIN (in HOME): ". Yii::app()->session->get('emprole')."<br>";  // after login session variable setup
}
?>
