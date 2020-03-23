/**
 * Vue filter to make a simple timestamp for an ISO date.
 * http://jsfiddle.net/bryan_k/44kqtpeg/
 *
 * @param {String} value The value string.
 */
Vue.filter('date', function(value) {
  var parts = value.split(' ');
  var date = parts[0];

  date = date.split('-');

  return date[1] + '/' + date[2] + '/' + date[0];
});
