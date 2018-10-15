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

    if ($('#accommodation-finder').length > 0) {
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
    }

    $('#accommodation-booker').each(function () {
        (new AccommodationBooker($(this))).init();
    });
});

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
        self.$detailsForm.find('input').on('change', function () {
            self.$boxPriceDetail.addClass('loading');

            $.get(self.$detailsForm.attr('action') + '?' + self.$detailsForm.serialize(), function (response) {
                self.$boxPriceDetail.html($(response).find('#box-price-detail').html());
                self.$boxPriceDetail.removeClass('loading');
                self.setBookingDetails();
            });
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

    self.init = function () {
        self.$slidesHolder.css('width', (100*self.count) + '%');
        self.$slides.css('width', (100/self.count) + '%');
        self.bindEvents();
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
        return false;
    };

    self.previous = function () {
        if (self.currentSlide == 0) {
            return false;
        }

        self.currentSlide--;
        self.$slidesHolder.css('left', (-100 * self.currentSlide) + '%');
        return false;
    }
}
