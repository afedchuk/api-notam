/**
 * Class NotamMap
 * 
 */
var NotamMap = {

  /**
   * map
   */
  map: null,

  /**
   * markers
   */
  markers: new Array,

  /**
   * mapMarkers
   */
  mapMarkers: new Array,

  /**
   * infowindow
   */
  infowindow: null,

  /**
   * zoom
   */
  zoom: 14,

  /**
   * iconMarker
   */
  iconMarker: null,

  /**
   * init all objects
   * @return void
   */
  init: function() {
    this.iconMarker = {
        url: "/img/marker.png",
        scaledSize: new google.maps.Size(18, 18),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(0, 0)
    };
    this.infowindow = new google.maps.InfoWindow;
    this.initPosition();   
  },

  /**
  * get notams by icao code
  * @return void
  **/
  getNotam: function(){
      $.post("index.php/notam/index", 
        $( "#w0" ).serialize())
          .done(function( data ) {
          if(data.result == 'error') {
            for(val in data.message) {
               alert(data.message[val]);
            }
          } else {
              NotamMap.clearMarker();
              if(data.codes.length > 0) {
                for(icao in data.codes) {
                  NotamMap.markers.push([data.codes[icao].ItemE, data.codes[icao].geo.lat, data.codes[icao].geo.lng]);
                }
                NotamMap.markerApply();
              } else {
                alert('NOTAM information is empty');
              }
          }
      });
  },

  /**
   * set marker position on a map and adding click listener
   * @return void
   */
  markerApply: function() {
    len  = NotamMap.markers.length;
    for (i = 0; i < len; i++) {
      marker = new google.maps.Marker({
        position: {lat:  NotamMap.markers[i][1], lng:  NotamMap.markers[i][2]}, 
        icon: this.iconMarker,
        title: NotamMap.markers[i][0],
        map: NotamMap.map
      });
      NotamMap.mapMarkers.push(marker);
      google.maps.event.addListener(marker, "click", (function(marker, i) { 
        return function() {
             NotamMap.infowindow.setContent(NotamMap.markers[i][0]);
             NotamMap.infowindow.open(this.map, marker);
         }
      })(marker, i));
      
    }   
    NotamMap.map.setCenter(new google.maps.LatLng(NotamMap.markers[len - 1][1], NotamMap.markers[len - 1][2]), NotamMap.zoom); 
  },

  /**
   * clear all markers before adding new markers
   * @return void
   */
  clearMarker: function() {
    for (var i = 0; i < NotamMap.mapMarkers.length; i++) {
      NotamMap.mapMarkers[i].setMap(null);
    }
    NotamMap.mapMarkers = new Array();
    NotamMap.markers = new Array();
  },


  /**
   * get current position on a map
   * @return void
  */
  initPosition: function() {
    NotamMap.map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: this.zoom
    });
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        NotamMap.infowindow.setPosition(pos);
        NotamMap.infowindow.setContent('Current location found.');
        NotamMap.map.setCenter(pos);
      }, function() {
        NotamMap.handleLocationError(true, NotamMap.infowindow, NotamMap.map.getCenter());
      });
    } else {
      NotamMap.handleLocationError(false, NotamMap.infowindow, NotamMap.map.getCenter());
    }
  },

  /**
   * handle browser geolocation supporting
   * @return void
  */
  handleLocationError: function() {
      infoWindow.setPosition(pos);
      infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
  }
}

NotamMap.init();