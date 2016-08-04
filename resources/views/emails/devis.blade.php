<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>QUOTATION SARAH COMPANY N: SAC-{{$devis->id}}</title>
    <link rel="stylesheet" href="{{ asset('css/style_df.css') }}" media="all" />
</head>
<body>
<header class="clearfix">
    <div id="logo">
        @if(isset($show))
            <img src="{{{ asset('images/logo.png') }}}">
        @else

            <img src="http://www.wordsandco.pro/wp-content/uploads/2016/04/logo-wordsandco-silver200.png">
        @endif
    </div>
    <h1>QUOTATION SARAH COMPANY N: SAC-{{$devis->id}}</h1>
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