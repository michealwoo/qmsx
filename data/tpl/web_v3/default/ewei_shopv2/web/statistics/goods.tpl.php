<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header"> 当前位置：<span class="text-primary">商品销售明细</span> </div>

     <div class="page-content">

         <form action="./index.php" method="get" class="form-horizontal">

             <input type="hidden" name="c" value="site" />

             <input type="hidden" name="a" value="entry" />

             <input type="hidden" name="m" value="ewei_shopv2" />

             <input type="hidden" name="do" value="web" />

             <input type="hidden" name="r"  value="statistics.goods" />

             <div class="page-toolbar m-b-sm m-t-sm">

                 <div class="col-sm-5">

                     <?php  echo tpl_daterange('datetime', array('sm'=>true,'placeholder'=>'下单时间'),true);?>

                 </div>

                 <div class="col-sm-6 pull-right">

                     <div class="input-group">

                         <div class="input-group-select">

                             <select name='orderby'  class='form-control  '   style="width:120px;"  >

                                 <option value='' <?php  if($_GPC['orderby']=='') { ?>selected<?php  } ?>>排序</option>

                                 <option value='0' <?php  if($_GPC['orderby']=='0') { ?>selected<?php  } ?>>按销售额</option>

                                 <option value='1' <?php  if($_GPC['orderby']=='1') { ?>selected<?php  } ?>>按销售量</option>

                             </select>

                         </div>

                         <input type="text" class="form-control"  name="title" value="<?php  echo $_GPC['title'];?>" placeholder="商品名称"/>

				<span class="input-group-btn">

					<button class="btn btn-primary" type="submit"> 搜索</button>

                    <?php if(cv('statistics.goods.export')) { ?>

                    <button type="submit" name="export" value="1" class="btn btn-success">导出</button>

                    <?php  } ?>

				</span>

                     </div>

                 </div>

             </div>

         </form>



         <?php  if(empty($list)) { ?>

         <div class="panel panel-default">

             <div class="panel-body empty-data">未查询到相关数据</div>

         </div>

         <?php  } else { ?>

         <table class="table table-hover">

             <thead class="navbar-inner">

             <tr>

                 <th style="width:190px;">订单号</th>

                 <th>商品名称</th>

                 <th>商品编号</th>

                 <th style="width: 80px">数量</th>

                 <th>价格</th>

                 <th style="width: 100px;">成交时间</th>

             </tr>

             </thead>

             <tbody>

             <?php  if(is_array($list)) { foreach($list as $item) { ?>

             <tr>

                 <td><?php  echo $item['ordersn'];?></td>

                 <td><img src="<?php  echo tomedia($item['thumb'])?>" style="width: 30px; height: 30px;border:1px solid #ccc;padding:1px;"  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" >

                     <?php  echo $item['title'];?>

                 </td>

                 <td><?php  echo $item['goodssn'];?></td>

                 <td><?php  echo $item['total'];?></td>

                 <td><?php  echo $item['price'];?></td>

                 <td><?php  echo date('Y-m-d',$item['createtime'])?><br/><?php  echo date('H:i:s',$item['createtime'])?></td>

             </tr>

             <?php  } } ?>

             </tbody>

             <tfoot>

                <tr>

                    <td colspan="6" style="text-align: right">

                        <?php  echo $pager;?>

                    </td>

                </tr>

             </tfoot>

         </table>

         <?php  } ?>

     </div>

 

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--OTEzNzAyMDIzNTAzMjQyOTE0-->