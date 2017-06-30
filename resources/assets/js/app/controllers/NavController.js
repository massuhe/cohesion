/**
 * Controlador del Navbar
 */
(function () {

    'use strict';

    angular
        .module('miApp')
        .controller('NavController', NavController);

    NavController.$inject = [];

    function NavController() {

        var nc = this;
        nc.menus = [
            {
                nombre: 'Home',
                subMenus: [],
                isDropdown: false,
                active: true,
                link: '#'
            },
            getDropdownObject('Mi Perfil', [
                {nombre: 'Ver Perfil'},
                {nombre: 'Rutina'},
                {nombre: 'Editar Datos'},
                {nombre: 'Cambiar Contraseña'}
            ], 'dropdownMiPerfil'),
            getDropdownObject('Clases', [
                {nombre: 'Listado'},
                {nombre: 'Suspender'}
            ], 'dropdownClases'),
            getDropdownObject('Alumnos', [
                {nombre: 'Listado'},
                {nombre: 'Alta'}
            ], 'dropdownAlumnos'),
            getDropdownObject('Finanzas', [
                {nombre: 'Registrar Pago'},
                {nombre: 'Listar Pagos'},
                {nombre: 'Gestionar Movimientos de Dinero'},
                {nombre: 'Balance General'}
            ], 'dropdownFinanzas'),
            getDropdownObject('Sistema', [
                {nombre: 'Actividades'},
                {nombre: 'Ejercicios'},
                {nombre: 'Inventario'},
                {nombre: 'Roles'},
                {nombre: 'Novedades'}
            ], 'dropdownSistema')
        ];

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
            }
        }
    }
})();