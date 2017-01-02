/**
 * @author      Sergey Babko <srgbabko@gmail.com>
 * @copyright   © 2017 farior (https://github.com/farior)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
define([
    'jquery',
    'Treant',
    'jquery/ui',
    'dragscroll',
    'domReady!'
], function ($, Treant) {
    "use strict";

    $.widget('layout.chart', {
        options: {
            rootOrientation: 'WEST',
            scrollbar: 'none mouseout',
            text: {},
            children: []
        },
        _create: function () {
            var chartConfig = {
                chart: {
                    container: '#' + this.element.attr('id'),
                    node: {
                        collapsable: true
                    },
                    rootOrientation: this.options.rootOrientation,
                    scrollbar: this.options.scrollbar
                },
                nodeStructure: {
                    text: this.options.text,
                    children: this.options.children
                }
            };

            new Treant(chartConfig);
        }
    });

    return $.layout.chart;
});
