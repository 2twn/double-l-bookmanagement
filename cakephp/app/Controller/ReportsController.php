<?php //中文
class ReportsController extends AppController {
	public $uses = array('Lend_Record', 'Book_Instance', 'System_Location', 'Book_Cate');
    public $helpers = array('Html', 'Form', 'Session', 'Paginator');
    public $components = array('Session', 'Formfunc', 'Lendfunc');

	public $paginate = array(
        'Lend_Record' => array(	'limit' => 10,
								'order' => array('Lend_Record.id' => 'desc')
		)
    );
	
    public function user_person_status(){
		$person_id = $this->Session->read('user_id');
		if ($this->Session->read('user_role') !== 'user') {
			if (isset($this->data['Lend_Record']['person_id'])) {
				$person_id = $this->data['Lend_Record']['person_id'];
			}
			else {
				$person_id = $this->Session->read('user_person_status');
			}
			$this->set('person_id', $person_id);
		}
		$this->Session->write('user_person_status',$person_id);
		$lend_records = $this->paginate('Lend_Record', array('person_id'=>$person_id));
		$this->Person->id = $person_id;
		$person_info = $this->Person->read();
		$o_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_id, 'return_time' => null, 'status in ("C", "E")') ));
		$o_over_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_id, 'return_time' => null, 'Book_Instance.s_return_date < current_timestamp', 'status in ("C", "E")') ));
		$this->set('person_info', $person_info);
		$this->set('lend_status', $this->Lendfunc->lend_status());
		$this->set('o_lend_records', $o_lend_records);
		$this->set('o_over_lend_records', $o_over_lend_records); 		
    	$this->set('lend_records', $lend_records);
    }    

    public function book_inv_check(){
		$books = array();
		$location_id = '';
		if (!empty($this->data) && $this->Session->read('user_role') !== 'user') {
			// 判斷 $locatio_id, 如果是 localadmin, 直接設定為指定 $location_id
			if ($this->Session->read('user_role') === 'localadmin') {
				$location_id = $this->Session->read('user_location');
			} else {
				$location_id = $this->data['Book_Instance']['location_id'];
			}			
			//$location_id = $this->data['Book_Instance']['location_id'];
			//if ($this->Session->read('user_role') !== 'user') {
			//	if ($this->Session->read('user_role') === 'localadmin') {
			//		$location_id = $this->Session->read('user_location');
			//	}
			
			// 只有當盤點時,才會產生report
			if(Cache::read($location_id.'_take_stock')){
				$option['joins'] = array(
					array('table' => 'system_take_stocks',
						'alias' => 'System_Take_Stock',
						'type' => 'LEFT',
						'conditions' => array(
							'System_Take_Stock.book_instance_id = Book_Instance.id',
							'System_Take_Stock.version'=> Cache::read($location_id.'_take_stock_version') 
						)
					)	
				);
				$option['conditions'] = array(
					'Book_Instance.book_status in (1,4)',
					'Book_Instance.location_id' => $location_id
				);
				$option['fields'] = array(
						'System_Take_Stock.*',
						'Book_Instance.*',
						'Book.*',
						'System_Location.*',
						'Book_Status.*'
					);
				//$books = $this->Book_Instance->find('all',array('conditions' => array('book_status in (1,4)','location_id' => $location_id)));
				$books = $this->Book_Instance->find('all',$option);
			}
		}
		$options = array(
			'condiftions'=>array('valid' => 1),
			'fields'=>array('id', 'location_name'),
			'order' => array('id'),
		);
		//$this->set('locations', $this->System_Location->find('list',array('condiftions'=>array('valid' => 1), 'fields'=>array('id', 'location_name'))));
    	$this->set('locations', $this->System_Location->find('list',$options));
		$this->set('books', $books);
    }   

	public function book_cate_stats() {
		$books_sort = 0;
		$books_sorts = array(0 => 'isbn');
		$page_size = 20;
		$page = 1;
		$filter_str = '';
		$this->Person->Id = $this->Session->read('user_id');
		$person_info = $this->Person->read();
		if ((isset($this->data['Book']['page'])) && (trim($this->data['Book']['page']) != ''))  {
			$page = trim($this->data['Book']['page']);
		}
		if ((isset($this->data['Book']['sort'])) && (trim($this->data['Book']['sort']) != ''))  {
			$books_sort = trim($this->data['Book']['sort']);
		}
		if ((isset($this->data['Book']['cate'])) && (trim($this->data['Book']['cate']) != ''))  {
			$filter_str = $filter_str." and cate_id = '".mysql_real_escape_string($this->data['Book']['cate'])."' ";
		}
		if ((isset($this->data['Book']['start_date'])) && (trim($this->data['Book']['start_date']) != ''))  {
			$filter_str = $filter_str." and substring(lend_time,1,10) >= '".mysql_real_escape_string($this->data['Book']['start_date'])."' ";
		}
		if ((isset($this->data['Book']['end_date'])) && (trim($this->data['Book']['end_date']) != ''))  {
			$filter_str = $filter_str." and lend_time <= '".mysql_real_escape_string($this->data['Book']['end_date'])."' ";
		}
		if (trim($filter_str) == '') {
			if ($filter_str = '') {  $filter_str = $filter_str." and "; };
			$filter_str = " and  1=2 ";
		}
		$strsql = " FROM `lend_records`, books, system_locations 
				   WHERE status <> 'L' 
					 and status<>'R' 
					 and status <> 'S' 
					 and books.id = lend_records.book_id 
					 and location_id = system_locations.id ";
		if (trim($filter_str) != '') {
			$strsql = $strsql.$filter_str;
		}
		$strsql1 = "SELECT count( * ) AS cnt from ( select count( * ) ";
		$strsql_group = " GROUP BY books.id, `book_type` , `book_name` , `book_author` , `book_publisher` , `cate_id` , `isbn` , `book_search_code` , `book_location` , `book_attachment` , `book_image` , `publish_date` , `order_start_date` , `order_end_date` , `order_start_version` , `order_end_version` , `memo`, books.book_version, location_id, location_name ";
		$books_cnt = $this->Lend_Record->query($strsql1.$strsql.$strsql_group.') as x;');
		$strsql1 = "SELECT books.id,  `book_name` , `book_author` , `book_publisher` , `cate_id` , `isbn` , `book_search_code` , `book_location` , `book_attachment` , `book_image` , `publish_date` , `order_start_date` , `order_end_date` , `order_start_version` , `order_end_version` , `memo` , count( * ) AS cnt, books.book_version, location_id, location_name  ";
		$strsql = $strsql1.$strsql.$strsql_group." LIMIT ".($page-1)*$page_size." , ".$page_size.";";
		$books = $this->Lend_Record->query($strsql);
		$this->set('page', $page);
		$this->set('books', $books);
		$this->set('books_sort', $books_sort);
		$this->set('books_cnt', $books_cnt[0][0]['cnt']);
		$this->set('books_page', floor($books_cnt[0][0]['cnt'] / $page_size) + 1);
		$this->set('cates', $this->Book_Cate->find('list', array('fields'=>array('id', 'catagory_name'))));
	} 	

}
?>