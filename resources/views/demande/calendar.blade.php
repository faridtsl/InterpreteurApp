@extends('layouts.layout')

@section('title')
    Calendrier des evenements
@endsection

@section('header')

    <link rel='stylesheet' href='http://fullcalendar.io/js/fullcalendar-2.2.3/fullcalendar.css' />

@endsection

@section('content')

    <hr>

    <div id='calendar'></div>

@endsection

@section('footer')

    <script src='http://fullcalendar.io/js/fullcalendar-2.2.3/lib/moment.min.js'></script>
    <script src='http://fullcalendar.io/js/fullcalendar-2.2.3/fullcalendar.min.js'></script>

    <script type="text/javascript">

        $(document).ready(function() {
            // page is now ready, initialize the calendar...
            // options and github  - http://fullcalendar.io/

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                aspectRatio: 2.5,
                eventLimit: true, // allow "more" link when too many events
                timeFormat:  'H:mm',

                displayEventEnd: {
                    month: true,
                    basicWeek: true,
                    basicDay : true,
                    "default": true
                },

                eventRender: function (event, element) {
                    element.popover({
                        title: "<strong>"+event.title+"</strong>",
                        placement:'auto',
                        html:true,
                        trigger : 'click',
                        animation : 'true',
                        content: event.msg,
                        container:'body'
                    });
                    $('body').on('click', function (e) {
                        if (!element.is(e.target) && element.has(e.target).length === 0 && $('.popover').has(e.target).length === 0)
                            element.popover('hide');
                    });
                },

                events: [

                        @foreach($demandes as $demande)

                    {
                        title: convertEntities("[{{App\Tools\EtatTools::getEtatById($demande->etat_id)->libelle}}] {{$demande->titre}}"),
                        start: new Date('{{$demande->dateEvent}}'.replace(' ', 'T')),
                        end: new Date('{{$demande->dateEndEvent}}'.replace(' ', 'T')),
                        msg: '\
          <div class="row">\
            <div class="col-lg-4">\
              Start Event :\
            </div>\
            <div class="col-lg-8">\
              <strong>{{$demande->dateEvent}}</strong>\
            </div>\
          </div>\
          <hr>\
          <div class="row">\
            <div class="col-lg-4">\
              End time\
            </div>\
            <div class="col-lg-8">\
              <strong>{{$demande->dateEndEvent}}</strong>\
            </div>\
          </div>\
          <hr>\
          <div class="row">\
            <div class="col-lg-4">\
              Event address\
            </div>\
            <div class="col-lg-8">\
              <strong>{{App\Tools\AdresseTools::getAdresse($demande->adresse_id)->adresse}}</strong>\
            </div>\
          </div>\
          <hr>\
          <div class="row">\
            <div class="col-lg-4">\
              Client\
            </div>\
            <div class="col-lg-8">\
              <strong>{{App\Tools\ClientTools::getClient($demande->client_id)->nom}} {{App\Tools\ClientTools::getClient($demande->client_id)->prenom}}</strong>\
            </div>\
          </div>\
          <hr>\
           <div class="row">\
            <div class="col-lg-4">\
              Etat\
            </div>\
            <div class="col-lg-8">\
              <strong>{{App\Tools\EtatTools::getEtatById($demande->etat_id)->libelle}}</strong>\
            </div>\
          </div>\
        ',
                        //url: '/demande/edit/{{$demande->id}}',
                        @if(App\Tools\EtatTools::getEtatById($demande->etat_id)->id === 3)color:'#f00',@endif

                    },

                        @endforeach
                    {
                        title: 'Long Event',
                        start: new Date(y-2, m, d-5,"16","30"),
                        end: new Date(y-2, m, d-5,"18","41")

                    }
                ],
                editable: false
            });

        });

    </script>

    <script type="text/javascript">
        function convertEntities(html) {
            var el = document.createElement("div");
            el.innerHTML = html;
            return el.firstChild.data;
        }
    </script>

@endsection