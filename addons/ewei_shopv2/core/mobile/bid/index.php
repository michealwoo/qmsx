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

        $supplier = pdo_get('supplier', array('openid'=>$_W['openid'],'is_dps'=>1), array());

        if(empty($supplier)){
            $this->message("抱歉,您还没有成为供货商,您可以留言申请",mobileUrl("bid/message"), "error");
            exit();
        }

        //status=1 and total>0 and deleted=0  上架的未删除的 库存大于0的
        $goods_list = pdo_fetchall('SELECT id,title,marketprice FROM ' . tablename('ewei_shop_goods') . ' where status=1 and total>0 and deleted=0 order by createtime DESC',array());
     
        include $this->template('bid/search');
    }
    //留言
    public function message()
    {
        global $_W;
        global $_GPC;
        //print_r($_GPC);exit;
        if( $_W['ispost'] )
        {
            if( empty($_GPC['company']) ) 
            {
                $this->message("请填写公司名称","", "error");
            }

            if( empty($_GPC['name']) ) 
            {
                $this->message("请填写名字","", "error");
            }

            if( empty($_GPC['phone']) ) 
            {
                $this->message("请填写手机号码","", "error");
            }
            //print_r($_GPC);exit;
            pdo_insert('bid_apply',array(
                'company'=>$_GPC['company'],
                'name'=>$_GPC['name'],
                'phone'=>$_GPC['phone'],
                'telephone'=>$_GPC['telephone'],
                'msg'=>$_GPC['msg'],
                'createtime'=>time()
                )
            );

            // show_json(1,'留言成功,我们将尽快联系您');
            //$this->message("留言成功,我们将尽快联系您",mobileUrl("bid/message"));
        }
        include $this->template('bid/message');
    }

    //供货商竞价商品列表
    public function goodslist()
    {
        global $_W;
        global $_GPC;

        if(!empty($_GPC['id']))
        {
            $goods = pdo_get('bid_goodslist',array('goodsid'=>$_GPC['id'],'openid'=>$_W['openid']),array('id'));

            if(empty($goods))
            {
                $data = array(
                    'supplierid'=>pdo_get('supplier',array('openid'=>$_W['openid']),array('id'))['id'],
                    'openid'=>$_W['openid'],
                    'goodsid'=>$_GPC['id'],
                    'createtime'=>time()
                    );
                pdo_insert('bid_goodslist',$data);
                $id = pdo_insertid();
            }
        }
        
        $goods_list = pdo_fetchall('SELECT id,goodsid,supplierid FROM '.tablename('bid_goodslist').' WHERE openid=:openid',array('openid'=>$_W['openid']));
        
        foreach ($goods_list as &$val) 
        {  
            //已上架的商品
            $val['title'] = pdo_get('ewei_shop_goods',array('id'=>$val['goodsid']),array('title'))['title'];
        }
  
        include $this->template('bid/goodslist');
    }
    //竞价供货商商品列表删除
    public function goods_del()
    {
        global $_W;
        global $_GPC;
        $id = $_GPC['id'];
        $openid = $_W['openid'];
 
        $list = pdo_get('bid_goodslist',array('id'=>$_GPC['id'],'openid'=>$_W['openid']),array('id'));
        
        if(empty($list))
        {
            $result = pdo_delete('bid_goodslist',array('id'=>$_GPC['id'],'openid'=>$_W['openid']));
            if (!empty($result)) {
                header("location: " . mobileUrl("bid"));
                exit();
            }
        }
    }

    //供货商报价
    public function list()
    {
        global $_W;
        global $_GPC;

        $ids_str = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;

        $goods_list = pdo_fetchall('SELECT id,title,marketprice FROM '.tablename('ewei_shop_goods').' WHERE id in( ' . $ids_str . ' )');

        include $this->template('bid/submit');
    }

    // //供货商竞价
    public function subbid()
    {
        global $_W;
        global $_GPC;

        if( $_W['ispost'] )
        {
            // if(empty($_GPC['goodsid']))
            // {
            //     $this->message("请先选择商品","", "error");
            // }

            $data = array();
            $data['supplierid'] = pdo_get('supplier',array('openid'=>$_W['openid']),array('id'))['id'];
            $data['openid'] = $_W['openid'];
            $data['createtime'] = time();
            $data['verify'] = 0;

            foreach ($_GPC['goodsid'] as $key => $val)
            {
                $data['goodsid'] = $val;
                $data['marketprice'] = pdo_get('ewei_shop_goods',array('id'=>$val),array('marketprice'))['marketprice'];
                $data['bidprice'] = $_GPC['bidprice'][$key];

                $offset = bcsub(floatval($data['bidprice']),floatval($data['marketprice']),3);
                
                if($offset>0)
                {
                    $data['change'] = "<i style='color:red;'>".sprintf("%.2f",$offset)."&nbsp;&#8593;</i>";
                }elseif ($offset==0) {
                    $data['change'] ="<i style='color:gray;'>持平</i>";
                }else{
                    $data['change'] = "<i style='color:green;'>".sprintf("%.2f",$offset)."&nbsp;&#8595;</i>";
                }

                $data['desc'] = $_GPC['desc'][$key];
                pdo_insert('bid',$data);
            }
            header("location: " . mobileUrl("bid"));
            exit();
           
        }
        include $this->template('bid/search');
    }
    
}

?>
