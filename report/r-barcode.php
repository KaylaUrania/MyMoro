<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode</title>
    <style>
    @media print {
        @page {
            margin: 5mm; /* bebas atur margin */
        }
        body {
            margin: 0;
            -webkit-print-color-adjust: exact;
        }
    }
</style>
</head>
<body>
    <?php

    $jmlCetak = $_GET['jmlCetak'];
    for ($i=1; $i <= $jmlCetak ; $i++) { ?>
        <div style="text-align: center; width: 210px; float: left; margin-right:30px; margin-bottom:30px;">
            <?php

            $barcode = isset($_GET['barcode']) ? $_GET['barcode'] : '';
            if ($barcode == '') {
                echo "Barcode tidak di Temukan";
                exit();
            }

            require '../asset/barcodeGenerator/vendor/autoload.php';

            $generator = new Picqer\Barcode\barcodeGeneratorPNG();
            echo '<img src="data:image/png;base64,' . base64_encode ($generator->getBarcode($barcode, $generator::TYPE_CODE_128)) . '" width="200px">';
            ?>
            <div><?= $barcode ?></div>
        </div>
    <?php
    }
    ?>

    <script>
        window.print();
    </script>
</body>
</html>