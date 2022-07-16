import * as React from 'react';
import { HashRouter, Routes, Route } from 'react-router-dom';

import routes from '@routes/index';

export default () => {
  return (
    <HashRouter>
      <Routes>
        {routes.map((route, index) => (
          <Route key={index} path={route.path} element={<route.element />} />
        ))}
      </Routes>
    </HashRouter>
  );
};
