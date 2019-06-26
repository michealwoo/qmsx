<?php defined('IN_IA') or exit('Access Denied');?><form action="<?php  echo mobileUrl('goods')?>" method="post">
	<div class="fui-searchbar bar">
		<div class="searchbar center">
			<input type="submit" class="searchbar-cancel searchbtn" value="搜索" />
			<div class="search-input">
				<i class="icon icon-search"></i>
				<input type="search" placeholder="输入关键字..." class="search" name="keywords">
			</div>
		</div>
	</div>
</form>
<script>
	$(function () {
		$("input[name='keywords']").focusin(function () {
			$(this).removeAttr('placeholder');
		});
		$("input[name='keywords']").focusout(function () {
			$(this).attr('placeholder','输入关键字...');
		});
		$("form").submit(function () {
			$(this).find("input[name='keywords']").blur();
		});
	});
</script>
<!--4000097827-->