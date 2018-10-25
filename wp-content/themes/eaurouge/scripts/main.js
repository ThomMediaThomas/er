$(document).ready(function () {
    $('.slider').each(function () {
        (new Slider($(this))).init();
    });

    $('#quick-booking').each(function () {
        (new QuickBooking($(this))).init();
    });

    $('.number-input').each(function () {
        (new NumberInput($(this))).init();
    });

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        language: 'nl-NL',
        autoHide: true
    });

    if ($('.submit-parent-form').length > 0) {
        $('.submit-parent-form').on('click', function () {
            $(this).parents('form').submit();
        })
    }

    $('#accommodation-finder').each(function () {
        (new AccommodationFinder($(this))).init();
    });

    $('#accommodation-booker').each(function () {
        (new AccommodationBooker($(this))).init();
    });

    if ($('.show-nav').length > 0) {
        $('.show-nav').on('click', function () {
            $('#nav').toggleClass('open');
            return false;
        })
    }
});

function AccommodationFinder($element) {
    var self = this;
    self.$element = $element;
    self.$form = self.$element.find('#accommodation-finder-filters');
    self.$results = self.$element.find('#accommodation-finder-results');

    self.init = function () {
        self.bindEvents();
    };

    self.bindEvents = function () {
        self.$form.find('input, select').on('change', debounce(self.filterResults, 500));

        $('#stay_type').on('change', function () {
            if ($(this).val() == 'chalet') {
                $('#stay_type_chalet').show();
                $('#stay_type_camping').hide();
            } else if ($(this).val() == 'camping') {
                $('#stay_type_camping').show();
                $('#stay_type_chalet').hide();
            }
        }).trigger('change');

        $('a.set-image').on('click', function () {
            var $left = $(this).parents('.left');
            $left.find('a.set-image.active').removeClass('active');
            $left.find('img.image-larger').attr('src', $(this).attr('href'));
            $(this).addClass('active');
            return false;
        });
    };

    self.filterResults = function () {
        self.$results.addClass('loading');

        var serialized = self.$form.serialize();
        history.pushState(null, '', self.$form.attr('action') + '?' + serialized);

        $.get(self.$form.attr('action') + '?' + serialized, function (response) {
            self.$results.html($(response).find('#accommodation-finder-results').html());
            self.$results.removeClass('loading');
        });
    }
}

function AccommodationBooker($element) {
    var self = this;
    self.$element = $element;
    self.$detailsForm = $element.find('#booking-details-form');
    self.$boxPriceDetail = $element.find('#box-price-detail');

    self.init = function () {
        self.bindEvents();
        self.setBookingDetails();
    };

    self.bindEvents = function () {
        self.$detailsForm.find('input').on('change', debounce(self.calculatePrice, 500));
        $('.frm-show-form').on('submit', function (event) {
            if (!self.validateBookingDetails()) {
                document.getElementById("booking-details-form").scrollIntoView();
                event.preventDefault();
                return false;
            }
        });
    };

    self.validateBookingDetails = function () {
        return validateForm(self.$detailsForm);
    };

    self.calculatePrice = function () {
        self.$boxPriceDetail.addClass('loading');
        var serialized = self.$detailsForm.serialize();
        history.pushState(null, '', self.$detailsForm.attr('action') + '?' + serialized);

        $.get(self.$detailsForm.attr('action') + '?' + serialized, function (response) {
            self.$boxPriceDetail.html($(response).find('#box-price-detail').html());
            self.$boxPriceDetail.removeClass('loading');
            self.setBookingDetails();
        });
    };

    self.setBookingDetails = function () {
        $('#field_accommodation_id').val($('#accommodation_id').val());
        $('#field_date_from').val($('#date_from').val());
        $('#field_date_to').val($('#date_to').val());
        $('#field_adults').val($('#adults').val());
        $('#field_children').val($('#children').val());
        $('#field_pets').val($('#pets').val());
        $('#field_calculated_price').val($('#total-price').text());

        //extras
        var $checkedExtras = $('input[name="extras[]"]:checked'),
            extrasValue = [];

        $checkedExtras.each(function () {
            extrasValue.push($(this).val());
        });

        $('#field_extras').val(extrasValue.join(','));
    }
}

function NumberInput($element) {
    var self = this;
    self.$element = $element;
    self.$input = self.$element.find('input');
    self.$up = self.$element.find('.up');
    self.$down = self.$element.find('.down');

    self.init = function () {
        self.bindEvents();
    };

    self.bindEvents = function () {
        self.$up.on('click', function () {
            self.setValue(self.getValue() + 1);
        });

        self.$down.on('click', function () {
            if (self.getValue() >= 1) {
                self.setValue(self.getValue() - 1);
            }
        });
    };

    self.getValue = function () {
        return parseInt(self.$input.val() ? self.$input.val() : 0);
    };

    self.setValue = function (value) {
        self.$input.val(value).trigger('change');
    };
}

function QuickBooking($element) {
    var self = this;
    self.$element = $element;
    self.$tabs = this.$element.find('.tab');
    self.$submit = self.$element.find('.submit-quick-booking-form');

    self.init = function () {
        self.bindEvents();
    };

    self.bindEvents = function () {
        self.$tabs.on('click', function () {
            self.$element.find('.tab-content.active').removeClass('active');
            self.$element.find($(this).attr('href')).addClass('active');
            return false;
        });

        self.$submit.on('click', function (event) {
            event.preventDefault();
            var $form = $(this).parents('form.quick-booking-form');
            if ($form.find('#stay_date_from').val() && $form.find('#stay_date_to').val()) {
                $form.submit();
            }
        });
    };

}

function Slider($element) {
    var self = this;
    self.$element = $element;
    self.$slidesHolder = self.$element.find('.slides');
    self.$slides = self.$element.find('.slide');
    self.$previous = self.$element.find('.slide-nav.previous');
    self.$next = self.$element.find('.slide-nav.next');
    self.count = self.$slides.length;
    self.currentSlide = 0;

    self.autoRotate = self.$element.attr('data-auto');
    self.rotateInterval = null;
    self.autoRotateTiming = 7500;

    self.init = function () {
        self.$slidesHolder.css('width', (100 * self.count) + '%');
        self.$slides.css('width', (100 / self.count) + '%');

        if (self.count > 1) {
            self.bindEvents();
        } else {
            self.$previous.hide();
            self.$next.hide();
        }

        self.setAutoRotate();
    };

    self.setAutoRotate = function () {
        if (self.rotateInterval) {
            clearInterval(self.rotateInterval);
        }

        if (self.autoRotate) {
            self.rotateInterval = setInterval(function () {
                self.next();
            }, self.autoRotateTiming);
        }
    };

    self.bindEvents = function () {
        self.$next.on('click', self.next);
        self.$previous.on('click', self.previous);
    };

    self.next = function () {
        if (self.currentSlide == self.count-1) {
            return false;
        }

        self.currentSlide++;
        self.$slidesHolder.css('left', (-100 * self.currentSlide) + '%');

        self.setAutoRotate();

        return false;
    };

    self.previous = function () {
        if (self.currentSlide == 0) {
            return false;
        }

        self.currentSlide--;
        self.$slidesHolder.css('left', (-100 * self.currentSlide) + '%');

        self.setAutoRotate();

        return false;
    }
}

function validateForm($form) {
    $form.find('.invalid').removeClass('invalid');
    $form.find('.frm-error').remove();
    var errors = 0;

    $form.find('.required').each(function () {
        if ($(this).val() == '')  {
            errors++;
            $(this).addClass('invalid');
            $(this).after('<div class="frm-error">Dit veld is verplicht.</div>');
        }
    });

    return errors == 0;
}
