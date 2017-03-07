import DS from 'ember-data';

export default DS.Model.extend({
  username: DS.attr('string'),
  enabled: DS.attr("boolean", {
    defaultValue() {
      return true;
    },
  }),
  lastlogin: DS.attr("date", {
    defaultValue() {
      return new Date();
    },
  })
});
