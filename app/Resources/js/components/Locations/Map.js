import React from 'react';
import { Map, TileLayer } from 'react-leaflet';
import MapMarker from './MapMarker';

class LocationsMap extends React.Component {
  constructor(props) {
    super(props);

    this.handleAccessTokenChange = this.handleAccessTokenChange.bind(this);
    this.handleLocationChange = this.handleLocationChange.bind(this);
    this.handleLocationFound = this.handleLocationFound.bind(this);
    this.handleLocationError = this.handleLocationError.bind(this);

    this.state = {
      latlng: [0, 0],
      zoom: 13,
      maxZoom: 18,
      style: 'mapbox.light',
      origin: [0, 0],
      originColor: '#883333',
    };
  }

  componentDidMount() {
    this.refs.map.leafletElement.locate();
  }

  handleLocationChange(e) {
    this.props.onLocationsChange(e.target.value);
  }

  handleLocationFound(e) {
    const map = this.refs.map.leafletElement;
    map.stopLocate();

    console.log('Location found: %o', e);

    this.setState({ origin: e.latlng });

    L.marker(this.state.origin).addTo(map).bindPopup('You are here.').openPopup();
    L.circle(this.state.origin, {radius: e.accuracy / 2 * this.state.zoom, color: this.state.originColor}).addTo(map);
    map.flyTo(this.state.origin, this.state.zoom);
  }

  handleLocationError(e) {
    const map = this.refs.map.leafletElement;
    map.stopLocate();

    console.log('Unable to get location: %o', e);

    this.setState({ origin: [35.227, -80.843] });

    L.marker(this.state.origin).addTo(map).bindPopup('You are here.').openPopup();
    L.circle(this.state.origin, {radius: 26.2 * this.state.zoom, color: this.state.originColor}).addTo(map);
    map.flyTo(this.state.origin, this.state.zoom);
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
          handleMarkerClick={this.props.handleMarkerClick}
        />;
      });
    }

    const returnMap = (
      <Map
        center={latlng}
        zoom={zoom}
        id="map"
        ref="map"
        onLocationfound={this.handleLocationFound}
        onLocationError={this.handleLocationError }
        onMoveEnd={this.props.handleMoveEnd}
        onMoveStart={this.props.handleMoveStart}
      >
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

    this.props.updateMarkers(markers, this.refs.map);

    return returnMap;
  }
}

export default LocationsMap;
