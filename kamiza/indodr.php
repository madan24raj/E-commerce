	<?
	ob_start();

	require_once"../database/clsuser.php";
	$obj=new user();
	extract($_REQUEST);
	require_once"Order_Header.php";

	date_default_timezone_set('Asia/Kolkata');
	$num_rec_per_page=20;
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
	$start_from = ($page-1) * $num_rec_per_page; 
	

	

	if(!empty($type))
	{
		if($whr=="")
		{
		$whr.="  a.Category='$type'";
		}
		else
		{
			$whr.=" and a.Category='$type'";
		}
	}
	if(!empty($status))
	{
		if($status=="FAILED")
		{
			if($whr=="")
		{
			$whr.="  a.Status='$status' or a.Status='TXN_FAILURE'";
		}
		else
		{
			$whr.=" and (a.Status='$status' or a.Status='TXN_FAILURE')";
		}
		}
		else if($status=="APPROVED")
		{
				if($whr=="")
		{
		$whr.="  a.Status='$status' or a.Status='TXN_SUCCESS'";
		}
		else
		{
			$whr.=" and (a.Status='$status' or a.Status='TXN_SUCCESS')";
		}
		}
		else if($status=="No TXN")
	{
			if($whr=="")
	{
	$whr.="  a.Status='$status'";
	}
	else
	{
		$whr.=" and (a.Status='$status')";
	}
	}
		else
		{
			if($whr=="")
		{
			$whr.="  a.Status='$status'";
		}
		else
		{
			$whr.=" and a.Status='$status'";
		}
		}
	}
	if(!empty($from)){
		$fr=explode("/",$from);$ex=$fr[0]."-".$fr[1]."-".$fr[2];
		if($whr=="")
			{
			$whr.=" a.Dates='$ex'";
		}
		else
		{
			$whr.=" and a.Dates='$ex'";
		}
	}
	//echo "select a.*,b.Name from orderdetails as a join admin as b on a.User_id=b.Id where $whr"
	

	
	
	
		$sql_qury="select a.*,a.Status as stat,b.Name,b.Id,b.Userid,b.Mobileno,b.Activation,b.Status,b.uniq_id from orderdetails as a join admin as b on a.User_id=b.Id where b.uniq_id='$order_id'  order by a.Order_id, STR_TO_DATE(a.Dates,'%d-%m-%Y') DESC LIMIT $start_from, $num_rec_per_page";
		
		//echo "select a.*,a.Status as stat,b.Name,b.Id,b.Userid,b.Mobileno,b.Activation,b.Status,b.uniq_id from orderdetails as //a join admin as b on a.User_id=b.Id  ".$whr." ORDER BY a.Order_id, Dates DESC LIMIT $start_from, $num_rec_per_page";
		//echo "select a.*,b.Name from orderdetails as a join admin as b on a.User_id=b.Id where ".$whr."";
	
	$det=mysql_fetch_assoc(mysql_query("select a.*,a.Status as stat,b.Name,b.Id,b.Userid,b.Mobileno,b.Activation,b.Status,b.uniq_id from orderdetails as a join admin as b on a.User_id=b.Id where b.uniq_id='$order_id'  order by a.Order_id, STR_TO_DATE(a.Dates,'%d-%m-%Y') DESC LIMIT 1"));
	$sel=mysql_query($sql_qury);
	?>

	<style>
 .pagenation
  {
	  width: 2%;
	  padding: 2px 21px 2px 21px;
    float: left;
  }
  .pagenation a
  {
	  color:#fff;
  }
  .page_a a
  {
	  width: 2%;
	  padding: 2px 21px 2px 21px;
    float: left;
	 color:#fff;
  }
  
</style>
	<div id="whole" >
	<div class="content">
	<table width="100%" cellpadding="3" cellspacing="2" align="center" style="font-size:15px;" > 
	<tr><td colspan=5><b>ORDER DETAILS</b></td></tr>
	<form method="post"> 
	<tr>
	<td WIDTH="20%;"><input type="text" name="order_id"  id="byid" placeholder="IHS ID"  class="tx_nrm" style="width:150px;" /></td>
	 <td><input type="submit" value="Search" class='btn' style="background-color:#017935;margin:0;" /></td>
	 <td colspan=2 > NAME - <b><?=$det['Name']?></b></td>
	<td > IHS ID - <b><?=$det['uniq_id']?></b></td>
	
	 
	</tr>
	</form>
	<tr><td align="left">
	 <? if($det['Status']==6){?>
	 <a class="btn" href="view_user.php?id=<?=$det['Id']?>&st=6&unid=<?=$det['uniq_id']?>&uids=&sta=">View Details</a>
	 <? }?>
	  <? if($det['Status']==3){?>
	 <a class="btn" href="cesview_user.php?id=<?=$det['Id']?>&st=3&unid=<?=$det['uniq_id']?>">View Details</a>
	 <? }?>
	  <? if($det['Status']==2){?>
	 <a class="btn" href="studentview_user.php?id=<?=$det['Id']?>&st=2&unid=<?=$det['uniq_id']?>">View Details</a>
	 <? }?>
	 </td>
	<td colspan="4" align=right style="padding-top:10px;">
	    <img src="image/Success.jpg" height="20" title="Success" align="absmiddle"> Success &nbsp; 
	    <img src="image/Failure.jpg" height="20" title="Failure" align="absmiddle"> Failure &nbsp; 
	    <img src="image/Invalid.jpg" height="20" title="Invalid" align="absmiddle"> Invalid &nbsp; 
	    <img src="image/Abort.jpg" height="20" title="Aborted" align="absmiddle"> Aborted &nbsp; 
	    <img src="image/Awaiting.jpg" height="20" title="No Status" align="absmiddle"> No Status
	</td></tr>
	</table>
	<table width="100%"  cellpadding="3" cellspacing="2" align="center" style="font-size:15px;" >
	<tr bgcolor="#0cb4ce" class="wit" align="center">
	
	<td width="140">ORDER ID</td>
	
	<td>MODULE PURCHASED</td>
	<td width="80">STATUS</td>
	<!--<th  align="left">Email</th>-->
	<td width="100">DATE</td>
	</tr>
	<?
	if(mysql_num_rows($sel)!="0"){
		
		while($res=mysql_fetch_assoc($sel)){
			?>
			<tr>
			


		
	<td align="center" style="border-bottom:1px dotted #ccc; border-right:1px dotted #666;" valign="top"><?=$res['Order_id']?></td>
	
	<td align="left" style="padding-left:10px !important;border-bottom:1px dotted #ccc; border-right:1px dotted #666;" valign="top">

	<?

	$qid=str_replace(",","','",$res['Pack_id']);
	if($res['Category']==1)
	{
		
		$sql_in_query="SELECT * FROM  cne where Id in('$qid')";
		$sel_in=mysql_query($sql_in_query);
		if(mysql_num_rows($sel_in)!="0"){
		while($id_id=mysql_fetch_assoc($sel_in))
		{
			if(mysql_num_rows($sel_in)>1)
			{
				echo $id_id['Module'].", ";
			}
			else
			{
				echo $id_id['Module'];
			}
		}
		}
		
	//	echo "SELECT * FROM  cne where Id in('$qid')";
	}
	else if($res['Category']==2)
	{
		$sql_in_query_nur="SELECT * FROM  package where Id in('$qid')";
		$sel_in_nur=mysql_query($sql_in_query_nur);
		if(mysql_num_rows($sel_in_nur)!="0"){
		while($id_id_nur=mysql_fetch_assoc($sel_in_nur))
		{
			if(mysql_num_rows($sel_in_nur)>1)
			{
				echo $id_id_nur['Name'].",";
			}
			else
			{
				echo $id_id_nur['Name'];
			}
		}
		}
	}
		else if($res['Category']==3)
	{
		$sql_in_query_nur="SELECT * FROM  student_pack where Id in('$qid')";
		$sel_in_nur=mysql_query($sql_in_query_nur);
		if(mysql_num_rows($sel_in_nur)!="0"){
		while($id_id_nur=mysql_fetch_assoc($sel_in_nur))
		{
			if(mysql_num_rows($sel_in_nur)>1)
			{
				echo $id_id_nur['Name'].",";
			}
			else
			{
				echo $id_id_nur['Name'];
			}
		}
		}
	}
	?>
	</td>
	<td align="center" style="border-bottom:1px dotted #ccc; border-right:1px dotted #666;" valign="top">
	    
	    <? //=$res['stat']?>
	    <? if ($res['stat'] == "Success"){
	    echo '<img src="image/Success.jpg" height="20" title="Success">';
	    }
	    if ($res['stat'] == "Failure"){
	    echo '<img src="image/Failure.jpg" height="20" title="Failure">';
	    }
	    if ($res['stat'] == "Invalid"){
	    echo '<img src="image/Invalid.jpg" height="20" title="Invalid">';
	    }
	    if ($res['stat'] == "Aborted"){
	    echo '<img src="image/Abort.jpg" height="20" title="Aborted">';
	    }
	    if ($res['stat'] == ""){
	    echo '<img src="image/Awaiting.jpg" height="25" title="No Status">';
	    }
	    ?>
	    </td>
	<td align="center" style="border-bottom:1px dotted #ccc; border-right:1px dotted #666;" valign="top">
	<?
	$originalDate = $res['Dates'];
	$timestamp = strtotime($originalDate);
	echo date("d-m-Y", $timestamp);
	?>

	</td>
	</tr>
	<? } } ?>
	</table>

	


	</div>
	</div>

	<script>

	 $(function() {

		$("#datepicker_from" ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  yearRange: "-100:+0"
		});
	  } );
	   $(function() {

		$(datepicker_to).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  yearRange: "-100:+0"
		});
	  } );
	  </script>