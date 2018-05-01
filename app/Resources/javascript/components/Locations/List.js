import React from 'react';
import LocationsListItem from './ListItem';

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
      list = locations.map(location => <LocationsListItem location={location} key={location.id}/>);
    }

    return (
      <ul className="list-group">
        {list}
      </ul>
    )
  }
}

export default LocationsList;
