<script>
	function printDiv(divName) {
		 var printContents = document.getElementById(divName).innerHTML;
		 var originalContents = document.body.innerHTML;
		 document.body.innerHTML = printContents;
		 window.print();
		 document.body.innerHTML = originalContents;
	}
</script>
<h1>書籍盤點清冊</h1>
<?php echo $this->html->link('列印清冊',"javascript:printDiv('print_div');");?>
<?php  if($this->Session->read('user_role') !== 'user')  { echo $this->Form->create('Book_Instance', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); }?>
	<table>
		<tr>
			<td>借卡號碼
			<?php if ($this->Session->read('user_role') === 'admin') : ?>
				<?php echo $this->Form->select('location_id', $locations, array('empty' => false));?>
			<?php elseif ($this->Session->read('user_role') === 'localadmin'): ?>
				<?php echo $this->Form->text('location_id', array('value' => $this->Session->read('user_location'), 'readonly' => true));?>
			<?php endif;?>
			<?php echo $this->Form->submit('選取', array('div'=>false)); ?>
		</tr>
		<tr>
			<td colspan=3>
				<div id='print_div' align="center" cellspacing=0 cellpadding=0>
				<table>
					<tr>
						<th>書籍編號</th>
						<th>書籍名稱</th>
						<th>ISBN</th>
						<th>版本</th>
						<th>附屬媒體</th>
						<th>作者/編者</th>
						<th>出版廠商</th>
						<th>尋書碼</th>
						<th>位置</th>
						<th>購買日期</th>
						<th>地點</th>
						<th>狀態</th>
					</tr>
					<?php foreach ($books as $book): ?>
					<tr>
						<td><?php echo $book['Book_Instance']['id']; ?></td>
						<td style="width:300px;word-wrap:break-word;word-break:break-all;"><?php echo $book['Book']['book_name']; ?></td>
						<td><?php echo $book['Book']['isbn']; ?></td>
						<td><?php echo $book['Book']['book_version']; ?></td>
						<td><?php echo $book['Book']['book_attachment']; ?></td>
						<td><?php echo $book['Book']['book_author']; ?></td>
						<td><?php echo $book['Book']['book_publisher']; ?></td>
						<td><?php echo $book['Book']['book_search_code']; ?></td>
						<td><?php echo $book['Book']['book_location']; ?></td>
						<td><?php echo $book['Book_Instance']['purchase_date']; ?></td>
						<td><?php echo $book['System_Location']['location_name']; ?></td>
						<td><?php echo $book['Book_Status']['status_name']; ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
				</div>
			</td>
		</tr>
	</table>
<?php  if($this->Session->read('user_role') !== 'user')  { echo $this->Form->end(); }?>