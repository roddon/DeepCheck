<!DOCTYPE HTML>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,500i,600,600i,700&display=swap" rel="stylesheet">
    <title>Deepcheck</title>
    <style>

        body{
            color: 000 !important;
        }
        .main-table,
        .main-table tbody {
            width: 100%;
            max-width: 800px;
        }

        td {
            vertical-align: middle;
        }

        /*IPAD STYLES*/
        @media only screen and (max-width: 640px) {
            td[class=footer-add] {
                width: 100% !important;
                text-align: center !important;
                display: block;
            }

            td[class=social-link] {
                width: 100% !important;
                text-align: center !important;
                margin-top: 15px;
                display: block;
            }
        }

        .invitations-note span {
            display: block;
            margin-bottom: 10px;
        }

        p.invitations-note a {
            text-decoration: underline;
        }
    </style>
</head>

<body style="padding: 0;margin: 0;background-color: #fff;font-family: 'Nunito', sans-serif;">
    <table cellpadding="0" cellspacing="0" class="main-table" border="0" width="100%" style="margin:0 auto; background-color:#ffffff;">
        <tr>
            <td style="padding: 15px;background-color: #FFF;">
                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="text-align: left; border-bottom: 3px solid #ffcd00;">
                            <img src="{{ asset('assets/deepcheck_Logo.svg')  }}" height="80" style="vertical-align: middle;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 25px;vertical-align: middle;border-top: 3px #3f76ba solid;border: none;">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" style="text-align: center; margin: 0;font-family: 'Nunito', sans-serif;">
                    <tr>
                        <td align=" left">

                            @yield('content')
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</body>

</html>
