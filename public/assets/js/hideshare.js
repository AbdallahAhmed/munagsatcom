/*! hideshare - v0.1.0 - 2013-09-11* https://github.com/arnonate/jQuery-FASS-Widget* Copyright (c) 2013 Nate Arnold; Licensed MIT */
!function (e, i) {
    "use strict";
    var t = function (e, t) {
        this.elem = e, this.$elem = i(e), this.options = t
    };
    t.prototype = {
        defaults: {
            link: document.URL,
            title: document.title,
            description: "",
            media: null,
            facebook: !0,
            twitter: !0,
            pinterest: !0,
            googleplus: !0,
            linkedin: !0,
            position: "right",
            speed: 100
        }, init: function () {
            return this.config = i.extend({}, this.defaults, this.options), this.wrapHideshare(), this
        }, wrapHideshare: function () {
            var t = t, n = this.$elem.outerWidth(), o = this.$elem.outerHeight(), s = 0, a = this.config.position,
                r = this.config.speed,
                l = this.elem.dataset.title,
                h = this.elem.dataset.link,
                p = this.config.media,
                c = this.elem.dataset.description;
            this.config.facebook ? (t = '<li><a class="hideshare-facebook" href="#"><i class="fa fa-facebook fa-2x"></i><span>Facebook</span></a></li>', s += 40) : (t = "", s = s), this.config.twitter ? (t += '<li><a class="hideshare-twitter" href="#"><i class="fa fa-twitter-square fa-2x"></i><span>Twitter</span></a></li>', s += 40) : (t = t, s = s), this.config.pinterest ? (t += '<li><a class="hideshare-pinterest" href="#" data-pin-do="buttonPin" data-pin-config="above"><i class="fab fa-pinterest-square fa-2x"></i><span>Pinterest</span></a></li>', s += 40) : (t = t, s = s), this.config.googleplus ? (t += '<li><a class="hideshare-google-plus" href="#"><i class="fab fa-google-plus-square fa-2x"></i><span>Google Plus</span></a></li>', s += 40) : (t = t, s = s), this.config.linkedin ? (t += '<li><a class="hideshare-linkedin" href="#"><i class="fab fa-linkedin fa-2x"></i><span>Linked In</span></a></li>', s += 40) : (t = t, s = s), s < n && (s = n);
            var d = '<ul class="hideshare-list" style="display: none; width: ' + s + 'px">' + t + "</ul>";
            this.$elem.addClass("hideshare-btn").wrap("<div class='hideshare-wrap' style='width:" + n + "px; height:" + o + "px;' />"), this.$wrap = this.$elem.parent(), i(d).insertAfter(this.$elem);
            this.$elem.click(function (e) {
                var t, s, l, h, p, c, d = i(e.currentTarget).parent();
                return d.find(".hideshare-list").hasClass("shown") ? (c = r, d.find(".hideshare-list").animate({
                    top: "0px",
                    left: "0px",
                    opacity: "toggle"
                }, c).removeClass("shown")) : (s = n, l = o, h = r, p = {}, p = "right" === (t = a) ? {
                    left: s + "px",
                    right: -(s) + "px",
                    opacity: "toggle"
                } : "left" === t ? {
                    left: -(s + 10) + "px",
                    right: s + "px",
                    opacity: "toggle"
                } : "top" === t ? {
                    top: -(l + 10) + "px",
                    bottom: l + 10 + "px",
                    opacity: "toggle"
                } : {
                    top: l + 10 + "px",
                    bottom: -(l + 10) + "px",
                    left: "0px",
                    opacity: "toggle"
                }, d.find(".hideshare-list").animate(p, h).addClass("shown")), !1
            });
            this.$wrap.find(".hideshare-facebook").click(function () {
                // connsole.
                console.log(h);
                return e.open("https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(h), "Facebook", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600"), !1
            }), this.$wrap.find(".hideshare-twitter").click(function () {
                return e.open("https://twitter.com/intent/tweet?original_referer=" + encodeURIComponent(h) + "&text=" + encodeURIComponent(l) + "%20" + encodeURIComponent(h), "Twitter", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600"), !1
            }), this.$wrap.find(".hideshare-pinterest").click(function () {
                return e.open("//pinterest.com/pin/create/button/?url=" + encodeURIComponent(h) + "&media=" + encodeURIComponent(p) + "&description=" + encodeURIComponent(l), "Pinterest", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600"), !1
            }), this.$wrap.find(".hideshare-google-plus").click(function () {
                return e.open("//plus.google.com/share?url=" + encodeURIComponent(h), "GooglePlus", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600"), !1
            }), this.$wrap.find(".hideshare-linkedin").click(function () {
                return e.open("//www.linkedin.com/shareArticle?mini=true&url=" + encodeURIComponent(h) + "&title=" + encodeURIComponent(l) + "&source=" + encodeURIComponent(h), "LinkedIn", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600"), !1
            })
        }
    }, t.defaults = t.prototype.defaults, i.fn.hideshare = function (e) {
        return this.each(function () {
            new t(this, e).init()
        })
    }, e.Hideshare = t
}(window, jQuery);