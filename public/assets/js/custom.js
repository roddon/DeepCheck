// JavaScript Document

!(function($) {
    "use strict";
    $.fn.meanmenu = function(e) {
        var n = {
            meanMenuTarget: jQuery(this),
            meanMenuContainer: ".small_nav",
            meanMenuClose: "X",
            meanMenuCloseSize: "18px",
            meanMenuOpen: "<span /><span /><span />",
            meanRevealPosition: "right",
            meanRevealPositionDistance: "0",
            meanRevealColour: "",
            meanScreenWidth: "1199",
            meanNavPush: "",
            meanShowChildren: !0,
            meanExpandableChildren: !0,
            meanExpand: "+",
            meanContract: "-",
            meanRemoveAttrs: !1,
            onePage: !1,
            meanDisplay: "block",
            removeElements: ""
        };
        e = $.extend(n, e);
        var a = window.innerWidth || document.documentElement.clientWidth;
        return this.each(function() {
            var n = e.meanMenuTarget,
                t = e.meanMenuContainer,
                r = e.meanMenuClose,
                i = e.meanMenuCloseSize,
                s = e.meanMenuOpen,
                u = e.meanRevealPosition,
                m = e.meanRevealPositionDistance,
                l = e.meanRevealColour,
                o = e.meanScreenWidth,
                c = e.meanNavPush,
                v = ".meanmenu-reveal",
                h = e.meanShowChildren,
                d = e.meanExpandableChildren,
                y = e.meanExpand,
                j = e.meanContract,
                Q = e.meanRemoveAttrs,
                f = e.onePage,
                g = e.meanDisplay,
                p = e.removeElements,
                C = !1;
            (navigator.userAgent.match(/iPhone/i) ||
                navigator.userAgent.match(/iPod/i) ||
                navigator.userAgent.match(/iPad/i) ||
                navigator.userAgent.match(/Android/i) ||
                navigator.userAgent.match(/Blackberry/i) ||
                navigator.userAgent.match(/Windows Phone/i)) &&
                (C = !0),
                (navigator.userAgent.match(/MSIE 8/i) ||
                    navigator.userAgent.match(/MSIE 7/i)) &&
                    jQuery("html").css("overflow-y", "scroll");
            var w = "",
                x = function() {
                    if ("center" === u) {
                        var e =
                                window.innerWidth ||
                                document.documentElement.clientWidth,
                            n = e / 2 - 22 + "px";
                        (w = "left:" + n + ";right:auto;"),
                            C
                                ? jQuery(".meanmenu-reveal").animate({
                                      left: n
                                  })
                                : jQuery(".meanmenu-reveal").css("left", n);
                    }
                },
                A = !1,
                E = !1;
            "right" === u && (w = "right:" + m + ";left:auto;"),
                "left" === u && (w = "left:" + m + ";right:auto;"),
                x();
            var M = "",
                P = function() {
                    M.html(jQuery(M).is(".meanmenu-reveal.meanclose") ? r : s);
                },
                W = function() {
                    jQuery(".mean-bar,.mean-push").remove(),
                        jQuery(t).removeClass("mean-container"),
                        jQuery(n).css("display", g),
                        (A = !1),
                        (E = !1),
                        jQuery(p).removeClass("mean-remove");
                },
                b = function() {
                    var e = "background:" + l + ";color:" + l + ";" + w;
                    if (o >= a) {
                        jQuery(p).addClass("mean-remove"),
                            (E = !0),
                            jQuery(t).addClass("mean-container"),
                            jQuery(".mean-container").prepend(
                                '<div class="mean-bar"><a href="#nav" class="meanmenu-reveal" style="' +
                                    e +
                                    '">Show Navigation</a><nav class="mean-nav"></nav></div>'
                            );
                        var r = jQuery(n).html();
                        jQuery(".mean-nav").html(r),
                            Q &&
                                jQuery(
                                    "nav.mean-nav ul, nav.mean-nav ul *"
                                ).each(function() {
                                    jQuery(this).is(".mean-remove")
                                        ? jQuery(this).attr(
                                              "class",
                                              "mean-remove"
                                          )
                                        : jQuery(this).removeAttr("class"),
                                        jQuery(this).removeAttr("id");
                                }),
                            jQuery(n).before('<div class="mean-push" />'),
                            jQuery(".mean-push").css("margin-top", c),
                            jQuery(n).hide(),
                            jQuery(".meanmenu-reveal").show(),
                            jQuery(v).html(s),
                            (M = jQuery(v)),
                            jQuery(".mean-nav ul").hide(),
                            h
                                ? d
                                    ? (jQuery(".mean-nav ul ul").each(
                                          function() {
                                              jQuery(this).children().length &&
                                                  jQuery(this, "li:first")
                                                      .parent()
                                                      .append(
                                                          '<a class="mean-expand" href="#" style="font-size: ' +
                                                              i +
                                                              '">' +
                                                              y +
                                                              "</a>"
                                                      );
                                          }
                                      ),
                                      jQuery(".mean-expand").on(
                                          "click",
                                          function(e) {
                                              e.preventDefault(),
                                                  jQuery(this).hasClass(
                                                      "mean-clicked"
                                                  )
                                                      ? (jQuery(this).text(y),
                                                        jQuery(this)
                                                            .prev("ul")
                                                            .slideUp(
                                                                300,
                                                                function() {}
                                                            ))
                                                      : (jQuery(this).text(j),
                                                        jQuery(this)
                                                            .prev("ul")
                                                            .slideDown(
                                                                300,
                                                                function() {}
                                                            )),
                                                  jQuery(this).toggleClass(
                                                      "mean-clicked"
                                                  );
                                          }
                                      ))
                                    : jQuery(".mean-nav ul ul").show()
                                : jQuery(".mean-nav ul ul").hide(),
                            jQuery(".mean-nav ul li")
                                .last()
                                .addClass("mean-last"),
                            M.removeClass("meanclose"),
                            jQuery(M).click(function(e) {
                                e.preventDefault(),
                                    A === !1
                                        ? (M.css("text-align", "center"),
                                          M.css("text-indent", "0"),
                                          M.css("font-size", i),
                                          jQuery(
                                              ".mean-nav ul:first"
                                          ).slideDown(),
                                          (A = !0))
                                        : (jQuery(
                                              ".mean-nav ul:first"
                                          ).slideUp(),
                                          (A = !1)),
                                    M.toggleClass("meanclose"),
                                    P(),
                                    jQuery(p).addClass("mean-remove");
                            }),
                            f &&
                                jQuery(".mean-nav ul > li > a:first-child").on(
                                    "click",
                                    function() {
                                        jQuery(".mean-nav ul:first").slideUp(),
                                            (A = !1),
                                            jQuery(M)
                                                .toggleClass("meanclose")
                                                .html(s);
                                    }
                                );
                    } else W();
                };
            C ||
                jQuery(window).resize(function() {
                    (a =
                        window.innerWidth ||
                        document.documentElement.clientWidth),
                        a > o,
                        W(),
                        o >= a ? (b(), x()) : W();
                }),
                jQuery(window).resize(function() {
                    (a =
                        window.innerWidth ||
                        document.documentElement.clientWidth),
                        C
                            ? (x(), o >= a ? E === !1 && b() : W())
                            : (W(), o >= a && (b(), x()));
                }),
                b();
        });
    };
})(jQuery);

jQuery(document).ready(function() {
    jQuery(".dash_sidebar nav").meanmenu();
});

$(".acout_drop_down").click(function() {
    $(".profile_dropdown").slideToggle();
});

$(document).ready(function() {
    // $(".tablefst").DataTable();

    $("#user-chart-container").insertFusionCharts({
        type: "column2d",
        width: "100%",
        height: "100",
        id: "chart1",
        dataFormat: "json",
        dataSource: {
            chart: {
                paletteColors: "#13c67f",
                showvalues: "0",
                divlinealpha: "30",
                numdivlines: "3",
                showlabels: "0",
                showYAxisValues: "0",
                yAxisMaxValue: "9000",
                palettecolors: "13c67f",
                plotspacepercent: "0",
                chartLeftMargin: "0",
                chartRightMargin: "0",
                plotToolText:
                    "<div><b>$label, <br/>Users: $datavalue</b></div>",
                theme: "zune"
            },
            data: user_chart_data //from data.js
        }
    });
    //Creating Page Views Chart for that month
    $("#page-views-chart-container").insertFusionCharts({
        type: "column2d",
        id: "chart2",
        width: "100%",
        height: "100",
        dataFormat: "json",
        dataSource: {
            chart: {
                paletteColors: "#ec8078",
                showvalues: "0",
                divlinealpha: "30",
                numdivlines: "3",
                showlabels: "0",
                showYAxisValues: "0",
                yAxisMaxValue: "28000",
                palettecolors: "ec8078",
                plotspacepercent: "0",
                chartLeftMargin: "0",
                chartRightMargin: "0",
                plotToolText:
                    "<div><b>$label, <br/>Page Views: $datavalue</b></div>",
                theme: "zune"
            },
            data: page_views_chart_data //from data.js
        }
    });
    //Creating Avg. session duration Chart for that month
    $("#session-duration-chart-container").insertFusionCharts({
        type: "column2d",
        id: "chart3",
        width: "100%",
        height: "100",
        dataFormat: "json",
        dataSource: {
            chart: {
                paletteColors: "#ffcb61",
                showvalues: "0",
                divlinealpha: "30",
                numdivlines: "3",
                showlabels: "0",
                showYAxisValues: "0",
                yAxisMaxValue: "300",
                palettecolors: "ffcb61",
                plotspacepercent: "0",
                chartLeftMargin: "0",
                chartRightMargin: "0",
                plotToolText:
                    "<div><b>$label, <br/>Avg. Session Duration: $value secs</b></div>",
                theme: "zune"
            },
            data: session_duration_chart_data //from data.js
        }
    });
    //Creating Bounce rate Chart for that month
    $("#bounce-rate-chart-container").insertFusionCharts({
        type: "column2d",
        id: "chart4",
        width: "100%",
        height: "100",
        dataFormat: "json",
        dataSource: {
            chart: {
                paletteColors: "#048800",
                showvalues: "0",
                divlinealpha: "30",
                numdivlines: "3",
                showlabels: "0",
                showYAxisValues: "0",
                yAxisMaxValue: "100",
                palettecolors: "048800",
                plotspacepercent: "0",
                chartLeftMargin: "0",
                chartRightMargin: "0",
                plotToolText:
                    "<div><b>$label, <br/>Bounce Rate: $value%</b></div>",
                theme: "zune"
            },
            data: bounce_rate_chart_data //from data.js
        }
    });
    //Creating Session Chart for that month
    $("#session-chart-container").insertFusionCharts({
        type: "mscombi2d",
        id: "chart5",
        width: "100%",
        height: "150",
        dataFormat: "json",
        dataSource: {
            chart: {
                palette: "2",
                showvalues: "0",
                yAxisMaxValue: "10000",
                numDivLines: "2",
                plotfillalpha: "20",
                lineThickness: "4",
                divlinealpha: "20",
                formatnumberscale: "0",
                showlegend: "0",
                labelStep: "6",
                palettecolors: "008ae6",
                labelDisplay: "NONE",
                chartLeftMargin: "10",
                chartRightMargin: "10",
                chartBottomMargin: "10",
                yAxisValuesPadding: "10",
                plotToolText:
                    "<div><b>$label, <br/>Total Hits: $datavalue</b></div>",
                theme: "zune"
            },
            categories: session_chart_catagories, //from data.js
            dataset: session_chart_data //from data.js
        }
    });

    $("#session-chart-container2").insertFusionCharts({
        type: "mscombi2d",
        id: "chart5",
        width: "100%",
        height: "150",
        dataFormat: "json",
        dataSource: {
            chart: {
                palette: "2",
                showvalues: "0",
                yAxisMaxValue: "10000",
                numDivLines: "2",
                plotfillalpha: "20",
                lineThickness: "4",
                divlinealpha: "20",
                formatnumberscale: "0",
                showlegend: "0",
                labelStep: "6",
                palettecolors: "008ae6",
                labelDisplay: "NONE",
                chartLeftMargin: "10",
                chartRightMargin: "10",
                chartBottomMargin: "10",
                yAxisValuesPadding: "10",
                plotToolText:
                    "<div><b>$label, <br/>Total Hits: $datavalue</b></div>",
                theme: "zune"
            },
            categories: session_chart_catagories, //from data.js
            dataset: session_chart_data //from data.js
        }
    });

    //Creating Visistor Type Chart for that month
    $("#visitor-chart-container").insertFusionCharts({
        type: "pie2d",
        id: "chart6",
        width: "100%",
        height: "160",
        dataFormat: "json",
        dataSource: {
            chart: {
                chartLeftMargin: "0",
                chartRightMargin: "0",
                chartTopMargin: "0",
                chartBottomMargin: "0",
                startingAngle: "90",
                showValues: "1",
                showLegend: "1",
                interactiveLegend: "0",
                //"plotTooltext": "<b>No. of $label Visitors: $value<br/>Traffic: $percentValue</b>",
                theme: "zune"
            },
            data: visitor_chart_data //from data.js
        }
    });
    //Creating Gender Chart for that month
    $("#gender-chart-container").insertFusionCharts({
        type: "pie2d",
        id: "chart7",
        width: "100%",
        height: "300",
        dataFormat: "json",
        dataSource: {
            chart: {
                chartLeftMargin: "0",
                chartRightMargin: "0",
                chartTopMargin: "0",
                chartBottomMargin: "0",
                startingAngle: "90",
                showValues: "1",
                showLegend: "1",
                plotTooltext:
                    "<b>Gender: $label<br/>Traffic: $percentValue<br/>No. of users: $value</b>",
                theme: "zune"
            },
            data: gender_chart_data //from data.js
        }
    });
    //Creating Traffic Soucres Chart for that month
    $("#traffic-chart-container").insertFusionCharts({
        type: "column2d",
        id: "chart8",
        width: "100%",
        height: "300",
        dataFormat: "json",
        dataSource: {
            chart: {
                chartLeftMargin: "0",
                chartRightMargin: "0",
                chartBottomMargin: "0",
                //"xAxisName": "Traffic Source",
                yAxisName: "No. of Users",
                yAxisMaxValue: "100000",
                placevaluesInside: "0",
                valueFontColor: "000000",
                palettecolors: "008ae6",
                rotateValues: "0",
                showValues: "1",
                showLegend: "1",
                divLineAlpha: "30",
                //"plotTooltext": "<b>Traffic Source: $label<br/>No. of users: $value</b>",
                theme: "zune"
            },
            data: traffic_chart_data //from data.js
        }
    });
    //Creating Age Group Chart for that month , this tells the different age group of people that visited the site in that month
    $("#age-chart-container").insertFusionCharts({
        type: "column2d",
        id: "chart9",
        width: "100%",
        height: "200",
        dataFormat: "json",
        dataSource: {
            chart: {
                chartLeftMargin: "0",
                chartRightMargin: "0",
                chartBottomMargin: "0",
                xAxisName: "Age Group",
                yAxisName: "No. of Users",
                placevaluesInside: "0",
                valueFontColor: "000000",
                palettecolors: "008ae6",
                rotateValues: "0",
                showValues: "1",
                showLegend: "1",
                divLineAlpha: "30",
                plotTooltext:
                    "<b>Age Group: $label<br/>Traffic: $percentValue<br/>No. of users: $value</b></b>",
                theme: "zune"
            },
            data: age_chart_data //from data.js
        }
    });
    //Creating Geo Location Chart for that month , i.e the location for different places where the site was opened
    $("#location-chart-container").insertFusionCharts({
        type: "maps/worldwithcountries",
        id: "chart10",
        width: "100%",
        height: "500",
        dataFormat: "json",
        dataSource: {
            chart: {
                animation: "0",
                showbevel: "0",
                usehovercolor: "1",
                showlegend: "1",
                legendborderalpha: "0",
                legendshadow: "0",
                legendCaption: "Site Usage",
                connectorcolor: "ff0000",
                entityFillHoverColor: "bfbfbf",
                legendpadding: "0",
                chartLeftMargin: "0",
                chartRightMargin: "0",
                chartTopMargin: "0",
                chartBottomMargin: "0",
                showlabels: "0",
                legendaxisbordercolor: "4db8ff",
                legendspreadfactor: ".4",
                entityToolText:
                    "<b>Country: $lName<br/>No. of Viewers: $value</b>",
                theme: "zune",
                fillColor: "e6f5ff"
            },
            colorrange: {
                minvalue: "0",
                code: "b3e0ff",
                color: [
                    {
                        minvalue: "0",
                        maxvalue: "100",
                        code: "#e6f5ff",
                        displayValue: "< 100"
                    },
                    {
                        minvalue: "100",
                        maxvalue: "1000",
                        code: "#80ccff",
                        displayValue: "100-1K"
                    },
                    {
                        minvalue: "1000",
                        maxvalue: "15000",
                        code: "#1aa3ff",
                        displayValue: "1K-15K"
                    },
                    {
                        minvalue: "15000",
                        maxvalue: "25000",
                        code: "#0075c2",
                        displayValue: "15K-25K"
                    },
                    {
                        minvalue: "25000",
                        maxvalue: "35000",
                        code: "#004d80",
                        displayValue: "25K-35K"
                    }
                ]
            },
            data: location_chart_data //from data.js
        }
    });
});

$("#chart-container").insertFusionCharts({
    type: "pie2d",
    width: "100%",
    height: "100%",
    dataFormat: "json",
    dataSource: {
        chart: {
            //caption: "Market Share of Web Servers",
            //plottooltext: "<b>$percentValue</b> of web servers run on $label servers",
            showlegend: "1",
            showpercentvalues: "1",
            legendposition: "bottom",
            usedataplotcolorforlabels: "1",
            theme: "fusion"
        },
        data: [
            {
                label: "Apache",
                value: "32647479"
            },
            {
                label: "Microsoft",
                value: "22100932"
            },
            {
                label: "Zeus",
                value: "14376"
            },
            {
                label: "Other",
                value: "18674221"
            }
        ]
    }
});

$(document).ready(function() {
    $("#myInput").on("keyup", function() {
        var value = $(this)
            .val()
            .toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle(
                $(this)
                    .text()
                    .toLowerCase()
                    .indexOf(value) > -1
            );
        });
    });

    $("#myInput_two").on("keyup", function() {
        var value = $(this)
            .val()
            .toLowerCase();
        $("#myTable_two tr").filter(function() {
            $(this).toggle(
                $(this)
                    .text()
                    .toLowerCase()
                    .indexOf(value) > -1
            );
        });
    });
});

equalheight = function(container) {
    var currentTallest = 0,
        currentRowStart = 0,
        rowDivs = new Array(),
        $el,
        topPosition = 0;
    $(container).each(function() {
        $el = $(this);
        $($el).height("auto");
        topPostion = $el.position().top;

        if (currentRowStart != topPostion) {
            for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
            rowDivs.length = 0; // empty the array
            currentRowStart = topPostion;
            currentTallest = $el.height();
            rowDivs.push($el);
        } else {
            rowDivs.push($el);
            currentTallest =
                currentTallest < $el.height() ? $el.height() : currentTallest;
        }
        for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
            rowDivs[currentDiv].height(currentTallest);
        }
    });
};

$(window).load(function() {
    equalheight(".sm-hgt");
    equalheight(".parea");
});

$(window).resize(function() {
    equalheight(".sm-hgt");
    equalheight(".parea");
});

var wdth = $(window).width();
if (wdth < 768) {
    function scroll1() {
        $("#scroll-post-1")
            .stop()
            .animate(
                {
                    scrollLeft: $("#right1").offset().left
                },
                500
            );
        event.preventDefault();
    }
    function scroll2() {
        $("#scroll-post-1")
            .stop()
            .animate(
                {
                    scrollLeft: $("#right2").offset().left
                },
                500
            );
        event.preventDefault();
    }

    function scroll3() {
        $("#scroll-post-1")
            .stop()
            .animate(
                {
                    scrollLeft: $("#right3").offset().left
                },
                500
            );
        event.preventDefault();
    }

    function scroll4() {
        $("#scroll-post-1")
            .stop()
            .animate(
                {
                    scrollLeft: $("#right4").offset().left
                },
                500
            );
        event.preventDefault();
    }
}

$(".smenu-arw").click(function() {
    $(this)
        .parent()
        .toggleClass("add");
    $(this).toggleClass("add-two");
    $(".list-unstyled").slideToggle();
});

$(".uploadOuter").click(function() {
    $("#preview").css("display", "inline-block");
});

("use strict");
function dragNdrop(event) {
    var fileName = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("preview");
    var previewImg = document.createElement("img");
    previewImg.setAttribute("src", fileName);
    preview.innerHTML = "";
    preview.appendChild(previewImg);
}
function drag() {
    document.getElementById("uploadFile").parentNode.className =
        "draging dragBox";
}
function drop() {
    document.getElementById("uploadFile").parentNode.className = "dragBox";
}

$(document).ready(function() {
    $(".tab-a").click(function() {
        $(".tab").removeClass("tab-active");
        $(".tab[data-id='" + $(this).attr("data-id") + "']").addClass(
            "tab-active"
        );
        $(".tab-a").removeClass("active-a");
        $(this)
            .parent()
            .find(".tab-a")
            .addClass("active-a");
    });
});
