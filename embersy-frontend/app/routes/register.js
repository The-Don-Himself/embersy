import Ember from 'ember';
import ENV from 'frontend/config/environment';

export default Ember.Route.extend({
  title: 'Register | Embersy',
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
    let title = 'Register | Embersy';
    this.set('headData.title', title);
    this.set('headData.description', 'Your nifty kickstart package for building ambitious web apps.');
    this.set('headData.keywords', 'register,sign up');
    this.set('headData.register', true);
  },

  actions: {
    register(){
      let store = this.store;
      let session = this.get('session');
      let signUpForm = Ember.$('form');

      let submitButton = signUpForm.find(":submit");
      let loading = Ember.$('<div>' , { 'html': 'processing...' });
      submitButton.replaceWith(loading);

      let formData = new FormData(signUpForm[0]);
	  let accountUsername = Ember.$('.username').val();
	  let accountFirstname = Ember.$('.firstname').val();
	  let accountLastname = Ember.$('.lastname').val();
	  let accountEmail = Ember.$('.email').val();
	  let accountPassword = Ember.$('.password').val();

      Ember.$.ajax({
        url: ENV.apiUrl + "/api/accounts",
		cache: false,
		type: "POST",
		data: formData,
		dataType: 'json',
		contentType: false,
		processData: false,
        statusCode: {
          201: function(response){
			let userId = response.user_id;
			alert('Sign Up Success : User ID is ' + userId);

            store.push({
                data: [{
                    id: userId,
                    type: 'user',
                    attributes: {
                        username: accountUsername
                    }
                }]
            });

            store.push({
                data: [{
                    id: userId,
                    type: 'profile',
                    attributes: {
                        firstname: accountFirstname,
                        lastname: accountLastname
                    }
                }]
            });

            let user = store.peekRecord("user" , userId);

            let profile = store.peekRecord("profile" , userId);
            profile.set('user' , user);

			session
			.authenticate('authenticator:oauth2', accountEmail, accountPassword)
			.catch((reason) => {
			  alert(reason.error ||reason);
			});
		  },
          400: function(){
		    alert('The form is invalid, please check and re-submit');
		  },
          500: function(){
		    alert('A Server Error Occured : HTTP_INTERNAL_SERVER_ERROR');
		  },
          502: function(){
		    alert('A Server Error Occured : HTTP_BAD_GATEWAY');
		  },
          503: function(){
		    alert('A Server Error Occured : HTTP_SERVICE_UNAVAILABLE');
		  },
          504: function(){
		    alert('A Server Error Occured : HTTP_GATEWAY_TIMEOUT');
		  }
        },
		complete:function(){
		  loading.replaceWith(submitButton);
		}
	  });
    }
  }

});
