<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
load()->func('communication');
load()->model('cloud');
load()->func('file');
load()->func('az');

	global $_W,$_GPC;  
    if ($_GPC['op'] == 'yun') {
	$op = $_GPC['op'];
	$ver = $_GPC['dataurl'];
	$ver = base64_decode($ver); 
	$ver = $ver - 0.1;
	$hosturl = $_SERVER['HTTP_HOST'];
	$updatehost = 'http://cloud.zhangshuoyin.cn/update.php';
    $lastver = file_get_contents($updatehost . '?a=check&v='.$ver);
	$updatehosturl = $updatehost . '?a=update&v=' . $ver . '&u=' . $hosturl;
	$updatenowinfo = file_get_contents($updatehosturl);

        //$vern = $ver+0.1;
      	$prturl = $updatehost . '?a=pra&v=' . $ver. '&u=' . $hosturl;
		$pr = file_get_contents($prturl);
      	$prcl = explode('<br>',$pr);
        $packet['files'] = $prcl;
        $packet['type'] = '';  

		if (strstr($updatenowinfo, 'zip')){			
				$pathurl = $updatehost . '?a=down&f=' . $updatenowinfo. '&u=' . $hosturl;
				$updatedir = IA_ROOT.'/data/update';
				if(!is_dir($updatedir)) {
					mkdirs($updatedir);
				}	

				$isgot = get_file($pathurl, $updatenowinfo, $updatedir);
				
				if($isgot){				
					$updatezip = $updatedir . '/' . $updatenowinfo;
					require_once IA_ROOT.'/framework/library/phpexcel/PHPExcel/Shared/PCLZip/pclzip.lib.php';
					$thisfolder = new PclZip($updatezip);
					$isextract = $thisfolder->extract(PCLZIP_OPT_PATH, $updatedir);
					if ($isextract == 0) {  
						itoast('解压更新包失败！',referer(),'error'); 
					} 
					$archive = new PclZip($updatezip);
					$list = $archive->extract(PCLZIP_OPT_PATH, IA_ROOT, PCLZIP_OPT_REPLACE_NEWER); 
					
					if ($list == 0) {  
						itoast('远程更新文件不存在或站点没有读写权限,升级失败！',referer(),'error'); 
					} 
					
					if(file_exists($updatedir . '/update.sql')) {						
						$sqlfile = $updatedir . '/update.sql';

						runquery($sqlfile);               
					}
					                                  
					$newver = "<?php return array ('ver' => '$lastver');?>";
					$f = fopen(IA_ROOT.'/web/key.php','w+');
					fwrite($f,$newver);
					fclose($f);
					@unlink(IA_ROOT . '/update.sql');                  
					deldir($updatedir);
				}
				else{
					itoast('查找不到更新包！',referer(),'error');
				}
		}
		else {
		itoast('您还不是魔方社区会员或获取授权失败，请联系QQ84204332处理！', url('system/module/not_installed'), 'error');
	}
		
    }
template('cloud/az');
