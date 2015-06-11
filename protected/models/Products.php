<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property integer $pid
 * @property string $pname
 * @property integer $pcat
 * @property string $pdesc
 * @property integer $price
 */
class Products extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pname, pcat, pdesc, price', 'required'),
			array('pcat, price', 'numerical', 'integerOnly'=>true),
			array('pname', 'length', 'max'=>50),
			array('pname','is_product_unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pid, pname, pcat, pdesc, price', 'safe', 'on'=>'search'),
		);
	}
	
	public function is_product_unique($attribute, $params)
	{
		
		if(isset($this->pid))
		{					
			if($user = $this->exists('pname=:pname and pcat=:pcat and pid!=:pid',array(':pname'=>$this->pname, ':pcat'=>$this->pcat, ':pid'=>$this->id)))
	          $this->addError($attribute, 'product '. $this->pname .' already exists in catagory '. $this->catagory->cname .' !');			}
	    else{
			if($user = $this->exists('pname=:pname and pcat=:pcat',array(':pname'=>$this->pname, ':pcat'=>$this->pcat)))
	          $this->addError($attribute, 'product '. $this->pname .' already exists in catagory '. $this->catagory->cname .' !');
			
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'catagory'=>array(self::BELONGS_TO, 'Catagory', 'pcat'),
			//'price'=>array(self::BELONGS_TO, 'price', 'pprice')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pid' => 'Id',
			'pname' => 'Product Name',
			'pcat' => 'Catagory',
			'pdesc' => 'Details',
			'price' => 'Price',
			'images' => 'Photos'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('pid',$this->pid);
		$criteria->compare('pname',$this->pname,true);
		//$criteria->compare('pcat',$this->pcat);
		
		$criteria->compare('pcat',$this->pcat,true);
		$criteria->compare('pdesc',$this->pdesc,true);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

		
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Products the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function updateImage($imgname, $id=3)
	{
	
	    $command = Yii::app()->db->createCommand();	
	    $row = $command->select('*')->from('products')->where('pid=:id', array(':id'=>$id))->queryRow();
	    $imgname = trim($imgname, ',');
	    if(!empty($row['images']))
	    {
			$imgname = $imgname.",".$row['images'];			
		}		
		$command->update('products', array('images'=>$imgname), 'pid=:id', array(':id'=>$id));
		
	}
	

}
