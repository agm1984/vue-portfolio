const extend = (input) => {
    console.log('input', input);
};
const loadInputValidationMessages = (extend) => {
    extend('alpha_dash', {
        ...alpha_dash,
        message: 'The {_field_} field can only include alphanumeric, dashes, and underscores',
    });

    extend('between', {
        ...between,
        message: 'The {_field_} field must be between {min} and {max}',
    });

    extend('email', {
        ...email,
        message: 'The {_field_} field must be a valid email',
    });

    extend('image', {
        ...image,
        message: 'The {_field_} field must be an image',
    });

    extend('max', {
        ...max,
        message: 'The {_field_} field is too long',
    });

    extend('max_value', {
        ...max_value,
        message: 'The {_field_} field is too large',
    });

    extend('min', {
        ...min,
        message: 'The {_field_} field is too short',
    });

    extend('numeric', {
        ...numeric,
        message: 'The {_field_} field must be a number',
    });

    extend('oneOf', {
        ...oneOf,
        message: 'The {_field_} field has an invalid value',
    });

    extend('required', {
        ...required,
        message: 'The {_field_} field is required',
    });
};

export default loadInputValidationMessages;
