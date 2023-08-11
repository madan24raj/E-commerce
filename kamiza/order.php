<?
header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");
require_once "header.php";
$obj=new user();
extract($_REQUEST);
if(isset($ordid)){
$sql=$obj->getorderdetails($ordid);

?>
<style>


.bd{
	padding:2%;
	float-left
}
.bod{
	    
    width: 100%;
    
    float: left;
    border-top: 0;
}
.ddg{
	    padding: 24px 24px 12px 24px;
    vertical-align: top;
    min-height: 112px;
    -webkit-flex: 1 1;
    -ms-flex: 1 1;
    flex: 1 1;
    overflow: hidden;
}
</style>
<script>

</script>
<div class="wraper" style="background-color:#fff">
<div class="row" >
<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 bd " >
<div class="carthead p-2" style="background-color: #112655; color: #fff; float:left; width:100%;">
<div class="float-left"><h6 style="font-weight:bold;">Delivery Details</h6></div>

</div>

<div class="bod">
      <table class="table text-left">
     
       <tr><td> 
        
          <b>Name</b> &nbsp;
          </td><td><Label><?=$sql['cust_name']?></Label>
        </td></tr>
       
       <tr><td> 
          <b>Email ID</b> &nbsp;
        </td><td> <Label><?=$sql['Email']?></Label>
        </td></tr>
     <tr><td>  
          <b>Mobile</b>
          </td><td>  <Label><?=$sql['mobile']?></Label>
        </td></tr>
		
		<tr><td>
          <b>Address</b>&nbsp;
          </td><td>  <Label><?=$sql['shipping_address']?></Label>
        </td></tr>
		</table>
  </div>
  

</div>
<div class="col-lg-4 col-xl-5 col-md-12 col-sm-12 bd">
<div class="carthead p-2">
<h6 style="font-weight:bold;">ORDER DETAILS</h6>
</div>
<form method="post" action="PaytmKit/pgRedirect.php">
<div class="bod">
<input type="hidden" id="ORDER_ID" name="ORDER_ID" autocomplete="off" value="<?=$ordid?>">
<input type="hidden" id="CUST_ID" name="CUST_ID" autocomplete="off" value="<?=$sql['userid']?>">
<input type="hidden" id="INDUSTRY_TYPE_ID" name="INDUSTRY_TYPE_ID" autocomplete="off" value="RETAIL">
<input type="hidden" id="CHANNEL_ID" name="CHANNEL_ID" autocomplete="off" value="WEB">
<input type="hidden" id="TXN_AMOUNT" name="TXN_AMOUNT" autocomplete="off" value="<?=$sql['total_pay']?>">
<input type="hidden" id="CALLBACK_URL" name="CALLBACK_URL" autocomplete="off" value="https://www.kamizacollections.com/cart.php">


<table class="table text-center">
<tr>
<td><b>Order ID</b></td><td><?=$ordid?></td></tr>
<tr>
<td><b>Order Value</b></td><td><i  class="fa fa-inr"></i> <?=$sql['total_pay']?></td></tr>
</table>
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6  float-right"> 
<div class="p-2 float-right">
<input type="submit" name="place" id="place"  value="Make Payment Online" class="btn p-2" style="background-color: #3d3e65;color: #fff;font-weight: bold;">
</div>
</div>
</form>
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6  float-left"> 
<div class="p-2 float-right">
<input type="button" name="cod" id="cod"  value="Cash on Delivery" class="btn p-2" style="background-color: #3d3e65;color: #fff;font-weight: bold;">
</div>
</div>
</div>


</div>
</div>
</div>
<?}else{
echo "<script>window.location.href='cart.php';</script>";}?>
<footer>
<?require_once"footer.php";?>
</footer>
</body>
</html>