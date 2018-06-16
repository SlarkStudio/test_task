<?php
/*---HUMAN SIZE FOR bytes-----*/
function human_filesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}
/*---HUMAN SIZE FOR bytes-----*/


$curr_path = $_GET['get_path'];// get current path
$files = scandir(getcwd().$curr_path);//scan dir - get all files and folders for curr pass

foreach($files as $file){	
	$f_info = new SplFileInfo(getcwd().$curr_path."/".$file);//new fileinfo obj
	$f_type = $f_info->getExtension();//file type
	if(strlen($f_type) !== 0){//if file
		$f_size = human_filesize(filesize(getcwd().$curr_path."/".$file));//file size
		$f_path = "?show_content=yes&get_path=".$curr_path."/".$file;
	}else {//if folder
		$f_size = "";//file size 0 for folder
		$f_path = "?get_path=".$curr_path."/".$file;
	}
	
	if($file == "." or $file == ".."){
		$f_datem = "";//date modified for '.' and '..' btns
	}else {		
		$f_datem = date('m/d/Y H:i:s', filemtime(getcwd().$curr_path."/".$file));//file/folder date modified
	}
	
	
	/*----EXEPTIONS FOR BACK AND ROOT BUTTONS-----*/
	if($file == ".") { $f_path = "/"; $file = "/<-script_root"; }//ROOT BUTTON
	if($file == "..") {//LEVEL UP BUTTON
		$path  = $curr_path;// ?get_path=/fold1/test/one%20more%20fold
		$pieces = explode("/", $path);		
		unset($pieces[0]);// delet first empty 
		unset($pieces[count($pieces)]);//delete last one
		foreach ($pieces as $piece) {
			$urlka .= "/".$piece;//create new url for "back" btn
		}
		$f_path = "/?get_path=$urlka";
	}
	/*----EXEPTIONS FOR BACK AND ROOT BUTTONS-----*/
	
	$table .= "<tr>";
	$table .= "<td><a href='$f_path'>$file</a></td>";
	$table .= "<td class='size'>".$f_size."</td>";
	$table .= "<td class='date'>".$f_datem."</td>";
	$table .= "<td class='type'>".$f_type."</td>";
	$table .= "</tr>";
}
?>


<div class="addr_div"><?php echo "<b>YOUR'RE HERE:  </b>".getcwd().$curr_path; ?></div><br><br>
<table id="sorted_tbl" class="tablesorter">
	<thead> 
		<tr>
		   <th>File Name</th>
		   <th class="size">Size</th>
		   <th class="date">Date modif.</th>
		   <th class="type">type</th>
		</tr>
	</thead> 
	<body> 
		<?php echo $table; ?>
	</body> 
</table>
<?php
if($_GET['show_content'] == "yes"){
	echo "<a href='http://1200501.nightmar.web.hosting-test.net'>/script_root</a></br></br>";
	echo "<a href=".$_SERVER['HTTP_REFERER']."><<--back</a></br></br>";
	echo "<xmp>";
		echo trim(file_get_contents("http://1200501.nightmar.web.hosting-test.net/".$_GET['get_path']));
	echo "</xmp>";	
}
?>


<style>
xmp {
    background: lightblue;
    padding: 10px;
    border: 2px solid red;
	white-space: pre-wrap;
}
.addr_div {
	padding: 10px;
	border: 2px solid red;
	margin: 0px;
}
td,th {
	padding: 10px;
	border: 2px solid red;
}
* {
    margin:10;
    padding:0;
}

html, body {
    background-color:#fff;
}

table.tablesorter {
	font-family:"Trebuchet MS", Tahoma, Verdana, Arial, Helvetica, sans-serif;
	background-color: #CDCDCD;
	margin:10px 0pt 15px;
	font-size: 13px;
	width: 100%;
	text-align: left;
}
table.tablesorter thead tr th, table.tablesorter tfoot tr th {
	background-color: #B1DB87;
	border: 1px solid #FFF;
	font-size: 13px;
	padding: 4px;
	padding-right: 20px;
}
table.tablesorter thead tr .header {
	background-image: url(icon/tablesorter-bg.gif);
	background-repeat: no-repeat;
	background-position: center right;
	cursor: pointer;
}
table.tablesorter tbody td {
	color: #3D3D3D;
	padding: 4px;
	background-color: #FFF;
	vertical-align: top;
}
table.tablesorter tbody tr.odd td {
	background-color:#E0F4D7;
}
table.tablesorter thead tr .headerSortUp {
	background-image: url(icon/tablesorter-asc.gif);
}
table.tablesorter thead tr .headerSortDown {
	background-image: url(icon/tablesorter-desc.gif);
}
table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
	background-color: #83C948;
}
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#sorted_tbl").tablesorter({ widgets: ['zebra']});
});
</script>