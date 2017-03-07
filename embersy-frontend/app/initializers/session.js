export function initialize(application) {
  application.inject('route', 'session', 'service:session');
  application.inject('route', 'sessionAccount', 'service:session-account');
  application.inject('controller', 'session', 'service:session');
  application.inject('controller', 'sessionAccount', 'service:session-account');
  application.inject('component', 'session', 'service:session');
  application.inject('component', 'sessionAccount', 'service:session-account');
}

export default {
  name: 'session',
  after: 'ember-simple-auth',
  initialize
};
