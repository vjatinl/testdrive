<?php
/* @var $this ProductsController */
/* @var $model Products */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'products-catgroup-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pname'); ?>
		<?php echo $form->textField($model,'pname'); ?>
		<?php echo $form->error($model,'pname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pcat'); ?>
		<?php echo $form->textField($model,'pcat'); ?>
		<?php echo $form->error($model,'pcat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pdesc'); ?>
		<?php echo $form->textField($model,'pdesc'); ?>
		<?php echo $form->error($model,'pdesc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->