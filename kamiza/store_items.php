<?php
  session_start();
require_once "Database/clsuser.php";
$obj=new user();
 extract($_REQUEST);
  if(isset($_POST['headercart']) && isset($_POST['total_cart_items']) && isset($_SESSION['cart'])){
	echo count($_SESSION['cart']);
} 
if(isset($_POST['headercart']) && isset($_POST['total_cart_items']) && !isset($_SESSION['cart'])){
	echo "0";
}

if(isset($_POST['movewishlist'])){
    $no=mysql_num_rows($obj->getwishlist2($pcode,$pcolor));
	  if(empty($no)){
	  $sql=$obj->addwishlist($pcode,$psize,$pcolor);
	  $max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($_POST['pcode']==$_SESSION['cart'][$i]['prodcode']  && $_POST['pcolor']==$_SESSION['cart'][$i]['color'] && $_POST['psize']==$_SESSION['cart'][$i]['size'] ){
				unset($_SESSION['cart'][$i]);
				$_SESSION['cart']=array_values($_SESSION['cart']);
				echo count($_SESSION['cart']);
				exit();
			}
		}
	 }
}
if(isset($_POST['removewishlist'])){
    $no=$obj->deletewishlist($wishid);
	 exit();
}
  if(isset($_POST['code']) && !isset($_POST['cartquan']) )
  {
	  if(isset($_SESSION['cart'])){
			
			$max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
				if($_POST['code']==$_SESSION['cart'][$i]['prodcode'] && $_POST['color']==$_SESSION['cart'][$i]['color'] && $_POST['size']==$_SESSION['cart'][$i]['size'] ){
					$_SESSION['cart'][$i]['quan']=$_POST['quan'];
					echo count($_SESSION['cart']);
					exit();
				}
			}
			
			$_SESSION['cart'][$max]['prodcode']=$_POST['code'];
			$_SESSION['cart'][$max]['size']=$_POST['size'];
			$_SESSION['cart'][$max]['color']=$_POST['color'];
			$_SESSION['cart'][$max]['quan']=$_POST['quan'];
			echo count($_SESSION['cart']);
		}else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['prodcode']=$_POST['code'];
			$_SESSION['cart'][0]['size']=$_POST['size'];
			$_SESSION['cart'][0]['color']=$_POST['color'];
			$_SESSION['cart'][0]['quan']=$_POST['quan'];
			echo count($_SESSION['cart']);
  }
  }
  
  

 
  
  
  if(isset($_POST['cartquan'])){
	  $max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
				if($_POST['code']==$_SESSION['cart'][$i]['prodcode'] && $_POST['color']==$_SESSION['cart'][$i]['color'] && $_POST['size']==$_SESSION['cart'][$i]['size'] ){
					$_SESSION['cart'][$i]['quan']=$_POST['quan'];
					echo count($_SESSION['cart']);
					exit();
				}
			}
  }
  
  if(isset($_POST['pcode'])){
	  $max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($_POST['pcode']==$_SESSION['cart'][$i]['prodcode']  && $_POST['pcolor']==$_SESSION['cart'][$i]['color'] && $_POST['psize']==$_SESSION['cart'][$i]['size'] ){
				unset($_SESSION['cart'][$i]);
				$_SESSION['cart']=array_values($_SESSION['cart']);
				echo count($_SESSION['cart']);
				exit();
			}
		}
	    }

  if(isset($_POST['showcart']))
  {
    for($i=0;$i<count($_SESSION['src']);$i++)
    {
      echo "<div class='cart_items'>";
      echo "<img src='".$_SESSION['src'][$i]."'>";
      echo "<p>".$_SESSION['name'][$i]."</p>";
      echo "<p>".$_SESSION['price'][$i]."</p>";
      echo "</div>";
    }
    exit();	
  }
  
    if(isset($_POST['wishlist'])){
	  $no=mysql_num_rows($obj->getwishlist2($pcode,$color));
	  if(empty($no)){
	  $sql=$obj->addwishlist($pcode,$psize,$color);
	 }
	 else{
		  $obj->delwishlist($pcode,$color);
	  }
				}
				
				
				if(isset($_POST['movetocart']) )
  {
      $obj->deletewishlist($wishid);
	  if(isset($_SESSION['cart'])){
			
			$max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
				if($_POST['wcode']==$_SESSION['cart'][$i]['prodcode'] && $_POST['wcolor']==$_SESSION['cart'][$i]['color'] && $_POST['wsize']==$_SESSION['cart'][$i]['size'] ){
					$_SESSION['cart'][$i]['quan']=$_POST['wquan'];
					echo count($_SESSION['cart']);
					exit();
				}
			}
			
			$_SESSION['cart'][$max]['prodcode']=$_POST['wcode'];
			$_SESSION['cart'][$max]['size']=$_POST['wsize'];
			$_SESSION['cart'][$max]['color']=$_POST['wcolor'];
			$_SESSION['cart'][$max]['quan']=$_POST['wquan'];
			echo count($_SESSION['cart']);
		}else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['prodcode']=$_POST['wcode'];
			$_SESSION['cart'][0]['size']=$_POST['wsize'];
			$_SESSION['cart'][0]['color']=$_POST['wcolor'];
			$_SESSION['cart'][0]['quan']=$_POST['wquan'];
			echo count($_SESSION['cart']);
  }
  
  }
	
  
 
?>
