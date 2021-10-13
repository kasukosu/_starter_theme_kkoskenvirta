<?php defined('ABSPATH') || exit(); ?>
<section class="map">
    <div class="container">
        <div id="map" style="width:100%;height:450px;"></div>
    </div>
    <script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            disableDefaultUI: true,
            scaleControl: true,
            zoomControl: true,
            center: {
                lat: 60.45289863940857,
                lng: 22.26705175325073

            },
            zoom: 16,
            styles: [
                {
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#f5f5f5"
                    }
                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                    {
                        "visibility": "off"
                    }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#616161"
                    }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                    {
                        "color": "#f5f5f5"
                    }
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#bdbdbd"
                    }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#757575"
                    }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#e5e5e5"
                    }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#ffffff"
                    }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#757575"
                    }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#dadada"
                    }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#616161"
                    }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                    ]
                },
                {
                    "featureType": "transit.line",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#e5e5e5"
                    }
                    ]
                },
                {
                    "featureType": "transit.station",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#c9c9c9"
                    }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                    ]
                }
            ]
        });

        var iconBase = '//maps.google.com/mapfiles/kml/shapes/';
        var icons = {
            parking: {
                //icon: iconBase + 'parking_lot_maps.png'
                icon: '<?php print get_template_directory_uri(); ?>/assets/img/parking-lot.png',
            },
            info: {
                icon: '<?php print get_template_directory_uri(); ?>/assets/img/map-marker.png',
            }
        };

        var features = [
            {
                // kauppiaskatu
                position: new google.maps.LatLng(60.45289863940857, 22.26705175325073),
                type: 'info'
            },
            {
                // toriparkki
                position: new google.maps.LatLng(60.452739699670985, 22.267766176121775),
                type: 'parking'
            }
        ]

        // Create markers.
        features.forEach(function(feature) {
            var marker = new google.maps.Marker({
                position: feature.position,
                icon: icons[feature.type].icon,
                map: map
            });
        });
    }
    </script>
    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyC_C8Btea0AlSpfMXgxbgR-OeNlehWLrvE&callback=initMap" async defer></script>
</section>