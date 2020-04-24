import '../css/app.scss';

const $ = require('jquery');
require('bootstrap');

const clipboard = require('clipboard');

new clipboard('.btn-copy');

$('#copy-url').click(function () {
    $(this).text('Copied!');
});