
<div class="form-group">
    <label>Adresse</label>
    <input class="form-control" name="adresse" value="{{ old('adresse') }}" id="adresse" placeholder="Enter your address" onFocus="geolocate()"  type="text">
</div>

<div class="form-group">
    <label>Numero</label>
    <input class="form-control" name="numero" value="{{ old('numero') }}" id="street_number">
</div>

<div class="form-group">
    <label>Route</label>
    <input class="form-control" name="route" value="{{ old('route') }}" id="route">
</div>

<div class="form-group">
    <label>Code postal</label>
    <input class="form-control" name="code_postal" value="{{ old('code_postal') }}" id="postal_code" type="text">
</div>

<div class="form-group">
    <label>Ville</label>
    <input class="form-control" name="ville" value="{{ old('ville') }}" id="locality"
           type="text">
</div>

<div class="form-group">
    <label>Pays</label>
    <input class="form-control" name="pays" value="{{ old('pays') }}" id="country" >
</div>

<div class="form-group">
    <label>Departement</label>
    <input class="form-control" name="departement" value="{{ old('departement') }}" id="administrative_area_level_1">
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