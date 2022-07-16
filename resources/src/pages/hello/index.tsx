import * as React from 'react';
import { __ } from '@wordpress/i18n';

import './index.scss';

export default () => {
  return (
    <div className='hello-page'>
      <div className='card'>
        <h3>{__('Hello', 'my-app')}</h3>
        <p>
          {__('Edit HelloPage at ', 'my-app')}
          <code>src/pages/hello/index.tsx</code>
        </p>
      </div>
    </div>
  );
};
