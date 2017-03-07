import Ember from 'ember';

const { inject: { service }, Component } = Ember;

export default Component.extend({
  session: service('session'),
  sessionAccount: service('session-account'),

  didInsertElement() {
    let component = this;

	this.set('service', null);

    let headers = this.get('headers');

    if(!headers){
        component.get('router').transitionTo('login');
        alert("Please try to login again.");
        return;
	}

    if(!headers['service'] || !headers['oauth2']){
        component.get('router').transitionTo('login');
        alert("Please try to login again.");
        return;
	}

    component.set('service' , headers['service']);
    alert("You've Successfully Logged in via " + headers['service']);

    component.get('session').authenticate('authenticator:social', headers['oauth2']).catch((reason) => {
        alert(reason.error || reason);
    }).then(function(){
        component.get('router').transitionTo('index');
        component.get('sessionAccount').loadCurrentUser();
    });
  }
});
