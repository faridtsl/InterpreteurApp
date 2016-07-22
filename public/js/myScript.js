
$(function () {

    $('#example').DataTable();

    $('.toggle').click(function (event) {
        event.preventDefault();
        var target = $(this).attr('href');
        $(target).toggleClass('hidden show');
    });

    $(document).on('click', '.btn-add', function(e){
        e.preventDefault();
        var teams = $(this).parents('#langs:first');
        var controlForm = $('#formID'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(teams);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e){
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
    });

    $('.editButton').on('click', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');

        $.ajax({
            url: $id,
            type:"GET",
            success:function(data){
                $("#id").val(data['id']);
                $("#email").val(data['email']);
                $("#prestation").val(data['prestation']);
                $("#tel_fixe").val(data['tel_fixe']);
                $("#tel_portable").val(data['tel_portable']);

            },error:function(){
                alert("error!!!!");
            }
        });
    });

    $('.deleteButton').on('click', function () {
        // Get the record's ID via attribute
        $id = $(this).attr('data-id');

        $.ajax({
            url: $id,
            type:"GET",
            success:function(data){
                $("#idDel").val(data['id']);
                var msg = "Suppresion de '";
                var m2 = msg.concat(data['nom']);
                m2 = m2.concat(' ');
                m2 = m2.concat(data['prenom']);
                var m = m2.concat("'");
                $("#headDelete").text(m);
            },error:function(){
                alert("error!!!!");
            }
        });

    });


});


var placeSearch, autocomplete;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
        {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

// [START region_fillform]
function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
    var lat = place.geometry.location.lat();
    var long = place.geometry.location.lng();

    document.getElementById("lat").value = lat;
    document.getElementById("long").value = long;

    for (var component in componentForm) {
        //document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}