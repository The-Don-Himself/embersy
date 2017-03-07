import DS from 'ember-data';

export default DS.Model.extend({
  user: DS.attr(),
  joined: DS.attr('date', {
    defaultValue() {
      return new Date();
    }
  }),
  firstname: DS.attr('string'),
  lastname: DS.attr('string'),
  avatarversion: DS.attr('number', {
    defaultValue() {
      return 1;
    }
  }),
  status: DS.attr('number', {
    defaultValue() {
      return 0;
    }
  })
});