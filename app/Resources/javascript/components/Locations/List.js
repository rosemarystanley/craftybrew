import React from 'react';

class LocationsList extends React.Component {
  constructor(props) {
    super(props);

    this.handleLocationsChange = this.handleLocationsChange.bind(this);
  }

  address(props) {
    const location = props.location;

    if (location.address_extended) {
      return (
        <span>
          {location.address}<br/>
          {location.address_extended}<br/>
        </span>
      )
    } else {
      return (
        <span>{location.address}<br/></span>
      )
    }
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
                <this.address location={location}/>
                {location.city}, {location.state} {location.postal}
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
