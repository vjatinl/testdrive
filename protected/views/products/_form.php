<?php
/* @var $this ProductsController */
/* @var $model Products */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'products-form',
	'enableClientValidation' => true,
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'clientOptions' => array('validateOnSubmit' => true,),

)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'Catagory : '); ?>
		<?php //echo $form->textField($model,'pcat'); ?>
		<?php echo $form->dropDownList($model,'pcat',CHtml::listData(Catagory::model()->findAll(), 'cid','cname'),array('empty'=>'Please Select')); ?>
		<?php echo $form->error($model,'pcat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Product name:'); ?>
		<?php echo $form->textField($model,'pname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'pname'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'Description : '); ?>
		<?php echo $form->textArea($model,'pdesc',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'pdesc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Price(Rs) :'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>


	<div class="row">		
		<?php echo $form->hiddenField($model,'images'); ?>		
	</div>


<?php 
$this->widget('ext.EFineUploader.EFineUploader',
 array(
       'id'=>'FineUploader',
       'config'=>array(
                       'autoUpload'=>true,
                       'request'=>array(
                          'endpoint'=>$this->createUrl('products/upload'), //OR $this->createUrl('products/upload'),
                          'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken,'pid'=>$model->pid),
                                       ),
                       'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                       'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
                       'callbacks'=>array(
                                        'onComplete'=>"js:function(id, name, response){ alert(name);  
                                            var filename = $('#Products_images').val(); 
                                            console.log(filename);
                                        	$('#Products_images').val(response.filename+','+filename);                                      	
                                         }",
                                        'onError'=>"js:function(id, name, errorReason){ }",
                                        'onValidateBatch' => "js:function(fileOrBlobData) {}", 
                                         ),
                       'validation'=>array(
                                 'allowedExtensions'=>array('jpg','jpeg'),
                                 'sizeLimit'=>2 * 1024 * 1024,//maximum file size in bytes
                                 'minSizeLimit'=>1024,// minimum file size in bytes
                                 ),
                      )
      ));

?>

<?php $this->endWidget(); ?>

</div><!-- form -->