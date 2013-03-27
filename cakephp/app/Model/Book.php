<?php
class Book extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'books';
	public $validate = array(
		'lexile_level' => array(
				array('rule'=> 'numeric','message' => 'Lexile級別必須是數字'),
				array('rule'=> array('between', 0, 2000),'message' => 'Lexile級別必須介於0~2000之間')
		)	
	);
	public $hasMany = array(
		'Book_Instances' => array(
			'className' => 'Book_Instance',
			'foreignKey' => 'book_id',
		)
	);
	public $belongsTo = array(	
		'Book_Cate' => array(
			'className' => 'Book_Cate',
			'foreignKey' => 'cate_id',
		)
	);

	public function beforeSave($options = array()){
		
		if($this->data['Book']['lexile_level'] == 0){
			$this->data['Book']['cate_id'] = 0;
		} else if($this->data['Book']['lexile_level'] > 900) {
			$this->data['Book']['cate_id'] = 1000;
		} else {
			$this->data['Book']['cate_id'] = (floor(($this->data['Book']['lexile_level']-1)/100)+1)*100;
		}
		return true;
	}
}
?>