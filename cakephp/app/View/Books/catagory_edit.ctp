<div class="pageheader_div"><h1 id="pageheader">修改書籍級別</h1></div>
<div class="pagemenu_div"><?php 
	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
?></div>
<?php
    echo $this->Form->create('Book_Cate');
	if ($this->request->data["Book_Cate"]["id"] == null) {
		echo $this->Form->input('id', array('type'=> 'text','label'=>'級別代號'));
	}
	else {
		echo $this->Form->input('id', array('type'=> 'text','label'=>'級別代號(不可變更)', 'readonly'=>true));
	}
    echo $this->Form->input('catagory_name', array('label'=>'級別名稱'));
    echo $this->Form->input('catagory_color', array('label'=>'顏色(格式:#FF2288)'));
    echo $this->Form->end('儲存');
?>