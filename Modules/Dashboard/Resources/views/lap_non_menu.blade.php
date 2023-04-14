<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns="http://www.w3.org/1999/xhtml">

<head>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />

        <title>{{ $title }}</title>

        <!-- Styles -->
        <style>
            *,
            *:before,
            *:after {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                margin: 0;
                padding: 0;
                min-width: 100% !important;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
                    Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
                color: #000000;
                /* line-height: 150%; */
            }

            .content {
                width: 100%;
            }

            img {
                max-width: 100%;
            }
            table {
                border-spacing: 0;
                border-collapse: collapse;
            }
        </style>
    </head>

<body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%">
        <tr>
            <td align="center" style="padding: 5px; width: 100%">
                <div style="background: #ffffff;padding: 5px;display: block;width: 7cm;max-width: 100%;margin: 0 auto;">
                    <div style="font-family: Courier; font-size: 14px;">
                        <table width="100%" border="1">
                            @foreach($sales as $key => $valSales)
                            <tr style="background: #d35252; color:#ffffff; font-weight: bold; text-align: center">
                                <td colspan="3">{{ ucfirst($key)}}</td>
                            </tr>
                            @foreach ($valSales as $key => $valItem)
                            <tr>
                                <td colspan="3">{{strtoupper($valItem['Tipe'])}}</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Menu</td>
                                <td>{{$valItem['Menu']}}</td>
                            </tr>
                            @if ($valItem['Non Menu'] >= 0)
                            <tr>
                                <td>2</td>
                                <td>Non Menu</td>
                                <td>{{$valItem['Non Menu']}}</td>
                            </tr>
                            @endif
                            @if ($valItem['Ice Cream'] >= 0)
                            <tr>
                                <td>3</td>
                                <td>Ice Cream</td>
                                <td>{{$valItem['Ice Cream']}}</td>
                            </tr>
                            @endif
                            @if ($valItem['KBD'] >= 0)
                            <tr>
                                <td>4</td>
                                <td>KBD</td>
                                <td>{{$valItem['KBD']}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="3">-</td>
                            </tr>
                            @endforeach

                            {{-- <tr>
                                <td style="padding-left: 20px">{{ $key }}</td>
                                <td align="right">{{$key}}</td>
                            </tr> --}}
                            @endforeach
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
