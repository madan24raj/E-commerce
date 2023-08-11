<?
require_once"clsdatabase.php";

class user extends database
{

function user()
{
parent::database();

}

function registration(){
		extract($_REQUEST);
		$chk=mysqli_num_rows(mysqli_query($GLOBALS['mysqli'],"SELECT * FROM users where Email='$email' or Mobile='$mob'"));
		if(empty($chk)){
			
			mysqli_query($GLOBALS['mysqli'],"insert into users (`Name`, `Gender`, `Email`, `Password`, `Mobile`, `Address`,`Area`, `City`,`State`,`Pincode`) values 
				('$name','$gender','$email','$pass','$mob','$add','$area','$city','$state','$pincode')");
//$ccode="91";			
//$mobile=$ccode.$mob;		

$mobileNumber = $mob;

$senderId = "KAMIZA";

$message = urlencode("Thanks for registering with Kamiza Collections!!! Visit https://www.kamizacollections.com for more informations.");

$route = 4;

//Prepare you post parameters
$postData = array(
    'mobiles' => $mobileNumber,
    'message' => $message,
    'sender' => $senderId,
    'route' => $route
);

$url="http://api.msg91.com/api/v2/sendsms";


$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "$url",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_HTTPHEADER => array(
        "authkey: 162903A2TkFdCFiE595252a7",
        "content-type: multipart/form-data"
    ),
));

$response = curl_exec($curl);

$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}


header('Location:register.php?suc=msg');
}
else{
	header('Location:register.php?err=msg');
}
}
function selectuser($id){
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"SELECT * from users where Id='$id'"));
	return $sql;
}
function addcoupons(){
	extract($_REQUEST);
	mysqli_query($GLOBALS['mysqli'],"INSERT INTO coupons(`coupon_code`,`percent`,`isactive`) values('$ccode','$cpercent',1)");
	header('Location:add-coupon.php?ins=suc');
}
function updreward(){
	extract($_REQUEST);
	mysqli_query($GLOBALS['mysqli'],"update users set reward_points='$reward' where Id='$hidid' ");
	header('Location:view-user.php?upd=reward');
}
function getstates($id){
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"SELECT * from states where Id='$id'"));
	return $sql;
}
function states()
	{
		$sql=mysqli_query($GLOBALS['mysqli'],"select * from states");
		while($res=mysqli_fetch_assoc($sql)){
			$index=$res['Id'];
			$sts[$index]=$res['States'];
		}
		return $sts;
	}
	function generateorder(){
		$ord.='KM';
$yr=date('y');
$ord.=$yr;
$no=rand(0000,9999);
$ord.=$no;
return $ord;
	}
	function sendnotifymail(){
		extract($_REQUEST);

		$headers .= 'From: Kamiza Collections <kamizacollections.com>' . "\r\n"; 
		$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$to      = 'info@kamizacollections.com'; // Send email to our user
$subject = 'Notify when stock is available'; // Give the email a subject 
$message .= "
<b>Email id </b>: $email <br><br>
<b>Product Code </b> : $pcode <br><br>
<b>Color </b> : <span style='height:35px;width:30px;border:1px #000 solid; border-radius:50%;background-color:#$pcolor'>&nbsp; &nbsp; &nbsp; &nbsp;</span> - #$pcolor <br><br>
<b>Size </b>: $psize <br> 
<br><br>"; 
mail($to, $subject, $message, $headers); 
		echo "<script>window.location='produ2.php?code=".$code."&color=".$color."&not=email';</script>";
	}
		
	
function login(){
	extract($_REQUEST);
	$usrnm=mysqli_real_escape_string($username);
	$pas=mysqli_real_escape_string($password);
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"select Id,Name,Email from users where Email='$usrnm' and Password='$pas'"));
	if(!empty($sql['Id'])){
		session_start();
		$_SESSION['id']=$sql['Id'];
		$_SESSION['name']=$sql['Name'];
		$_SESSION['email']=$sql['Email'];
		if(strpos($_SERVER['PHP_SELF'],"register.php")!=false){header('Location:index.php?suc=msg');}else{
		header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
		}
	}
	else{
		header('Location:index.php?logs=err');
	}
}



function getcategory()
	{
		$sql=mysqli_query($GLOBALS['mysqli'],"select * from category where c_id=0 and s_id=0");
		while($res=mysqli_fetch_assoc($sql)){
			$index=$res['Id'];
			$sts[$index]=$res['Name'];
		}
		return $sts;
	}
function getsubcategory($catid)
{
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from category where c_id='$catid' and s_id=0");
	return $sql;
}
function updateinfo()
{
	extract($_REQUEST);
	$sql=mysqli_query($GLOBALS['mysqli'],"UPDATE category  SET `infocare`='$updinfo' where Id='$hidsubid' ");
	return $sql;
}	
function getsubsubcategory($catid)
{
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from category where s_id='$catid'");
	return $sql;
}
function getcategoryname($id){
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"select * from category where Id='$id'"));


	return $sql;
		
	}
function updateprofile(){
	extract($_REQUEST);
	mysqli_query($GLOBALS['mysqli'],"update users set `Name`='$name',`Gender`='$gender',`Address`='$address',`Area`='$area',`City`='$city',`Pincode`='$pincode',`State`='$state' where `Id`='".$_SESSION['id']."' ");
	echo "<script>window.location.href='wishlist.php?profupd=suc';</script>";
}
function getproductsearch($prtcode,$catid){
	$whr="";
	if($prtcode!=""){
		if($whr==""){
		$whr.="where Prod_code like '%".$prtcode."%'";
		}
		else{
			$whr.="and Prod_code like '%".$prtcode."%'";
		}
	}
	if($catid!=0){
		if($whr==""){
		$whr.="where Cat_id =".$catid."";
		}else{
			$whr.="and Cat_id =".$catid."";
		}
	}
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from product  ".$whr." order by Cat_id ASC");
	return $sql;
}
function getusersearch($username,$email){
	$whr="";
	if($username!=""){
		if($whr==""){
		$whr.="where Name like '%".$username."%'";
		}
		else{
			$whr.="and Name like '%".$username."%'";
		}
	}
	if($email!=""){
		if($whr==""){
		$whr.="where ((Email like '%".$email."%') or (Mobile like '%".$email."%')) ";
		}else{
			$whr.="and ((Email like '%".$email."%') or (Mobile like '%".$email."%'))";
		}
	}
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from users  ".$whr." order by Name ASC");
	return $sql;
}		
function admin($username,$password)
{

extract($_REQUEST);
$sql=mysqli_query($GLOBALS['mysqli'],"SELECT * FROM  admin WHERE `Userid`='$username' and `Password`='$password'" );
if(mysqli_num_rows($sql) > 0){
echo "<script>window.location='index.php?log=err';</script>";


}
else{
	session_start();
	$_SESSION['admin']=$username;
echo "<script>window.location='add-product.php';</script>";
}
}
function checkemail($email){
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from users where Email='$email' ");
	return $sql;
}
function checkmob($mobile){
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from users where Mobile='$mobile' ");
	return $sql;
}
function getallproducts(){
	extract($_REQUEST);
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from product order by Cat_id ASC");
	return $sql;
}
function getproductbycode(){
	extract($_REQUEST);
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from product where Prod_code = '$prtcode'");
	return $sql;
}
function getproductbyid($id){
	extract($_REQUEST);
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"select * from product where Id = '$id'"));
	return $sql;
}
function getotherproducts($code,$catid){
	extract($_REQUEST);
	$sql=mysqli_query($GLOBALS['mysqli'],"SELECT p.*,st.* from product p left outer join stock st ON st.prod_code=p.Prod_code where p.Prod_code!='$code' and p.Cat_id='$catid' order by RAND() LIMIT 6");
	return $sql;
}
function getrandproducts(){
	extract($_REQUEST);
	$sql=mysqli_query($GLOBALS['mysqli'],"SELECT p.*,st.* from product p left outer join stock st ON st.prod_code=p.Prod_code  order by RAND() LIMIT 8 ");
	return $sql;
}
function getstockbycode($code){
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from stock where prod_code='$code'");
	return $sql;
}
function delstock(){
	extract($_REQUEST);
	mysqli_query($GLOBALS['mysqli'],"delete from stock where id='$did'");
	echo "<script>window.location='update-product.php?id=".$pid."&stockdel=del';</script>";
}
function updstock(){
	extract($_REQUEST);
	$color=ltrim($colors,"#");
	$img=$image1;
	$imgbg1=$image2;
	$imgbg2=$image3;
if($_FILES['img1']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['img1']['tmp_name'];
	$img=$uniqueid.$_FILES['img1']['name'];
	move_uploaded_file($tempfile,"../images/Products/".$img);
	}
	if($_FILES['img2']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['img2']['tmp_name'];
	$imgbg1=$uniqueid.$_FILES['img2']['name'];
	move_uploaded_file($tempfile,"../images/Products/".$imgbg1);
	}
	if($_FILES['img3']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['img3']['tmp_name'];
	$imgbg2=$uniqueid.$_FILES['img3']['name'];
	move_uploaded_file($tempfile,"../images/Products/".$imgbg2);
	}
	mysqli_query($GLOBALS['mysqli'],"update stock set color='$color',`image1`='$img',`image2`='$imgbg1',`image3`='$imgbg2',`small`='$small',`medium`='$medium',`large`='$large',`xlarge`='$xlarge',`xxlarge`='$xxlarge' where id='$stid'");
	echo "<script>window.location='update-product.php?id=".$pid."&stockupdsuc=del';</script>";
}
function getstock($size,$color,$code){
	extract($_REQUEST);
	
	$sql=mysqli_query($GLOBALS['mysqli'],"select ".$size." as size  from stock where color='$color' and prod_code='$code'");
	return $sql;
}
function addcategory(){
	extract($_REQUEST);
	$sql=mysqli_query($GLOBALS['mysqli'],"insert into category(`Name`,`c_id`,`s_id`,`infocare`) values ('$name','$cat','$sub','$infocare')");
echo "<script>window.location='add-category.php?suc=ins';</script>";
	
}
function getorderdetails($ordid){
	extract($_REQUEST);
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"select us.Email,ord.* from orders ord left outer join users us on us.Id=ord.userid where ord.ord_id='$ordid' "));
	return $sql;
}
function updateproduct(){
	extract($_REQUEST);
	$sizecharts=$hidsizechart;
	if($_FILES['sizechart']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['sizechart']['tmp_name'];
	$sizecharts=$uniqueid.$_FILES['sizechart']['name'];
	move_uploaded_file($tempfile,"../images/Sizecharts/".$sizecharts);

	}
	$sql=mysqli_query($GLOBALS['mysqli'],"update product set `Prod_code`='$prtcode',`Name`='$prtname',`Cat_id`='$cat',`Subcat_id`='$sub',`Subsubcat_id`='$subsub',`sizechart`='$sizecharts',`Description`='$desc',`Price`='$price' where Id='$id'"); 
	echo "<script>window.location='update-product.php?id=".$id."&suc=upd';</script>";
}
function getallcategories(){
	$sql="select ca.Id as catid,IFNULL(cat.Id,c.Id) as subid,IF(IFNULL(cat.Name,c.Name)=c.Name,0,c.Id) as subsubid,c.Id as ID,ca.Name as Category,IFNULL(cat.Name,c.Name) as sub,IF(IFNULL(cat.Name,c.Name)=c.Name,NULL,c.Name) as subsub  from category ca left join category c on c.c_id=ca.Id left join category cat on c.s_id=cat.Id  where c.c_id!=0 order by catid,subsub,sub";
	$xsql=mysqli_query($GLOBALS['mysqli'],$sql);
	return $xsql;
}
function getmainbanners(){
  
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from banner where type=1 order by Id DESC") or die("error"); 
	return $sql;
}
function getsmallbanners(){
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from banner where type=2 order by Id DESC");
	return $sql;
}
function getsize(){
	extract($_REQUEST);
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"select small,medium,large,xlarge,xxlarge from stock where prod_code='$code' and color='$color'"));
	return $sql;
}
function getsizes($code,$color){
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"select small,medium,large,xlarge,xxlarge from stock where prod_code='$code' and color='$color'"));
	return $sql;
}

function getnumberimages(){
	extract($_REQUEST);
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"select image1,image2,image3 from stock where prod_code='$code' and color='$color'"));
	return $sql;
}
function getcoupon($ccode){
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from coupons where coupon_code='$ccode' and isactive=1");
	return $sql;
}
function couponactive(){
	extract($_REQUEST);
	if($active==1){$act=0;}else{$act=1;}
	mysqli_query($GLOBALS['mysqli'],"update coupons set isactive='$act' where Id='$id'");
	echo "<script>window.location='add-coupon.php?upd=act';</script>";
}
function delbanner(){
	extract($_REQUEST);
	$sql=mysqli_query($GLOBALS['mysqli'],"delete from banner where Id='$id'");
	echo "<script>window.location='add-banner.php?suc=del';</script>";
}
function delcoupon(){
	extract($_REQUEST);
	$sql=mysqli_query($GLOBALS['mysqli'],"delete from coupons where Id='$cid'");
	echo "<script>window.location='add-coupon.php?suc=del';</script>";
}
function delproduct(){
	extract($_REQUEST);
	$sql=mysqli_query($GLOBALS['mysqli'],"delete from product where Id='$id'");
	$sql=mysqli_query($GLOBALS['mysqli'],"delete from stock where prod_code='$pcode'");
	echo "<script>window.location='view-product.php?suc=del';</script>";
}
function delcategory(){
	extract($_REQUEST);
	$whr=($ssid==0)?"":"and p.Subsubcat_id='$ssid' ";
	//echo "delete p,st from product p inner join stock st where st.prod_code=p.Prod_code and p.Cat_id='$cid' and p.Subcat_id='$sid' ".$whr." ";
	mysqli_query($GLOBALS['mysqli'],"delete p,st from product p inner join stock st where st.prod_code=p.Prod_code and p.Cat_id='$cid' and p.Subcat_id='$sid' ".$whr." ");
	mysqli_query($GLOBALS['mysqli'],"delete c,ca from  category c inner join category ca where ca.s_id=c.Id and c.Id='$id' ");
	mysqli_query($GLOBALS['mysqli'],"delete from category where c_id='$cid' and Id='$id'");
	//echo "delete p,st from product p inner join stock st where st.prod_code=p.Prod_code and p.Cat_id='$cid' and p.Subcat_id='$sid' ".$whr." ";
   
//echo "delete  c,ca from category c inner join category ca where ca.s_id=c.Id and c.Id='$id' ";
mysqli_query($GLOBALS['mysqli'],"delete from category  where s_id='$sid' and Id='$id' ");
echo "<script>window.location='add-category.php?suc=del';</script>";
}
function addstock(){
	extract($_REQUEST);
	$color=ltrim($colors,"#");
	if($colortype==1){
		$color='multi';
	}	
	$img='';
	$imgbg1='';
	$imgbg2='';
	
if($_FILES['img1']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['img1']['tmp_name'];
	$img=$uniqueid.$_FILES['img1']['name'];
	move_uploaded_file($tempfile,"../images/Products/".$img);
	}
	if($_FILES['img2']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['img2']['tmp_name'];
	$imgbg1=$uniqueid.$_FILES['img2']['name'];
	move_uploaded_file($tempfile,"../images/Products/".$imgbg1);
	}
	if($_FILES['img3']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['img3']['tmp_name'];
	$imgbg2=$uniqueid.$_FILES['img3']['name'];
	move_uploaded_file($tempfile,"../images/Products/".$imgbg2);
	}
	 $sql="INSERT INTO stock(`prod_code`,`small`,`medium`,`large`,`xlarge`,`xxlarge`,`color`,`colortype`,`Image1`,`Image2`,`Image3`) values ('$prtcode','$small','$medium','$large','$xlarge','$xxlarge','$color','$colortype','$img','$imgbg1','$imgbg2')";
	 $xsql=mysqli_query($GLOBALS['mysqli'],$sql);
	 echo "<script>window.location='add-product.php?suc=add';</script>";
}
function addbanner($type){
	extract($_REQUEST);
	if($_FILES['img1']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['img1']['tmp_name'];
	$img=$uniqueid.$_FILES['img1']['name'];
	move_uploaded_file($tempfile,"../images/Banner/".$img);
	}
	$sql="INSERT INTO banner(`image`,`linkurl`,`type`) values('$img','$url','$type')";
	$xsql=mysqli_query($GLOBALS['mysqli'],$sql);
	echo "<script>window.location='add-banner.php?suc=add';</script>";
}

function addwishlist($code,$size,$color){
	$id=$_SESSION['id'];
	$sql=mysqli_query($GLOBALS['mysqli'],"insert into wishlist(`user_id`,`prod_code`,`color`,`size`,`created`) values ('$id','$code','$color','$size',now())");
	return $sql;
}
function getwishlist(){
	extract($_REQUEST);
	$id=$_SESSION['id'];
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"select * from wishlist where user_id='$id' and prod_code='$code' and color='$color'"));
	return $sql;
}
function getwishlist2($code,$color){
	$id=$_SESSION['id'];
	$sql=mysqli_query($GLOBALS['mysqli'],"select * from wishlist where user_id='$id' and prod_code='$code' and color='$color'");
	return $sql;
}
function getfullwishlist(){
	extract($_REQUEST);
	$id=$_SESSION['id'];
	$sql=mysqli_query($GLOBALS['mysqli'],"select wl.color as CL,wl.*,p.Price,p.Name,st.* from wishlist wl left outer join product p on p.Prod_code=wl.prod_code left outer join stock st on st.prod_code=wl.prod_code and st.color=wl.color where wl.user_id='$id'");
	return $sql;
}
function delwishlist($code,$color){
	$id=$_SESSION['id'];
	$sql=mysqli_query($GLOBALS['mysqli'],"delete from wishlist where user_id='$id' and prod_code='$code' and color='$color'");
	return $sql;
}
function deletewishlist($wishid){
	
	mysqli_query($GLOBALS['mysqli'],"delete from wishlist where Id='$wishid' ");
	
}
function getcart($code,$color){
	$sql=mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],"select p.Name,p.Price,st.image1 from product p left outer join stock st on st.prod_code=p.Prod_code where p.Prod_code='$code' and st.color='$color' "));
	return $sql;
}

function insert_prt()
{

extract($_REQUEST);
$sizecharts='';
if($_FILES['sizechart']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['sizechart']['tmp_name'];
	$sizecharts=$uniqueid.$_FILES['sizechart']['name'];
	move_uploaded_file($tempfile,"../images/Sizecharts/".$sizecharts);
	}
$sql="INSERT INTO product (`Prod_code`,`Name`,`Cat_id`,`Subcat_id`,`Subsubcat_id`,`sizechart`,`Description`,`Price`) VAlUES('$prtcode','$prtname','$cat','$sub','$subsub','$sizecharts','$desc','$price')";
 $xsql=mysqli_query($GLOBALS['mysqli'],$sql);
 $color=ltrim($colors,"#");
 if($colortype==1){
		$color='multi';
	}
$img='';
	$imgbg1='';
	$imgbg2='';
	$sizecharts='';
if($_FILES['img1']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['img1']['tmp_name'];
	$img=$uniqueid.$_FILES['img1']['name'];
	move_uploaded_file($tempfile,"../images/Products/".$img);
	}
	if($_FILES['img2']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['img2']['tmp_name'];
	$imgbg1=$uniqueid.$_FILES['img2']['name'];
	move_uploaded_file($tempfile,"../images/Products/".$imgbg1);
	}
	if($_FILES['img3']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['img3']['tmp_name'];
	$imgbg2=$uniqueid.$_FILES['img3']['name'];
	move_uploaded_file($tempfile,"../images/Products/".$imgbg2);
	}
	
 $sql="INSERT INTO stock(`prod_code`,`small`,`medium`,`large`,`xlarge`,`xxlarge`,`color`,`colortype`,`image1`,`image2`,`image3`) values ('$prtcode','$small','$medium','$large','$xlarge','$xxlarge','$color','$colortype','$img','$imgbg1','$imgbg2')";
 $xsql=mysqli_query($GLOBALS['mysqli'],$sql);
 echo "<script>window.location='add-product.php?suc=add';</script>";
}

function getproduct($code){
	extract($_REQUEST);
	$sql="SELECT p.*,st.*,count(color) as numcolors from product p left outer join stock st ON st.prod_code=p.Prod_code where p.Prod_code='$code' LIMIT 1 ";
	$sql1=mysqli_query($GLOBALS['mysqli'],$sql);
	return $sql1;
}
function getproductbycolor($color){
	extract($_REQUEST);
	$sql="SELECT p.*,st.*,count(color) as numcolors from product p left outer join stock st ON st.prod_code=p.Prod_code where st.color='$color' and st.prod_code='$code' ";
	//echo $sql;
	$sql1=mysqli_query($GLOBALS['mysqli'],$sql);
	return $sql1;
}
function getproductsbycategory($id){
	extract($_REQUEST);
extract($_REQUEST);
	/*$sql=mysqli_query($GLOBALS['mysqli'],"SELECT p.*,
      (SELECT st.image1
       FROM stock as st
       WHERE p.Prod_code = st.prod_code
       LIMIT 1) as image1,(SELECT st1.color from stock as st1 where p.Prod_code=st1.prod_code LIMIT 1) as color
FROM product p where p.Subcat_id='$id' ");*/
$sql=mysqli_query($GLOBALS['mysqli'],"select p.*,st.image1 as image1,st.color as color from product p left join stock st on st.prod_code=p.Prod_code where p.Subcat_id='$id' order by RAND()");
	return $sql;
}
function getproductsbysubsub($id1){
	extract($_REQUEST);
	
$sql=mysqli_query($GLOBALS['mysqli'],"select p.*,st.image1 as image1,st.color as color from product p left join stock st on st.prod_code=p.Prod_code where p.Subsubcat_id='$id1' order by RAND()");
	return $sql;
}
function getcolor($code)
{
	extract($_REQUEST);
	$sql="SELECT p.Id,p.Prod_code,st.color as color,st.colortype as colortype from product p left outer join stock st ON st.prod_code=p.Prod_code where p.Prod_code='$code'";
	$sql1=mysqli_query($GLOBALS['mysqli'],$sql);
	return $sql1;
}


function insert_cat()
{
extract($_REQUEST);
$sql1=mysqli_query($GLOBALS['mysqli'],"SELECT * FROM category where cat_name='$catnameng' ");
$cnt=mysqli_num_rows($sql1);
if($cnt== 0)
{
$sql="INSERT INTO category (`cat_name`,`Cat_tml`) VALUES ('$catnameng','$catnamtam')";
$xsql=mysqli_query($GLOBALS['mysqli'],$sql);
$msg="Category Added....";
}
else
{
$msg="This Name Already Exist....";
}
return $msg;
}

function sel_cat()
{
 $sql=mysqli_query($GLOBALS['mysqli'],"SELECT * FROM category")or die(mysqli_error());
return $sql;
}

function upd_cat()
{
extract($_REQUEST);
$upd=mysqli_query($GLOBALS['mysqli'],"UPDATE category SET cat_name='$updt', Cat_tml='$updtm' WHERE Id='$id' ");
return $upd;
}

function del_cat()
{
extract($_REQUEST);
$del=mysqli_query($GLOBALS['mysqli'],"DELETE FROM category WHERE  Id='$id'");

}



function sel_prt()
{
$sql=mysqli_query($GLOBALS['mysqli'],"SELECT * FROM product");
return $sql;
}

function up_prt()
{
extract($_REQUEST);


if($_FILES['smlimg']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['smlimg']['tmp_name'];
	$img=$uniqueid.$_FILES['smlimg']['name'];
	move_uploaded_file($tempfile,"../Images/Small/".$img);
	}
else{

$img=$_REQUEST['oldimg'];
}	

	if($_FILES['bgimg1']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['bgimg1']['tmp_name'];
	$imgbg1=$uniqueid.$_FILES['bgimg1']['name'];
	move_uploaded_file($tempfile,"../Images/Big/".$imgbg1);

	}
	else
	{
$imgbg1=$_REQUEST['oldimg1'];
	}
	if($_FILES['bgimg2']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['bgimg2']['tmp_name'];
	$imgbg2=$uniqueid.$_FILES['bgimg2']['name'];
	move_uploaded_file($tempfile,"../Images/Big/".$imgbg2);

	}
	else
	{
	$imgbg2=$_REQUEST['oldimg2'];
	}
	
	
	if($_FILES['bgimg3']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['bgimg3']['tmp_name'];
	$imgbg3=$uniqueid.$_FILES['bgimg3']['name'];
	move_uploaded_file($tempfile,"../Images/Big/".$imgbg3);

	}
else
	{
$imgbg3=$_REQUEST['oldimg3'];
	}
	
	if($_FILES['bgimg4']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['bgimg4']['tmp_name'];
	$imgbg4=$uniqueid.$_FILES['bgimg4']['name'];
	move_uploaded_file($tempfile,"../Images/Big/".$imgbg4);

	}
else
	{
	$imgbg4=$_REQUEST['oldimg4'];
	}	

	if($_FILES['bgimg5']['size']>0)
	{
	$uniqueid=time();
	$tempfile=$_FILES['bgimg5']['tmp_name'];
	$imgbg5=$uniqueid.$_FILES['bgimg5']['name'];
	move_uploaded_file($tempfile,"../Images/Big/".$imgbg5);

	}
else
	{
	$imgbg5=$_REQUEST['oldimg5'];
	}
	
$sql="UPDATE product SET Name='$prtname', Tml_name='$catnamtam', Cat_id= '$catgry', Discription='$des', Price='$price',Smallimg='$img',Bigimage1='$imgbg1',Bigimage2='$imgbg2',
Bigimage3='$imgbg3',Bigimage4='$imgbg4',Bigimage5='$imgbg5' WHERE Id='$id'";
$xec=mysqli_query($GLOBALS['mysqli'],$sql);
return $xec;
}




}

?>