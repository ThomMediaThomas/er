var MOBILE_BREAKPOINT = 730;

$(document).ready(function () {
    $('.slider').each(function () {
        (new Slider($(this))).init();
    });

    $('.same-height-parent').each(function () {
        (new SameHeight($(this))).init();
    });

    $('#quick-booking').each(function () {
        (new QuickBooking($(this))).init();
    });

    $('.number-input').each(function () {
        (new NumberInput($(this))).init();
    });


    $('.stick-in-parent').each(function () {
        (new StickyInParent($(this))).init();
    });

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        language: 'nl-NL',
        autoHide: true,
        startDate: new Date()
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

    if ($('.from-related-to').length > 0) {
        $('.from-related-to').on('change', function () {
            $(this).datepicker('close');
            
            var from = $(this).val(),
                to = $('.to-related-from').val(),
                from_date = new Date(from.split('-').reverse().join('-')),
                to_date = new Date(to.split('-').reverse().join('-'));

            var newTo = from_date;
            newTo.setDate(newTo.getDate() + 1);

            if (from && to && to_date > from_date) {
                newTo = to_date;
            }


            if(!isNaN(newTo.getTime())) {
                $('.to-related-from').val(newTo.format('dd-mm-yyyy')).trigger('change').datepicker('update');
            }
        });
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

        self.$form.on('submit', function () {
            self.filterResults();
            return false;
        });

        $('#stay_type').on('change', function () {
            if ($(this).val() == 'chalet') {
                $('#stay_type_chalet').show();
                $('#stay_type_camping').hide();
            } else if ($(this).val() == 'camping') {
                $('#stay_type_camping').show();
                $('#stay_type_chalet').hide();
            } else {
                $('#stay_type_camping').hide();
                $('#stay_type_chalet').hide();

            }
        }).trigger('change');

        $('body').on('click', 'a.set-image', function () {
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
    self.$periodInfo = $element.find("#period-info");
    self.$selectedExtras = $element.find("#selected-extras");
    self.$formidableForm = $element.find("#formidable-form");

    self.init = function () {
        self.bindEvents();
        self.setBookingDetails();
        self.initFamilyMembers();
    };

    self.bindEvents = function () {
        self.$detailsForm.on('change', 'input', debounce(self.reloadSmallParts, 500));
        self.$detailsForm.on('change', 'input', debounce(self.setBookingDetails, 500));
        self.$detailsForm.on('change', 'input', debounce(self.checkIfFormIsValid, 500));
    };

    self.checkIfFormIsValid = function () {
        var formIsValid = self.validateBookingDetails();

        if(formIsValid) {
            $("#form_booking_form").find('button[type="submit"]').removeAttr('disabled');
        } else {
            self.disableSubmitButton();
        }
    };

    self.disableSubmitButton = function () {
        $("#form_booking_form").find('button[type="submit"]').attr('disabled', 'true');
    };

    self.validateBookingDetails = function () {
        return validateForm(self.$detailsForm);
    };

    self.reloadSmallParts = function (event) {
        if(!($(event.currentTarget).hasClass('prevent-reload-small-parts'))) {
            //add loading states
            self.$element.find('.can-reload').addClass('loading');

            var serialized = self.$detailsForm.serialize();
            history.pushState(null, '', self.$detailsForm.attr('action') + '?' + serialized);

            $.get(self.$detailsForm.attr('action') + '?' + serialized, function (response) {
                //update HTML
                self.$boxPriceDetail.html($(response).find('#box-price-detail').html());
                self.$periodInfo.html($(response).find('#period-info').html());
                self.$selectedExtras.html($(response).find('#selected-extras').html());
                self.$formidableForm.html($(response).find('#formidable-form').html());

                //remove loading states
                self.$element.find('.can-reload').removeClass('loading');

                //reload hidden data
                self.setBookingDetails();
                
                $('input[id*="field_calculated_price"]').val($('#total-price').text());
                self.checkIfFormIsValid();
            });
        }
    };

    self.setBookingDetails = function () {
        $('input[id*="field_accommodation_id"]').val($('#accommodation_id').val());
        $('input[id*="field_date_from"]').val($('#date_from').val());
        $('input[id*="field_date_to"]').val($('#date_to').val());
        $('input[id*="field_adults"]').val($('#adults').val());
        $('input[id*="field_children"]').val($('#children').val());
        $('input[id*="field_babies"]').val($('#babies').val());
        $('input[id*="field_pets"]').val($('#pets').val());
        $('input[id*="field_calculated_price"]').val($('#total-price').text());

        //extras
        var $checkedExtras = $('input[name="extras[]"]:checked'),
            extrasValue = [];

        $checkedExtras.each(function () {
            extrasValue.push($(this).val());
        });

        $('input[id*="field_extras"]').val(extrasValue.join(','));

        //members
        if(self.$familyHolder.length) {
            var $familyMemberNames = $('input.family-member-name'),
                familyMemberNamesValue = [];

            $familyMemberNames.each(function() {
                familyMemberNamesValue.push($(this).val() ? $(this).val() : ' / ');
            });

            $('input[id*="field_family_members"]').val(familyMemberNamesValue.join(','));
        }
    };

    //family member form
    self.familyCount = 1;
    self.$familyHolder = self.$detailsForm.find("#family-holder");
    self.familyMemberTemplate;
    self.familyMembersHtml = [];

    self.initFamilyMembers = function () {
        self.familyCount = 1;
        self.$familyHolder = self.$detailsForm.find("#family-holder");
        self.familyMemberTemplate;
        self.familyMembersHtml = [];

        if(self.$familyHolder.length) {
            self.setFamilyCount();
            self.$detailsForm.find('input.change-family-members').on('change', debounce(self.updateFamilyMembers, 500));

            self.familyMemberTemplate = self.$detailsForm.find('#family-member-template').html();
            self.$detailsForm.find('#family-member-template').remove();

            self.updateFamilyMembers();
        }
        
        self.checkIfFormIsValid();
    };

    self.updateFamilyMembers = function () {
        self.setFamilyCount();
        var currentRenderedMembers = self.$familyHolder.find('div.family-member').length;
        var membersToAdd = self.familyCount;
        // minus self
        membersToAdd = membersToAdd -1;
        // minus existing
        membersToAdd = membersToAdd - currentRenderedMembers;

        if (membersToAdd >= 0) {
            for (var i = 0; i < membersToAdd; i++){
                var htmlToAppend = self.familyMemberTemplate;
                var memberCounter = currentRenderedMembers + i + 1;
                htmlToAppend = htmlToAppend.split('MEMBER_COUNT').join(memberCounter);
                self.$familyHolder.append(htmlToAppend);
            }
        }else{
            var membersToRemove = Math.abs(membersToAdd);
            for (var j = 0; j < membersToRemove; j++){
                self.$familyHolder.find('div.family-member')[currentRenderedMembers - 1 - j].remove();
            }                
        }
    };

    self.setFamilyCount = function () {
        var adults = $('#adults').val() ? parseInt($('#adults').val()) : 0;
        var children = $('#children').val() ? parseInt($('#children').val()) : 0;
        var babies = $('#babies').val() ? parseInt($('#babies').val()) : 0;
        self.familyCount = adults + children + babies;
    };
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

    self.autoRotate = self.$element.attr('data-auto');
    self.rotateInterval = null;
    self.autoRotateTiming = 75000;
    self.autoRotateDirection = 'next';

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
        if (self.currentSlide == 0) {
            self.autoRotateDirection = 'next';
        }

        if (self.currentSlide == self.count-1) {
            self.autoRotateDirection = 'prev';
        }

        if (self.rotateInterval) {
            clearInterval(self.rotateInterval);
        }

        if (self.autoRotate) {
            self.rotateInterval = setInterval(function () {
                if (self.autoRotateDirection == 'next') {
                    self.next();
                } else {
                    self.previous();
                }
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


function SameHeight($element) {
    var self = this;
    self.$parent = $element;
    self.$elements = self.$parent.find('.same-height');

    self.init = function () {
        self.setHeight();
        self.bindEvents();
    };

    self.bindEvents = function () {
        $(window).on('resize', debounce(self.setHeight, 500));
    };

    self.setHeight = function () {
        self.$elements.css('height', 'auto');
        setTimeout(self.setHeightAgain, 50);

    };

    self.setHeightAgain = function () {
        if ($(window).width() > MOBILE_BREAKPOINT) {
            self.$elements.css('height', self.$parent.innerHeight());
        }
    };
}

function StickyInParent($element) {
    var self = this;
    self.$element = $element;
    self.elementWidth = $element.width();
    self.$parent = self.$element.parents('.stick-in-parent-parent');
    self.parentPositionTop = self.$parent.offset().top;
    self.offset = 62;

    self.init = function () {
        if ($(window).width() > MOBILE_BREAKPOINT) {
            self.bindEvents();
            $(window).trigger('scroll');
        }
    };

    self.bindEvents = function () {
        $(window).scroll(function (e) { 
            var currentScroll = $(window).scrollTop();

            if (currentScroll >= self.parentPositionTop - self.offset) {
                var newPosition = currentScroll - self.parentPositionTop + self.offset;

                self.$parent.css({
                    'position': 'relative',
                    'width': 'auto'
                });

                if (newPosition + self.$element.height() < self.$parent.height()) {
                    self.$element.css({
                        'position': 'absolute',
                        'top': newPosition,
                        'bottom': 'initial',
                        'width': self.elementWidth
                    });
                } else {
                    self.$element.css({
                        'position': 'absolute',
                        'top': 'initial',
                        'bottom': 0,
                        'width': self.elementWidth
                    });

                }
            } else {
                self.$element.css({
                    'position': 'relative',
                    'top': 'initial'
                });                
            }

        });
    };
}


