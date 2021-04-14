<?php

session_start();
include("db.php");
error_reporting(0);
if((!isset($_SESSION['email'])) && (!isset($_SESSION['password']))){
header('Location: student-login.php');
}
if(isset($_REQUEST['submit']))
{
$name=$_REQUEST['name'];
$fathername=$_REQUEST['fathername'];
$mothername=$_REQUEST['mothername'];
$cource=$_REQUEST['cource'];
$img=$_FILES['img']['name'];
$email=$_REQUEST['email'];
$password=$_REQUEST['password'];
$hpassword = password_hash($password, PASSWORD_BCRYPT);
$phone=$_REQUEST['phone'];
$dob=$_REQUEST['dob'];
$gender=$_REQUEST['gender'];
$address=$_REQUEST['address'];
$location="upload/".$img;
copy($_FILES['img']['tmp_name'],$location);
if($img==""){
$query="UPDATE studentregister SET name='$name', fathername='$fathername', mothername='$mothername', cource='$cource', email='$email', password='$hpassword', phone='$phone', gender ='$gender', address='$address' WHERE  email = '$_SESSION[email]'";
}
else{
$location="upload/".$img;
copy($_FILES['img']['tmp_name'], $location);
$query="UPDATE studentregister SET name='$name', fathername='$fathername', mothername='$mothername', cource='$cource', img='$img', email='$email', password='$hpassword', phone='$phone', gender ='$gender', address='$address' WHERE  email = '$_SESSION[email]'";
}
$result = mysqli_query($conn,$query);
if($result){
    header("location:student-profile.php?edit successful");
}
else {
    echo "Failed";
}
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student | Admin</title>
   
</head>

<body>
    <div class="wrapper">
        <?php include('student_includes/sidebar.php');?>
        <div class="main-panel">

            <?php include('includes/nav.php');?>
            <div class="container">
                <form action="" method="post" enctype="multipart/form-data"
                    class="pt-1 pb-5">
                    <h4>EDIT STUDENT</h4>
                    <table align="center" class="table-responsive" cellpadding="12"
                        style="background-color:cornflowerblue;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);font-weight: bold;">
                        <?php
                         $fetchdata="select * from studentregister where email = '$_SESSION[email]'";
                         $records = mysqli_query($conn,$fetchdata);
                         while($data=mysqli_fetch_array($records,MYSQLI_ASSOC))
                         {
                         ?>
                        <tr>
                            <td>Name:</td>
                            <td><input type="text" name="name" value="<?php echo $data[" name"]; ?>"></td>
                            <td>Father's Name:</td>
                            <td><input type="text" name="fathername" value="<?php echo $data[" fathername"]; ?>"></td>
                        </tr>
                        <tr>
                            <td>Mother's Name:</td>
                            <td><input type="text" name="mothername" value="<?php echo $data[" mothername"]; ?>" ></td>
                            <td>Cource</td>
                            <td><input type="text" name="cource" value="<?php echo $data[" cource"]; ?>"></td>
                        </tr>
                        <tr>
                            <td>Student Image</td>
                            <td><input type="file" name="img"></td>
                            <td> <img src="upload/<?php echo $data[" img"]; ?>" style=" width: 200px; border-radius:
                                50%; height: 200px;">
                        </tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" value="<?php echo $data[" email"]; ?>"></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type="password" name="password"></td>
                            <td>Phone</td>
                            <td><input type="text" name="phone" value="<?php echo $data[" phone"]; ?>"></td>
                        </tr>
                        <tr>
                            <td>D.O.B</td>
                            <td><input type="date" name="dob" value="<?php echo $data[" dob"]; ?>"></td>
                            <td><input type="radio" name="gender" value="Male" <?php if($data["gender"]=="Male" ) {
                                    echo "checked" ; }; ?> /><label>Male</label><input type="radio" name="gender"
                                    value="Female" <?php if($data["gender"]=="Female" ) { echo "checked" ; }; ?>
                                /><label>Female</label></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td><textarea name="address" value="<?php echo $data[" address"]; ?>"></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="4"><input type="checkbox" required>&nbsp;&nbsp;I agree to the Terms and
                                Conditions
                            </td>
                        </tr>
                        <tr align="center">
                            <td colspan="1"><input type="submit" value="Submit" name="submit"></td>
                            <td colspan="1"><input type="reset" value="Reset"></td>
                        </tr>
                    </table>
                    </fieldset>
                </form>
            </div>
            <?php
}
?>
</body>

</html>