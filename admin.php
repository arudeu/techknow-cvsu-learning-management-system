<?php
  include 'includes/dbh.inc.php';
  include 'includes/admin.inc.php';
  require "header.php";

echo "<main style='min-height: 95vh;'>";
    if (isset($_SESSION['adminuserId']))
    {
      if(isset($_GET['type']))
      {
        if($_GET['type'] == 'flags')
        {
          echo "<title>Reports | TechKnow</title>";
          echo "<div class='container box-container'>";
          echo "<div class='grid-padding' style='background: #dfe4ea; padding:10px;'>";
          echo "<div class='row'>
          <div class='col text-center admin-approval-users'>";
          echo "<div class='box-divs' style='margin-top: 75px;'>";
          echo"<h4>REPORTS</h4>";
          echo "<table class='table col-sm-8'>
          <thead>
          <tr>
          <th>ID</th>
          <th>Reporter</th>
          <th>Violator</th>
          <th>Reason</th>
          <th>View Post</th>
          <th>Delete</th>
          </tr>
          </thead><tbody>";
          $tablesel = "SELECT * FROM reports";
          $tableres = $conn->query($tablesel);

          while($tablerow = $tableres->fetch_assoc())
          {
            echo "<tr>";
            echo "<td>".$tablerow['reportID']."</td>";
            $userid = $tablerow['reporterID'];
            $usersql = "SELECT * FROM users WHERE idUsers = $userid";
            $userres = $conn->query($usersql);
            $usernum = mysqli_num_rows($userres);
            if ($usernum > 0)
            {
              while($userrow = $userres->fetch_assoc())
              {
                echo "<td>".$userrow['lnameUsers'].", ".$userrow['fnameUsers']."</td>";
              }
            }
            else
            {
              echo "Deleted user (uid: ".$userid.")";
            }
            
            $userid = $tablerow['reportedID'];
            $usersql = "SELECT * FROM users WHERE idUsers = $userid";
            $userres = $conn->query($usersql);
            $usernum = mysqli_num_rows($userres);
            if ($usernum > 0)
            {
              while($userrow = $userres->fetch_assoc())
              {
                echo "<td>".$userrow['lnameUsers'].", ".$userrow['fnameUsers']."</td>";
              }
            }
            else
            {
              echo "Deleted user (uid: ".$userid.")";
            }
            echo "<td>".$tablerow['reasonID'].". ".$tablerow['reason']."</td>";
            echo "<td><button type='button' class='get-reportpostview' data-id='".$tablerow['postID']."' data-toggle='modal' data-target='#viewreportpostmodal'>View Post</button></td>";
            echo "<td><button type='button' class='get-reportpostdelete' data-id='".$tablerow['postID']."' data-toggle='modal' data-target='#deletereportpostmodal'>Delete</button></td>";
          }
          echo "</div>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
          echo "</div>";

          echo '<div class="modal fade" id="viewreportpostmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-body" id="check-adminpostview">
                    
                    
                  </div>
                </div>
              </div>
            </div>';

            echo '<div class="modal fade" id="deletereportpostmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Are you sure you want to delete this post?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-footer" id="check-adminpostdelete">
                  
                  
                </div>
              </div>
            </div>
          </div>';
        }
        elseif($_GET['type'] == 'departments')
        {
          echo "<title>Add | TechKnow</title>";
          echo "<div class='container box-container'>";
            echo "<div class='grid-padding' style='background: #dfe4ea; padding:10px;'>";
              echo "<div class='row'>
                <div class='col admin-approval-users'>";
                echo "<div class='box-divs text-center' style='margin-top: 75px;'>";
                  echo"<h4>ADD A</h4>";
                    echo "<div class='form-group container row-sm-12 form-check-inline'>";
                    echo "<form method='POST' action='admin.php'>";

                    echo "<select name='coursedepttype' class='signupinputfrm form-control' style='text-align: center;' onchange='showsec(this)'>
                    <option selected value='Course'>Course</option>
                    <option value='Department'>Department</option>
                    </select>";

                      
                      echo "<div id='student-section'>";

                      echo "<div class='col'>";
                      echo "<input type='text' name='coursecode' placeholder='Course code' style='text-transform: uppercase' maxlength='8'>";
                      echo "</div>";

                      echo "<div class='col'>";
                        echo "<input type='text' name='coursename' placeholder='Course name'>";
                      echo "</div>";

                        echo "<div class='col'>";
                        echo "<button type='submit' name='addcourse'>Add</button>";
                      echo "</div>";

                    echo "</div>";

                      echo "<div id='teacher-section'>";

                      echo "<div class='col'>";
                      echo "<input type='text' name='deptcode' placeholder='Department code' style='text-transform: uppercase' maxlength='8'>";
                      echo "</div>";

                      echo "<div class='col'>";
                        echo "<input type='text' name='deptname' placeholder='Department name'>";
                      echo "</div>";

                        echo "<div class='col'>";
                        echo "<button type='submit' name='adddept'>Add</button>";
                      echo "</div>";


                    

                    echo "</form>";
                    echo "</div>";
                    echo "<table class='table col-sm-8'>
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Delete</th>
                    </tr>
                    </thead><tbody>";
                    $tablesel = "SELECT * FROM coursedept";
                    $tableres = $conn->query($tablesel);

                    while($tablerow = $tableres->fetch_assoc())
                    {
                      echo "<tr>";
                      echo "<td>".$tablerow['id']."</td>";
                      echo "<td>".$tablerow['code']."</td>";
                      echo "<td>".$tablerow['type']."</td>";
                      echo "<td>".$tablerow['title']."</td>";
                      echo "<td><button type='button' class='get-deletecoursedept' data-id='".$tablerow['id']."' data-toggle='modal' data-target='#deletecoursedept'>Delete</button></td>";
                    }
                    echo "</tbody></table>";
                    echo "</div>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
          echo '<div class="modal fade" id="deletecoursedept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Are you sure you want to delete this course/department?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-footer" id="check-admincoursedeptdelete">
                  
                  
                </div>
              </div>
            </div>
          </div>';
        }
      }
      else
      {
        echo "<title>Admin | TechKnow</title>";
        echo "<div class='container box-container'>";
        echo "<div class='grid-padding' style='background: #dfe4ea; padding:10px;'>";
        echo "<div class='row'>
        <div class='col text-center admin-approval-users'>";
          echo "<div class='box-divs' style='margin-top: 75px;'>";
          echo"<h4>SIGNUP APPROVAL</h4>";
          echo "
          <div class='row'>
            <div class='col-sm-6'>
              <form method='POST' action='admin.php'>
              <input type='text' placeholder='Search' name='searchusertext'>
              </div>
              <div class='col-sm-3'>
              <select name='searchby'>
              <option value='studentIDUsers'>Student Number</option>
              <option value='employeeIDUsers'>Employee Number</option>
              </select>
              </div>
              <div class='col-sm-3'>
              <button type='submit' name='searchuser'>Search</button>
              </form>
            </div>
          </div>
          <table class='table'>
          <thead>
          <tr>
          <th>User ID</th>
          <th>Full Name</th>
          <th>Account Type</th>
          <th>Approval</th>
          <th>ID</th>
          <th>Delete</th>
          <th>Details</th>
          </tr>
          </thead>
          ";
          if (isset($_POST['searchuser']))
          {
            $getadminapprovalsql = "SELECT * FROM users WHERE ".$_POST['searchby']." = '".$_POST['searchusertext']."'";
            $getadminapprovalresult = $conn->query($getadminapprovalsql);
            if(mysqli_num_rows($getadminapprovalresult) == 0)
            {
              echo "No pending applications found";
            }
            else
            {
              echo "<tbody>";
              while($getadminapprovalrow = $getadminapprovalresult->fetch_assoc())
              {
                 echo
                 "
                 <tr>
                 <td>".$getadminapprovalrow['idUsers']."</td>
                 <td>".$getadminapprovalrow['lnameUsers'].", ".$getadminapprovalrow['fnameUsers']."</td>
                 <td>".$getadminapprovalrow['accounttypeUsers']."</td>
                 ";
                 if ($getadminapprovalrow['statusUsers'] == "Pending")
                 {
                     echo "<td><form action='".approveUserApplication($conn)."' method='POST'><button name='approveapplication' value='".$getadminapprovalrow['idUsers']."'>Approve</button><button name='declineapplication' value='".$getadminapprovalrow['idUsers']."'>Decline</button></form></td>";
                 }
                 else
                 {
                     echo "<td>".$getadminapprovalrow['statusUsers'];
                     
                     echo "<button type='button' class='get-status' data-id='".$getadminapprovalrow['idUsers']."' data-toggle='modal' data-target='#editadminmodal'>
                     Edit
                     </button>
                     </td>";
                 }
                 echo "<td>
                 <button type='button' class='get-id' data-id='".$getadminapprovalrow['idUsers']."' data-toggle='modal' data-target='#exampleModalCenter'>
                 Check ID
                 </button>
                 </td>
                 <td>
                 <button type='button' class='get-admindel' data-id='".$getadminapprovalrow['idUsers']."' data-toggle='modal' data-target='#deleteadminmodal'>
                 Delete
                 </button>
                 </td>
                 <td>
                 <button type='button' class='get-adminview' data-id='".$getadminapprovalrow['idUsers']."' data-toggle='modal' data-target='#viewadminmodal'>
                 View
                 </button>
                 </td>
                 </tr>";
                 
             echo '<!-- Button trigger modal -->
          
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">CVSU - SC ID</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="check-id">
                        
                        
                      </div>
                    </div>
                  </div>
                </div>';
              
              echo '<div class="modal fade" id="editadminmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Approve this user?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-footer" id="check-status">
                    
                    
                  </div>
                </div>
              </div>
            </div>';
  
            echo '<div class="modal fade" id="deleteadminmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Are you sure you want to delete this user?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-footer" id="check-admindel">
                    
                    
                  </div>
                </div>
              </div>
            </div>';
  
            echo '<div class="modal fade" id="viewadminmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">User Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="check-adminview">
                    
                    
                  </div>
                </div>
              </div>
            </div>';
              }
              exit();
            }
            
          }
          else
          {
            $getadminapprovalsql = "SELECT * FROM users WHERE statusUsers = 'Pending'";
            $getadminapprovalresult = $conn->query($getadminapprovalsql);
            if(mysqli_num_rows($getadminapprovalresult) > 0)
            {
              echo "<tbody>";
              while($getadminapprovalrow = $getadminapprovalresult->fetch_assoc())
              {
                 echo
                 "
                 <tr>
                 <td>".$getadminapprovalrow['idUsers']."</td>
                 <td>".$getadminapprovalrow['lnameUsers'].", ".$getadminapprovalrow['fnameUsers']."</td>
                 <td>".$getadminapprovalrow['accounttypeUsers']."</td>
                 ";
                 if ($getadminapprovalrow['statusUsers'] == "Pending")
                 {
                     echo "<td><form action='".approveUserApplication($conn)."' method='POST'><button name='approveapplication' value='".$getadminapprovalrow['idUsers']."'>Approve</button><button name='declineapplication' value='".$getadminapprovalrow['idUsers']."'>Decline</button></form></td>";
                 }
                 else
                 {
                     echo "<td>".$getadminapprovalrow['statusUsers']."
                     <form action='".editUserStatus($conn)."' method='post'><button type='submit' name='editUserStat' value='".$getadminapprovalrow['idUsers']."'>
                     Edit
                     </button>
                     </form>
                     </td>";
                 }
                 echo "<td>
                 <button type='button' class='get-id' data-id='".$getadminapprovalrow['idUsers']."' data-toggle='modal' data-target='#exampleModalLong'>
                 Check ID
                 </button>
                 </td>
                 <td>
                 <form action='' method='post'>
                 <button type='submit' value='".$getadminapprovalrow['idUsers']."' name='userid'>Delete</button>
                 </form>
                 </td>
                 </tr>";
                 
          echo '<!-- Button trigger modal -->
          
          
                <!-- Modal -->
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">CVSU - SC ID</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="check-id">
                        
                        
                      </div>
                    </div>
                  </div>
                </div>';
              }
              exit();
            }
            else
            {
              echo "No pending applications found";
            }
          }
          
          
          
          echo
          " </tbody>
          </table>
          </div>
          </div>
          </div>
          </div>
          </div>
          ";
      }
      
    }
    else if(isset($_POST['userId']))
    {
      echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
    }
    else
    {
      echo '<div class="signupbg" style="background-image: url(images/admin-img.jpg); height: 100vh">';
          echo "<div class='grid-padding' style='padding:10px;'>";
              echo '<div class="col">';
                echo "<div class='row' style='margin-top:10%;'>";
                      echo "<div class='signupctn text-center box-divs' style='width: 40%; margin: 0 auto; top: 10%;'>
                            <h4 class='card-header'>ADMIN LOGIN</h4>
                                <div class='card-body'>
                                
                                    <form class='signup-form' action='includes/admin-login.inc.php' method='POST'>
                                    <input class='signupinputfrm form-control' type='text' name='userid' id='' placeholder='Admin username'>
                                    <input class='signupinputfrm form-control' type='password' name='passid' id='' placeholder='Admin password'>
                                    <div class='row'>
                                    <div class='col'>
                                    <button class='form-control' type='submit' name='login-adminheader'>Login</button>
                                    </div>
                                    </form>";
                                    $getadminsql = "SELECT * FROM users WHERE accounttypeUsers = 'Admin'";
                                    $getadminresult = $conn->query($getadminsql);
                                    $getadminnumrow = mysqli_num_rows($getadminresult);
                                    if($getadminnumrow < 2)
                                    {
                                      echo"<div class='col'>
                                      <form action='admin-signup.php' method='POST'>
                                      <button class='form-control' type='submit' name='signup-adminheader' id='student'>Signup</button>
                                      </form>
                                      </div>";
                                    }
                                    elseif($getadminnumrow >= 2)
                                    {
                                      echo "";
                                    }

                                   echo"</div>
                                </div>
                            </div>
                        </div>
                  </div>
                </div> 
         </div>";
    }
    echo "<script>
    function showsec(element)
    {
      document.getElementById('student-section').style.display = element.value == 'Course' ? 'block' : 'none';
      document.getElementById('teacher-section').style.display = element.value == 'Department' ? 'block' : 'none';
    }
    </script>";

    echo"</main>";

if(isset($_POST['addcourse']))
{
  $coursecode = $_POST['coursecode'];
  $coursename = $_POST['coursename'];
  $coursetype = "Course";
  $addins = "INSERT INTO coursedept (code, type, title) VALUES ('$coursecode', '$coursetype', '$coursename')";
  $addres = $conn->query($addins);
  echo "<script type='text/javascript'>window.history.back();</script>"; 
  exit;
}
else if (isset($_POST['adddept']))
{
  $coursecode = $_POST['deptcode'];
  $coursename = $_POST['deptname'];
  $coursetype = "Department";
  $addins = "INSERT INTO coursedept (code, type, title) VALUES ('$coursecode', '$coursetype', '$coursename')";
  $addres = $conn->query($addins);
  echo "<script type='text/javascript'>window.history.back();</script>"; 
  exit;
}
    