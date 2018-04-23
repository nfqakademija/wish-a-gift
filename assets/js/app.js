//add bootstrap
require('bootstrap');

//move images to public/images folder and add them to the manifest.json file
const imagesContext = require.context('../images', false, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

//enable Jquery
const $ = require('jquery');
global.$ = global.jQuery = $;
