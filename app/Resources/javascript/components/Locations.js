import React from 'react';
import LocationsMap from './Locations/Map';
import LocationsList from './Locations/List';

class Locations extends React.Component {
  constructor(props) {
    super(props);

    this.state = { locations: [], accessToken: props.accessToken };
  }

  async fetch() {
    const response = await fetch('/api/locations');
    return await response.json();
  };

  componentDidMount() {
    try {
      this.fetch().then(locations => this.setState({ locations: locations }));
    } catch (e) {
      throw e;
    }
  }

  render() {
    const { locations, accessToken } = this.state;

    return (
      <div className="row">
        <div id="map-view" className="col-md mt-3">
          <LocationsMap accessToken={accessToken} locations={locations}/>
        </div>
        <div id="map-list" className="col-md mt-3 pt-2 pb-2">
          <LocationsList locations={locations}/>
        </div>
      </div>
    );
  }
}

export default Locations;
