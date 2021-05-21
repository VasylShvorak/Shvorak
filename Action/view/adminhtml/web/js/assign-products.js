define([
    'mage/adminhtml/grid'
], function () {
    'use strict';

    return function (config) {
        var selectedProducts = config.selectedProducts,
            actionProducts = $H(selectedProducts),
            gridJsObject = window[config.gridJsObjectName],
            tabIndex = 1000;
        console.log(actionProducts);
        /**
         * Show selected product when edit form in associated product grid
         */
        $('in_action_products').value = Object.toJSON(actionProducts);
        /**
         * Register action Product
         *
         * @param {Object} grid
         * @param {Object} element
         * @param {Boolean} checked
         */
        function registerActionProduct(grid, element, checked) {
            if (checked) {
                if (element.value) {
                    actionProducts.set(element.value, element.value);
                }
            } else {
                actionProducts.unset(element.value);
            }
            $('in_action_products').value = Object.toJSON(actionProducts);
            grid.reloadParams = {
                'selected_products[]': actionProducts.keys()
            };
        }

        /**
         * Click on product row
         *
         * @param {Object} grid
         * @param {String} event
         */
        function actionProductRowClick(grid, event) {
            var trElement = Event.findElement(event, 'tr'),
                isInput = Event.element(event).tagName === 'INPUT',
                checked = false,
                checkbox = null;

            if (trElement) {
                checkbox = Element.getElementsBySelector(trElement, 'input');

                if (checkbox[0]) {
                    checked = isInput ? checkbox[0].checked : !checkbox[0].checked;
                    gridJsObject.setCheckboxChecked(checkbox[0], checked);
                }
            }
        }

        /**
         * Change product position
         *
         * @param {String} event
         */
        function positionChange(event) {
            var element = Event.element(event);

            if (element && element.checkboxElement && element.checkboxElement.checked) {
                actionProducts.set(element.checkboxElement.value, element.value);
                $('in_action_products').value = Object.toJSON(actionProducts);
            }
        }

        /**
         * Initialize action product row
         *
         * @param {Object} grid
         * @param {String} row
         */
        function actionProductRowInit(grid, row) {
            var checkbox = $(row).getElementsByClassName('checkbox')[0],
                position = $(row).getElementsByClassName('input-text')[0];

            if (checkbox && position) {
                checkbox.positionElement = position;
                position.checkboxElement = checkbox;
                position.disabled = !checkbox.checked;
                position.tabIndex = tabIndex++;
                Event.observe(position, 'keyup', positionChange);
            }
        }

        gridJsObject.rowClickCallback = actionProductRowClick;
        gridJsObject.initRowCallback = actionProductRowInit;
        gridJsObject.checkboxCheckCallback = registerActionProduct;

        if (gridJsObject.rows) {
            gridJsObject.rows.each(function (row) {
                actionProductRowInit(gridJsObject, row);
            });
        }
    };
});
