/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

/**
 * Mi aplicación Angular
 */
(function () {

    'use strict';

    angular.module('miApp', []).config(config);

    function config() {}
})();
/*
    .controller('testController',['$scope',function($scope){
        $scope.variableDePrueba = 'funccooo';

        $scope.neneKappa = function(){
            alert('HEY!!!!!');
        }

    }]);*/

/***/ }),
/* 1 */
/***/ (function(module, exports) {

/**
 * Controlador del Navbar
 */
(function () {

    'use strict';

    angular.module('miApp').controller('NavController', NavController);

    NavController.$inject = [];

    function NavController() {

        var nc = this;
        nc.menus = [{
            nombre: 'Home',
            subMenus: [],
            isDropdown: false,
            active: true,
            link: '#'
        }, getDropdownObject('Mi Perfil', [{ nombre: 'Ver Perfil' }, { nombre: 'Rutina' }, { nombre: 'Editar Datos' }, { nombre: 'Cambiar Contraseña' }], 'dropdownMiPerfil'), getDropdownObject('Clases', [{ nombre: 'Listado' }, { nombre: 'Suspender' }], 'dropdownClases'), getDropdownObject('Alumnos', [{ nombre: 'Listado' }, { nombre: 'Alta' }], 'dropdownAlumnos'), getDropdownObject('Finanzas', [{ nombre: 'Registrar Pago' }, { nombre: 'Listar Pagos' }, { nombre: 'Gestionar Movimientos de Dinero' }, { nombre: 'Balance General' }], 'dropdownFinanzas'), getDropdownObject('Sistema', [{ nombre: 'Actividades' }, { nombre: 'Ejercicios' }, { nombre: 'Inventario' }, { nombre: 'Roles' }, { nombre: 'Novedades' }], 'dropdownSistema')];

        var getDropdownObject = getDropdownObject;

        function getDropdownObject(nombre, submenus, idMenu) {
            return {
                nombre: nombre,
                subMenus: submenus,
                isDropdown: true,
                active: false,
                link: '#',
                id: idMenu,
                dataToggle: 'dropdown',
                hasPopup: true,
                expanded: false
            };
        }
    }
})();

/***/ }),
/* 2 */
/***/ (function(module, exports) {

/**
 * Controlador de Prueba
 */
(function () {

    'use strict';

    angular.module('miApp').controller('TestController', TestController);

    TestController.$inject = [];

    function TestController() {

        var vm = this;
        vm.variableDePrueba = 'Funcó';
    }
})();

/***/ }),
/* 3 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 4 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(0);
__webpack_require__(2);
__webpack_require__(1);
__webpack_require__(3);
module.exports = __webpack_require__(4);


/***/ })
/******/ ]);