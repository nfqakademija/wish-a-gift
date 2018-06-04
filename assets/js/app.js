//add bootstrap
require('bootstrap');
// workaround for (possible) webpack bug to prevent error from UglifyJs 'Unexpected token: name (self) [js/app.2b7036a4c723ac53590a.js:12552,12]'
// require('amazon-autocomplete/src/amazon-autocomplete');
require('amazon-autocomplete/dist/amazon-autocomplete.min');

//enable Jquery
const $ = require('jquery');
global.$ = global.jQuery = $;
