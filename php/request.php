<?php
require_once('phpmailer/PHPMailerAutoload.php');
require_once('chart_generator.php');

$sum = $_POST['sum'];
$term = $_POST['term'];
$percent = $_POST['percent'];
$i = $_POST['i'];
define('i',$i);
$p = $_POST['p'];
define('p',$p);
$y = $_POST['y'];
define('y',$y);
define("lastname", $_POST['lastname']);
define("firstname", $_POST['firstname']);
define("middlename", $_POST['middlename']);
define("tel", $_POST['tel']);
define("date", $_POST['date']);
$date = date('d.m.Y', strtotime(date));
$date = new DateTime($date);
define("total", $sum);
define("months", $term * 12);



$dataForEmail = getParams($sum, months, i, p, $date);
$date = new DateTime($dataForEmail[months]["date"]);
$date = $date->format('Y.m.d');


$html = "<p>" . lastname . " " . firstname . " " .  middlename . " отправил/-а заявку на кредит через форму для расчёта кредита по схеме \"Аннуитет\".<p>";
$html .= "<p>Полученные данные от клиента:</p>";
$html .= "<ul>";
        if ($sum != ''){$html .="<li>Сумма кредита - " . number_format($sum, 2, ",", " ") . " руб.</li>";};
        if ($sum != '' and percent != ''){ $html .= "<li>Срок кредитования - " . term . " лет</li>";};
        if (percent != ''){$html .="<li>Процентная ставка - " . percent . "% в год</li>";};
            $html .="<li>Фамилия - " . lastname . "</li>
            <li>Имя - " . firstname . "</li>";
        if (middlename != ''){$html .="<li>Отчество - " . middlename . "</li>";};
            $html .="<li>Контактный телефон - <a href=\"tel:" . tel . "\">" . tel . "</a></li></ul>";


$html .= "<p>Кредитные данные, рассчитанные по схеме \"Аннуитет\":</p>";
if ($sum == '' or percent == '') {
    $html .= "Клиент не ввел необходимые для рассчёта данные.";
}
else {
    $html .= "<ul>
                <li>Сумма ежемесячных отчислений - " . number_format(round(p, 2), 2, ",", " ") . " руб.</li>
                <li>Сумма выплаченных процентов - " . number_format(round(y, 2), 2, ",", " ") . " руб.</li>
                <li>Ежемесячная процентная ставка - " . round(i, 6) . "%.</li>
                <li>Дата последнего платежа - " . $date . " г.</li>
                <li>График погашения аннуитетных платежей:</li></ul><br />";


$html .= "<table style=\"border: 1px solid black;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0\" width=\"max-content\"> 
            <tr> 
                <td><center style=\"max-width: 600px; \">
                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0\" width=\"100%\">
                        <tr align=\"center\" style=\"\">
                            <td style=\"padding: 3px 10px;border-right: 1px solid black;\">" . $dataForEmail[0]["date_col"]  . "</td>
                            <td style=\"padding: 3px 10px;border-right: 1px solid black;\">" . $dataForEmail[0]["month_col"]  . "</td>
                            <td style=\"padding: 3px 10px;border-right: 1px solid black;\">" . $dataForEmail[0]["percent_col"]  . "</td>
                            <td style=\"padding: 3px 10px;border-right: 1px solid black;\">" . $dataForEmail[0]["total_col"]  . "</td>
                            <td style=\"padding: 3px 10px;\">" . $dataForEmail[0]["debt_col"]  . "</td>
                        </tr>";


for ($i = 1; $i <= months; $i++) {
$html .=                "<tr style=\"\"> 
                            <td style=\"padding: 7px 3px;text-align: center;border-right: 1px solid black;border-top: 1px solid black;\">" . $dataForEmail[$i]["date"]  . "</td>
                            <td style=\"padding: 7px 3px;text-align: right;border-right: 1px solid black;border-top: 1px solid black;\">" . number_format($dataForEmail[$i]["p"], 2, ",", " ") . "</td>
                            <td style=\"padding: 7px 3px;text-align: right;border-right: 1px solid black;border-top: 1px solid black;\">" . number_format($dataForEmail[$i]["in"], 2, ",", " ")  . "</td>
                            <td style=\"padding: 7px 3px;text-align: right;border-right: 1px solid black;border-top: 1px solid black;\">" . number_format($dataForEmail[$i]["s"], 2, ",", " ")  . "</td>
                            <td style=\"padding: 7px 3px;text-align: right;border-top: 1px solid black;\">" . number_format($dataForEmail[$i]["sn2"], 2, ",", " ")  . "</td>
                        </tr>";
}

$html .=                "<tr style=\"\"> 
                            <td style=\"padding: 7px 3px;text-align: center;border-right: 1px solid black;border-top: 1px solid black;\">" . $dataForEmail[months + 1]["summary_string"]  . "</td>
                            <td style=\"padding: 7px 3px;text-align: right;border-right: 1px solid black;border-top: 1px solid black;\">" . number_format($dataForEmail[months + 1]["summary"], 2, ",", " ")  . "</td>
                            <td style=\"padding: 7px 3px;text-align: right;border-right: 1px solid black;border-top: 1px solid black;\">" . number_format($dataForEmail[months + 1]["summary_percent"], 2, ",", " ")  . "</td>
                            <td style=\"padding: 7px 3px;text-align: right;border-right: 1px solid black;border-top: 1px solid black;\">" . number_format($dataForEmail[months + 1]["total"], 2, ",", " ")  . "</td>
                            <td style=\"padding: 7px 3px;text-align: right;border-top: 1px solid black;\">" . $dataForEmail[months + 1]["empty"]  . "</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>";

};

$mail = new PHPMailer;
$mail->CharSet = 'utf-8';
$mail->isSMTP();
$mail->Host = 'smtp.timeweb.ru';                                                                                            
$mail->SMTPAuth = true;
$mail->Username = 'xander11rgn@cj86520.tmweb.ru';
$mail->Password = '19734655643791a';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->setFrom('xander11rgn@cj86520.tmweb.ru');
$mail->addAddress('xander11rgn-cool@yandex.ru');
$mail->addReplyTo('xander11rgn@cj86520.tmweb.ru', 'Антон');                      
$mail->isHTML(true);
$mail->Subject = 'Заявка на кредитование';
$mail->Body = $html;

if (!$mail->send()) {
    echo $mail->ErrorInfo;
    exit();
} else {
    if ($sum != '' and percent != ''){
        $term = term;
        $percent = percent;
        $i = round(i,6);
        $p = round(p,2);
        $y = round(y,2);
        $dataForEmail = json_encode($dataForEmail, JSON_UNESCAPED_UNICODE);
    } else {
        $sum = null;
        $term = null;
        $percent = null;
        $i = null;
        $p = null;
        $y = null;
        $date = null;
        $dataForEmail = null;
    }
    
    feedbackDB($sum, $term, $percent, lastname, firstname, middlename, tel, $i, $p, $y, $date, $dataForEmail);
    
}


function feedbackDB($sum, $term, $percent, $lastname, $firstname, $middlename, $tel, $i, $p, $y, $date, $chartData)
{
    $servername = "localhost";
    $username = "root";
    $password = "root";

    try {
        $conn = new PDO("mysql:host=$servername; dbname=annuitet", $username, $password);
        $query = "INSERT INTO request (sum, term, percent, lastname, firstname, middlename, tel, monthlyPercent, monthlyPayment, totalPercentPayment, endDate, paymentChart) 
                  VALUES (:sum, :term, :percent, :lastname, :firstname, :middlename, :tel, :i, :p, :y, :date, :chartData)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['sum' => $sum, 'term' => $term, 'percent' => $percent, 
                        'lastname' => $lastname, 'firstname' => $firstname,'middlename' => $middlename,
                        'tel' => $tel,'i' => $i,'p' => $p,'y' => $y, 'date' => $date, 'chartData' => $chartData]);
        $conn = null;
        $stmt = null;
        echo 'Success';
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};
