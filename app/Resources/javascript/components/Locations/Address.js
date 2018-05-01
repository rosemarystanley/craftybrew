import React from 'react';

class LocationsAddress extends React.Component {
  constructor(props) {
    super(props);

    this.handleAddressChange = this.handleAddressChange.bind(this);
  }

  handleAddressChange(e) {
    this.props.onAddressChange(e.target.value);
  }

  render() {
    const { location } = this.props;

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
    );
  }
}

export default LocationsAddress;
