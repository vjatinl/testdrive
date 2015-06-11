<?php
/* @var $this CatagoryController */
/* @var $model Catagory */

$this->breadcrumbs=array(
	'Catagories'=>array('index'),
	$model->cid=>array('view','id'=>$model->cid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Catagory', 'url'=>array('index')),
	array('label'=>'Create Catagory', 'url'=>array('create')),
	array('label'=>'View Catagory', 'url'=>array('view', 'id'=>$model->cid)),
	array('label'=>'Manage Catagory', 'url'=>array('admin')),
);
?>

<h1>Update Catagory <?php echo $model->cid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>