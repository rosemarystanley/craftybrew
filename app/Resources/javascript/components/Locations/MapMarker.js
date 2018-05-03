import React from 'react';
import { Marker, Popup } from 'react-leaflet';
import LocationsAddress from './Address';

class MapMarker extends React.Component {
  constructor(props) {
    super(props);

    this.handleLocationChange = this.handleLocationChange.bind(this);
  }

  handleLocationChange(e) {
    this.props.onLocationChange(e.target.value);
  }

  render() {
    const { location } = this.props;
    const point = [ location.latitude, location.longitude ];

    return (
      <Marker
        position={point}
        ref={ref => this.props.addMarker(ref)}
        onClick={() => this.props.handleMarkerClick(point)}
      >
        <Popup>
          <div>
            <h5>{location.brewery_name}</h5>
            <dl>
              <dt>Address</dt>
              <dd>
                <LocationsAddress location={location}/>
              </dd>
            </dl>
          </div>
        </Popup>
      </Marker>
    );
  }
}

export default MapMarker;
