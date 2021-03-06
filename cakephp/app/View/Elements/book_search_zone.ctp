<table>
	<tr>
        <td>
		<?php echo $this->Form->create('Book',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
			<table>
				<tr>
					<td style="width:100px">閱讀等級</td>
					<td><?php echo $this->Form->select('cate_id', $cates);?></td>
					<td style="width:100px">書籍編號</td>
					<td><?php echo $this->Form->input('book_instance_id',array('type'=> 'text'));?></td>					
				</tr>
				<tr>
					<td style="width:100px" >書籍名稱</td>
					<td colspan=3><?php echo $this->Form->input('book_name', array('size'=>80));?></td>
				</tr>
				<tr>
					<td style="width:100px" >叢集名</td>
					<td colspan=3><?php echo $this->Form->input('book_suite', array('size'=>80));?></td>
				</tr>				
				<tr>
					<td style="width:100px">ISBN</td>
					<td colspan=3><?php echo $this->Form->input('isbn', array('size'=>20));?></td>
				</tr>
				<tr>
					<td style="width:100px">出版社</td>
					<td><?php echo $this->Form->input('book_publisher');?></td>
					<td style="width:100px">作者</td>
					<td><?php echo $this->Form->input('book_author');?></td>
				</tr>
				<tr>
					<td style="width:100px">親子共讀</td>
					<td colspan=3><?php echo $this->Form->checkbox('book_ad', array('hiddenField' => false)); ?></td>
				</tr>					
				<tr>
					<td colspan=4>
					<?php echo $this->Form->hidden('books_sort', array('value'=>$books_sort));?>
					<?php echo $this->Form->hidden('page', array('value'=>1));?>
					<?php echo $this->Form->hidden('page_change', array('value'=>0));?>
					<?php echo $this->Form->submit('搜尋', array('div'=>false));?>
					</td>
				</tr>			
			</table>
		<?php echo $this->Form->end(); ?>
		</td>
	</tr>
</table>
