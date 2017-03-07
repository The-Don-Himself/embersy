import Ember from 'ember';
import OAuth2 from 'frontend/authenticators/oauth2';

export default OAuth2.extend({
    authenticate(json) {
        return new Ember.RSVP.Promise((resolve, reject) => {
            try{
                JSON.parse(json);
            } catch(e) {
                reject('malformed json');
            }
            resolve(JSON.parse(json));
        });
    }
});