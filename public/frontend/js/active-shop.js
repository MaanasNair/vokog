



// Background image holder with fullscreen option
$(window).on('load resize', function() {





    // Headroom
    if ($(window).width() > 0) {
        if ($("[data-toggle='headroom']").length > 0) {
            $("[data-toggle='headroom']").headroom({
                // vertical offset in px before element is first unpinned
                offset : 0,
                // or you can specify tolerance individually for up/down scroll
                tolerance : {
                    up : 40,
                    down : 5
                },
                // css classes to apply
                classes : {
                    // when element is initialised
                    initial : "headroom",
                    // when scrolling up
                    pinned : "headroom--pinned",
                    // when scrolling down
                    unpinned : "headroom--unpinned",
                    // when above offset
                    top : "headroom--top",
                    // when below offset
                    notTop : "fixed-top",
                    // when at bottom of scoll area
                    bottom : "headroom--bottom",
                    // when not at bottom of scroll area
                    //notBottom : "headroom--not-bottom"
                },
                onPin : function() {
                    if($(window).offset.top > 0) {
                        var height = $("[data-toggle='headroom']").height();
                        $('body').css({"padding-top": height+"px"});
                    }
                    else {
                        $('body').css({"padding-top": 0});
                    }
                },
                onUnpin : function() {
                    var height = $("[data-toggle='headroom']").height();
                    $('body').css({"padding-top": height+"px"});
                },
                onTop : function() {
                    $('body').css({"padding-top": 0});
                },
                onBottom : function() {

                },
            });
        }
    }
});

// On document ready functions
$(document).ready(function() {

    // Bootstrap - Submenu event for small resolutions
    $('.dropdown-menu .dropdown-submenu [data-toggle="dropdown"]').on('click', function(e) {

            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            var $subMenu = $(this).next(".dropdown-menu");
            $subMenu.toggleClass('show');
            $subMenu.parent().toggleClass('show');

            $(this).parents('.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                $('.dropdown-submenu .show').removeClass("show");
            });

            return false;

    });

    // Fix the closing problem when clicking inside dopdown menu
    $('.navbar .dropdown-menu').on('click', function(event) {
        event.stopPropagation();
    });

    // One page nav
    $('.navbar-onepage .nav-link').on('click', function(e) {
        var $anchor = $(this);

        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');

        e.preventDefault();
    });

    // Hamburger
    if ($('.hamburger-js')[0]) {
        $(".hamburger-js").each(function() {
            var $this = $(this);

            $this.on("click", function(e) {
                $this.toggleClass("is-active");
                // Do something else, like open/close menu
            });
        });

    }

    // Footer reveal
    if ($('[data-footer-reveal]').length) {
        $('[data-footer-reveal]').footerReveal({
            shadow: false,
            zIndex: -101
        });
    }

    // Input group - plus minus
    $('.btn-number').click(function(e) {
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());

        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });

    $('.input-number').focusin(function() {
        $(this).data('oldValue', $(this).val());
    });

    $('.input-number').change(function() {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }


    });
    $(".input-number").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    // Floating label
    $('.has-floating-label .form-control').on('focus blur', function(e) {
        $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    }).trigger('blur');

    // Bootstrap selected
    $('.selectpicker').each(function(index, element) {
        $('.selectpicker').select2({

        });
    });

    // Datepicker
    if ($('.datepicker')[0]) {
        $('.datepicker').each(function() {
            var $this = $(this);

            $this.flatpickr({
                noCalendar: $this.data('datepicker-no-calendar') ? $this.data('datepicker-no-calendar') : false,
                enableTime: $this.data('datepicker-enable-time') ? $this.data('datepicker-enable-time') : false,
                inline: $this.data('datepicker-inline') ? $this.data('datepicker-inline') : false,
                allowInput: $this.data('datepicker-allow-input') ? $this.data('datepicker-allow-input') : true,
                mode: $this.data('datepicker-mode') ? $this.data('datepicker-mode') : 'single',
                static: true,
                inline: $this.data('datepicker-inline') ? $this.data('datepicker-inline') : false,
                nextArrow: '<i class="ion-ios-arrow-right" />',
                prevArrow: '<i class="ion-ios-arrow-left" />'
            });
        })
    }

    // Custom file input
    $('.custom-input-file').each(function() {
        var $input = $(this),
            $label = $input.next('label'),
            labelVal = $label.html();

        $input.on('change', function(e) {
            var fileName = '';

            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            else if (e.target.value)
                fileName = e.target.value.split('\\').pop();

            if (fileName)
                $label.find('span').html(fileName);
            else
                $label.html(labelVal);
        });

        // Firefox bug fix
        $input
            .on('focus', function() {
                $input.addClass('has-focus');
            })
            .on('blur', function() {
                $input.removeClass('has-focus');
            });
    });
    // NoUI Slider
    if ($(".input-slider-container")[0]) {
        $('.input-slider-container').each(function() {

            var slider = $(this).find('.input-slider');
            var sliderId = slider.attr('id');
            var minValue = slider.data('range-value-min');
            var maxValue = slider.data('range-value-max');

            var sliderValue = $(this).find('.range-slider-value');
            var sliderValueId = sliderValue.attr('id');
            var startValue = sliderValue.data('range-value-low');

            var c = document.getElementById(sliderId),
                d = document.getElementById(sliderValueId);

            noUiSlider.create(c, {
                start: [parseInt(startValue)],
                //step: 1000,
                range: {
                    'min': [parseInt(minValue)],
                    'max': [parseInt(maxValue)]
                }
            });

            c.noUiSlider.on('update', function(a, b) {
                //alert(b)
                d.textContent = a[b];
            });
        })

    }

    if ($("#input-slider-range")[0]) {
        var c = document.getElementById("input-slider-range"),
            d = document.getElementById("input-slider-range-value-low"),
            e = document.getElementById("input-slider-range-value-high"),
            f = [d, e];

        noUiSlider.create(c, {
            start: [parseInt(d.getAttribute('data-range-value-low')), parseInt(e.getAttribute('data-range-value-high'))],
            connect: !0,
            range: {
                min: parseInt(c.getAttribute('data-range-value-min')),
                max: parseInt(c.getAttribute('data-range-value-max'))
            }
        }), c.noUiSlider.on("update", function(a, b) {
            f[b].textContent = a[b];
        }), c.noUiSlider.on("change", function(a, b) {
            rangefilter(a);
        })
    }

    // Flip cards
    if ($(".card-flip")[0]) {
        $('.card-flip-container').imagesLoaded(function() {
            $(".card-flip").each(function() {
                $this = $(this);
                $this.flip({
                    'front': '.card-front',
                    'back': '.card-back',
                    'forceHeight': true,
                    'trigger': $this.data('flip-trigger') ? $this.data('flip-trigger') : 'hover',
                    'reverse': $this.data('flip-reverse') ? $this.data('flip-reverse') : false,
                });
            });
        });
    }


    // Bootstrap Carousels
    $('.carousel').carousel({
        interval: 5000,
        pause: 'hover'
    });

    // Smooth scroll
    $('.scroll-me, [data-scroll-to]').on('click', function(event) {
        var hash = $(this).data('scroll-to');
        var offset = $(this).data('scroll-to-offset') ? $(this).data('scroll-to-offset') : 0;

        // Animate scroll to the selected section
        $('html, body').stop(true, true).animate({
            scrollTop: $(hash).offset().top - offset
        }, 600);

        event.preventDefault();
    });

    // To top
    var offset = 300,
        //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //duration of the top scrolling animation (in ms)
        scroll_top_duration = 700,
        //grab the "back to top" link
        $back_to_top = $('.back-to-top');

    //hide or show the "back to top" link
    $(window).scroll(function() {
        ($(this).scrollTop() > offset) ? $back_to_top.addClass('back-to-top-is-visible'): $back_to_top.removeClass('back-to-top-is-visible cd-fade-out');
        if ($(this).scrollTop() > offset_opacity) {
            $back_to_top.addClass('back-to-top-fade-out');
        }
    });

    //smooth scroll to top
    $back_to_top.on('click', function(event) {
        event.preventDefault();
        $('body, html').animate({
            scrollTop: 0,
        }, scroll_top_duration);
    });

    // Light gallery
    if ($('[data-toggle="light-gallery"]').length > 0) {
        $('[data-toggle="light-gallery"]').lightGallery({
            selector: 'this'
        });
    }

    if ($('.light-gallery').length > 0) {
        $('.light-gallery').each(function() {
            var $this = $(this);

            $this.lightGallery({
                selector: '.item',
                thumbnail: true
            });
        });
    }

    // Isotope
    // for each container
    $('.masonry-container').each(function(i, masonryContainer) {
        var $masonryContainer = $(masonryContainer);

        // init isotope for container
        var $masonry = $masonryContainer.find('.masonry').imagesLoaded(function() {

            // Set default filter if exists
            var filterMenuItems = $masonryContainer.find('.masonry-filter-menu');
            var defaultFilterButton = filterMenuItems.find('.default');
            var defaultFilterValue = defaultFilterButton.data('filter');

            if (defaultFilterValue != undefined && defaultFilterValue != '') {

                if (defaultFilterValue != '*') {
                    defaultFilterValue = '.' + defaultFilterValue;
                }

                defaultFilterButton.addClass('active');
            }


            $masonry.isotope({
                itemSelector: '.masonry-item',
                filter: defaultFilterValue
            })
        });
        // init filters for container
        $masonryContainer.find('.masonry-filter-menu').on('click', 'a', function() {
            var filterValue = $(this).attr('data-filter');

            if (filterValue == '*') {
                filterValue = '';
            } else {
                filterValue = '.' + filterValue;
            }

            $masonry.isotope({
                filter: filterValue
            });
        });
    });

    $('.masonry-filter-menu').each(function(i, buttonGroup) {
        var $buttonGroup = $(buttonGroup);
        $buttonGroup.on('click', 'a', function() {
            $buttonGroup.find('.active').removeClass('active');
            $(this).addClass('active');
        });
    });

    // Swiper
    var productSwiper;
    if ($(".product-swiper-container").length > 0) {
        $(".product-swiper-container").each(function(index, element) {
            $(this).addClass('s-' + index);
            $(this).find('.swiper-pagination').addClass('sp-' + index);

            productSwiper = $('.s-' + index).swiper({
                speed: 400,
                loop: true,
                grabCursor: true,
                pagination: '.sp-' + index,
                paginationClickable: true,
                centeredSlides: false,
                preloadImages: false,
                lazyLoading: true,
                observer: true,
                observerParents: true

            });
        });
    }

    if ($(".swiper-container-centered").length > 0) {
        $(".swiper-container-centered").each(function() {
            var swiper = new Swiper('.swiper-container-centered', {
                pagination: '.swiper-pagination',
                slidesPerView: 'auto',
                centeredSlides: true,
                paginationClickable: true,
                spaceBetween: 30,
                initialSlide: 1,
                breakpoints: {
                    // when window width is <= 320px
                    768: {
                        slidesPerView: 1,
                        spaceBetweenSlides: 0
                    },
                    // when window width is <= 480px
                    991: {
                        slidesPerView: 2,
                        spaceBetweenSlides: 0
                    }
                }
            });
        });
    }

    // Swiper with coverflow effect
    if ($(".swiper-container-coverflow").length > 0) {
        $(".swiper-container-coverflow").each(function() {
            var swiper = new Swiper($(this), {
                pagination: $(this).find('.swiper-pagination'),
                effect: 'coverflow',
                grabCursor: true,
                centeredSlides: true,
                initialSlide: $(this).data('swiper-initial-slide'),
                slidesPerView: $(this).data('swiper-items'),
                coverflow: {
                    rotate: 0,
                    stretch: 0,
                    depth: 300,
                    modifier: 1,
                    slideShadows: true
                },
                breakpoints: {
                    576: {
                        slidesPerView: 1,
                        spaceBetweenSlides: 0,
                        initialSlide: 0,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetweenSlides: 0
                    },
                    // when window width is <= 480px
                    992: {
                        slidesPerView: 3,
                        spaceBetweenSlides: 0,
                        initialSlide: 2,
                    }
                }
            });
        });
    }



    if ($('.countdown').length > 0) {
        $('.countdown').each(function() {
            var $this = $(this);
            var date = $this.data('countdown-date');

            $this.countdown(date).on('update.countdown', function(event) {
                var $this = $(this).html(event.strftime('' +
                    '<div class="countdown-item"><span class="countdown-digit">%-D</span><span class="countdown-label countdown-days">day%!d</span></div>' +
                    '<div class="countdown-item"><span class="countdown-digit">%H</span><span class="countdown-separator">:</span><span class="countdown-label">hr</span></div>' +
                    '<div class="countdown-item"><span class="countdown-digit">%M</span><span class="countdown-separator">:</span><span class="countdown-label">min</span></div>' +
                    '<div class="countdown-item"><span class="countdown-digit">%S</span><span class="countdown-label">sec</span></div>'
                ));
            });
        });
    }

    // Optional filters
    $("#btnToggleOptionalFilters").click(function() {
        var animateIn = $(this).data("animate-in");
        var animateOut = $(this).data("animate-out");

        if ($(this).hasClass("opened")) {
            $(".hidden-form-filters").addClass('hide');
            $(this).removeClass("opened");
        } else {
            $(this).addClass("opened");
            $(".hidden-form-filters").removeClass("hide");
        }
        return false;
    });

    // Rating Stars
    var star = $(".rating span.star");

    star.hover(
        function() {
            $(this).addClass("over");
            $(this).prevAll().addClass("over");
        },
        function() {
            $(this).removeClass("over");
            $(this).prevAll().removeClass("over");
        }
    );
    star.click(function() {
        $(this).parent().children(".star").removeClass("voted");
        $(this).prevAll().addClass("voted");
        $(this).addClass("voted");
    });

    // Tooltip & Popover
    $('[data-toggle="tooltip"]').tooltip({
        // placement: $(this).data('placement'),
        html: true
    });
    $('[data-toggle="popover"]').popover({
        placement: $(this).data('placement'),
        html: true
    });

    // Global search
    $('[data-toggle="global-search"]').click(function() {

        var target = $('.global-search');
        var delay = 0;

        if (!target.hasClass('in')) {

            if (!target.hasClass('global-search-fullscreen') && !target.hasClass('global-search-overlay')) {
                $('.navbar').addClass('global-search-active');

                delay = 200;
            } else if (target.hasClass('global-search-overlay')) {
                $('.navbar').addClass('hide');
            }

            setTimeout(function() {
                target.addClass('in');
            }, delay);

            setTimeout(function() {
                target.addClass('animated fadeIn');
                target.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                    target.removeClass("fadeIn");
                });
            }, delay * 2.5);
        } else {
            target.addClass('fadeOut');
            target.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {

                target.removeClass("animated fadeOut");
                target.removeClass('in');

                setTimeout(function() {
                    $('.navbar').removeClass('global-search-active hide');
                }, delay);
            });
        }
    });

    // Morphext - Text rotators
    if ($(".morphext").length > 0) {
        $(".morphext").Morphext({
            // The [in] animation type. Refer to Animate.css for a list of available animations.
            animation: 'fadeIn',
            // An array of phrases to rotate are created based on this separator. Change it if you wish to separate the phrases differently (e.g. So Simple | Very Doge | Much Wow | Such Cool).
            separator: ";",
            // The delay between the changing of each phrase in milliseconds.
            speed: '3000',
            complete: function() {
                //alert($(this).data('animation'))
            }
        });
    }

    // WOW animation
    if ($('.animate-on-scroll').length > 0) {
        wow = new WOW({
            boxClass: 'animate-on-scroll',
            animateClass: 'animated',
            offset: 100,
            mobile: false,
            live: true
        });
        wow.init();
    }

    // Collapse component settings
    $('.accordion--style-1 .collapse, .accordion--style-2 .collapse').on('show.bs.collapse', function() {

        $(this).parent().find(".fa-chevron-right").removeClass("fa-chevron-right").addClass("fa-chevron-down");
    }).on('hide.bs.collapse', function() {
        $(this).parent().find(".fa-chevron-down").removeClass("fa-chevron-down").addClass("fa-chevron-right");
    });

    //// SHOP functionalities
    // Plus - Minus control
    $('.spinner .btn:first-of-type').on('click', function() {
        $('.spinner input').val(parseInt($('.spinner input').val(), 10) + 1);
    });

    $('.spinner .btn:last-of-type').on('click', function() {
        $('.spinner input').val(parseInt($('.spinner input').val(), 10) - 1);
    });

    // Product actions
    $('.product').on('mouseenter', function() {
        if ($(this).find('.product-actions--a').length > 0 && !$(this).find('.product-actions--a').hasClass('in')) {
            var $this = $(this).find('.product-actions--a');
            var animationIn = $this.data('animation-in');

            $this.addClass('in animated ' + animationIn);
            $this.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $this.removeClass('animated ' + animationIn);
            });
        }
    });

    $('.product').on('mouseleave', function() {
        if ($(this).find('.product-actions--a').length > 0 && $(this).find('.product-actions--a').hasClass('in')) {
            var $this = $(this).find('.product-actions--a');
            var animationOut = $this.data('animation-out');

            $this.addClass('animated ' + animationOut);
            $this.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $this.removeClass('in animated ' + animationOut);
            });
        }
    });

    // Advanced search
    $('#btn_advanced_search_open').click(function() {
        if (!$('.advanced-search-hidden').hasClass("in")) {
            $('.advanced-search-hidden').addClass("in");

        } else {
            $('.advanced-search-hidden').removeClass("in");
        }
        return false;
    })

    // Instafeed with Spectagram
    if ($('.instafeed').length > 0) {
        $('.instafeed').each(function() {
            var $this = $(this);
            var target = $this.attr('id');
            var userId = $this.data('user-id');
            var limit = $this.data('limit');
            var col = $this.data('col');
            var template;
            var classes = $this.data('classes') ? $this.data('classes') : '';
            var lightbox = $this.data('lightbox') ? ' data-fancybox ' : '';

            // Fill with the data from Instagram API
            var clientID = 'c81e735d834e4960ab5bfdc89fff7b7a';
            var accessToken = '4168279954.c81e735.bd435dd21a344208ad569b028b372088';

            var instafeed = new Instafeed({
                target: target,
                clientId: clientID,
                accessToken: accessToken,
                get: 'user',
                userId: userId,
                limit: limit,
                resolution: 'thumbnail',
                template: '<div class="col-sm-' + col + ' col-6"><a href="{{link}}"'+lightbox+'><img src="{{image}}" class="img-fluid '+classes+'" /></a></div>'
            });
            instafeed.run();
        });
    }

    // Form validation

    if ($('[data-toggle="validation"]')[0]) {
        $('[data-toggle="validation"]').each(function() {
            var $this = $(this);
            var form = document.getElementById($this.attr('id'));

            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }

    // Contact form ajax send
    if ($('#form_contact').length > 0) {
        $('#form_contact').on('submit', function(e) {
            var $this = $(this);
            var buttonText =  $this.find('button[type="submit"]').text();

            if (e.isDefaultPrevented()) {
                // handle the invalid form...
            } else {
                var formData = $this.serialize();

                var subscribeRequest = $.ajax({
                    type: "POST",
                    url: $this.data('action'),
                    data: formData,
                    dataType: 'json'
                });

                // Changing button text
                $this.find('button[type="submit"]').text('Sending...');

                // Get success status and data
                subscribeRequest.done(function(data, msg) {

                    var status = data['status'];

                    var notifyTitle = data['notify_title'];
                    var notifyMessage = data['notify_message'];
                    var notifyType = data['notify_type'];

                    // Create notification
                    notify(notifyTitle, notifyMessage, notifyType);

                    if (status == 'success') {
                        // Clear form
                        $this.find('.btn-reset').trigger('click');
                        $this.find('.glyphicon-ok').removeClass('glyphicon-ok');
                        grecaptcha.reset();
                    }

                    $this.find('button[type="submit"]').text('Message sent!');

                    setTimeout(function() {
                        $this.find('button[type="submit"]').text(buttonText);
                    }, 3000);

                });

                subscribeRequest.fail(function(data, textStatus) {
                    var status = data['status'];

                    var notifyTitle = data['notify_title'];
                    var notifyMessage = data['responseText'];
                    var notifyType = 'danger';

                    // Create notification
                    notify(notifyTitle, notifyMessage, notifyType);

                    $this.find('button[type="submit"]').text('Error!');

                    setTimeout(function() {
                        $this.find('button[type="submit"]').text(buttonText);
                    }, 3000);
                });

                return false;
            }
        });
    }

    // Gradentify
    if ($('.gradientify').length) {
        $('.gradientify').each(function() {
            $this.gradientify({
                gradients: [{
                        start: [17, 132, 254],
                        stop: [154, 70, 248]
                    },
                    {
                        start: [154, 70, 248],
                        stop: [17, 132, 254]
                    }
                ],
                angle: '0deg',
                fps: 60,
                transition_time: 10
            });
        });
    }

    // Clipboard JS
    if ($('.btn-clipboard')[0]) {

        var clipboard = new Clipboard('.btn-clipboard');

        clipboard.on('success', function(e) {
            e.trigger.innerHTML = '<span class="text-sm">Copied</span>';

            e.clearSelection();

            setTimeout(function() {
                e.trigger.innerHTML = '<i class="fa fa-files-o"></i>';
            }, 3000);

        });

    }

}); // END document ready


$(document).ajaxComplete(function(){
    $('.custom-input-file').each(function() {
        var $input = $(this),
            $label = $input.next('label'),
            labelVal = $label.html();

        $input.on('change', function(e) {
            var fileName = '';

            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            else if (e.target.value)
                fileName = e.target.value.split('\\').pop();

            if (fileName)
                $label.find('span').html(fileName);
            else
                $label.html(labelVal);
        });

        // Firefox bug fix
        $input
            .on('focus', function() {
                $input.addClass('has-focus');
            })
            .on('blur', function() {
                $input.removeClass('has-focus');
            });
    });
});
