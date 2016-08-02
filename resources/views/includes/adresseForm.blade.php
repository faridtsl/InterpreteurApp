
<div class="form-group">
    <label>Adresse</label>
    <input class="form-control enab" name="adresse"
           @if(isset($demande))readonly @endif
           value="@if(isset($demande)){{\App\Tools\AdresseTools::getAdresse($demande->adresse_id)->adresse}}@else{{ old('adresse') }}@endif" id="adresse" placeholder="Enter your address" onFocus="geolocate()"  type="text">
</div>

<div class="form-group">
    <label>Numero</label>
    <input class="form-control enab" name="numero" @if(isset($demande))readonly @endif value="@if(isset($demande)){{\App\Tools\AdresseTools::getAdresse($demande->adresse_id)->numero}}@else{{ old('numero') }}@endif" id="street_number">
</div>

<div class="form-group">
    <label>Route</label>
    <input class="form-control enab" name="route" @if(isset($demande))readonly @endif value="@if(isset($demande)){{\App\Tools\AdresseTools::getAdresse($demande->adresse_id)->route}}@else{{ old('route') }}@endif" id="route">
</div>

<div class="form-group">
    <label>Code postal</label>
    <input class="form-control enab" name="code_postal" @if(isset($demande))readonly @endif value="@if(isset($demande)){{\App\Tools\AdresseTools::getAdresse($demande->adresse_id)->code_postal}}@else{{ old('code_postal') }}@endif" id="postal_code" type="text">
</div>

<div class="form-group">
    <label>Ville</label>
    <input class="form-control enab" name="ville" @if(isset($demande))readonly @endif value="@if(isset($demande)){{\App\Tools\AdresseTools::getAdresse($demande->adresse_id)->ville}}@else{{ old('ville') }}@endif" id="locality"
           type="text">
</div>

<div class="form-group">
    <label>Pays</label>
    <input class="form-control enab" name="pays" @if(isset($demande))readonly @endif value="@if(isset($demande)){{\App\Tools\AdresseTools::getAdresse($demande->adresse_id)->pays}}@else{{ old('pays') }}@endif" id="country" >
</div>

<div class="form-group">
    <label>Departement</label>
    <input class="form-control enab" name="departement" @if(isset($demande))readonly @endif value="@if(isset($demande)){{\App\Tools\AdresseTools::getAdresse($demande->adresse_id)->departement}}@else{{ old('departement') }}@endif" id="administrative_area_level_1">
</div>
<div class="form-group">
    <div class="row">
        <div class="col-lg-6">
            <label>Long</label>
            <input id="long" name="long" class="form-control" value="@if(isset($demande)){{\App\Tools\AdresseTools::getAdresse($demande->adresse_id)->long}}@else{{ old('long') }}@endif" readonly></input>
        </div>
        <div class="col-lg-6">
            <label>Lat</label>
            <input id="lat" name="lat" class="form-control" value="@if(isset($demande)){{\App\Tools\AdresseTools::getAdresse($demande->adresse_id)->lat}}@else{{ old('lat') }}@endif" readonly></input>
        </div>
    </div>
</div>