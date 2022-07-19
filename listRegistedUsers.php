<?php
session_start();
if(isset($_SESSION['id'])){
  $welcome = "Welcome '".$_SESSION['email']."' <a href='logout.php'>Logout</a>";
}else{
  header("Location: loginForm.php");
  exit;
}
//1-connect to database
$conn = mysqli_connect("localhost","root","","users");
if(!$conn){
    echo mysqli_error();
    exit;
}
//2-draw in table (show in table)
$query = "SELECT * FROM `customers`";

//2-search and filter
if(isset($_GET['search'])){
  $search = mysqli_escape_string($conn,$_GET['search']);
  $query .= " WHERE `customers`.`name` LIKE '%".$search."%' OR `customers`.`email` LIKE '%".$search."%'";
}
$result = mysqli_query($conn,$query);    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIST</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h4 class="text-center pt-5 text-success"><?php echo $welcome ?></h4>
    <h1 class="text-center pt-5 text-success">USERS LIST</h1>
    <!--1-Search and filter form-->
    <form method="GET">
      <div class="input-group mb-3">
        <input type="text" class="form-control" name="search" id="search" placeholder="search by name or email">
        <button type="submit" class="btn btn-secondary">Search</button>
      </div>
    </form>
    <table class="table table-success table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">#id</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Admin</th>
      <th scope="col">Avatar</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <?php 
  while($row = mysqli_fetch_assoc($result)){ 
  ?>
<tbody>
    <tr>
      <th><?php echo $row['id']?></th> 
      <td><?php echo $row['name']?></td>
      <td><?php echo $row['email']?></td>
      <td><?php echo $row['admin']? 'Yes': 'No' ?></td>
      <td><?php if($row['avatar']) { ?><img src="./uploads/<?php echo $row['avatar'] ?>" style="width:100px; height:100px"> <?php }else{ ?>
      <img src="./uploads/no-img.png" style="width:100px; height:100px"> <?php } ?>
      </td>
      <td><a class="btn btn-success" href="edit.php?id=<?php echo $row['id'] ?>">Edit</a> || <a class="btn btn-danger" href="delete.php?id=<?php echo $row['id'] ?>">Delete</a></td>      
    </tr> <!--send id to know which will edit or delete-->
</tbody>
<?php } ?>
<tfoot>
    <tr>
      <td class="fw-bold">Users Count:</td>
        <td colspan="2" class="text-center fw-bold"><?php echo mysqli_num_rows($result) ?></td>
        <td colspan="3" class="text-center"><a class="btn btn-dark" href="add.php">Add user</a></td>
    </tr>
</tfoot>
</table>

<?php 
mysqli_free_result($result);
mysqli_close($conn);
?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
