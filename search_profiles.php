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
			//echo "search profiles";
			session_start();
			include ("connection.php");
			if (isset($_POST['search'])){
				//echo 'inside submit';
				$row_major=$row_native=$row_languages=$row_user='';
				$listofemails = array();
				$sql="select EmailId from user where 1=1";
				//if email is set
				if(isset($_POST["email"])&&!empty($_POST["email"])){
					$sql .= " AND user.EmailId LIKE '%".$_POST["email"]."%'";
					//echo "email</br>";
					//echo $_POST['email']."</br>";
				} 
					
				//if name is set
				if(isset($_POST["profilename"]) && $_POST["profilename"]!=''){
					$sql .= " AND FirstName LIKE '%".$_POST["profilename"]."%' OR LastName LIKE '%".$_POST["profilename"]."%'";
					//echo $_POST['profilename']."</br>";
					//echo "profile</br>";
				}
					
				//if gender is set
				if(isset($_POST["gender"]) && $_POST["gender"]!='') {
					$sql .= " AND Gender='".$_POST["gender"]."'";
					//echo $_POST['gender']."</br>";
					//echo "gender</br>";
				}
					
				//if Budget is set
				if(isset($_POST["budgetpreferences"]) && $_POST["budgetpreferences"]!='null'){
					$sql .= " AND Budget = '".$_POST["budgetpreferences"]."'";
					//echo $_POST['budgetpreferences']."</br>";
					//echo "budget</br>";
				}
					
				//if No of Roommates is set
				if(isset($_POST["roommatespreferences"]) && $_POST["roommatespreferences"]!='null'){
					$sql .= " AND NoOfRoommates = '".$_POST["roommatespreferences"]."'";
					//echo "room</br>";
				}
					
				//if smoking is set
				if(isset($_POST["smokingpreferences"]) && $_POST["smokingpreferences"]!='null')
				{
					$sql .= " AND SmokingSelf = '".$_POST["smokingpreferences"]."'";
					//echo "smoke</br>";
				}
					
				//if Drinking is set
				if(isset($_POST["drinkingpreferences"]) && $_POST["drinkingpreferences"]!='null')
				{
					$sql .= " AND DrinkingSelf = '".$_POST["drinkingpreferences"]."'";
					//echo "drink</br>";
				}
					
				//if Food Habits is set
				if(isset($_POST["foodhabitspreferences"]) && $_POST["foodhabitspreferences"]!='null'){
					$sql .= " AND FoodHabitsSelf = '".$_POST["foodhabitspreferences"]."'";
					//echo "food</br>";
				}
					
				
				//execute user table query
				if(!mysqli_query($conn, $sql)){
					echo mysqli_error($conn);
					echo "</br>";
				}
				$result_user=mysqli_query($conn, $sql);
				while($row_user=mysqli_fetch_array($result_user)){
					//push into array
					//echo $row_user[0]." 	push </br>";
					array_push($listofemails, $row_user[0]);
					
				}
				
				//if Major is set
				if(isset($_POST["majorpreferences"])&& $_POST["majorpreferences"]!='null' &&is_array($_POST['majorpreferences'])) {
					foreach ($_POST['majorpreferences'] as $value)
					{
						//$sqlmajor = "select EmailId from major where major.Major LIKE '%".$value."%' AND major.Type=1";
						$sqlmajor = "select EmailId from major where major.Major='".$value."' AND major.Type=1";
						$result_major=mysqli_query($conn, $sqlmajor);
						while($row_major=mysqli_fetch_array($result_major)){
							if(!in_array($row_major[0], $listofemails, true)){
								//echo $row_major[0]."major push </br>";
								array_push($listofemails, $row_major[0]);
							}
							
						}
					}
				}
				
				//if Native is set
				if(isset($_POST["nativepreferences"])&& $_POST["nativepreferences"]!='null' &&is_array($_POST['nativepreferences'])){ 
					foreach ($_POST['nativepreferences'] as $value)
					{
						$sqlnative = "select EmailId from native where native.Native LIKE '%".$value."%' AND native.Type=1";
						$result_native=mysqli_query($conn, $sqlnative);
						while($row_native=mysqli_fetch_array($result_native)){
							if(!in_array($row_native[0], $listofemails, true)){
								array_push($listofemails, $row_native[0]);
							}
						}
					}
				}
				//if LanguagesKnown is set
				if(isset($_POST["languagespreferences"])&& $_POST["languagespreferences"]!='null' &&is_array($_POST['languagespreferences'])) {
					foreach ($_POST['languagespreferences'] as $value)
					{
						$sqllanguages = "select EmailId from languagesknown where languagesknown.LanguagesKnown LIKE '%".$value."%' AND languagesknown.Type=1";
						$result_languages=mysqli_query($conn, $sqllanguages);
						while($row_languages=mysqli_fetch_array($result_languages)){
							if(!in_array($row_languages[0], $listofemails, true)){
								array_push($listofemails, $row_languages[0]);
							}
						}
					}
				}
				
				foreach($listofemails as $email){
					//echo "list ";
					//echo $email."</br>";
				}
				$output='<div class="table-responsive">
														<table class="table table-bordered">
																<thead>
																  <tr>
																	<th>Firstname</th>
																	<th>Gender</th>
																	<th>Major</th>
																	<th>Native</th>
																	<th>Group</th>
																	<th>View Profile</th>
																  </tr>
																</thead>
																<tbody>';
				foreach($listofemails as $email){
									
									
									//get profile info for Name, Gender, Group, Smoking, Drinking, FoodHabits, Budget, NoOfRoommates, EmailId and Phone number
									$query="select * from user where EmailId='". $email. "'";
									//execute the user query
									$result=mysqli_query($conn, $query);
									//fetch user data
									$row=mysqli_fetch_array($result);


									//get profile major info-1 major
									$querymajor="select * from major where EmailId='".$email."' and Type=1";
									//execute profile major query
									$resultmajor=mysqli_query($conn, $querymajor);
									//fetch major value
									$rowmajor=mysqli_fetch_array($resultmajor);
									
									//get profile native info-1 native
									$querynative="select * from native where EmailId='".$email."' and Type=1";
									//execute profile native query
									$resultnative=mysqli_query($conn, $querynative);
									//fetch native value
									$rownative=mysqli_fetch_array($resultnative);
									
									//get profile language info-more than 1 language known
									$querylanguage="select * from languagesknown where EmailId='".$email."' and Type=1";
									//execute profile language query
									$resultlanguage=mysqli_query($conn, $querylanguage);
									//fetch inside while since more than 1
									
									
									//Display the results
									  $output.= '<tr>
																	<td>'.$row["FirstName"].' '.$row["LastName"].'</td>
																	<td>'.$row["Gender"].'</td>
																	<td>'.$rowmajor["Major"].'</td>
																	<td>'.$rownative["Native"].'</td>
																	<td>'.$row["user_groupname"].'</td>
																	<td><button name="view_profile" id="'.$email.'" class="btn btn-info view_profile">View</button></td>
																	</tr>';
													
													
								
							}
							$output.='</tbody>
							</table>
								</div>';
													  

													  
							echo "		
								<script>
									$(document).ready(function(){
										$('.view_profile').click(function(){
											var email_id=$(this).attr('id');
											
											var header='Profile Details';
											$.ajax({
												url:'select.php',
												method: 'post',
												data:{EmailId: email_id},
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
			}
			?>
		<div class="container" style="padding-top:100px;">
        <div class="row">
            <div class="col-sm-4">
                <form class="form-horizontal" method="post" name="searchroommates" id="searchroommates" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
				
                    <div class="form-group">
   						<label class="control-label col-sm-3" for="email">Email</label>
                        <div class="col-md-8 col-sm-9">
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
					
                    <div class="form-group">
						<label class="control-label col-sm-3" for="profilename">Name</label>
                        <div class="col-md-8 col-sm-9">
                            <input type="text" class="form-control" id="profilename" name="profilename" placeholder="FirstName/LastName">
                        </div>
                    </div>
					
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="gender">Gender</label>
                        <div class="col-md-8 col-sm-9">
                            <label class="radio-inline">
								&nbsp;<input type="radio" name="gender" value="male">Male
							</label>
							<label class="radio-inline">
								<input type="radio" name="gender" value="female">Female
							</label>
							<label class="radio-inline">
								<input type="radio" name="gender" value="other">Other
							</label>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3" for="majorpreferences">Major</label>
                        <div class="col-md-8 col-sm-9">
									<select  id="majorpreferences" class="selectpicker"  multiple="multiple" name="majorpreferences[]" multiple >
										<option value="null"></option>
										<option value="Computer Science">Computer Science</option>
										<option value="Computer Engineering">Computer Engineering</option>
										<option value="Electrical Engineering">Electrical Engineering</option>
										<option value="Industrial Engineering">Industrial Engineering</option>
										<option value="Civil Engineering">Civil Engineering</option>
										<option value="Chemical Engineering">Chemical Engineering</option>
										<option value="Structural Engineering">Structural Engineering</option>
										<option value="Bio-Medical Engineering">Bio-Medical Engineering</option>
										<option value="Mechanical Engineering">Mechanical Engineering</option>
										<option value="Doesn't matter">Doesn't matter</option>
									</select> 
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3" for="budgetpreferences">Budget</label>
                        <div class="col-md-8 col-sm-9">
							<select  id="budgetpreferences"  class="selectpicker" name="budgetpreferences">
									<option value="null"></option>
									<option value="less than 200">less than 200</option>
									<option value="200-250">200-250</option>
									<option value="250-300">250-300</option>
									<option value="greater than 300">greater than 300</option>
							</select> 
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3" for="roommatespreferences">No of Roommates</label>
                        <div class="col-md-8 col-sm-9">
							<select  id="roommatespreferences" class="selectpicker" name="roommatespreferences">
									<option value="null"></option>
									<option value="less than 2">less than 2</option>
									<option value="2-3">2-3</option>
									<option value="4-5">4-5</option>
									<option value="more than 5">more than 5</option>
							</select>
                        </div>
                    </div>
					
					<button type="button" name="advanced_search" id="advanced_search" class="btn btn-sm btn-info advanced_search" style="float:right;">Advanced Search</button>
					
					<br>
					<br>
					
					<div id="advanced_search_div" style="display:none;">
					
						<!--Advanced search options-->
						<div class="form-group">
							<label class="control-label col-sm-3" for="smokingpreferences">Smoking</label>
							<div class="col-md-8 col-sm-9">
								<select  id="smokingpreferences" class="selectpicker" name="smokingpreferences">
										<option value="null"></option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
										<option value="Occasional">Occasional</option>
								</select> 
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3" for="drinkingpreferences">Drinking</label>
							<div class="col-md-8 col-sm-9">
								<select  id="drinkingpreferences"  class="selectpicker" name="drinkingpreferences">
										<option value="null"></option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
										<option value="Occasional">Occasional</option>
								</select> 
							</div>
						</div>
						
						 <div class="form-group">
							<label class="control-label col-sm-3" for="foodhabitspreferences">Food Habits</label>
							<div class="col-md-8 col-sm-9">
								<select  id="foodhabitspreferences" class="selectpicker" name="foodhabitspreferences">
										<option value="null"></option>
										<option value="Vegetarian">Vegetarian</option>
										<option value="Non-Vegetarian">Non-Vegetarian</option>
										<option value="Eggetarian">Eggetarian</option>
										<option value="Doesn't matter">Doesn't matter</option>
								</select> 
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3" for="nativepreferences">Native</label>
							<div class="col-md-8 col-sm-9">
								<select  id="nativepreferences" class="selectpicker" multiple="multiple"  name="nativepreferences[]" multiple>
									<option value="null"></option>
									<option value="Hyderabad">Hyderabad</option>
									<option value="Chennai">Chennai</option>
									<option value="Bangalore">Bangalore</option>
									<option value="Coimbatore">Coimbatore</option>
									<option value="Cochin">Cochin</option>
									<option value="Kolkata">Kolkata</option>
									<option value="Ahmedabad">Ahmedabad</option>
									<option value="Delhi">Delhi</option>
									<option value="Noida">Noida</option>
									<option value="Chandigarh">Chandigarh</option>
									<option value="Doesn't matter">Doesn't matter</option>
								</select>  
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3" for="languagespreferences">Languages known</label>
							<div class="col-md-8 col-sm-9">
								<select  id="languagespreferences"  class="selectpicker" multiple="multiple" name="languagespreferences[]" multiple>
									<option value="null"></option>
									<option value="Hindi">Hindi</option>
									<option value="Kannada">Kannada</option>
									<option value="Gujarati">Gujarati</option>
									<option value="Marathi">Marathi</option>
									<option value="Tamil">Tamil</option>
									<option value="Malayalam">Malayalam</option>
									<option value="Odiya">Odiya</option>
									<option value="Punjabi">Punjabi</option>
									<option value="Assamese">Assamese</option>
									<option value="Haryanvi">Haryanvi</option>
									<option value="Kashmiri">Kashmiri</option>
									<option value="Urdu">Urdu</option>
									<option value="Chhattisgarhi">Chhattisgarhi</option>
									<option value="Telugu">Telugu</option>
									<option value="Bengali">Bengali</option>
									<option value="Rajasthani">Rajasthani</option>
									<option value="Doesn't matter">Doesn't matter</option>
								</select>  
							</div>
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
				</div>
            </div>
        </div>
    </div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

		<script>
			$('#languagespreferences').selectpicker();
			$('#smokingpreferences').selectpicker();
			$('#drinkingpreferences').selectpicker();
			$('#majorpreferences').selectpicker();
			$('#nativepreferences').selectpicker();
			$('#foodhabitspreferences').selectpicker();
			
		</script>
		
		<script>
			$(document).on("click", function(e){
			if($(e.target).is("#advanced_search")){
			  $("#advanced_search_div").toggle('show');
			}
		});
		</script>
	</body>
</html>
