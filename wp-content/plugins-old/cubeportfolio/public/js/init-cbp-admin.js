(function($, window, document, undefined) {
    'use strict';

    var gridContainer = $('#cbpw-grid' + cbpwOptions.id),
        filtersContainer = $('#cbpw-filters' + cbpwOptions.id);



    /*********************************
     init cubeportfolio
     *********************************/
    cbpwOptions.options.singlePageCallback = function(url, element) {

        // to update singlePage content use the following method: this.updateSinglePage(yourContent)
        var self = this;

        $.ajax({
                url: url,
                type: 'POST',
                dataType: 'html',
                timeout: 10000,
                data: {
                    link: url,
                    type: 'cbp-singlePage',
                    source: 'cubeportfolio',
                    id: cbpwOptions.id,
                    popupData: localStorage.getItem('popup')
                }
            }).done(function(result) {
                self.updateSinglePage('<div class="notice-cbp-singlePage"><strong>Cube Portfolio Notice:</strong> You can\'t test this feature here because some contents don\'t work fine on the admin side. <br>Please test this feature on the frontend side.</div>');
            })
            .fail(function() {
                self.updateSinglePage("Error! Please refresh the page!");
            });

    };

    cbpwOptions.options.singlePageInlineCallback = function(url, element) {

        // to update singlePage content use the following method: this.updateSinglePageInline(yourContent)
        var self = this;

        $.ajax({
                url: url,
                type: 'POST',
                dataType: 'html',
                timeout: 10000,
                data: {
                    link: url,
                    type: 'cbp-singlePageInline',
                    source: 'cubeportfolio',
                    id: cbpwOptions.id,
                    popupData: localStorage.getItem('popup')
                }
            }).done(function(result) {
                self.updateSinglePageInline('<div class="notice-cbp-singlePage"><strong>Cube Portfolio Notice:</strong> You can\'t test this feature here because some contents don\'t work fine on the admin side. <br>Please test this feature on the frontend side.</div>');
            })
            .fail(function() {
                self.updateSinglePageInline("Error! Please refresh the page!");
            });
    };

    gridContainer.cubeportfolio(cbpwOptions.options);

    /*********************************
     add id attr to singlePage block
     *********************************/
    // when the plugin is completed
    gridContainer.on('initComplete.cbp', function() {
        $(this).data('cubeportfolio').singlePage.wrap.attr('id', 'cbpw-singlePage' + cbpwOptions.id);
    });


    cbpwOptions.initFilters = function(container) {
        var wrap, filtersCallback;

        if (container.hasClass('cbp-l-filters-dropdown')) {

            wrap = container.find('.cbp-l-filters-dropdownWrap');

            wrap.on({
                'mouseover.cbp': function() {
                    wrap.addClass('cbp-l-filters-dropdownWrap-open');
                },
                'mouseleave.cbp': function() {
                    wrap.removeClass('cbp-l-filters-dropdownWrap-open');
                }
            });

            filtersCallback = function(me) {
                wrap.find('.cbp-filter-item').removeClass('cbp-filter-item-active');

                wrap.find('.cbp-l-filters-dropdownHeader').text(me.text());

                me.addClass('cbp-filter-item-active');

                wrap.trigger('mouseleave.cbp');
            };

        } else {
            filtersCallback = function(me) {
                me.addClass('cbp-filter-item-active').siblings().removeClass('cbp-filter-item-active');
            };
        }

        container.on('click.cbp', '.cbp-filter-item', function() {

            var me = $(this);

            if (me.hasClass('cbp-filter-item-active')) {
                return;
            }

            // get cubeportfolio data and check if is still animating (reposition) the items.
            if (!$.data(gridContainer[0], 'cubeportfolio').isAnimating) {
                filtersCallback.call(null, me);
            }

            // filter the items
            gridContainer.cubeportfolio('filter', me.data('filter'), function() {});

        });
    };

    cbpwOptions.refreshFilters = function(container) {
        container.off('click.cbp');
        cbpwOptions.initFilters(container);
    };


    /*********************************
     add listener for filters
     *********************************/
     cbpwOptions.initFilters(filtersContainer);


    /*********************************
     activate counter for filters
     *********************************/
    gridContainer.cubeportfolio('showCounter', filtersContainer.find('.cbp-filter-item'), function() {
        // read from url and change filter active
        var match = /#cbpf=(.*?)([#|?&]|$)/gi.exec(location.href),
            item;
        if (match !== null) {
            item = filtersContainer.find('.cbp-filter-item').filter('[data-filter="' + match[1] + '"]');
            if (item.length) {
                filtersCallback.call(null, item);
            }
        }
    });


    /*********************************
     add listener for load more
     *********************************/
    $('#cbpw-loadMore' + cbpwOptions.id).on('click', '.cbp-l-loadMore-button-link', function(e) {
        var clicks, self = $(this),
            container = $('#cbp-load-more-container'),
            items, elements;

        e.preventDefault();

        if (self.hasClass('cbp-l-loadMore-button-stop')) {
            return;
        }

        clicks = $.data(this, 'numberOfClicks') ? parseInt($.data(this, 'numberOfClicks'), 10) : 0;

        self.addClass('cbp-l-loadMore-button-loading');

        var displayItemsLoadMore = +gridContainer.data('cubeportfolio').options.displayItemsLoadMore;

        elements = container.children().slice(clicks, clicks + displayItemsLoadMore);
        items = elements.clone(true);

        items.addClass('cbp-item-config-loaded');

        items.each(function(index, item) {
            var img = $(item).find('img');
            img.attr('src', img.attr('srcc'));
        });

        gridContainer.cubeportfolio('appendItems', items, function() {
            self.removeClass('cbp-l-loadMore-button-loading');

            if (container.children().slice(clicks + displayItemsLoadMore).length === 0) {
                self.addClass('cbp-l-loadMore-button-stop');
            }
        });

        $.data(this, 'numberOfClicks', clicks + displayItemsLoadMore);
    });

})(jQuery, window, document);
