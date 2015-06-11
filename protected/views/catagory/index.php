<?php
/* @var $this CatagoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Catagories',
);

$this->menu=array(
	array('label'=>'Create Catagory', 'url'=>array('create')),
	array('label'=>'Manage Catagory', 'url'=>array('admin')),
);
?>

<h1>Catagories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
