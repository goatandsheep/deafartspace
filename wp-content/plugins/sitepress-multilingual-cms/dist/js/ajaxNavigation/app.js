!function(t){var e={};function n(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:r})},n.r=function(t){Object.defineProperty(t,"__esModule",{value:!0})},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=1)}([function(t,e,n){"use strict";n.r(e);function r(t){return function(t){if(Array.isArray(t))return o(t)}(t)||function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return o(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(t);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return o(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function o(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,r=new Array(e);n<e;n++)r[n]=t[n];return r}var u=function(t){var e=t.onloadend;t.onloadend=function(t){if(a(t)){var n=document.createElement("html");n.innerHTML=t.currentTarget.responseText,i(n,document)}e&&e(t)}},a=function(t){return 200===t.currentTarget.status&&t.currentTarget.responseText},i=function(t,e){var n=c(t);n.length&&c(e).forEach(function(t,e){var r=s(t,n,e);r&&t.parentNode.replaceChild(r,t)})},c=function(t){return d(l(t).concat(f(t)))},l=function(t){return Array.from(t.getElementsByClassName("wpml-ls"))},f=function(t){return Array.from(t.querySelectorAll("ul > .wpml-ls-menu-item")).map(function(t){return t.parentNode}).filter(p)},s=function(t,e,n){var r=e.filter(function(e){return p(t)?t.id===e.id:t.classList.value===e.classList.value});return r[0]?r[0]:e[n]},p=function(t){return""!==t.id},d=function(t){return r(new Set(t))};document.addEventListener("DOMContentLoaded",function(){!function(t){if(XMLHttpRequest.wpmlCallbacks)XMLHttpRequest.wpmlCallbacks.push(t);else{XMLHttpRequest.wpmlCallbacks=[t];var e=XMLHttpRequest.prototype.send;XMLHttpRequest.prototype.send=function(){var t=this;XMLHttpRequest.wpmlCallbacks.forEach(function(e){return e(t)}),e.apply(this,arguments)}}}(u)})},function(t,e,n){t.exports=n(0)}]);