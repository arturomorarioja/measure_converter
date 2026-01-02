/* eslint-disable indent */
const { defineConfig } = require('cypress');

module.exports = defineConfig({
  e2e: {
    baseUrl: 'http://localhost/measure_converter',
    setupNodeEvents(on, config) {   // eslint-disable-line
      // implement node event listeners here
    },
  },
  integration: {
    
  }
});
