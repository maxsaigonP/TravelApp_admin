<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="@import url(https://fonts.googleapis.com/css?family=Helvetica:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1
                                            style="color:#0066FF; font-weight:700; margin:0;font-size:25px;font-family:'Helvetica',sans-serif; text-align:left">
                                            Strawhat
                                        </h1>
                                        <span
                                            style="display:inline-block; vertical-align:middle; margin:20px 0 0px;"></span>
                                        <p style="color:#333333; font-size:15px;line-height:24px; margin:0; text-align:left">
                                            Xin ch??o <strong>{{ $user->hoTen }}</strong>,<br>
                                            C?? v??? b???n ???? y??u c???u ?????t l???i m???t kh???u cho t??i kho???n c???a m??nh. N???u
                                            b???n ???? l??m ??i???u ???? vui l??ng nh???p v??o li??n k???t d?????i ????y v?? l??m theo h?????ng d???n
                                            ????? ?????t l???i
                                            m???t kh???u c???a b???n. </p>
                                        <a href="{{ url('/reset-password/'. $token) }}"
                                            style="background:#0066FF;text-decoration:none !important; font-weight:500; margin-top:30px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:block;border-radius:25px;width: fit-content;">?????t
                                            l???i m???t kh???u</a>
                                        <p style="color:#333333; font-size:15px;line-height:24px; margin-top: 20px; text-align:left">
                                            N???u b???n kh??ng l??m ??i???u ????, vui l??ng <a href="#"
                                                style="text-decoration: none !important;color: #0066FF"> Li??n h??? v???i b???
                                                ph???n h???
                                                tr???</a>
                                            ngay l???p t???c.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>