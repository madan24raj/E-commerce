<?
require_once "headeradmin.php";
$obj=new user();
extract($_REQUEST);
$cat=$obj->getcategory();
if(!isset($_SESSION['admin'])){
header('Location:index.php');
}
if(isset($suc)){
	echo "<script>alert('Added Successful');</script>";
}
if(isset($submit)){
	$sql=mysql_num_rows(mysql_query("select * from product where Prod_code='$prtcode'"));
	if($sql>0){
		$obj->addstock();
	}
	else{
	$obj->insert_prt();
	}
}
?>
<style>
.pd{
	float:left;
	padding:2%;
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

function colchange(){
	var col=$('#colors').val();
	$('#col').html('Value : '+col);
}

$(function(){
	
		$('.colradio').change(function() {
	 if($('#multi').is(':checked')) { 
var multi='colormulti';
	$('#colortype').val(1);
	$('#colors').hide();
	 $('#col').html('Value: Multicolor');
	 }
	 if($('#single').is(':checked')) {
$('#colortype').val(0);		 
$('#colors').show();
$('#col').show();
 $('#col').html('Value: #000000');
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
	
		$('#prtcode').keyup(function(e) {	
		var prtcode = $(this).val();
			
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

		
			
			});
	
		
	});
});

</script>


<div style="width:70%;margin:0 auto;">
<form action="#" method="post" name="prd" enctype="multipart/form-data">
<div class=" col-xl-6 col-lg-6 col-md-6 col-sm-6 pd">
<div><b>Product Code</b></div>
<input type="text" id="prtcode" name="prtcode" class="input_filed	" required />
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
<div><b>Color</b> &nbsp; <input type="radio" class="colradio" name="ctype" id="single" value="single" checked/> Single &nbsp; &nbsp;<input type="radio" class="colradio" name="ctype" id="multi" value="multi" /> Multicolor</div>
<div style="padding:8% 2%;"><input type="color" name="colors" id="colors" onchange="colchange();" value="#000000" class="input_filed"/><br/><span id="col" style="font-size:15px;">Value : #000000</span>
<input type="hidden" name="colortype" value="0" id="colortype"/>
</div>
</div>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 pd">
 <h5>Images<i style="font-size:15px;">(600x600)</i></h5>
 <div class=" col-xl-12 col-lg-12 col-md-12 col-sm-12 pd">
 <div><b>Image 1</b></div> 
 <input type="file" name="img1" required /> 
 </div>
 <div class=" col-xl-12 col-lg-12 col-md-12 col-sm-12 pd">
 <div><b>Image 2</b></div> 
 <input type="file" name="img2"   /> 
 </div>
 <div class=" col-xl-12 col-lg-12 col-md-12 col-sm-12 pd">
 <div><b>Image 3</b></div> 
 <input type="file" name="img3"   /> 
 </div>
</div>
 <div class=" col-xl-6 col-lg-6 col-md-6 col-sm-6 pd" style="margin-left:-10px;margin-top:5px;">
<h5>Size</h5>
 <div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">
 <span style="font-weight:bold;" >S&nbsp;&nbsp;</span> 
         <input type="text" name="small" class="ss"  /> 
 </div>
  <div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd"> 
 <span style="font-weight:bold;width:25px;" >M&nbsp;&nbsp;&nbsp;</span> 
         <input type="text" name="medium" class="ss"  /> 
 </div>
  <div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd"> 
<span style="font-weight:bold;width:25px;" >L&nbsp;&nbsp;&nbsp;</span> 
         <input type="text" name="large" class="ss"  /> 
 </div>
  <div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd"> 
 <span style="font-weight:bold;width:25px;" >XL</span> 
         <input type="text" name="xlarge" class="ss"  /> 
 </div>
  <div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd"> 
 <span style="font-weight:bold;width:25px;" >XXL</span> 
          <input type="text" name="xxlarge" class="ss"  /> 
 </div>
   <div class=" col-xl-12 col-lg-12 col-md-12 col-sm-12 pd"> 
 <span style="font-weight:bold;width:25px;" >Size Chart</span></br> 
         <input type="file" name="sizechart"   /> 
 </div>
</div>


</br>
<div class=" col-xl-12 col-lg-12 col-md-12 col-sm-12 pd text-center"><input type="submit" name="submit" class="btn btn-primary" value="Submit"/>  </div>
</div>
</form>






</body>
</html>
