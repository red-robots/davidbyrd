/**
 * jquery.matchHeight.js v0.5.2
 * http://brm.io/jquery-match-height/
 * License: MIT
 */

;(function ($) {
    /*
     *  internal
     */

    var _previousResizeWidth = -1,
        _updateTimeout = -1;

    /*
     *  _rows
     *  utility function returns array of jQuery selections representing each row
     *  (as displayed after float wrapping applied by browser)
     */

    var _rows = function (elements) {
        var tolerance = 1,
            $elements = $(elements),
            lastTop = null,
            rows = [];

        // group elements by their top position
        $elements.each(function () {
            var $that = $(this),
                top = $that.offset().top - _parse($that.css('margin-top')),
                lastRow = rows.length > 0 ? rows[rows.length - 1] : null;

            if (lastRow === null) {
                // first item on the row, so just push it
                rows.push($that);
            } else {
                // if the row top is the same, add to the row group
                if (Math.floor(Math.abs(lastTop - top)) <= tolerance) {
                    rows[rows.length - 1] = lastRow.add($that);
                } else {
                    // otherwise start a new row group
                    rows.push($that);
                }
            }

            // keep track of the last row top
            lastTop = top;
        });

        return rows;
    };

    /*
     *  _parse
     *  value parse utility function
     */

    var _parse = function (value) {
        // parse value and convert NaN to 0
        return parseFloat(value) || 0;
    };

    /*
     *  _parseOptions
     *  handle plugin options
     */

    var _parseOptions = function (options) {
        var opts = {
            byRow: true,
            remove: false,
            property: 'height'
        };

        if (typeof options === 'object') {
            return $.extend(opts, options);
        }

        if (typeof options === 'boolean') {
            opts.byRow = options;
        } else if (options === 'remove') {
            opts.remove = true;
        }

        return opts;
    };

    /*
     *  matchHeight
     *  plugin definition
     */

    var matchHeight = $.fn.matchHeight = function (options) {
        var opts = _parseOptions(options);

        // handle remove
        if (opts.remove) {
            var that = this;

            // remove fixed height from all selected elements
            this.css(opts.property, '');

            // remove selected elements from all groups
            $.each(matchHeight._groups, function (key, group) {
                group.elements = group.elements.not(that);
            });

            // TODO: cleanup empty groups

            return this;
        }

        if (this.length <= 1)
            return this;

        // keep track of this group so we can re-apply later on load and resize events
        matchHeight._groups.push({
            elements: this,
            options: opts
        });

        // match each element's height to the tallest element in the selection
        matchHeight._apply(this, opts);

        return this;
    };

    /*
     *  plugin global options
     */

    matchHeight._groups = [];
    matchHeight._throttle = 80;
    matchHeight._maintainScroll = false;
    matchHeight._beforeUpdate = null;
    matchHeight._afterUpdate = null;

    /*
     *  matchHeight._apply
     *  apply matchHeight to given elements
     */

    matchHeight._apply = function (elements, options) {
        var opts = _parseOptions(options),
            $elements = $(elements),
            rows = [$elements];

        // take note of scroll position
        var scrollTop = $(window).scrollTop(),
            htmlHeight = $('html').outerHeight(true);

        // get hidden parents
        var $hiddenParents = $elements.parents().filter(':hidden');

        // cache the original inline style
        $hiddenParents.each(function () {
            var $that = $(this);
            $that.data('style-cache', $that.attr('style'));
        });

        // temporarily must force hidden parents visible
        $hiddenParents.css('display', 'block');

        // get rows if using byRow, otherwise assume one row
        if (opts.byRow) {

            // must first force an arbitrary equal height so floating elements break evenly
            $elements.each(function () {
                var $that = $(this),
                    display = $that.css('display') === 'inline-block' ? 'inline-block' : 'block';

                // cache the original inline style
                $that.data('style-cache', $that.attr('style'));

                $that.css({
                    'display': display,
                    'padding-top': '0',
                    'padding-bottom': '0',
                    'margin-top': '0',
                    'margin-bottom': '0',
                    'border-top-width': '0',
                    'border-bottom-width': '0',
                    'height': '100px'
                });
            });

            // get the array of rows (based on element top position)
            rows = _rows($elements);

            // revert original inline styles
            $elements.each(function () {
                var $that = $(this);
                $that.attr('style', $that.data('style-cache') || '');
            });
        }

        $.each(rows, function (key, row) {
            var $row = $(row),
                maxHeight = 0;

            // skip apply to rows with only one item
            if (opts.byRow && $row.length <= 1) {
                $row.css(opts.property, '');
                return;
            }

            // iterate the row and find the max height
            $row.each(function () {
                var $that = $(this),
                    display = $that.css('display') === 'inline-block' ? 'inline-block' : 'block';

                // ensure we get the correct actual height (and not a previously set height value)
                var css = {'display': display};
                css[opts.property] = '';
                $that.css(css);

                // find the max height (including padding, but not margin)
                if ($that.outerHeight(false) > maxHeight)
                    maxHeight = $that.outerHeight(false);

                // revert display block
                $that.css('display', '');
            });

            // iterate the row and apply the height to all elements
            $row.each(function () {
                var $that = $(this),
                    verticalPadding = 0;

                // handle padding and border correctly (required when not using border-box)
                if ($that.css('box-sizing') !== 'border-box') {
                    verticalPadding += _parse($that.css('border-top-width')) + _parse($that.css('border-bottom-width'));
                    verticalPadding += _parse($that.css('padding-top')) + _parse($that.css('padding-bottom'));
                }

                // set the height (accounting for padding and border)
                $that.css(opts.property, maxHeight - verticalPadding);
            });
        });

        // revert hidden parents
        $hiddenParents.each(function () {
            var $that = $(this);
            $that.attr('style', $that.data('style-cache') || null);
        });

        // restore scroll position if enabled
        if (matchHeight._maintainScroll)
            $(window).scrollTop((scrollTop / htmlHeight) * $('html').outerHeight(true));

        return this;
    };

    /*
     *  matchHeight._applyDataApi
     *  applies matchHeight to all elements with a data-match-height attribute
     */

    matchHeight._applyDataApi = function () {
        var groups = {};

        // generate groups by their groupId set by elements using data-match-height
        $('[data-match-height], [data-mh]').each(function () {
            var $this = $(this),
                groupId = $this.attr('data-match-height') || $this.attr('data-mh');
            if (groupId in groups) {
                groups[groupId] = groups[groupId].add($this);
            } else {
                groups[groupId] = $this;
            }
        });

        // apply matchHeight to each group
        $.each(groups, function () {
            this.matchHeight(true);
        });
    };

    /*
     *  matchHeight._update
     *  updates matchHeight on all current groups with their correct options
     */

    var _update = function (event) {
        if (matchHeight._beforeUpdate)
            matchHeight._beforeUpdate(event, matchHeight._groups);

        $.each(matchHeight._groups, function () {
            matchHeight._apply(this.elements, this.options);
        });

        if (matchHeight._afterUpdate)
            matchHeight._afterUpdate(event, matchHeight._groups);
    };

    matchHeight._update = function (throttle, event) {
        // prevent update if fired from a resize event
        // where the viewport width hasn't actually changed
        // fixes an event looping bug in IE8
        if (event && event.type === 'resize') {
            var windowWidth = $(window).width();
            if (windowWidth === _previousResizeWidth)
                return;
            _previousResizeWidth = windowWidth;
        }

        // throttle updates
        if (!throttle) {
            _update(event);
        } else if (_updateTimeout === -1) {
            _updateTimeout = setTimeout(function () {
                _update(event);
                _updateTimeout = -1;
            }, matchHeight._throttle);
        }
    };

    /*
     *  bind events
     */

    // apply on DOM ready event
    $(matchHeight._applyDataApi);

    // update heights on load and resize events
    $(window).bind('load', function (event) {
        matchHeight._update(false, event);
    });

    // throttled update heights on resize events
    $(window).bind('resize orientationchange', function (event) {
        matchHeight._update(true, event);
    });

})(jQuery);

/**
 *    Custom jQuery Scripts
 *
 */

$(document).ready(function () {
    //Examples of how to assign the Colorbox event to elements
    $(".group1").colorbox({rel: 'group1'});
    $(".group2").colorbox({rel: 'group2'});
    $(".group3").colorbox({rel: 'group3', transition: "none", width: "75%", height: "75%"});
    $(".group4").colorbox({rel: 'group4', slideshow: true});
    $(".ajax").colorbox();
    $(".youtube").colorbox({iframe: true, innerWidth: 640, innerHeight: 390});
    $(".vimeo").colorbox({iframe: true, innerWidth: 500, innerHeight: 409});
    $(".iframe").colorbox({iframe: true, width: "80%", height: "80%"});
    $(".inline").colorbox({inline: true, width: "50%"});
    $(".callbacks").colorbox({
        onOpen: function () {
            alert('onOpen: colorbox is about to open');
        },
        onLoad: function () {
            alert('onLoad: colorbox has started to load the targeted content');
        },
        onComplete: function () {
            alert('onComplete: colorbox has displayed the loaded content');
        },
        onCleanup: function () {
            alert('onCleanup: colorbox has begun the close process');
        },
        onClosed: function () {
            alert('onClosed: colorbox has completely closed');
        }
    });

    $('.non-retina').colorbox({rel: 'group5', transition: 'none'})
    $('.retina').colorbox({rel: 'group5', transition: 'none', retinaImage: true, retinaUrl: true});

    $('.audio-popup').colorbox({
        className: 'audio',
        inline: true,
        width: '90%',
        maxWidth: '960px',
    });

    $('audio.audio-player').on('contextmenu',function(){
        return false;
    });
    //Example of preserving a JavaScript event for inline calls.
    $("#click").click(function () {
        $('#click').css({
            "background-color": "#f00",
            "color": "#fff",
            "cursor": "inherit"
        }).text("Open this window again and this message will still be here.");
        return false;
    });

    /*
     *
     *	Equal Heights Divs
     *
     ------------------------------------*/
    $('.js-blocks').matchHeight();

    //function to add items to cart
    (function () {
        $('a.add_to_cart_button').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            var id = $this.data('product_id');
            var qty = 1;
            jQuery.post(
                bellaajaxurl.url,
                {
                    'action': 'bella_add_cart',
                    'id': id,
                    'qty': qty,
                },
                function (response) {
                    if (Number($(response).find("cart").attr("id")) === 1) {
                        console.log('added product');
                        //update cart popup
                        jQuery.post(
                            bellaajaxurl.url,
                            {
                                'action': 'bella_get_cart',
                                'data': '',
                            },
                            function (response) {
                                if ($(response).find("response_data").length > 0) {
                                    $text = $(response).find("response_data").eq(0).text();
                                    console.log($text);
                                }
                            }
                        );
                        //update cart popup
                        jQuery.post(
                            bellaajaxurl.url,
                            {
                                'action': 'bella_get_cart_count',
                                'data': '',
                            },
                            function (response) {
                                if ($(response).find("response_data").length > 0) {
                                    $text = $(response).find("response_data").eq(0).text();
                                    console.log($text);
                                }
                            }
                        );
                    }
                }
            );
        });
    })();
});