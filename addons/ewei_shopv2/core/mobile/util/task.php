<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Task_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		$this->runTasks();
	}
}

?>
