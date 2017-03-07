import Ember from 'ember';

export default Ember.Route.extend({
  title: 'Login | Embersy',
  fastboot: Ember.inject.service(),
  session: Ember.inject.service('session'),
  sessionAccount: Ember.inject.service('session-account'),

  model() {
    let isFastBoot = this.get('fastboot.isFastBoot');

    if (isFastBoot) {
      let resHeaders = this.get('fastboot.response.headers');
	  resHeaders.set('Cache-Control', 'public, s-maxage=86400, max-age=86400');
    }

  },

  headData: Ember.inject.service(),

  afterModel() {
    let title = 'Login | Embersy';
    this.set('headData.title', title);
    this.set('headData.description', 'Your nifty kickstart package for building ambitious web apps.');
    this.set('headData.keywords', 'login,sign in');
    this.set('headData.login', true);
  },

  actions: {
    login() {
      let session = this.get('session');
      let logInForm = Ember.$('form');

      let submitButton = logInForm.find(":submit");
      let loading = Ember.$('<div>' , { 'html': 'processing...' });
      submitButton.replaceWith(loading);

	  let identification = Ember.$('#identification').val();
	  let password = Ember.$('#password').val();

      session.authenticate('authenticator:oauth2', identification, password).catch((reason) => {
        alert(reason.error || reason);
      }).then(function(){
        loading.replaceWith(submitButton);
	  });
    }
  }

});
