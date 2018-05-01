import React from 'react';
import LocationsAddress from './Address';

class LocationsList extends React.Component {
  constructor(props) {
    super(props);

    this.handleLocationsChange = this.handleLocationsChange.bind(this);
  }

  handleLocationsChange(e) {
    this.props.onLocationsChange(e.target.value);
  }

  render() {
    const { locations } = this.props;

    let list = [];

    if (locations) {
      list = locations.map(location => {
        return (
          <li className="list-group-item" key={location.id}>
            <h5>{location.brewery_name}</h5>
            <dl>
              <dt>Address</dt>
              <dd>
                <LocationsAddress location={location}/>
              </dd>
            </dl>
          </li>
        )
      });
    }

    return (
      <ul className="list-group">
        {list}
      </ul>
    )
  }
}

export default LocationsList;
