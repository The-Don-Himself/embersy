import Ember from 'ember';
import config from './config/environment';

const Router = Ember.Router.extend({
  location: config.locationType,
  rootURL: config.rootURL,
  headData: Ember.inject.service(),
  fastboot: Ember.inject.service(),

  setTitle(title) {
    this.get('headData').set('title', title);
  },

  didTransition() {
    this._super(...arguments);
    let isFastBoot = this.get('fastboot.isFastBoot');
    if (!isFastBoot) {
        Ember.$('body').animate({ scrollTop: 0 }, 500);
    }
  }

});

Router.map(function() {
  this.route('users', function() {
    this.route('show', { path: '/:user_id' });
  });
  this.route('about');
  this.route('login');
  this.route('register');
  this.route('social-login');
  this.route('page-not-found', { path: '/*wildcard' });
});

export default Router;
