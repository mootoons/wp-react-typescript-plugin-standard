import * as React from 'react';
import { __ } from '@wordpress/i18n';

import './index.scss';

export default () => {
  return (
    <div className='home-page'>
      <div className='card'>
        <h3>{__('Home', 'my-app')}</h3>
        <p>
          {__('Edit HomePage at ', 'my-app')}
          <code>src/pages/home/index.tsx</code>
        </p>
      </div>
    </div>
  );
};
