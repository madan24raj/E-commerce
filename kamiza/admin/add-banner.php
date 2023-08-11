<?
require_once "headeradmin.php";
$obj=new user();
extract($_REQUEST);
$main=$obj->getmainbanners();
$small1=$obj->getsmallbanners();
if(!isset($_SESSION['admin'])){
header('Location:index.php');
}

if(isset($del)){
	$obj->delbanner();
}
if(isset($submit)){

		$obj->addbanner(1);
	}
	if(isset($small)){

		$obj->addbanner(2);
	}

?>
<style>
.pd{
	float:left;
	padding:2%;
}

</style>


<div style="width:80%;margin:0 auto;">
<ul class="nav nav-pills pt-2 nav-fill">
         <li class="nav-item text-left">
        <a class="nav-link active" id="nav" data-toggle="tab" href="#main" role="tab"><b>Main Banner</b></a>
    </li>
	<li class="nav-item text-left">
        <a class="nav-link" id="nav" data-toggle="tab" href="#small" role="tab"><b>Small Banner</b></a>
    </li>
</ul>
<div class="tab-content">
<div role="tabpanel" class="tab-pane in active" id="main">
<form action="#" method="post" enctype="multipart/form-data">

<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">
<div><b>Select Image</b><i style="color:blue;font-size:12px;">(1200x500)</i></div>
 <input type="file" class='mt-2' name="img1"  required/> 
</div>
<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">
<div><b>Link URL</b></div>
<input type="text" name="url"  class="input_filed"  /> 

</div>
 
<div class=" col-xl-4 col-lg-4 col-md-12 col-sm-12 pd "><div></div><br/><input type="submit" name="submit" class="btn btn-primary mt-1" value="Submit"/>  </div>

</form>


<div style="width:100%;float:left;">
<table class="table">
<tr>
<th align="center" width="5%">#</th>
<th align="center" width="30%">Image</th>
<th align="center" width="50%">Link URL</th>
<th align="center" width="5%">Action</th>
</tr>
<?$count=1; 
while($ban=mysqli_fetch_assoc($main)){?>
<tr>
<td><?=$count?></td>
<td><img src="../images/Banner/<?=$ban['image']?>" width="300px"></td>
<td><?=$ban['linkurl']?></td>
<td><a href="add-banner.php?id=<?=$ban['Id']?>&del=ban">Delete</a>
</tr>
<? $count++;}?>
</table>
</div>
</div>

<div role="tabpanel" class="tab-pane" id="small">
<form action="#" method="post" enctype="multipart/form-data">
<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">
<div><b>Select Image</b><i style="color:blue;font-size:12px;">(450x250)</i></div>
 <input type="file" class='mt-2' name="img1"  required/> 
</div>
<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">
<div><b>Link URL</b></div>
<input type="text" name="url"  class="input_filed"  /> 

</div>
 
<div class=" col-xl-4 col-lg-4 col-md-12 col-sm-12 pd "><div></div><br/><input type="submit" name="small" class="btn btn-primary mt-1" value="Submit"/>  </div>

</form>


<div style="width:100%;float:left;">
<table class="table">
<tr>
<th align="center" width="5%">#</th>
<th align="center" width="30%">Image</th>
<th align="center" width="50%">Link URL</th>
<th align="center" width="5%">Action</th>
</tr>
<?$count=1; 
while($ban=mysqli_fetch_assoc($small1)){?>
<tr>
<td><?=$count?></td>
<td><img src="../images/Banner/<?=$ban['image']?>"  width="300px"></td>
<td><?=$ban['linkurl']?></td>
<td><a href="add-banner.php?id=<?=$ban['Id']?>&del=ban">Delete</a>
</tr>
<? $count++;}?>
</table>
</div>
</div>
</div>
</div>

</body>
</html>
