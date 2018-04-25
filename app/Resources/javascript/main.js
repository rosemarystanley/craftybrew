require('es6-promise').polyfill();
require('isomorphic-fetch');

// Load the map
const map = L.map('map').setView([35.227, -80.843], 13);
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
  attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
  maxZoom: 18,
  id: 'mapbox.light',
  accessToken: mapbox_access_token
}).addTo(map);

// Get the map data
fetch('/api/breweries')
  .then(function (response) {
    if (response.status >= 400) {
      throw new Error("Received the following error from the server: " + response.statusText);
    }

    return response.json()
  })
  .then(function (breweries) {
    breweries.forEach(function (brewery) {
      const marker = L
        .marker([brewery.latitude, brewery.longitude])
        .addTo(map);

      // TODO Templating
      marker.bindPopup(
        '<h5>' + brewery.name + '</h5>' +
        '<dl>' +
        '  <dt>Address</dt>' +
        ' <dd>' +
            brewery.address + '<br>' +
            brewery.city + ', ' +
            brewery.state + ' ' +
            brewery.postal +
        ' </dd>' +
        '</dl>'
      );
    });

  })
  .catch(function (error) {});

