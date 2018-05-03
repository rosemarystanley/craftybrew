import React from 'react';
import { Map, TileLayer } from 'react-leaflet';
import MapMarker from './MapMarker';

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
        return <MapMarker
          key={location.id}
          location={location}
          addMarker={this.props.addMarker}
          handleMarkerClick={this.props.handleMarkerClick}
        />;
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
