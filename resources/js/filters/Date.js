Vue.filter('date', {
    read: function (val) {
      return formatDate(parseDate(val));
    },
    write: function (val, oldVal) {
      var d = parseDate(val);
      return d ? formatDate(d) : val
    }
  });


  new Vue({
    el: document.body,
    data: { mydate: new Date() },
  })

  // super simple pt-BR date parser
  function parseDate(str) {
    if(str === null || isDate(str)) return str || null;
    var p = str.match(/^(\d{1,2})\/?(\d{1,2})?\/?(\d{2,4})?$/);
    if(!p) return null;
    return new Date(parseInt(p[3] || new Date().getFullYear()), parseInt(p[2] || (new Date().getMonth() + 1)) - 1, parseInt(p[1]), 0, 0, 0, 0);
  }

  // super simple pt-BR date format
  function formatDate(dt) {
    if(dt == null) return '';
    var f = function(d) { return d < 10 ? '0' + d : d; };
    return f(dt.getDate()) + '/' + f(dt.getMonth() + 1) + '/' + dt.getFullYear();
  }

  // is object a date?
  function isDate(d) {
      return Object.prototype.toString.call(d) === '[object Date]';
  }
