<?php
include 'dbh.inc.php';

$uid = $_POST['idUsers'];
$viewsel = "SELECT * FROM users WHERE idUsers = $uid";
$viewres = $conn->query($viewsel);

while($viewrow = $viewres->fetch_assoc())
{
    echo "<div class='row-lg-12' style='text-align: left;'>";
    echo "<h2>";
        echo $viewrow['lnameUsers'].", ".$viewrow['fnameUsers'];
    echo"</h2>";
    echo "</div>";

    echo "<div class='row-lg-12' style='text-align: left;'>";
    if($viewrow['accounttypeUsers'] == "Student")
    {
        echo $viewrow['course'];
    }
    else if($viewrow['accounttypeUsers'] == "Teacher")
    {
        echo $viewrow['departmentUsers'];
    }
    echo "</div>";

    echo "<div class='row-lg-12' style='text-align: left;'>";
    if($viewrow['accounttypeUsers'] == "Student")
    {
        echo "Student No: ";
        echo $viewrow['studentIDUsers'];
    }
    else if($viewrow['accounttypeUsers'] == "Teacher")
    {
        echo "Employee No: ";
        echo $viewrow['employeeIDUsers'];
    }
    echo "</div>";

    echo "<div class='row-lg-12' style='text-align: left;'>";
    echo $viewrow['addressUsers'];
    echo "</div>";
    
    echo "<div class='row-lg-12' style='text-align: left;'>";
    if($viewrow['genderUsers'] == "M")
    {
        echo "Male";
    }
    else if($viewrow['genderUsers'] == "F")
    {
        echo "Female";
    }
    echo "</div>";

    

    
    
    
}