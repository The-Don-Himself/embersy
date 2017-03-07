import DS from 'ember-data';

export default DS.Model.extend({
  user: DS.belongsTo('user', { 
    async: false 
  }),
  joined: DS.attr('date'),
  firstname: DS.attr('string'),
  lastname: DS.attr('string'),
  avatarversion: DS.attr("number", {
    defaultValue() {
      return 1;
    },
  }),
  status: DS.attr("number", {
    defaultValue() {
      return 0;
    },
  })
});