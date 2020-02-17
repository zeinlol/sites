
    $(document).ready(function()
    {
        if (typeof g_googleSearchConfig != 'undefined') // Работать на тех страницах где был запущен конфиг поиска
        {
            // Input поиска делаем так что бы он возвращал начальный текст если все стирают
            if ($('#s'))
            {
                $('#s').addClass("idleField");
                $('#s').focus
                (
                    function()
                    {
                        $(this).removeClass("idleField").addClass("focusField");
                        if (this.value == this.defaultValue)
                        {
                            this.value = '';
                        }
                        if (this.value != this.defaultValue)
                        {
                            this.select();
                        }
                    }
                );
                $('#s').blur
                (
                    function()
                    {
                        $(this).removeClass("focusField").addClass("idleField");
                        if ($.trim(this.value) == '')
                        {
                            this.value = (this.defaultValue ? this.defaultValue : '');
                        }
                    }
                );
            }

            // Настройка поиска
            $('.google-search ul.icons li').click(function()
            {
                var el = $(this);

                if (el.hasClass('active'))
                {
                    return false;
                }

                el.siblings().removeClass('active');
                el.addClass('active');

                // Устанавливаем тип поиска
                g_googleSearchConfig.type = el.attr('data-searchType');
                $('#google-result-more').fadeOut('fast');
                return false;
            });

            // Устанавливаем домен сайта как метку для первой радио кнопки:
            $('#siteNameLabel').append(' ' + g_googleSearchConfig.siteURL);

            // Маркируем радио кнопку поиска по сайту как активную:
            $('#searchSite').click();

            // Маркируем иконку веб поиска как активную:
            $('.google-search li.web').click();

            // Устанавливаем фокус ввода в поле для ввода текста:
            // $('#s').focus();

            $('.google-search').submit(function()
            {
                GoogleSearch();
                return false;
            });

            $('#searchSite, #searchWeb').change(function()
            {
                // Ловим событие click на одной из радио кнопок.
                // g_googleSearchConfig.searchSite примет значение либо true либо false.
                g_googleSearchConfig.searchSite = this.id == 'searchSite';
            });
        }
    });

    function GoogleSearch(settings)
    {
        // Если никаких аргументов не было передано функции,
        // то будут использоваться значения по умолчанию из объекта конфигурации:
        settings = $.extend({}, g_googleSearchConfig,settings);
        settings.term = settings.term || $('#s').val();

        if (settings.searchSite)
        {
            // Используем  опцию для Google site:example.com для ограничения поиска
            // по определенному домену:
            settings.term = 'site:' + settings.siteURL + ' ' + settings.term;
        }

        // URL API Google AJAX Search
        var apiURL     = 'http://ajax.googleapis.com/ajax/services/search/' + settings.type + '?v=1.0&callback=?';
        var resultsDiv = $('#' + g_googleSearchConfig.divId);

        $.getJSON(apiURL, {q: settings.term, rsz: settings.perPage, start: settings.page * settings.perPage},
        function (r)
        {
            var results = r.responseData.results;
            $('#more').remove();

            if (results.length)
            {
                // Если результат был возвращен, добавляем его к элементу div pageContainer,
                // который затем добавлет его к resultsDiv:
                var pageContainer = $('<div class="pageContainer"></div>');
                if ( ! settings.append && settings.searchHead.length)
                {
                    pageContainer.append('<h1>' +  settings.searchHead + '</h1>')
                }

                for (var i = 0; i < results.length; i++)
                {
                    // Создаем новый объект результата и запускаем его метод toString:
                    pageContainer.append(new GoogleSearchResult(results[i]) + '');
                }

                if ( ! settings.append)
                {
                    // Данный код выполняется, если запускается новый поиск 
                    // вместо нажатия на кнопку _Показать еще_:
                    resultsDiv.empty();
                }

                pageContainer.append('<div style="clear: both"></div>')
                             .hide()
                             .appendTo(resultsDiv)
                             .fadeIn('fast');

                var cursor = r.responseData.cursor;

                // Проверяем, имеются ли еще страницы с результатами поиска, 
                // и определяем, показывать ли кнопку _Показать еще_:
                if (+cursor.estimatedResultCount > (settings.page + 1) * settings.perPage)
                {
                    $('<div>', {id: 'google-result-more', html: '+'}).appendTo(resultsDiv).click(
                    function ()
                    {
                        GoogleSearch({append: true, page: settings.page + 1});
                        $(this).fadeOut('fast');
                    });
                }
            }
            else
            {
                // В данном поиске не было найдено ничего.
                resultsDiv.empty();
                $('<p>', {"class": 'googleNotFound', html:g_googleSearchConfig.emptyResult}).hide().appendTo(resultsDiv).fadeIn('fast');
            }
        });
    }

    function GoogleSearchResult(r)
    {
        // Это определение класса. Объект данного класса создается для каждого результата поиска.
        // Разметка генерируется методом .toString().

        var arr = [];

        // GsearchResultClass передается из API Google
        switch (r.GsearchResultClass)
        {
            case 'GwebSearch':
                arr =
                [
                    '<div class="webResult">',
                    '<h2><a href="',r.unescapedUrl,'" target="_blank">',r.title,'</a></h2>',
                    '<p>',r.content,'</p>',
                    '<a href="',r.unescapedUrl,'" target="_blank">',r.unescapedUrl,'</a>',
                    '</div>'
                ];
            break;
            case 'GimageSearch':
                arr =
                [
                    '<div class="imageResult">',
                    '<a target="_blank" href="',r.unescapedUrl,'" title="',r.titleNoFormatting,'" class="pic" style="width:',r.tbWidth,'px;height:',r.tbHeight,'px;">',
                    '<img src="',r.tbUrl,'" width="',r.tbWidth,'" height="',r.tbHeight,'" /></a>',
                    '<div class="clear"></div>','<a href="',r.originalContextUrl,'" target="_blank">',r.visibleUrl,'</a>',
                    '</div>'
                ];
            break;
            case 'GvideoSearch':
                arr =
                [
                    '<div class="imageResult">',
                    '<a target="_blank" href="',r.url,'" title="',r.titleNoFormatting,'" class="pic" style="width:150px;height:auto;">',
                    '<img src="',r.tbUrl,'" width="100%" /></a>',
                    '<div class="clear"></div>','<a href="',r.originalContextUrl,'" target="_blank">',r.publisher,'</a>',
                    '</div>'
                ];
            break;
            case 'GnewsSearch':
                arr =
                [
                    '<div class="webResult">',
                    '<h2><a href="',r.unescapedUrl,'" target="_blank">',r.title,'</a></h2>',
                    '<p>',r.content,'</p>',
                    '<a href="',r.unescapedUrl,'" target="_blank">',r.publisher,'</a>',
                    '</div>'
                ];
            break;
        }

        // Метод toString
        this.toString = function()
        {
            return arr.join('');
        }
    }
