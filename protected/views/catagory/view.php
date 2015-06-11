<?php
/* @var $this CatagoryController */
/* @var $model Catagory */

$this->breadcrumbs=array(
	'Catagories'=>array('index'),
	$model->cid,
);

$this->menu=array(
	array('label'=>'List Catagory', 'url'=>array('index')),
	array('label'=>'Create Catagory', 'url'=>array('create')),
	array('label'=>'Update Catagory', 'url'=>array('update', 'id'=>$model->cid)),
	array('label'=>'Delete Catagory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Catagory', 'url'=>array('admin')),
);
?>

<h1>View Catagory #<?php echo $model->cid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cid',
		'cname',
	),
)); ?>
