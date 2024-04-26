// /**
//  * VeeValidate provides user-input validation functionality. Rules are very similar to Laravel's validation.
//  *
//  * When working with validation, aim to make rules congruent between Laravel migrations, FormRequest classes,
//  * and form inputs. Matching rules in all three areas helps provide the triple-layer protection against bad data input.
//  *
//  * @link https://logaretm.github.io/vee-validate/guide/basics.html
//  * @link https://laravel.com/docs/7.x/validation#available-validation-rules
//  */
// import { extend } from 'vee-validate';
// import {
//     alpha_dash,
//     between,
//     email,
//     image,
//     max,
//     max_value,
//     min,
//     numeric,
//     oneOf,
//     required,
// } from 'vee-validate/dist/rules';

// extend('alpha_dash', {
//     ...alpha_dash,
//     message: 'This field can only include alphanumeric, dashes, and underscores',
// });

// extend('between', {
//     ...between,
//     message: 'This field must be between {min} and {max}',
// });

// extend('email', {
//     ...email,
//     message: 'This field must be a valid email',
// });

// extend('image', {
//     ...image,
//     message: 'This field must be an image',
// });

// extend('max', {
//     ...max,
//     message: 'This field is too long',
// });

// extend('max_value', {
//     ...max_value,
//     message: 'This field is too large',
// });

// extend('min', {
//     ...min,
//     message: 'This field is too short',
// });

// extend('numeric', {
//     ...numeric,
//     message: 'This field must be a number',
// });

// extend('oneOf', {
//     ...oneOf,
//     message: 'This field has an invalid value',
// });

// extend('required', {
//     ...required,
//     message: 'This field is required',
// });
