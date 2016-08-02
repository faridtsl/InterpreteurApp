<table id="{{$id}}" class="table table-striped table-bordered display responsive nowrap" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>Titre</th>
        <th>Etat</th>
        <th>Client</th>
        <th>Date Creation</th>
        <th>Langue Initiale</th>
        <th>Langue Destination</th>
        <th>Action</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Titre</th>
        <th>Etat</th>
        <th>Client</th>
        <th>Date Creation</th>
        <th>Langue Initiale</th>
        <th>Langue Destination</th>
        <th>Action</th>
    </tr>
    </tfoot>
    <tbody>
    @foreach($demandes as $demande)
        @if((\App\Tools\DemandeTools::tempsRestant($demande)>0 and $parent='new') or (\App\Tools\DemandeTools::tempsRestant($demande)<0 and $parent=='expired' ) )
            <tr class="@if(\App\Tools\DemandeTools::tempsRestant($demande) < env('EVENT_DANGER_DELAI','0')) danger @elseif(\App\Tools\DemandeTools::tempsRestant($demande) < env('EVENT_WAR_DELAI','0')) warning @endif">
                <td>{{$demande->titre}}</td>
                <td>{{\App\Tools\EtatTools::getEtatById($demande->etat_id)->libelle}}</td>
                <td>{{\App\Tools\ClientTools::getClient($demande->client_id)->nom}} {{\App\Tools\ClientTools::getClient($demande->client_id)->prenom}}</td>
                <td>{{$demande->created_at}}</td>
                <td>{{\App\Tools\LangueTools::getLangue(\App\Tools\TraductionTools::getTraductionById($demande->traduction_id)->source)->content}}</td>
                <td>{{\App\Tools\LangueTools::getLangue(\App\Tools\TraductionTools::getTraductionById($demande->traduction_id)->cible)->content}}</td>
                <td>
                    <p data-placement="top" data-toggle="tooltip" title="Edit">
                        <a class="btn btn-warning btn-xs editButton" href="/demande/update?id={{$demande->id}}" >
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <button class="btn btn-success btn-xs deleteButton" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="{{$demande->id}}" >
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </p>
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>