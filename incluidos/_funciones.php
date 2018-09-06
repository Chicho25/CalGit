<?php 
function DMAtoAMD($cdate){
    list($day,$month,$year)=explode("/",$cdate);
    return $year."-".$month."-".$day;
}
function AMDtoDMA($cdate){
    list($year,$month,$day)=explode("-",$cdate);
    return $day."/".$month."/".$year;
}


?>