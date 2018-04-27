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
    const mapList = document
      .getElementById('map-list')
        .getElementsByTagName('ul')[0];

    breweries.forEach(function (brewery) {
      const h5 = document.createElement('h5');
            h5.appendChild(document.createTextNode(brewery.name));

      const dt = document.createElement('dt');
            dt.appendChild(document.createTextNode('Address'));

      const dd = document.createElement('dd');
            dd.appendChild(document.createTextNode(brewery.address));
            dd.appendChild(document.createElement('br'));
            dd.appendChild(document.createTextNode(
              brewery.city + ', ' +
              brewery.state + ' ' +
              brewery.postal)
            );

      const dl = document.createElement('dl');
            dl.appendChild(dt);
            dl.appendChild(dd);

      const listItem = document.createElement('li');
            listItem.appendChild(h5);
            listItem.appendChild(dl);
            listItem.className = 'list-group-item';

      mapList.appendChild(listItem);

      const marker = L
        .marker([brewery.latitude, brewery.longitude], {
          title: h5.innerText,
          alt: h5.innerText
        })
        .addTo(map);

      marker.on('click', function (mapList, listItem) {
        mapList.childNodes.forEach(function (childNode) {
          childNode.classList.remove('active')
        });

        listItem.classList.add('active');
        scrollTo(mapList, listItem.offsetTop, 1250)
      }.bind(null, mapList, listItem));

      // TODO Templating
      const popup = L.popup();
            popup.setLatLng(marker.getLatLng());
            popup.setContent(h5.outerHTML + dl.outerHTML);

      marker.bindPopup(popup);
    });

  })
  .catch(function (error) {});

/**
 * @see https://gist.github.com/andjosh/6764939
 *
 * @param element
 * @param to
 * @param duration
 */
function scrollTo(element, to, duration) {
  const start = element.scrollTop;
  const change = to - start;
  const increment = 20;

  let currentTime = 0;

  const animateScroll = function() {
    currentTime += increment;

    element.scrollTop = easeInOutQuad(currentTime, start, change, duration);

    if (currentTime < duration) {
      setTimeout(animateScroll, increment);
    }
  };

  animateScroll();
}

/**
 * @see https://gist.github.com/andjosh/6764939
 *
 * @param t current time
 * @param b start value
 * @param c change in value
 * @param d duration
 *
 * @returns {*}
 */
const easeInOutQuad = function (t, b, c, d) {
  t /= d/2;

  if (t < 1) {
    return c / 2 * t * t + b;
  }

  t--;

  return -c / 2 * (t * (t - 2) - 1) + b;
};
