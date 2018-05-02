import React from 'react';
import LocationsMap from './Locations/Map';
import LocationsList from './Locations/List';

class Locations extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      locations: [],
      accessToken: props.accessToken,
      refs: {
        markers: [],
        listItems: [],
      },
    };

    this.addListItemRef = this.addListItemRef.bind(this);
    this.addMarkerRef = this.addMarkerRef.bind(this);

    this.handleListItemClick = this.handleListItemClick.bind(this);
    this.handleMarkerClick = this.handleMarkerClick.bind(this);

    this.scrollTo = this.scrollTo.bind(this);
  }

  addListItemRef(listItem) {
    const listItems = this.state.refs.listItems;

    if (listItems.indexOf(listItem) < 0) {
      listItems.push(listItem);
    }
  }

  addMarkerRef(marker) {
    const markers = this.state.refs.markers;

    if (markers.indexOf(marker) < 0) {
      markers.push(marker);
    }
  }

  componentDidMount() {
    try {
      this.constructor
        .fetch()
          .then(locations => this.setState({ locations: locations }));
    } catch (e) {
      throw e;
    }
  }

  static async fetch() {
    const response = await fetch('/api/locations');
    return await response.json();
  }

  /**
   * When selecting an item from the unordered list, we want to:
   *
   * 1. Highlight the list item as active
   * b. open the corresponding marker's popup
   * iii. pan the map to center the marker
   *
   * @param position Array of latitude/longitude coordinates
   */
  handleListItemClick(position) {
    const markers = this.state.refs.markers;
    const marker = markers.filter(marker => marker.props.position.toString() === position.toString())
      .shift();

    if (marker) {
      const listItems = this.state.refs.listItems;

      marker.leafletElement._map.flyTo(position);
      marker.leafletElement.openPopup();

      listItems.map(listItem => this.constructor.handleListItemSelection(listItem, position));
    }
  }

  /**
   * For the item at position, mark the element as active. Other elements will be unmarked as active.
   *
   * @param listItem
   * @param position
   */
  static handleListItemSelection(listItem, position) {
    const location = listItem.props.location;
    const _position = [location.latitude, location.longitude];
    const el = listItem.state.item;

    if (_position.toString() === position.toString()) {
      el.classList.add('active');
    } else {
      el.classList.remove('active');
    }
  }

  /**
   * When selecting a marker from the map, we want to:
   *
   * a. Open the popup (this is automatic)
   * ii. Scroll the unordered list to the corresponding item
   * 3. Select the item as active, and deselect previous active items
   *
   * @param marker
   */
  handleMarkerClick(position) {
    const listItems = this.state.refs.listItems;
    const listItem = listItems.filter(listItem => {
      const location = listItem.props.location;
      const _position = [ location.latitude, location.longitude ];

      return _position.toString() === position.toString();
    }).shift();

    if (listItem) {
      this.scrollTo(listItem.state.item.parentElement, listItem.state.item.offsetTop, 1250);
      listItems.map(listItem => this.constructor.handleListItemSelection(listItem, position));
    }
  }

  render() {
    const { locations, accessToken } = this.state;

    return (
      <div className="row">
        <div id="map-view" className="col-md mt-3">
          <LocationsMap
            accessToken={accessToken}
            locations={locations}
            addMarker={this.addMarkerRef}
            handleMarkerClick={this.handleMarkerClick}
          />
        </div>
        <div id="map-list" className="col-md mt-3 pt-2 pb-2">
          <LocationsList
            locations={locations}
            addListItem={this.addListItemRef}
            handleListItemClick={this.handleListItemClick}
          />
        </div>
      </div>
    );
  }

  /**
   * @see https://gist.github.com/andjosh/6764939
   *
   * @param element
   * @param to
   * @param duration
   */
  scrollTo(element, to, duration) {
    const start = element.scrollTop;
    const change = to - start;
    const increment = 20;

    let currentTime = 0;

    const animateScroll = function() {
      currentTime += increment;

      element.scrollTop = this.constructor.easeInOutQuad(currentTime, start, change, duration);

      if (currentTime < duration) {
        setTimeout(animateScroll, increment);
      }
    }.bind(this);

    animateScroll();
  }

  /**
   * @see https://gist.github.com/andjosh/6764939
   *
   * @param t current time
   * @param b start value
   * @param c change in value
   * @param d duration
   *
   * @returns {*}
   */
  static easeInOutQuad (t, b, c, d) {
    t /= d/2;

    if (t < 1) {
      return c / 2 * t * t + b;
    }

    t--;

    return -c / 2 * (t * (t - 2) - 1) + b;
  };
}

export default Locations;
