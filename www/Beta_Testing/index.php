<!DOCTYPE html>
<html>
<head>
	<title>Starter</title>
</head>
<body>
<?php

	echo "<h1>Beta testing <br></h1>";

?>
<a href="http://127.0.0.1:8080/forms/">Forms</a>
<?php
   # This is a comment, and
   # This is the second line of the comment
   
   // This is a comment too. Each style comments only

   print "Forms<br>";
   
   $int_var = 45;

   echo "$int_var<br>";



   $my_var = NULL;
   $my_var = null;

   $variable = "name";
   $literally = 'My $variable will not print!';
   print($literally);
   print "<br>";
   
   $literally = "My $variable will print!<br>";
   print($literally);

//   print "<br><br><br><br>"


/*
\n is replaced by the newline character
\r is replaced by the carriage-return character
\t is replaced by the tab character
\$ is replaced by the dollar sign itself ($)
\" is replaced by a single double-quote (")
\\ is replaced by a single backslash (\)
*/

define("MINSIZE", 50);
   
   echo MINSIZE;
   print "<br>";
   echo constant("MINSIZE"); // same thing as the previous line
   print "<br>";
   print "<br>";

         $d=date("D");
         echo "$d <br>";
         echo "__LINE__ <br><br>";
         if ($d=="Fri")
            echo "Have a nice weekend!"; 
         
         else
            echo "Have a nice day!<br><br>"; 
      

$array = array( 1, 2, 3, 4, 5);
         
         foreach( $array as $value )
         {
            echo "Value is $value <br />";

            if ($value == 3)
            {
				break;

            }
         }



          $string1="Hello World";
   $string2="1234";
   
   echo $string1 . " " . $string2;









function getBrowser()
         { 
 $u_agent = $_SERVER['HTTP_USER_AGENT']; 
            $bname = 'Unknown';
            $platform = 'Unknown';
            $version= "";
            
            //First get the platform?
            if (preg_match('/linux/i', $u_agent)) {
               $platform = 'linux';
            }
            
            elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
               $platform = 'mac';
            }
            
            elseif (preg_match('/windows|win32/i', $u_agent)) {
               $platform = 'windows';
            }
            
            // Next get the name of the useragent yes seperately and for good reason
            if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
            {
               $bname = 'Internet Explorer';
               $ub = "MSIE";
            }
            
            elseif(preg_match('/Firefox/i',$u_agent))
            {
               $bname = 'Mozilla Firefox';
               $ub = "Firefox";
            }
            
            elseif(preg_match('/Chrome/i',$u_agent))
            {
               $bname = 'Google Chrome';
               $ub = "Chrome";
            }
            
            elseif(preg_match('/Safari/i',$u_agent))
            {
               $bname = 'Apple Safari';
               $ub = "Safari";
            }
            
            elseif(preg_match('/Opera/i',$u_agent))
            {
               $bname = 'Opera';
               $ub = "Opera";
            }
            
            elseif(preg_match('/Netscape/i',$u_agent))
            {
               $bname = 'Netscape';
               $ub = "Netscape";
            }
            
            // finally get the correct version number
            $known = array('Version', $ub, 'other');
            $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
            
            if (!preg_match_all($pattern, $u_agent, $matches)) {
               // we have no matching number just continue
            }
            
            // see how many we have
            $i = count($matches['browser']);
            
            if ($i != 1) {
               //we will have two since we are not using 'other' argument yet
               
               //see if version is before or after the name
               if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                  $version= $matches['version'][0];
               }
               else {
                  $version= $matches['version'][1];
               }
            }
            else {
               $version= $matches['version'][0];
            }
            
            // check if we have a number
            if ($version==null || $version=="") {$version="?";}
            return array(
               'userAgent' => $u_agent,
               'name'      => $bname,
               'version'   => $version,
               'platform'  => $platform,
               'pattern'   => $pattern
            );
         }
         
         // now try it
         $ua=getBrowser();
         $yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
         
         print_r($yourbrowser);




print "<br><br>";



 srand( microtime() * 1000000 );
         $num = rand( 1, 4 );
         
         switch( $num )
         {
            case 1: $image_file = "1.jpg";
               break;
            
            case 2: $image_file = "2.jpg";
               break;
            
            case 3: $image_file = "3.jpg";
               break;
            
            case 4: $image_file = "4.jpg";
               break;
         }
         echo "Random Image : <img src=$image_file />";







?>
</body>
</html>