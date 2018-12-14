<?php
$logo=get_template_directory_uri().'/assets/images/mappin.png';
if($instance['logo_url']!=''){
  $logo=esc_url($instance['logo_url']);
}
?>
<div id="map"></div>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>
    <script type="text/javascript">
      var geocoder;
      var map;
      var address ="<?php echo esc_html($instance['address']); ?>";

        function mapinitialize() {

            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(-34.397, 150.644);
            var myOptions = {
                zoom: 14,
                center: latlng,
                scrollwheel: false,
                scaleControl: false,
                disableDefaultUI: false,
                panControl:true,
                zoomControl:true,
                mapTypeControl:true,
                scaleControl:true,
                streetViewControl:true,
                overviewMapControl:true,
                rotateControl:true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("map"), myOptions);

            if (geocoder) {
              geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                  if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                  map.setCenter(results[0].geometry.location);

                    var infowindow = new google.maps.InfoWindow(
                        { content: '<b><?php echo wp_kses_post( $instance['description'] ) ?></b>',
                          size: new google.maps.Size(150,50)
                        });
                    var image = "<?php echo $logo;?>";
                    var marker = new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map, 
                        title:address,
                        icon: image,
                    }); 
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.open(map,marker);
                    });

                  } else {
                    alert("No results found");
                  }
                } else {
                  alert("Geocode was not successful for the following reason: " + status);
                }
              });
            }
        }
        mapinitialize();
    </script> 
