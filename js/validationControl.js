$(document).ready(function() {
    $('#connectForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Это поле не может быть пустым'
                    },
                    emailAddress: {
                        message: 'E-mail введен неверно'
                    }
                }
            },
            password: {
                validators: {
                    identical: {
                        field: 'confirmPassword',
                        message: 'Значение пароля и его подтверждения не совпадают'
                    },
                    notEmpty: {
                        message: 'Это поле не может быть пустым'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    identical: {
                        field: 'password',
                        message: 'Значение пароля и его подтверждения не совпадают'
                    },
                    notEmpty: {
                        message: 'Это поле не может быть пустым'
                    }
                }
            }
        }
    });
    $('#loginForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            identity: {
                validators: {
                    notEmpty: {
                        message: 'Это поле не может быть пустым'
                    },
                    emailAddress: {
                        message: 'E-mail введен неверно'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Это поле не может быть пустым'
                    }
                }
            }
        }
    });
});


