import Ember from 'ember';
import ENV from 'frontend/config/environment';
import fetch from 'ember-network/fetch';

const { inject: { service }, Service } = Ember;

export default Service.extend({
	session: service('session'),
	store: service(),

	loadCurrentUser() {
		let service = this;
		if (service.get('session.isAuthenticated')) {
			const headers = {};
			service.get('session').authorize('authorizer:oauth2', (headerName, headerValue) => {
				headers[headerName] = headerValue;
			});

			headers['Accept'] = 'application/json, text/javascript, */*';

			let fetchInit = {
				method: 'GET',
				headers: headers,
				cache: 'default'
			};

			fetch(ENV.apiUrl + '/api/accounts/me' , fetchInit)
				.then(
					function(response) {
						if (response.status !== 200) {
							service.get('session').invalidate();
							return;
						}

						// Examine the text in the response
						response.json().then(function(data) {
							service.get('store').pushPayload('account' , data);
							let profile = service.get('store').peekRecord('account' , 'me');
							service.set('profile', profile);
							let userId = profile.get('user.id');
							service.get('store').findRecord('profile' , userId);
						});
					}
				)
				.catch(function() {
					service.get('session').invalidate();
				});
		}
	}

});
