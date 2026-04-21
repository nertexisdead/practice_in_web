import './bootstrap';

import jQuery from 'jquery';
window.$ = jQuery;

import 'admin-lte';

import select2 from 'select2';
select2();

import Mustache from 'mustache';
window.Mustache = Mustache;

window.defaultErrorHandler = function ($context, requestData) {
    const data = requestData.response.data;
    const errors = data.errors;
    if (errors) {
        for (let field in errors) {
            $context.find('span.error.' + field).text(errors[field]);
            $context.find('span.error[data-name="' + field + '"]').text(errors[field]);
            $context.find('[name="' + field + '"]').addClass('is-invalid');
        }
    }
    $context.find('button[type=submit]').removeAttr('disabled');
    data.message = ((typeof data.message !== 'undefined')
            ? data.message
            : 'Проверьте правильность заполнения формы'
    );
    toastr.error(data.message);
};

window.defaultSuccessHandler = function (response) {
    if (typeof response.data.message !== 'undefined') {
        toastr.success(response.data.message);
    }
    if (typeof response.data.redirect !== 'undefined') {
        window.location.href = response.data.redirect;
    }
};

window.defaultFormPostHandler = function (form, e) {
    let $context = $(form);
    $context
        .find('input,select,textarea')
        .removeClass('is-invalid')
    ;
    $context.find('span.error').html('');
    e.preventDefault();

    const formData = new FormData(form);
    axios
        .post(
            $context.attr('data-action'),
            formData
        )
        .then(window.defaultSuccessHandler)
        .catch((responseData) => window.defaultErrorHandler($context, responseData))
    ;
};
