jQuery.validator.addMethod("accept", function (value, element, param) {
    return value.match(new RegExp("." + param + "$"));
});

$(document).ready(function () {

    $("#formCadastrar").validate({
        rules: {
            nomeLocal: {
                required: true
                
            }

    },
    //está função permite que logo após a validação dos campos execute uma função, aqui no caso preloading
        submitHandler: function(form) {
            var pre_src = '<div class="rect1"></div>'
            +'<div class="rect2"></div>'
            +'<div class="rect3"></div>'
            +'<div class="rect4"></div>'
            +'<div class="rect5"></div>';

            
            var div = document.createElement("div");
            div.setAttribute("id","teste");
            document.body.appendChild(div);
            var div = document.createElement("div");
            div.setAttribute("class","preloader");
            document.body.appendChild(div);
            document.body.querySelector(".preloader").innerHTML = pre_src;
            form.submit();
          }

    })
    $().ready(function () {
        setTimeout(function () {
            $('#msg').hide();
        }, 10000);
    });

    //VARIÁVEIS GLOBAIS
var marker; 
var map = null;
var latitude;
var longitude;
var popup = L.popup();
var polygon;

$('#buscar').click(function () {
    
    $("div[name='map']").removeAttr('hidden');
    //COMANDO RESPONSÁVEL PELA CAPTURA DAS COORDENADAS DO NAVEGADOR
    navigator.geolocation.watchPosition(success, error);
})

$('#buscarEditar').click(function () {
    
    $("div[name='map']").removeAttr('hidden');
    //COMANDO RESPONSÁVEL PELA CAPTURA DAS COORDENADAS DO NAVEGADOR
    var lat = $('#latitude').val();
    var long = $('#longitude').val();
    var poligono = $('#coordenadasPoligono').val();
    editarCoordenadas(lat,long, poligono);
})

//FUNÇÃO RESPONSÁVEL PELA CAPTURA DAS COORDENADAS ORIUNDAS DO CLIQUE NO MOUSE NO MAPA
function onMapClick(e) {
  //buscando do evento as latitude e longitude
  
  latitude = e.latlng.lat;
  longitude = e.latlng.lng;
  //$('#latitude').val(latitude);
  //$('#longitude').val(longitude);

  if(marker === undefined){
    //criando um marcador
    marker = L.marker([latitude, longitude]).addTo(map);
  }
 
  //alterando as latitude e logitude do marcador baseado no clique na variável 
  marker.setLatLng([latitude, longitude]);
  
  
  
  popup
      .setLatLng(e.latlng)
      .setContent("Você clicou " + e.latlng.toString())
      .openOn(map);
}

//FUNÇÃO RESPONSÁVEL POR ADICIONAR MARCADORES E POLÍGONO NO MAPA - CASO O USUÁRIO PERMITA QUE O NAVEGADOR BUSQUE A LOCALIZAÇÃO
function success(pos){

  //RECEBE AS COORDENADAS DO NAVEGADOR
  latitude = pos.coords.latitude;
  longitude = pos.coords.longitude;

  $('#latitude').val(latitude);
  $('#longitude').val(longitude);
  

  //INSTANCIANDO O MAPA COM AS COORDENADAS INFORMADAS
  map = L.map('map').setView([latitude, longitude], 15);
  //PARÂMETROS DE CONFIGURAÇÃO DO MAPA
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //zoom no mapa
    maxZoom: 19,
    //creditos
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);
  
  //ADICIONADO MARCADO NO MAPA BASEADA NAS COORDENADAS DO NAVEGADOR
  marker = L.marker([latitude, longitude]).addTo(map);
  //MENSAGEM QUE APARECERÁ NO NAVEGADOR - EM POPUP
  marker.bindPopup("<b>Você está aqui!</b>.").openPopup();
  
 
// Adiciona as ferramentas de desenho ao mapa
var drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);

var drawControl = new L.Control.Draw({
  draw: {
    polygon: true,
    polyline: false,
    rectangle: false,
    circle: false,
    marker: false
  },
  edit: {
    featureGroup: drawnItems,
    remove: true
  }
});
map.addControl(drawControl);

// Evento disparado quando um polígono é desenhado no mapa
map.on(L.Draw.Event.CREATED, function (event) {
  var layer = event.layer;
  var polygonCoords = layer.getLatLngs();
  
  // Percorre o array e concatena as coordenadas em uma única string separadas por "%"
  var coordinatesString = polygonCoords.map(function(coord) {
  return coord.join(',');
  }).join('%');
  $('#coordenadasPoligono').val(coordinatesString);
  drawnItems.addLayer(layer);
});

// Evento disparado quando um polígono é editado ou removido
map.on('draw:edited', function (event) {
  var layers = event.layers;
  layers.eachLayer(function (layer) {
    // Realiza alguma ação com o polígono editado
    console.log('Polígono editado:', layer.getLatLngs());
  });
});

map.on('draw:deleted', function (event) {
  var layers = event.layers;
  layers.eachLayer(function (layer) {
    // Realiza alguma ação com o polígono removido
    console.log('Polígono removido:', layer.getLatLngs());
  });
});

  //CHAMANDO A FUNÇÃO POR EVENTO DO CLICK DO MOUSE
  map.on('click', onMapClick);
  
}

//FUNÇÃO RESPONSÁVEL POR ADICIONAR MARCADORES E POLÍGONO NO MAPA - CASO O USUÁRIO NÃO PERMITA QUE O NAVEGADOR BUSQUE A LOCALIZAÇÃO
//SÃO CARREGADOS NO MAPA VALORES DEFAULT
function error(err){
    $('#longitude').val(-40.841136);
    $('#latitude').val(-14.852933);
    map = L.map('map').setView([-14.852933, -40.841136], 15);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      //zoom no mapa
      maxZoom: 19,
      //creditos
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    
    // Adiciona as ferramentas de desenho ao mapa
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
    draw: {
      polygon: true,
      polyline: false,
      rectangle: false,
      circle: false,
      marker: false
    },
    edit: {
      featureGroup: drawnItems,
      remove: true
    }
    });
    map.addControl(drawControl);

    // Evento disparado quando um polígono é desenhado no mapa  
    map.on(L.Draw.Event.CREATED, function (event) {
      var layer = event.layer;
      var polygonCoords = layer.getLatLngs();
  
    // Percorre o array e concatena as coordenadas em uma única string separadas por "%"
      var coordinatesString = polygonCoords.map(function(coord) {
      return coord.join(',');
    }).join('%');
    $('#coordenadasPoligono').val(coordinatesString);
    drawnItems.addLayer(layer);
    });

    // Evento disparado quando um polígono é editado ou removido
    map.on('draw:edited', function (event) {
    var layers = event.layers;
    layers.eachLayer(function (layer) {
      // Realiza alguma ação com o polígono editado
      console.log('Polígono editado:', layer.getLatLngs());
      });
    });

    map.on('draw:deleted', function (event) {
      var layers = event.layers;
      layers.eachLayer(function (layer) {
      // Realiza alguma ação com o polígono removido
      console.log('Polígono removido:', layer.getLatLngs());
      });
    });
    
    map.on('click', onMapClick);
    
  }
  
function editarCoordenadas(lat, long, poligono){
    latitudeE = lat;
    longitudeE = long;

    //INSTANCIANDO O MAPA COM AS COORDENADAS INFORMADAS
    map = L.map('map').setView([latitudeE, longitudeE], 15);
    //PARÂMETROS DE CONFIGURAÇÃO DO MAPA
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      //zoom no mapa
      maxZoom: 19,
      //creditos
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
  
    //ADICIONADO MARCADO NO MAPA BASEADA NAS COORDENADAS DO NAVEGADOR
    marker = L.marker([latitudeE, longitudeE]).addTo(map);
    //MENSAGEM QUE APARECERÁ NO NAVEGADOR - EM POPUP
    marker.bindPopup("<b>Posição do local!</b>.").openPopup();
    //COORDENADAS DO POLÍGONO - É TRAÇADO EM TORNO DO MARCADOR
  
    
    // Quebrar a string em um array de coordenadas
    var arrayCoordenadas = poligono.split('),').map(function(coordString) {
    // Remover o texto "LatLng("
    coordString = coordString.replace('LatLng(', '');
  
    // Dividir a string em latitude e longitude
    var latLng = coordString.split(', ');
    var lat = parseFloat(latLng[0]);
    var lng = parseFloat(latLng[1]);
  
    return L.latLng(lat, lng);
    });

    // Cria o polígono com base nas coordenadas
    var polygon = L.polygon(arrayCoordenadas, { color: 'red' }).addTo(map);
  
    // Ajusta o zoom do mapa para exibir o polígono
    map.fitBounds(polygon.getBounds());

    //CHAMANDO A FUNÇÃO POR EVENTO DO CLICK DO MOUSE
    map.on('click', onMapClick);
  

}    
    
});

  

