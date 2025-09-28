<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$company_id = $user['company_id'];

if(isset($_POST['import_excel'])){
    $file = $_FILES['excel']['tmp_name'];
    require 'vendor/autoload.php'; // PhpSpreadsheet kullanımı

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    foreach($sheet->getRowIterator(2) as $row){
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        $data = [];
        foreach ($cellIterator as $cell) {
            $data[] = $cell->getValue();
        }
        // Örn: $data[0]=name, $data[1]=phone veya price
        $stmt = $pdo->prepare("INSERT INTO customers (company_id, name, phone) VALUES (?,?,?)");
        $stmt->execute([$company_id, $data[0], $data[1]]);
    }
    $message = "Excel import tamamlandı!";
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="excel" accept=".xlsx, .xls">
    <button type="submit" name="import_excel">Yükle</button>
</form>
<?php if(isset($message)) echo $message; ?>
