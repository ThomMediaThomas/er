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

    if ($('#accommodation-booker').length > 0) {
        setBookingDetails();
    }
});

function setBookingDetails() {
    var $field = $('textarea.booking_details');
    if ($field.length <= 0) {
        setTimeout(setBookingDetails, 500);
        return;
    }

    var value = '';
    value += 'Accommodatie: ' + $('#accommodation_id').val() + ' / ';
    value += 'Van: ' + $('#date_from').val() + ' / ';
    value += 'Tot: ' + $('#date_to').val() + ' / ';
    value += 'Volwassenen: ' + $('#adults').val() + ' / ';
    value += 'Kinderen: ' + $('#children').val() + ' / ';
    value += 'Honden: ' + $('#pets').val() + ' / ';
    value += 'Uitgerekende prijs: ' + $('#total-price').text();
    $field.val(value);
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
        self.$input.val(value);
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
            $(this).parents('form.quick-booking-form').submit();
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
