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
});

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

    self.init = function () {
        self.bindEvents();
    };

    self.bindEvents = function () {
        self.$tabs.on('click', function () {
            self.$element.find('.tab-content.active').removeClass('active');
            self.$element.find($(this).attr('href')).addClass('active');
            return false;
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
