import React from 'react';
import {render} from 'react-dom';

import Locations from './components/Locations';

render(
  <Locations accessToken={mapbox_access_token}/>,
  document.getElementById('react-app-locations')
);
