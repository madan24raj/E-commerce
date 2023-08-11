<?
require_once"header.php";
$obj=new user();
$states=$obj->states();
if(isset($_SESSION['id'])){
	$wish=$obj->getfullwishlist();
   $sql=$obj->selectuser($_SESSION['id']);
}
if(isset($profileupdate)){
$obj->updateprofile();	
}
if(isset($profupd)){
echo "<script>
$(function(){
	$('#profsuc').show();
});
</script>";	
}
?>
<style>
.modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
		background: #60c7c1;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
		min-width: 120px;
        border: none;
		min-height: 40px;
		border-radius: 3px;
		margin: 0 5px;
		outline: none !important;
    }
	.modal-confirm .btn-info {
        background: #c1c1c1;
    }
    .modal-confirm .btn-info:hover, .modal-confirm .btn-info:focus {
        background: #a8a8a8;
    }
    .modal-confirm .btn-danger {
        background: #f15e5e;
    }
    .modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
        background: #ee3535;
    }
	.trigger-btn {
		display: inline-block;
		margin: 100px auto;
	}

</style>
<div class="nav flex-column nav-pills float-left sidenav" id="v-pills-tab" role="tablist"  aria-orientation="vertical" >

  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="v-pills-home" aria-selected="true">Profile</a>
  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#wish" role="tab" aria-controls="v-pills-messages" aria-selected="false">Wishlist</a>
  <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Orders</a>
</div>

<div class="tab-content float-left" style="width:75%;">

<div  class="tab-pane fade show active" role="tabpanel" id="profile">
	<div class="row p-4">
	<div style="width:50%;float:left;"><span>Personal Profile</span></div><div style="width:50%;float:right;"><span style="float:right;">Your Reward Points : <b><?=$sql['reward_points']?></b></span></div>
	<form method="post" id="form" onsubmit="return validation()">

<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" id="name" name="name" placeholder="Name" class="input_filed" style=" width: 80%;" value="<?=$sql['Name']?>" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 21px 0;"><b>Gender: &nbsp; </b>
<input type="radio" name="gender" value="Male"  <?if($sql['Gender']=='Male'){echo "checked";}?>/> Male &nbsp; &nbsp; 
<input type="radio" name="gender" value="Female" <?if($sql['Gender']=='Female'){echo "checked";}?>/> Female &nbsp; &nbsp; 
<input type="radio" name="gender" value="Others" <?if($sql['Gender']=='Others'){echo "checked";}?>/> Others
</div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="email" id="email" name="email" placeholder="Email" class="input_filed" style=" width: 80%;" value="<?=$sql['Email']?>" readonly /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" name="mob" id="mobile" placeholder="Mobile" class="input_filed" style=" width: 80%;" value="<?=$sql['Mobile']?>" readonly /></div>
<!--div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="password" id="pass" name="pass" placeholder="Password" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="password" id="cpass" name="conpass" placeholder="Confirm Password" class="input_filed" style=" width: 80%;" required /></div-->

<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" name="address" placeholder="Door no / Street" class="input_filed" style=" width: 80%;" value="<?=$sql['Address']?>" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" name="area" placeholder="Area" class="input_filed" style=" width: 80%;"  value="<?=$sql['Area']?>" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" name="city" placeholder="City" class="input_filed" style=" width: 80%;" value="<?=$sql['City']?>" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" id="pincode" name="pincode" placeholder="Pincode" class="input_filed" style=" width: 80%;" value="<?=$sql['Pincode']?>"  required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;">
<select name="state" class="input_filed" required style=" width: 80%;">
<option value="">Select State</option>
<? foreach($states as $key=>$val){
	$sel="";
	if($sql['State']==$key){$sel="selected";}
echo '<option value="'.$key.'" '.$sel.'>'.$val.'</option>';	
}?>
</select>
</div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center;"><input type="submit" onclick="return validation()" id="signup" name="profileupdate" value="Update" class="btn btn-primary" style="margin:15px 0 0 0px; width: 50%;background-color:#007bff;"/><br>
<span id="profsuc" style="color:green;display:none;">Updated Successfully!</span>
</div>
</form>
   </div>
<div class="row p-4">
<div class="col-xl-12 col-lg-12 col-md-12 col-12 float-left">
<span id="changepass" style="cursor:pointer;">Change Password?</span>
</div>
<div class="col-xl-12 col-lg-12 col-md-12 col-12 float-left" style="display:none;" id="passdiv">
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;">
<input type="hidden" id="hidcurrentpass" name="hidcurrentpass" value="<?=$sql['Password']?>"/> 
<input type="password" id="currentpass" name="currentpass" placeholder="Current Password" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="password" id="newpass" name="newpass" placeholder="New Password" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="password" id="newconpass" name="newconpass" placeholder="Confirm New Password" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left text-center" ><input type="submit" id="changepassbtn" name="changepassbtn" value="Change Password" class="btn btn-primary" style="margin:15px 0 0 0px; width: 50%;background-color:#007bff;"/><br>
<span id="passchangesuc" style="color:green;display:none;">Password Changed Successfully!</span>
</div>
</div>
</div>   
</div>

 <div class="tab-pane fade " id="wish">
        
        <div class="row p-4">
		<?$num=mysql_num_rows($wish);
		if(empty($num)){?>
			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 float-left p-4" style="border: 1px dashed #ccc;" align="center">
			<img src="images/emptywishlist.png" width="50%" />
			</div>
		<?}else{
		while($prod=mysql_fetch_assoc($wish)){?>
            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 float-left p-4" id="wishli" style="border: 1px dashed #ccc;">
			<button type="button"  class="close remwish" > <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

                        </button>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 float-left p-3">
                    <img src="images/Products/<?=$prod['image1']?>" width="100px" height="100px" />
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 ddg float-left">
						
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 float-left p-1">
						<h6><?=$prod['Name']?> &nbsp; </h6>
                  </div>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 float-left p-1">	
<span>Color - </span> <span style="width:25px;height:25px;border:1px solid black;background-color:<?=$prod['CL']?>"> &nbsp;&nbsp; &nbsp; </span></br>
</div>


<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 float-left p-1">
<span style="color:#000;font-size:15px;font-weight:bold;"><? echo '<i  class="fa fa-inr"></i> <b>'.$prod['Price'].'</b>' ?></span>
</div>
<div class="sz col-xl-12 col-lg-12 col-md-12 col-sm-12 float-left p-2" >

<div class="p-2 w-75 float-left">
<span class="ele">SIZE &nbsp;</span>
<? $size=$obj->getsizes($prod['prod_code'],$prod['CL']);?>
<?if($size['small']==0){?>
<input type="button" class="siz S" id="S" style="background-color:#eee;"  name="small" value="S" disabled>
<?}else{?>
<input type="button" class="siz S" id="S"  name="small" value="S">
<?}?>
<?if($size['medium']==0){?>
<input type="button" class="siz M"  id="M" style="background-color:#eee;"  name="medium" value="M" disabled>
<?}else{?>
<input type="button" class="siz M" id="M"  name="medium" value="M">
<?}?>
<?if($size['large']==0){?>
<input type="button" class="siz L" id="L" style="background-color:#eee;"  name="large" value="L" disabled>
<?}else{?>
<input type="button" class="siz L" id="L" name="large" value="L">
<?}?>
<?if($size['xlarge']==0){?>
<input type="button" class="siz L"  id="XL" style="background-color:#eee;"  name="xlarge" value="XL" disabled>
<?}else{?>
<input type="button" class="siz L" id="XL" name="xlarge" value="XL">
<?}?>
<?if($size['xxlarge']==0){?>
<input type="button" class="siz L" id="XXL" style="background-color:#eee;"  name="xxlarge" value="XXL" disabled>
<?}else{?>
<input type="button" class="siz L" id="XXL" name="xxlarge" value="XXL">
<?}?>
</div>
<div class="w-25 float-left">
    <input type="hidden" name="wishid" class="wishid2" value="<?=$prod['Id']?>"/>
			    <input type="hidden" name="pcolors" class="pcolors" value="<?=$prod['CL']?>"/>
			    <input type="hidden" name="pcodes" class="pcodes" value="<?=$prod['prod_code']?>"/>
<button class="btn cart btn-link">Move To Cart</button>
</div>
</div>

                        
                    </div>
					</div>
					 <div id="confirmmodel2" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
		
			<div class="modal-body">
				<p style="color:#000;font-size:16px;text-align:center;" id="paramsg2"></p>
			</div>
			<div class="modal-footer">
			    <input type="hidden" name="wishid" class="wishid2" value="<?=$prod['Id']?>"/>
			    <input type="hidden" name="pcolors" class="pcolors" value="<?=$prod['CL']?>"/>
			    <input type="hidden" name="pcodes" class="pcodes" value="<?=$prod['prod_code']?>"/>
				<div style="float:left;width:70%"><button type="button" class="btn btn-info" data-dismiss="modal">No</button></div>
				<button type="button" class="del22 btn btn-danger">Yes</button>
			</div>
		</div>
	</div>
</div>
					
					
		<? }} ?>
                </div>
				
            </div>

        </div>
  <script>
 $(function(){
     var psize='';
	var size='';
	<?for($i=0;$i<1;$i++){?>
<?if($size['small']!=0){?>
	size='small';
	psize='S';
	
<?break;}?>
<?if($size['medium']!=0){?>
	size='medium';
	psize='M';
<?break;}?>
<?if($size['large']!=0){?>
	size='large';
	psize='L';
<?break;}?>
<?if($size['xlarge']!=0){?>
	size='xlarge';
	psize='XL';
<?break;}?>
<?if($size['xxlarge']!=0){?>
	size='xxlarge';
	psize='XXL';
<?break;}?>	
	<?}?>
	
		$('.siz').css({'border':'1px #ccc solid'});
		if(psize!=''){
		$("#"+psize).css({'border':'1px #000 solid'});
		}
    $('.remwish').click(function(){
		
	    $('#paramsg2').html('Are you sure want to remove this item from the wishlist?')
	    $('#confirmmodel2').modal('show');
	});
	
	$('.del22').click(function(){
	     $('#confirmmodel2').modal('hide');

		var wishid=$(this).parent().parent().find('.wishid2').val();
		
		$.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          wishid:wishid,
		  removewishlist:"wishlist"
        },
        success:function(response) {
            var h = $("body").height() + 'px';
     $("#black_overlay").css({"height":h,"display":"block","z-index":"5"});
  //Put an animated GIF image insight of content
  $("#black_overlay").html('<center><table style="height:100%;"><tr><td valign="middle"><img src="images/loading2.gif"></td></tr></table></center>');
			 $("body").load("");
		 
        }
      });
	});
	
	$('.siz').click(function(){
		var size=this.name;
		psize=this.value;
		$('.siz').css({'border':'1px #ccc solid'});
		$(this).css({'border':'1px #000 solid'});
	});
	    
$('.cart').click(function(){
    
    
    $('.siz').css({'border':'1px #ccc solid'});
		$('.'+psize).css({'border':'1px #000 solid'});
    
    var wishid=$(this).parent().find('.wishid2').val();
      var wcode=$(this).parent().find('.pcodes').val();
	  var wcolor=$(this).parent().find('.pcolors').val();
	  var wsize=psize;
	  var wquan=1;
	  $.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          wishid:wishid,
          wcode:wcode,
          wcolor:wcolor,
          wsize:wsize,
		  wquan:wquan,
		  movetocart:"totalitems"
        },
        success:function(response) {
             $('#total_items').html(response);
            var h = $("body").height() + 'px';
     $("#black_overlay").css({"height":h,"display":"block","z-index":"5"});
  //Put an animated GIF image insight of content
  $("#black_overlay").html('<center><table style="height:100%;"><tr><td valign="middle"><img src="images/loading2.gif"></td></tr></table></center>');
			 
         
          $("body").load("");
        }
      });
	
    });
	$('#changepass').click(function(){
		$('#passdiv').toggle();
	});
	$('#changepassbtn').click(function(){
		var hidoldpass=$('#hidcurrentpass').val();
		var hidpassword  = hidoldpass.replace(/./g, '*');
		var oldpass=$('#currentpass').val();
		var password  = oldpass.replace(/./g, '*');
		var newpass=$('#newpass').val();
		var connewpass=$('#newconpass').val();
		if(password!=hidpassword){
			$('#passchangesuc').html('Wrong Old Password!! Try again..');
			$('#passchangesuc').css('color','red');
			$('#passchangesuc').css('display','block');
		}
		else if(newpass!=connewpass){
			$('#passchangesuc').html('New Passwords does not match!! Try again..');
			$('#passchangesuc').css('color','red');
			$('#passchangesuc').css('display','block');
		}else{
		$.ajax({
        type:'post',
        url:'ajax_data.php',
        data:{
          newpass:newpass,
		  changepass:"totalitems"
        },
        success:function(response) {
             
				 	$('#passchangesuc').html('Password changed successfully');
			$('#passchangesuc').css('color','green');
			$('#passchangesuc').css('display','block');
			 
        }
      });	
			
		}
	});
});
</script>
    
   
<?
require_once"footer.php";
?>