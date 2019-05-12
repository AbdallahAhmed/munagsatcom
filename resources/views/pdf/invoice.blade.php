<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Page Description">
    <meta name="author" content="gimi">
    <link href="https://fonts.googleapis.com/css?family=Tajawal:400,500&amp;subset=arabic" rel="stylesheet">
    <title>فاتورة مبيعات</title>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        @import url('https://fonts.googleapis.com/css?family=Tajawal:400,500&subset=arabic');
    </style>
    <style>

        * {
            font-family: 'Tajawal', sans-serif
        }

        @media print {
            /* styles go here */
            .table-header td, .table-header tr {
                background-color: #366a96;
                color: #ffffff;
                font-size: 20px;
                padding: 18px;
                font-weight: 500
            }
        }

        .table-header td, .table-header tr {
            background-color: #366a96;
            color: #ffffff;
            font-size: 20px;
            padding: 18px;
            font-weight: 500
        }

        .col-6 {
            width: 50%;
        }
    </style>

</head>
<body dir="rtl">
<header>
    <table width="800px" style="margin: auto;margin-top: 100px">
        <tr>
            <td width="50%">
                <img src="{{asset('assets/images/logo.jpg')}}" alt="">
            </td>
            <td width="50%"
                style="text-align: left;color: #646464;font-size: 22px;font-family: 'Tajawal', sans-serif;font-weight: 700;line-height: 2rem;">
                <span>‫شركة ‫مناقصاتكم‬ ‬المحدودة‬</span>
                <br>
                <span>{{'‫هاتف‬'}}:</span><span>‫‪920008769‬‬</span> ‫‪
                <br>
                <span>‫‪info@munagasatcom.com‬‬</span>
            </td>
        </tr>
    </table>
</header>
<main>
    <table style="margin: auto;margin-top: 80px">
        <tr>
            <td width="33.3%"></td>
            <td width="33.3%" style="color: #646464 ;font-size: 22px;"><span>فاتورة مبيعات</span></td>
            <td width="33.3%"></td>
        </tr>
    </table>
    <table width="800px" style="margin: auto;margin-top: 25px;" cellpadding="0" cellspacing="0" class="table-header">
        <tr style="background-color: #366a96;padding: 8px">
            <td width="50%"><span>رقم الفاتورة:465456465</span>
            </td>
            <td width="50%"><span>التاريخ:15/3/2017</span></td>
        </tr>
    </table>

    <table width="800px" style="margin: auto;" cellpadding="0" cellspacing="0">
        <tr style="background-color: #dadada;">
            <th width="50%" style="font-size: 16px;padding: 10px;font-weight: 100;">البيان</th>
            <th width="50%" style="font-size: 16px;padding: 10px;font-weight: 100;">القيمة</th>
        </tr>
        <tr>
            <td style="text-align: center;color:  #646464;padding: 10px">فرع الدنيا</td>
            <td style="text-align: center;color:  #646464;padding: 10px">100</td>
        </tr>
    </table>
    <hr width="800px" style="margin: auto;">

</main>
<footer></footer>
</body>
<script>
    window.print()
</script>
</html>

