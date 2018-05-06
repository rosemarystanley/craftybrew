import React from 'react';
import buildUrl from 'build-url';
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
        map: undefined,
      },
      centerPoint: undefined
    };

    this.addListItemRef = this.addListItemRef.bind(this);
    this.updateMarkerRefs = this.updateMarkerRefs.bind(this);

    this.handleListItemClick = this.handleListItemClick.bind(this);
    this.handleMarkerClick = this.handleMarkerClick.bind(this);
    this.handleMoveEnd = this.handleMoveEnd.bind(this);
    this.handleMoveStart = this.handleMoveStart.bind(this);

    this.scrollTo = this.scrollTo.bind(this);
  }

  addListItemRef(listItem) {
    const listItems = this.state.refs.listItems;

    if (listItems.indexOf(listItem) < 0) {
      listItems.push(listItem);
    }
  }

  updateMarkerRefs(markers, map) {
    const refs = this.state.refs;
    refs.markers = markers;
    refs.map = map;
  }

  static async fetch(center, distance) {
    const response = await fetch(buildUrl('', {
      path: '/api/locations',
      queryParams: { latitude: center.lat || '', longitude: center.lng || '', distance: distance || '' }
    }));
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
    const marker = markers.filter(marker => {
      const location = marker.props.location;
      const _position = [location.latitude, location.longitude];
      return ''+_position === ''+position
    })
      .shift();

    if (marker) {
      const map = this.state.refs.map;
      const listItems = this.state.refs.listItems;

      map.leafletElement.flyTo(position);

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
   * @param position
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

  /**
   * The idea is to allow minute movements within an expanded bounding box before updating the list
   * of breweries. Any time the map displays outside of this expanded bounding box, then update the list.
   *
   * Idea 1: Calculate a +/- n-mile radius around the center of the map, and any time the center moves outside of that
   *         radius, then update. No bounding box required.
   *
   * @param e
   */
  handleMoveEnd(e) {
    const mapElement = e.target;
    const newCenter = mapElement.getCenter();
    const centerPoint = this.state.centerPoint;
    const mileRadius = 1 / 69.172;

    try {
      // If no center point exists, or the center point has moved more than one mile from
      // it's original position, then update the list.
      if (!centerPoint || (Math.abs(newCenter.lat - centerPoint.lat)) > mileRadius) {
        const bounds = mapElement.getBounds();
        // Divide the calculated distance (meters) by 111,111.1 meters (1º of latitude)
        // This should take into account zoom factor and draw a radius beyond the visible
        // view port.
        const distance = mapElement.distance(bounds.getNorthWest(), newCenter) / 111111.1;

        this.constructor
          .fetch(newCenter, distance)
            .then(locations => {
              this.setState({ centerPoint: newCenter, locations: locations });
            });
      }
    } catch (e) {
      throw e;
    }
  }

  handleMoveStart(e) {
    const mapElement = e.target;

    if (!this.state.centerPoint) {
      this.forceUpdate();
    }

    this.setState({ centerPoint: mapElement.getCenter() });
  }

  render() {
    const { locations, accessToken } = this.state;

    return (
      <div className="row">
        <div id="map-view" className="col-md mt-3">
          <LocationsMap
            accessToken={accessToken}
            locations={locations}
            updateMarkers={this.updateMarkerRefs}
            handleMarkerClick={this.handleMarkerClick}
            handleMoveEnd={this.handleMoveEnd}
            handleMoveStart={this.handleMoveStart}
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
