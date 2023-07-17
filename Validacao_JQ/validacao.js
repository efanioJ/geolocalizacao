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
    editarCoordenadas(lat,long);
})

//FUNÇÃO RESPONSÁVEL PELA CAPTURA DAS COORDENADAS ORIUNDAS DO CLIQUE NO MOUSE NO MAPA
function onMapClick(e) {
  //buscando do evento as latitude e longitude
  
  latitude = e.latlng.lat;
  longitude = e.latlng.lng;
  $('#latitude').val(latitude);
  $('#longitude').val(longitude);

  if(marker === undefined){
    //criando um marcador
    marker = L.marker([latitude, longitude]).addTo(map);
  }
  if(polygon !== undefined){
    //removendo um poligono do mapa caso exista
    polygon.remove();
  }
  //alterando as latitude e logitude do marcador baseado no clique na variável 
  marker.setLatLng([latitude, longitude]);
  
  //coordenadas do poligono
  polygon = L.polygon([
    [(latitude+(-0.001)), (longitude+(-0.001))],
    [(latitude+(0.001)), (longitude+(-0.001))],
    [(latitude), (longitude+(0.001))]
  ]).addTo(map);
  
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
  
  //COORDENADAS DO POLÍGONO - É TRAÇADO EM TORNO DO MARCADOR
  polygon = L.polygon([
    [(latitude+(-0.001)), (longitude+(-0.001))],
    [(latitude+(0.001)), (longitude+(-0.001))],
    [(latitude), (longitude+(0.001))]
  ]).addTo(map);

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
    
    map.on('click', onMapClick);
    
  }
  
function editarCoordenadas(lat, long){
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
  
  polygon = L.polygon([
    [(parseFloat(latitudeE)+(-0.001)), (parseFloat(longitudeE)+(-0.001))],
    [(parseFloat(latitudeE)+(0.001)), (parseFloat(longitudeE)+(-0.001))],
    [(parseFloat(latitudeE)), (parseFloat(longitudeE)+(0.001))]
  ]).addTo(map);

  //CHAMANDO A FUNÇÃO POR EVENTO DO CLICK DO MOUSE
  map.on('click', onMapClick);

}    
    
});

  

