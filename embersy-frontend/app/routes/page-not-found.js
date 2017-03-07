import Ember from 'ember';

export default Ember.Route.extend({
  title: '404 - Page Not Found',
  fastboot: Ember.inject.service(),

  beforeModel(transition) {
	if (!this.get('session.isAuthenticated')) {
		this.set('session.attemptedTransition' , transition);
	}
  },

  model() {
	let isFastBoot = this.get('fastboot.isFastBoot');

	if (isFastBoot) {
		let resHeaders = this.get('fastboot.response.headers');
		resHeaders.set('Cache-Control', 'public, s-maxage=86400, max-age=1800');
		this.set('fastboot.response.statusCode' , 404);
	}
  },

  headData: Ember.inject.service(),

  afterModel() {
    let title = '404 - Page Not Found';
    this.set('headData.title', title);
    this.set('headData.description', '404 - Page Not Found.');
    this.set('headData.keywords', 'page not found');
  }

});
