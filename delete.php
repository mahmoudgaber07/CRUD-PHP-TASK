<?php 
//connect to db
$conn = mysqli_connect("localhost","root","","users");
if(!$conn){
    echo mysqli_connect_error();
    exit;
}
//Select user
$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$query = "DELETE FROM customers where id = '$id ' LIMIT 1";
if(mysqli_query($conn,$query)){
    header("Location: listRegistedUsers.php");
    exit;
}else{
    echo $query;
    echo mysqli_error($conn);
}
//close connection
mysqli_close($conn);
?>