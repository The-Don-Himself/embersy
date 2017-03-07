/* jshint node: true */

module.exports = function(environment) {
  var ENV = {
    modulePrefix: 'frontend',
    environment: environment,
    rootURL: '/',
    apiUrl: 'https://embersy-backend.mybluemix.net',
    apiNamespace: 'api',
    serverTokenEndpoint: 'https://embersy-backend.mybluemix.net/oauth/v2/token',
    clientId: '1_4w0fuf92dvs408kwowok04s008c04ws08k4wcsggk4ok04w0kk',
    clientSecret: '5k17q2cbuswskkksk00ckcw4g44o4ooo48gwgs40sgk8gcogsg',
    locationType: 'auto',
    EmberENV: {
      FEATURES: {
        // Here you can enable experimental features on an ember canary build
        // e.g. 'with-controller': true
      }
    },

    APP: {
      // Here you can pass flags/options to your application instance
      // when it is created
      version: '1.0.0'
    },

    'ember-simple-auth': {
        authenticationRoute: 'login',
        routeIfAlreadyAuthenticated: 'index',
        routeAfterAuthentication: 'index'
    },

    fastboot: {
        hostWhitelist: ['mybluemix.net', 'embersy.mybluemix.net', 'embersy-frontend.mybluemix.net', 'localhost', /^localhost:\d+$/]
    }

  };

  if (environment === 'development') {
    // ENV.APP.LOG_RESOLVER = true;
    // ENV.APP.LOG_ACTIVE_GENERATION = true;
    // ENV.APP.LOG_TRANSITIONS = true;
    // ENV.APP.LOG_TRANSITIONS_INTERNAL = true;
    // ENV.APP.LOG_VIEW_LOOKUPS = true;
  }

  if (environment === 'test') {
    // Testem prefers this...
    ENV.locationType = 'none';

    // keep test console output quieter
    ENV.APP.LOG_ACTIVE_GENERATION = false;
    ENV.APP.LOG_VIEW_LOOKUPS = false;

    ENV.APP.rootElement = '#ember-testing';
  }

  if (environment === 'production') {

  }

  return ENV;
};
