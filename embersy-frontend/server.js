const FastBootAppServer = require('fastboot-app-server');

var server = new FastBootAppServer({
  distPath: '/home/vcap/app/dist',
  gzip: true // Optional - Enables gzip compression.
});

server.start();