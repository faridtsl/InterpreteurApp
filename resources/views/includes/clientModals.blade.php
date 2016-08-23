<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                <h4 class="modal-title custom_align" id="Heading">Modifier</h4>
            </div>
            <form role="form" method="post" id="updateForm" action="update" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="row hide" data-step="1" data-title="This is step!">
                        <div class="container-fluid">
                            <h3> Informations personnelles</h3>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Nom</label>
                                        <input class="form-control" value="{{ old('nom') }}" name="nom" id="nom" placeholder="Nom">
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Prenom</label>
                                        <input class="form-control" value="{{ old('prenom') }}" name="prenom" id="prenom" placeholder="Prenom">
                                    </div>
                                </div>
                                <input type="hidden" value="-1" readonly="readonly" id="id" name="id" class="form-control"/>
                                <input type="hidden" value="-1" readonly="readonly" id="adr" name="adresse_id" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Email: </label>
                                <input type="text" value="-1" id="email" name="email" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>nationalite</label>
                                <input class="form-control" value="{{ old('nationalite') }}"  name="nationalite" placeholder="nationalite">
                            </div>
                            <div class="form-group">
                                <label>Image : </label>
                                <input type="file" name="image" />
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Tel fixe: </label>
                                        <input type="text" value="-1" id="tel_fixe" name="tel_fixe" class="form-control"/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Tel portable: </label>
                                        <input type="text" value="-1" id="tel_portable" name="tel_portable" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row hide" data-step="2" data-title="adresse">
                        <div class="container-fluid">
                            <h3> Adresse</h3>
                            @include('includes.adresseForm')
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning js-btn-step" data-orientation="previous"></button>
                    <button type="button" class="btn btn-success js-btn-step" data-orientation="next"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Suppression popup-->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                <h4 class="modal-title custom_align" id="headDelete"></h4>
            </div>
            <form id="deleteForm" action="delete" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" value="-1" id="idDel" name="id" />
                    </div>
                    <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> êtes-vous sur de vouloir supprimer?</div>
                </div>
                <div class="modal-footer ">
                    <input class="btn btn-success" value="Oui" type="submit"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>