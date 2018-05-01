import React from 'react';
import LocationsAddress from './Address';

class LocationsListItem extends React.Component {
  constructor(props) {
    super(props);

    this.handleLocationChange = this.handleLocationChange.bind(this);
  }

  handleLocationChange(e) {
    this.props.onLocationChange(e.target.value);
  }

  render() {
    const { location } = this.props;

    return (
      <li className="list-group-item">
        <h5>{location.brewery_name}</h5>
        <dl>
          <dt>Address</dt>
          <dd>
            <LocationsAddress location={location}/>
          </dd>
        </dl>
      </li>
    );
  }
}

export default LocationsListItem;
