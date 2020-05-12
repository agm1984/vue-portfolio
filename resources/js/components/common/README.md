# Adam's portfolio

> All Vue components in this folder are automatically globally-registered when the App is instantiated.

The `index.js` file is called by `resources/js/app.js`

These components are dynamically imported, as indicated by the "lazy" option in `require.context('./', true, /\.vue$/i, 'lazy')`. This is important towards minimizing the main JS bundle size and therefore, initial app loading performance. A component is only downloaded if it is used downstream of the active-route component.
