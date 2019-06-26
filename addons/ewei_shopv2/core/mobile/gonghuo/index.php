<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends MobilePage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        
        if(empty($_W['openid']))
        {
            $this->message("请先关注公众号","", "error");
        }
        
        $supplier = pdo_get('supplier', array('openid' => $_W['openid']), array());
        
        if(empty($supplier))
        {
            $this->message("抱歉,您还没有成为供货商","", "error");
        }
 
        //status=1 and total>0 and deleted=0 
        $goods_list = pdo_fetchall('SELECT id,title,marketprice FROM ' . tablename('ewei_shop_goods') . ' WHERE supplier_id=:supplier_id order by createtime DESC',array('supplier_id'=>$supplier['id']));
     
        include $this->template('gonghuo/list');
    }
    //供货商报价
    public function quote()
    {
        global $_W;
        global $_GPC;

        if(empty($_GPC['ids']))
        {
            $this->message("请先选择商品","", "error");
        }

        $ids_str = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;

        $goods_list = pdo_fetchall('SELECT id,title,marketprice FROM '.tablename('ewei_shop_goods').' WHERE id in( ' . $ids_str . ' )');
        
        include $this->template('gonghuo/submit');
    }
    //提交报价
    public function subquote()
    {
        global $_W;
        global $_GPC;

        if( $_W['ispost'] )
        {

            if(empty($_GPC['goodsid']))
            {
                $this->message("请先选择商品","", "error");
            }

            $data = array();
            $data['supplierid'] = pdo_get('supplier',array('openid'=>$_W['openid']),array('id'))['id'];
            $data['openid'] = $_W['openid'];
            $data['createtime'] = time();
            $data['verify'] = 0;

            foreach ($_GPC['goodsid'] as $key => $val)
            {
                $data['goodsid'] = $val;
                $data['marketprice'] = pdo_get('ewei_shop_goods',array('id'=>$val),array('marketprice'))['marketprice'];
                $data['quotedprice'] = $_GPC['quotedprice'][$key];
                $offset = bcsub(floatval($data['quotedprice']),floatval($data['marketprice']),3);
                
                if($offset>0){
                    $data['change'] = "<i style='color:red;'>".sprintf("%.2f",$offset)."&nbsp;&#8593;</i>";
                }elseif ($offset==0) {
                    $data['change']="<i style='color:gray;'>持平</i>";
                }else{
                    $data['change'] = "<i style='color:green;'>".sprintf("%.2f",$offset)."&nbsp;&#8595;</i>";
                }

                $data['desc'] = $_GPC['desc'][$key];
                pdo_insert('quote',$data);
            }

            // //$this->message("报价成功");
            header("location: " . mobileUrl("gonghuo"));
            exit();
          
            //$this->message("报价成功",mobileUrl('gonghuo/subquote'));
         }
        //include $this->template('gonghuo/list');
    }
    //供货商查询配货详情
    public function supplier_dist()
    { 
       global $_W;
       global $_GPC;

       if(empty($_W['openid']))
       {
          $this->message("请先关注公众号","", "error");
       }

       $supplier = pdo_get('supplier', array('openid' => $_W['openid']), array());
    
       if(empty($supplier))
       {
          $this->message("抱歉,您还没有成为供货商","", "error");
       }

       $info = pdo_get('supplier_distribution', array('id' => $_GPC['id']), array());

       if(empty($info))
       {
          $this->message("没有配货单","", "error");
       }
       
       include $this->template();
    }
}

?>
