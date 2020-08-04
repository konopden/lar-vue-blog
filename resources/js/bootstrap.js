window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.$ = window.jQuery = require('jquery');
window.Vue = require('vue');
require('./vendor/jquery.stellar.min.js');
require('./vendor/jquery.waypoints.min.js');
require('bootstrap');
window.AOS = require('aos');
require('jquery-migrate');
require('jquery.animate-number');
require('jquery.easing');
require('magnific-popup');
require('owl.carousel');
require('popper.js');
window.toastr = require('toastr');
require('scrollax');
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
