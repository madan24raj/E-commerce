<?
error_reporting(1);
session_start();
require_once"../Database/clsuser.php";
$obj=new user();
extract($_REQUEST);
?>
<script>

function validate(){
var hidid=$('#hidid').val();
var reward=$('#reward').val();
window.location.href="view-user.php?updreward=upd&hidid="+hidid+"&reward="+reward+"";
}

</script>
<?
if($action=="categorysearch"){
	$sql=$obj->getsubcategory($catid);
	$json=array();
	while($res=mysql_fetch_assoc($sql)){
	 //echo $res['branch_name']." - ".$res['ifsc'];
	$json[]=$res['Id']."~~~".$res['Name'];
			
		}
	echo json_encode($json);
}
if($action=="subcategorysearch"){
	$sql=$obj->getsubsubcategory($catid1);
	$json=array();
	while($res=mysql_fetch_assoc($sql)){
	 //echo $res['branch_name']." - ".$res['ifsc'];
	$json[]=$res['Id']."~~~".$res['Name'];
			
		}
	echo json_encode($json);
}

if($action=="productsearch"){
	$sql=$obj->getproductsearch($prtcode,$catid);
	?>
	 <table class="table" id="searchdata">
<tr>
<th width="5%">#</th>
<th width="10%">Code</th>
<th width="25%">Product Name</th>
<th width="15%">Category</th>
<th width="20%">Sub-Category</th>
<th width="20%">Sub-Sub-Category</th>
<th width="5%">Action</th>
</tr>
<?$count=1; 
while($pro=mysql_fetch_assoc($sql)){
	$cat=$obj->getcategoryname($pro['Cat_id']);
	$sub=$obj->getcategoryname($pro['Subcat_id']);
	$subsub=$obj->getcategoryname($pro['Subsubcat_id']);
	?>
<tr>
<td><?=$count?></td>
<td><?=$pro['Prod_code']?></td>
<td><?=$pro['Name']?></td>
<td><?=$cat['Name']?></td>
<td><?=$sub['Name']?></td>
<td><?=$subsub['Name']?></td>
<td><a href="update-product.php?id=<?=$pro['Id']?>">Update</a>&nbsp;<a href="view-product.php?id=<?=$pro['Id']?>&del=cat">Delete</a></td>
</tr>
<? $count++;}?>
</table>
			
	<?
	}
	
	
	if($action=="viewusersearch"){
	$sql=$obj->getusersearch($name,$email);
	?>
	 <table class="table" id="searchdata">
<tr>
<th width="5%">#</th>
<th width="30%">Customer Name</th>
<th width="25%">Email ID</th>
<th width="15%">Mobile</th>
<th width="20%">Reward Points</th>
<th width="5%">Action</th>
</tr>
<?$count=1; 
while($pro=mysql_fetch_assoc($sql)){
	?>
<tr>
<form method="post">
<input type="hidden" name="hidid" id="hidid" value="<?=$pro['Id']?>" />
<td style="vertical-align:middle"><?=$start+=1?></td>
<td style="vertical-align:middle"><?=$pro['Name']?></td>
<td style="vertical-align:middle"><?=$pro['Email']?></td>
<td style="vertical-align:middle"><?=$pro['Mobile']?></td>
<td style="vertical-align:middle"><input type="text" id="reward" style="width:50%;" name="reward" class="input_filed" value="<?=$pro['reward_points']?>" /></td>
<td style="vertical-align:middle"><a onclick="validate();" href="#" class="btn btn-info"> Update</a></td>
</form>
</tr>
<? $count++;}?>
</table>
			
	<?
	}

?>
