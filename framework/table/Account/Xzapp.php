<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
namespace We7\Table\Account;

class Xzapp extends \We7Table {
	protected $tableName = 'account_xzapp';
	protected $primaryKey = 'acid';
	protected $field = array(
		'acid',
		'uniacid',
		'name',
	);
	protected $default = array(
		'acid' => '',
		'uniacid' => '',
		'name' => '',
	);

	public function searchWithType($types = array()) {
		$this->query->where(array('b.type' => $types));
		return $this;
	}

	public function searchWithKeyword($title) {
		$this->query->where('a.name LIKE', "%{$title}%");
		return $this;
	}

	public function searchWithLetter($letter) {
		if (!empty($letter)) {
			$this->query->where('a.title_initial', $letter);
		} else {
			$this->query->where('a.title_initial', '');
		}
		return $this;
	}

	public function accountRankOrder() {
		$this->query->orderby('a.rank', 'desc');
		return $this;
	}

	public function searchAccountListFields($fields = 'a.uniacid',$expire = false) {
		global $_W;
		$this->query->from('uni_account', 'a')->select($fields)->leftjoin('account', 'b')
			->on(array('a.uniacid' => 'b.uniacid', 'a.default_acid' => 'b.acid'))
			->where('b.isdeleted !=', '1');

				if (!user_is_founder($_W['uid']) || user_is_vice_founder()) {
			$this->query->leftjoin('uni_account_users', 'c')->on(array('a.uniacid' => 'c.uniacid'))
				->where('a.default_acid !=', '0')->where('c.uid', $_W['uid']);
		} else {
			$this->query->where('a.default_acid !=', '0');
		}
		if (!empty($expire)) {
			$this->searchWithExprie();
		}
		$list = $this->query->getall('uniacid');
		return $list;
	}

	public function getXzappAccount($acid) {
		return $this->query->from('account_xzapp')->where('acid' , $acid)->get();
	}

	public function updateByUniacidAcid($update, $uniacid, $acid) {
		$this->query->where('uniacid', $uniacid)->where('acid', $acid);
		return $this->fill($update)->save();
	}
}