// ------------step-wizard-------------
$(document).ready(function () {
  $(".nav-tabs > li a[title]").tooltip();

  //Wizard
  $('a[data-toggle="tab"]').on("show.bs.tab", function (e) {
    var $target = $(e.target);

    if ($target.parent().hasClass("disabled")) {
      return false;
    }
  });

  $(".next-step-1").click(function (e) {
    if (checkSelfReview("notFinal")) {
      var $active = $(".wizard .nav-tabs li.active");
      $active.next().removeClass("disabled");
      nextTab($active);
    }
  });
  $(".next-step-2").click(function (e) {
    if (checkCulture("notFinal")) {
      var $active = $(".wizard .nav-tabs li.active");
      $active.next().removeClass("disabled");
      nextTab($active);
    }
  });
  $(".next-step-review-1").click(function (e) {
    if (checkSelfReview("notFinal")) {
      var $active = $(".wizard .nav-tabs li.active");
      $active.next().removeClass("disabled");
      nextTab($active);
    }
  });
  $(".next-step-review-2").click(function (e) {
    if (checkCulture("notFinal")) {
      var $active = $(".wizard .nav-tabs li.active");
      $active.next().removeClass("disabled");
      nextTab($active);
    }
  });
  $(".prev-step").click(function (e) {
    var $active = $(".wizard .nav-tabs li.active");
    prevTab($active);
  });
  $(".final-step-1").click(function (e) {
    checkSelfReview("final");
  });
  $(".final-step-2").click(function (e) {
    checkCulture("final");
  });
  $(".final-step-3").click(function (e) {
    checkLeadership();
  });
  $(".final-step-review-2").click(function (e) {
    checkCulture("final");
  });
  $(".final-step-review-3").click(function (e) {
    checkLeadership();
  });
});

function nextTab(elem) {
  $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
  $(elem).prev().find('a[data-toggle="tab"]').click();
}
