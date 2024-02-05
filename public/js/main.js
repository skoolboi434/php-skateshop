$(document).ready(function () {
  // Replace dashes with spaces for #brand-heading
  var brandHeading = $('#brand-heading').text();
  var formattedBrandHeading = brandHeading.replace(/-/g, ' ');
  $('#brand-heading').text(formattedBrandHeading);

  // Replace dashes with spaces for .product-brand
  $('.product-brand').each(function () {
    var productBrand = $(this).text();
    var formattedProductBrand = productBrand.replace(/-/g, ' ');
    $(this).text(formattedProductBrand);
  });

  // Replace dashes with spaces for .brand-card
  $('.brand-card').each(function () {
    var productBrandLink = $(this).text();
    var formattedProductBrandLink = productBrandLink.replace(/-/g, ' ');
    $(this).text(formattedProductBrandLink);
  });
});
