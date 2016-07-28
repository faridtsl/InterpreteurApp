
<div class="form-group">
    <label>Adresse</label>
    <input class="form-control" name="adresse" value="{{ old('adresse') }}" id="adresse" placeholder="Enter your address" onFocus="geolocate()"  type="text">
</div>

<div class="form-group">
    <label>Numero</label>
    <input class="form-control" name="numero" value="{{ old('numero') }}" id="numero">
</div>

<div class="form-group">
    <label>Route</label>
    <input class="form-control" name="route" value="{{ old('route') }}" id="route">
</div>

<div class="form-group">
    <label>Code postal</label>
    <input class="form-control" name="code_postal" value="{{ old('code_postal') }}" id="code_postal" type="text">
</div>

<div class="form-group">
    <label>Ville</label>
    <input class="form-control" name="ville" value="{{ old('ville') }}" id="ville"
           type="text">
</div>

<div class="form-group">
    <label>Pays</label>
    <input class="form-control" name="pays" value="{{ old('pays') }}" id="pays" >
</div>

<div class="form-group">
    <label>Departement</label>
    <input class="form-control" name="departement" value="{{ old('departement') }}" id="departement">
</div>
<div class="form-group">
    <div class="row">
        <div class="col-lg-6">
            <label>Long</label>
            <input id="long" name="long" class="form-control" value="{{ old('long') }}" readonly></input>
        </div>
        <div class="col-lg-6">
            <label>Lat</label>
            <input id="lat" name="lat" class="form-control" value="{{ old('lat') }}" readonly></input>
        </div>
    </div>
</div>