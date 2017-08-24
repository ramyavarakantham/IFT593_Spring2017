<?php
//echo "search groups";
?>
<html>
	<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<!-- The above 3 meta tags *must* come first in the head; any other head 
				 content must come *after* these tags -->
			<title>Ristorante Con Fusion: About Us</title>
			  <!-- Bootstrap -->
			  <!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-social.css">
							
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

				<!-- Latest compiled JavaScript -->
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
				
				<!--Mobile first. Adapts itself to screen width-->
				<meta name="viewport" content="width=device-width, initial-scale=1">
				
				<!--font-awesome-->
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
				<!--
				<link href="Ramya_index_css.css" rel="stylesheet">-->
				
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
				
				
			<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
			<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
			<!--[if lt IE 9]>
			  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->
	</head>
	<body>
		<?php
			session_start();
			include ("connection.php");
			if (isset($_POST['search'])){
				//echo 'inside submit';

				$sql="select * from user_group where 1=1";
				//if groupname is set
				if(isset($_POST["name"])&&!empty($_POST["name"])){
					$sql .= " AND GroupName LIKE '%".$_POST["name"]."%'";
					//echo "group</br>";
					//echo $_POST['name']."</br>";
				} 
					
				//if aptname is set
				if(isset($_POST["aptname"]) && $_POST["aptname"]!=''){
					$sql .= " AND ApartmentName LIKE '%".$_POST["aptname"]."%'";
					//echo $_POST['aptname']."</br>";
					//echo "aptname</br>";
				}
					
				//if budget is set
				if(isset($_POST["budget"]) && $_POST["budget"]!='null') {
					$sql .= " AND Budget='".$_POST["budget"]."'";
					//echo $_POST['budget']."</br>";
					//echo "budget</br>";
				}
					
				//if maxmembers is set
				if(isset($_POST["maxmembers"]) && $_POST["maxmembers"]!='null'){
					$sql .= " AND MaxMembers = '".$_POST["maxmembers"]."'";
					//echo $_POST['maxmembers']."</br>";
					//echo "maxmembers</br>";
				}
					
				//execute user group table query
				if(!mysqli_query($conn, $sql)){
					echo mysqli_error($conn);
					echo "</br>";
				}
				$result_user=mysqli_query($conn, $sql);		
				$output='<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									 <tr>
										<th>Group Name</th>
										<th>Vacancies</th>
										<th>View Details</th>
										<th>Join Group</th>
									</tr>
								</thead>
							<tbody>';
							
				while($row_user=mysqli_fetch_array($result_user)){
									//echo "list ";
									//echo $row_user['GroupName']."</br>";
									//echo "inside while";
													
									//select members belonging to that group
									$q="select * from user where user_groupname='".$row_user['GroupName']."'";
									$r=mysqli_query($conn, $q);
									$currentcount=mysqli_affected_rows($conn);
									$vacancies=$row_user['MaxMembers']-$currentcount;
									
									
									//Display the results
									  $output.= '<tr>
																	<td>'.$row_user["GroupName"].'</td>
																	<td>'.$vacancies.'</td>
																	<td><button name="view_data" id="'.$row_user['GroupName'].'" class="btn btn-info view_data">View</button></td>
																	<td><button name="join_group" id="'.$row_user['GroupName'].'" class="btn btn-info join_group">Join</button></td>
																	</tr>';
													
													
								
							}
							$output.='</tbody>
							</table>
								</div>';
					echo "<script>
							$(document).ready(function(){
								$('.view_data').click(function(){
									var group_name=$(this).attr('id');
									var header='Group Details';
									$.ajax({
										url:'select.php',
										method: 'post',
										data:{GroupName: group_name},
										success: function(data){
											$('#member_details').html(data);
											$('#member_header').html(header);
											$('#dataModal').modal('show');
										}
									});
									$('#dataModal').modal('show');
								});
							});
						</script>";
					echo " <script>
							$(document).ready(function(){
								$('.join_group').click(function(){
									var group=$(this).attr('id');
									
									$.ajax({
										url:'select.php',
										method: 'post',
										data:{JoinGroup: group},
										success: function(data){
											$('#alertmessage').html(data);	
										}
									});	
									$('#joinedgroupalert').css('display', '');
								});
							});
						</script>";
			}
			?>
		<div class="container" style="padding-top:100px;">
        <div class="row">
            <div class="col-sm-4">
                <form class="form-horizontal" method="post" name="searchgroups" id="searchgroups" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
				
                    <div class="form-group">
   						<label class="control-label col-sm-3" for="name">Group Name</label>
                        <div class="col-md-8 col-sm-9">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
					
					<div class="form-group">
   						<label class="control-label col-sm-3" for="aptname">Apartment Name</label>
                        <div class="col-md-8 col-sm-9">
                            <input type="text" class="form-control" id="aptname" name="aptname">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3" for="budget">Budget</label>
                        <div class="col-md-8 col-sm-9">
							<select  id="budget"  class="selectpicker" name="budget">
									<option value="null"></option>
									<option value="less than 200">less than 200</option>
									<option value="200-250">200-250</option>
									<option value="250-300">250-300</option>
									<option value="greater than 300">greater than 300</option>
							</select> 
                        </div>
                    </div>
										
					<div class="form-group">
                        <label class="control-label col-sm-3" for="maxmembers">Max Members</label>
                        <div class="col-md-8 col-sm-9">
							<select  id="maxmembers"  class="selectpicker" name="maxmembers">
									<option value="null"></option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4-5">4-5</option>
									<option value=">5">greater than 5</option>
							</select> 
                        </div>
                    </div>		

					
					<div class="col-md-4"></div>
					<input  class="btn btn-primary col-md-4" type="submit" value="submit" name="search">
                    
                </form>
            </div>
            <div class="row col-sm-8">
                <div class="col-sm-10" id="filtered_responses">
					<?php
					if(isset($output)&&$output!='')
						echo $output;
					
					?>
					
					<!--modal to display group details-->
					<div id="dataModal" class="modal modal-lg fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 id="member_header"></h4>
								</div>
								<div class="modal-body" id="member_details">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div> 	
					</div>
					
					<!--alert to display when you have joined a group-->
					<div class="alert alert-success alert-dismissable" id="joinedgroupalert" style="display:none;">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
						<div id="alertmessage"></div>
					</div>
				</div>
            </div>
        </div>
    </div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

		<script>
			$('#budget').selectpicker();
			$('#maxmembers').selectpicker();			
		</script>
		
	</body>
</html>
