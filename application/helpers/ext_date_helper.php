<?php
function date_std_mysql($std)
{
  $sdate = explode('/',$std);
  $m = $sdate[0];
  $d = $sdate[1];
  $y = $sdate[2];
  $date = "$y-$m-$d";
  return $date;
}