/**
 * @module tristanhall
 */
(function() {
    "use strict";

    var app = angular.module('tristanhall', ['slick']);

    app.config([function() {
        window.svg = new Walkway({
            selector: '#logo-svg',
            duration: '2000'
        });
    }]);

    app.run([function() {
        window.svg.draw(function() {
            angular.element('#logo-svg').addClass('complete');
        });
    }]);

})();