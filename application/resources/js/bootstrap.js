import './bootstrap';

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import toastr from 'toastr/toastr';
window.toastr = toastr;

import * as bootstrap from 'bootstrap'
window.bootstrap = bootstrap;

import $ from 'jquery';
window.$ = $;
