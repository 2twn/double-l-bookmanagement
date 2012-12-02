<?php
/**中文*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php //echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('application');
		echo $this->Html->css('redmond/jquery-ui-1.9.1.custom.css');
        echo $this->Html->script('jquery-1.8.2.js');
        echo $this->Html->script('jquery-ui-1.9.1.custom.js');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
<script type="text/javascript">
	$(function(){
		// 幫 #menu li 加上 hover 事件
		$('#menu>li').hover(function(){
			// 先找到 li 中的子選單
			var _this = $(this),
				_subnav = _this.children('ul');
			
			// 變更目前母選項的背景顏色
			// 同時顯示子選單(如果有的話)
			_this.css('backgroundColor', '#06c').siblings().css('backgroundColor', '');
			_subnav.css('display', 'block');
		} , function(){
			// 同時隱藏子選單(如果有的話)
			// 也可以把整句拆成上面的寫法
			$(this).children('ul').css('display', 'none');
		});
		
		// 取消超連結的虛線框
		$('a').focus(function(){
			this.blur();
		});
	});
</script>

</head>
<body>
	<div id="container">
		<div id="header">
			<div style="float:left;"><h1>哥大圖書</h1></div>
			<div id="menu_div" style="float:left;">
				<?php 
					if($this->Session->read('user_role'))
						echo $this->element('menu_'.$this->Session->read('user_role'));
				?>
			</div>			
			<div id="account">
			<?php
				if($this->Session->read('isLogin')){
					echo '<li>';
					echo $this->Session->read('user_name');
					echo '</li>';
					echo '<li>';
					echo $this->Html->link(
    					'logout',
    					array('controller' => 'users', 'action' => 'logout'),
  						array(),
    					"Are you sure you wish to logout?"
					);
					echo '</li>';
				}
			?>
			</div>		
			
				

		</div>

