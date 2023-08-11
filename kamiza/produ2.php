<?php

require_once("header.php");
$obj=new user();
extract($_REQUEST);


if(isset($_SESSION['id'])){
	$wish=$obj->getwishlist();
}
if(isset($notify)){
	$obj->sendnotifymail();
}

if(isset($code) && isset($color)){
$size=$obj->getsize();
$sql2=$obj->getcolor($code);
$image=$obj->getnumberimages();
$noimages=1;
if($image['image2']!=NULL){$noimages+=1;}
if($image['image3']!=NULL){$noimages+=1;}
	$sql1=mysqli_fetch_assoc($obj->getproductbycolor($color));
	$catname=$obj->getcategoryname($sql1['Cat_id']);
	$catid=$sql1['Cat_id'];
	$subcatid=$sql1['Subcat_id'];
	$subname=$obj->getcategoryname($sql1['Subcat_id']);
	$subsubname=$obj->getcategoryname($sql1['Subsubcat_id']);
	$other=$obj->getotherproducts($code,$catid);
	}
?>
<style>



.don{
	list-style-type:none;
}
.don li{
	float:left;
	margin-right:5px;
}
.don label:hover{
border:1px solid #000;
}
.modal-open {
    padding-right: 0px !important;
}
body {
    padding-right: 0px !important;
}
#larg{
	    width: 100%;
    height: 400px;
    border: 1px solid #f5efef;
    padding: 2%;
}
</style>
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
		$('#'+psize).css({'border':'1px #000 solid'});
		}
	var color="<?=$color?>";
	var code="<?=$code?>";
	var action="stocksearch";
   
	var datastring={size:size,color:color,code:code,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			$('#hidstock').val(data);
			
		
			if(data<=0){
			   $("#notify").modal();
				   	$('#quan').val(0);
				$('#avail').css("display","block");
				
				$('#cart').attr('disabled','true');
				
			}else{
			  $('#avail').hide();
					$('#quan').val(1);
					$('#cart').removeAttr('disabled');
				
			}
		}
	    
	});
	
	
	
	
	
	
	$('.siz').click(function(){
		var size=this.name;
		
		psize=this.value;
		$('.siz').css({'border':'1px #ccc solid'});
		$(this).css({'border':'1px #000 solid'});
	var color="<?=$color?>";
	var code="<?=$code?>";
	var action="stocksearch";
   
	var datastring={size:size,color:color,code:code,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			
			$('#hidstock').val(data);
		
			if(data<=0){
				$('#nsize').val(size);
				$('#notifyhead').html('Notify me when '+size.toUpperCase()+' size is back in stock');
				$("#notify").modal();
			   	$('#quan').val(0);
				$('#avail').show();
				
				$('#cart').attr('disabled','true');
				
			}else{
					$('#avail').hide();
					$('#quan').val(1);
					$('#cart').removeAttr('disabled');
				
				
			}
		}
	    
	});
	    
	});


    $('#cart').click(function(){
		
		var cart = $('#cartimg');
		 var imgtodrag = $("body").find("#larg").eq(0);
		 
		 
		   if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
                .css({
                'opacity': '0.9',
                    'position': 'absolute',
                    'height': '350px',
                    'width': '350px',
                    'z-index': '100'
            })
                .appendTo($('body'))
                .animate({
                'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
            }, 1000, 'easeInOutExpo');
            
            setTimeout(function () {
                cart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                    'height': 0
            }, function () {
                $(this).detach()
            });
        }
		 
		 
		 
      var code=$('#prodcode').val();
	  var color=$('#prodcolor').val();
	  var size=psize;
	  var quan=$('#quan').val();
	  $.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          code:code,
          color:color,
          size:size,
		  quan:quan,
		  total_cart_items:"totalitems"
        },
        success:function(response) {
        setTimeout(function () {
                $("#total_items").html(response);
            }, 1500);  
        }
      });
	   $("body").scrollTop(0);
		$('#cart').attr('disabled','true');
    });

	$( ".nsiz" ).mouseover(function(e) {
		var names=$(e.target);
		var elId = names.attr('name');
		$('#nsize').val(elId);
				$('#notifyhead').html('Notify me when '+elId.toUpperCase()+' size is back in stock');
  $("#notify").modal();
});

	
	$("#wish").click(function(){
		<?if(!isset($_SESSION['id'])){?>
		$( ".register" ).trigger( "click" );
		
		<? }else{?>
var wimg=$('#imgwish');
		var pcode="<?=$code?>";
		var color=$('#prodcolor').val();
wimg.effect("shake", {
                    times: 2
                }, 200);
		var h = $("body").height() + 'px';
     $("#black_overlay").css({"height":h,"display":"block","z-index":"5"});
  //Put an animated GIF image insight of content
  $("#black_overlay").html('<center><table style="height:100%;"><tr><td valign="middle"><img src="images/loading2.gif"></td></tr></table></center>');
$.ajax({
      type:'post',
      url:'store_items.php',
      data:{
		 pcode:pcode,
		 color:color,
		 psize:psize,
        wishlist:"wishlist"
      },
      success:function(response) {
		


                $("body").load(""); 
            
 }
     });
  // Make AJAX call
		<?}?>
});
	});
</script>
<div class="w-100 text-left py-2" style="padding-left:5%;">
    <span style="font-size:12px;color:#007bff;"><?=$catname['Name']?> &raquo; <a style="color:#007bff!important;" href="products.php?id=<?=$subcatid?>"><?=$subname['Name']?></a> &raquo; <a style="color:#007bff!important;" href="products.php?id=<?=$subcatid?>&tab=<?=$subsubname['Name']?>"> <?=$subsubname['Name']?></a></span>

</div>
<div class="w-100 px-2">
<div class=" row">

<input type="hidden" id="prodcode" value="<?=$code?>" />
<input type="hidden" id="prodcolor" value="<?=$color?>" />
<div id="large" class="col-lg-4 col-xl-4 col-md-12 col-sm-12"  style="padding-left:4%;">

<img id="larg" src="images/Products/<?=$sql1['image1']?>" alt="item" style="width:375px;height:375px;" data-zoom-image="images/Products/<?=$sql1['image1']?>" />
<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 mx-auto float-left text-center">
<?
for($i=1;$i<=$noimages;$i++){
?>

<img align="center" class="id1"  src="images/Products/<?=$sql1['image'.$i.'']?>" style="width:64px; height:64px; margin:0 4%;">

<?}?>
</div>
<div style="width:253px;">
<button style="border:none;padding:15px 0px;float:right;" type="button" class="btn " data-toggle="modal" data-target="#dem"><img src="images/info-care.png" width="auto" border="0" /></button>
</div>
</div>
<div class="col-lg-8 col-xl-8 col-md-12 col-sm-12 float-left" id="ho" >

<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-2">
<div class="hname col-lg-6 col-xl-6 col-md-6 col-sm-6 float-left">
<span id="name"><?=$sql1['Name']?></span>
</div>
<div class=" col-lg-6 col-xl-6 col-md-6 col-sm-6 float-left p-2">
<?if(empty($wish)){?><button class="btn" id="wish" style="background-color:#fff;color:#113166;"><img src="images/add-Wishlist.png" width="auto;"></button><?}
else{?> 
<button class="btn" id="wish" style="background-color:#fff;color:#113166;"><img src="images/in-Wishlist.png" width="auto;"></button>
<?}?>
</div>

</div>
<div class="desc">
<div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 float-left">
<p style="color:#2d2e30;"><?=$sql1['Description']?></p>
</div>
<div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 float-left">
<div class="price">
<? echo '<i  class="fa fa-inr"></i> '.$sql1['Price']; ?>
</div>
</div>
</div>
<div style="border-bottom:1px dashed #000;width:80%;float:left;margin-left:25px;">
</div>




	
	
	




<!--Side wish-->

<div  class="col-lg-6 col-xl-6 col-md-12 col-sm-12 float-left" >
<div class="w-100 float-left p-2" >
<div class="w-100">
<div class="sz col-xl-12 col-lg-12 col-md-12 col-sm-12 float-left p-2" >
<div class="ele">SIZE  &nbsp; <? if(!empty($sql1['sizechart'])){?><button style="border:none;padding:0;float:right;" type="button" class="btn " data-toggle="modal" data-target="#myModal"><img src="images/Size-Chart.png" width="88px"></button><?}?></div>
<div class="p-2">
<?if($size['small']==0){?>
<input type="button" class="siz nsiz" id="S" style="background-color:#eee;"  name="small" value="S">
<?}else{?>
<input type="button" class="siz" id="S"  name="small" value="S">
<?}?>
<?if($size['medium']==0){?>
<input type="button" class="siz nsiz"  id="M" style="background-color:#eee;"  name="medium" value="M">
<?}else{?>
<input type="button" class="siz" id="M"  name="medium" value="M">
<?}?>
<?if($size['large']==0){?>
<input type="button" class="siz nsiz" id="L" style="background-color:#eee;"  name="large" value="L">
<?}else{?>
<input type="button" class="siz" id="L" name="large" value="L">
<?}?>
<?if($size['xlarge']==0){?>
<input type="button" class="siz nsiz"  id="XL" style="background-color:#eee;"  name="xlarge" value="XL">
<?}else{?>
<input type="button" class="siz" id="XL" name="xlarge" value="XL">
<?}?>
<?if($size['xxlarge']==0){?>
<input type="button" class="siz nsiz" id="XXL" style="background-color:#eee;"  name="xxlarge" value="XXL">
<?}else{?>
<input type="button" class="siz" id="XXL" name="xxlarge" value="XXL">
<?}?>
</div>
</div>
<div class="colorpk w-100 float-left" >
<span class="ele">COLOURS &nbsp;</SPAN>

<?$i=0;
while($s=mysqli_fetch_assoc($sql2)){
?>
<? if($s['colortype']==1){?>
	&nbsp;<a href="produ2.php?code=<?=$s['Prod_code']?>&color=<?=$s['color']?>"><img src="images/gradient.png" width="28" height="28"/>
</a>
<?}else{?>
&nbsp;<a href="produ2.php?code=<?=$s['Prod_code']?>&color=<?=$s['color']?>" style="background-color:<?=$s['color']?>;height:25px;border-radius:50%;border:1px #000 solid" class="btn color">
</a>
<?}?>
<?$i++;}?>
</div>


</div>
<div class="stock">

<div class="quan col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-3">
<div class="ele">QUANTITY</div>
    <div class="p-2 col-lg-6 col-xl-6 col-md-6 col-sm-6 float-left">
	<input type='button' value='-' class='qtyminus' field='quantity' />
    <input type='text' id="quan" name='quantity' value='1' class="qty text-center" readonly/>
	
    <input type='button' value='+' class='qtyplus' field='quantity' />
	</div>
	<input type="hidden" id="hidstock" />
	<div style="padding-left:2%;" id="avail" class="col-lg-6 col-xl-6 col-md-6 col-sm-6  float-left" ><img src="images/Sold-Out.png" width="120px"></div>
	</div>

	

	</div>
	<div class="ct">
	<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-2">
	<input type="button" id="cart" class="btn mx-auto" style="background-image:url('images/Add-Cart.png');width:150px;height:52px;" />
	</div>
	
</div>
</div>
</div>
</div>
</div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog w-100 float-left ">
      <div class="modal-content w-50 mx-auto float-right">
        
        
          
		  
			  <img src='images/Sizecharts/<?=$sql1['sizechart']?>' style='align:center;' width='800' /> 
		  
		 
		  
        
        
      </div>
    </div>
  </div>
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 float-left" >

</div>
  <div class="modal fade" id="dem">
    <div class="modal-dialog">
      <div class="modal-content">
      
        
        <!-- Modal body -->
        <div class="modal-body">
          <table class="table">
        <tr><td><b>Info & Care</b><br/>
		<?=$subname['infocare']?></td></tr>
        <tr><td style="font-size:14px;">
<b>Please Note:</b> <br/><i>Colours may slightly vary depending on your screen brightness</i></td></tr>
        </table>
        </div>
        
       
        
      </div>
    </div>
    </div>
	
	<div class="modal fade" id="notify" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content ">
      <div class="modal-header">
	   
          <h4 id="notifyhead" style="font-size:14px;" class="modal-title"></h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<form method="post">
		<input type="hidden" name="pcolor" value="<?=$color?>"/>
		<input type="hidden" name="pcode" value="<?=$code?>"/>
		<input type="hidden" name="psize" id="nsize"/>
         <div class="width_50" style="text-align:center; padding: 10px 0;"><input type="email" name="email" placeholder="Email" class="input_filed" required /></div>
		  <div class="width_50" style="text-align:center; padding: 10px 0;"><input type="submit" name="notify" value="Notify me" class="btn btn-primary" style="margin-top:5px;width: 50%;background-color:#007bff;"/></div>
		 </form>
        </div>
        
       
        
      </div>
    </div>
    </div>
	<div class="px-5">
 <div style="border-bottom:2px solid #000;width:100%;float:left;">
</div> 
</div>

<div class="thr float-left">
<h4 class="text-center">OTHER PRODUCTS</h4>

<?
while($others=mysqli_fetch_assoc($other)){
?>
<div class="col-lg-2 col-xl-2 col-md-4 sm float-left text-center p-2"  >
<a href="produ2.php?code=<?=$others['Prod_code']?>&color=<?=$others['color']?>">
<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-1 "  >
<div style="width:160px;height:160px;margin:0 auto;">
<img src="images/Products/<?=$others['image1']?>" width="100%" height="100%" class="p-2">
</div>
<div class="text-center col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-1">

<span style="font-size:16px;color:#757070;font-weight:bold;"><?=$others['Name']?></span>
<div style="font-size:16px;">
<? echo '<i  class="fa fa-inr"></i> <b>'.$others['Price'].'</b>'; ?>
</div>
</div>
</div>
</a>
</div>
<?}?>
 
</div>
<?require_once"footer.php";
?>



</body>
</html>

<script>
$(document).ready(function() {
      $('#avail').hide();
});
jQuery(document).ready(function(){
    $('.qtyplus').click(function(e){
		var hidstock=$('#hidstock').val();
        e.preventDefault();
        fieldName = $(this).attr('field');
        var currentVal = parseInt($('input[name='+fieldName+']').val());

        if (!isNaN(currentVal)) {
			if(hidstock>currentVal){
            $('input[name='+fieldName+']').val(currentVal + 1);
			}
        } else {
            $('input[name='+fieldName+']').val(1);
        }
    });
    $(".qtyminus").click(function(e) {
        e.preventDefault();
        fieldName = $(this).attr('field');
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        if (!isNaN(currentVal) && currentVal > 1) {
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            $('input[name='+fieldName+']').val(1);
        }
    });
});


$('.id1').click(function(event) {
    $('#larg').attr('src',this.src);
	$('#larg').data('zoom-image',this.src).elevateZoom({
    zoomType: "inner",
cursor: "crosshair",
zoomWindowFadeIn: 500,
zoomWindowFadeOut: 500
   });
});
  $('#larg').elevateZoom({
    zoomType: "inner",
cursor: "crosshair",
zoomWindowFadeIn: 500,
zoomWindowFadeOut: 500
   }); 
</script>