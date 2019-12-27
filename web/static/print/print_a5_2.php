<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8;">
    <!--  <meta name=ProgId content=Word.Document>-->
    <title></title>
    <style >

    </style>
    <style type="text/css" media="print">
        @page
        {
            size: auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }
        @media print {
            .header, .hide { visibility: hidden }
        }
        @font-face {
            font-family: Arial;
            panose-1: 2 11 6 4 3 5 4 4 2 4;
            mso-font-charset: 204;
            mso-generic-font-family: swiss;
            mso-font-pitch: variable;
            mso-font-signature: -520077569 -1073717157 41 0 66047 0;
        }

       /* @page :left {
            size: 5.83in 8.27in;
            margin-left: 2cm;
            margin-right: 1cm;
        }

        @page :right {
            size: 5.83in 8.27in;
            margin-left: 1cm;
            margin-right: 2cm;
        }
*/
        body {
            background: red;
        }

        .conteiner > .code {
            text-align: center;
            font-size: 80px;
        }

        .conteiner > .conteinerForBarCode > p {
            text-align: center;
        }

        .conteiner > .discription {
            text-align: center;
        }

        .conteiner > .namequeue {
            text-align: center;
        }

        .conteiner {
            position: relative;
        }

        .conteiner > .date {
            position: absolute;
            right: 0;
            bottom: 0;

        }
    </style>
</head>

<body style="min-height:60px;width: 300px">
<div class="conteiner" style="margin-top: 50px;">

    <div class="namequeue">
       <?php if ($_GET['namequeue']) {
            echo $_GET['namequeue'];
        } ?>
    </div>
    <div class="discription">Ваш номер в очереди</div>
    <div class="code">
        <?php  if (isset($_GET['talon_code'])) {
            echo $_GET['talon_code'];
        }
        ?>
    </div>
    <div class="conteinerForBarCode">
      <!--  <p><img alt="testing" src="barcode.php?text=<?/*= $_GET['barcode'] */?>"/></p>-->

       <p><?= $_GET['barcode'] ?></p>

        <p><?= date("d.m"); ?>&nbsp;<?= date("G:i"); ?></p>
    </div>
</div>

<div id="testValue"></div>
</body>

</html>
