(function ($) {
  "use strict";

  var is_mailto_or_tel_link = false;

  /* If preloader is enabled */

  if (zass_main_js_params.show_preloader) {
    $(window).on("load", function () {
      $("#loader").delay(100).fadeOut();

      $(".mask").delay(300).fadeOut();
    });
  }

  $(window).on("load", function () {
    checkRevealFooter();
  });

  $(document).ready(function () {
    // -------------------------------------------------------------------------------------------------------

    // Fade Effect on page "unload" - uncomment to enable

    // -------------------------------------------------------------------------------------------------------

    /*



    $(window).on('beforeunload', function () {

            if(!is_mailto_or_tel_link) {

                $("body").animate({opacity: 0}, "slow");

            }

    });

    */

    $("a.woocommerce-review-link").on("click", function () {
      $("a[href='#reviews']").trigger("click");
    });

    $("html.no-touch .zass-tilting-row").tiltedpage_scroll({
      sectionContainer: ".vc_row",

      angle: 30,

      opacity: true,

      scale: true,

      outAnimation: true,
    });

    /*

     * Remove resposive images functionality for CloudZoom galleries

     */

    $("#wrap a.cloud-zoom img").removeAttr("srcset");

    $(
      "ul#topnav li:has(ul), ul#topnav2 li:has(ul), ul.menu li:has(ul) "
    ).addClass("dropdown");

    $("#header:has(div#header_top) ").addClass("zass-has-header-top");

    $("ul.menu li:has(div)").addClass("has-mega");

    $("#header_top .inner:has(div#menu)").addClass("has-top-menu");

    $(".summary.entry-summary div#report_abuse_form.simplePopup").appendTo(
      "body"
    );

    /**

     * Sticky header (if on)

     */

    if (
      zass_main_js_params.sticky_header &&
      $("#container").has("#header").length
    ) {
      $("body:not(.zass_header_left) #header")
        .addClass("original_header")

        .before(
          $("#header")
            .clone()

            .addClass("animateIt")

            .removeClass("original_header")
        );

      $("#header.animateIt").attr("id", "header2");

      $("#header2.animateIt #header_top").remove();

      $("#header2.animateIt #logo").attr("id", "logo2");

      $("#header2.animateIt #search").attr("id", "search2");

      $("#header2.animateIt #searchform").attr("id", "searchform2");

      $("#header2.animateIt #zass-account-holder").attr(
        "id",

        "zass-account-holder2"
      );

      $("#header2.animateIt #searchsubmit").attr("id", "searchsubmit2");

      $("#header2.animateIt #cart-module").attr("id", "cart-module2");

      $("#header2.animateIt #s").attr("id", "s2");

      $(window).on("scroll", function () {
        var showStickyMenu = $("#header").offset().top;

        $("body").toggleClass(
          "down",

          $(window).scrollTop() > showStickyMenu + 200
        );
      });
    }

    $(
      "body.zass_logo_center_menu_below #header .zass-search-cart-holder"
    ).prependTo("#header #main-menu");

    $(
      "body.zass_logo_center_menu_below #header2 .zass-search-cart-holder"
    ).prependTo("#header2 #main-menu");

    /* Mega Menu */

    $("#header #main-menu .zass-mega-menu").each(function () {
      var menu = $("#header .main_menu_holder").offset();

      var menuColumns = $(this).find("li.zass_colum_title").length;

      $(this).addClass("menu-columns" + menuColumns);

      var dropdown = $(this).parent().offset();

      var i =
        dropdown.left +
        $(this).outerWidth() -
        (menu.left + $("#header .main_menu_holder").outerWidth());

      if (i > 0) {
        $(this).css("margin-left", "-" + (i + 5) + "px");
      }
    });

    $("#header2 #main-menu .zass-mega-menu").each(function () {
      var menu = $("#header2 .main_menu_holder").offset();

      var menuColumns = $(this).find("li.zass_colum_title").length;

      $(this).addClass("menu-columns" + menuColumns);

      var dropdown = $(this).parent().offset();

      var i =
        dropdown.left +
        $(this).outerWidth() -
        (menu.left + $("#header2 .main_menu_holder").outerWidth());

      if (i > 0) {
        $(this).css("margin-left", "-" + (i + 5) + "px");
      }
    });

    var customTitleHeight = $("body.zass_transparent_header #header").height();

    $(
      "body.zass_transparent_header:not(.zass_header_left) .zass_title_holder .inner"
    ).css("padding-top", customTitleHeight + 180);

    var customTitleHeight2 = $("body.zass-overlay-header #header").height();

    $(
      "body.zass-overlay-header:not(.zass_header_left) .zass_title_holder .inner"
    ).css("padding-top", customTitleHeight2 + 180);

    $("#header #search").prepend("<span></span>");

    $("#header2 #search2").prepend("<span></span>");

    $("#header #search > span, #header2 #search2 > span").on(
      "click",

      function () {
        if ($("#header #search").hasClass("active")) {
          $("#header #search").removeClass("active");
        } else {
          $("#header #search").addClass("active");

          $("#header #search #s").focus();
        }
      }
    );

    $("#main-menu .zass-mega-menu").css("display", "");

    if (zass_main_js_params.my_account_display_style === "carousel") {
      $("p.demo_store").prependTo("#content .inner #main");

      $(
        "body.woocommerce-account #customer_login.col2-set, #customer_login.u-columns.col2-set"
      ).addClass("owl-carousel");

      var is_rtl = false;

      if (zass_main_js_params.is_rtl === "true") {
        is_rtl = true;
      }

      $(
        "body.woocommerce-account #customer_login.col2-set, #customer_login.u-columns.col2-set"
      ).owlCarousel({
        rtl: is_rtl,

        items: 1,

        dots: false,

        nav: true,

        navText: [
          zass_main_js_params.login_label,

          zass_main_js_params.register_label,
        ],
      });
    }

    //

    // -------------------------------------------------------------------------------------------------------

    // Mobile Menu

    // -------------------------------------------------------------------------------------------------------

    $(
      ".mob-menu-toggle, .mob-close-toggle, ul#mobile-menu.menu li:not(.menu-item-has-children) a"
    ).on("click", function () {
      $("#menu_mobile").toggleClass("active");

      $("#container").toggleClass("active");
    });

    $("ul#mobile-menu.menu .menu-item a").each(function () {
      if ($(this).html() == "–") {
        $(this).remove();
      }
    });

    $("ul#mobile-menu.menu > li.menu-item-has-children > a").prepend(
      '<span class="drop-mob">+</span>'
    );

    $("ul#mobile-menu.menu > li.menu-item-has-children > a .drop-mob").on(
      "click",

      function (event) {
        event.preventDefault();

        $(this).closest("li").find("ul.sub-menu").toggleClass("active");
      }
    );

    $(".video_controlls a#video-volume").on("click", function () {
      $(".video_controlls a#video-volume").toggleClass("disabled");
    });

    $('a[href="#"], a.cloud-zoom').on("click", function (event) {
      event.preventDefault();
    });

    $(
      'a[href$=".mov"] , a[href$=".swf"], a[href$=".mp4"], a[href*="vimeo.com/"], a[href*="youtube.com/watch"]'
    ).magnificPopup({
      disableOn: 700,

      type: "iframe",

      mainClass: "mfp-fade",

      removalDelay: 160,

      preloader: false,

      fixedContentPos: false,
    });

    $(".wpb_single_image a.prettyphoto").magnificPopup({ type: "image" });

    // -------------------------------------------------------------------------------------------------------

    // Tipsy - tooltips jQuery plugin

    // -------------------------------------------------------------------------------------------------------

    $(
      "a.compe_small, a.compare_prod, a.wish_prod, a#toggle_switch, .team_social a, .count_comments a"
    ).tipsy({
      gravity: "e",

      fade: true,

      title: function () {
        return this.getAttribute("original-title").toUpperCase();
      },
    });

    $(".prod_hold a.add_to_wishlist").attr("title", function () {
      return $(this).data("title");
    });

    $("#currency a, #language a").tipsy({
      gravity: "e",

      fade: true,

      title: function () {
        return this.getAttribute("original-title").toUpperCase();
      },
    });

    // -------------------------------------------------------------------------------------------------------

    // SLIDING ELEMENTS

    // -------------------------------------------------------------------------------------------------------

    $(document)
      .find("a#toggle_switch")

      .on("click", function () {
        var $togglerone = $(this).siblings("#togglerone");

        if ($(this).hasClass("swap")) {
          $(this).removeClass("swap");

          $togglerone.slideToggle("slow");
        } else {
          $(this).addClass("swap");

          $togglerone.slideToggle("slow");
        }
      });

    if (!document.getElementById("zass_page_title")) {
      $("body").addClass("page-no-title");
    } else {
      $("body").addClass("page-has-title");
    }

    $(
      "body.page-no-title .sidebar-trigger, body.zass-accent-tearoff .sidebar-trigger"
    ).prependTo("#header .zass-search-cart-holder");

    if ($("div#zass_page_title .inner").has("div.breadcrumb").length) {
      $(".video_controlls").appendTo("div.breadcrumb");
    } else {
      $(".video_controlls").prependTo("#header .zass-search-cart-holder");
    }

    $(".sidebar-trigger, .close-off-canvas").on("click", function () {
      $(".off-canvas-sidebar").toggleClass("active_sidebar");
    });

    $("html.no-touch .zass-from-bottom").each(function () {
      $(this).appear(function () {
        $(this).delay(300).animate({ opacity: 1, bottom: "0px" }, 500);
      });
    });

    $("html.no-touch .zass-from-left").each(function () {
      $(this).appear(function () {
        $(this).delay(300).animate({ opacity: 1, left: "0px" }, 500);
      });
    });

    $("html.no-touch .zass-from-right").each(function () {
      $(this).appear(function () {
        $(this).delay(300).animate({ opacity: 1, right: "0px" }, 500);
      });
    });

    $("html.no-touch .zass-fade").each(function () {
      $(this).appear(function () {
        $(this).delay(300).animate({ opacity: 1 }, 700);
      });
    });

    $(".zass-counter:not(.already_seen)").each(function () {
      $(this).appear(function () {
        $(this)
          .prop("Counter", 0)

          .animate(
            {
              Counter: $(this).text(),
            },

            {
              duration: 3000,

              decimals: 2,

              easing: "swing",

              step: function (now) {
                $(this).text(Math.ceil(now).toLocaleString("en"));
              },
            }
          );

        $(this).addClass("already_seen");
      });
    });

    // -------------------------------------------------------------------------------------------------------

    // FADING ELEMENTS

    // -------------------------------------------------------------------------------------------------------

    if (zass_main_js_params.page_title_fade === "yes") {
      $(window).scroll(function () {
        $("html.no-touch .zass_title_holder.title_has_image .inner").css(
          "opacity",

          1 - $(window).scrollTop() / 375
        );
      });
    }

    // Put class .last on each 4th widget in the footer

    $("#slide_footer div.one_fourth")
      .filter(function (index) {
        return index % 4 === 3;
      })

      .addClass("last")

      .after('<div class="clear"></div>');

    $("#footer > div.inner div.one_fourth")
      .filter(function (index) {
        return index % 4 === 3;
      })

      .addClass("last")

      .after('<div class="clear"></div>');

    // Put class .last on each 4th widget in pre header

    $("#pre_header > div.inner div.one_fourth")
      .filter(function (index) {
        return index % 4 === 3;
      })

      .addClass("last")

      .after('<div class="clear"></div>');

    // Put class .last on each 3th widget in the footer

    $("#slide_footer div.one_third")
      .filter(function (index) {
        return index % 3 === 2;
      })

      .addClass("last")

      .after('<div class="clear"></div>');

    $("#footer > div.inner div.one_third")
      .filter(function (index) {
        return index % 3 === 2;
      })

      .addClass("last")

      .after('<div class="clear"></div>');

    // Put class .last on each 3th widget in pre header

    $("#pre_header > div.inner div.one_third")
      .filter(function (index) {
        return index % 3 === 2;
      })

      .addClass("last")

      .after('<div class="clear"></div>');

    // Put class .last on each 2nd widget in the footer

    $("#slide_footer div.one_half")
      .filter(function (index) {
        return index % 2 === 1;
      })

      .addClass("last")

      .after('<div class="clear"></div>');

    $("#footer > div.inner div.one_half")
      .filter(function (index) {
        return index % 2 === 1;
      })

      .addClass("last")

      .after('<div class="clear"></div>');

    // Put class .last on each 2nd widget in pre header

    $("#pre_header > div.inner div.one_half")
      .filter(function (index) {
        return index % 2 === 1;
      })

      .addClass("last")

      .after('<div class="clear"></div>');

    // Woocommerce part columns

    $(".woocommerce.columns-2:not(.owl-carousel)").each(function () {
      $(this)
        .find("div.prod_hold, .product-category")

        .filter(function (index) {
          return index % 2 === 1;
        })

        .addClass("last")

        .after('<div class="clear"></div>');
    });

    $(".woocommerce.columns-3:not(.owl-carousel)").each(function () {
      $(this)
        .find("div.prod_hold, .product-category")

        .filter(function (index) {
          return index % 3 === 2;
        })

        .addClass("last")

        .after('<div class="clear"></div>');
    });

    $(".woocommerce.columns-4:not(.owl-carousel)").each(function () {
      $(this)
        .find("div.prod_hold, .product-category")

        .filter(function (index) {
          return index % 4 === 3;
        })

        .addClass("last")

        .after('<div class="clear"></div>');
    });

    $("#tab-more_seller_product").each(function () {
      $(this)
        .find("div.prod_hold")

        .filter(function (index) {
          return index % 4 === 3;
        })

        .addClass("last")

        .after('<div class="clear"></div>');
    });

    $(".woocommerce.columns-5:not(.owl-carousel)").each(function () {
      $(this)
        .find("div.prod_hold, .product-category")

        .filter(function (index) {
          return index % 5 === 4;
        })

        .addClass("last")

        .after('<div class="clear"></div>');
    });

    $(".woocommerce.columns-6:not(.owl-carousel)").each(function () {
      $(this)
        .find("div.prod_hold, .product-category")

        .filter(function (index) {
          return index % 6 === 5;
        })

        .addClass("last")

        .after('<div class="clear"></div>');
    });

    // Number of products to show in category

    // per_page and auto load

    $("select.per_page").on("change", function () {
      $.zass_show_loader();

      $(".woocommerce-ordering").trigger("submit");
    });

    $("select.orderby").on("change", function () {
      $.zass_show_loader();
    });

    function addQty() {
      var input = $(this).parent().find("input[type=number]");

      if (isNaN(input.val())) {
        input.val(0);
      }

      input.val(parseInt(input.val()) + 1);
    }

    function subtractQty() {
      var input = $(this).parent().find("input[type=number]");

      if (isNaN(input.val())) {
        input.val(1);
      }

      if (input.val() > 1) {
        input.val(parseInt(input.val()) - 1);
      }
    }

    $(".zass-qty-plus").on("click", addQty);

    $(".zass-qty-minus").on("click", subtractQty);

    if ($("#cart-module").length !== 0) {
      track_ajax_add_to_cart();

      $("body").on("added_to_cart", update_cart_dropdown);
    }

    if ($("#cart-module2").length !== 0) {
      track_ajax_add_to_cart();

      $("body").on("added_to_cart", update_cart_dropdown);
    }

    $(".zass-latest-grid.zass-latest-blog-col-3 div.post:nth-child(3n)").after(
      "<div class='clear'></div>"
    );

    $(".zass-latest-grid.zass-latest-blog-col-2 div.post:nth-child(2n)").after(
      "<div class='clear'></div>"
    );

    $(".zass-latest-grid.zass-latest-blog-col-4 div.post:nth-child(4n)").after(
      "<div class='clear'></div>"
    );

    $(".zass-latest-grid.zass-latest-blog-col-5 div.post:nth-child(5n)").after(
      "<div class='clear'></div>"
    );

    $(".zass-latest-grid.zass-latest-blog-col-6 div.post:nth-child(6n)").after(
      "<div class='clear'></div>"
    );

    // HIDE EMPTY COMMENTS DIV

    $("div#comments").each(function () {
      if ($(this).children().length == 0) {
        $(this).hide();
      }
    });

    // Smooth scroll

    var scrollDuration = 0;

    if (zass_main_js_params.enable_smooth_scroll) {
      scrollDuration = 1500;
    }

    $(
      "li.menu-item a[href*='#']:not([href='#']), #content .inner .wpb_text_column > a[href*='#']:not([href='#']), a.vc_btn3[href*='#']:not([href='#']), a.woocommerce-review-link, .vc_icon_element a[href*='#']:not([href='#'])"
    ).on("click", function () {
      if (
        location.pathname.replace(/^\//, "") ==
          this.pathname.replace(/^\//, "") &&
        location.hostname == this.hostname
      ) {
        var target = $(this.hash);

        target = target.length
          ? target
          : $("[name=" + this.hash.slice(1) + "]");

        if (target.length) {
          $("html,body").animate(
            {
              scrollTop: target.offset().top - 75,
            },

            scrollDuration,

            "swing"
          );
        }

        return false;
      }
    });

    /**

     * This part handles the menu highlighting functionality.

     * When using anchors

     */

    var aChildren = $("li.menu-item a[href*='#']:not([href='#'])"); // find the a children of the list items

    var aArray = []; // create the empty aArray

    for (var i = 0; i < aChildren.length; i++) {
      var aChild = aChildren[i];

      var ahref = $(aChild).attr("href");

      aArray.push(ahref);
    } // this for loop fills the aArray with attribute href values

    $(window).scroll(function () {
      var windowPos = $(window).scrollTop(); // get the offset of the window from the top of page

      var windowHeight = $(window).height(); // get the height of the window

      var docHeight = $(document).height();

      for (var i = 0; i < aArray.length; i++) {
        var theID = aArray[i];

        if (theID.length && undefined !== $(theID).offset()) {
          var divPos = $(theID).offset().top - 145; // get the offset of the div from the top of page

          var divHeight = $(theID).height(); // get the height of the div in question

          if (windowPos >= divPos && windowPos < divPos + divHeight) {
            $("li.current-menu-item").removeClass("current-menu-item");

            $("li.menu-item a[href='" + theID + "']")
              .parent()

              .addClass("current-menu-item");
          }
        }
      }

      if (windowPos + windowHeight == docHeight) {
        if (!$("li.menu-item:last-child").hasClass("current-menu-item")) {
          var navActiveCurrent = $("li.current-menu-item a").attr("href");

          $("a[href='" + navActiveCurrent + "']")
            .parent()

            .removeClass("current-menu-item");

          $("li.menu-item:last-child a").addClass("current-menu-item");
        }
      }
    });

    // Add to cart Ajax if enable_ajax_add_to_cart is set in the WooCommerce settings and product is simple or variable

    if (zass_main_js_params.enable_ajax_add_to_cart === "yes") {
      $(document).on("click", ".single_add_to_cart_button", function (e) {
        var $add_to_cart_form = $(this).closest("form.cart");

        if ($add_to_cart_form.length) {
          var is_variable = $add_to_cart_form.hasClass("variations_form");

          var is_grouped = $add_to_cart_form.hasClass("grouped_form");

          var is_external = $add_to_cart_form.attr("method") === "get";
        } else {
          return true;
        }

        if (!is_grouped && !is_external) {
          // perform the html5 validation

          if ($add_to_cart_form[0].checkValidity()) {
            e.preventDefault();
          } else {
            return true;
          }

          // If we've chosen unavailable variation don't execute

          if (
            !$(this).is(
              ".wc-variation-is-unavailable,.wc-variation-selection-needed"
            )
          ) {
            var quantity = $add_to_cart_form

              .find('input[name="quantity"]')

              .val();

            var product_id;

            if (is_variable) {
              product_id = $add_to_cart_form

                .find('input[name="add-to-cart"]')

                .val();
            } else {
              product_id = $add_to_cart_form

                .find('button[name="add-to-cart"]')

                .val();
            }

            var data = {
              product_id: product_id,

              quantity: quantity,

              product_sku: "",
            };

            // AJAX add to cart request.

            var $thisbutton = $(this);

            // Trigger event.

            $(document.body).trigger("adding_to_cart", [$thisbutton, data]);

            //AJAX call

            $thisbutton.addClass("loading");

            $thisbutton.prop("disabled", true);

            var add_to_cart_ajax_data = {};

            add_to_cart_ajax_data.action = "zass_wc_add_cart";

            if (product_id) {
              add_to_cart_ajax_data["add-to-cart"] = product_id;
            }

            $.ajax({
              url: zass_main_js_params.admin_url,

              type: "POST",

              data:
                $add_to_cart_form.serialize() +
                "&" +
                $.param(add_to_cart_ajax_data),

              success: function (results) {
                // Redirect to cart option

                if (zass_main_js_params.cart_redirect_after_add === "yes") {
                  window.location = zass_main_js_params.cart_url;
                } else {
                  if ("error_message" in results) {
                    alert(results.error_message);
                  } else {
                    // Trigger event so themes can refresh other areas

                    $(document.body).trigger("added_to_cart", [
                      results.fragments,

                      results.cart_hash,

                      $thisbutton,
                    ]);
                  }
                }
              },

              complete: function (jqXHR, status) {
                $thisbutton.removeClass("loading");

                $thisbutton.prop("disabled", false);
              },
            });
          }
        } else {
          return true;
        }
      });
    }

    // Set flag when mailto: and tel: links are clicked

    $(document.body).on(
      "click",

      "div.widget_zass_contacts_widget a, div.zass-top-bar-message a",

      function (e) {
        is_mailto_or_tel_link = true;
      }
    );

    /*

     * Listen for added_to_wishlist to increase number in header

     */

    $(document.body).on("added_to_wishlist", function () {
      var wishNumberSpan = $("span.zass-wish-number");

      if (wishNumberSpan.length) {
        var wishNum = parseInt(wishNumberSpan.html(), 10);

        if (!isNaN(wishNum)) {
          wishNumberSpan.html(wishNum + 1);
        }
      }
    });

    /*

     * Listen for removed_from_wishlist to decrease number in header

     */

    $(document.body).on("removed_from_wishlist", function () {
      var wishNumberSpan = $("span.zass-wish-number");

      if (wishNumberSpan.length) {
        var wishNum = parseInt(wishNumberSpan.html(), 10);

        if (!isNaN(wishNum) && wishNum > 0) {
          wishNumberSpan.html(wishNum - 1);
        }
      }
    });

    $("#content > .inner > #main").attr("role", "main");
    $("#zass_page_title").attr("role", "region");
    $("#zass_page_title").attr("aria-label", "Breadcrumb");

    // End of document.ready()
  });

  window.onresize = function () {
    checkRevealFooter();
  };

  function checkRevealFooter() {
    var isReveal = $("#footer").height() - 1;

    if (isReveal < 550 && $("body").hasClass("zass_fullwidth")) {
      $("html.no-touch body.zass_fullwidth.zass-reveal-footer #content").css(
        "margin-bottom",

        isReveal + "px"
      );

      $("body.zass_fullwidth.zass-reveal-footer #footer").addClass(
        "zass_do_reveal"
      );
    } else {
      $("html.no-touch body.zass_fullwidth.zass-reveal-footer #content").css(
        "margin-bottom",

        0 + "px"
      );

      $("body.zass_fullwidth.zass-reveal-footer #footer").removeClass(
        "zass_do_reveal"
      );
    }
  }

  //updates the shopping cart in the sidebar, hooks into the added_to_cart event whcih is triggered by woocommerce

  function update_cart_dropdown(event) {
    var product = jQuery.extend(
      { name: zass_main_js_params.product_label, price: "", image: "" },

      zass_added_product
    );

    var notice = $(
      "<div class='zass_added_to_cart_notification'>" +
        product.image +
        "<div class='added-product-text'><strong>" +
        product.name +
        " " +
        zass_main_js_params.added_to_cart_label +
        "</strong></div></div>"
    );

    if (typeof event !== "undefined") {
      //$("body").append(notice).fadeIn('slow');

      if ($("#cart_add_sound").length) {
        $("#cart_add_sound")[0].play && $("#cart_add_sound")[0].play();
      }

      notice.appendTo($("body")).hide().fadeIn("slow");

      setTimeout(function () {
        notice.fadeOut("slow");
      }, 2500);
    }
  }

  var zass_added_product = {};

  function track_ajax_add_to_cart() {
    jQuery("body").on("click", ".add_to_cart_button", function () {
      var productContainer = jQuery(this).parents(".product").eq(0),
        product = {};

      product.name = productContainer.find("span.name").text();

      product.image = productContainer.find("div.image img");

      product.price = productContainer

        .find(".price_hold .amount")

        .last()

        .text();

      /*fallbacks*/

      if (productContainer.length === 0) {
        return;
      }

      if (product.image.length) {
        product.image =
          "<img class='added-product-image' src='" +
          product.image.get(0).src +
          "' title='' alt='' />";
      } else {
        product.image = "";
      }

      zass_added_product = product;
    });
  }

  // Showing loader on price slider change

  jQuery.zass_show_loader = function () {
    var overlay;

    if ($(".shopbypricefilter-overlay").length) {
      overlay = $(".shopbypricefilter-overlay");
    } else {
      overlay = $(
        '<div class="ui-widget-overlay shopbypricefilter-overlay">&nbsp;</div>'
      ).prependTo("body");
    }

    $(overlay).css({
      position: "fixed",

      top: 0,

      left: 0,

      width: "100%",

      height: "100%",

      "z-index": 19999,
    });

    $(".shopbypricefilter-overlay")
      .each(function () {
        var overlay = this;

        var img;

        if ($("img", overlay).length) {
          img = $("img", overlay);
        } else {
          img = $(
            '<img id="price_fltr_loading_gif" src="' +
              zass_main_js_params.img_path +
              'loading3.gif" />'
          ).prependTo(overlay);
        }

        $(img).css({
          "max-height": $(overlay).height() * 0.8,

          "max-width": $(overlay).width() * 0.8,
        });

        $(img).css({
          position: "fixed",

          top: $(window).outerHeight() / 2,

          left: ($(window).outerWidth() - $(img).width()) / 2,
        });
      })

      .show();
  };
})(window.jQuery);

// non jQuery scripts below

("use strict");

/* START BUBBLE EFFECT FUNCTIONS */

function zassBubbleInitHeader(rowUniqueId, canvasUniqueId, skin) {
  var width,
    height,
    largeHeader,
    canvas,
    ctx,
    circles,
    target = true;

  largeHeader = document.getElementById(rowUniqueId);

  if (largeHeader) {
    width = window.innerWidth;

    height = largeHeader.offsetHeight;

    canvas = document.getElementById(canvasUniqueId);

    canvas.width = width;

    canvas.height = height;

    ctx = canvas.getContext("2d");

    var circles = createParticles(width, height);

    zassBubbleAnimate(width, height, ctx, circles, skin);

    window.addEventListener("resize", function () {
      zassBubbleResize(largeHeader, ctx, canvas, skin);
    });
  }
}

function createParticles(width, height) {
  // create particles

  var circles = [];

  for (var x = 0; x < width * 0.25; x++) {
    var c = new zassBubbleCircle(width, height);

    circles.push(c);
  }

  return circles;
}

function zassBubbleResize(largeHeader, ctx, canvas, skin) {
  var width = window.innerWidth;

  var height = largeHeader.offsetHeight;

  canvas.width = width;

  canvas.height = height;

  var circles = createParticles(width, height);

  zassBubbleAnimate(width, height, ctx, circles, skin);
}

function zassBubbleAnimate(width, height, ctx, circles, skin) {
  ctx.clearRect(0, 0, width, height);

  for (var i in circles) {
    circles[i].draw(width, height, ctx, skin);
  }

  requestAnimationFrame(function () {
    zassBubbleAnimate(width, height, ctx, circles, skin);
  });
}

// Canvas manipulation

function zassBubbleCircle() {
  var _this = this;

  // constructor

  (function (width, height) {
    _this.pos = {};

    init(width, height);

    //console.log(_this);
  })();

  function init(width, height) {
    _this.pos.x = Math.random() * width;

    _this.pos.y = height + Math.random() * 100;

    _this.alpha = 0.1 + Math.random() * 0.4;

    _this.scale = 0.1 + Math.random() * 0.4;

    _this.velocity = Math.random();
  }

  this.draw = function (width, height, ctx, skin) {
    if (_this.alpha <= 0) {
      init(width, height);
    }

    _this.pos.y -= _this.velocity;

    _this.alpha -= 0.0005;

    ctx.beginPath();

    ctx.arc(_this.pos.x, _this.pos.y, _this.scale * 10, 0, 2 * Math.PI, false);

    switch (skin) {
      case "light":
        ctx.fillStyle = "rgba(255,255,255," + _this.alpha + ")";

        break;

      case "dark":
        ctx.fillStyle = "rgba(0,0,0," + _this.alpha + ")";

        break;

      default:
        ctx.fillStyle = "rgba(255,255,255," + _this.alpha + ")";
    }

    ctx.fill();
  };
}

/* END BUBBLE EFFECT FUNCTIONS */
