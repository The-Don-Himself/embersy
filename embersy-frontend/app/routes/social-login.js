import Ember from 'ember';

export default Ember.Route.extend({
  title: 'Social Login | Embersy',
  fastboot: Ember.inject.service(),

  beforeModel(transition) {
	if (!this.get('session.isAuthenticated')) {
		this.set('session.attemptedTransition' , transition);
	}
  },

  model() {
    let isFastBoot = this.get('fastboot.isFastBoot');
    let shoebox = this.get('fastboot.shoebox');
    let shoeboxStore = shoebox.retrieve('my-store');

    if (isFastBoot) {
        if (!shoeboxStore) {
            shoeboxStore = {};
            shoebox.put('my-store', shoeboxStore);
        }
        let service = this.get('fastboot.request.queryParams.service');
        shoeboxStore['service'] = service;

        let oauth2 = this.get('fastboot.request.queryParams.oauth2');
        shoeboxStore['oauth2'] = oauth2;

        let resHeaders = this.get('fastboot.response.headers');
        resHeaders.set('Cache-Control', 'private, s-maxage=0, max-age=0, no-cache, no-store');
    } else {
        return Ember.RSVP.hash({
            service: shoeboxStore['service'],
            oauth2: shoeboxStore['oauth2']
        });
    }
  },

  headData: Ember.inject.service(),

  afterModel() {
    let title = 'Social Login | Embersy';
    this.set('headData.robotsIndex', 'noindex');
    this.set('headData.robotsFollow', 'follow');
    this.set('headData.title', title);
    this.set('headData.description', '.');
    this.set('headData.keywords', '');
  }

});
