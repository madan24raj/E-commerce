<?
ob_start();

require_once"header.php";
$obj=new user();
$states=$obj->states();
$rewards='0.00';
if(isset($_SESSION['id'])){
$sql=$obj->selectuser($_SESSION['id']);
$rewards=$sql['reward_points'];
$address=$sql['Address']." ".$sql['City']." ".$sql['Pincode'];

}
if(isset($_SESSION['cart'])){
$max=count($_SESSION['cart']);
$items=0;
			for($i=0;$i<$max;$i++){
					$items+=$_SESSION['cart'][$i]['quan'];
					
				}

}else{
$max=0;
}

?>
<style>
@media(max-width:500px)
{
	.ddg{
	    padding: 2px 24px 12px 24px;
	}
}
@media(max-width:500px)
{
	#nxt{
	   float:left!important;
	}
}
.pan{
	float:left;
	padding:10px;
}

.bd{
	padding:2%;
	float:left;
}
.bod{
    padding:0 2%;
    width: 100%;
    border-bottom: 1px dashed #ccc;
    float: left;

}
.ddg{
	    padding: 20px 24px 12px 24px;
    vertical-align: top;
    
    -webkit-flex: 1 1;
    -ms-flex: 1 1;
    flex: 1 1;
    overflow: hidden;
}



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
<script>

	
$(function(){
	$('#applycoupon').click(function(){
		var ccode=$('#ccode').val();
		var ordprice=$('#ordprice').val();
		var neword="";
		var rewardhid=$('#rewardhid').val();
		var action="checkcoupon";
		$.ajax({
        type:'post',
        url:'ajax_data.php',
        data:{
          ccode:ccode,
          action:action
        },
        success:function(response) {
			if(response){
				neword=(ordprice-rewardhid-(ordprice*(response/100))).toFixed(2);
				var discount=(ordprice*(response/100)).toFixed(2);
				$('#labeldiscount').html(discount);
				$('#ordprice').val(neword);
				$('#labelorder').html(neword);
				$('#succoupon').html('Coupon Code Applied!!');
				$('#succoupon').css('color','green');
				$('#succoupon').show();
$('#ccode').hide();
$('#applycoupon').hide();
			}else{
				$('#succoupon').html('Invalid Coupon Code!!');
				$('#succoupon').css('color','red');
				$('#succoupon').show();

			}
		 
        }
      });
		
	});
	
	$('.remove').click(function(){
	    $('.paramsg').html('Are you sure want to remove this item from the cart?');
	    $(this).parent().find('.cm').modal('show');
		
	});
	$('#log').click(function(){
			$( ".register" ).trigger( "click" );
	});
	$('.del').click(function(){
	    $('.cm').modal('hide');
		var pcode=$(this).parent().find('.pcode').val();
		var pcolor=$(this).parent().find('.pcolor').val();
		var psize=$(this).parent().find('.psize').val();
		$.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          pcode:pcode,
          pcolor:pcolor,
          psize:psize,
		  total_cart_items:"totalitems"
        },
        success:function(response) {
            var h = $("body").height() + 'px';
     $("#black_overlay").css({"height":h,"display":"block","z-index":"5"});
  //Put an animated GIF image insight of content
  $("#black_overlay").html('<center><table style="height:100%;"><tr><td valign="middle"><img src="images/loading2.gif"></td></tr></table></center>');
			 $("body").load("");
          $('#total_items').html(response);
		 }
      });
	});
	
	$('.wishlist').click(function(){
		<?if(!isset($_SESSION['id'])){?>
		$( ".register" ).trigger( "click" );
		
		<? }else{?>
	    $('.paramsg2').html('Are you sure want to move this item to the wishlist?')
	    $(this).parent().find('.cm2').modal('show');
		<?}?>
	});
	$('.del2').click(function(){
	     $('.cm2').modal('hide');
		var pcode=$(this).parent().parent().find('.pcode').val();
		var pcolor=$(this).parent().parent().find('.pcolor').val();
		var psize=$(this).parent().parent().find('.psize').val();
		$.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          pcode:pcode,
          pcolor:pcolor,
          psize:psize,
		  movewishlist:"wishlist"
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
});
jQuery(document).ready(function(){
	
    $('.qtyplus').click(function(e){
		
		var hidstock=$(this).parent().find('.hidstocks').val();
		var code=$(this).parent().find('.pcode').val();
		var size=$(this).parent().find('.psize').val();
		var color=$(this).parent().find('.pcolor').val();
		
		
        e.preventDefault();
        fieldName = $(this).attr('field');
        var currentVal = parseInt(  $(this).parent().find('.quan').val());

        if (!isNaN(currentVal)) {
			if(hidstock>currentVal){
            $(this).parent().find('.quan').val(currentVal + 1);
			}
        } else {
            $(this).parent().find('.quan').val(1);
        }
		var quan=$(this).parent().find('.quan').val();

		 $.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          code:code,
          size:size,
          quan:quan,
          color:color,
		  cartquan:"carquan"
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
    $(".qtyminus").click(function(e) {
		var code=$(this).parent().find('.pcode').val();
		var size=$(this).parent().find('.psize').val();
		var color=$(this).parent().find('.pcolor').val();
        e.preventDefault();
        fieldName = $(this).attr('field');
        var currentVal = parseInt($(this).parent().find('.quan').val());
        if (!isNaN(currentVal) && currentVal > 1) {
            $(this).parent().find('.quan').val(currentVal - 1);
        } else {
            $(this).parent().find('.quan').val(1);
        }
		var quan=$(this).parent().find('.quan').val();
		 $.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          code:code,
          size:size,
          quan:quan,
          color:color,
		  cartquan:"carquan"
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

	 $("#place").click(function() {
		 
		 	$('.clu').hide();
		 <? if(isset($_SESSION['id'])){?>
		 $('.open').show("slide", { direction: "right" }, 600);
		$('.tw2').show("slide", { direction: "right" }, 600);
		 <?}else{?>
		 	$('.open').show("slide", { direction: "right" }, 600);
			$('#on1').show();
			
			
		 <?}?>
		 $(this).hide();
			$('.admore').hide();
			  $("body").scrollTop(0);
	 });
	 $("#backcart").click(function() {
		 <?if(isset($_SESSION['id'])){?>
		 $('.open').hide();
		 $('.clu').show("slide",{direction:"left"},600);
		 $('#place').show();
		 $('.admore').show();
		 <?}else{?>
		 $('.open').hide();
		 $('#tw2').hide();
		 $('.open').show("slide", { direction: "left" }, 600);
		 $('#on1').show();
		 <?}?>
	 });
	 $("#prev").click(function() {
		 $('.open').hide();
		  $('.clu').show("slide",{direction:"left"},600);
		 $('#place').show();
		 $('.admore').show();
	 });
		 });
</script>
<div class="wraper" style="background-color:#fff">
<div class="row" style="margin: 20px 0;">
<div class="clu col-lg-6 col-xl-7 col-md-12 col-sm-12 bd">
<div class="carthead p-2" style="background-color: #112655; color: #fff; float:left; width:100%;">
<div class="float-left" style="width:35%;"><h6 style="font-weight:bold;">Items (<span id="carttotal"><?=$items?></span>)</h6></div>
<div class="float-left" style="width:65%;font-weight:bold; text-align:right;">Total Payable: <i  class="fa fa-inr"></i> <span id="totalpay">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span></div>

</div>
<?$totalsum=0;
$arr=array("S"=>'small',"M"=>'medium',"L"=>'large',"XL"=>'xlarge',"XXL"=>'xxlarge');
if(empty($max)){?>
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 bd text-center float-left">
<img src="images/cartempty.png" width="auto" />

</div>
<?}else{
for($i=0;$i<$max;$i++){
	
	$code=$_SESSION['cart'][$i]['prodcode'];
	$size=$_SESSION['cart'][$i]['size'];
	$color=$_SESSION['cart'][$i]['color'];
	$quan=$_SESSION['cart'][$i]['quan'];
	if(isset($_SESSION['id'])){
	$wish=mysqli_fetch_assoc($obj->getwishlist2($code,$color));
}
	$det=$obj->getcart($code,$color);
	$stock=mysqli_fetch_assoc($obj->getstock($arr[$size],$color,$code));
	$totalsum=$totalsum+($det['Price']*$quan);
	?>
<div class="bod">
<div class="col-xl-2 col-lg-2 col-md-2 col-4 bd float-left">
<img src="images/Products/<?=$det['image1']?>" width="100px" height="100px" />
</div>
<div class="col-xl-10 col-lg-10 col-md-10 col-8 ddg pr-0 float-left">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 float-left p-2">
<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 float-left">
<span style="font-size:0.9rem;"><?=$det['Name']?> &nbsp; 
	</span>
	</div>
	<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 float-left"><span style="color:#000;font-size:15px;"><? echo '<i  class="fa fa-inr"></i> '.$det['Price'].'  x  '.$quan ?></span> 
</div>
<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 float-right"> <span style="color:#000;font-size:15px;font-weight:bold;"><? echo '<i  class="fa fa-inr"></i> '.$det['Price']*$quan ?></span></div>
</div>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 float-left p-2">
<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 float-left pt-2">	
<span >SIZE -</span><span style="color:#8a7a7a;font-weight:bold;">  <?=$size?> </span></br>
</div>
<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 px-0 float-left pt-2">
 <div class="">
    <input type='button' value='-' class='qtyminus' field='quantity' />
    <input type='text' name='quantity' value=<?=$quan?> class="qty quan text-center" readonly/>
	<input type='button' value='+' class='qtyplus' field='quantity' />
	
	<input type="hidden" class="hidstock" value="5"/>
<input type="hidden" class="pcode" name="pcode" value="<?=$code?>"/>
<input type="hidden" class="pcolor" name="pcolor" value="<?=$color?>"/>
<input type="hidden" class="psize" name="psize" value="<?=$size?>"/>
<input type="hidden" class="pquan" name="pquan" value="<?=$quan?>"/>
<input type="hidden" class="hidstocks" name="hidstocks" value="<?=$stock['size']?>"/>
    </div> 
<div class="p-2 hidd">
<input type="hidden" class="pcode" name="pcode" value="<?=$code?>"/>
<input type="hidden" class="pcolor" name="pcolor" value="<?=$color?>"/>
<input type="hidden" class="psize" name="psize" value="<?=$size?>"/>
<input type="hidden" class="pquan" name="pquan" value="<?=$quan?>"/>
</div>
</div>
</div>
</div>


<div class="col-xl-12 col-lg-12 col-md-12 col-12  float-right">
<div class="col-xl-5 col-lg-5 col-md-5 col-5  float-right">
<input type="hidden" class="pcode" name="pcode" value="<?=$code?>"/>
<input type="hidden" class="pcolor" name="pcolor" value="<?=$color?>"/>
<input type="hidden" class="psize" name="psize" value="<?=$size?>"/>
<input type="hidden" class="pquan" name="pquan" value="<?=$quan?>"/>
<input type="button" name="rmv" class="remove btn" value="Remove Item"  style="background-color: #3d3e65;color: #fff;font-weight: bold;padding:5px;margin-left:32px;margin-bottom:10px;">
<div id="confirmmodel" class="modal fade cm">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
		
			<div class="modal-body">
				<p style="color:#000;font-size:16px;text-align:center;" class='paramsg' id="paramsg"></p>
			</div>
			<div class="modal-footer">
			    <input type="hidden" class="pcode" name="pcode" value="<?=$code?>"/>
<input type="hidden" class="pcolor" name="pcolor" value="<?=$color?>"/>
<input type="hidden" class="psize" name="psize" value="<?=$size?>"/>
<input type="hidden" class="pquan" name="pquan" value="<?=$quan?>"/>
				<div style="float:left;width:70%"><button type="button" class="btn btn-info" data-dismiss="modal">No</button></div>
				<button type="button" class="del btn btn-danger">Yes</button>
			</div>
		</div>
	</div>
</div> 
</div>
<div class="col-xl-7 col-lg-7 col-md-7 col-7  float-right">
<?if(empty($wish)){?><span class="wishlist btn"  style="background-color:#fff;color:#113166;"><img src="images/add-Wishlist.png" width="auto;"></span>
<div id="confirmmodel2" class="modal fade cm2">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
		
			<div class="modal-body">
				<p style="color:#000;font-size:16px;text-align:center;" class="paramsg2" id="paramsg2"></p>
			</div>
			<div class="modal-footer">
			    <input type="hidden" class="pcode" name="pcode" value="<?=$code?>"/>
<input type="hidden" class="pcolor" name="pcolor" value="<?=$color?>"/>
<input type="hidden" class="psize" name="psize" value="<?=$size?>"/>
<input type="hidden" class="pquan" name="pquan" value="<?=$quan?>"/>
				<div style="float:left;width:70%"><button type="button" class="btn btn-info" data-dismiss="modal">No</button></div>
				<button type="button" class="del2 btn btn-danger">Yes</button>
			</div>
		</div>
	</div>
</div><?}
else{?> 
<span class="btn"  style="background-color:#fff;color:#113166;"><img src="images/in-Wishlist.png" width="auto;"></span>
<?}?>
</div>
</div>
</div>

<!---Confirm remove Modal--->


<!---Confirm remove Modal--->

<?}}?>

</div>

<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 bd  open" style="display:none;">


<div class="bod bl">
      
     <form method="post" action="order.php" id="form">
	<div  id="on1" style="display:none;">
	<div class="carthead ca"  style="background-color: #112655; color: #fff; float:left;padding:1%; width:100%;">
<h5 style="font-weight:bold;">Register Your Details</h5>
</div>
     <div class="width_100" style="text-align:center; padding: 0px 0;">
   

	<span class="width_100" id="errcart" style="color:red">Please Enter all Details</span>

</div>
        <div class="col-lg-6 col-xl-6 col-md-6 pan mx-auto">
		
           <input type="text" class="input_filed" id="name" name="name" value="<?=$sql['Name']?>" placeholder="Name"/>
        </div>
		 <div class="col-lg-6 col-xl-6 col-md-6 py-4 pan mx-auto">
<input type="radio" class="gender" name="gender" value="Male" checked /> Male &nbsp; &nbsp; 
<input type="radio" name="gender" value="Female"/> Female &nbsp; &nbsp; 
<input type="radio" name="gender" value="Others"/> Others
</div>
        <div class="col-lg-6 col-xl-6 col-md-6 pan mx-auto">
        <input type="text" class="input_filed" id="email" name="email" value="<?=$sql['Email']?>" placeholder="Email"  />
        </div>
        <div class="col-lg-6 col-xl-6 col-md-6 pan mx-auto"  >
         <input type="text" class="input_filed" id="mobile" pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[6789]\d{9}$" title="Enter Valid mobile number"  name="mob" value="<?=$sql['Mobile']?>" placeholder="Mobile"  />
        </div>
		<div class="col-lg-6 col-xl-6 col-md-6 pan mx-auto">
         
          <input type="password" class="input_filed" id="pass" name="password" value=""  placeholder="Password" />
        </div>
		<div class="col-lg-6 col-xl-6 col-md-6 pan mx-auto">
         
          <input type="password" class="input_filed" id="cpass"  name="password" value=""  placeholder="Confirm Password"  />
        </div>
	
		<div class="col-lg-3 col-xl-3 col-md-3 pan p-2 mx-auto"  >
          <input type="button" class="btn p-2"  style="background-color:#09634e;color:#fff;" id="prev" value="Review Items"  />
          
          
        </div>
		<div class="col-lg-3 col-xl-3 col-md-3 float-right pan p-2 mx-auto"  >
         
          <input type="button" class="btn p-2 float-right"  style="background-color:#3d3e65;color:#fff;" id="nxt" value="Continue"  />
         
        </div>
		
		  <div class="col-lg-6 col-xl-6 text-center col-md-6 pan p-3 mx-auto"  >
            <a  href="#" id="log">Already a user? Login</a>
        </div>
  </div>

   <div class="tw2" id="tw2" style="display:none;">
  <div class="carthead ca" style="background-color: #112655; color: #fff; float:left;padding:1%; width:100%;">
<h5 style="font-weight:bold;">Shipping Details</h5>
</div>
<div class="width_100" style="text-align:center; padding: 0px 0;">
   

	<span class="width_100" id="errcart2" style="color:red;font-weight:none;">Please Enter all Details</span>

</div>
		<div id="lv">
		
		<div class="col-lg-6 col-xl-6 col-md-6 pan float-left" >
		<input type="hidden" id="hideid" name="hideid" value="<?=$sql['Id']?>" />
          <input id="dname" type="text" class="input_filed" name="dname" value="<? if(isset($_SESSION['id'])){echo $sql['Name'];} ?>"  placeholder="Customer Name"  />
        </div>
		<div class="col-lg-6 col-xl-6 col-md-6 pan float-left">
          
          <input type="text" class="input_filed" id="mobile2" name="mobile" value="<? if(isset($_SESSION['id'])){echo $sql['Mobile'];} ?>" placeholder="Mobile"   />
		  </div>
        <div class="col-lg-6 col-xl-6 col-md-6 pan float-left" >
         
          <input id="address" type="text" class="input_filed" name="address" value="<?=$sql['Address']?>"  placeholder="Door no / Street"  />
        </div>
       
        <div class="col-lg-6 col-xl-6 col-md-6 pan float-left">
          
          <input type="text" id="area" class="input_filed" name="area" value="<?=$sql['Area']?>" placeholder="Area"   />
        </div>
        <div class="col-lg-6 col-xl-6 col-md-6 pan float-left">
         
          <input type="text" id="city" class="input_filed" name="city" value="<?=$sql['City']?>" placeholder="City"    />
        </div>
	      <div class="col-lg-6 col-xl-6 col-md-6 pan float-left">
          
          <input id="pincode" type="text" class="input_filed" name="pincode" value="<?=$sql['Pincode']?>" placeholder="Pincode"   />
        </div>
        <div class="col-lg-6 col-xl-6 col-md-6  pan float-left">
          <select name="state" class="input_filed" id="state"  >
<option value="">Select State</option>
<? foreach($states as $key=>$val){
	$sel="";
	if($sql['State']==$key){$sel="selected";}
echo '<option value="'.$key.'" '.$sel.'>'.$val.'</option>';	
}?>
</select>
		  </div>
			
		   
		  <div class="col-lg-12 col-xl-12 col-md-12 pan p-3 float-left mx-auto"  >
		  <? 
if($rewards>=$totalsum){
	$rewards=$totalsum;
}
 $total=$totalsum-$rewards-$discount;
	?>
         <input type="hidden" name="ordprice" id="ordprice" value="<?=$total?>"/>
         <input type="hidden" name="hideorderid" id="hideorderid" />
         <input type="hidden" name="rewardhid" id="rewardhid" value="<?=$rewards?>" />
		 <?if (isset($_SESSION['id'])){?>
		 <input type="button" class="btn btn-warning p-2" style="background-color:#09634e;color:#fff;float:left;" id="backcart" name="backcart" value="Review Items" />
		 <?}else{?>
		 <input type="button" class="btn btn-warning p-2" style="background-color:#09634e;color:#fff;float:left;" id="backcart" name="backcart" value="Edit Details" />
		 <?}?>
          <input type="button" class="btn p-2" id="plorder"  style="background-color:#3d3e65;color:#fff;float:right;;" name="placeorder" value="Proceed"  />
		  
        </div>
		   </div>
   </div>
   </form>
</div>
</div>
<div id="pl" class="col-lg-4 col-xl-5 col-md-12 col-sm-12 bd">
<div class="carthead p-2">
<h6 style="font-weight:bold;">PRICE DETAILS</h6>
</div>
<div class="bod">
<table class="table text-center">
<tr><td align="left"><input type="text" style="width:90%;" class="input_filed" placeholder="Apply Discount Coupon" name="ccode" id="ccode"/><BR/><span style="display:none;color:green;" id="succoupon"></span> </td><td colspan="2" align="left"><input type="button" id="applycoupon" class="btn btn-success mt-2" style="background-color:#28a745;" value="Apply"/></td></tr>
<tr><td align="left">Product Value</td><td align="right"><i  class="fa fa-inr"></i> </td><td align="right" ><?=round($totalsum*(.9525),2) ?></td></tr>
<tr><td align="left">GST @ 5%</td><td align="right"><i  class="fa fa-inr"></i> </td><td align="right"><?=round($totalsum*(.0475),2) ?></td></tr>
<tr><td align="left"><b>Total Amount</b></td><td align="right"><i  class="fa fa-inr"></i> </td><td align="right"> <b><span id="totsum"><?=round($totalsum,2).'.00' ?></span></b></td></tr>
<tr><td align="left">Reward Points</td><td align="right"><i  class="fa fa-inr"></i> </td><td align="right" >-<?=$rewards ?></td></tr>
<tr><td align="left">Discount</td><td align="right"> <i  class="fa fa-inr"></i></td><td align="right" >-<span id="labeldiscount">0.00</td></tr>

<tr><td align="left"><b>Total Payable</b></td><td align="right"><i  class="fa fa-inr"></i> </td><td align="right"> <b><span id="labelorder"><?=round($total,2).'.00' ?></span></b></td></tr>	
 
</table>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12  pl-2  float-left"> 

<div class="p-2 float-right" style="width:30%;">
<? if(!empty($max)){?>
<input type="button" name="place" id="place"  value="Place Order" class="btn p-2" style="background-color: #3d3e65;color: #fff;font-weight: bold;">

<?}?>
</div>

<div class="p-2 w-50 float-right">
<a class="float-left pt-2 admore" href="index.php"><img src="images/add-more.png"></a>
</div>
</div>
</div>

</div>
</div>
</div>


<script>
$(function(){
	var emailflag=0;
	var mobflag=0;
	var pinflag=0;
	var hidid=0;
	$('#totalpay').html($('#totsum').html());
	$('#name').keyup(function(e) {
		var cname=$(this).val();
		$('#dname').val(cname);
	});
	$('#mobile').keyup(function(e) {
		var cmob=$(this).val();
		$('#mobile2').val(cmob);
	});
$('#pincode').keyup(function(e) {
		var pincode = $(this).val();
	if(pincode.length == 6 && $.isNumeric(pincode)) {
		$('#pincode').css('border','1px solid #a1a3a3');
		pinflag=0;
	}
	else{
		$("#pincode").css('border','2px solid #ff0000');
		pinflag=1;
	}
	});
	$('#email').keyup(function(e) {
		var email=$(this).val();
		 $.ajax({
        type:'post',
        url:'ajax_data.php',
        data:{
          email:email,
		  checkemail:"check"
        },
        success:function(response) {
            if(response==1){
				$("#email").css('border','2px solid #ff0000');
				emailflag=1;
			}else{
				$('#email').css('border','1px solid #a1a3a3');
				emailflag=0;
			}
        }
      });
	});
	
	$('#mobile').keyup(function(e) {
		var mobile=$(this).val();
		 $.ajax({
        type:'post',
        url:'ajax_data.php',
        data:{
          mobile:mobile,
		  checkmob:"check"
        },
        success:function(response) {
            if(response==1){
				$("#mobile").css('border','2px solid #ff0000');
				mobflag=1;
			}else{
				$('#mobile').css('border','1px solid #a1a3a3');
				mobflag=0;
			}
        }
      });
	});
	$('#cpass').keyup(function(e) {
		var password=$("#pass").val();
		var cpassword=$(this).val();
		if(password!=cpassword){
		$('#cpass').css('border','2px solid #ff0000');
		}
		else{
			$('#cpass').css('border','1px solid #a1a3a3');
		}
	});
$('#nxt').click(function(){
var name = $("#name").val();
var email = $("#email").val();
var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
var mobile = $("#mobile").val();
var pass=$('#pass').val();
var cpass=$('#cpass').val();

if (emailflag==1) {
$('#errcart').html("This Email is already registered");
}
else if( name=='' || email == '' || mobile=='' || pass=='' || cpass==''){
	$('#errcart').html("Please fill all the details");
}
else if(!filter.test(email)){
	$('#errcart').html("Please enter a valid Email ID");
}
else if (mobflag==1) {
$('#errcart').html("This Mobile is already registered");

}else if(pass!=cpass){
	$('#errcart').html("Password does not match");
	
}

else if(mobile.length != 10 || !$.isNumeric(mobile)){
$('#errcart').html("Please Enter Valid Mobile");
}
		else{
			$('.open').hide();
			  $('#on1').hide();
		$('.open').show("slide", { direction: "right" }, 600);
		$('#tw2').show();
		}
});
$('#plorder').click(function(){
var name = $("#name").val();
var email = $("#email").val();
var mobile = $("#mobile").val();
var dname=$("#dname").val();
var gender=$('.gender').val();	
var pass=$('#pass').val();
var address = $("#address").val();
var area = $("#area").val();
var city = $("#city").val();
var pincode = $("#pincode").val();
var state = $("#state").val();
var mobile2 = $("#mobile2").val();
var ordprice=$("#ordprice").val();
var userid=$("#hideid").val();
if(area=='' || address=='' || city=='' || pincode=='' || state=='' || mobile2==''){
	$('#errcart2').html("Please Enter all Details");
}
else if(pinflag==1){
	$('#errcart2').html("Please Enter Valid Pincode");
}else{
	<? if(!isset($_SESSION['id'])){?>
	 $.ajax({
        type:'post',
        url:'ajax_data.php',
        data:{
          name:name,
          email:email,
		  gender:gender,
		  pass:pass,
		  address:address,
		  area:area,
		  city:city,
		  pincode:pincode,
		  state:state,
		  mobile:mobile,
		  register:"check"
        },
        success:function(response) {
            $.ajax({
        type:'post',
        url:'ajax_data.php',
        data:{
         email:email,
		 pass:pass,
		 login:"checking"
        },
        success:function(response) {
			
			$('#hideid').val(response);
			userid=response;
        }
        
		});
		}
		
	 });
	 
	
	  <?}?>
	   
	    
	  
	setTimeout(function(){ $.ajax({
        type:'post',
        url:'ajax_data.php',
        data:{
			dname:dname,
			mobile2:mobile2,
           address:address,
		  area:area,
		  city:city,
		  pincode:pincode,
		  state:state,
		  ordprice:ordprice,
		  userid:userid,
		 order:"checking"
        },
        success:function(response) {
			$("hideorderid").val(response);
			window.location.href='order.php?ordid='+response;
        }
        
		}); }, 300);
	 
	 

}
});
});
</script>


<footer>
<?require_once"footer.php";?>
</footer>
</body>
</html>