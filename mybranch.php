<?php
session_start();	
	$db=mysql_connect('localhost','students_sachin','!sn;2614');
	mysql_select_db('students_network',$db);
	$email=$_SESSION['email'];
	$query="select * from details where email='$email'";
	$row=mysql_query($query,$db);
	$values=mysql_fetch_array($row);
	$college=$values['college'];
	setcookie('condition',"type=1 and college='{$college}'",time()+9999999);
	require_once("header.php");
	$_SESSION['val']=10;
?>
<div id='outline_wrapper' >

<aside id="left">

<div id="Profile">
    <div id="college">
        <div id="profile_top">
            <?php 
			$email=$_SESSION['email'];
			$query="select * from details where email='$email'";
			$row=mysql_query($query,$db);
			$values=mysql_fetch_array($row);
			$name=$values['firstname'];
			$college=$_GET['college'];
			$points=$values['points'];
			$query="select path from colleges where  college='$college'";
			$p=mysql_query($query,$db);
			$r=mysql_fetch_array($p);	
			 $src=$r['path'];		
      echo "<div id='college_image'><a href=''><img src='{$src}' height='100' width='150' id='pic' ></a></div>
        </div>
        <div id='college_bottom'>
		<ul>
            <li id='college_name'><a href='other_college.php?college=$college'>$college</a></li>
		</ul>";
			?>
        </div>
    </div>
</div>

<div id="my_network"><a href="mynetwork.php"><div align="center"></div></a></div>
<div class="rank">Top contibutors</div>
<div id="rank_top">
 <?php 
			mysql_query("set @row:=0",$db);
			$query="select rank,firstname,points,path,college from(select @row:=@row+1 as rank,firstname,points,path,college,id from details order 
			by points desc )as result where college='{$college}'"; 
			$s=mysql_query($query,$db);
			$i=0;
			while($row=mysql_fetch_array($s)){
				if($i++==3)
				break;
				$name=$row['firstname'];
				$points=$row['points'];
				$src=$row['path'];	
				 echo "<div class='rankers'><div class='rank_images1'><a href='#'><img src='{$src}' height='40' width='40'></a></div>
			<div class='rank_names1'><a href='other_student.php?email={$email}'>$name($points)</a></div></div>";		
			}
?>	
</div>

</aside>
<div id='outline'>
<?php
require_once("functions/functions.php");
$email=$_SESSION['email'];
$values=get_info($email);
$branch=$values['branch'];
echo"<div id='middle'>  <div class='discuss_sub_heading'> latest in  $branch </div>
	<div id='college_share_wrap'>
		
	</div>";
   
	    require_once('functions/functions.php');
            $email1=$_SESSION['email'];	
		$user=get_info($email1);
	 $mybranch=$user['branch'];
           $query="select * from updateall where type=1 and college='{$college}' order by id DESC ";
            $r=mysql_query($query,$db);		
            while($x=mysql_fetch_array($r)){
		$subject=$x['subject'];
                 $query="select * from branch_subject where subject='{$subject}' and branch='{$mybranch}'";
                $r1=mysql_query($query,$db);
                if(!mysql_affected_rows()) { continue; }
                
		$details=nl2br(htmlspecialchars($x['details']));
		$details=similey($details);
		$text = $details;	
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";		
		if(preg_match($reg_exUrl, $text, $url)) {
		       $details=preg_replace($reg_exUrl, '<a href="'.$url[0].'" rel="nofollow" target="_blank">'.$url[0].'</a>', $text);
		
		} else {
		       $details=$text;
		
		}
		$email=$x['email'];
		$values=get_info($email);
                $src=$values['path'];
                $name=$values['firstname'];
                $college=$values['college'];
		$recommended=$x['recommended'];
		$offensive=$x['offensive'];
		$date=$x['time'];
		$path=$x['path'];
		$id=$x['id'];
		$email1=$_SESSION['email'];
		require_once("functions/functions.php");	
		$user=get_info($email1);
		$userid=$user['id'];
		mysql_query("set @row:=0",$db);
		$query="select rank,email,points from(select @row:=@row+1 as rank,id,email,points from details order by points desc)as result where 				email='{$email}'"; 
		$s=mysql_query($query,$db);
		$row=mysql_fetch_array($s);
		$rank=$row['rank'];
		$points=$row['points'];
		$art=$id;
      	 echo "<div class='news' i='$id' id='art$id'>
		<div class='news_top'>
			<div class='news_image' email='$email' >			
				<a href='other_student.php?email=$email' upid='$id' class='news_img' i='$id' email='$email' rank='$rank' points='$points'>
				<img src='{$src}' width='40' height='40'></a>
			</div>
			<div class='news_user'>
				<a href='other_student.php?email={$email}'>{$name}</a>,<a href='other_college.php?college={$college}'>{$college}</a>
				<div class='date'>$date</div>
			</div>
			</div>
			<div class='$id news_points'  style='display:none' >
				<div class='news_po' email='$email' i='$id' id='net$id'>
					
				</div>
			</div>
		"; 
	if($_SESSION['email']==$email)
			echo "<div><a href='' email='$email' class='delete_art' id='del$art' oid='$art'>del</a></div>";
		echo "<div class='news_details'>{$details}</div>
		<div class='down_sec' align='center'>";
			if($path!='no'){
						$e=get_type($path);
					 	echo $e;
				 }
				 echo"
		</div>
	  <div><a href='' id='$id' class='comments'>comments";
		   $query="select * from comment where art_id='{$id}'";
		   mysql_query($query,$db);
		  echo "<span class='commcount'>(".mysql_affected_rows().")</span>";
		   echo "<img src='images/collapse.png'  class='doubt_img'/></a></div>
	
	<div class='com_waiting$id commm' style='position:absolute; left:230px; display:none'><img src='images/waiting.gif' width='30' 
	height='30'/></div>
	     <div ><a href='' id='c$id' pa='$art' style='display:none' class='clo'>comments<img src='images/expand.png'  class='doubt_img'/></a></div>
		<div class='reply_form{$id}' style='display:none'>
			<output id='comment$id'></output>
			<textarea id='area$id' class='comm' rows='2' cols='60'></textarea>
			<input type='submit' class='subm button_submit' art_id='$art' email='$email' value='reply'>
		</div>
	<div class='news_wrapper' >
		<div class='news_content'>
			 <div class='news_buttons'><a href='#' tbl='2' class='recommended' article_id='$id' id='$userid' email='$email'> 
			 recommended($recommended)</a></div>
			 <div class='news_buttons'><a href='#' tbl='2'class='offensive' article_id='$id' email='$email'>offensive</a></div>";
			 echo"
		</div>
	</div>
</div >";
        }
        
    echo "</div>";
?>
</div>

<aside id="right">
        <ul id="sub">
            <h4>Subjects</h4>
            <?php
				$email=$_SESSION['email'];
				require_once('functions/functions.php');
				$values=get_info($email);
				$branch=$values['branch'];
				$college=$_GET['college'];
				$query="select subject from branch_subject where branch='$branch' and college='$college'";
				$s=mysql_query($query,$db);
				while($row=mysql_fetch_array($s)){
					$sub=$row['subject'];
		          echo "<li><div class='sub_name'><a href='branch_middle.php?branch={$branch}&college={$college}&subject={$sub}' class='branch_sub'  >$sub</a></div></li>";
				}
			?>
        </ul>
         <div id='man'><a href="other_college.php?college=<?php echo $college; ?>">back to college</a></div>
        <div id='man'><a href="branch.php?college=<?php echo $college; ?>">check other branches</a></div>
 </aside>
</div>

<footer id="footer"><div id='foot'>Copyright &copy 2012 students-network.com. All pages of the website are subject to our terms and condition and privacy policy.U must not reproduce, duplicate, sell, resell or exploit any material on the website for any commercial purpose without written permission from admin.</div></footer><script type="text/javascript" src="js/jquery.js"></script>       
<script type="text/javascript" src="js/index.js"></script>
   <?php 	mysql_close($db); ?>
   </div>
</div>
</body>
</html>