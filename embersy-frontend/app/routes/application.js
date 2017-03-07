import Ember from 'ember';
import ApplicationRouteMixin from 'ember-simple-auth/mixins/application-route-mixin';

const { inject: { service }, Route } = Ember;

export default Route.extend(ApplicationRouteMixin, {
	fastboot: service(),
	session: service('session'),
	sessionAccount: service('session-account'),

	beforeModel(transition) {
		if (!this.get('session.isAuthenticated')) {
			this.set('session.attemptedTransition' , transition);
		}
		return this._loadCurrentUser();
	},

	sessionAuthenticated() {
		this._super(...arguments);
		this._loadCurrentUser();
	},

	_loadCurrentUser() {
		return this.get('sessionAccount').loadCurrentUser();
	},

    actions: {
        logout() {
            let session = this.get('session');

            let submitButton = Ember.$('#logout');
            let loading = Ember.$('<div>' , { 'html': 'processing...' });
            submitButton.replaceWith(loading);

            session.invalidate();
        }
    }

});
