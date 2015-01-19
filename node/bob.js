pry = require('pryjs')
function Bob() {
  this.hey = function hey(message) {
    var response = null;
    if (message.replace(/\s+/, '').length === 0) {
      response = 'Fine. Be that way!';
    } else if (message.toUpperCase() === message) {
      // eval(pry.it) // play
      response = 'Whoa, chill out!';
    } else if (message.match(/\?$/)) {
      response = 'Sure.';
    }
    return response || 'Whatever.';
  };
}
module.exports = Bob;
