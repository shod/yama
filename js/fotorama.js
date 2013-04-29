/* Fotorama 3.0.1 (v1426) | http://fotoramajs.com/license/ */
(function (d) {
    function wa(b) {
        for (var c = {}, d = 0; d < S.length; d++) {
            var p = S[d][0],
                n = S[d][1];
            if (b) {
                var l = b.attr("data-" + p);
                l && ("number" == n ? (l = Number(l), isNaN(l) || (c[p] = l)) : "boolean" == n ? "true" == l ? c[p] = !0 : "false" == l && (c[p] = !1) : "string" == n ? c[p] = l : "boolean-number" == n && ("true" == l ? c[p] = !0 : "false" == l ? c[p] = !1 : (l = Number(l), isNaN(l) || (c[p] = l))))
            } else c[p] = S[d][2]
        }
        return c
    }
    function xa(b, c) {
        for (var d = {}, p = 0; p < Ua.length; p++) d[Ua[p] + b] = c;
        return d
    }
    function ya(b, c, d) {
        if ($ && !d) return xa("transform", c ? "translate(0," + b + "px)" : "translate(" + b + "px,0)");
        d = {};
        d[c ? "top" : "left"] = b;
        return d
    }
    function Fb(b, c, d) {
        return !jb || !$ || !d ? b.position()[c] : b.css("-moz-transform").match(/-?\d+/g)["left" == c ? 4 : 5]
    }
    function za(b) {
        return xa("transition-duration", b + "ms")
    }
    function N(b) {
        b = Number(String(b).replace("px", ""));
        return isNaN(b) ? !1 : b
    }
    function G(b, c, d) {
        return Math.max(c, Math[!1 !== d ? "min" : "max"](d, b))
    }
    function Gb() {
        return !1
    }
    function Va(b) {
        b.mousemove(function (b) {
            b.preventDefault()
        }).mousedown(function (b) {
            b.preventDefault()
        })
    }
    function Zb(b) {
        b.preventDefault();
        document.selection && document.selection.empty ? document.selection.empty() : window.getSelection && window.getSelection().removeAllRanges()
    }
    function kb(b, c) {
        b.is(":visible") ? c() : setTimeout(function () {
            kb(b, c)
        }, 100)
    }
    var Aa, Ba = this.document,
        Da = function (b, c) {
            for (var d in b) if (void 0 !== Ca[b[d]]) return "pfx" == c ? b[d] : !0;
            return !1
        }, aa = function (b, c, d) {
            var p = b.charAt(0).toUpperCase() + b.substr(1),
                n = (b + " " + Ea.join(p + " ") + p).split(" ");
            if ("string" === typeof c || "undefined" === typeof c) c = Da(n, c);
            else {
                n = (b + " " + Fa.join(p + " ") + p).split(" ");
                a: {
                    var b = n,
                        l;
                    for (l in b) if (p = c[b[l]], void 0 !== p) {
                        c = !1 === d ? b[l] : "function" === typeof p ? p.bind(d || c) : p;
                        break a
                    }
                    c = !1
                }
            }
            return c
        }, q = {}, B = Ba.createElement("modernizr"),
        Ca = B.style,
        Ea = ["Webkit", "Moz", "O", "ms"],
        Fa = ["webkit", "moz", "o", "ms"],
        B = {}, Ga = [],
        ba = Ga.slice,
        ca, da = {}.hasOwnProperty,
        oa;
    "undefined" !== typeof da && "undefined" !== typeof da.call ? oa = function (b, c) {
        return da.call(b, c)
    } : oa = function (b, c) {
        return c in b && "undefined" === typeof b.constructor.prototype[c]
    };
    Function.prototype.bind || (Function.prototype.bind = function (b) {
        var c = this;
        if ("function" != typeof c) throw new TypeError;
        var d = ba.call(arguments, 1),
            p = function () {
                if (this instanceof p) {
                    var n = function () {};
                    n.prototype = c.prototype;
                    var n = new n,
                        l = c.apply(n, d.concat(ba.call(arguments)));
                    return Object(l) === l ? l : n
                }
                return c.apply(b, d.concat(ba.call(arguments)))
            };
        return p
    });
    B.canvas = function () {
        var b = Ba.createElement("canvas");
        return !!b.getContext && !! b.getContext("2d")
    };
    B.csstransforms = function () {
        return !!aa("transform")
    };
    B.csstransitions = function () {
        return aa("transition")
    };
    for (var ea in B) oa(B, ea) && (ca = ea.toLowerCase(), q[ca] = B[ea](), Ga.push((q[ca] ? "" : "no-") + ca));
    Ca.cssText = "";
    Aa = (B = null, q._version = "2.5.3", q._domPrefixes = Fa, q._cssomPrefixes = Ea, q.testProp = function (b) {
        return Da([b])
    }, q.testAllProps = aa, q);
    d.extend({
        bez: function (b) {
            var c = "bez_" + d.makeArray(arguments).join("_").replace(".", "p");
            "function" != typeof d.easing[c] && (d.easing[c] = function (c, d, n, l, q) {
                for (var G = [b[0], b[1]], B = [b[2], b[3]], T = [null, null], K = [null, null], U = [null, null], c = function (b, c) {
                    return U[c] = 3 * G[c], K[c] = 3 * (B[c] - G[c]) - U[c], T[c] = 1 - U[c] - K[c], b * (U[c] + b * (K[c] + b * T[c]))
                }, q = d /= q, N = 0, J; 14 > ++N;) {
                    J = c(q, 0) - d;
                    if (0.001 > Math.abs(J)) break;
                    q -= J / (U[0] + q * (2 * K[0] + 3 * T[0] * q))
                }
                return l * c(q, 1) + n
            });
            return c
        }
    });
    var q = "quirks" == document.location.hash.replace("#", ""),
        n = "ontouchstart" in document,
        Ha = navigator.userAgent.toLowerCase().match(/(phone|ipod|ipad|windows ce|netfront|playstation|midp|up\.browser|android|mobile|mini|tablet|symbian|nintendo|wii)/),
        qa = d.browser.msie,
        lb = qa && "6.0" == d.browser.version,
        jb = d.browser.mozilla,
        $ = Aa.csstransforms && Aa.csstransitions && !q && !0,
        mb = "CSS1Compat" != document.compatMode && qa,
        Ia = !q;
    Ia && (q = new Image, q.onerror = function () {
        if (1 != this.width || 1 != this.height) Ia = !1
    }, q.src = "data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==");
    var Ja = 300,
        nb = d.bez([0.1, 0, 0.25, 1]),
        Hb = 500,
        Ib = 333,
        b = "fotorama",
        J = d(window),
        Ka = d(document),
        ob, Wa, S = [
            ["width", "string", null],
            ["minWidth", "string", null],
            ["maxWidth", "string", null],
            ["height", "string", null],
            ["minHeight", "string", null],
            ["maxHeight", "string", null],
            ["aspectRatio", "number", null],
            ["transition", "string", "slide"],
            ["touchStyle", "boolean", !0],
            ["click", "boolean", null],
            ["pseudoClick", "boolean", !0],
            ["loop", "boolean", !1],
            ["autoplay", "boolean-number", !1],
            ["stopAutoplayOnAction", "boolean", !0],
            ["transitionDuration", "number", 333],
            ["background", "string", null],
            ["backgroundColor", "string", null],
            ["margin", "number", 4],
            ["minPadding", "number", 0],
            ["alwaysPadding", "boolean", !1],
            ["zoomToFit", "boolean", !0],
            ["cropToFit", "boolean", !1],
            ["cropToFitIfFullscreen", "boolean", !1],
            ["flexible", "boolean", !1],
            ["fitToWindowHeight", "boolean", !1],
            ["fitToWindowHeightMargin", "number", 20],
            ["fullscreen", "boolean", !1],
            ["fullscreenIcon", "boolean", !1],
            ["vertical", "boolean", !1],
            ["arrows", "boolean", !0],
            ["arrowsColor", "string", null],
            ["arrowPrev", "string", null],
            ["arrowNext", "string", null],
            ["nav", "string", null],
            ["thumbs", "boolean", !0],
            ["navPosition", "string", null],
            ["thumbsOnTop", "boolean", !1],
            ["thumbsOnRight", "boolean", !1],
            ["navBackground", "string", null],
            ["thumbsBackgroundColor", "string", null],
            ["dotColor", "string", null],
            ["thumbColor", "string", null],
            ["thumbsPreview", "boolean", !0],
            ["thumbSize", "number", null],
            ["thumbMargin", "number", 4],
            ["thumbBorderWidth", "number", 2],
            ["thumbBorderColor", "string", null],
            ["thumbsCentered", "boolean", !0],
            ["hideNavIfFullscreen", "boolean", !1],
            ["caption", "string", !1],
            ["preload", "number", 3],
            ["shadows", "boolean", !0],
            ["data", "array", null],
            ["html", "array", null],
            ["hash", "boolean", !1],
            ["startImg", "number", 0],
            ["onShowImg", "function", null],
            ["onFullscreenOpen", "function", null],
            ["onFullscreenClose", "function", null],
            ["onClick", "function", null],
            ["onTransitionStop", "function", null],
            ["detachSiblings", "boolean", !0],
            ["cssTransitions", "boolean", !0]
        ],
        Ua = ["-webkit-", "-moz-", "-o-", "-ms-", ""];
    d.fn[b] = function (q) {
        typeof fotoramaDefaults == "undefined" && (fotoramaDefaults = {});
        this.each(function () {
            var c = d(this),
                B = d.extend(wa(), d.extend({}, fotoramaDefaults, d.extend(q, wa(c))));
            if (!c.data("ini")) {
                c.data({
                    ini: true,
                    options: B
                });
                kb(c, function () {
                    var p = function () {
                        clearTimeout(Jb);
                        !La && !pb && m.removeClass(b + "__wrap_mouseover").addClass(b + "__wrap_mouseout")
                    }, q = function (e, f, c, t, o, E) {
                        f = d(e);
                        t = O.i.test(o) ? z ? z : 1 : t;
                        t = a().vertical ? Math.round(H / t) : Math.round(H * t);
                        if (Aa.canvas) {
                            f.remove();
                            f = d('<canvas class="' + b + '__thumb__img"></canvas>');
                            f.appendTo(I.eq(E))
                        } else f.addClass(b + "__thumb__img");
                        c = {};
                        c[P] = t;
                        c[X] = H;
                        f.attr(c).css(c).css({
                            visibility: "visible"
                        });
                        Aa.canvas && !O.i.test(o) && f[0].getContext("2d").drawImage(e, 0, 0, a().vertical ? H : t, a().vertical ? t : H);
                        c[X] = null;
                        I.eq(E).css(c).data(c);
                        da()
                    }, l = function (a) {
                        if (!Ma && !ga && !Xa && !qb) {
                            a || (a = 0);
                            oa(a, I.eq(a), q, "thumb");
                            setTimeout(function () {
                                a + 1 < w && l(a + 1)
                            }, 50)
                        } else setTimeout(function () {
                            l(a)
                        }, 100)
                    }, B = function (e, f, b) {
                        if (e) if (O.no.test(e) || O.px.test(e)) {
                            ra = g = G(N(e), sa, Na);
                            ha = ta = false
                        } else if (O["%"].test(e)) {
                            rb = Number(String(e).replace("%", "")) / 100;
                            ta = !a().flexible;
                            if (!g) {
                                g = c.width() * (r ? 1 : rb) - Kb;
                                g = G(g, sa, Na)
                            }
                            ha = false
                        } else ha = true;
                        if (f) if (O.no.test(f) || O.px.test(f)) {
                            Oa = h = G(N(f), Pa, Qa);
                            ia = false
                        } else ia = true;
                        if (e == "auto" || !e || f == "auto" || !f) {
                            var b = Number(b),
                                t = y.filter(function () {
                                    return d(this).data("state") != "error"
                                }).filter(":first").data("srcKey");
                            if (isNaN(b) || !b) {
                                b = null;
                                if (t) b = j[t].imgRatio
                            }
                            if (b) {
                                Ya = Za = z = b;
                                if (t) {
                                    if (e == "auto" || !e) {
                                        ra = g = G(N(j[t].imgWidth), sa, Na);
                                        ha = true
                                    }
                                    if (f == "auto" || !f) {
                                        Oa = h = G(N(j[t].imgHeight), Pa, Qa);
                                        ia = true
                                    }
                                }
                                if (ia && b && !ha) Oa = h = G(Math.round(g / b), Pa, Qa);
                                if (!ia && b && ha) ra = g = G(Math.round(h * b), sa, Na)
                            }
                        }
                    }, fa = function (e, f, b) {
                        var t;
                        if (a().fitToWindowHeight || r) t = J.height();
                        if (!z || e) Ya = Za = z = g / h;
                        a().thumbs && !L && (L = a().vertical ? x.width() : x.height());
                        z = Fa ? Ya : Za;
                        c.css({
                            overflow: ta || r ? "hidden" : ""
                        });
                        if (ta || r) {
                            g = c.width() * (r ? 1 : rb) - (a().vertical && L && (!r || !a().hideNavIfFullscreen) ? L : 0);
                            r || (g = G(g, sa, Na))
                        } else ra && (g = ra);
                        h = r ? t - (!a().vertical && L && !a().hideNavIfFullscreen ? L : 0) : ia ? G(Math.round(g / z), Pa, Qa) : Oa;
                        z = g / h;
                        if (a().fitToWindowHeight && !r) {
                            t = t - a().fitToWindowHeightMargin - (!a().vertical && L ? L : 0);
                            if (h > t) {
                                h = G(t, Pa, Qa);
                                z = g / h
                            }
                        }
                        f || (f = 0);
                        t = g != Ba || h != Ca || z != Da;
                        if (e || t) {
                            if (a().vertical) {
                                u = h;
                                $a = g
                            } else {
                                u = g;
                                $a = h
                            }
                            m.add(y).animate({
                                width: g,
                                height: h
                            }, f);
                            a().thumbs && a().vertical && (a().thumbsOnRight ? x.animate({
                                left: g
                            }, f) : m.animate({
                                left: !r || !a().hideNavIfFullscreen ? L : 0
                            }, f));
                            if (a().touchStyle) {
                                sb = (u + a().margin) * w - a().margin;
                                Lb = $a;
                                e = {};
                                e[P] = sb;
                                e[X] = Lb;
                                C.animate(e, f).data(e).data({
                                    minPos: -(sb - u),
                                    maxPos: 0
                                })
                            } else C.animate({
                                width: g,
                                height: h
                            }, f);
                            if (a().thumbs) {
                                a().vertical ? x.animate({
                                    height: h
                                }, f) : x.animate({
                                    width: g
                                }, f);
                                a().thumbsPreview && t && da(f, b);
                                x.css({
                                    visibility: "visible"
                                })
                            }
                            if (qa && !a().vertical) {
                                a().arrows && ja.animate({
                                    top: h / 2
                                }, f);
                                e = {};
                                e[ab] = $a / 2;
                                Q.animate(e,
                                f)
                            }
                            if (bb == "loading" || bb == "error") {
                                e = {};
                                e[F] = (a().touchStyle ? A : 0) * (u + a().margin) + u / 2;
                                Q.animate(e, f)
                            }
                            if (D && a().touchStyle) {
                                b = -A * (u + a().margin);
                                pa(C, b, 0)
                            }
                            Ea = true;
                            var o = 0;
                            d(tb).each(function () {
                                clearTimeout(this)
                            });
                            tb = [];
                            Ra(D, A, f);
                            y.each(function (a) {
                                if (a != A) {
                                    var e = d(this);
                                    e.data("img") && e.data("img").css({
                                        visibility: "hidden"
                                    });
                                    var f = setTimeout(function () {
                                        Ra(e, a)
                                    }, o * 50 + 50);
                                    tb.push(f);
                                    o++
                                }
                            })
                        }
                        Ba = g;
                        Ca = h;
                        Da = z
                    }, S = function () {
                        var e = D.data("srcKey");
                        if (e && j[e].imgWidth && j[e].imgHeight && j[e].imgRatio) {
                            ra = g = j[e].imgWidth;
                            Oa = h = j[e].imgHeight;
                            Za = z = j[e].imgRatio;
                            fa(false, a().transitionDuration)
                        }
                    }, T = function (e, f, d) {
                        function t() {
                            a().touchStyle || (f = 0);
                            Q.css(F, f * (u + a().margin) + u / 2);
                            Mb = setTimeout(function () {
                                Q.stop().show().fadeTo(0, 1)
                            }, 100)
                        }
                        function o() {
                            Q.css({
                                backgroundPosition: "0 -" + jb * cb + "px"
                            });
                            cb++;
                            cb >= $b && (cb = 0)
                        }
                        clearTimeout(Mb);
                        clearInterval(Nb);
                        if (e == "loading") {
                            t();
                            c.addClass(b + "_loading").removeClass(b + "_error");
                            Ia ? Nb = setInterval(o, ac) : Q.html("<span>&middot;&middot;&middot;</span>").css({
                                backgroundImage: "none"
                            })
                        } else if (e == "error") {
                            t();
                            c.addClass(b + "_error").removeClass(b + "_loading");
                            Ia || Q.html("<span>?</span>").css({
                                backgroundImage: "none"
                            })
                        } else if (e == "loaded") {
                            c.removeClass(b + "_loading " + b + "_error");
                            Q.stop().fadeTo(Math.min(333, qa ? 0 : d), 0, function () {
                                Q.hide()
                            })
                        }
                        bb = e
                    }, K = function () {
                        return {
                            index: A,
                            src: j[A],
                            img: D[0],
                            thumb: a().thumbs ? ka[0] : null,
                            caption: ub
                        }
                    }, U = function () {
                        a().onTransitionStop && a().onTransitionStop.call(c[0], K())
                    }, pa = function (e, f, b, c) {
                        var d = isNaN(f) ? 0 : Math.round(f);
                        clearInterval(e.data("backAnimate"));
                        if (c) {
                            d = c;
                            $ && a().cssTransitions && e.data({
                                backAnimate: setInterval(function () {
                                    var d = Fb(e, F, a().cssTransitions);
                                    Math.abs(d - c) < 1 && pa(e, f, Math.max(333, b / 2))
                                }, 10)
                            })
                        } else setTimeout(function () {
                            U()
                        }, b + 10);
                        if (b) {
                            clearTimeout(Ob);
                            qb = true
                        }
                        if ($ && a().cssTransitions) {
                            e.css(za(b));
                            setTimeout(function () {
                                e.css(ya(d, a().vertical))
                            }, 1)
                        } else e.stop().animate(ya(d, a().vertical, !a().cssTransitions), b, nb, function () {
                            c && pa(e, f, Math.max(333, b / 2))
                        });
                        Ob = setTimeout(function () {
                            qb = false;
                            a().flexible && e == C && S()
                        }, b)
                    }, ca = function () {
                        if (V > u || !a().thumbsCentered) {
                            s.data({
                                minPos: V > u ? -(V - u) : a().thumbMargin
                            });
                            ga || s.data({
                                maxPos: a().thumbMargin
                            })
                        } else {
                            var e = u / 2 - V / 2;
                            s.data({
                                minPos: e
                            });
                            ga || s.data({
                                maxPos: e
                            })
                        }
                    }, aa = function (e, f, b) {
                        e = e * 1.1;
                        if (V) {
                            if (!b || V < u) db = false;
                            var c = ka.position()[F],
                                b = ka.data()[P];
                            ca();
                            if (!b && eb) {
                                la.hide();
                                eb = false
                            } else {
                                if (!eb) {
                                    la.show();
                                    eb = true
                                }
                                if (V > u) {
                                    var d = c + b / 2,
                                        E = u / 2,
                                        v = I.index(ka),
                                        k = v - Pb;
                                    W == void 0 && (W = s.position()[F]);
                                    if (vb && f && f > Math.max(36, a().thumbMargin * 2) && f < u - Math.max(36, a().thumbMargin * 2) && (k > 0 && f > E * 0.75 || k < 0 && f < E * 1.25)) {
                                        var g;
                                        g = k > 0 ? v + 1 : v - 1;
                                        g < 0 ? g = 0 : g > w - 1 && (g = w - 1);
                                        if (v != g) {
                                            d = I.eq(g);
                                            d = d.position()[F] + d.data()[P] / 2;
                                            E = f
                                        }
                                    }
                                    f = Math.round(-(d - E) + a().thumbMargin);
                                    if (k > 0 && f > W || k < 0 && f < W) f = c + W < a().thumbMargin ? -(c - a().thumbMargin) : c + W + b > u ? -(c * 2 - u + b + a().thumbMargin) : W;
                                    if (f <= s.data("minPos")) f = s.data("minPos");
                                    else if (f >= a().thumbMargin) f = a().thumbMargin;
                                    ba(f);
                                    ga || s.data({
                                        maxPos: a().thumbMargin
                                    })
                                } else f = s.data("minPos");
                                if (!db && !ga) {
                                    pa(s, f, e, false);
                                    fb && (db = true);
                                    W = f
                                } else fb = true;
                                var j = b - (mb ? 0 : a().thumbBorderWidth * 2),
                                    e = e * 0.9;
                                if ($ && a().cssTransitions) {
                                    la.css(za(e));
                                    setTimeout(function () {
                                        la.css(ya(c, a().vertical)).css(P, j)
                                    }, 1)
                                } else a().vertical ? la.stop().animate({
                                    top: c,
                                    height: j
                                }, e, nb) : la.stop().animate({
                                    left: c,
                                    width: j
                                }, e, nb)
                            }
                        }
                    }, ba = function (e) {
                        if (a().shadows) if (V > u) {
                            x.addClass(b + "__thumbs_shadow");
                            e <= s.data("minPos") ? x.removeClass(b + "__thumbs_shadow_no-left").addClass(b + "__thumbs_shadow_no-right") : e >= a().thumbMargin ? x.removeClass(b + "__thumbs_shadow_no-right").addClass(b + "__thumbs_shadow_no-left") : x.removeClass(b + "__thumbs_shadow_no-left " + b + "__thumbs_shadow_no-right")
                        } else x.removeClass(b + "__thumbs_shadow")
                    }, da = function (a, f) {
                        V = s[P]();
                        ca();
                        aa(a ? a : 0, false, !f)
                    }, Ra = function (e, f, b) {
                        var c = e.data("img"),
                            d = e.data("detached"),
                            b = b ? b : 0;
                        if (c && !d) {
                            var E = e.data("srcKey"),
                                d = j[E].imgWidth,
                                v = j[E].imgHeight,
                                k = j[E].imgRatio,
                                n = E = 0;
                            a().touchStyle && e.css(F, f * (u + a().margin));
                            if (d != g || v != h || a().alwaysPadding || r) {
                                var p = 0;
                                if (k / z < 0.99 || k / z > 1.01 || a().alwaysPadding || r) p = a().minPadding * 2;
                                if (k >= z) if (!r && !a().cropToFit || r && !a().cropToFitIfFullscreen) {
                                    d = Math.round(g - p) < d || a().zoomToFit || r ? Math.round(g - p) : d;
                                    v = Math.round(d / k);
                                    h - v < 4 && (v = v + (h - v))
                                } else {
                                    v = h;
                                    d = Math.round(v * k)
                                } else if (!r && !a().cropToFit || r && !a().cropToFitIfFullscreen) {
                                    v = Math.round(h - p) < v || a().zoomToFit || r ? Math.round(h - p) : v;
                                    d = Math.round(v * k);
                                    g - d < 4 && (d = d + (g - d))
                                } else {
                                    d = g;
                                    v = Math.round(d / k)
                                }
                            }
                            if (d && v) {
                                k = {
                                    width: d,
                                    height: v
                                };
                                v != h && (E = Math.round((h - v) / 2));
                                d != g && (n = Math.round((g - d) / 2));
                                c.attr(k);
                                k.top = E;
                                k.left = n;
                                c.animate(k, b)
                            }
                            c.css({
                                visibility: "visible"
                            });
                            b = e.data("img");
                            c = e.data("srcKey");
                            f = j[f].imgRel;
                            if (b && f && f != c && !Ha) {
                                d = b.data("full");
                                e = e.data("detached");
                                if ((r && !d || !r && d) && !e) {
                                    b[0].src = r ? f : c;
                                    b.data({
                                        full: r
                                    })
                                }
                            }
                        } else c && d && e.data({
                            needToResize: true
                        })
                    }, oa = function (e, f, c, t) {
                        function o(d) {
                            function p() {
                                v.css({
                                    visibility: "hidden"
                                });
                                g.src = d;
                                if (n == 0) {
                                    v.appendTo(f);
                                    if (t == "thumb") {
                                        var e = a().vertical ? Math.round(H / (a().aspectRatio ? a().aspectRatio : z ? z : 1)) : Math.round(H * (a().aspectRatio ? a().aspectRatio : z ? z : 1));
                                        f.css(P, e).data(P, e);
                                        da()
                                    }
                                }
                            }
                            function h() {
                                O.i.test(d) || (ua[d] = "loaded");
                                v.unbind("error load").error(function () {
                                    v.unbind("error");
                                    g.src = d;
                                    j[e].imgRel = false;
                                    Ra(y.eq(e), e)
                                });
                                f.trigger(b + "load").data({
                                    state: "loaded"
                                });
                                setTimeout(function () {
                                    if (!j[d]) {
                                        j[d] = [];
                                        j[d].imgWidth = v.width();
                                        if (!j[d].imgWidth) j[d].imgWidth = f.data("html") ? f.data("html").width() || Hb : Hb;
                                        j[d].imgHeight = v.height();
                                        if (!j[d].imgHeight) j[d].imgHeight = f.data("html") ? f.data("html").height() || Ib : Ib;
                                        j[d].imgRatio = j[d].imgWidth / j[d].imgHeight
                                    }
                                    c(g, j[d].imgWidth, j[d].imgHeight, j[d].imgRatio, d, e)
                                }, 100);
                                if (t == "thumb") {
                                    gb++;
                                    gb == w && (vb = true)
                                }
                            }
                            function u() {
                                kb(t == "img" ? m : x, h)
                            }

                            function l(a) {
                                ua[d] = "error";
                                v.unbind("error load");
                                if (n < k.length && a) {
                                    n++;
                                    O.i.test(k[n]) && l(true);
                                    o(k[n])
                                } else {
                                    f.trigger(b + "error").data({
                                        state: "error"
                                    });
                                    if (t == "thumb") {
                                        gb++;
                                        gb == w && (vb = true)
                                    }
                                }
                            }
                            if (ua[d]) {
                                var q = function () {
                                    ua[d] == "error" ? l(false) : ua[d] == "loaded" ? u() : setTimeout(q, 100)
                                };
                                p();
                                q()
                            } else if (O.i.test(d)) u();
                            else {
                                ua[d] = "loading";
                                v.unbind("error load").bind("error", function () {
                                    l(true)
                                }).bind("load", u);
                                p()
                            }
                        }
                        var g = new Image,
                            v = d(g),
                            k = [],
                            n = 0,
                            p = j[e].imgHref === " " ? "\u0451" + e : j[e].imgHref,
                            h = j[e].imgSrc === " " ? "\u0451" + e : j[e].imgSrc,
                            u = j[e].thumbSrc === " " ? "\u0451" + e : j[e].thumbSrc,
                            l = t == "img" ? "push" : "unshift";
                        if (p) k[l](p);
                        if (h) k[l](h);
                        if (u) k[l](u);
                        o(k[n])
                    }, ea = function (e, f) {
                        if (e.data("wraped")) {
                            if (a().detachSiblings && e.data("detached")) {
                                e.data({
                                    detached: false
                                }).appendTo(C);
                                if (e.data("needToResize")) {
                                    Ra(e, f);
                                    e.data({
                                        needToResize: false
                                    })
                                }
                            }
                        } else {
                            C.append(e.data({
                                state: "loading"
                            }));
                            f != A && !a().touchStyle && e.stop().fadeTo(0, 0);
                            e.data({
                                wraped: true,
                                detached: false
                            });
                            if (wb && M[f].html && M[f].html.length || a().html && a().html[f] && a().html[f].length) {
                                var c = M[f].html || a().html[f];
                                qa && (a().html[f] && a()._html[f]) && c.html(a()._html[f]);
                                e.append(c).data({
                                    html: d(c)
                                });
                                c = d("iframe", e);
                                c.size() && c.each(function () {
                                    var a = d(this).clone(),
                                        e = a.attr("src"),
                                        b = e.indexOf("?") > 0 ? "&" : "?";
                                    a.attr("src", e + b + "wmode=opaque").addClass("js-opaque");
                                    d(this).after(a).remove()
                                });
                                c = d("object", e);
                                c.size() && c.each(function () {
                                    var a = d(this).clone();
                                    a.addClass("js-opaque");
                                    d('<param name="wmode" value="opaque">').appendTo(a);
                                    d("embed", a).attr({
                                        wmode: "opaque"
                                    });
                                    d(this).after(a).remove()
                                })
                            }
                            oa(f, e, function (c, o, n, v, k) {
                                c = d(c);
                                c.addClass(b + "__img");
                                e.data({
                                    img: c,
                                    srcKey: k
                                });
                                k = false;
                                if ((!g || !h) && !Ea || !xb && f == a().startImg) {
                                    g = o;
                                    a().width = o;
                                    if (ia) {
                                        h = n;
                                        a().height = n
                                    } else if (ha) {
                                        g = Math.round(h * (o / n));
                                        a().width = g
                                    }
                                    if (!a().aspectRatio) a().aspectRatio = g / h;
                                    k = true;
                                    xb = f == a().startImg
                                }
                                k || a().flexible ? fa(true) : Ra(e, f);
                                e.css({
                                    visibility: "visible"
                                })
                            }, "img")
                        }
                    }, yb = function (e) {
                        e || (e = 0);
                        clearTimeout(Qb);
                        Qb = setTimeout(function () {
                            D.data("state") != "loading" ? va && c.trigger("showimg", [A + 1, false, true]) : D.bind(b + "load " + b + "error", function () {
                                yb(e)
                            })
                        }, Math.max(a().autoplay, e * 2))
                    }, Y = function (e, f, g, t, o, n, v, k) {
                        function j() {
                            if (a().caption)(ub = M[m].caption ? M[m].caption : M[m].title) ? ma.html(ub).show() : ma.html("").hide()
                        }
                        function p() {
                            if (a().shadows || !a().touchStyle) {
                                h.removeClass(b + "__frame_active");
                                e.addClass(b + "__frame_active")
                            }
                        }
                        var h, l, q, m = y.index(e);
                        y.each(function () {
                            d(this).unbind(b + "load " + b + "error")
                        });
                        typeof o != "number" && (o = t ? 0 : a().transitionDuration);
                        !t && (f && f.altKey) && (o = o * 10);
                        f = e.data("state");
                        if (f == "loading" || !f) {
                            T("loading", m, o);
                            e.one(b + "load", function () {
                                T("loaded", m, o);
                                j()
                            });
                            e.one(b + "error", function () {
                                T("error", m, o);
                                j()
                            })
                        } else f == "error" ? T("error", m, o) : f != bb && T("loaded", m, 0);
                        j();
                        if (D) {
                            h = D;
                            q = A;
                            a().thumbs && (l = ka)
                        } else {
                            h = y.not(e);
                            a().thumbs && (l = I.not(I.eq(m)))
                        }
                        if (a().thumbs) {
                            ka = I.eq(m);
                            q && (Pb = q);
                            l.removeClass(b + "__thumb_selected").data("disabled", false);
                            ka.addClass(b + "__thumb_selected").data("disabled", true)
                        }
                        a().thumbs && (a().thumbsPreview && (q != m || t)) && aa(o, g);
                        if (a().touchStyle) {
                            g = -m * (u + a().margin);
                            p();
                            pa(C, g, o, n)
                        } else if (a().transition == "crossFade") {
                            y.not(h.stop()).stop().fadeTo(0, 0);
                            e.stop().fadeTo(o, 1);
                            h.not(e).stop().fadeTo(o, 0, function () {
                                U();
                                a().flexible && S()
                            })
                        } else {
                            var s = function (b) {
                                if (q != m || t) {
                                    var f = o,
                                        c = 0;
                                    if (b) {
                                        f = 0;
                                        c = o
                                    }
                                    y.not(h.stop()).stop().fadeTo(0, 0);
                                    setTimeout(function () {
                                        p();
                                        e.stop().fadeTo(f, 1, function () {
                                            h.not(e).stop().fadeTo(c, 0, function () {
                                                a().flexible && S()
                                            });
                                            U()
                                        })
                                    }, 10)
                                }
                            };
                            if (f == "loaded") s();
                            else if (f == "error") s(true);
                            else {
                                e.one(b + "load", function () {
                                    s()
                                });
                                e.one(b + "error",

                                function () {
                                    s(true)
                                })
                            }
                        }
                        D = e;
                        A = m;
                        a().hash && location.replace(location.protocol + "//" + location.host + location.pathname + location.search + "#" + (A + 1));
                        va && (!v && a().stopAutoplayOnAction) && (va = false);
                        yb(o);
                        var x = K();
                        c.data(x);
                        if (a().arrows) {
                            (A == 0 || w < 2) && !a().loop ? Sa.addClass(b + "__arr_disabled").data("disabled", true) : Sa.removeClass(b + "__arr_disabled").data("disabled", false);
                            (A == w - 1 || w < 2) && !a().loop ? Ta.addClass(b + "__arr_disabled").data("disabled", true) : Ta.removeClass(b + "__arr_disabled").data("disabled", false)
                        }
                        var z = e.data("wraped");
                        clearTimeout(Rb);
                        Rb = setTimeout(function () {
                            if (!z && m != a().startImg) {
                                ea(e, m);
                                a().onShowImg && !k && a().onShowImg.call(c[0], x, v)
                            }
                            var b = m,
                                f = 0,
                                t = false,
                                o = [],
                                g = [],
                                n = r ? Math.min(1, a().preload) : a().preload;
                            for (i = 0; i < n * 2 + 1; i++) {
                                var h = b - n + i;
                                if (h >= 0 && h < w && !a().loop || a().loop) {
                                    h < 0 && (h = w + h);
                                    h > w - 1 && (h = h - w);
                                    if (!y.eq(h).data("wraped") || y.eq(h).data("detached")) {
                                        f++;
                                        o.push(h)
                                    }
                                    g.push(h)
                                } else t = true
                            }
                            if (f >= n || t) {
                                d(o).each(function (a) {
                                    setTimeout(function () {
                                        ea(y.eq(o[a]), o[a])
                                    }, a * 50)
                                });
                                a().detachSiblings && y.filter(function (a) {
                                    for (var e = d(this), f = false, c = 0; c < g.length && !f; c++) g[c] == a && (f = true);
                                    return e.data("state") != "loading" && !f && b != a
                                }).data({
                                    detached: true
                                }).detach()
                            }
                        }, (o ? Math.max(o / 2, 333) : 0) * 1.1);
                        if (z || m == a().startImg) {
                            ea(e, m);
                            a().onShowImg && !k && a().onShowImg.call(c[0], x, v)
                        }
                    }, Z = function (e, b) {
                        b.stopPropagation();
                        b.preventDefault();
                        var c = A + e;
                        c < 0 && (c = a().loop ? w - 1 : 0);
                        c > w - 1 && (c = a().loop ? 0 : w - 1);
                        Y(y.eq(c), b)
                    }, zb = function (a, b) {
                        clearTimeout(Sb);
                        Sb = setTimeout(function () {
                            fa(b)
                        }, 100)
                    }, wa = function () {
                        if (!Ga) {
                            J.bind("resize", zb);
                            n && window.addEventListener("orientationchange",
                            zb, false);
                            Ga = true
                        }
                    }, Ab = function (a) {
                        a.stopPropagation();
                        if (!d(this).data("disabled")) {
                            var b = I.index(d(this)),
                                c = a[R] - x.offset()[F];
                            Y(y.eq(b), a, c)
                        }
                    }, xa = function (e, b, c, d) {
                        function o(c) {
                            if ((n || c.which < 2) && D) {
                                var d = function () {
                                    q = (new Date).getTime();
                                    p = m;
                                    l = j;
                                    s = [
                                        [q, m]
                                    ];
                                    clearInterval(e.data("backAnimate"));
                                    $ && a().cssTransitions ? e.css(za(0)) : e.stop();
                                    k = Fb(e, F, a().cssTransitions);
                                    e.css(ya(k, a().vertical, !a().cssTransitions));
                                    u = k;
                                    b();
                                    C = false
                                };
                                if (n) if (n && c.targetTouches.length == 1) {
                                    m = c.targetTouches[0][R];
                                    j = c.targetTouches[0][hb];
                                    d();
                                    e[0].addEventListener("touchmove", g, false);
                                    e[0].addEventListener("touchend", h, false)
                                } else {
                                    if (n && c.targetTouches.length > 1) return false
                                } else {
                                    m = c[R];
                                    c.preventDefault();
                                    d();
                                    Ka.mousemove(g);
                                    Ka.mouseup(h)
                                }
                            }
                        }
                        function g(b) {
                            function f() {
                                b.preventDefault();
                                r = (new Date).getTime();
                                s.push([r, m]);
                                var d = p - m;
                                k = u - d;
                                if (k > e.data("maxPos")) {
                                    k = Math.round(k + (e.data("maxPos") - k) / 1.5);
                                    B = "left"
                                } else if (k < e.data("minPos")) {
                                    k = Math.round(k + (e.data("minPos") - k) / 1.5);
                                    B = "right"
                                } else B = false;
                                a().touchStyle && e.css(ya(k, a().vertical, !a().cssTransitions));
                                c(k, d, B)
                            }
                            if (n) {
                                if (n && b.targetTouches.length == 1) {
                                    m = b.targetTouches[0][R];
                                    j = b.targetTouches[0][hb];
                                    if (A) y === true && f();
                                    else if (Math.abs(m - p) - Math.abs(j - l) >= -5) {
                                        A = y = true;
                                        b.preventDefault()
                                    } else if (Math.abs(j - l) - Math.abs(m - p) >= -5) {
                                        y = "prevent";
                                        A = true
                                    }
                                }
                            } else {
                                m = b[R];
                                f()
                            }
                        }
                        function h(a) {
                            if ((!n || !a.targetTouches.length) && C === false) {
                                if (n) {
                                    e[0].removeEventListener("touchmove", g, false);
                                    e[0].removeEventListener("touchend", h, false)
                                } else {
                                    Ka.unbind("mouseup");
                                    Ka.unbind("mousemove")
                                }
                                w = (new Date).getTime();
                                for (var b = -k, f = w - Ja, c, o, j, p, l = 0; l < s.length; l++) {
                                    c = Math.abs(f - s[l][0]);
                                    if (l == 0) {
                                        o = c;
                                        j = w - s[l][0];
                                        p = s[l][1]
                                    }
                                    if (c <= o) {
                                        o = c;
                                        j = s[l][0];
                                        p = s[l][1]
                                    }
                                }
                                f = p - m;
                                c = f >= 0;
                                j = w - j;
                                d(b, j, j <= Ja, w - z, c === x, f, a, y);
                                z = w;
                                x = c;
                                A = y = false;
                                C = true
                            }
                        }
                        var k, m, j, p, l, u, q, s = [],
                            r, x, w, z = 0,
                            y = false,
                            A = false,
                            B = false,
                            C;
                        n ? e[0].addEventListener("touchstart", o, false) : e.mousedown(o);
                        n && J.scroll(function () {
                            h({
                                targetTouches: []
                            })
                        })
                    }, a = function () {
                        return c.data("options")
                    };
                    if (a().backgroundColor && !a().background) a().background = a().backgroundColor;
                    if (a().thumbsBackgroundColor && !a().navBackground) a().navBackground = a().thumbsBackgroundColor;
                    if (a().thumbColor && !a().dotColor) a().dotColor = a().thumbColor;
                    if (a().click !== null) a().pseudoClick = a().click;
                    if (a().nav === true || a().nav == "true" || a().nav == "thumbs") {
                        a().thumbs = true;
                        a().thumbsPreview = true
                    } else if (a().nav == "dots") {
                        a().thumbs = true;
                        a().thumbsPreview = false
                    } else if (a().nav === false || a().nav == "false" || a().nav == "none") a().thumbs = false;
                    if (a().transition === "fade" || a().transition === "crossFade") a().touchStyle = false;
                    if (a().cropToFit) a().cropToFitIfFullscreen = true;
                    if (a().thumbsPreview && a().background && !a().navBackground) a().navBackground = a().background;
                    if (a().caption) if (a().caption === true || a().caption == "true" || a().caption == "simple") a().caption = true;
                    else if (a().caption != "overlay") a().caption = false;
                    if (a().navPosition == "top") {
                        a().thumbsOnTop = true;
                        a().thumbsOnRight = false
                    } else if (a().navPosition == "right") {
                        a().thumbsOnTop = false;
                        a().thumbsOnRight = true
                    } else if (a().navPosition == "bottom") {
                        a().thumbsOnTop = false;
                        a().thumbsOnRight = false
                    } else if (a().navPosition == "left") {
                        a().thumbsOnTop = false;
                        a().thumbsOnRight = false
                    }
                    var bb;
                    if (a().hash && document.location.hash) a().startImg = parseInt(document.location.hash.replace("#", "")) - 1;
                    var M, wb = a().data && (typeof a().data == "object" || typeof a().data == "string");
                    M = wb ? d(a().data).filter(function () {
                        return this.img || this.img === " " || this.href || this.href === " "
                    }) : c.children().each(function () {
                        var a = d(this),
                            b = a.children("img");
                        (!(a.is("a") && b.length || a.is("img")) || !a.attr("href") && !(a.attr("href") === " " || a.attr("src") || a.attr("src") === " " || b.attr("src") || b.attr("src") === " ")) && a.data({
                            html: true
                        })
                    });
                    var w = M.size();
                    c.data({
                        size: w
                    });
                    a().preload = Math.min(a().preload, w);
                    if (a().startImg > w - 1 || typeof a().startImg != "number") a().startImg = 0;
                    var j = [];
                    M.each(function (b) {
                        if (wb) j[b] = {
                            imgHref: this.img ? this.img : this.href ? this.href : this.length ? String(this) : null,
                            thumbSrc: this.thumb,
                            imgRel: this.full
                        };
                        else {
                            var c = d(this);
                            if (c.data("html")) {
                                j[b] = {
                                    imgHref: c.attr("data-img") || " ",
                                    thumbSrc: c.attr("data-thumb"),
                                    imgRel: c.attr("data-full")
                                };
                                this.caption = this.caption || c.attr("data-caption");
                                if (!a().html) a().html = {};
                                a().html[b] = c;
                                if (qa) {
                                    if (!a()._html) a()._html = {};
                                    a()._html[b] = c.html()
                                }
                            } else {
                                var g = c.children();
                                j[b] = {
                                    imgHref: c.attr("href"),
                                    imgSrc: c.attr("src"),
                                    thumbSrc: g.attr("src"),
                                    imgRel: c.attr("rel") ? c.attr("rel") : g.attr("rel")
                                };
                                this.caption = c.attr("alt") || g.attr("alt")
                            }
                        }
                    });
                    c.html("").addClass(b + " " + (a().vertical ? b + "_vertical" : b + "_horizontal"));
                    mb && c.addClass(b + "_quirks");
                    if (lb || Ha) var Ua = c.wrap('<div class="' + b + '-outer"></div>').parent();
                    if (!a().arrows) a().loop = true;
                    var ua = [],
                        u, $a,
                        g, h, ra, Oa, sa = N(a().minWidth),
                        Na = N(a().maxWidth),
                        Pa = N(a().minHeight),
                        Qa = N(a().maxHeight),
                        rb = 1,
                        ia = true,
                        ha = true,
                        ta, O = {
                            no: /^[0-9.]+$/,
                            px: /^[0-9.]+px$/,
                            "%": /^[0-9.]+%$/,
                            i: /^\u0451\d+$/
                        }, z, Za, Ya, Ba, Ca, Da, Ea, xb, Fa, r, Ga, qb, Ob, Tb, Ub, Rb, va, Qb;
                    if (a().autoplay === true || a().autoplay == "true" || a().autoplay > 0) va = true;
                    if (typeof a().autoplay != "number") a().autoplay = 5E3;
                    if (a().touchStyle) var sb = 0,
                        Lb, La = false,
                        Xa = false,
                        Vb;
                    if (a().thumbs && a().thumbsPreview) var ga = false,
                        db = false,
                        fb = false,
                        Ma = false,
                        Wb, vb = false,
                        gb = 0;
                    var F, ab,
                    R, hb, P, X;
                    if (a().vertical) {
                        F = "top";
                        ab = "left";
                        R = "pageY";
                        hb = "pageX";
                        P = "height";
                        X = "width"
                    } else {
                        F = "left";
                        ab = "top";
                        R = "pageX";
                        hb = "pageY";
                        P = "width";
                        X = "height"
                    }
                    var m = d('<div class="' + b + '__wrap"></div>').appendTo(c),
                        C = d('<div class="' + b + '__shaft"></div>').appendTo(m);
                    if (!a().touchStyle) {
                        Va(m);
                        Va(C)
                    }
                    var Q = d('<div class="' + b + '__state"></div>').appendTo(C);
                    d('<div class="' + b + '__noise"></div>').prependTo(m);
                    Ia || Q.addClass(b + "__state_quirks");
                    var Mb, Nb, cb = 0,
                        jb = 32,
                        $b = 12,
                        ac = 83;
                    if (a().fullscreenIcon && !a().fullscreen) var na = d('<div class="' + b + '__fsi"><i class="i1"><i class="i1"></i></i><i class="i2"><i class="i2"></i></i><i class="i3"><i class="i3"></i></i><i class="i4"><i class="i4"></i></i><i class="i0"></i></div>').appendTo(m);
                    n && c.addClass(b + "_touch");
                    if (Ha) a().shadows = false;
                    a().touchStyle ? m.addClass(b + "__wrap_style_touch") : m.addClass(b + "__wrap_style_fade");
                    a().shadows && c.addClass(b + "_shadows");
                    $ && a().cssTransitions && c.addClass(b + "_csstransitions");
                    if (a().arrows) {
                        var Bb, Cb;
                        if (a().vertical) {
                            Bb = a().arrowPrev ? a().arrowPrev : "&#9650;";
                            Cb = a().arrowNext ? a().arrowNext : "&#9660;"
                        } else {
                            Bb = a().arrowPrev ? a().arrowPrev : "&#9664;";
                            Cb = a().arrowNext ? a().arrowNext : "&#9654;"
                        }
                        var ja = d('<i class="' + b + "__arr " + b + '__arr_prev">' + Bb + '</i><i class="' + b + "__arr " + b + '__arr_next">' + Cb + "</i>").appendTo(m),
                            Sa = ja.eq(0),
                            Ta = ja.eq(1);
                        Va(ja);
                        var Xb, Yb;
                        n || a().pseudoClick && m.mousemove(function (e) {
                            Xb = e[R] - m.offset()[F];
                            clearTimeout(Yb);
                            Yb = setTimeout(function () {
                                var e = Xb >= u / 2;
                                Ta[!e ? "removeClass" : "addClass"](b + "__arr_hover");
                                Sa[e ? "removeClass" : "addClass"](b + "__arr_hover");
                                a().touchStyle || C.css({
                                    cursor: e && Ta.data("disabled") || !e && Sa.data("disabled") ? "default" : "pointer"
                                })
                            }, 10)
                        })
                    } else !a().touchStyle && (a().pseudoClick && w > 1) && C.css({
                        cursor: "pointer"
                    });
                    var pb = false,
                        Jb;
                    if (!n) {
                        m.mouseenter(function () {
                            pb = true;
                            clearTimeout(Jb);
                            a().arrows && ja.css(za(0));
                            m.removeClass(b + "__wrap_mouseout");
                            setTimeout(function () {
                               // a().arrows && ja.css(za(a().transitionDuration));
                                setTimeout(function () {
                                    m.addClass(b + "__wrap_mouseover")
                                }, 1)
                            }, 1)
                        });
                        m.mouseleave(function () {
                            pb = false;
                            p()
                        })
                    }
                    var D,
                    A, ub, y = d();
                    M.each(function () {
                        var a = d('<div class="' + b + '__frame" style="visibility: hidden;"></div>');
                        y = y.add(a)
                    });
                    if (a().thumbs) {
                        var H = Number(a().thumbSize);
                        if (isNaN(H) || !H) H = a().vertical ? 64 : 48;
                        var ka, Pb = 0,
                            x = d('<div class="' + b + '__thumbs" style="visibility: hidden;"></div>')[a().thumbsOnTop ? "prependTo" : "appendTo"](c),
                            L, s = d('<div class="' + b + '__thumbs-shaft"></div>').appendTo(x);
                        a().touchStyle || Va(x);
                        if (a().thumbsPreview) {
                            L = H + a().thumbMargin * 2;
                            x.addClass(b + "__thumbs_previews").css(X, L);
                            var V = 0,
                                W = void 0,
                                bc = H - (mb ? 0 : a().thumbBorderWidth * 2),
                                cc = a().thumbMargin,
                                ib = {};
                            ib[X] = bc;
                            ib[ab] = cc;
                            ib.borderWidth = a().thumbBorderWidth;
                            var la = d('<i class="' + b + '__thumb-border"></i>').css(ib).appendTo(s),
                                eb
                        }
                        var Kb = a().vertical && x ? x.width() : 0;
                        c.css({
                            minWidth: sa + Kb
                        });
                        M.each(function () {
                            var e;
                            if (a().thumbsPreview) {
                                e = d('<div class="' + b + '__thumb"></div>');
                                var c = {};
                                c[X] = H;
                                c.margin = a().thumbMargin;
                                e.css(c)
                            } else e = d('<i class="' + b + '__thumb"><i class="' + b + '__thumb__dot"></i></i>');
                            e.appendTo(s)
                        });
                        var I = d("." + b + "__thumb", c)
                    }
                    if (a().caption) {
                        var ma = d('<p class="' + b + '__caption"></p>');
                        if (a().caption == "overlay") ma.appendTo(m).addClass(b + "__caption_overlay");
                        else {
                            ma.appendTo(c);
                            var dc = ma.wrap('<div class="' + b + '__caption-outer"></div>').parent()
                        }
                    }
                    B(a().width, a().height, a().aspectRatio);
                    var tb = [];
                    Y(y.eq(a().startImg), false, false, true, false, false, true);
                    if (g && h) {
                        xb = true;
                        fa()
                    }
                    a().thumbs && a().thumbsPreview && l(0);
                    if (a().thumbs) {
                        a().dotColor && !a().thumbsPreview && I.children().css({
                        //    backgroundColor: a().dotColor
                        });
                        a().navBackground && x.css({
                            background: a().navBackground
                        });
                        a().thumbsPreview && a().thumbBorderColor && la.css({
                            borderColor: a().thumbBorderColor
                        })
                    }
                    a().background && m.add(a().touchStyle ? false : y).css({
                        background: a().background
                    });
                    a().arrowsColor && a().arrows && ja.css({
                        color: a().arrowsColor
                    });
                    var Sb = false;
                    wa();
                    c.bind("dblclick", Zb);
                    c.bind("showimg", function (b, c, d, g) {
                        if (typeof c != "number") if (c == "next") c = A + 1;
                        else if (c == "prev") c = A - 1;
                        else if (c == "first") c = 0;
                        else if (c == "last") c = w - 1;
                        else {
                            c = A;
                            g = true
                        }
                        c > w - 1 && (c = 0);
                        (!a().touchStyle || !Xa) && Y(y.eq(c), b, false, false, d, false, g)
                    });
                    c.bind("play", function (b, c) {
                        va = true;
                        c = Number(c);
                        if (!isNaN(c)) a().autoplay = c;
                        yb(333)
                    });
                    c.bind("pause", function () {
                        va = false
                    });
                    c.bind("rescale", function (a, b, c, d, o) {
                        B(b, c, d);
                        Ya = z = g / h;
                        Fa = !ta;
                        o = Number(o);
                        isNaN(o) && (o = 0);
                        fa(false, o)
                    });
                    c.bind("fullscreenopen", function () {
                        Tb = J.scrollTop();
                        Ub = J.scrollLeft();
                        r = true;
                        na && na.trigger("mouseleave", true);
                        J.scrollTop(0);
                        ob.add(Wa).addClass("fullscreen");
                        c.addClass(b + "_fullscreen");
                        (lb || Ha) && c.appendTo(Wa).addClass(b + "_fullscreen_quirks");
                        a().caption && !a().caption != "overlay" && ma.appendTo(m);
                        a().thumbs && a().hideNavIfFullscreen && x.hide();
                        wa();
                        D && Y(D, false, false, true, 0, false, true, true);
                        fa(false, false, true);
                        a().onFullscreenOpen && a().onFullscreenOpen.call(c[0], K())
                    });
                    c.bind("fullscreenclose", function () {
                        r = false;
                        na && na.trigger("mouseleave", true);
                        ob.add(Wa).removeClass("fullscreen");
                        c.removeClass(b + "_fullscreen");
                        (lb || Ha) && c.appendTo(Ua).removeClass(b + "_fullscreen_quirks");
                        a().caption && !a().caption != "overlay" && ma.appendTo(dc);
                        J.scrollTop(Tb);
                        J.scrollLeft(Ub);
                        if (!ta) {
                            g = a().width;
                            h = a().height
                        }
                        a().thumbs && a().hideNavIfFullscreen && x.show();
                        D && Y(D, false, false, true, 0, false, true, true);
                        a().flexible ? S() : fa(false, false, true);
                        a().onFullscreenClose && a().onFullscreenClose.call(c[0], K())
                    });
                    c.bind("reset", function () {
                        zb({
                            type: "resize"
                        }, true)
                    });
                    Ka.bind("keydown", function (b) {
                        if (r) {
                            b.preventDefault();
                            b.keyCode == 27 && !a().fullscreen ? c.trigger("fullscreenclose") : b.keyCode == 39 || b.keyCode == 40 ? c.trigger("showimg", A + 1) : (b.keyCode == 37 || b.keyCode == 38) && c.trigger("showimg", A - 1)
                        }
                    });
                    a().thumbs && I.bind("click",
                    Ab);
                    if (a().arrows) {
                        Sa.bind("click", function (a) {
                            d(this).data("disabled") || Z(-1, a)
                        });
                        Ta.bind("click", function (a) {
                            d(this).data("disabled") || Z(1, a)
                        })
                    }!a().touchStyle && (!n && a().pseudoClick) && m.bind("click", function (b) {
                        if (a().html) {
                            var f, g;
                            f = d(b.target);
                            g = f.filter("a");
                            g.length || (g = f.parents("a"))
                        }
                        if (!g || !g.length) {
                            f = b[R] - m.offset()[F] >= u / 2;
                            if (a().onClick) var h = a().onClick.call(c[0], K());
                            h !== false && (!b.shiftKey && f && a().arrows || b.shiftKey && !f && a().arrows || !a().arrows && !b.shiftKey ? Z(1, b) : Z(-1, b))
                        }
                    });
                    na && na.bind("click", function (a) {
                        a.stopPropagation();
                        c.trigger(r ? "fullscreenclose" : "fullscreenopen")
                    }).bind("mouseenter mouseleave", function (a, c) {
                        c && a.stopPropagation();
                        na[a.type == "mouseenter" ? "addClass" : "removeClass"](b + "__fsi_hover")
                    });
                    a().fullscreen && c.trigger("fullscreenopen");
                    if (a().touchStyle || n) {
                        var Db = false;
                        xa(C, function () {
                            Xa = true
                        }, function (c, f, g) {
                            clearTimeout(Vb);
                            if (!La) {
                                a().shadows && m.addClass(b + "__wrap_shadow");
                                n || C.addClass(b + "__shaft_grabbing");
                                La = true
                            }
                            if (a().shadows) if (g) {
                                c = g == "left" ? "right" : "left";
                                m.addClass(b + "__wrap_shadow_no-" + g).removeClass(b + "__wrap_shadow_no-" + c)
                            } else a().shadows && m.removeClass(b + "__wrap_shadow_no-left " + b + "__wrap_shadow_no-right");
                            if (Math.abs(f) >= 5 && !Db) {
                                Db = true;
                                d("a", m).bind("click", Gb)
                            }
                        }, function (e, f, g, h, o, j, l, k) {
                            Xa = false;
                            Vb = setTimeout(function () {
                                !n && a().arrows && p();
                                Db = false;
                                d("a", m).unbind("click", Gb)
                            }, Ja);
                            n || C.removeClass(b + "__shaft_grabbing");
                            a().shadows && m.removeClass(b + "__wrap_shadow");
                            var o = h = false,
                                s, q;
                            if (a().html) {
                                s = d(l.target);
                                q = s.filter("a");
                                q.length || (q = s.parents("a"))
                            }
                            if (a().touchStyle) if (La) {
                                g && (j <= -10 ? h = true : j >= 10 && (o = true));
                                g = 333;
                                k = Math.round(e / (u + a().margin));
                                if (h || o) {
                                    var f = -j / f,
                                        j = Math.round(-e + f * 250),
                                        r;
                                    if (h) {
                                        k = Math.ceil(e / (u + a().margin)) - 1;
                                        e = -k * (u + a().margin);
                                        if (j > e) {
                                            r = Math.abs(j - e);
                                            g = Math.abs(g / (f * 250 / (Math.abs(f * 250) - r * 0.97)));
                                            r = e + r * 0.03
                                        }
                                    } else if (o) {
                                        k = Math.floor(e / (u + a().margin)) + 1;
                                        e = -k * (u + a().margin);
                                        if (j < e) {
                                            r = Math.abs(j - e);
                                            g = Math.abs(g / (f * 250 / (Math.abs(f * 250) - r * 0.97)));
                                            r = e - r * 0.03
                                        }
                                    }
                                }
                                if (k < 0) {
                                    k = 0;
                                    r = false;
                                    g = 333
                                }
                                if (k > w - 1) {
                                    k = w - 1;
                                    r = false;
                                    g = 333
                                }
                                Y(y.eq(k), l, false, false, g, r)
                            } else {
                                if (a().html && q.length) return false;
                                if (a().onClick && k != "prevent") var x = a().onClick.call(c[0], K());
                                if (x !== false && a().pseudoClick && !n && f < Ja) {
                                    r = l[R] - m.offset()[F] >= u / 2;
                                    !l.shiftKey && r && a().arrows || l.shiftKey && !r && a().arrows || !a().arrows && !l.shiftKey ? Z(1, l) : Z(-1, l)
                                } else Y(D, l, false, false, false, false, true)
                            } else {
                                if (j == 0 && a().html && q.length) return false;
                                j >= 0 ? Z(1, l) : j < 0 && Z(-1, l)
                            }
                            La = false
                        });
                        if (a().touchStyle && a().thumbs && a().thumbsPreview) {
                            var Eb = false;
                            xa(s, function () {
                                db = ga = true
                            }, function (a, b) {
                                if (!Ma && Math.abs(b) >= 5) {
                                    I.unbind("click", Ab);
                                    Eb = true;
                                    clearTimeout(Wb);
                                    Ma = true
                                }
                                ba(a)
                            }, function (a, b, c, d, g, h, j) {
                                Ma = ga = false;
                                Wb = setTimeout(function () {
                                    if (Eb) {
                                        I.bind("click", Ab);
                                        Eb = false
                                    }
                                }, Ja);
                                var d = a = -a,
                                    k, g = 666;
                                if (fb && Ma) {
                                    aa(0, false, false);
                                    fb = false
                                }
                                if (a > s.data("maxPos")) {
                                    d = s.data("maxPos");
                                    g = g / 2
                                } else if (a < s.data("minPos")) {
                                    d = s.data("minPos");
                                    g = g / 2
                                } else if (c) {
                                    b = -h / b;
                                    d = Math.round(a + b * 250);
                                    if (d > s.data("maxPos")) {
                                        k = Math.abs(d - s.data("maxPos"));
                                        g = Math.abs(g / (b * 250 / (Math.abs(b * 250) - k * 0.96)));
                                        d = s.data("maxPos");
                                        k = d + k * 0.04
                                    } else if (d < s.data("minPos")) {
                                        k = Math.abs(d - s.data("minPos"));
                                        g = Math.abs(g / (b * 250 / (Math.abs(b * 250) - k * 0.96)));
                                        d = s.data("minPos");
                                        k = d - k * 0.04
                                    }
                                }
                                j.altKey && (g = g * 10);
                                W = d;
                                if (d != a) {
                                    pa(s, d, g, k);
                                    ba(d)
                                }
                            })
                        }
                    }
                })
            }
        });
        return this
    };
    d(function () {
        ob = d("html");
        Wa = d("body");
        d("." + b).each(function () {
            d(this)[b]()
        })
    })
})(jQuery);