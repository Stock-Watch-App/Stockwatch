/**
 * Vue filter to make a simple timestamp for an ISO date.
 * http://jsfiddle.net/bryan_k/44kqtpeg/
 *
 * @param {String} value The value string.
 */
Vue.filter('date', function (value) {
    let date = new Date(value);

    //getMonth is zero base. Jan = 0, Feb = 1, Mar = 3, etc
    return date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
});
