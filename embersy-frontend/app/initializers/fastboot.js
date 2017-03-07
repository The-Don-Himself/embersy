export function initialize(application) {
  application.inject('route', 'fastboot', 'service:fastboot');
  application.inject('controller', 'fastboot', 'service:fastboot');
  application.inject('component', 'fastboot', 'service:fastboot');
}

export default {
  name: 'fastboot',
  initialize
};
