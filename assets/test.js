// ------------------------------------------------------- //
 //   Transparent navbar dropdowns
 //
 //   = do not make navbar
 //   transparent if dropdown's still open
 //   / make transparent again when dropdown's closed
 // ------------------------------------------------------ //

//  var navbar = $('.navbar.bg-transparent').on('show.bs.collapse', function(){ $('.navbar.bg-transparent').removeClass("bg-transparent").addClass('bg-primary');; $(this).removeClass("bg-primary").addClass("bg-transparent"); }));
  // Toggle the side navigation
//   var navbar = $('.navbar'),
//   navbarCollapse = $('.navbar-collapse');

//   $('.navbar.bg-transparent .navbar-collapse').on('hide.bs.collapse', function () {
//     navbar.removeClass('bg-transparent');
//     navbar.addClass('bg-primary');
// });


 var navbar = $('.navbar'),
     navbarCollapse = $('.navbar-collapse');

 $('.navbar.bg-transparent .navbar-collapse').on('show.collapse', function () {
    console.log("toto")
     makeNavbarWhite();
 });
 $('.navbar.bg-transparent .navbar-collapse').on('hide.collapse', function () {
     makeNavbarTransparent();
 });
 function makeNavbarWhite() {
     navbar.addClass('was-transparent');
     if (navbar.hasClass('navbar-dark')) {
         navbar.addClass('was-navbar-dark');
     } else {
         navbar.addClass('was-navbar-light');
     }
     navbar.removeClass('bg-transparent');
     navbar.addClass('bg-primary');
 }
 function makeNavbarTransparent() {
     navbar.removeClass('bg-primary');
     navbar.removeClass('was-transparent');
     navbar.addClass('bg-transparent');
     if (navbar.hasClass('was-navbar-dark')) {
         navbar.addClass('navbar-dark');
     } else {
         navbar.addClass('navbar-light');
     }
 }
