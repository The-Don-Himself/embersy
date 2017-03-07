import Ember from 'ember';
import ApplicationRouteMixin from 'ember-simple-auth/mixins/application-route-mixin';
import ENV from 'frontend/config/environment';
import fetch from 'ember-network/fetch';

const { inject: { service }, Route } = Ember;

export default Route.extend(ApplicationRouteMixin, {
	fastboot: service(),
	session: service('session'),
	sessionAccount: service('session-account'),
	store: service('store'),

	model() {
        let store = this.store;
		let isFastBoot = this.get('fastboot.isFastBoot');
		let shoebox = this.get('fastboot.shoebox');
		let shoeboxStore = shoebox.retrieve('my-store');

		if (isFastBoot) {
			if (!shoeboxStore) {
				shoeboxStore = {};
				shoebox.put('my-store', shoeboxStore);
			}
			return fetch(ENV.apiUrl + '/api/profiles')
                .then(function(response) { return response.json(); })
                .then(function(data) { shoeboxStore['profiles'] = data; });
		} else {
			if (!shoeboxStore) {
                return store.findAll('profile');
            }
			let profiles = shoeboxStore['profiles'];
			if(profiles){
                store.pushPayload('profile' , profiles);
                return store.peekAll('profile');
            } else {
                return store.findAll('profile');
            }
		}
	},

    headData: Ember.inject.service(),

    afterModel() {
        let title = 'Users | Embersy';
        this.set('headData.title', title);
        this.set('headData.description', 'Your nifty kickstart package for building ambitious web apps.');
        this.set('headData.keywords', 'users,profiles');
        this.set('headData.profiles', true);
    }

});
