/******/ (() => { // webpackBootstrap
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/functions.js ***!
  \***********************************/
__webpack_require__.g.deleteObject = function (id, route, _success, error) {
  var url = "/".concat(route, "/").concat(id, "/delete");
  Swal.fire({
    title: 'Confirmar',
    text: '¿Estás seguro de que desea eliminar el cliente?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then(function (result) {
    if (result.isConfirmed) {
      $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function success(response) {
          if (response.success) {
            Swal.fire('Eliminado', _success, 'success');
            window.location.reload();
          } else {
            Swal.fire('Error', error, 'error');
          }
        },
        error: function error() {
          Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
        }
      });
    }
  });
};
/******/ })()
;