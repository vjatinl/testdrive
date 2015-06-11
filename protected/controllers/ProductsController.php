<?php

class ProductsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', ),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'upload'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'upload', 'catgroup'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Products;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Products']))
		{
			$model->attributes=$_POST['Products'];			
			if($model->save()){
									
				// Image Handling 
				$imgs = explode(",",$_POST['Products']['images']);					
				foreach($imgs as $img)
				{				   	
				   if(empty($img))
				   {
				   	continue;
				   }
				   $src_path = Yii::getPathOfAlias('webroot')."/upload/images/temp/".$img;
				   $dest_path = Yii::getPathOfAlias('webroot')."/upload/images/".$model->pid;
				   if(!file_exists($dest_path) && !is_dir($dest_path)) 
						mkdir($dest_path, 0777, TRUE);
					$dest_path.="/".$img;
					echo $dest_path;
					
				   rename($src_path, $dest_path);
				  
				}
				//DATABASE OPERATION
				
				
				$model->updateImage($_POST['Products']['images'], $model->pid);
				$this->redirect(array('view','id'=>$model->pid));
				}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Products']))
		{
			$model->attributes=$_POST['Products'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->pid));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		//print_r(Yii::getPathOfAlias('webroot'));
		
		$dataProvider=new CActiveDataProvider('Products', 
			array('criteria'=>array('order'=>'pid DESC')));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,			
		));
		
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		/*
		$criteria = new CDbCriteria;
		// bro-tip: $_REQUEST is like $_GET and $_POST combined
		if (isset($_REQUEST['sSearch']) && isset($_REQUEST['sSearch']{0})) {
		    // use operator ILIKE if using PostgreSQL to get case insensitive search
		    $criteria->addSearchCondition('textColumn', $_REQUEST['sSearch'], true, 'AND', 'ILIKE');
		}
		$sortableColumnNamesArray = array('pid','pname');
		$sort = new EDTSort('products', $sortableColumnNamesArray);
		$sort->defaultOrder = 'pid';
		$pagination = new EDTPagination();
		 
		$dataProvider = new CActiveDataProvider('products', array(
		    'criteria'      => $criteria,
		    'pagination'    => $pagination,
		    'sort'          => $sort,
		));
		
		$columns = array('pid', 'pname', 'pcat');
		$this->widget=$this->createWidget('ext.EDataTables.EDataTables', array(
		 'id'            => 'products',
		 'dataProvider'  => $dataProvider,
		 'ajaxUrl'       => $this->createUrl('/products/index'),
		 'columns'       => $columns,
		));
		if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
		  $this->render('index', array('widget' => $widget,));
		  return;
		} else {
		  echo json_encode($widget->getFormattedData(intval($_REQUEST['sEcho'])));
		  Yii::app()->end();
		}*/
		
		$model=new Products('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Products']))
			$model->attributes=$_GET['Products'];

		$this->render('admin',array(
			'model'=>$model,
		));
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Products the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Products::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Products $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='products-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionUpload()
    {    		
            $tempFolder=Yii::getPathOfAlias('webroot').'/upload/images/';
            if(isset($_REQUEST['pid']) && is_numeric($_REQUEST['pid']))
            {
				$tempFolder.=$_REQUEST['pid'].'/';
			}
			else{				
				$tempFolder.='temp/';
			}
			if(!file_exists($tempFolder) && !is_dir($tempFolder)) 
				mkdir($tempFolder, 0777, TRUE);
			if(!file_exists($tempFolder.'/chunks') && !is_dir($tempFolder.'/chunks')) 
				mkdir($tempFolder.'/chunks', 0777, TRUE);            
			
	
            Yii::import("ext.EFineUploader.qqFileUploader");

            $uploader = new qqFileUploader();
            $uploader->allowedExtensions = array('jpg','jpeg');
            $uploader->sizeLimit = 2 * 1024 * 1024;//maximum file size in bytes
            $uploader->chunksFolder = $tempFolder.'chunks';

            $result = $uploader->handleUpload($tempFolder);
            $result['filename'] = $uploader->getUploadName();
            //$result['folder'] = $webFolder;

            $uploadedFile=$tempFolder.$result['filename'];
            
            
            // DATABASE OPERATION
            if(isset($_REQUEST['pid'])&& is_numeric($_REQUEST['pid'])){
						
            $model = new Products();          	
          	$model->updateImage($result['filename'], $_REQUEST['pid']);
          	          	
          	
          	}
          	// DATABASE OPERATION
          	
          	
            header("Content-Type: text/plain");
            $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $result;
                                 
                    
            Yii::app()->end();
    }
    
    public function actionCatgroup()
	{
	    $model=new Products;
	
	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='products-catgroup-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    */

	    if(isset($_POST['Products']))
	    {
	    	print_r($_POST);
	        $model->attributes=$_POST['Products'];
	        if($model->validate())
	        {
	            // form inputs are valid, do something here
	            return;
	        }
	    }
	    $this->render('catgroup',array('model'=>$model));
	}
    
}
