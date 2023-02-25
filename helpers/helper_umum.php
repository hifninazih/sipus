<?php 

function _d($str){
	echo '<pre>';
	var_dump($str);
	echo '</pre>';
}

function pagination($row, $num, $query_limit){
?>
	<ul class="table-pagination">
	<?php
		$page_num = ceil($row/$query_limit);
	
		for($i = 1; $i <= $page_num; $i++) {
	?>
			<li><a href="index.php?p=<?= $_GET['p']; ?>&num=<?php echo $i; ?>" <?php echo ($num == $i || ($num == 0 && $i == 1)) ? 'class="active"' : '' ?>><?php echo $i; ?></a></li>
	<?php
		}
	?>
</ul>
<?php
}
?>