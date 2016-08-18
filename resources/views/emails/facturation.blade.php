<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facturation N: SAC-{{$facture->id}}</title>
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
    <h1>INVOICE SARAH COMPANY N: SAC-{{$facture->id}}</h1>
    <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
    </div>
    <div id="project">
        <div><span>PROJECT</span> <span style="width: 13px;"></span>{{\App\Tools\DemandeTools::getDemande(\App\Tools\DevisTools::getDevisById($facture->devi_id)->demande_id)->titre}}</div>
        <div><span>CLIENT</span><span style="width: 13px;"></span> {{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande(\App\Tools\DevisTools::getDevisById($facture->devi_id)->demande_id)->client_id)->nom}} {{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande(\App\Tools\DevisTools::getDevisById($facture->devi_id)->demande_id)->client_id)->prenom}}</div>
        <div><span>ADDRESS</span><span style="width: 13px;"></span> {{\App\Tools\AdresseTools::getAdresse(\App\Tools\DemandeTools::getDemande(\App\Tools\DevisTools::getDevisById($facture->devi_id)->demande_id)->adresse_id)->adresse}}</div>
        <div><span>EMAIL</span><span style="width: 13px;"></span> <a href="mailto:{{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande(\App\Tools\DevisTools::getDevisById($facture->devi_id)->demande_id)->client_id)->email}}">{{\App\Tools\ClientTools::getClient(\App\Tools\DemandeTools::getDemande(\App\Tools\DevisTools::getDevisById($facture->devi_id)->demande_id)->client_id)->email}}</a></div>
        <div><span>CREATION DATE</span> <span style="width: 13px;"></span>{{date('D d M Y h:m:s',strtotime($facture->created_at))}}</div>
        <div><span>EVENT DATE</span> <span style="width: 13px;"></span>{{date('D d M Y h:m:s',strtotime(\App\Tools\DemandeTools::getDemande(\App\Tools\DevisTools::getDevisById($facture->devi_id)->demande_id)->dateEvent))}}</div>
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
            <td class="total">{{\App\Tools\DevisTools::getDevisById($facture->devi_id)->total}}&euro;</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>TAX {{env('PERCENT_TAXES') * 100}}%</td>
            <td class="total">{{(env('PERCENT_TAXES') * \App\Tools\DevisTools::getDevisById($facture->devi_id)->total)}}&euro;</td>
        </tr>
        <tr>
            <td class="grand total"></td>
            <td class="grand total"></td>
            <td class="grand total"></td>
            <td class="grand total"></td>
            <td class="grand total"><strong>GRAND TOTAL</strong></td>
            <td class="grand total">{{(env('PERCENT_TAXES') * \App\Tools\DevisTools::getDevisById($facture->devi_id)->total) + \App\Tools\DevisTools::getDevisById($facture->devi_id)->total}}&euro;</td>
        </tr>
        </tbody>
    </table>

    <div>
        <table border="1">
            <tr>
                <th scope="col" colspan="2" width="50%">Account information</th>
                <th scope="col">Notice</th>
            </tr>
            <tr>
                <td>Account Number</td>
                <td>account number</td>
                <td rowspan="4">
                    <ul>
                        <li>Make payment directly from your bank account. Please use the identifier of this invoice as payment reference. </li>
                        <li>The payment must be made within <strong>30 days</strong> of receiving the invoice. </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>Branch code</td>
                <td>007763849</td>
            </tr>
            <tr>
                <td>IBAN</td>
                <td>FR76353535193974273923294</td>
            </tr>
            <tr>
                <td>BIC</td>
                <td>1234362846322742</td>
            </tr>
        </table>
    </div>
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