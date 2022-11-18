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
<link rel="stylesheet" href="js/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <title><?php echo siteTitle(); ?></title>
  <?php require "assets/autoloader.php" ?>
  <style type="text/css">
  <?php include 'css/customStyle.css'; ?>

  </style>

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
        <li role="presentation"><a href="index.php">Home</a></li>
        <li role="presentation"><a href="inventory.php">Inventory</a></li>
        <li role="presentation"><a href="addnew.php">Add New Items</a></li>
        <li role="presentation" class="active"><a href="reports.php">Reports</a></li>
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
<div class="marginLeft" >
  <div style="color:white;background:#3C8DBC;padding: 0px 0px 20px" >
    <div class="pull-right flex rightAccount" style="padding-right: 11px;padding: 7px;">
      <div><img src="photo/<?php echo $user['pic'] ?>" style='width: 41px;height: 33px;' class='img-circle'></div>
      <div style="padding: 8px"><?php echo ucfirst($user['name']) ?></div>
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
    <a href="profile.php"><button class="btn btn-default" style="border-radius:0">Profile</button>
    <a href="logout.php"><button class="btn btn-default pull-right" style="border-radius: 0">Sign Out</button></a>
  </div>
</div>
<div class="content2">
<ol class="breadcrumb ">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Reports</li>
</ol>
  <div class="tableBox" >
    <table id="dataTable" class="table table-bordered table-striped" style="z-index: -1">
      <thead>
        <th>#</th>
        <th>Name</th>
        <th>Contact</th>
        <th>Discount</th>
        <th>Total Item</th>
        <th>Amount</th>
        <th>Transaction by:</th>
        <th>Date</th>
        
      </thead>
     <tbody>
      <?php $i=0;
          $array = $con->query("select * from sold ORDER BY date DESC");
        while ($row = $array->fetch_assoc()) 
        { 
          $i=$i+1;
          $id = $row['id'];
        ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['contact']; ?></td>
            <td><?php echo $row['discount']; ?></td>
            <td><?php echo $row['item']; ?></td>
            <td><?php echo $row['amount']; ?></td>
            <td><?php echo getAdminName($row['userId']); ?></td>
            <td><?php echo $row['date']; ?></td>

            
          </tr>
      <?php
        }
       ?>
     </tbody>
    </table>
  </div>                      

  </div>  <!-- ending tag for content -->

</div> <!-- ending tag for margin left -->



</body>
</html>

<script type="text/javascript">
  function addInBill(id,place)
  { 
    var value = $("#counter").val();
    value ++;
    var selection = 'selection'+place;
    $("#bill").fadeIn();
    $("#counter").val(value);
    $("#"+selection).html("selected");
    $.post('called.php?q=addtobill',
               {
                   id:id
               }
        );

  }
  $(document).ready(function()
  {
    $(".rightAccount").click(function(){$(".account").fadeToggle();});
    $("#dataTable").DataTable();
   
  });
</script>

  <script src="js/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="js/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>