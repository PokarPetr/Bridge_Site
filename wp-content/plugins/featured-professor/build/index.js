/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.scss":
/*!************************!*\
  !*** ./src/index.scss ***!
  \************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ (function(module) {

module.exports = window["React"];

/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ (function(module) {

module.exports = window["wp"]["apiFetch"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["data"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.scss */ "./src/index.scss");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3__);





const __ = wp.i18n.__;
const attrs = {
  prof_id: {
    type: 'string'
  }
};
wp.blocks.registerBlockType("ourplugin/featured-professor", {
  title: "Professor Callout",
  description: "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: attrs,
  edit: EditComponent,
  // save возвращает null и мы можем отдать отображение страницы коду PHP
  save: function () {
    return null;
  }
});

// Отображаем вид в разделе редактирования постов
function EditComponent(props) {
  const [thePreview, setThePreview] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)("");
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (props.attributes.prof_id) {
      update_the_meta();
      async function go() {
        const res = await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3___default()({
          path: `featured_professor/v1/getHTML?prof_id=${props.attributes.prof_id}`,
          method: "GET"
        });
        setThePreview(res);
      }
      go();
    }
  }, [props.attributes.prof_id]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    return () => {
      update_the_meta();
    };
  }, []);
  /*
      wp.data.select("core/block-editor"):
      wp.data - объект, предоставляющий доступ к глобальному хранилищу данных в WordPress.
      .select("core/block-editor") - метод выбора раздела "core/block-editor" в хранилище данных, связанного с блок-редактором.
      .getBlocks()- метод возвращает массив всех блоков, добавленных на страницу в текущем редакторе.
      .filter(x => x.name == "ourplugin/featured-professor") - код оставляет только те блоки, у которых имя (name) совпадает с "ourplugin/featured-professor". 
      .map(x => x.attributes.prof_id) - оставляет только атрибут с именем prof_id
      .filter((x, index, arr) => {
      return arr.indexOf(x) == index
      }) - удаляет дубликаты из массива
      В итоге в массиве profs_for_meta будут только свойства prof_id.
       Обновление метаданных поста. 
      wp.data.dispatch("core/editor"): Выбирает диспетчер для работы с редактором блоков.
      .editPost({meta: {featured_professor: profs_for_meta}}): 
      Обновляет метаданные текущего поста. Устанавливает мета-ключ featured_professor с массивом profs_for_meta в качестве его значения
  */
  function update_the_meta() {
    const profs_for_meta = wp.data.select("core/block-editor").getBlocks().filter(x => x.name == "ourplugin/featured-professor").map(x => x.attributes.prof_id).filter((x, index, arr) => {
      return arr.indexOf(x) == index;
    });
    console.log(profs_for_meta);
    wp.data.dispatch("core/editor").editPost({
      meta: {
        featured_professor: profs_for_meta
      }
    });
  }

  // Получаем данные от базы данных wordpress и сохраняем массив в переменную all_profs
  const all_profs = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.useSelect)(select => {
    return select("core").getEntityRecords("postType", "leader", {
      per_page: -1
    });
  });
  // Пока загружаются данные выводим Loading...
  if (all_profs == undefined) return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("strong", null, "Loading..."));
  // После загрузки отображаем блок 
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "featured-professor-wrapper"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "professor-select-container"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("select", {
    onChange: e => props.setAttributes({
      prof_id: e.target.value
    })
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
    value: ""
  }, __('Select a player', 'featured-professor')), all_profs.map(prof => {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
      value: prof.id,
      selected: props.attributes.prof_id == prof.id
    }, prof.title.rendered);
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    dangerouslySetInnerHTML: {
      __html: thePreview
    }
  }));
}
}();
/******/ })()
;
//# sourceMappingURL=index.js.map