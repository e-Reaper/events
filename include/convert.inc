<?php
//convertdate will convert date format from mm/dd/yyyy to yyyy/mm/dd so that event can be searched according to date
function convertdate($date){
echo $date;
$arr=explode("/",$date);
$value= "$arr[2]/$arr[0]/$arr[1]";
return $value;
}

//convertdate will convert date format from yyyy/mm/dd to mm/dd/yyyy so that event can be used for edit event form in event page
function convertDateForForm($date){
if($date!="")
{
$arr=explode("/",$date);
$value= $arr[1]."/".$arr[2]."/".$arr[0];
return $value;
}
else
{
	return "";
}
}


//converttime will convert time from 12 hour format to 24 hour format so that event can be searched according to time
function converttime($time){
$arr2=explode(":",$time);
$time1=$arr2[0];
$time2=substr($arr2[1],0,2);
$time3=substr($arr2[1],2,2);
if($time3=="am" && $time1==12)
     $time1-=12;
if($time3=="pm" && $time1!=12)
 $time1+=12;

 $time= "$time1:$time2";
 return $time;
}

//convertdateback will convert date format from yyyy/mm/dd to dd month yyyy so that it look better while displaying
function convertdateback($date)
{
$arr=explode("/",$date);
  switch($arr[1])
  {
	case '1': $month="January";
			break;
	case '2': $month="February";
			break;
	case '3': $month="March";
			break;
	case '4': $month="April";
			break;
	case '5': $month="May";
			break;
	case '6': $month="June";
			break;
	case '7': $month="July";
			break;
	case '8': $month="August";
			break;
	case '9': $month="September";
			break;
	case '10': $month="October";
			break;
	case '11': $month="November";
			break;
	case '12': $month="December";
			break;
  }
  $date="$arr[2] $month $arr[0]";
 return $date;
}
//converttimeback will convert time from 24 hour format to 12 hour format 
function converttimeback($time){
if($time=="") return "";
$arr2=explode(":",$time);
  $time1=$arr2[0];
  if($time1<12)
     $time3="am";
  else if($time1>12)
	{
	$time1-=12;
	$time3="pm";
	}
 $time="{$time1}:{$arr2[1]} $time3";
  
 return ",".$time;
 }
?>