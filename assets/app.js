/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// import './styles/app.scss';
import "./styles/app.scss";

require("@fortawesome/fontawesome-free/css/all.min.css");

// import $ from "jquery";
// global.$ = $;

var $ = require("jquery");
// window.$ = $;
// window.jQuery = $;

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require("bootstrap");
// import 'bootstrap/dist/js/bootstrap.bundle';

// or you can include specific pieces
require('bootstrap/js/dist/tooltip');
require('bootstrap/js/dist/popover');



      /*!
       * Start Bootstrap - SB Admin v6.0.3 (https://startbootstrap.com/template/sb-admin)
       * Copyright 2013-2021 Start Bootstrap
       * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
       */

       

      // $(".dropdown-menu a").click(function (e) {
      //   $(".active").removeClass("active");
      // });

      // $(".dropdown").click(function () {
      //   $(".dropdown-menu").toggleClass("show");
      // });

// $(document).ready(function () {
//   // Show hide popover
//   $(".dropdown").click(function () {
//     $(this).find(".dropdown-menu").slideToggle("fast");
//   });
// });
// $(document).on("click", function (event) {
//   var $trigger = $(".dropdown");
//   if ($trigger !== event.target && !$trigger.has(event.target).length) {
//     $(".dropdown-menu").slideUp("fast");
//   }
// });

$(".carousel").carousel({
  interval: 2000,
});

import "./test.js";

(function ($) {
  "use strict";

  // Add active state to sidbar nav links
  var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
  $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
    if (this.href === path) {
      $(this).addClass("active");
    }
  });

  // Toggle the side navigation
  $("#sidebarToggle").on("click", function (e) {
    e.preventDefault();
    $("body").toggleClass("sb-sidenav-toggled");
  });
})(jQuery);



import './autocomplete.js'