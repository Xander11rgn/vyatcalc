<?php
$sum = $_POST['sum'];
define("term", $_POST['term']);
define("percent", $_POST['percent']);
define("lastname", $_POST['lastname']);
define("firstname", $_POST['firstname']);
define("middlename", $_POST['middlename']);
define("tel", $_POST['tel']);
define("i", $_POST['i']);
define("p", $_POST['p']);
define("y", $_POST['y']);
define("date", $_POST['date']);
$date = date('d.m.Y', strtotime(date));
$date = new DateTime($date);
define("total", $sum);
define("months", term * 12);



function getParams($sum, $months, $i, $p, $date)
{
  
  $chartData = [];

  $chartData[0]["date_col"] = "Дата";
  $chartData[0]["month_col"] = "Ежемесячный платёж, руб.";
  $chartData[0]["percent_col"] = "Погашение процентов, руб.";
  $chartData[0]["total_col"] = "Погашение кредита, руб.";
  $chartData[0]["debt_col"] = "Остаток долга, руб.";



  for ($j = 1; $j <= $months; $j++) {
    $chartData[$j] = [];
    $in = $sum * $i;
    $s = $p - $in;
    $sn2 = $sum - $s;
    $chartData[$j]["date"] = $date->format('d.m.Y');
    $chartData[$j]["p"] = round($p, 2);
    $chartData[$j]["in"] = round($in, 2);
    $chartData[$j]["s"] = round($s, 2);
    $chartData[$j]["sn2"] = round($sn2, 2);
    $sum =  $chartData[$j]["sn2"];
    $date->add((new DateInterval('P1M')));
  }
  $chartData[$months]["sn2"] = number_format(0, 2, ",", " ");

  $chartData[$months + 1]["summary_string"] = "Итого";
  $chartData[$months + 1]["summary"] = round($p * $months, 2);
  $chartData[$months + 1]["summary_percent"] = round($p * $months - total, 2);
  $chartData[$months + 1]["total"] = round(total, 2);
  $chartData[$months + 1]["empty"] = "";
  return $chartData;
};

$chartData = getParams($sum, months, i, p, $date);

echo "<div class=\"table\"> 
        <div class=\"table__row\"> 
          <div>" . $chartData[0]["date_col"]  . "</div>
          <div>" . $chartData[0]["month_col"]  . "</div>
          <div>" . $chartData[0]["percent_col"]  . "</div>
          <div>" . $chartData[0]["total_col"]  . "</div>
          <div>" . $chartData[0]["debt_col"]  . "</div>
        </div>";


for ($i = 1; $i <= months; $i++) {
  echo "<div class=\"table__row\"> 
        <div>" . $chartData[$i]["date"]  . "</div>
        <div>" . number_format($chartData[$i]["p"], 2, ",", " ") . "</div>
        <div>" . number_format($chartData[$i]["in"], 2, ",", " ")  . "</div>
        <div>" . number_format($chartData[$i]["s"], 2, ",", " ")  . "</div>
        <div>" . number_format($chartData[$i]["sn2"], 2, ",", " ")  . "</div>
      </div>";
}

echo "<div class=\"table__row\"> 
        <div style=\"text-align: center;\">" . $chartData[months + 1]["summary_string"]  . "</div>
        <div>" . number_format($chartData[months + 1]["summary"], 2, ",", " ")  . "</div>
        <div>" . number_format($chartData[months + 1]["summary_percent"], 2, ",", " ")  . "</div>
        <div>" . number_format($chartData[months + 1]["total"], 2, ",", " ")  . "</div>
        <div>" . $chartData[months + 1]["empty"]  . "</div>
      </div>
    </div>";
