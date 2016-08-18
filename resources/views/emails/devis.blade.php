<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New QUOTATION has been created N: SAC-{{$devis->id}}</title>
    <link rel="stylesheet" href="{{ asset('css/style_df.css') }}" media="all" />
    @if(isset($PDF))
        <style>

            .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }

            a {
                color: #5D6975;
                text-decoration: underline;
            }

            body {
                #position: relative;
                width: 19cm;
                height: 20.7cm;
                margin: 0 auto;
                color: #001028;
                background: #FFFFFF;
                font-family: Arial, sans-serif;
                font-size: 9px;
                font-family: Arial;
            }

            header {
                padding: 0px 0;
                margin-bottom: 5px;
                overflow: hidden;
                height: 230px;
            }

            #logo {
                text-align: center;
                margin-bottom: 10px;
            }

            #logo img {
                width: 200px;
            }

            h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                color: #5D6975;
                font-size: 2.4em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 5px 0;
                background: url({{asset("images/dimension.png")}});
            }

            #project {
                float: left;
            }

            #project span {
                color: #5D6975;
                text-align: right;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
            }

            #company {
                float: right;
                text-align: right;
            }

            #project div,
            #company div {
                white-space: nowrap;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
                border-width : 1px;
            }

            table tr:nth-child(2n-1) td {
                background: #F5F5F5;
            }

            #normal tr:nth-child(2n-1) td {
                background: #FFFFFF;
            }



            table th,
            table td {
                text-align: left;
            }

            table th {
                padding: 5px 20px;
                color: #5D6975;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;
                font-weight: normal;
            }

            table .service,
            table .desc {
                text-align: left;
            }

            table td {
                padding: 20px;
                text-align: left;
            }

            table td.service,
            table td.desc {
                vertical-align: top;
            }

            table td.unit,
            table td.qty,
            table td.total {
                font-size: 1.2em;
            }

            table td.grand {
                border-top: 1px solid #5D6975;;
            }

            #notices .notice {
                color: #5D6975;
                font-size: 1.2em;
            }

            footer {
                color: #5D6975;
                width: 100%;
                height: 20px;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #C1CED9;
                padding: 8px 0;
                text-align: center;
            }

        </style>
    @endif
</head>
<body>
<header class="clearfix">
    <div id="logo">
        @if(isset($show))
            <img src="{{ asset('images/logo.png') }}">
        @else

            <img src="http://www.wordsandco.pro/wp-content/uploads/2016/04/logo-wordsandco-silver200.png">
        @endif
    </div>
    <h1>New QUOTATION has been created N: SAC-{{$devis->id}}</h1>
    <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
    </div>
    <div id="project">
        <div><span>PROJECT</span> {{$demande->titre}}</div>
        <div><span>CLIENT</span> {{$client->nom}} {{$client->prenom}}</div>
        <div><span>ADDRESS</span> {{$adresse->adresse}}</div>
        <div><span>EMAIL</span> <a href="mailto:{{$client->email}}">{{$client->email}}</a></div>
        <div><span>DATE</span>{{date('D d M Y h:m:s',strtotime($devis->created_at))}}</div>
        <div><span>EVENT DATE</span> {{date('D d M Y h:m:s',strtotime($demande->dateEvent))}}</div>

    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th>
            <th>UNIT</th>
            <th>QTY</th>
            <th>PRICE</th>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @foreach($services as $service)
            <tr>
                <td class="service">{{$service->service}}</td>
                <td class="desc">{{$service->designation}}</td>
                <td class="unit">{{$service->Unite}}</td>
                <td class="qty">{{$service->qantite}}</td>
                <td class="price">{{$service->prix}}&euro;</td>
                <td class="total">{{$service->total}}&euro;</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>SUBTOTAL</td>
            <td class="total">{{\App\Tools\DevisTools::getTotal($devis->id)}}&euro;</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>TAX {{env('PERCENT_TAXES') * 100}}%</td>
            <td class="total">{{(env('PERCENT_TAXES') * \App\Tools\DevisTools::getTotal($devis->id))}}&euro;</td>
        </tr>
        <tr>
            <td class="grand total"></td>
            <td class="grand total"></td>
            <td class="grand total"></td>
            <td class="grand total"></td>
            <td class="grand total"><strong>GRAND TOTAL</strong></td>
            <td class="grand total">{{(env('PERCENT_TAXES') * \App\Tools\DevisTools::getTotal($devis->id)) + \App\Tools\DevisTools::getTotal($devis->id) }}&euro;</td>
        </tr>
        </tbody>
    </table>
    <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
    </div>
</main>
<footer>
    Invoice was created on a computer and is valid without the signature and seal.
</footer>
</body>
</html>