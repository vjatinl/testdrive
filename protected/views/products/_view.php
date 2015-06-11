<?php
/* @var $this ProductsController */
/* @var $data Products */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('#id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pid), array('view', 'id'=>$data->pid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Product')); ?>:</b>
	<?php echo CHtml::encode($data->pname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Catagory')); ?>:</b>
	<?php //echo CHtml::encode($data->pcat); ?>
	<?php echo CHtml::encode($data->catagory->cname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Details')); ?>:</b>
	<?php echo CHtml::encode($data->pdesc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Images')); ?>:</b><br/>
	<?php
		if(empty($data->images))
		{
			echo '<i>NO IMAGE</i>';
		}
	
		$arr = explode(",",$data->images);	
				
		
		if(count($arr)>=1)
		{					
			foreach($arr as $img) {		
			 echo CHtml::Image(Yii::app()->baseUrl."/upload/images/".$data->pid."/".$img, "", array('width'=>100, 'height'=>100)); 
			}
		}
	?>
	<br />
	
</div>