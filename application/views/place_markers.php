<!DOCTYPE html>
<html>
  <head>
      
    <meta charset="utf-8">
    <title>Marker Animations</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }

      #dialog_content{}
      #dialog_content label{ display: block;}
      #dialog_content .form-control{ outline: none; border: solid 2px #e1e1e1; width: 250px; padding: 6px; margin-bottom: 10px;}
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   

    <script type="text/javascript">

    var centerposition = new google.maps.LatLng(59.32522, 18.07002);
    var marker;
    var markers = [];
    var map;
    var ajax_file = "<?=  base_url();?>load_stock/our_ajax";
    var openInfoWindow;
    var image = 'http://localhost/maps/images/blue_icon.png';


    function setup_marker(marker){
        

        var mLatLang = marker.getPosition().toUrlValue();
        google.maps.event.addListener(marker, 'click', function() {
          if (openInfoWindow) {
            openInfoWindow.close();
          }

          var infowindow = new google.maps.InfoWindow({
                content: ''
            });
          $.post( ajax_file, { action: "get_asset_details", position: mLatLang},function( data ) {
            
            var contentString = $('<div>'+data+'</div>');    

            infowindow.setContent(contentString[0]);
            infowindow.open(map,marker);
            openInfoWindow = infowindow;

            //Find remove button in infoWindow
            var removeBtn = contentString.find('.delete_asset')[0];
            var saveBtn = contentString.find('.save_asset')[0];

            //add click listner to remove marker button
            google.maps.event.addDomListener(removeBtn, "click", function(event) {
                //call remove_marker function to remove the marker from the map
                remove_marker(marker);
            });

             //add click listner to save marker button
            google.maps.event.addDomListener(saveBtn, "click", function(event) {
                //call remove_marker function to remove the marker from the map
                save_current_asset(marker,infowindow);
            });
          });
          
        });
      }

    function remove_marker(Marker){
        //Remove saved marker from DB and map using jQuery Ajax
        var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
        
        var myData = {action : 'delete_asset', latlang : mLatLang}; //post variables
        $.ajax({
          type: "POST",
          url: ajax_file,
          data: myData,
          success:function(data){
               Marker.setMap(null); 
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //throw any errors
            }
        });
      
    }

    function save_current_asset(Marker,infowindow){
        
        var myData = $(infowindow.content).find('form').serialize();
        $.ajax({
          type: "POST",
          url: ajax_file,
          data: myData,
          success:function(data){
               openInfoWindow.close();
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //throw any errors
            }
        });
      
    }

    function save_new_asset(Marker,infowindow){
        var myData = $(infowindow.content).find('form').serialize();
        $.ajax({type: "POST",url: ajax_file,
          data: myData,
          success:function(data){
             openInfoWindow.close();
          },
          error:function (xhr, ajaxOptions, thrownError){
              alert(thrownError); //throw any errors
          }
        });
    }

    function addMarker(location) {
      if (openInfoWindow) {
            openInfoWindow.close();
      }

      
      var marker = new google.maps.Marker({
        position: location,
        draggable:true,
        icon:image,
        map: map
      });

      markers.push(marker);

      var mLatLang = marker.getPosition().toUrlValue();
      var contentString = $('<div id="dialog_content"><form>'+
          '<h2>New Assets</h2>'+
          '<label>Title</label>'+
          '<input type="text" name="title" class="form-control"><br>'+
          '<label>Description</label>'+
          '<input type="text" name="title" class="form-control">'+
          '<input type="hidden" name="action" value="add_new_asset" >'+
          '<input type="text" class="form-control" name="position" value="'+mLatLang+'" >'+
          '<div class="buttons">'+
            '<a href="#" class="save_new_asset">Save Asset</a>'+
            '<a href="#" class="delete_new_asset">Delete Asset</a>'+
          '</div><br>'+
          '</form></div>');    
      

      var infowindow = new google.maps.InfoWindow({
          content: ''
      });
      infowindow.setContent(contentString[0]);
      openInfoWindow = infowindow;
      infowindow.open(map,marker);

      //Find remove button in infoWindow
      var removeBtn = contentString.find('.delete_new_asset')[0];
      var saveBtn = contentString.find('.save_new_asset')[0];

      //add click listner to remove marker button
      google.maps.event.addDomListener(removeBtn, "click", function(event) {
          marker.setMap(null); 
      });

       //add click listner to save marker button
      google.maps.event.addDomListener(saveBtn, "click", function(event) {
          save_new_asset(marker,openInfoWindow);
      });

      setup_marker(marker);
      

    }


      function initialize() {
        var mapOptions = {zoom: 13, center: centerposition};
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        
        google.maps.event.addListener(map, 'click', function(event) {
          addMarker(event.latLng);
        });

        var myLatlng = new google.maps.LatLng(59.311469,18.088474);
        var marker = new google.maps.Marker({
            position: myLatlng,
            icon:image,
            map: map,
            title: 'Hello World!'
        });
        setup_marker(marker);

        var myLatlng = new google.maps.LatLng(59.317864,18.057404);
        var marker = new google.maps.Marker({
            position: myLatlng,
            icon:image,
            map: map,
            title: 'Hello World!'
        });
        setup_marker(marker);

        var myLatlng = new google.maps.LatLng(59.333627,18.024445);
        var marker = new google.maps.Marker({
            position: myLatlng,
            icon:image,
            map: map,
            title: 'Hello World!'
        });
        setup_marker(marker);

        
        var myLatlng = new google.maps.LatLng(59.335816,18.092079);
        var marker = new google.maps.Marker({
            position: myLatlng,
            icon:image,
            map: map,
            title: 'Hello World!'
        });
        setup_marker(marker);

        
      }

      google.maps.event.addDomListener(window, 'load', initialize);

      
    </script>

  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>