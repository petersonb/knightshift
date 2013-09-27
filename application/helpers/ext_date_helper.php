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

function date_mysql_std($mysql)
{
  $sdate = explode('-',$mysql);
  $m = $sdate[1];
  $d = $sdate[2];
  $y = $sdate[0];
  $date = "$m/$d/$y";
  return $date;
}

function date_twelve_to_24($time)
{
  return DATE("H:i:00", STRTOTIME($time));
}

function date_24_to_twelve($time)
{
  return DATE("g:i a", STRTOTIME($time));
}