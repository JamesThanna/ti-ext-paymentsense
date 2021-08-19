  +function ($) {
    "use strict"

    var ProcessPaymentSense = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.$checkoutForm = this.$el.closest('#checkout-form')
        $('[name=payment][value=paymentsense]', this.$checkoutForm).on('change', $.proxy(this.init, this))
    }

    ProcessPaymentSense.prototype.init = function () {

        var config = {
            paymentDetails: {
                amount: this.$el.find('[name="paymentsense_amount"]')[0].value,
                currencyCode: this.$el.find('[name="paymentsense_currency"]')[0].value,
                paymentToken: this.$el.find('[name="paymentsense_token"]')[0].value,
            },
            containerId: "paymentsense-payment",
            fontCss: ['https://fonts.googleapis.com/css?family=Amaranth|Titillium+Web:200,200i,400,400i,600,600i,700,700i|Droid+Sans+Mono'],
            styles: {
                base: {
                    default: {
                        color: "black",
                        textDecoration: "none",
                        fontFamily: '"Titillium Web", "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
                        boxSizing: "border-box",
                        padding: ".375rem .75rem",
                        boxShadow: 'none',
                        fontSize: '0.875rem',
                        borderRadius: '.25rem',
                        lineHeight: '1.5',
                        backgroundColor: '#fff',
                        borderColor: '#e0dcdb',

                    },
                    focus: {
                        color: '#495057',
                        borderColor: '#ffa480',
                        outline: 'none',
                        boxShadow: '0 0 0 0.2rem rgba(255, 73, 0, 0.25)',
                    },
                    error: {
                        color: "#B00",
                        borderColor: "#B00"
                    },
                    valid: {
                        color: "green",
                        borderColor: 'green'
                    },
                    label: {
                        display: 'none'
                    }
                },
                cv2: {
                    container: {
                        width: "50%",
                        float: "left",
                        boxSizing: "border-box"
                    },
                    default: {
                        borderRadius: "0 .25rem .25rem 0"
                    }
                },
                expiryDate: {
                    container: {
                        width: "50%",
                        float: "left",
                        borderRadius: '0rem',
                    },
                    default: {
                        borderRadius: "0",
                        borderRight: "none"
                    },
                },
                cardNumber: {
                    default: {
                        borderRadius: ".25rem 0 0 .25rem",
                    },
                }
            }
        }

        this.$connectE = new Connect.ConnectE(config, $.proxy(this.displayErrors, this));

        this.$checkoutForm.on('submitCheckoutForm', $.proxy(this.submitFormHandler, this))
    }

    ProcessPaymentSense.prototype.displayErrors = function (errors) {
        var errorsDiv = document.querySelector(this.options.errorSelector);
        errorsDiv.innerHTML = '';
        if (errors && errors.length) {
            var list = document.createElement("ul");
            errors.forEach(function(error) {
                var item = document.createElement("li");
                item.innerText = error.message;
                list.appendChild(item);
            });
            errorsDiv.appendChild(list);
        }
    }

    ProcessPaymentSense.prototype.submitFormHandler = function (event) {
        var self = this,
            $form = this.$checkoutForm,
            $paymentInput = $form.find('input[name="payment"]:checked')

        if ($paymentInput.val() !== 'paymentsense') return

        // Prevent the form from submitting with the default action
        event.preventDefault();

        var additionalInfo = { billingAddress: {} };
        this.$el.find('#paymentsense-address input').each((idx, inp) => {
            additionalInfo.billingAddress[inp.name] = inp.value;
        });

        this.$connectE
            .executePayment(additionalInfo)
            .then(function(data){
                console.log(data);
                $form.unbind('submitCheckoutForm').submit()
            }.bind(this))
            .catch(function(data){
                console.log(data);
                this.displayErrors(typeof(data) == 'object' ? data : [data]);
            }.bind(this));
    }

    ProcessPaymentSense.DEFAULTS = {
        errorSelector: '#paymentsense-card-errors',
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.processPaymentSense

    $.fn.processPaymentSense = function (option) {
        var $this = $(this).first()
        var options = $.extend(true, {}, ProcessPaymentSense.DEFAULTS, $this.data(), typeof option == 'object' && option)

        return new ProcessPaymentSense($this, options)
    }

    $.fn.processPaymentSense.Constructor = ProcessPaymentSense

    $.fn.processPaymentSense.noConflict = function () {
        $.fn.booking = old
        return this
    }

    $(document).render(function () {
        $('#paymentsensePaymentForm').processPaymentSense()
    })
}(window.jQuery)
