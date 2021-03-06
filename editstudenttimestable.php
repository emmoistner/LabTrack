<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<title>LabTrack</title>
<?PHP
  require('files.php');
  require ('includeJS.php');
  require('nav.php');
  require('connect.php');
  $currentID = $_SESSION['ID'];
   if(!isset($_SESSION['Fname']) || $_SESSION['Instructor']==0) {
  header("location:index.php");
}

  ?>
<script src="dist/js/jquery-2.0.3.js"></script> 
<script src="dist/js/Jeditable/jquery.jeditable.js"></script>
<script src="dist/js/DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
<script src="dist/js/DataTables-1.9.4/media/js/jquery.dataTables.editable.js"></script>
<script src="dist/js/dataTables.tableTools.js"></script>
<script src="dist/js/DT_bootstrap.js"></script>
<link href="dist/css/DT_bootstrap.css" rel="stylesheet">
<script>
$(document).ready(function(){
     $('#table').dataTable();
});
</script>
<?PHP

	if (isset($_POST['id'])){
	
	$selecteStudent = $_POST['id'];
	
	}
?>
</head>
<body>
<div class="container">
<table cellpadding='0' cellspacing='0' border='0' class='table table-hover table-bordered' id='table'>
  <thead>
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>IP</th>
      <th>Class</th>
      <th>Section</th>
      <th>Semester</th>
      <th>Time In</th>
      <th>Time Out</th>
      <th>Time in Lab</th>
      <th>Edit Time</th>
    </tr>
  </thead>
  <tbody>
  <?PHP 

  $queryb = "Select CourseID from UserCourses where UserID = $selecteStudent";
  $datab = mysql_query($queryb, $link);

  while ($resultsb = mysql_fetch_array($datab)) {
    $courseID = $resultsb['CourseID'];
  $query= "Select Distinct Courses.Name, Courses.Section, Courses.Semester, TimeClock.StampID, TimeClock.TimeIn, TimeClock.TimeOut, TimeDiff(TimeClock.TimeOut, TimeClock.TimeIn) 
  as TimeDiff, INET_NTOA(TimeClock.IP) as IP, UserAccounts.Fname, UserAccounts.Lname from UserAccounts, Courses, UserCourses, 
  TimeClock where Courses.CourseID= $courseID and UserAccounts.id = $selecteStudent and TimeClock.UserID = $selecteStudent and TimeClock.CourseID = $courseID";
	$data = mysql_query($query, $link);
	 while($results = mysql_fetch_array($data, MYSQL_ASSOC)) {

	 	$timeIn = $results['TimeIn'];
	 	$dateTimeIn = DateTime::createFromFormat("Y-m-d H:i:s", $timeIn);
	 	$finalTimeIn = date_format($dateTimeIn, "l F j, Y g:i A");

	 	$timeOut = $results['TimeOut'];
	 	$dateTimeOut = DateTime::createFromFormat("Y-m-d H:i:s", $timeOut);
	 	$finalTimeOut = date_format($dateTimeOut, "l F j, Y g:i A");
	
		echo '<tr>
	 			<th>'.$results['Fname'].'</th><th>'.$results['Lname'].'</th><th>'.$results['IP'].'</th><th>'.$results['Name'].'</th><th>'.$results['Section'].'</th><th>'
        .$results['Semester'].'</th><th>'.$finalTimeIn.'</th><th>'.$finalTimeOut.'</th><th>'.$results['TimeDiff'].'</th><th><a class="btn btn-default" href="changestamp.php?id='.$results['StampID'].'"><span class="glyphicon glyphicon-pencil"></span></a></th>
	 			</tr>';
	
	
	}
}
  ?>
  
  
  </tbody>
</table>
<div class="row-fluid">
  <div class="span8 offset2">
    <footer>
      <p class="pull-right"><a href="#">Back to top</a></p>
      <p>2013 Ball State University 2000 W. University Ave. Muncie, IN 47306· <a href="http://www.bsu.edu">bsu.edu</a></p>
    </footer>
  </div>
  <!-- /.span4 --> 
</div>
<!-- /.row --> 

<!-- Placed at the end of the document so the pages load faster --> 
<script src="dist/js/bootstrap.js"></script> 
<script src="dist/js/holder.js"></script>
<script type="text/javascript">
</script>
</body>
</html>
