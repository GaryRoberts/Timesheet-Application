<?php

  error_reporting(0);

  require_once 'message.php';
  require_once('db_con.php');
  require_once('functions.php');
      
  try
  {


   session_start();

    if(isset($_SESSION['email']))
    {
        $email=$_SESSION['email'];
        $title=$_SESSION['title'];
        $first_name=$_SESSION['first_name'];
        $last_name=$_SESSION['last_name'];
        $telephone=$_SESSION['telephone'];
        $address=$_SESSION['address'];

        $stmt = $conn->prepare("SELECT role FROM role WHERE id = ?");
        $stmt->execute([$_SESSION['role_id']]);
        $user_role = $stmt->fetch();
        $role= $user_role['role'];
    } 
    else
    {
       direct("index.php");
    }


    if(isset($_POST['save_sheet']))  
    {  
     
      $query = "
      INSERT INTO timesheet(employee_id,job_title,start_time,end_time,comments,project_id,time_spent) 
      VALUES (:employee_id,:job_title,:start_time,:end_time,:comments,:project_id,:time_spent)";

      
      for($count = 0; $count < count($_POST['task']); $count++)
      {
        $data = array(
          ':employee_id'=>$_SESSION['id'],
          ':job_title'	=>	$_POST['task'][$count],
          ':start_time'	=>	$_POST['start_time'][$count],
          ':end_time'	=>	$_POST['end_time'][$count],
          ':comments'	=>	$_POST['comments'][$count],
          ':project_id'	=>$_POST['project_id'],
          ':time_spent'	=>	$_POST['total_hours'][$count]
        );
        $statement = $conn->prepare($query);
        $statement->execute($data);

        if($statement)
        {
          toast("Time sheet was submitted successfully");
        }
        else{
          toast("Sorry.Time sheet not submitted. Try again");
        }

      }
   }


}
catch(Exception $e) 
{
    toast("Sorry.Something went wrong. Please try again !!!");
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Home</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/mdb.min.css">
  <link rel="stylesheet" href="css/style.css">

<style type="text/css">/* Chart.js */
@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style></head>

<body class="fixed-sn white-skin">

  <!-- Main Navigation -->
  <header>

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg scrolling-navbar double-nav">
      <!-- Breadcrumb -->
      <div class="breadcrumb-dn mr-auto">
        <p>Timesheet</p>
      </div>

      <!-- Navbar links -->
      <ul class="nav navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle waves-effect" href="https://mdbootstrap.com/previews/templates/admin-dashboard/html/pages/customers.html#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <span class="clearfix d-none d-sm-inline-block">Profile</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item waves-effect waves-light" href="logout.php">Log Out</a>
          </div>
        </li>
      </ul>
      <!-- Navbar links -->

    </nav>
    <!-- Navbar -->

  </header>
  <!-- Main Navigation -->

  <!-- Main layout -->
  <main>
    <div class="container-fluid">

      <!-- Section: Customers -->
      <section class="section team-section">

        <!-- First row -->
        <div class="row">

          <!-- First column -->
          <div class="col-md-8">

            <div class="row mb-1">
              <div class="col-md-9">
                <h4 class="h4-responsive mt-1">Select Project:</h4>
               
                <?php

                  error_reporting(0);

                  require_once 'message.php';
                  require_once('db_con.php');
                  require_once('functions.php');
                      
                  try
                  {
                        

                        $stmt = $conn->prepare("SELECT * From project INNER JOiN client ON project.id=client.project_id");
                        $stmt->execute();
                        $info = $stmt->fetchAll();
                        
                        echo '<select id="my_select" class="browser-default" value="" name="project_id[]">';
                        $count=0;    
                        foreach($info as $row)
                        {
                          
                          $stmt = $conn->prepare("SELECT * FROM account WHERE id = ?");
                          $stmt->execute([$row['manager_id']]);
                          $manager = $stmt->fetch();

                          if($count==0)
                          {
                            $initializeManager='Manager:'.$manager['first_name']." ".$manager['last_name'];
                          }

                          $list='<option id="'.'Manager:'.$manager['first_name']." ".$manager['last_name'].'" value='."'".$row['id']."'".'>Client:'.$row['first_name']."\n".' '.$row['last_name'].'| Project:'.$row['name'].'</option>';
                          echo $list;
                          $count++;
                        }
                        echo '</select>';

                }
                catch(Exception $e) 
                {
                    toast("Sorry.An issue occurred.Please try again");
                }
                ?>

               <br> <p id="manager" value="<?php echo $initializeManager;?>"><?php echo $initializeManager;?></p>
              </div>
              <div class="col-md-3">
                <div class="md-form">
                    <div class="row">
                  <input id="myInput" placeholder="Search task name" onkeyup="mySearch()" type="text" id="form5" class="form-control">
                  
                  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Add Task</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body mx-3">

                        <div class="md-form mb-4">
                        <label>Job title:</label><br><br>
                          <input id="task" type="text" placeholder="Enter job title" class="form-control">
                        
                        </div>

                        <div class="md-form mb-4">
                            <label>Start time:</label><br><br>
                            <input id="start-time" type="datetime-local" name="input-time"  placeholder="HH:MM">
                        </div>

                        <div class="md-form mb-4">
                        <label>End time:</label style="padding-top:10%;"><br><br>
                         <input id="end-time" type="datetime-local" placeholder="HH:MM">
                        </div>

                        <div class="md-form mb-4">
                           <input id="total-hours" type="text" placeholder="Total time" class="form-control"readonly>
                        </div>
                

                        <div class="md-form mb-4">
                          <label>Comment:</label><br><br>
                          <input id="comment" placeholder="Enter comment" type="text" id="form2" class="form-control">
                        </div>

                      </div>
                      <div class="modal-footer d-flex justify-content-center">
                    
                        <input type="button" id="add-task" class="btn btn-indigo" value="Save">
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="text-center">
                  <a href="" class="btn btn-indigo" data-toggle="modal" data-target="#myModal">Add Task</a>
                </div>
                </div>
              </div>
              </div>
            </div>

            
            <div class="row">
              <div class="col-md-12 mb-1">
                <!-- Tabs -->
                <div class="classic-tabs">
                  <!-- Nav tabs -->
                  <div class="tabs-wrapper">
                    <ul class="nav tabs-primary primary-color" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link waves-light waves-effect waves-light active" data-toggle="tab" href="https://mdbootstrap.com/previews/templates/admin-dashboard/html/pages/customers.html#panel83" role="tab" aria-selected="true">Tasks</a>
                      </li>
                    </ul>
                  </div>
                  <!-- Tab panels -->
                  <div class="tab-content card">
                    <!-- Panel 1 -->
                    <div class="tab-pane fade active show" id="panel83" role="tabpanel">
                      <div class="table-responsive">
                      <form action="home.php" method="post" name=""> 
                        <input type="hidden" name="project_id" id="hidden_id" value="1"/>
                          <table id="myTable" class="table">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Job Title</th>
                                <th>Start time</th>
                                <th>End time</th>
                                <th>Comments</th>
                                <th>Time spent</th>
                              </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                          </table>
                          <button type="button" id="delete-rows" class="btn btn-indigo">Delete Row</button>
                        
                          <button type="submit" class="btn btn-indigo" name="save_sheet">Save sheet</button>
                     </form>
                      </div>
                    </div>
                    <!-- /.Panel 2 -->
                  </div>
                  <!-- /.Tabs -->
                </div>
              </div>
            </div>

          </div>
          <!-- First column -->

          <!-- Second column -->
          <div class="col-md-4 mb-md-0 mb-5">

            <!-- Card -->
            <div class="card profile-card">

              <!-- Avatar -->
              <div class="avatar z-depth-1-half mb-4">
                <img src="images/avatar.jpg" class="rounded-circle" alt="First sample avatar image">
              </div>

              <div class="card-body pt-0 mt-0">
                <!-- Name -->
                <div class="text-center">
                  <h3 class="mb-3 font-weight-bold"><strong><?php echo $first_name." ".$last_name; ?></strong></h3>
                  <h6 class="font-weight-bold blue-text mb-4">Role:<?php echo $role; ?></h6>
                </div>

                <ul class="striped list-unstyled">
                  <li><strong>E-mail address:</strong><?php echo $email; ?></li>

                  <li><strong>Phone number:</strong><?php echo $telephone; ?></li>

                  <li><strong>Address:</strong><?php echo $address; ?></li>
                </ul>

              </div>

            </div>
            <!-- Card -->

          </div>
          <!-- Second column -->

        </div>
        <!-- First row -->

      </section>
      <!-- Section: Customers -->

    </div>
  </main>
  <!-- Main layout -->

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <!-- MDB core JavaScript -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="js/custom_functions.js"></script><div class="hiddendiv common"></div>


<script>
   var counter=0;

    $(document).ready(function(){
        $("#add-task").click(function(){
            var count=0;
           
            var task=$('#task').val();
            var start_time=$('#start-time').val();
            var end_time=$('#end-time').val();
            var total_hours=$('#total-hours').val();
            var comment=$('#comment').val();
            
            
            var inputs = [task,start_time,end_time,total_hours,comment];
           
            var i;

            for (i = 0; i < inputs.length; i++)
            {
              
              if(inputs[i]=="")
              {
                count++;
              }
            }
            
            if(count>0)
            {
              alert("Please enter all required fields");
            }
            else
            {
              counter = counter + 1;
        
               output ='<tr id="row_'+counter+'">';
               output +='<td>'+'<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="record"><label class="custom-control-label" for="defaultUnchecked"></label></div></td>';
               output +='<td>'+task+' <input type="hidden" name="task[]" value="'+task+'" /></td>';
               output +='<td>'+start_time+' <input type="hidden" name="start_time[]" value="'+start_time+'" /></td>';
               output +='<td>'+end_time+' <input type="hidden" name="end_time[]" value="'+end_time+'" /></td>';
               output +='<td>'+comment+' <input type="hidden" name="comments[]" value="'+comment+'" /></td>';
               output +='<td>'+total_hours+' <input type="hidden" name="total_hours[]" value="'+total_hours+'" /></td>';
               output +='</tr>';
              
               $("table tbody").append(output);

               $("#task").val('');
               $("#start-time").val('');
               $("#end-time").val('');
               $("#total-hours").val('');
               $("#comment").val('');

               alert("New task added !!!");
            }
 
        });
        
        // Find and remove selected table rows
        $("#delete-rows").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });
    });  
    
    
    $("#my_select").change(function() {
      var id = $(this).children(":selected").attr("id");
      $("#manager").text(id);
      var project= $('#my_select').val();
      $('#hidden_id').val(project);
});
</script>

<div class="drag-target" style="left: 0px;"></div>

</body></html>