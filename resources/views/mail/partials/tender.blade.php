@foreach($tenders as $tender)
    <tr>
        <td style="background: #fff;">
            <table border="0" cellpadding="0" cellspacing="0"
                   style="     mso-table-lspace: 0pt;     border-spacing: 0;font-size:100%;     mso-table-rspace: 0pt;     -webkit-text-size-adjust: 100%;     -ms-text-size-adjust: 100%;border-collapse: collapse;     mso-table-lspace: 0pt;     mso-table-rspace: 0pt;     border-spacing: 0;     -webkit-text-size-adjust: 100%;     -ms-text-size-adjust: 100%;border-bottom: 3px solid #F0EFEF;"
                   width="100%">
                <tbody>
                <tr>
                    <td>
                        <table class="container-middle" align="center" border="0" cellpadding="0"
                               cellspacing="0" width="560">
                            <tr>
                                <td>
                                    <table class="mainContent" align="center" border="0" cellpadding="0"
                                           cellspacing="0" width="528">
                                        <tbody>
                                        <tr>
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td>


                                                <table class="section-item" align="left" border="0"
                                                       cellpadding="0" cellspacing="0" width="360">
                                                    <tbody>
                                                    <tr>
                                                        <td style="color: #315d90; font-size: 16px; font-weight:bold; font-family: 'Cairo', sans-serif; direction: rtl">

                                                            <a href="{{$tender->path}}"
                                                               style="color: #315d90; font-size: 16px; font-weight:bold; font-family: 'Cairo', sans-serif; direction: rtl; text-decoration:none; line-height:20px;">
                                                                {{$tender->name}}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="15"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color: #a4a4a4; line-height: 25px; font-size: 12px; font-weight: normal; font-family: 'Cairo', sans-serif;">
                                                            <table cellpadding="0" cellspacing="0"
                                                                   width="100%" dir="rtl">
                                                                <tr style="color:#474748; font-size: 12px;">
                                                                    <td width="33%" align="center">قيمة
                                                                        تحميل الكراسة
                                                                    </td>
                                                                    <td width="33%" align="center">قيمة
                                                                        الكراسة
                                                                    </td>
                                                                    <td width="33%" align="center">مناطق
                                                                    </td>
                                                                </tr>
                                                                <tr style="color: #315d90; font-weight:bold"

                                                                >
                                                                    <td width="33%"
                                                                        align="center">{{$tender->cb_downloaded_price}}
                                                                        ريال
                                                                        سعودى
                                                                    </td>
                                                                    <td width="33%"
                                                                        align="center">{{$tender->cb_real_price}} ريال
                                                                        سعودى
                                                                    </td>
                                                                    <td width="33%" align="center">
                                                                        {{$tender->address_get_offer or '---'}}
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="15"></td>
                                                    </tr>

                                                    </tbody>
                                                </table>

                                                <table align="left" border="0" cellpadding="0"
                                                       cellspacing="0">
                                                    <tbody>
                                                    <tr>
                                                        <td height="30" width="30"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="section-item" align="left" border="0"
                                                       cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                    <tr>
                                                        <td height="6"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="{{$tender->path}}"
                                                               style="width: 128px; display: block;"><img
                                                                        style="display: block;"
                                                                        src="{{uploads_url($tender->org->logo->path)}}"
                                                                        alt="{{$tender->title}}" class="section-img"
                                                                        height="auto" width="128"></a></td>
                                                    </tr>

                                                    </tbody>
                                                </table>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>


                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
@endforeach
