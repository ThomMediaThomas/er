$(document).ready(function () {
    $('.slider').each(function () {
        (new Slider($(this))).init();
    })
});

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
