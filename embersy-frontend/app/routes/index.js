import Ember from 'ember';

export default Ember.Route.extend({
  fastboot: Ember.inject.service(),
  session: Ember.inject.service('session'),
  sessionAccount: Ember.inject.service('session-account'),

  titleToken: function() {
    return this.get('session.isAuthenticated') ? "Embersy" : "Welcome To Embersy";
  },

  beforeModel(transition) {
	if (!this.get('session.isAuthenticated')) {
		this.set('session.attemptedTransition' , transition);
	}
  },

  model() {
	let isFastBoot = this.get('fastboot.isFastBoot');
    if (isFastBoot) {
      let resHeaders = this.get('fastboot.response.headers');
      resHeaders.set('Cache-Control', 'public, s-maxage=86400, max-age=86400');
    }
  },

  headData: Ember.inject.service(),

  afterModel() {
    let title = this.get('session.isAuthenticated') ? "Embersy" : "Welcome To Embersy";
    this.set('headData.title', title);
    this.set('headData.home', true);
  }

});
