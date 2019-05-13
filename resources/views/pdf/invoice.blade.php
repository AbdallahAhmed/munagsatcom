<style>
    .table-header td, .table-header tr {
        background-color: #366a96;
        color: #ffffff;
        font-size: 18px;
        padding: 18px;
        font-weight: 500
    }

    .result {
        color: #366a96;
        font-size: 16px;
        font-weight: bold;
    }
</style>
<table style="margin-top: 100px">
    <tr>
        <td width="50%">
            <img src="{{asset('assets/images/logo.jpg')}}" alt="">
        </td>
        <td width="50%"
            style="text-align: left;color: #646464;font-size: 18px;font-weight: 700;">
            <span>‫شركة ‫مناقصاتكم‬ ‬المحدودة‬</span>
            <br>
            <span>{{'‫هاتف‬'}}:</span><span>‫‪920008769‬‬</span> ‫‪
            <br>
            <span>‫‪info@munagasatcom.com‬‬</span>
        </td>
    </tr>
</table>
<br><br><br>
<table style="margin-top: 80px">
    <tr>
        <td width="33.3%"></td>
        <td width="33.3%" style="color: #646464 ;font-size: 16px;text-align: center"><span>فاتورة مبيعات</span></td>
        <td width="33.3%"></td>
    </tr>
</table>
<br><br>
<table style="margin-top: 25px;" cellpadding="10" cellspacing="0" class="table-header">
    <tr style="background-color: #366a96;padding: 8px">
        <td width="50%"><span>رقم الفاتورة:{{$transaction->id}}</span>
        </td>
        <td width="50%" style="text-align: left"><span>التاريخ:{{$transaction->created_at->format('d/m/Y')}}</span></td>
    </tr>
</table>

<table style="" cellpadding="5" cellspacing="0">
    <tr style="background-color: #dadada;">
        <th width="50%" style="font-size: 16px;font-weight: 100;text-align: center">البيان</th>
        <th width="50%" style="font-size: 16px;font-weight: 100;text-align: center">القيمة</th>
    </tr>
    <tr>
        <td style="text-align: center;color:  #646464;padding: 10px">{{$transaction->type}}</td>
        <td style="text-align: center;color:  #646464;padding: 10px">{{$transaction->points - $transaction->tax }}  ريال سعودى</td>
    </tr>
</table>
<hr>
<table style="" cellpadding="5" cellspacing="0" class="result">
    <tr>
        <td style="width: 50%"></td>
        <td style="width: 50%">
            <table cellspacing="0" cellpadding="15">
                <tr style="border-bottom: 1px gray !important;">
                    <td style=" border-bottom: 1px gray !important;">‫فرعي‬ ‫المجموع‬</td>
                    <td style="text-align: left; border-bottom: 1px gray !important;">{{$transaction->points - $transaction->tax}}</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px gray !important;">‫‫المضافة‬ ‫القيمة‬</td>
                    <td style="text-align: left;border-bottom: 1px gray !important;">{{ $transaction->tax}}</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px gray !important;">‫‫الكلي‬ ‫المجموع‬‬</td>
                    <td style="text-align: left;border-bottom: 1px gray !important;">{{$transaction->points}}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br><br><br><br>
<table style="margin-top: 80px">
    <tr>
        <td width="33.3%"></td>
        <td width="33.3%" style="color: #646464 ;font-size: 18px;text-align: center"><span> نشكركم على ثقتكم بنا</span>
        </td>
        <td width="33.3%"></td>
    </tr>
</table>
