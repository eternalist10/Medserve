<?php
session_start();
if(!isset($_SESSION['userId']))
{
  header('location:login.php');
}
 ?>
<?php require "assets/function.php" ?>
<?php require 'assets/db.php';?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo siteTitle(); ?></title>
  <?php require "assets/autoloader.php" ?>
  <style type="text/css">
  
  .button{
  background-color: #000000; /* Green */
  font-family: 'Bahnschrift';
  border: none;
  color: white;
  width:100%;
  padding: 15px 20px 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 25px;
  margin: 0px 0px;
  cursor: pointer;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
}
  #button1:hover {
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
    position: fixed;
  bottom: -4x;
  right: 10px;
  }

  <?php include 'css/customStyle.css'; ?>
  </style>
  <?php 
  $notice="";
  if (isset($_POST['safeIn'])) 
  {
    $filename = $_FILES['inPic']['name'];
    move_uploaded_file($_FILES["inPic"]["tmp_name"], "photo/".$_FILES["inPic"]["name"]);
    if ($con->query("insert into categories (name,pic) value ('$_POST[name]','$filename')")) {
      $notice ="<div class='alert alert-success'>Successfully Saved</div>";
    }
    else
      $notice ="<div class='alert alert-danger'>Not saved Error:".$con->error."</div>";
  }

   ?>
</head>
<body style="background: #ECF0F5;padding:0;margin:0">
<div class="dashboard" style="position: fixed;width: 18%;height: 100%;background:#ccd7db">
  <div style="background:#3C8DBC;padding: 10.3px 3px;color:white;font-size: 25pt;text-align: left ;padding: 10px 14px 10px;text-shadow: 1px 1px 8px black">
    <a href="index.php" style="color: white;text-decoration: none; font-family:'Bahnschrift'"><?php echo strtoupper(siteName()); ?> </a>
  </div>
  <div>
    <div style="background:#ffffff;color: black;padding: 14px 8px;border-left: 3px solid #000000;"><span><i class="fa fa-dashboard fa-fw"></i> Dashboard</span></div>
    <div class="nav-item">
    <ul class="nav nav-pills blue nav-stacked">
        <li role="presentation" class="active"><a href="index.php">Home</a></li>
        <li role="presentation"><a href="inventory.php">Inventory</a></li>
        <li role="presentation"><a href="addnew.php">Add New Items</a></li>
        <li role="presentation"><a href="reports.php">Reports</a></li>
    </ul>
    </div>
  </div><br>
    <div style="background:#ffffff;color: black;padding: 14px 8px;border-left: 3px solid #000000;"><span><i class="fa fa-globe fa-fw"></i> Other Menu</span></div>
    <div class="nav-item">
      <ul class="nav nav-pills nav-stacked">
      <li role="presentation"><a href="profile.php">Profile Settings</a></li>
      <li role="presentation"><a href="accountSetting.php">Account Settings</a></li>
      </ul>
    </div>
</div>
<div class="marginLeft">
  <div style="color:white;background:#3C8DBC;padding: 0px 0px 20px">
    <div class="pull-right flex rightAccount" style="padding-right: 11px;padding: 7px;">
      <div><img src="photo/<?php echo $user['pic'] ?>" style='width: 100%;height: 33px;' class='img-circle'></div>
      <div style="padding: 8px; color:black"><?php echo ucfirst($user['name']) ?></div>
    </div>
    <div class="clear"></div>
  </div>
<div class="account" style="display: none;z-index: 6">
  <div style="background: #3C8DBC;padding: 22px;" class="center">
    <img src="photo/<?php echo $user['pic'] ?>" style='width: 100px;height: 100px; margin:auto;' class='img-circle img-thumbnail'>
    <br><br>
    <span style="font-size: 13pt;color:#CEE6F0"><?php echo $user['name'] ?></span><br>
    <span style="color: #CEE6F0;font-size: 10pt">Member Since:<?php echo $user['date']; ?></span>
  </div>
  <div style="padding: 11px;">
    <a href="profile.php"><button class="btn btn-default" style="border-radius:5">Profile</button>
    <a href="logout.php"><button class="btn btn-default pull-right" style="border-radius: 5">Sign Out</button></a>
  </div>
</div>
<div class="content2">
    <?php echo $notice; ?>
    <div style="margin-left:auto;">
      <span style="font-size: 16pt; color: #333333; font-family:'Bahnschrift'"><b>CATEGORIES</b></span>
      <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#addIn" style="margin-left: 10px; background-color:red; border-color:red"><i class="fa fa-plus fa-fw"></i>Add New Category</button> 
      <a href="manageCat.php"><button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#addIn" style="margin-left: 5px"><i class="fa fa-gear fa-fw"> </i> Manage Categories</button></a>
    </div>
</div>
  <?php 
    $array = $con->query("select * from categories");
    while ($row = $array->fetch_assoc()) 
    {
      $array2 = $con->query("select count(*) from inventeries where catId = '$row[id]'");
      $row2 = $array2->fetch_assoc();
  ?>
    <a href="inventory.php?catId=<?php echo $row['id'] ?>"><div class="box2 col-md-3">
     <div class="center"> <img src="photo/<?php echo $row['pic'] ?>" style="width: 100%;height: 187px;" class='img-thumbnail'></div>
      <hr style="margin: 7px;">
      <span style="padding: 11px; font-color: black"><strong style="font-size: 10pt ;font-family:'Bahnschrift Light';"><b>Name</b></strong><span class="pull-right" style="color:blue;margin-right: 11px;"><?php echo $row['name'] ?></span></span>
      <hr style="margin: 7px;">
      <span style="padding: 11px"><strong style="font-size: 10pt; font-family:'Bahnschrift Light'"><b>Available Qty</b></strong><span class="pull-right" style="color:blue;margin-right: 11px"><?php echo $row2['count(*)']; ?></span></span>
    </div></a>
  <?php
    }
   ?>
  </div>
</div>

<div id="addIn" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Inventory</h4>
      </div>
      <div class="modal-body"> <form method="POST" enctype="multipart/form-data">
        <div style="width: 77%;margin: auto;">
         
          <div class="form-group">
            <label for="some" class="col-form-label">Name</label>
            <input type="text" name="inName" class="form-control" id="some" required>
          </div>
          <div class="form-group">
            <label for="2" class="col-form-label">Picture</label>
            <input type="file" name="inPic" class="form-control" id="2" required>
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="safeIn">Save Inventory</button>
      </div>
    </form>
    </div>

  </div>
</div>
</body>
</html>

<script type="text/javascript">
  $(document).ready(function(){$(".rightAccount").click(function(){$(".account").fadeToggle();});});
</script>