import OAuth2PasswordGrant from 'ember-simple-auth/authenticators/oauth2-password-grant';
import ENV from 'frontend/config/environment';

export default OAuth2PasswordGrant.extend({
  serverTokenEndpoint: ENV.serverTokenEndpoint,
  makeRequest: function(url, data){
    data.client_id = ENV.clientId;
    data.client_secret = ENV.clientSecret;
    return this._super(url, data);
  }
});