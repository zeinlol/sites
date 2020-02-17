$(document).ready(function () {

/////////////////////////////// Click more page /////////////////////////////////////////
    $('#ClickNext2Page').on('click', function () {
        var Go2NextPage = $('.next').find('a').attr('href');
        if (Go2NextPage !== undefined) {
            location.href = Go2NextPage;
        }
    });
//////////////////////////////////////////////////////////////////////////////////////////


    //Slider add class to first li
    $('.main-slider li:nth-of-type(1)').addClass('slide-active');


    //Latest from categories previews
    if ($(window).width() > 767) {
        $('.tab-pane:first-of-type .latest-from-category-right ul li:first-of-type h3').siblings('a').children('img').clone().appendTo('.latest-from-category-left-inner');
        $('.latest-from-category-right ul li:first-of-type h3 a').addClass('current-heading');
        $('.latest-from-category-right ul li h3 a').mouseenter(function (event) {
            if ($(this).hasClass('current-heading')) {

            } else {
                $('.latest-from-category-right ul li h3 a').removeClass('current-heading');
                $('.latest-from-category-left-inner img').addClass('deletethis');
                $(this).parent('h3').siblings('a').children('img').clone().appendTo('.latest-from-category-left-inner');
            }
            ;
        });

        setInterval(function () {
            $('.latest-from-category-left-inner img.deletethis').remove();
        }, 10000);

        $('.latest-from-category-right ul li:nth-of-type(1) h3 a').mouseenter(function (event) {
            $('.latest-category-arrow').css('top', '15%');
        });

        $('.latest-from-category-right ul li:nth-of-type(2) h3 a').mouseenter(function (event) {
            $('.latest-category-arrow').css('top', '49%');
        });

        $('.latest-from-category-right ul li:nth-of-type(3) h3 a').mouseenter(function (event) {
            $('.latest-category-arrow').css('top', '82%');
        });

        $('.latest-from-category-right ul li h3 a').mouseleave(function (event) {
            $(this).addClass('current-heading');
        });

        $('.latest-from-category-tabs .nav-tabs li a').click(function (event) {
            $('.latest-from-category-left-inner img').remove();
            $('.latest-category-arrow').css('top', '15%');
            var tabId = $(this).attr('href');
            $(tabId + ' .latest-from-category-right ul li:first-of-type h3 a').parent('h3').siblings('a').children('img').clone().appendTo('.latest-from-category-left-inner');
            //$('.latest-from-category-right ul li:first-of-type h3').siblings('img').clone().appendTo('.latest-from-category-left-inner');
        });

        //Latest news hover heading
        $('.latest-news-preview-img-block-inner').hover(function () {
            $(this).parent('.latest-news-preview-img-block-outer').siblings('h3').find('.news-underline').css('width', '30%');
        }, function () {
            $('.news-underline').css('width', '0');
        });

        $('.latest-news-item-heading').hover(function () {
            $(this).parent('h3').siblings('.latest-news-preview-img-block-outer').find('.latest-news-preview-img-overlay').addClass('overlay-hovered');
            $(this).parent('h3').siblings('.latest-news-preview-img-block-outer').find('img').addClass('latest-news-preview-img-hovered');
            $(this).parent('h3').siblings('.latest-news-preview-img-block-outer').find('span').addClass('span-hovered');
            $(this).parent('h3').siblings('.latest-news-preview-img-block-outer').find('.read-article-divider').addClass('read-article-divider-hovered');
        }, function () {
            $(this).parent('h3').siblings('.latest-news-preview-img-block-outer').find('.latest-news-preview-img-overlay').removeClass('overlay-hovered');
            $(this).parent('h3').siblings('.latest-news-preview-img-block-outer').find('img').removeClass('latest-news-preview-img-hovered');
            $(this).parent('h3').siblings('.latest-news-preview-img-block-outer').find('span').removeClass('span-hovered');
            $(this).parent('h3').siblings('.latest-news-preview-img-block-outer').find('.read-article-divider').removeClass('read-article-divider-hovered');
        });

        //Most viewed posts hover heading
        $('.most-viewed-post-left a').hover(function () {
            $(this).parent('.most-viewed-post-left').siblings('.most-viewed-post-right').find('.most-viewed-underline').css('width', '30%');
        }, function () {
            $('.most-viewed-underline').css('width', '0');
        });

        $('.most-viewed-post-right h3 a').hover(function () {
            $(this).parent('h3').parent('.most-viewed-post-right').siblings('.most-viewed-post-left').find('.latest-news-preview-img-overlay').addClass('overlay-hovered');
            $(this).parent('h3').parent('.most-viewed-post-right').siblings('.most-viewed-post-left').find('img').addClass('latest-news-preview-img-hovered');
            $(this).parent('h3').parent('.most-viewed-post-right').siblings('.most-viewed-post-left').find('span').addClass('span-hovered');
            $(this).parent('h3').parent('.most-viewed-post-right').siblings('.most-viewed-post-left').find('.read-article-divider').addClass('read-article-divider-hovered');
        }, function () {
            $(this).parent('h3').parent('.most-viewed-post-right').siblings('.most-viewed-post-left').find('.latest-news-preview-img-overlay').removeClass('overlay-hovered');
            $(this).parent('h3').parent('.most-viewed-post-right').siblings('.most-viewed-post-left').find('img').removeClass('latest-news-preview-img-hovered');
            $(this).parent('h3').parent('.most-viewed-post-right').siblings('.most-viewed-post-left').find('span').removeClass('span-hovered');
            $(this).parent('h3').parent('.most-viewed-post-right').siblings('.most-viewed-post-left').find('.read-article-divider').removeClass('read-article-divider-hovered');
        });

        //Search header
        $('#search-box').focus(function (event) {
            $('.header--search-profile label').css('color', '#75cbc7');
            $('.search-underline').css('width', '100%');
        });
        $('#search-box').focusout(function (event) {
            $('.header--search-profile label').css('color', '#fff');
            $('.header--search-profile button[type="submit"]').css('color', '#fff');
            $('.search-underline').css('width', '0');
        });

        //Filter block
        $('.select-tags').click(function (event) {
            var clicks = $(this).data('clicks');
            var optionsHeight = $('.tags-list').height();
            if (clicks) {
                $(this).css('height', '24px');
                $('.filter-icon').css('transform', 'rotate(0deg)');
            } else {
                $(this).css('height', optionsHeight + 32 + 'px');
                $('.filter-icon').css({
                    'transform': 'rotate(90deg) scale(0.5) translate(0,-10px)'
                });
            }
            $(this).data("clicks", !clicks);
        });
    }

    if ($(window).width() <= 1020) {
        $('.blog-article-right').insertBefore('.blog-more-articles');
    }

    if ($(window).width() < 767) {
        //Mobile
        $('.latest-video-left').appendTo('.latest-video-posts');
        $(window).resize(function (event) {
            $('.latest-video-left').appendTo('.latest-video-posts');
        });
        $('.footer-text-left').appendTo('.footer-text');
        $(window).resize(function (event) {
            $('.latest-video-left').appendTo('.latest-video-posts');
        });
        $('.slider-controls').css('display', 'none');
        $('#search').appendTo('.header-nav > ul');

        //Menu click
        $('.mobile-menu i').click(function (event) {
            $('.header-nav').css('transform', 'translate3d(0,0,0)');
        });

        //Menu swipe/close
        $('.header-nav').on('swipeleft', function (event) {
            $('.header-nav').css('transform', 'translate3d(-100%,0,0)');
        });

        $('.close-menu').click(function (event) {
            $('.header-nav').css('transform', 'translate3d(-100%,0,0)');
        });

        //Menu submenu
        $('.main-submenu li a').removeClass('fadeInLeft').addClass('fadeInRight');
        $('.header-nav > ul > li:not(.lang):not(.no-submenu) > a').click(function (event) {
            event.preventDefault();
            var clicks = $(this).data('clicks');
            if (clicks) {
                $(this).siblings('.main-submenu').css('display', 'none');
                $(this).siblings('.header-nav > ul > li > i').css('cssText', 'transform: rotate(0) !important');
            } else {
                $(this).siblings('.main-submenu').css('display', 'block');
                $(this).siblings('.header-nav > ul > li > i').css('cssText', 'transform: rotate(-90deg) !important');
            }
            $(this).data("clicks", !clicks);
        });

        $('.under-menu').css('display', 'none');

        //Change animation submenu
        $('.main-submenu').removeClass('slideInDown').addClass('fadeInRight');

        //Filter block
        $('.select-tags, .filter-category').click(function (event) {
            var clicks = $(this).data('clicks');
            var optionsHeight = $('.tags-list').height();
            if (clicks) {
                $('.select-tags').css('height', '24px');
                $('.filter-icon').css('transform', 'rotate(0deg)');
            } else {
                $('.select-tags').css('height', optionsHeight + 32 + 'px');
                $('.filter-icon').css({
                    'transform': 'rotate(90deg) scale(0.5) translate(0,-10px)'
                });
            }
            $(this).data("clicks", !clicks);
        });
    }
    ;


    /*10-08-2018
     //Move label on login form
     $('.modal-login-content input').click(function (event) {
     $(this).prev().css('bottom', '0');
     });

     //Check form if not empty
     if ($('.modal-login-content form input').val()) {
     $('.modal-login-content label').css('bottom', '0');
     }
     ;
     */

    //Add class to img on main
    $('.latest-from-category-right ul li img').addClass('animated slideInRight');

    //Equal height of post items
    equalheight = function (container) {
        var currentTallest = 0,
                currentRowStart = 0,
                rowDivs = new Array(),
                $el,
                topPosition = 0;
        $(container).each(function () {
            $el = $(this);
            $($el).height('auto')
            topPostion = $el.position().top;
            if (currentRowStart != topPostion) {
                for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                    rowDivs[currentDiv].height(currentTallest);
                }
                rowDivs.length = 0; // empty the array
                currentRowStart = topPostion;
                currentTallest = $el.height();
                rowDivs.push($el);
            } else {
                rowDivs.push($el);
                currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
            }
            for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
        });
    }
    $(window).load(function () {
        equalheight('.latest-news-item:not(.slide-latest-news-item)');
    });
    $(window).resize(function () {
        equalheight('.latest-news-item:not(.slide-latest-news-item)');
    });

    //Slide sidebar on post single page
    $('.sidebar-link').click(function (event) {
        if ($(this).is(':nth-of-type(2)')) {
            $('.sidebar-link').removeClass('sidebar-link-active');
            $(this).addClass('sidebar-link-active');
            $('.sidebar-slider-container').css('marginLeft', '-100%');
        } else {
            $('.sidebar-link').removeClass('sidebar-link-active');
            $(this).addClass('sidebar-link-active');
            $('.sidebar-slider-container').css('marginLeft', '0');
        }
        ;
    });

    //Underheader padding
    setTimeout(function () {
        var headerOffset = $('.header-nav ul').offset();
        $('.main-submenu').css('paddingLeft', headerOffset.left + 25 + 'px');
    }, 200);
    $(window).resize(function () {
        headerOffset = $('.header-nav ul').offset();
        $('.main-submenu').css('paddingLeft', headerOffset.left + 25 + 'px');
    });

    //Move submenu down
    $('.header-nav > ul > li > a.active-menu').siblings('.main-submenu').clone().addClass('fixed-submenu').appendTo('.under-menu');

    $('.header-nav > ul > li:not(.lang):not(.no-submenu) > a').click(function (event) {
        event.preventDefault();
        if ($(this).hasClass('active-menu')) {

        } else {
            $('.header-nav > ul > li > a').removeClass('active-menu active-arrow');
            $(this).addClass('active-menu active-arrow');
            $('.fixed-submenu').css('display', 'none');
            $('.under-menu .del-menu').remove();
            $(this).siblings('.main-submenu').clone().addClass('del-menu').appendTo('.under-menu');
        }
        ;


    });

    //Advertisement append
    $('.adv-blog-block').insertAfter('.category-news-list .latest-news-item:nth-of-type(6)');


    //Hide filter block
    $('.filter-list-block h4').on('click', function (event) {
        var clicks = $(this).data('clicks');
        if (clicks) {
            $(this).siblings('.filter-list').css({
                'maxHeight': '270px',
                'visibility': 'visible',
                'opacity': '1',
                'paddingBottom': '20px'
            });
            $(this).find('img').removeClass('filter-icon-rotate');
        } else {
            $(this).siblings('.filter-list').css({
                'maxHeight': '0px',
                'visibility': 'hidden',
                'opacity': '0',
                'paddingBottom': '0'
            });
            $(this).find('img').addClass('filter-icon-rotate');
        }
        $(this).data("clicks", !clicks);
    });


    //Add Industry checked to selected
    $('.filter-list-industry label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();

        $('.selected-right-industry span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-industry span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-industry span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-industry');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-industry span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-industry").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-industry');
        }
    });


    //Add Category checked to selected
    $('.filter-list-category label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();

        $('.selected-right-category span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-category span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-category span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-category');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-category span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-category").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-category');
        }
    });

    //Add availability checked to selected
    $('.filter-list-availability label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();

        $('.selected-right-availability span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-availability span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-availability span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-availability');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-availability span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-availability").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-availability');
        }
    });

    //Add selected country
    $("#filter-country").change(function () {
        var country = $("#filter-country option:selected").text();
        $('.selected-right-country span').remove();
        $('<span class="animated fadeInRight"></span>').text(country).prependTo('.selected-right-country');
        $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-country span');
    });

    //Add selected city
    $("#filter-city").change(function () {
        var city = $("#filter-city option:selected").text();
        $('.selected-right-city span').remove();
        $('<span class="animated fadeInRight"></span>').text(city).prependTo('.selected-right-city');
        $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-city span');
    });

    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-industry span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-industry li').find('input#' + checkBoxId + '').removeAttr('checked');

        $(this).remove();
        if ($.trim($(".selected-right-industry").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#industries').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#industries').val(industries);
        filterVacancies();
    });


    $(document).delegate('.selected-right-category span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-category li').find('input#' + checkBoxId + '').removeAttr('checked');
        $(this).remove();

        if ($.trim($(".selected-right-category").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-category');
        }

        var categories = $('#categories').val();
        var category_id = getCategoryId(checkBoxId);
        categories = replaceAll(categories, category_id, ' ');
        $('#categories').val(categories);
        filterVacancies();
    });

    /***********************************26.09.2018****************************/

    //Clear filter form
    $('.clear-form-button').on('click', function (event) {
        document.getElementById("filter-form").reset();
        $('.selected-right').empty();
        $('<span class="animated fadeInRight">All</span>').appendTo('.selected-right');

        $('#industries').val('');
        $('#categories').val('');
        $('#availability').val('');
        $('#city').val('');
        $('#country').val('');

        /*26.09.2018s*/
        $('#id_bq_slv_bycategory').val('');
        $('#id_bq_slv_bylook').val('');
        $('#id_bq_slv_bybrand').val('');
        $('#id_bq_slv_shoes').val('');
        $('#id_bq_slv_bags').val('');
        $('#id_bq_slv_jewelry').val('');
        $('#id_bq_slv_accessories').val('');
        $('#id_bq_slv_designers').val('');
        $('#id_bq_slv_size').val('');
        $('#id_bq_slv_colour').val('');
        $('#id_bq_slv_clothing').val('');

        $('#id_bq_slv_categories4kids').val('');
        $('#id_bq_slv_gender').val('');
        $('#id_bq_slv_size4kids').val('');
        $('#id_bq_slv_size4shoe').val('');

        $('#id_bq_slv_categories4beauty').val('');
        $('#id_bq_slv_makeup').val('');
        $('#id_bq_slv_accessories4beauty').val('');
        $('#id_bq_slv_fragrance').val('');

        filterVacancies();
    });






    function AddRemoveInputVal(id, value) {
        var CurrentValue = $(id).val();
        var CurrentValueArr = CurrentValue.split(' ');
        var idArr = $.inArray(value, CurrentValueArr);
        if (idArr === -1) {
            CurrentValueArr.push(value);
        } else {
            CurrentValueArr.splice(idArr, 1);
        }
        $(id).val(CurrentValueArr.join(' ').trim());
    }


    /*id_bq_slv_bycategory*/

    //Add Category checked to selected
    $('.filter-list-id_bq_slv_bycategory label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_bycategory', ThisVal);

        $('.selected-right-id_bq_slv_bycategory span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_bycategory span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_bycategory span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_bycategory');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_bycategory span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_bycategory").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_bycategory');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_bycategory span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_bycategory li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_bycategory li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_bycategory', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_bycategory").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_bycategory').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_bycategory').val(industries);
        filterVacancies();
    });



    /*id_bq_slv_bylook */

    //Add Category checked to selected
    $('.filter-list-id_bq_slv_bylook label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_bylook', ThisVal);

        $('.selected-right-id_bq_slv_bylook span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_bylook span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_bylook span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_bylook');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_bylook span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_bylook").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_bylook');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_bylook span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_bylook li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_bylook li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_bylook', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_bylook").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_bylook').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_bylook').val(industries);
        filterVacancies();
    });


    /*id_bq_slv_bybrand*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_bybrand label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_bybrand', ThisVal);

        $('.selected-right-id_bq_slv_bybrand span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_bybrand span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_bybrand span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_bybrand');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_bybrand span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_bybrand").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_bybrand');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_bybrand span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_bybrand li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_bybrand li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_bybrand', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_bybrand").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_bybrand').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_bybrand').val(industries);
        filterVacancies();
    });


    /*shoes*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_shoes label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_shoes', ThisVal);

        $('.selected-right-id_bq_slv_shoes span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_shoes span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_shoes span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_shoes');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_shoes span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_shoes").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_shoes');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_shoes span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_shoes li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_shoes li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_shoes', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_shoes").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_shoes').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_shoes').val(industries);
        filterVacancies();
    });


    /*id_bq_slv_jewelry*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_jewelry label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_jewelry', ThisVal);

        $('.selected-right-id_bq_slv_jewelry span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_jewelry span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_jewelry span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_jewelry');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_jewelry span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_jewelry").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_jewelry');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_jewelry span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_jewelry li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_jewelry li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_jewelry', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_jewelry").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_jewelry').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_jewelry').val(industries);
        filterVacancies();
    });


    /*id_bq_slv_accessories*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_accessories label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_accessories', ThisVal);

        $('.selected-right-id_bq_slv_accessories span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_accessories span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_accessories span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_accessories');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_accessories span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_accessories").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_accessories');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_accessories span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_accessories li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_accessories li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_accessories', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_accessories").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_accessories').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_accessories').val(industries);
        filterVacancies();
    });


    /*id_bq_slv_designers*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_designers label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_designers', ThisVal);

        $('.selected-right-id_bq_slv_designers span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_designers span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_designers span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_designers');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_designers span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_designers").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_designers');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_designers span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_designers li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_designers li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_designers', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_designers").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_designers').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_designers').val(industries);
        filterVacancies();
    });

    /*id_bq_slv_size*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_size label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_size', ThisVal);

        $('.selected-right-id_bq_slv_size span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_size span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_size span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_size');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_size span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_size").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_size');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_size span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_size li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_size li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_size', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_size").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_size').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_size').val(industries);
        filterVacancies();
    });



    /*id_bq_slv_colour*/

    //Add Category checked to selected
    $('.filter-list-id_bq_slv_colour label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_colour', ThisVal);

        $('.selected-right-id_bq_slv_colour span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_colour span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_colour span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_colour');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_colour span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_colour").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_colour');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_colour span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_colour li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_colour li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_colour', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_colour").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_colour').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_colour').val(industries);
        filterVacancies();
    });


    /*id_bq_slv_clothing*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_clothing label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_clothing', ThisVal);

        $('.selected-right-id_bq_slv_clothing span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_clothing span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_clothing span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_clothing');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_clothing span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_clothing").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_clothing');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_clothing span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_clothing li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_clothing li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_clothing', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_clothing").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_clothing').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_clothing').val(industries);
        filterVacancies();
    });


    /*id_bq_slv_bags*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_bags label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_bags', ThisVal);

        $('.selected-right-id_bq_slv_bags span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_bags span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_bags span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_bags');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_bags span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_bags").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_bags');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_bags span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_bags li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_bags li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_bags', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_bags").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_bags').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_bags').val(industries);
        filterVacancies();
    });




    /*id_bq_slv_categories4kids*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_categories4kids label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_categories4kids', ThisVal);

        $('.selected-right-id_bq_slv_categories4kids span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_categories4kids span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_categories4kids span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_categories4kids');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_categories4kids span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_categories4kids").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_categories4kids');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_categories4kids span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_categories4kids li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_categories4kids li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_categories4kids', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_categories4kids").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_categories4kids').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_categories4kids').val(industries);
        filterVacancies();
    });

    /*gender*/

    //Add Category checked to selected
    $('.filter-list-id_bq_slv_gender label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_gender', ThisVal);

        $('.selected-right-id_bq_slv_gender span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_gender span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_gender span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_gender');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_gender span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_gender").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_gender');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_gender span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_gender li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_gender li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_gender', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_gender").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_gender').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_gender').val(industries);
        filterVacancies();
    });

    /*id_bq_slv_size4kids*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_size4kids label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_size4kids', ThisVal);

        $('.selected-right-id_bq_slv_size4kids span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_size4kids span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_size4kids span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_size4kids');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_size4kids span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_size4kids").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_size4kids');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_size4kids span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_size4kids li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_size4kids li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_size4kids', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_size4kids").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_size4kids').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_size4kids').val(industries);
        filterVacancies();
    });

    /*id_bq_slv_size4shoe*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_size4shoe label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_size4shoe', ThisVal);

        $('.selected-right-id_bq_slv_size4shoe span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_size4shoe span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_size4shoe span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_size4shoe');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_size4shoe span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_size4shoe").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_size4shoe');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_size4shoe span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_size4shoe li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_size4shoe li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_size4shoe', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_size4shoe").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_size4shoe').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_size4shoe').val(industries);
        filterVacancies();
    });


    /*id_bq_slv_categories4beauty*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_categories4beauty label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_categories4beauty', ThisVal);

        $('.selected-right-id_bq_slv_categories4beauty span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_categories4beauty span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_categories4beauty span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_categories4beauty');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_categories4beauty span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_categories4beauty").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_categories4beauty');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_categories4beauty span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_categories4beauty li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_categories4beauty li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_categories4beauty', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_categories4beauty").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_categories4beauty').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_categories4beauty').val(industries);
        filterVacancies();
    });


    /*id_bq_slv_makeup*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_makeup label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_makeup', ThisVal);

        $('.selected-right-id_bq_slv_makeup span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_makeup span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_makeup span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_makeup');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_makeup span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_makeup").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_makeup');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_makeup span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_makeup li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_makeup li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_makeup', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_makeup").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_makeup').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_makeup').val(industries);
        filterVacancies();
    });

    /*id_bq_slv_accessories4beauty*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_accessories4beauty label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_accessories4beauty', ThisVal);

        $('.selected-right-id_bq_slv_accessories4beauty span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_accessories4beauty span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_accessories4beauty span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_accessories4beauty');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_accessories4beauty span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_accessories4beauty").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_accessories4beauty');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_accessories4beauty span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_accessories4beauty li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_accessories4beauty li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_accessories4beauty', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_accessories4beauty").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_accessories4beauty').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_accessories4beauty').val(industries);
        filterVacancies();
    });


    /*id_bq_slv_fragrance*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_fragrance label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_fragrance', ThisVal);

        $('.selected-right-id_bq_slv_fragrance span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_fragrance span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_fragrance span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_fragrance');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_fragrance span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_fragrance").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_fragrance');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_fragrance span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_fragrance li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_fragrance li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_fragrance', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_fragrance").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_fragrance').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_fragrance').val(industries);
        filterVacancies();
    });


    /*id_bq_slv_categories4pets*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_categories4pets label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_categories4pets', ThisVal);

        $('.selected-right-id_bq_slv_categories4pets span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_categories4pets span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_categories4pets span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_categories4pets');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_categories4pets span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_categories4pets").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_categories4pets');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_categories4pets span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_categories4pets li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_categories4pets li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_categories4pets', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_categories4pets").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_categories4pets').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_categories4pets').val(industries);
        filterVacancies();
    });



    /*id_bq_slv_material*/
    //Add Category checked to selected
    $('.filter-list-id_bq_slv_material label').on('click', function (event) {
        var filterFor = $(this).attr('for');
        var filterName = $(this).text();
        var ThisVal = $(this).attr('data-val');

        AddRemoveInputVal('#id_bq_slv_material', ThisVal);

        $('.selected-right-id_bq_slv_material span').each(function (index, el) {
            if ($(this).text() == 'All') {
                $(this).remove();
            }
        });

        if ($('.selected-right-id_bq_slv_material span[data-id=' + filterFor + ']')[0]) {
            $('.selected-right-id_bq_slv_material span[data-id=' + filterFor + ']')[0].remove();
        } else {
            $('<span class="animated fadeInRight"></span>').attr('data-id', filterFor).text(filterName).prependTo('.selected-right-id_bq_slv_material');
            $('<img src="/img/icons/filter-remove-icon.svg">').appendTo('.selected-right-id_bq_slv_material span[data-id=' + filterFor + ']');
        }

        if ($.trim($(".selected-right-id_bq_slv_material").html()) == '') {
            $('<span>All</span>').prependTo('.selected-right-id_bq_slv_material');
        }
        filterVacancies();
    });


    /*  Remove and uncheck filter */
    $(document).delegate('.selected-right-id_bq_slv_material span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');
        $('.filter-list-id_bq_slv_material li').find('input#' + checkBoxId + '').removeAttr('checked');
        var GetIDValue = $('.filter-list-id_bq_slv_material li').find('input#' + checkBoxId + '').val();
        AddRemoveInputVal('#id_bq_slv_material', GetIDValue);
        $(this).remove();
        if ($.trim($(".selected-right-id_bq_slv_material").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-industry');
        }

        var industries = $('#id_bq_slv_material').val();
        var industry_id = getIndustryId(checkBoxId);
        industries = replaceAll(industries, industry_id, ' ');
        $('#id_bq_slv_material').val(industries);
        filterVacancies();
    });


    /*************************************************************************/





    $(document).delegate('.selected-right-availability span', 'click', function (event) {
        var checkBoxId = $(this).attr('data-id');

        $('.filter-list-availability li').find('input#' + checkBoxId + '').removeAttr('checked');
        $(this).remove();
        if ($.trim($(".selected-right-availability").html()) == '') {
            $('<span class="animated fadeInRight">All</span>').prependTo('.selected-right-availability');
        }

        var availability = $('#availability').val();
        var availability_id = getAvailabilityId(checkBoxId);
        availability = replaceAll(availability, availability_id, ' ');
        $('#availability').val(availability);

        filterVacancies();
    });

    $(document).delegate('.selected-right-country span', 'click', function (event) {
        $("#filter-country option").removeAttr('selected');
        $(this).remove();
        $('<span class="animated fadeInRight">All</span>').appendTo('.selected-right-country');

        $('#country').val('');
        filterVacancies();
    });

    $(document).delegate('.selected-right-city span', 'click', function (event) {
        $("#filter-city option").removeAttr('selected');
        $(this).remove();
        $('<span class="animated fadeInRight">All</span>').appendTo('.selected-right-city');

        $('#city').val('');
        filterVacancies();
    });





    //Filter block height
    var filterBlockHeight = function () {
        var filterBlockHeight = $('.vacancies-block').height();
        $('.filter-block').css('minHeight', filterBlockHeight + 'px');
    };
    filterBlockHeight();

    //Resize and show more equal height
    $(window).resize(function (event) {
        filterBlockHeight();
    });

    $('.more-vacancies').on('click', function (event) {
        filterBlockHeight();
    });


    //Mobile filter trigger
    $('.filter-block-button').on('click', function (event) {
        $('.filter-block').addClass('filter-block-opened');
        $('body').css('overflow', 'hidden');
        $('.filter-overlay').addClass('filter-overlay-opened');
        $('.filter-overlay-opened').css('opacity', '0.8');
    });

    $('.filter-overlay, .close-filter-slider').on('click', function (event) {
        $('.filter-block').removeClass('filter-block-opened');
        $('body').css('overflow', 'visible');
        $('.filter-overlay-opened').css('opacity', '0');
        setTimeout(function () {
            $('.filter-overlay').removeClass('filter-overlay-opened');
        }, 500);
    });

    //Close filter menu on swipe
    $('.filter-block').on('swipeleft', function (event) {
        $('.filter-block').removeClass('filter-block-opened');
        $('body').css('overflow', 'visible');
        $('.filter-overlay-opened').css('opacity', '0');
        setTimeout(function () {
            $('.filter-overlay').removeClass('filter-overlay-opened');
        }, 500);
    });


    //Show contacts
    $('.show-contacts').on('click', function (event) {
        event.preventDefault();
        $('.contacts-list').addClass('contacts-list-opened');
        $(this).remove();
    });


    ////Move company page on vacancy page down
    if ($(window).width() <= 767) {
        $('.company-description').appendTo('.fjob-single-section');
    }




    //Emulate click on file input avatar
    $('#image-holder').on('click', function (event) {
        event.preventDefault();
        $('#fileUpload').click();
    });
    //Avatar preview on load
    $("#fileUpload").on('change', function () {
        //Get count of selected files
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#image-holder");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            $('#image-holder').addClass('notempty');
            if (typeof (FileReader) != "undefined") {
                //loop for each file selected for uploaded.
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img />", {
                            "src": e.target.result,
                            "class": "thumb-image"
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
            } else {
                alert("This browser does not support FileReader.");
            }
        } else {
            $('#image-warning-modal').modal('toggle');
            $('<img src="img/default-avatar.gif">').appendTo(image_holder);
        }
    });
    //Emulate click on file input logo
    $('#logo-holder1').on('click', function (event) {
        event.preventDefault();
        $('#loadLogo1').click();
    });
    $('#logo-holder2').on('click', function (event) {
        event.preventDefault();
        $('#loadLogo2').click();
    });
    $('#logo-holder3').on('click', function (event) {
        event.preventDefault();
        $('#loadLogo3').click();
    });
    $('#logo-holder4').on('click', function (event) {
        event.preventDefault();
        $('#loadLogo4').click();
    });
    $('#logo-holder5').on('click', function (event) {
        event.preventDefault();
        $('#loadLogo5').click();
    });
    //Logo preview on load
    $("#loadLogo1").on('change', function () {
        //Get count of selected files
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#logo-holder1");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            $('#logo-holder1').addClass('notempty');
            if (typeof (FileReader) != "undefined") {
                //loop for each file selected for uploaded.
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img />", {
                            "src": e.target.result,
                            "class": "thumb-image"
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
                ;
            } else {
                alert("This browser does not support FileReader.");
            }
        } else {
            $('#image-warning-modal').modal('toggle');
            $('<img src="img/company_default.png">').appendTo(image_holder);
        }
    });
    $("#loadLogo2").on('change', function () {
        //Get count of selected files
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#logo-holder2");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            $('#logo-holder2').addClass('notempty');
            if (typeof (FileReader) != "undefined") {
                //loop for each file selected for uploaded.
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img />", {
                            "src": e.target.result,
                            "class": "thumb-image"
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
            } else {
                alert("This browser does not support FileReader.");
            }
        } else {
            $('#image-warning-modal').modal('toggle');
            $('<img src="img/company_default.png">').appendTo(image_holder);
        }
    });
    $("#loadLogo3").on('change', function () {
        //Get count of selected files
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#logo-holder3");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            $('#logo-holder3').addClass('notempty');
            if (typeof (FileReader) != "undefined") {
                //loop for each file selected for uploaded.
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img />", {
                            "src": e.target.result,
                            "class": "thumb-image"
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
            } else {
                alert("This browser does not support FileReader.");
            }
        } else {
            $('#image-warning-modal').modal('toggle');
            $('<img src="img/company_default.png">').appendTo(image_holder);
        }
    });
    $("#loadLogo4").on('change', function () {
        //Get count of selected files
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#logo-holder4");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            $('#logo-holder4').addClass('notempty');
            if (typeof (FileReader) != "undefined") {
                //loop for each file selected for uploaded.
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img />", {
                            "src": e.target.result,
                            "class": "thumb-image"
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
            } else {
                alert("This browser does not support FileReader.");
            }
        } else {
            $('#image-warning-modal').modal('toggle');
            $('<img src="img/company_default.png">').appendTo(image_holder);
        }
    });
    $("#loadLogo5").on('change', function () {
        //Get count of selected files
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#logo-holder5");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            $('#logo-holder5').addClass('notempty');
            if (typeof (FileReader) != "undefined") {
                //loop for each file selected for uploaded.
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img />", {
                            "src": e.target.result,
                            "class": "thumb-image"
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
            } else {
                alert("This browser does not support FileReader.");
            }
        } else {
            $('#image-warning-modal').modal('toggle');
            $('<img src="img/company_default.png">').appendTo(image_holder);
        }
    });
    //Add more tel numbers
    $('.add-tel-number').click(function (event) {
        $(this).siblings('.tel-visible').next('.tel-notvisible').removeClass('tel-notvisible').addClass('tel-visible');
        if (!$(this).parent().find('.tel-input-profile').hasClass('tel-notvisible')) {
            $(this).css({
                'opacity': '0',
                'pointerEvents': 'none'
            });
        }
    });

    //Add more companies
    $('.add-one-more-company-button').click(function (event) {
        $('.company-visible').next('.company-notvisible').removeClass('company-notvisible').addClass('company-visible');
        if (!$('.company-profile-form').hasClass('company-notvisible')) {
            $(this).css('display', 'none');
        }
    });
    //Gender options - profile page
    if ($('#user-male').prop('checked')) {
        $('#user-male').removeAttr('checked');
        $('label[for="user-male"]').click();
    } else if ($('#user-female').prop('checked')) {
        $('#user-female').removeAttr('checked');
        $('label[for="user-female"]').click();
    }
    ;

    $('.profile-form-one-col-gender input').on('change', function (event) {
        if ($('#user-male').prop('checked')) {
            if ($('#user-female').prop('checked')) {
                $('#user-female').click();
            }
        }
    });
    $('.profile-form-one-col-gender input').on('change', function (event) {
        if ($('#user-female').prop('checked')) {
            if ($('#user-male').prop('checked')) {
                $('#user-male').click();
            }
        }
    });
    //Active profile menu label
    if ($('.profile-menu li:first-of-type').hasClass('active-profile-menu')) {
        $('.profile-menu > li.active-label').css('top', '25px');
    } else if ($('.profile-menu li:nth-of-type(2)').hasClass('active-profile-menu')) {
        $('.profile-menu > li.active-label').css('top', '55px');
    } else if ($('.profile-menu li:nth-of-type(3)').hasClass('active-profile-menu')) {
        $('.profile-menu > li.active-label').css('top', '85px');
    } else if ($('.profile-menu li:nth-of-type(4)').hasClass('active-profile-menu')) {
        $('.profile-menu > li.active-label').css('top', '115px');
    }
    //Hover profile menu label
    $('.profile-menu > li:first-of-type > a').hover(function () {
        $('.profile-menu > li.active-label').css('top', '25px');
        $(this).css('paddingLeft', '50px');
    }, function () {
        $(this).css('paddingLeft', '55px');
        if ($('.profile-menu li:first-of-type').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '25px');
        } else if ($('.profile-menu li:nth-of-type(2)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '55px');
        } else if ($('.profile-menu li:nth-of-type(3)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '85px');
        } else if ($('.profile-menu li:nth-of-type(4)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '115px');
        }
    });
    $('.profile-menu > li:nth-of-type(2) > a').hover(function () {
        $('.profile-menu > li.active-label').css('top', '55px');
        $(this).css('paddingLeft', '50px');
    }, function () {
        $(this).css('paddingLeft', '55px');
        if ($('.profile-menu li:first-of-type').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '25px');
        } else if ($('.profile-menu li:nth-of-type(2)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '55px');
        } else if ($('.profile-menu li:nth-of-type(3)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '85px');
        } else if ($('.profile-menu li:nth-of-type(4)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '115px');
        }
    });
    $('.profile-menu > li:nth-of-type(3) > a').hover(function () {
        $('.profile-menu > li.active-label').css('top', '85px');
        $(this).css('paddingLeft', '50px');
    }, function () {
        $(this).css('paddingLeft', '55px');
        if ($('.profile-menu li:first-of-type').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '25px');
        } else if ($('.profile-menu li:nth-of-type(2)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '55px');
        } else if ($('.profile-menu li:nth-of-type(3)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '85px');
        } else if ($('.profile-menu li:nth-of-type(4)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '115px');
        }
    });
    $('.profile-menu > li:nth-of-type(4) > a').hover(function () {
        if ($('.profile-menu li ul').hasClass('my-posts-list')) {
            $('.profile-menu > li.active-label').css('top', '165px');
            $(this).css('paddingLeft', '50px');
        } else {
            $('.profile-menu > li.active-label').css('top', '115px');
            $(this).css('paddingLeft', '50px');
        }
    }, function () {
        $(this).css('paddingLeft', '55px');
        if ($('.profile-menu li:first-of-type').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '25px');
        } else if ($('.profile-menu li:nth-of-type(2)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '55px');
        } else if ($('.profile-menu li:nth-of-type(3)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '85px');
        } else if ($('.profile-menu li:nth-of-type(4)').hasClass('active-profile-menu')) {
            $('.profile-menu > li.active-label').css('top', '115px');
        }
    });

    //Open profile menu on mobile
    $(document).on('click', '.profile-menu-label-closed', function (event) {
        event.preventDefault();
        $(document).scrollTop(0);
        $('.profile-left').css({
            'transform': 'translate(0,0)',
            'boxShadow': '0 0 5px #ccc'
        });
        $(this).css('top', '25px');
        $(this).find('i').removeClass('fa-bars').addClass('fa-times');
        $(this).find('span').text('Close menu');
        $('body').css('overflow', 'hidden');
        $('.filter-overlay').addClass('filter-overlay-opened').css("ponter-events", "none");
        $('.filter-overlay').css('opacity', '0.8');
        $(this).removeClass('profile-menu-label-closed').addClass('profile-menu-label-opened');
    });

    //Close profile menu on mobile
    $(document).on('click', '.profile-menu-label-opened', function (event) {
        event.preventDefault();
        $('.profile-left').css({
            'transform': 'translate(-210px,0)',
            'boxShadow': 'none'
        });
        $(this).css('top', '130px');
        $(this).find('i').removeClass('fa-times').addClass('fa-bars');
        $(this).find('span').text('Profile menu');
        $('body').css('overflow', 'visible');
        $('.filter-overlay').removeClass('filter-overlay-opened');
        $('.filter-overlay').css('opacity', '0');
        $(this).removeClass('profile-menu-label-opened').addClass('profile-menu-label-closed');
    });

    $(document).on('click', '.filter-overlay-profile', function (event) {
        event.preventDefault();
        $('.profile-left').css({
            'transform': 'translate(-210px,0)',
            'boxShadow': 'none'
        });
        $('.profile-menu-label').css('top', '130px');
        $('.profile-menu-label').find('i').removeClass('fa-times').addClass('fa-bars');
        $('.profile-menu-label').find('span').text('Profile menu');
        $('body').css('overflow', 'visible');
        $('.filter-overlay').removeClass('filter-overlay-opened');
        $('.filter-overlay').css('opacity', '0');
        $('.profile-menu-label').removeClass('profile-menu-label-opened').addClass('profile-menu-label-closed');
    });

    $('.profile-left').on('swipeleft', function (event) {
        event.preventDefault();
        $('.profile-left').css({
            'transform': 'translate(-210px,0)',
            'boxShadow': 'none'
        });
        $('.profile-menu-label').css('top', '130px');
        $('.profile-menu-label').find('i').removeClass('fa-times').addClass('fa-bars');
        $('.profile-menu-label').find('span').text('Profile menu');
        $('body').css('overflow', 'visible');
        $('.filter-overlay').removeClass('filter-overlay-opened');
        $('.filter-overlay').css('opacity', '0');
        $('.profile-menu-label').removeClass('profile-menu-label-opened').addClass('profile-menu-label-closed');
    });


    //Profile page checkbox fix
    $('.profile-user-block label').on('click', function (event) {
        if ($(this).prev('input').is(':checked')) {
            $(this).prev('input').removeAttr('checked').prop('checked', '0');
        }
    });

    //Profile post subcategories open
    $('.post-categories-block label').on('click', function (event) {
        $(this).next('.subs-block').toggle('slow');
    });


    //Emulate click on file input post preview
    $('#post-preview').on('click', function (event) {
        event.preventDefault();
        $('#post-preview-file').click();
    });
    //Post preview on load
    $("#post-preview-file").on('change', function () {
        //Get count of selected files
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#post-preview");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            image_holder.addClass('notempty');
            if (typeof (FileReader) != "undefined") {
                //loop for each file selected for uploaded.
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img />", {
                            "src": e.target.result,
                            "class": "thumb-image"
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
            } else {
                alert("This browser does not support FileReader.");
            }
        } else {
            $('#image-warning-modal').modal('toggle');
            $('<img src="img/post-default.jpg">').appendTo(image_holder);
        }
    });


    //Add post categories choose only one
    $('.post-categories-block > label').on('click', function (event) {
        if ($('.post-categories-block > input').is(':checked')) {
            $('.post-categories-block > input:checked').next('label').next('.subs-block').toggle('slow');
            $('.post-categories-block > input:checked').click();

            if ($(this).next('.subs-block').find('input').is(':checked')) {
                $(this).next('.subs-block').find('input:checked').click();
            }
        }
    });

    $('.post-categories-block .subs-block > label').on('click', function (event) {
        if ($(this).parent().find('input').is(':checked')) {
            $(this).parent().find('input:checked').click();
        }
    });

    //Covert youtube and vimeo links to iframe
    var videoEmbed = {
        invoke: function () {

            $('.blog-article').html(function (i, html) {
                return videoEmbed.convertMedia(html);
            });

        },
        convertMedia: function (html) {
            var pattern1 = /(?:http?s?:\/\/)?(?:www\.)?(?:vimeo\.com)\/?(.+)/g;
            var pattern2 = /(?:http?s?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g;

            if (pattern1.test(html)) {
                var replacement = '<iframe width="420" height="345" src="//player.vimeo.com/video/$1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

                var html = html.replace(pattern1, replacement);
            }


            if (pattern2.test(html)) {
                var replacement = '<iframe width="420" height="345" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>';
                var html = html.replace(pattern2, replacement);
            }

            return html;
        }
    }

    videoEmbed.invoke();


    //Covert youtube and vimeo links to iframe
    var videoEmbed = {
        invoke: function () {

            $('.latest-video-left-inner > ul > li').html(function (i, html) {
                return videoEmbed.convertMedia(html);
            });

        },
        convertMedia: function (html) {
            var pattern1 = /(?:http?s?:\/\/)?(?:www\.)?(?:vimeo\.com)\/?(.+)/g;
            var pattern2 = /(?:http?s?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g;

            if (pattern1.test(html)) {
                var replacement = '<iframe width="420" height="345" src="//player.vimeo.com/video/$1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

                var html = html.replace(pattern1, replacement);
            }


            if (pattern2.test(html)) {
                var replacement = '<iframe width="420" height="345" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>';
                var html = html.replace(pattern2, replacement);
            }

            return html;
        }
    }

    videoEmbed.invoke();

    //Latest from video preview
    if ($(window).width() > 767) {
        $('.latest-video-left-inner li:nth-of-type(1) iframe').appendTo('.latest-video-right-inner .video-1');
        $('.latest-video-left-inner li:nth-of-type(2) iframe').appendTo('.latest-video-right-inner .video-2');
        $('.latest-video-left-inner li:nth-of-type(3) iframe').appendTo('.latest-video-right-inner .video-3');
        $('.latest-video-left-inner ul li:nth-of-type(1) h3 a').hover(function () {
            $('.latest-video-right-inner .video-1, .latest-video-right-inner .video-2, .latest-video-right-inner .video-3').css('display', 'none');
            $('.latest-video-right-inner .video-1').css('display', 'block');
        });
        $('.latest-video-left-inner ul li:nth-of-type(2) h3 a').hover(function () {
            $('.latest-video-right-inner .video-1, .latest-video-right-inner .video-2, .latest-video-right-inner .video-3').css('display', 'none');
            $('.latest-video-right-inner .video-2').css('display', 'block');
        });
        $('.latest-video-left-inner ul li:nth-of-type(3) h3 a').hover(function () {
            $('.latest-video-right-inner .video-1, .latest-video-right-inner .video-2, .latest-video-right-inner .video-3').css('display', 'none');
            $('.latest-video-right-inner .video-3').css('display', 'block');
        });
    }
    ;



    //Show video link input on choose video post
    $('#post-video').on('change', function (event) {
        if ($('#post-video').is(':checked')) {
            $('.tagsinput-videolink').addClass('tagsinput-videolink-visible');
        } else {
            $('.tagsinput-videolink').removeClass('tagsinput-videolink-visible');
            $('.tagsinput-videolink input').val('');
        }
    });

    //Only one checkbox when adding vacancy
    $('.addvacancy-inform-block-onlyone label').on('click', function (event) {
        if ($('.addvacancy-inform-block-onlyone > input').is(':checked')) {
            $(this).parent('.addvacancy-inform-block-onlyone').find('input:checked').click();
        }
    });

    //Load CV emulate click on input
    $('#loadCVbutton').on('click', function (event) {
        $('#loadCV').click();
    });

    $('#loadCV').on('change', function (event) {
        $('#loadCVbutton i').css('display', 'inline-block');
    });

    //Modals for deleting company
    $('.delete-company1-button').on('click', function (event) {
        $('#delete-company1-modal').modal('toggle');
    });
    $('.delete-company2-button').on('click', function (event) {
        $('#delete-company2-modal').modal('toggle');
    });
    $('.delete-company3-button').on('click', function (event) {
        $('#delete-company3-modal').modal('toggle');
    });
    $('.delete-company4-button').on('click', function (event) {
        $('#delete-company4-modal').modal('toggle');
    });
    $('.delete-company5-button').on('click', function (event) {
        $('#delete-company5-modal').modal('toggle');
    });
    $('.delete-company-button').click(function (event) {
        event.preventDefault();
    });

    //Ajax more posts/vacancies prevent #
    $('.more-posts').on('click', function (event) {
        event.preventDefault();
    });




    // //Profile avatar size
    // if ( $('#image-holder img').height() >= $('#image-holder img').width() ) {
    // 	$('#image-holder img').css({
    // 		'width': '100%',
    // 		'minHeight': '100%'
    // 	});
    // } else {
    // 	$('#image-holder img').css({
    // 		'minWidth': '100%',
    // 		'Height': '100%'
    // 	});
    // };




















// ////////////////////////////////////////////////////////////////////////////////
// /////// MODALS FOR AJAX ////////////////////////////////////////////////////////
// ////////////////////////////////////////////////////////////////////////////////

// //Success modals for saving profile and companies
// $('.profile-user-save').on('click', function(event) {
// 	event.preventDefault();
// 	//ajax code and modal after success
// 	$('#saved-modal').modal('toggle');
// });

// $('.company1-save-button').on('click', function(event) {
// 	event.preventDefault();
// 	//ajax code and modal after success
// 	$('#saved-company-modal').modal('toggle');
// });

// $('.company2-save-button').on('click', function(event) {
// 	event.preventDefault();
// 	//ajax code and modal after success
// 	$('#saved-company-modal').modal('toggle');
// });

// $('.company3-save-button').on('click', function(event) {
// 	event.preventDefault();
// 	//ajax code and modal after success
// 	$('#saved-company-modal').modal('toggle');
// });

// $('.company4-save-button').on('click', function(event) {
// 	event.preventDefault();
// 	//ajax code and modal after success
// 	$('#saved-company-modal').modal('toggle');
// });

// $('.company5-save-button').on('click', function(event) {
// 	event.preventDefault();
// 	//ajax code and modal after success
// 	$('#saved-company-modal').modal('toggle');
// });





// //Delete companies ajax
// $('#delete-company1-modal .delete-company-modal-buttons-yes').on('click', function(event) {
// 	event.preventDefault();
// 	$('.company-profile-form1').find('.logo-photo img').remove();
// 	$('.company-profile-form1').find('.logo-photo').removeClass('notempty');
// 	$('.company-profile-form1').trigger("reset");
// 	$('.company-profile-form1').find('input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
// 	$('.company-profile-form1').find('textarea').text('');
// 	if ( $('.company-profile-form').hasClass('company-notvisible') ) {
// 		$('.add-one-more-company-button').css('display', 'block');
// 	}
// 	//code for ajax request
// });

// $('#delete-company2-modal .delete-company-modal-buttons-yes').on('click', function(event) {
// 	event.preventDefault();
// 	$('.company-profile-form2').find('.logo-photo img').remove();
// 	$('.company-profile-form2').find('.logo-photo').removeClass('notempty');
// 	$('.company-profile-form2').trigger("reset");
// 	$('.company-profile-form2').removeClass('company-visible').addClass('company-notvisible');
// 	if ( $('.company-profile-form').hasClass('company-notvisible') ) {
// 		$('.add-one-more-company-button').css('display', 'block');
// 	}
// 	//code for ajax request
// });

// $('#delete-company3-modal .delete-company-modal-buttons-yes').on('click', function(event) {
// 	event.preventDefault();
// 	$('.company-profile-form3').find('.logo-photo img').remove();
// 	$('.company-profile-form3').find('.logo-photo').removeClass('notempty');
// 	$('.company-profile-form3').trigger("reset");
// 	$('.company-profile-form3').removeClass('company-visible').addClass('company-notvisible');
// 	if ( $('.company-profile-form').hasClass('company-notvisible') ) {
// 		$('.add-one-more-company-button').css('display', 'block');
// 	}
// 	//code for ajax request
// });

// $('#delete-company4-modal .delete-company-modal-buttons-yes').on('click', function(event) {
// 	event.preventDefault();
// 	$('.company-profile-form4').find('.logo-photo img').remove();
// 	$('.company-profile-form4').find('.logo-photo').removeClass('notempty');
// 	$('.company-profile-form4').trigger("reset");
// 	$('.company-profile-form4').removeClass('company-visible').addClass('company-notvisible');
// 	if ( $('.company-profile-form').hasClass('company-notvisible') ) {
// 		$('.add-one-more-company-button').css('display', 'block');
// 	}
// 	//code for ajax request
// });

// $('#delete-company5-modal .delete-company-modal-buttons-yes').on('click', function(event) {
// 	event.preventDefault();
// 	$('.company-profile-form5').find('.logo-photo img').remove();
// 	$('.company-profile-form5').find('.logo-photo').removeClass('notempty');
// 	$('.company-profile-form5').trigger("reset");
// 	$('.company-profile-form5').removeClass('company-visible').addClass('company-notvisible');
// 	if ( $('.company-profile-form').hasClass('company-notvisible') ) {
// 		$('.add-one-more-company-button').css('display', 'block');
// 	}
// 	//code for ajax request
// });



// //////////////////////////Update Ajax - send post button

// $('#send-post-button').on('click', function(event) {
// 	event.preventDefault();
// 	//ajax code here
// 	$('#saved-post').modal('toggle');
// });



























    // $('.profile-menu-label').click(function(event) {
    // 	var clicks = $(this).data('clicks');
    // 	if (clicks) {
    // 		$('.profile-left').css('transform', 'translate(-210px,0)');
    // 		$(this).css('top', '130px');
    // 		$(this).find('i').removeClass('fa-times').addClass('fa-bars');
    // 		$(this).find('span').text('Profile menu');
    // 		$('body').css('overflow', 'visible');
    // 		$('.filter-overlay').removeClass('filter-overlay-opened');
    // 		$('.filter-overlay').css('opacity', '0');
    // 	} else {
    // 		$('.profile-left').css('transform', 'translate(0,0)');
    // 		$(this).css('top', '25px');
    // 		$(this).find('i').removeClass('fa-bars').addClass('fa-times');
    // 		$(this).find('span').text('Close menu');
    // 		$('body').css('overflow', 'hidden');
    // 		$('.filter-overlay').addClass('filter-overlay-opened').css("ponter-events", "none");
    // 		$('.filter-overlay').css('opacity', '0.8');
    // 	}
    // 	$(this).data("clicks", !clicks);
    // });


    // $('.profile-menu-label').click(function(event) {
    // 	$('.profile-left').css('transform', 'translate(0,0)');
    // });


    // //footer to bottom on static page (wrapper height)
    // var screenHeight = $(document).height();
    // var headerHeight = $('header').height();
    // var footerHeight = $('footer').height();
    // var staticWrapperHeight = screenHeight - headerHeight - footerHeight;
    // $('.static-page-wrapper').css('minHeight', staticWrapperHeight + 25 + 'px');





    // //Equal height job logo block
    // $('.vacancies-left').each(function(index, el) {
    // 	var height = $(this).parent().height();
    // 	$(this).height(height);
    // });


    // //Menu arrow
    // $('.header-nav > ul > li a').hover(function() {
    // 	$(this).siblings('i').css({
    // 		'transform': 'translate(-5px,0)',
    // 		'opacity': '1'
    // 	});
    // }, function() {
    // 	$(this).siblings('i').css({
    // 		'transform': 'translate(0,0)',
    // 		'opacity': '0'
    // 	});
    // });



});
