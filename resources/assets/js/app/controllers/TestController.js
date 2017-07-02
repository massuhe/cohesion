/**
 * Controlador de Prueba
 */
(function() {

    'use strict';

    angular
        .module('miApp')
        .controller('TestController', TestController);

    TestController.$inject = [];

    function TestController() {

        var vm = this;
        vm.variableDePrueba = 'Slider';

    }
})();