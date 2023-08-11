<?
require_once "headeradmin.php";
$obj=new user();
extract($_REQUEST);
$cat=$obj->getcategory();
$prod=$obj->getproductbyid($id);
$sql=$obj->getstockbycode($prod['Prod_code']);
if(!isset($_SESSION['admin'])){
header('Location:index.php');
}
if(isset($suc)){
	echo "<script>$(function(){
		$('#err').html('Updated Successfully');
	});</script>";
}
if(isset($stockupdsuc)){
	echo "<script>$(function(){
		$('#err').html('Stock Updated Successfully');
	});</script>";
}
if(isset($stockdel)){
	echo "<script>$(function(){
		$('#err').html('Stock Deleted Successfully');
	});</script>";
}
if(isset($update)){
	$obj->updateproduct();
}
if(isset($delstock)){
	$obj->delstock();
}
if(isset($supdate)){
	$obj->updstock();
}
?>
<style>
.pd{
	float:left;
	padding:2%;
}
.table td{
	border-top:none;
}
.table th{
	border-bottom:1px solid #dee2e6;
}
.don label{
	appearance:button;
	padding:10px;
	cursor:pointer;
	height:30px;
	width:30px;
	text-align:left;
	float:left;
}
input[name=color]{
	display:none;
}
input[type="radio"]:not(:checked)  {
    border: 0px #000 solid;
}

.don{
	list-style-type:none;
}
.don li{
	float:left;
	margin-right:5px;
}
.don label:hover{
border:2px solid #000;
}
</style>
<script>

$(function(){
	var prtcode = $('#prtcode').val();
			$(".colors").change(function(){
	var col=$(this).val();
	$(this).parent().find('.col').html(col);
});
     $("#black_overlay").css({"height":"100%","display":"block","z-index":"5"});
  //Put an animated GIF image insight of content
  $("#black_overlay").html('<center><table><tr><td valign="top"><img src="../images/loading2.gif"></td></tr></table></center>');
			var req = 'retrieve.php?prtcode=' + prtcode;
			$.getJSON(req, null, function(datas) {
				var sub=datas.sub;
				var subsub1=datas.subsub;
				$('#name').val(datas.name);
				$('#cat').val(datas.cat);
				$('#desc').val(datas.desc);
				$('#price').val(datas.price);
				
	
				
				
			/* sub category selection */
			var catid=$('#cat').val();
			var data=new Array();
			var action="categorysearch";
			var datastring={catid:catid,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			$('#sub').empty();
			 $('#sub').append('<option value="">--Select---</option>');
			resultObj = eval (data);
			
       for(var i=0;i<resultObj.length;i++){
	   var sel="";
	   var id=resultObj[i].split("~~~");
	   if(id[0]==sub){sel="selected";}else{sel="";}
	   $('#sub').append('<option value="'+id[0]+'" '+sel+'>'+id[1]+'</option>');
          
		  }
		  
		}
	    
	});
	
				
				/*subsubcategory selection */
			
			var catid1=sub;
			var data1=new Array();
			var action="subcategorysearch";
			var datastring1={catid1:catid1,action:action};
			$.ajax({
			type:"post",
		url:"ajax_data.php",
		data:datastring1,
		success:function(data1){
			$('#subsub').empty();
			 $('#subsub').append('<option value="">--Select---</option>');
			resultObj1 = eval (data1);
			for(var i=0;i<resultObj1.length;i++){
		   var sel="";
	   var id1=resultObj1[i].split("~~~");
	   if(id1[0]==subsub1){sel="selected";}else{sel="";}
	   $('#subsub').append('<option value="'+id1[0]+'" '+sel+'>'+id1[1]+'</option>');
		  }
		}
	    
	});

			 $("#black_overlay").hide();
			
			});

		
	
	
	
	
	$('.color').click(function(){
	   
   
	if($(this).is(':checked')) {
		$('.color').parent().css('border','none');
		$(this).parent().css({'border':'2px #000 solid'});
		}
		
	});
	
	
	$('#cat').change(function() {
	var catid=this.value;
	var data=new Array();
	var action="categorysearch";

	var datastring={catid:catid,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			$('#sub').empty();
			 $('#sub').append('<option value="">--Select---</option>');
			resultObj = eval (data);
			
       for(var i=0;i<resultObj.length;i++){
	   var id=resultObj[i].split("~~~");
	   
	   $('#sub').append('<option value="'+id[0]+'">'+id[1]+'</option>');
          
		  }
		}
	    
	});
	});
	$('#sub').change(function() {
	var catid1=this.value;
	var data=new Array();
	var action="subcategorysearch";

	var datastring={catid1:catid1,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			$('#subsub').empty();
			 $('#subsub').append('<option value="">--Select---</option>');
			resultObj = eval (data);
			
       for(var i=0;i<resultObj.length;i++){
	   var id=resultObj[i].split("~~~");
	   
	   $('#subsub').append('<option value="'+id[0]+'">'+id[1]+'</option>');
          
		  }
		}
	    
	});
	});
	
			
		
});

</script>


<div style="width:80%;margin:0 auto;">
<form action="#" method="post" name="prd" enctype="multipart/form-data">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center"><span id="err" style="color:green;"></span></div>
<div class=" col-xl-6 col-lg-6 col-md-6 col-sm-6 pd">
<div><b>Product Code</b></div>
<input type="text" id="prtcode" name="prtcode" class="input_filed" value="<?=$prod['Prod_code']?>" readonly />
</div>
<div class=" col-xl-6 col-lg-6 col-md-6 col-sm-6 pd">
<div><b>Product Name</div>
<input type="text" name="prtname" id="name" class="input_filed" required />
</div>
<div class=" col-xl-6 col-lg-6 col-md-6 col-sm-6 pd">
<div><b>Select Category</b></div>
<select id="cat" name="cat" class="input_filed" required>
<option value="">--Select---</option>
<? foreach($cat as $key=>$value)
{
?>
<option value="<?=$key?>"><?=$value?></option>
<? }?>
</select>
</div>
<div class=" col-xl-6 col-lg-6 col-md-6 col-sm-6 pd">
<div><b>Select Sub-Category</b></div>
<select id="sub" name="sub" class="input_filed" required>
<option value="">--Select---</option>

</select>
</div>

<div class=" col-xl-6 col-lg-6 col-md-6 col-sm-6 pd">
<div><b>Select Sub-Sub-Category</b></div>
<select id="subsub" name="subsub" class="input_filed" >
<option value="">--Select---</option>
<? while($res=mysql_fetch_assoc($sel))
{
?>
<? echo $res['Id'];?>
<option value="<?=$res['Id']?>"><?=$res['cat_name']?></option>
<? }?>
</select>
</div>
<div class=" col-xl-6 col-lg-6 col-md-6 col-sm-6 pd"> 
 <div><b>Price</b></div> 
 <input type="text" name="price" id="price" class="input_filed"  /> 
 </div>
 <div class=" col-xl-6 col-lg-6 col-md-12 col-sm-12 pd">
<div><b>Description</b></div>
<textarea name="desc" id="desc" rows="3" placeholder="Description about product" class="textarea " required></textarea>
</div>
<div class=" col-xl-6 col-lg-6 col-md-12 col-sm-12 pd">
<div><b>Size Chart</b></div>
<input type="hidden" name="hidsizechart" value="<?=$prod['sizechart']?>" />
<input type="file" name="sizechart" />
</div>

<div class=" col-xl-6 col-lg-6 col-md-12 col-sm-12 pd pt-2"><input type="submit" name="update" class="btn btn-primary" value="Update"/>  </div>
</form>

<div style="width:100%;float:left;">
<table class="table"  id="searchdata">
<tr>

<th width="12%">Color</th>
<th width="12%">Small</th>
<th width="12%">Medium</th>
<th width="12%">Large</th>
<th width="12%">X-Large</th>
<th width="12%">XX-Large</th>
<th width="28%">Action</th>
</tr>
<?$count=1; 
while($pro=mysql_fetch_assoc($sql)){
	
	?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="stid" value="<?=$pro['id']?>"/>
<input type="hidden" name="pid" value="<?=$prod['Id']?>"/>
<tr>
	<input type="hidden" value="<?=$pro['image1']?>" name="image1"/>
	<input type="hidden" value="<?=$pro['image2']?>" name="image2"/>
	<input type="hidden" value="<?=$pro['image3']?>" name="image3"/>
<td style="vertical-align:middle;"><? if($pro['colortype']==1){?><img src="../images/gradient.png" width="28" height="28"/><?}else{?><input type="color" name="colors" class="colors" value="#<?=$pro['color']?>" />&nbsp; <span class="col" style="font-size:14px;">#<?=$pro['color']?></span><?}?></td>
<td  style="vertical-align:middle;"><input type="text" name="small" class="ss" value="<?=$pro['small']?>"></td>
<td  style="vertical-align:middle;"><input type="text" name="medium" class="ss" value="<?=$pro['medium']?>"></td>
<td  style="vertical-align:middle;"><input type="text" name="large" class="ss" value="<?=$pro['large']?>"></td>
<td  style="vertical-align:middle;"><input type="text" name="xlarge" class="ss" value="<?=$pro['xlarge']?>"></td>
<td  style="vertical-align:middle;"><input type="text" name="xxlarge" class="ss" value="<?=$pro['xxlarge']?>"></td>
<td  style="vertical-align:bottom;"><a href="update-product.php?pid=<?=$prod['Id']?>&did=<?=$pro['id']?>&delstock=del">Delete</a></td>
</tr>
<tr style="border-bottom:1px solid #dee2e6;">
<td colspan=2 style="vertical-align:middle;"><input type="file" name="img1" value="<?=$pro['image1']?>"/></td><td colspan=2 style="vertical-align:middle;"><input type="file" name="img2" value="<?=$pro['image2']?>"/></td><td colspan=2 style="vertical-align:middle;"><input type="file" name="img3" value="<?=$pro['image3']?>" /></td>
<td style="vertical-align:top;"><input type="submit" class="btn btn-primary p-1" value="Update" name="supdate"/>
</tr>
</form>
<? $count++;}?>
</table>
</div>

</div>




</body>
</html>
