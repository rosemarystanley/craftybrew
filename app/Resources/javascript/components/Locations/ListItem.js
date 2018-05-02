import React from 'react';
import LocationsAddress from './Address';

class LocationsListItem extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      item: undefined,
    };

    this.handleLocationChange = this.handleLocationChange.bind(this);
  }

  handleLocationChange(e) {
    this.props.onLocationChange(e.target.value);
  }

  render() {
    const { location, handleListItemClick } = this.props;
    const position = [ location.latitude, location.longitude ];

    return (
      <li
        className="list-group-item"
        ref={ref => this.state.item = ref}
        onClick={() => handleListItemClick(position)}
      >
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
