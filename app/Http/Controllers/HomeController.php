<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Devi;
use App\Http\Requests;
use App\Interpreteur;
use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DemandeTools;
use App\Tools\DevisTools;
use App\Tools\FactureTools;
use App\Tools\LangueTools;
use App\Tools\MailTools;
use App\Tools\ServiceTools;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('home',['langues'=>LangueTools::getAllLangues()]);
    }

    public function q(){
        $intepreteurs = Interpreteur::join('adresses','interpreteurs.adresse_id','=','adresses.id')->select(array('interpreteurs.id','nom','prenom','email','prestation','devise','adresse','tel_fixe','tel_portable','image','interpreteurs.created_at','interpreteurs.updated_at'));
        $ssData = Datatables::of($intepreteurs);//->addColumn('adresse','{{ \App\Tools\AdresseTools::getAdresse($id)->adresse }}');
        $ssData = $ssData->editColumn('nom','<img class="img-circle" src="/images/{{$image}}" style="width: 50px;height:50px;"/> {{$nom}} {{$prenom}}');
        $ssData = $ssData->addColumn('traductions','
                                |
                                @foreach(\App\Tools\TraductionTools::getTraductionsByInterpreteur($id) as $traduction)
                                    {{\App\Tools\LangueTools::getLangue($traduction->source)->content}} <span class="glyphicon glyphicon-arrow-right"></span> {{\App\Tools\LangueTools::getLangue($traduction->cible)->content}}
                                     |
                                @endforeach');
        $ssData = $ssData->addColumn('butts','<p data-placement="top" data-toggle="tooltip" title="Edit">
                                    <button class="btn btn-warning btn-xs editButton" data-title="Edit" data-toggle="modal" data-target="#edit" data-id="{{$id}}" >
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                    <button class="btn btn-danger btn-xs deleteButton" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="{{$id}}" >
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                    <a class="btn btn-default btn-xs" href="/interpreteur/profile?id={{$id}}" >
                                        <span class="glyphicon glyphicon-user"></span>
                                    </a>
                                </p>');
        return $ssData->make(true);
        return $ssData->getData()->data;
    }
}

/*
 *
 *
 */