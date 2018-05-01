import React from 'react';
import { Map, TileLayer, Marker, Popup } from 'react-leaflet';

class LocationsMap extends React.Component {
  constructor(props) {
    super(props);

    this.handleAccessTokenChange = this.handleAccessTokenChange.bind(this);
    this.handleLocationChange = this.handleLocationChange.bind(this);

    this.state = {
      latlng: [35.227, -80.843], // Charlotte, NC, USA
      zoom: 13,
      maxZoom: 18,
      style: 'mapbox.light',
    };
  }

  address(location) {
    return (
      <div>
        {location.address &&
        <span>{location.address}<br/></span>
        }

        {location.address_extended &&
        <span>{location.address_extended}<br/></span>
        }

        {location.city &&
        <span>{location.city}</span>
        }

        {(location.state || location.postal) &&
        <span>,</span>
        }

        {location.state &&
        <span> {location.state}</span>
        }

        {location.postal &&
        <span> {location.postal}</span>
        }
      </div>
    )
  }

  handleLocationChange(e) {
    this.props.onLocationsChange(e.target.value);
  }

  handleAccessTokenChange(e) {
    this.props.onAccessTokenChange(e.target.value);
  }

  render() {
    const {
      latlng,
      zoom,
      maxZoom,
      style,
    } = this.state;

    const {
      locations,
      accessToken
    } = this.props;

    let markers = [];

    if (locations) {
      markers = locations.map(location => {
        const position = [ location.latitude, location.longitude ];
        const address = this.address(location);

        return (
          <Marker position={position} key={location.id}>
            <Popup>
              <div>
                <h5>{location.brewery_name}</h5>
                <dl>
                  <dt>Address</dt>
                  <dd>
                    {address}
                  </dd>
                </dl>
              </div>
            </Popup>
          </Marker>
        );
      });
    }

    return (
      <Map center={latlng} zoom={zoom} id="map">
        <TileLayer
          attribution="Map data &copy; <a href=&quot;http://openstreetmap.org&quot;>OpenStreetMap</a> contributors, <a href=&quot;http://creativecommons.org/licenses/by-sa/2.0/&quot;>CC-BY-SA</a>, Imagery © <a href=&quot;http://mapbox.com&quot;>Mapbox</a>"
          url="https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}"
          maxZoom={maxZoom}
          id={style}
          accessToken={accessToken}
        />
        {markers}
      </Map>
    );
  }
}

export default LocationsMap;
