<?php
/* @var $this CatagoryController */
/* @var $model Catagory */

$this->breadcrumbs=array(
	'Catagories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Catagory', 'url'=>array('index')),
	array('label'=>'Manage Catagory', 'url'=>array('admin')),
);
?>

<h1>Create Catagory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>