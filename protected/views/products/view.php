<?php
/* @var $this ProductsController */
/* @var $model Products */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->pid,
);

$this->menu=array(
	array('label'=>'List Products', 'url'=>array('index')),
	array('label'=>'Create Products', 'url'=>array('create')),
	array('label'=>'Update Products', 'url'=>array('update', 'id'=>$model->pid)),
	array('label'=>'Delete Products', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Products', 'url'=>array('admin')),
);
?>

<h1>View Products #<?php echo $model->pid; ?></h1>

<?php $imgpath = Yii::app()->getBaseUrl(true)."/upload/images/".$model->pid."/".$model->images; ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pid',
		'pname',
		array('label'=>'catagory', 'value'=>$model->catagory->cname),
		'pdesc',
		'price',
		array('label'=>'images', 
			  'type'=>'raw', 
			  'value'=>html_entity_decode(CHtml::image($imgpath,'alt', array('height'=>'100', 'width'=>'100')))),
	),
)); ?>


