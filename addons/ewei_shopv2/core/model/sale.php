<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Sale_EweiShopV2Model 
{
	public function getFullBackText($echo = false) 
	{
		$text = '全返';
		$set = m('common')->getSysset('fullback');
		if (!(empty($set['text']))) 
		{
			$text = $set['text'];
		}
		if ($echo) 
		{
			echo $text;
			return;
		}
		return $text;
	}
	public function parseInvoiceInfo($invoice_name) 
	{
		$invoice_name = (string) $invoice_name;
		$invoice_arr = array('entity' => false, 'company' => false, 'title' => false, 'number' => false);
		$invoice_name = str_replace(array('[', ']', '（', '）', ':'), '', $invoice_name);
		$invoice_info = explode(' ', $invoice_name);
		if (!(empty($invoice_info)) && (($invoice_info[0] === '电子') || ($invoice_info[0] === '纸质'))) 
		{
			$invoice_arr['entity'] = (($invoice_info[0] === '电子' ? false : true));
			$invoice_arr['title'] = $invoice_info[1];
			$invoice_arr['company'] = (($invoice_info[2] === '个人' ? false : true));
			$invoice_arr['number'] = (($invoice_info[3] ? $invoice_info[3] : false));
		}
		return $invoice_arr;
	}
}
?>