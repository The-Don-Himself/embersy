import Ember from 'ember';

export default Ember.Route.extend({
  title: 'About | Embersy',
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
      resHeaders.set('Cache-Control', 'public, s-maxage=86400, max-age=86400');
    }
  },

  headData: Ember.inject.service(),

  afterModel() {
    let title = 'About | Embersy';
    this.set('headData.title', title);
    this.set('headData.description', 'Embersy is your nifty kickstart package for building ambitious web apps.');
    this.set('headData.keywords', 'about embersy,embersy,embersymfony,ember,symfony');
  }

});
