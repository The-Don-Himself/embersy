import Ember from 'ember';
import ENV from 'frontend/config/environment';
import fetch from 'ember-network/fetch';

export default Ember.Route.extend({
  fastboot: Ember.inject.service(),

  beforeModel(transition) {
	if (!this.get('session.isAuthenticated')) {
		this.set('session.attemptedTransition' , transition);
	}
  },

  model(params) {
    let store = this.store;
    let isFastBoot = this.get('fastboot.isFastBoot');
    let shoebox = this.get('fastboot.shoebox');
    let shoeboxStore = shoebox.retrieve('my-store');
	if (isFastBoot) {
        if (!shoeboxStore) {
            shoeboxStore = {};
            shoebox.put('my-store', shoeboxStore);
        }
        let resHeaders = this.get('fastboot.response.headers');
        resHeaders.set('Cache-Control', 'public, s-maxage=86400, max-age=60');

        return fetch(ENV.apiUrl + '/api/profiles/' + params.user_id)
            .then(function(response) { return response.json(); })
            .then(function(data) { 
                shoeboxStore['profile'] = data; 
                return store.findRecord('profile', params.user_id);
            });
	} else {
        let shoebox = this.get('fastboot.shoebox');
        let shoeboxStore = shoebox.retrieve('my-store');
        let profile = shoeboxStore['profile'];
        if(profile){
            store.pushPayload('profile' , profile);
            let profileId = profile.data.id;
			return store.peekRecord("profile" , profileId);
        } else {
            return store.findRecord('profile', params.user_id);
        }
    }
  },

  titleToken: function(model) {
    return '@' + model.get('user.username');
  },

  headData: Ember.inject.service(),

  afterModel(model) {
    let title = '@' + model.get('user.username') || "404 - User Not Found!";
    this.set('headData.title', title);
    this.set('headData.description', '@' + model.get('user.username') + '\'s Profile on Embersy');
    this.set('headData.keywords', '@' + model.get('user.username') + '\'s Profile on Embersy');
    this.set('headData.image', 'users/' + model.get('id') + '/avatar.jpeg?v=' + model.get('avatarversion'));
    this.set('headData.imageType', 'image/jpeg');
    this.set('headData.imageWidth', '200');
    this.set('headData.imageHeight', '200');
    this.set('headData.profile', model);
  }

});
