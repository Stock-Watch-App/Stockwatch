/**
 * Vue filter to make a simple timestamp for an ISO date.
 * http://jsfiddle.net/bryan_k/44kqtpeg/
 *
 * @param {String} value The value string.
 */
Vue.filter('date', function (value) {
    let date = new Date(value);


    return date.getMonth() + '/' + date.getDate() + '/' + date.getFullYear();
});
