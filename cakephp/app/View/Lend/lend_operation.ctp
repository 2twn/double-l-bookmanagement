<script language="JavaScript">
	
	function delete_row(row_id) {
		jQuery('#'+row_id).remove();
		jQuery('#lend_cnt')[0].innerHTML = jQuery('#lend_table tr').length - 1;
		jQuery('#can_lend')[0].innerHTML = jQuery('#can_lend1')[0].innerHTML - jQuery('#lend_table tr').length + 1;
		if (jQuery('#lend_table tr').length <= 1) {
			jQuery('#SaveData').hide();
		}
		return false;
	}
	
	function search_person_id(e) {
	var key;
		if(window.event)
			key = window.event.keyCode;     //IE
		else
			key = e.which;     //firefox
		if(key != 13) {
			return false;
		}
		else {	
			jQuery('#Lend_RecordLendOperationForm')[0].submit();
			return true;
		}
	}

	function add_book(book_id, e) {
		var key;
		if(window.event)
			key = window.event.keyCode;     //IE
		else
			key = e.which;     //firefox
		if(key == 13) {
			//$.post("lend_book", { person_id: jQuery('#person_id')[0].value, book_id: book_id.value } );
			$.ajax(
				{	
					url:"lend_book", 
					data:{ person_id: jQuery('#person_id')[0].value, book_id: book_id.value, book_cnt: jQuery('#lend_table tr').length }, 
					type: "post", 
					success: function(response){
						if (response == '') {
							alert('書籍代號：' + book_id.value + '不存在');
						}
						else {
							jQuery('#lend_table').append(response);
							jQuery('#lend_cnt')[0].innerHTML = jQuery('#lend_table tr').length - 1;
							jQuery('#can_lend')[0].innerHTML = jQuery('#can_lend1')[0].innerHTML - jQuery('#lend_table tr').length + 1;
						}
						if (jQuery('#lend_table tr').length > 1) {
							jQuery('#SaveData').show();
						}
					}
				}
			);
			return false;
		}
		else {	return true;}
	}
</script>
<h1>書籍借閱作業</h1>
<?php if (!isset($person_info['Person']['id'])) { echo $this->Form->create('Lend_Record', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); }?>
<table>
	<tr>
		<table>
			<tr>
				<td>借卡號碼</td>
				<td><?php if (isset($person_info['Person']['id'])) {echo $person_info['Person']['id']; echo $this->Form->hidden('person_id', array('value' => $person_info['Person']['id']));} else {echo $this->Form->text('person_id', array('onkeypress' => 'search_person_id(event);'));}?></td>
				<td>借卡狀況</td>
				<td><?php if (isset($person_info['Person']['id'])) {echo $person_info['Person']['valid'];}?></td>
				<td>目前狀況</td>
				<td><?php if (isset($this->data['Lend_Record']['id'])) {echo $this->data['Lend_Record']['id'];}?></td>
			</tr>
			<tr>
				<td>姓名</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person']['name'];} ?></td>
				<td>群組</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Group']['group_name'];} ?></td>
				<td>電話</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person']['phone'];} ?></td>
			</tr>
			<tr>
				<td>等級權限</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['level_name'];} ?></td>
				<td>可借天數</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['max_day'];} ?></td>
				<td>可借本數</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['max_book'];} ?></td>
			</tr>
			<tr>
				<td>已借未還</td>
				<td><?php echo sizeof($lend_records); ?></td>
				<td>已逾期數</td>
				<td><?php echo sizeof($lend_records); ?></td>
				<td>可借數</td>
				<td id='can_lend1'><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['max_book'] - sizeof($lend_records); } ?></td>
			</tr>
			<tr>
				<td colspan=4>欲借出明細</td>
				<td style="text-align:right">已輸入<span id='lend_cnt'>0</span>本</td>
				<td style="text-align:right">還可借出<span id='can_lend'><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['max_book'] - sizeof($lend_records); } ?></span>本</td>
			</tr>
			<tr>
				<td>請輸入書籍代號</td><td colspan=5> <?php if (isset($person_info['Person']['id'])) { echo $this->Form->input('book', array('label' => false,'div' => false,'onkeypress' =>'add_book(this, event);')); } ?></td>
			</tr>
			<tr>
				<td colspan=6>
					<?php if (isset($person_info['Person']['id'])) { echo $this->Form->create('Lend_Record', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); }?>
					<?php if (isset($person_info['Person']['id'])) { echo $this->Form->hidden('person_id', array('value'=>$person_info['Person']['id'])); }?>
					<table id='lend_table'>
						<tr>
							<th>書籍編號</th>
							<th>書籍名稱</th>
							<th>附屬媒體</th>
							<th>應還日期</th>
							<th>借閱等級</th>
							<th>狀態</th>
							<th><?php echo $this->Form->submit('儲存', array('style'=>'display:none', 'id' => 'SaveData')); ?></th>
						</tr>
					</table>
					<?php if (isset($person_info['Person']['id'])) { echo $this->Form->end(); }?>
				</td>
			</tr>
			<tr>
				<td colspan=5>借出尚未歸還明細</td><td style="text-align:right">共<?php echo sizeof($lend_records);?>本</td>
			</tr>
			<tr>
				<td colspan=6>
					<table>
						<tr>
							<th>出借日期</th>
							<th>應還日期</th>
							<th>書籍編號</th>
							<th>書籍名稱</th>
							<th>附屬媒體</th>
							<th>狀態</th>
							<th>續借次數</th>
						</tr>
						<?php foreach ($lend_records as $lend_record): ?>
						<tr>
							<td><?php echo $lend_record['Lead_Record']['lead_date']; ?></td>
							<td><?php echo $lend_record[0]['s_return_date']; ?></td>
							<td><?php echo $lend_record['Book']['id']; ?></td>
							<td><?php echo $lend_record['Book']['book_name']; ?></td>
							<td><?php echo $lend_record['Person']['name']; ?></td>
							<td><?php echo $lend_record['Lead_Record']['status']; ?></td>
							<td><?php echo $lend_record['Lead_Record']['lead_cnt']; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
		</table>
	</tr>
</table>
<?php if (!isset($person_info['Person']['id'])) { echo $this->Form->end(); }?>
