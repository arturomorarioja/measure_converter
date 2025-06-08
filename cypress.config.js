/* eslint-disable indent */
const { defineConfig } = require('cypress');

module.exports = defineConfig({
  e2e: {
    baseUrl: 'http://localhost/__testE25/_e2e/measure_converter',
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
  integration: {
    
  }
});
