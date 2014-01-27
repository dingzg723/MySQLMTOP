<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script language="javascript" src="js/DatePicker/WdatePicker.js"></script>

<div class="page-header">
  <h2>MySQL 慢查询分析平台<small> </small></h2>
</div>

<div class="ui-widget">
<div class="ui-state-highlight      ui-corner-all">
<p><span class="ui-icon ui-icon-volume-on" style="float: left; margin-right: .3em;"></span>
MySQLMTOP温馨提示：1.默认显示一台主机的慢查询,可通过检索栏切换到不同的主机; 2.点击对应的checksum查看语句的执行详情; 3.点击展开所有按钮展开所有的语句,+按钮可以展开当前语句。 </p>
</div>
</div>
  
<script src="./bootstrap/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  
	//hide message_body after the first one
	//$(".table .message_body:gt(0)").hide();
    $(".table .message_body").hide();
	$(".collpase_all_message").hide();
	
	//toggle message_body
	$(".message_head").click(function(){
		$(this).next(".message_body").slideToggle(200)
		return false;
	});

    //collapse all messages
	$(".collpase_all_message").click(function(){
	   		$(this).hide()
		$(".show_all_message").show()
		$(".message_body").slideUp(200)
		return false;
	});

	//show all messages
	$(".show_all_message").click(function(){
		$(this).hide()
		$(".collpase_all_message").show()
		$(".message_body").slideDown()
		return false;
	});
 
   $(".pinned").pin();

});

</script>
<style type="text/css">

/* message display page */

.message_head {
	padding: 2px 5px;
	cursor: pointer;
	position: relative;
}

.message_head cite {
	font-size: 100%;
	font-weight: bold;
	font-style: normal;
}

</style>


<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span class="ui-icon ui-icon-search" style="float: left; margin-right: .3em;"></span>
                    
<form name="form" class="form-inline" method="get" action="<?php site_url('monitor/replication') ?>" >
  <input type="hidden" name="search" value="submit" />
  切换主机(已开启慢查询)
  <select name="server_id" class="input-medium" style="" >
  <?php foreach ($server as $item):?>
  <option value="<?php echo $item['id'];?>" <?php if($setval['server_id']==$item['id']) echo "selected"; ?> ><?php echo $item['host'];?>:<?php echo $item['port'];?></option>
   <?php endforeach;?>
  </select>
  最后执行时间
  <input class="Wdate" style="width:120px;" type="text" name="stime" id="start_time>" value="<?php echo $setval['stime'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,dateFmt:'yyyy-MM-dd HH:mm'})"/>
  <input class="Wdate" style="width:120px;" type="text" name="etime" id="end_time>" value="<?php echo $setval['etime'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,startDate:'1980-05-01',dateFmt:'yyyy-MM-dd HH:mm'})"/>
  <button type="submit" class="btn btn-success">检索</button>
  <a href="<?php echo site_url('monitor/replication') ?>" class="btn btn-warning">重置</a>

</form>
                    
</div>

                



<table class="table table-hover table-striped  table-bordered table-condensed" style="font-size: 12px;" >
	<tr>
		<th colspan="4"><center>SQL</center></th>
		<th colspan="3"><center>Query</center></th>
        <th colspan="3"><center>Lock</center></th>
		<th colspan="2"><center>Rows</center></th>
		

	</tr>
    <tr>
        <th>checksum</th>
        <th>fringerprint <span class="collapse_buttons" ><a href="#" class="show_all_message">展开所有</a> <a href="#" class="collpase_all_message">合并所有</a></span></th>
        <th>ts_cnt</th>
        <th>last_seen</th>
        <th>time_sum</th>
		<th>time_min</th>
        <th>time_max</th>
        <th>time_sum</th>
        <th>time_min</th>
		<th>time_max</th>
		<th>sent_sum</th>
		<th>examined_sum</th>
	
	</tr>
	
 <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr style="font-size: 12px;">
        <td><a href="<?php echo site_url('slowquery/detail/'.$item['checksum'].'/'.$setval['server_id']) ?>" target="_blank"  title="点击进入详情"><?php  echo $item['checksum'] ?></a></td>
         <td>
         <div class="message_head"><span class="message_icon"><i class="icon-plus"></i></span><cite><?php echo substring($item['fingerprint'],0,40); ?>:</cite></div>
		<div class="message_body" style="width: 300px;">
			<pre><span style="color: blue;"><?php echo $item['fingerprint']; ?></span></pre>
		</div>
        <td><?php echo $item['ts_cnt'] ?></td>
        <td><?php echo $item['last_seen'] ?></td>
        <td><?php echo $item['Query_time_sum'] ?></td>
        <td><?php echo $item['Query_time_min'] ?></td>
        <td><?php echo $item['Query_time_max'] ?></td>
        <td><?php echo $item['Lock_time_sum'] ?></td>
        <td><?php echo $item['Lock_time_min'] ?></td>
        <td><?php echo $item['Lock_time_max'] ?></td>
        <td><?php echo $item['Rows_sent_sum'] ?></td>
        <td><?php echo $item['Rows_examined_sum'] ?></td>
       
        
	</tr>
 <?php endforeach;?>
<?php }else{  ?>
<tr>
<td colspan="12">
<font color="red">对不起,没有查询到相关数据！ 1.请确认是否添加主机信息; 2.请确认主机是否部署慢查询采集脚本并开启慢查询。</font>
</td>
</tr>
<?php } ?>
	 
</table>

<div class="pagination">
  <ul>
	<?php echo $this->pagination->create_links(); ?>
  </ul>
</div>
