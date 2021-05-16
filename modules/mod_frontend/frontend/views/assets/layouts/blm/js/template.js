var $jscomp = {
    scope: {},
    getGlobal: function (a) {
        return "undefined" != typeof window && window === a ? a : "undefined" != typeof global ? global : a
    }
};
$jscomp.global = $jscomp.getGlobal(this);
$jscomp.initSymbol = function () {
    $jscomp.global.Symbol || ($jscomp.global.Symbol = $jscomp.Symbol);
    $jscomp.initSymbol = function () {
    }
};
$jscomp.symbolCounter_ = 0;
$jscomp.Symbol = function (a) {
    return "jscomp_symbol_" + a + $jscomp.symbolCounter_++
};
$jscomp.initSymbolIterator = function () {
    $jscomp.initSymbol();
    $jscomp.global.Symbol.iterator || ($jscomp.global.Symbol.iterator = $jscomp.global.Symbol("iterator"));
    $jscomp.initSymbolIterator = function () {
    }
};
$jscomp.makeIterator = function (a) {
    $jscomp.initSymbolIterator();
    if (a[$jscomp.global.Symbol.iterator]) return a[$jscomp.global.Symbol.iterator]();
    if (!(a instanceof Array || "string" == typeof a || a instanceof String)) throw new TypeError(a + " is not iterable");
    var d = 0;
    return {
        next: function () {
            return d == a.length ? {
                    done: !0
                } : {
                    done: !1,
                    value: a[d++]
                }
        }
    }
};
$jscomp.arrayFromIterator = function (a) {
    for (var d, h = []; !(d = a.next()).done;) h.push(d.value);
    return h
};
$jscomp.arrayFromIterable = function (a) {
    return a instanceof Array ? a : $jscomp.arrayFromIterator($jscomp.makeIterator(a))
};
$jscomp.arrayFromArguments = function (a) {
    for (var d = [], h = 0; h < a.length; h++) d.push(a[h]);
    return d
};
$jscomp.inherits = function (a, d) {
    function h() {
    }

    h.prototype = d.prototype;
    a.prototype = new h;
    a.prototype.constructor = a;
    for (var c in d)
        if ($jscomp.global.Object.defineProperties) {
            var l = $jscomp.global.Object.getOwnPropertyDescriptor(d, c);
            void 0 !== l && $jscomp.global.Object.defineProperty(a, c, l)
        } else a[c] = d[c]
};
window.Modernizr = function (a, d, h) {
    function c(b, a) {
        return typeof b === a
    }

    function l(b, a) {
        for (var e in b) {
            var f = b[e];
            if (!~("" + f).indexOf("-") && u[f] !== h) return "pfx" == a ? f : !0
        }
        return !1
    }

    function m(b, a, e) {
        var f = b.charAt(0).toUpperCase() + b.slice(1),
            k = (b + " " + y.join(f + " ") + f).split(" ");
        if (c(a, "string") || c(a, "undefined")) return l(k, a);
        k = (b + " " + A.join(f + " ") + f).split(" ");
        a: {
            b = k;
            for (var r in b)
                if (f = a[b[r]], f !== h) {
                    a = !1 === e ? b[r] : c(f, "function") ? f.bind(e || a) : f;
                    break a
                }
            a = !1
        }
        return a
    }

    function g() {
        n.input = function (b) {
            for (var f = 0, k = b.length; f < k; f++) e[b[f]] = !!(b[f] in x);
            e.list && (e.list = !(!d.createElement("datalist") || !a.HTMLDataListElement));
            return e
        }("autocomplete autofocus list placeholder max min multiple pattern required step".split(" "));
        n.inputtypes = function (a) {
            for (var e = 0, f, k, c = a.length; e < c; e++) {
                x.setAttribute("type", k = a[e]);
                if (f = "text" !== x.type) x.value = ":)", x.style.cssText = "position:absolute;visibility:hidden;", /^range$/.test(k) && x.style.WebkitAppearance !== h ? (q.appendChild(x), f = d.defaultView, f = f.getComputedStyle && "textfield" !== f.getComputedStyle(x, null).WebkitAppearance && 0 !== x.offsetHeight, q.removeChild(x)) : /^(search|tel)$/.test(k) || (f = /^(url|email)$/.test(k) ? x.checkValidity && !1 === x.checkValidity() : ":)" != x.value);
                b[a[e]] = !!f
            }
            return b
        }("search tel url email datetime date month week time datetime-local number range color".split(" "))
    }

    var n = {},
        q = d.documentElement,
        v = d.createElement("modernizr"),
        u = v.style,
        x = d.createElement("input"),
        w = {}.toString,
        t = " -webkit- -moz- -o- -ms- ".split(" "),
        y = ["Webkit", "Moz", "O", "ms"],
        A = ["webkit", "moz", "o", "ms"],
        v = {},
        b = {},
        e = {},
        f = [],
        k = f.slice,
        r, z = function (b, a, e, f) {
            var k, c, r = d.createElement("div"),
                g = d.body,
                h = g || d.createElement("body");
            if (parseInt(e, 10))
                for (; e--;) k = d.createElement("div"), k.id = f ? f[e] : "modernizr" + (e + 1), r.appendChild(k);
            e = ['&#173;<style id="smodernizr">', b, "</style>"].join("");
            r.id = "modernizr";
            (g ? r : h).innerHTML += e;
            h.appendChild(r);
            g || (h.style.background = "", h.style.overflow = "hidden", c = q.style.overflow, q.style.overflow = "hidden", q.appendChild(h));
            b = a(r, b);
            g ? r.parentNode.removeChild(r) : (h.parentNode.removeChild(h), q.style.overflow = c);
            return !!b
        },
        X = function () {
            var b = {
                select: "input",
                change: "input",
                submit: "form",
                reset: "form",
                error: "img",
                load: "img",
                abort: "img"
            };
            return function (a, e) {
                e = e || d.createElement(b[a] || "div");
                a = "on" + a;
                var f = a in e;
                f || (e.setAttribute || (e = d.createElement("div")), e.setAttribute && e.removeAttribute && (e.setAttribute(a, ""), f = c(e[a], "function"), c(e[a], "undefined") || (e[a] = h), e.removeAttribute(a)));
                return f
            }
        }(),
        U = {}.hasOwnProperty,
        K;
    K = c(U, "undefined") || c(U.call, "undefined") ? function (b, a) {
            return a in b && c(b.constructor.prototype[a], "undefined")
        } : function (b, a) {
            return U.call(b, a)
        };
    Function.prototype.bind || (Function.prototype.bind = function (b) {
        var a = this;
        if ("function" != typeof a) throw new TypeError;
        var e = k.call(arguments, 1),
            f = function () {
                if (this instanceof f) {
                    var c = function () {
                    };
                    c.prototype = a.prototype;
                    var c = new c,
                        r = a.apply(c, e.concat(k.call(arguments)));
                    return Object(r) === r ? r : c
                }
                return a.apply(b, e.concat(k.call(arguments)))
            };
        return f
    });
    v.flexbox = function () {
        return m("flexWrap")
    };
    v.canvas = function () {
        var b = d.createElement("canvas");
        return !(!b.getContext || !b.getContext("2d"))
    };
    v.canvastext = function () {
        return !(!n.canvas || !c(d.createElement("canvas").getContext("2d").fillText, "function"))
    };
    v.webgl = function () {
        return !!a.WebGLRenderingContext
    };
    v.touch = function () {
        var b;
        "ontouchstart" in a || a.DocumentTouch && d instanceof DocumentTouch ? b = !0 : z(["@media (", t.join("touch-enabled),("), "modernizr){#modernizr{top:9px;position:absolute}}"].join(""), function (a) {
                b = 9 === a.offsetTop
            });
        return b
    };
    v.geolocation = function () {
        return "geolocation" in navigator
    };
    v.postmessage = function () {
        return !!a.postMessage
    };
    v.websqldatabase = function () {
        return !!a.openDatabase
    };
    v.indexedDB = function () {
        return !!m("indexedDB", a)
    };
    v.hashchange = function () {
        return X("hashchange", a) && (d.documentMode === h || 7 < d.documentMode)
    };
    v.history = function () {
        return !(!a.history || !history.pushState)
    };
    v.draganddrop = function () {
        var b = d.createElement("div");
        return "draggable" in b || "ondragstart" in b && "ondrop" in b
    };
    v.websockets = function () {
        return "WebSocket" in a || "MozWebSocket" in a
    };
    v.rgba = function () {
        u.cssText = "background-color:rgba(150,255,150,.5)";
        return !!~("" + u.backgroundColor).indexOf("rgba")
    };
    v.hsla = function () {
        u.cssText = "background-color:hsla(120,40%,100%,.5)";
        return !!~("" + u.backgroundColor).indexOf("rgba") || !!~("" + u.backgroundColor).indexOf("hsla")
    };
    v.multiplebgs = function () {
        u.cssText = "background:url(https://),url(https://),red url(https://)";
        return /(url\s*\(.*?){3}/.test(u.background)
    };
    v.backgroundsize = function () {
        return m("backgroundSize")
    };
    v.borderimage = function () {
        return m("borderImage")
    };
    v.borderradius = function () {
        return m("borderRadius")
    };
    v.boxshadow = function () {
        return m("boxShadow")
    };
    v.textshadow = function () {
        return "" === d.createElement("div").style.textShadow
    };
    v.opacity = function () {
        var b = t.join("opacity:.55;") + "";
        u.cssText = b;
        return /^0.55$/.test(u.opacity)
    };
    v.cssanimations = function () {
        return m("animationName")
    };
    v.csscolumns = function () {
        return m("columnCount")
    };
    v.cssgradients = function () {
        var b = ("background-image:-webkit-gradient(linear,left top,right bottom,from(#9f9),to(white));background-image:" +
        t.join("linear-gradient(left top,#9f9, white);background-image:")).slice(0, -17);
        u.cssText = b;
        return !!~("" + u.backgroundImage).indexOf("gradient")
    };
    v.cssreflections = function () {
        return m("boxReflect")
    };
    v.csstransforms = function () {
        return !!m("transform")
    };
    v.csstransforms3d = function () {
        var b = !!m("perspective");
        b && "webkitPerspective" in q.style && z("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}", function (a, e) {
            b = 9 === a.offsetLeft && 3 === a.offsetHeight
        });
        return b
    };
    v.csstransitions = function () {
        return m("transition")
    };
    v.fontface = function () {
        var b;
        z('@font-face {font-family:"font";src:url("https://")}', function (a, e) {
            var f = d.getElementById("smodernizr"),
                f = (f = f.sheet || f.styleSheet) ? f.cssRules && f.cssRules[0] ? f.cssRules[0].cssText : f.cssText || "" : "";
            b = /src/i.test(f) && 0 === f.indexOf(e.split(" ")[0])
        });
        return b
    };
    v.generatedcontent = function () {
        var b;
        z('#modernizr{font:0/0 a}#modernizr:after{content:":)";visibility:hidden;font:3px/1 a}', function (a) {
            b = 3 <= a.offsetHeight
        });
        return b
    };
    v.video = function () {
        var b = d.createElement("video"),
            a = !1;
        try {
            if (a = !!b.canPlayType) a = new Boolean(a), a.ogg = b.canPlayType('video/ogg; codecs="theora"').replace(/^no$/, ""), a.h264 = b.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/, ""), a.webm = b.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/, "")
        } catch (e) {
        }
        return a
    };
    v.audio = function () {
        var b = d.createElement("audio"),
            a = !1;
        try {
            if (a = !!b.canPlayType) a = new Boolean(a), a.ogg = b.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/, ""), a.mp3 = b.canPlayType("audio/mpeg;").replace(/^no$/, ""), a.wav = b.canPlayType('audio/wav; codecs="1"').replace(/^no$/, ""), a.m4a = (b.canPlayType("audio/x-m4a;") || b.canPlayType("audio/aac;")).replace(/^no$/, "")
        } catch (e) {
        }
        return a
    };
    v.localstorage = function () {
        try {
            return localStorage.setItem("modernizr", "modernizr"), localStorage.removeItem("modernizr"), !0
        } catch (b) {
            return !1
        }
    };
    v.sessionstorage = function () {
        try {
            return sessionStorage.setItem("modernizr", "modernizr"), sessionStorage.removeItem("modernizr"), !0
        } catch (b) {
            return !1
        }
    };
    v.webworkers = function () {
        return !!a.Worker
    };
    v.applicationcache = function () {
        return !!a.applicationCache
    };
    v.svg = function () {
        return !!d.createElementNS && !!d.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect
    };
    v.inlinesvg = function () {
        var b = d.createElement("div");
        b.innerHTML = "<svg/>";
        return "http://www.w3.org/2000/svg" == (b.firstChild && b.firstChild.namespaceURI)
    };
    v.smil = function () {
        return !!d.createElementNS && /SVGAnimate/.test(w.call(d.createElementNS("http://www.w3.org/2000/svg", "animate")))
    };
    v.svgclippaths = function () {
        return !!d.createElementNS && /SVGClipPath/.test(w.call(d.createElementNS("http://www.w3.org/2000/svg", "clipPath")))
    };
    for (var D in v) K(v, D) && (r = D.toLowerCase(), n[r] = v[D](), f.push((n[r] ? "" : "no-") + r));
    n.input || g();
    n.addTest = function (b, a) {
        if ("object" == typeof b)
            for (var e in b) K(b, e) && n.addTest(e, b[e]);
        else {
            b = b.toLowerCase();
            if (n[b] !== h) return n;
            a = "function" == typeof a ? a() : a;
            q.className += " " + (a ? "" : "no-") + b;
            n[b] = a
        }
        return n
    };
    u.cssText = "";
    v = x = null;
    (function (b, a) {
        function e() {
            var b = m.elements;
            return "string" == typeof b ? b.split(" ") : b
        }

        function f(b) {
            var a = z[b._html5shiv];
            a || (a = {}, l++, b._html5shiv = l, z[l] = a);
            return a
        }

        function k(b, e, c) {
            e || (e = a);
            if (q) return e.createElement(b);
            c || (c = f(e));
            e = c.cache[b] ? c.cache[b].cloneNode() : h.test(b) ? (c.cache[b] = c.createElem(b)).cloneNode() : c.createElem(b);
            return e.canHaveChildren && !d.test(b) ? c.frag.appendChild(e) : e
        }

        function c(b, a) {
            a.cache || (a.cache = {}, a.createElem = b.createElement, a.createFrag = b.createDocumentFragment, a.frag = a.createFrag());
            b.createElement = function (e) {
                return m.shivMethods ? k(e, b, a) : a.createElem(e)
            };
            b.createDocumentFragment = Function("h,f", "return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(" + e().join().replace(/\w+/g, function (b) {
                    a.createElem(b);
                    a.frag.createElement(b);
                    return 'c("' + b + '")'
                }) + ");return n}")(m, a.frag)
        }

        function r(b) {
            b || (b = a);
            var e = f(b);
            if (m.shivCSS && !n && !e.hasCSS) {
                var k, g = b;
                k = g.createElement("p");
                g = g.getElementsByTagName("head")[0] || g.documentElement;
                k.innerHTML = "x<style>article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}</style>";
                k = g.insertBefore(k.lastChild, g.firstChild);
                e.hasCSS = !!k
            }
            q || c(b, e);
            return b
        }

        var g = b.html5 || {},
            d = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,
            h = /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,
            n, l = 0,
            z = {},
            q;
        (function () {
            try {
                var b = a.createElement("a");
                b.innerHTML = "<xyz></xyz>";
                n = "hidden" in b;
                var e;
                if (!(e = 1 == b.childNodes.length)) {
                    a.createElement("a");
                    var f = a.createDocumentFragment();
                    e = "undefined" == typeof f.cloneNode || "undefined" == typeof f.createDocumentFragment || "undefined" == typeof f.createElement
                }
                q = e
            } catch (k) {
                q = n = !0
            }
        })();
        var m = {
            elements: g.elements || "abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",
            shivCSS: !1 !== g.shivCSS,
            supportsUnknownElements: q,
            shivMethods: !1 !== g.shivMethods,
            type: "default",
            shivDocument: r,
            createElement: k,
            createDocumentFragment: function (b, k) {
                b || (b = a);
                if (q) return b.createDocumentFragment();
                k = k || f(b);
                for (var c = k.frag.cloneNode(), r = 0, g = e(), d = g.length; r < d; r++) c.createElement(g[r]);
                return c
            }
        };
        b.html5 = m;
        r(a)
    })(this, d);
    n._version = "2.6.2";
    n._prefixes = t;
    n._domPrefixes = A;
    n._cssomPrefixes = y;
    n.mq = function (b) {
        var e = a.matchMedia || a.msMatchMedia;
        if (e) return e(b).matches;
        var f;
        z("@media " + b + " { #modernizr { position: absolute; } }", function (b) {
            f = "absolute" == (a.getComputedStyle ? getComputedStyle(b, null) : b.currentStyle).position
        });
        return f
    };
    n.hasEvent = X;
    n.testProp = function (b) {
        return l([b])
    };
    n.testAllProps = m;
    n.testStyles = z;
    n.prefixed = function (b, a, e) {
        return a ? m(b, a, e) : m(b, "pfx")
    };
    q.className = q.className.replace(/(^|\s)no-js(\s|$)/, "$1$2") + (" js " + f.join(" "));
    return n
}(this, this.document);

function css_browser_selector(a) {
    function d() {
        var a = window.outerWidth || n.clientWidth;
        h.orientation = a < (window.outerHeight || n.clientHeight) ? "portrait" : "landscape";
        n.className = n.className.replace(/ ?orientation_\w+/g, "").replace(/ [min|max|cl]+[w|h]_\d+/g, "");
        for (var g = l - 1; 0 <= g; g--)
            if (a >= c[g]) {
                h.maxw = c[g];
                break
            }
        widthClasses = "";
        for (var d in h) widthClasses += " " + d + "_" + h[d];
        n.className += widthClasses;
        return widthClasses
    }

    var h = {},
        c = [320, 480, 640, 768, 1024, 1152, 1280, 1440, 1680, 1920, 2560],
        l = c.length,
        m = a.toLowerCase();
    a = function (a) {
        return RegExp(a, "i").test(m)
    };
    var g = function (a, c) {
            c = c.replace(".", "_");
            for (var g = c.indexOf("_"), d = ""; 0 < g;) d += " " + a + c.substring(0, g), g = c.indexOf("_", g + 1);
            return d + (" " + a + c)
        },
        n = document.documentElement;
    a = [!/opera|webtv/i.test(m) && /msie\s(\d+)/.test(m) ? "ie ie" + (/trident\/4\.0/.test(m) ? "8" : RegExp.$1) : a("firefox/") ? "gecko firefox" + (/firefox\/((\d+)(\.(\d+))(\.\d+)*)/.test(m) ? " firefox" + RegExp.$2 + " firefox" + RegExp.$2 + "_" + RegExp.$4 : "") : a("gecko/") ? "gecko" : a("opera") ? "opera" + (/version\/((\d+)(\.(\d+))(\.\d+)*)/.test(m) ? " opera" + RegExp.$2 + " opera" + RegExp.$2 + "_" + RegExp.$4 : /opera(\s|\/)(\d+)\.(\d+)/.test(m) ? " opera" + RegExp.$2 + " opera" + RegExp.$2 + "_" + RegExp.$3 : "") : a("konqueror") ? "konqueror" : a("blackberry") ? "blackberry" + (/Version\/(\d+)(\.(\d+)+)/i.test(m) ? " blackberry" + RegExp.$1 + " blackberry" + RegExp.$1 + RegExp.$2.replace(".", "_") : /Blackberry ?(([0-9]+)([a-z]?))[\/|;]/gi.test(m) ? " blackberry" + RegExp.$2 + (RegExp.$3 ? " blackberry" + RegExp.$2 + RegExp.$3 : "") : "") : a("android") ? "android" + (/Version\/(\d+)(\.(\d+))+/i.test(m) ? " android" +
                                    RegExp.$1 + " android" + RegExp.$1 + RegExp.$2.replace(".", "_") : "") + (/Android (.+); (.+) Build/i.test(m) ? " device_" + RegExp.$2.replace(/ /g, "_").replace(/-/g, "_") : "") : a("chrome") ? "webkit chrome" + (/chrome\/((\d+)(\.(\d+))(\.\d+)*)/.test(m) ? " chrome" + RegExp.$2 + (0 < RegExp.$4 ? " chrome" + RegExp.$2 + "_" + RegExp.$4 : "") : "") : a("iron") ? "webkit iron" : a("applewebkit/") ? "webkit safari" + (/version\/((\d+)(\.(\d+))(\.\d+)*)/.test(m) ? " safari" + RegExp.$2 + " safari" + RegExp.$2 + RegExp.$3.replace(".", "_") : / Safari\/(\d+)/i.test(m) ? "419" == RegExp.$1 || "417" == RegExp.$1 || "416" == RegExp.$1 || "412" == RegExp.$1 ? " safari2_0" : "312" == RegExp.$1 ? " safari1_3" : "125" == RegExp.$1 ? " safari1_2" : "85" == RegExp.$1 ? " safari1_0" : "" : "") : a("mozilla/") ? "gecko" : "", a("android|mobi|mobile|j2me|iphone|ipod|ipad|blackberry|playbook|kindle|silk") ? "mobile" : "", a("j2me") ? "j2me" : a("ipad|ipod|iphone") ? (/CPU( iPhone)? OS (\d+[_|\.]\d+([_|\.]\d+)*)/i.test(m) ? "ios" + g("ios", RegExp.$2) : "") + " " + (/(ip(ad|od|hone))/gi.test(m) ? RegExp.$1 : "") : a("playbook") ? "playbook" : a("kindle|silk") ? "kindle" : a("playbook") ? "playbook" : a("mac") ? "mac" + (/mac os x ((\d+)[.|_](\d+))/.test(m) ? " mac" + RegExp.$2 + " mac" + RegExp.$1.replace(".", "_") : "") : a("win") ? "win" + (a("windows nt 6.2") ? " win8" : a("windows nt 6.1") ? " win7" : a("windows nt 6.0") ? " vista" : a("windows nt 5.2") || a("windows nt 5.1") ? " win_xp" : a("windows nt 5.0") ? " win_2k" : a("windows nt 4.0") || a("WinNT4.0") ? " win_nt" : "") : a("freebsd") ? "freebsd" : a("x11|linux") ? "linux" : "", /[; |\[](([a-z]{2})(\-[a-z]{2})?)[)|;|\]]/i.test(m) ? ("lang_" + RegExp.$2).replace("-", "_") + ("" != RegExp.$3 ? (" lang_" + RegExp.$1).replace("-", "_") : "") : "", a("ipad|iphone|ipod") && !a("safari") ? "ipad_app" : ""];
    window.onresize = d;
    d();
    a = a.join(" ") + " js ";
    n.className = (a + n.className.replace(/\b(no[-|_]?)?js\b/g, "")).replace(/^ /, "").replace(/ +/g, " ");
    return a
}
css_browser_selector(navigator.userAgent);
(function (a) {
    window.PURL = {};
    PURL.ImageSet = function (d, h) {
        var c = function (a) {
                for (var c = 0; c < a.length; c++) {
                    var d = new FileReader;
                    d.file = a[c];
                    d.onloadend = l;
                    d.readAsDataURL(a[c])
                }
            },
            l = function (a) {
                var c = a.target.file;
                c && m(c, a.target.result)
            },
            m = function (c, h) {
                var l = a("<li></li>");
                l.data("file", c);
                l.data("uploaded", !0);
                if (!c || -1 != c.type.search(/image\/.*/)) {
                    var m = new Image;
                    m.src = h;
                    c && (m.alt = c.name, m.title = c.name);
                    m.onload = function () {
                        var a = this.width,
                            c = this.height,
                            g = Math.min(a / PURL.ImageSetInit.thumbWidth, c / PURL.ImageSetInit.thumbHeight);
                        this.width = a / g;
                        this.height = c / g;
                        this.style.position = "relative";
                        this.style.top = Math.round((PURL.ImageSetInit.thumbHeight - this.height) / 2) + "px";
                        this.style.left = Math.round((PURL.ImageSetInit.thumbWidth - this.width) / 2) + "px"
                    };
                    l.append(m)
                }
                a('<input type="hidden" name="' + a(d).data("name") + '[]" value="" class="_file">').val(c ? "" : "url:" + h).appendTo(l);
                l.append('<button type="button" class="cms _del">Delete</button>');
                a(d).data("single") && a("li:not(._add)", d).each(function () {
                    var c = a(this),
                        g = c.find("input._file");
                    c.data("uploaded") || !g.val().match(/^(delete:)?\d+$/) || "0" == g.val() ? c.remove() : (g.val("delete:" + g.val().replace(/^filename:/, "")), c.data("file", !1).hide())
                });
                a(d).children("li:last").before(l);
                l.trigger("purl-imageset-field-add")
            };
        this.init = function () {
            if ("undefined" == typeof FileReader) return !1;
            if (a(h).data("imageset-initialized")) return !0;
            a(h).data("imageset-initialized", !0);
            a(h).attr("name", "");
            h.onchange = this.addFiles;
            d.addEventListener("dragenter", this.stopProp, !1);
            d.addEventListener("dragleave", this.stopProp, !1);
            d.addEventListener("dragover", this.stopProp, !1);
            d.addEventListener("drop", this.showDroppedFiles, !1);
            a(d).data("files", []);
            return !0
        };
        this.addFiles = function () {
            c(this.files);
            this.value = null
        };
        this.showDroppedFiles = function (a) {
            a.stopPropagation();
            a.preventDefault();
            a.dataTransfer.files && a.dataTransfer.files.length ? c(a.dataTransfer.files) : a.dataTransfer.getData("URL") ? (a = a.dataTransfer.getData("URL"), m(null, a)) : a.dataTransfer.getData("Text") && (a = a.dataTransfer.getData("Text"), m(null, a))
        };
        this.stopProp = function (a) {
            a.stopPropagation();
            a.preventDefault()
        }
    };
    PURL.ImageSetInit = function () {
        var d = a(this);
        PURL.ImageSetInit.thumbWidth = d.data("thumbwidth") || 100;
        PURL.ImageSetInit.thumbHeight = d.data("thumbheight") || 65;
        d.disableSelection().sortable({
            items: "li:not(._add)"
        });
        d.children("li:not(._add)").each(function () {
            0 == a("button._del", this).length && a(this).append('<button type="button" class="cms _del">Delete</button>');
            a(this).trigger("purl-imageset-field-add")
        });
        d.on("click", "li:not(._add) button._del", function () {
            var d = a(this).closest("li");
            d.data("file") ? a(d).animate({
                    width: 0
                }, 500, function () {
                    a(this).remove()
                }) : (a("input._file", d).val("delete:" + a("input._file", d).val().replace(/^filename:/, "")), a(d).data("file", !1).animate({
                    width: 0
                }, 500, function () {
                    a(this).hide()
                }))
        });
        (new PURL.ImageSet(d[0], a("input", d.children("li:last"))[0])).init()
    };
    PURL.FileSet = function (d, h) {
        this.init = function () {
            if ("undefined" == typeof FileReader) return !1;
            if (a(h).data("fileset-initialized")) return !0;
            a(h).data("fileset-initialized", !0);
            a(h).attr("name", "");
            h.onchange = this.addFiles;
            d.addEventListener("dragenter", this.stopProp, !1);
            d.addEventListener("dragleave", this.stopProp, !1);
            d.addEventListener("dragover", this.stopProp, !1);
            d.addEventListener("drop", this.showDroppedFiles, !1);
            a(d).data("files", []);
            return !0
        };
        this.addFiles = function () {
            c(this.files);
            this.value = null
        };
        this.showDroppedFiles = function (a) {
            a.stopPropagation();
            a.preventDefault();
            c(a.dataTransfer.files)
        };
        this.stopProp = function (a) {
            a.stopPropagation();
            a.preventDefault()
        };
        var c = function (c) {
            for (var h = 0; h < c.length; h++)
                if (c[h]) {
                    var g = a("<li></li>");
                    g.data("file", c[h]);
                    g.html(c[h].name);
                    g.append('<input type="hidden" name="' + a(d).data("name") + '[]" value="" class="_file">');
                    g.append('<button type="button" class="cms _del">Delete</button>');
                    a(d).data("single") && a("li:not(._add)", d).each(function () {
                        a(this).data("file") ? a(this).remove() : (a("input._file", this).val("delete:" + a("input._file", this).val().replace(/^filename:/, "")), a(this).data("file", !1).hide())
                    });
                    a(d).children("li:last").before(g);
                    g.trigger("purl-fileset-field-add")
                }
        }
    };
    PURL.FileSetInit = function () {
        var d = a(this);
        d.disableSelection().sortable({
            items: "li:not(._add)"
        });
        d.children("li:not(._add)").each(function () {
            0 == a("button._del", this).length && a(this).append('<button type="button" class="cms _del">Delete</button>');
            a(this).trigger("purl-fileset-field-add")
        });
        d.on("click", "li:not(._add) button._del", function () {
            var d = a(this).closest("li");
            d.trigger("purl-fileset-field-del");
            d.data("file") ? a(d).animate({
                    width: 0
                }, 500, function () {
                    a(this).remove()
                }) : (a("input._file", d).val("delete:" + a("input._file", d).val().replace(/^filename:/, "")), a(d).data("file", !1).animate({
                    width: 0
                }, 500, function () {
                    a(this).hide()
                }))
        });
        (new PURL.FileSet(d[0], a("input", d.children("li:last"))[0])).init()
    };
    PURL.DataSetInit = function () {
        var d = a(this);
        d.disableSelection().sortable({
            items: "li:not(._add)"
        });
        d.children("li:not(._add)").append('<button type="button" class="cms _del">Delete</button>').trigger("purl-dataset-field-add");
        d.on("click", "li:not(._add) button._del", function () {
            var d = a(this).closest("li");
            a(d).animate({
                width: 0
            }, 500, function () {
                a(this).remove()
            })
        });
        d.on("purl-dataset-add", "li._add", function () {
            var h = a(this).clone().appendTo(d);
            h.find(":input").val("");
            var c = h.width();
            h.css("width", 0).animate({
                width: c + "px"
            }, 500);
            a(this).removeClass("_add").append('<button type="button" class="cms _del">Delete</button>').trigger("purl-dataset-field-add")
        })
    };
    PURL.readableSize = function (a, h) {
        for (var c = 0; 1024 < a;) a /= 1024, c++;
        return a.toFixed(h || 1) + ["b", "K", "M", "G", "T"][c]
    };
    PURL.uploadFile = function (d, h, c) {
        if (d) {
            PURL.uploadFile.chunk_size || (PURL.uploadFile.chunk_size = 92160);
            d = {
                timeStart: (new Date).getTime() / 1E3,
                file: d,
                tmpFilename: "",
                bytesOffset: 0,
                bytesSent: 0,
                onProgress: c,
                onComplete: h
            };
            var l = function (a) {
                    if (a.bytesOffset >= a.file.size) return null;
                    var c = Math.min(PURL.uploadFile.chunk_size, a.file.size - a.bytesOffset),
                        d;
                    if (a.file.slice) d = a.file.slice(a.bytesOffset, a.bytesOffset + c);
                    else if (a.file.webkitSlice) d = a.file.webkitSlice(a.bytesOffset, a.bytesOffset + c);
                    else if (a.file.mozSlice) d = a.file.mozSlice(a.bytesOffset,
                        a.bytesOffset + c);
                    else return null;
                    a.bytesOffset += c;
                    return d
                },
                m = function (c) {
                    var d = l(c);
                    d && a.ajax({
                        type: "POST",
                        url: WEB_ROOT + "purl/api/purl-upload.php?fn=" + encodeURIComponent(c.tmpFilename),
                        headers: {
                            "Cache-Control": "no-cache",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-File-Name": c.file.name
                        },
                        contentType: "application/octet-stream",
                        data: d,
                        processData: !1,
                        beforeSend: function (d, h) {
                            var l = h.xhr;
                            h.xhr = function () {
                                var d = l();
                                d.upload.addEventListener("progress", function (d) {
                                    if (d.lengthComputable && a.isFunction(c.onProgress)) c.onProgress(c.bytesSent +
                                        d.loaded, c.file.size, (new Date).getTime() / 1E3 - c.timeStart)
                                }, !1);
                                return d
                            }
                        },
                        success: function (d, h, l) {
                            if (d.res && d.tmp_name)
                                if (c.bytesOffset < c.file.size) c.bytesSent = c.bytesOffset, c.tmpFilename = d.tmp_name, m(c);
                                else {
                                    if (a.isFunction(c.onComplete)) c.onComplete(!0, void 0, d.tmp_name, c.file.name)
                                }
                            else if (console.log("File Upload Failed: " + h, d, l), a.isFunction(c.onComplete)) c.onComplete(!1, "Upload of " + c.file.name + " failed" + (d.error ? ": " + d.error : ""), void 0, c.file.name)
                        },
                        error: function (d, h, l) {
                            console.log("File Upload Failed: " +
                                h, d, l);
                            if (a.isFunction(c.onComplete)) c.onComplete(!1, "Upload of " + c.file.name + " failed: " + h, void 0, c.file.name)
                        },
                        dataType: "json"
                    })
                };
            m(d)
        }
    };
    PURL.parentFieldInit = function () {
        var d = a(this),
            h = d.closest("tr,form,.form-row"),
            c = h.find(':input[name="' + d.data("parent-field") + '"]'),
            l = function () {
                var c = {};
                a(this).children().each(function () {
                    var g = String(a(this).data("pid") || "").split(",").reduce(function (a, c) {
                            0 > a.indexOf(c) && a.push(c);
                            return a
                        }, []),
                        d;
                    for (d = 0; d < g.length; d++) c[g[d]] = c[g[d]] ? c[g[d]] + this.outerHTML : this.outerHTML
                });
                return c
            },
            m = function () {
                var c = a(this),
                    g = h.find(':input[name="' + c.data("parent-field") + '"]').val(),
                    d = c.data("parent-field-data"),
                    n = !1,
                    m = c.val(),
                    t = "";
                d || (d = l.apply(this), c.data("parent-field-data", d));
                t += d[""];
                if ("" != g || c.data("parent-field-hide-on-null")) g && (t += d[g]);
                else
                    for (var y in d) y && (t += d[y]);
                c.html(t);
                c.val(m);
                if (c.attr("required") || c.data("pf-required")) c.children("option:not(:disabled)").each(function () {
                    if ("" != this.value) return n = !0, !1
                }), c.data("pf-required", !0).attr("required", n)
            },
            g = function () {
                var c = a(this),
                    g = h.find(':input[name="' + c.data("parent-field") + '"]').val();
                !c.is("[data-pid]") || c.data("pid") == g || !c.data("parent-field-hide-on-null") && "" == g ? c.attr("disabled", !1).show().closest("label").show() : c.attr("disabled", !0).hide().closest("label").hide()
            },
            n = function () {
                var c = a(this),
                    d = '[data-parent-field="' + c.attr("name") + '"]';
                clearTimeout(c.data("parentFieldUpdateTimer"));
                a(this).closest("tr,form,.form-row").find(":input" + d + ":not(select)").trigger("parent-field-pre-update").each(g).trigger("parent-field-post-update").trigger("parent-field-update");
                a(this).closest("tr,form,.form-row").find("select" + d).trigger("parent-field-pre-update").each(m).trigger("parent-field-post-update").trigger("parent-field-update")
            };
        c.length || (h = d.closest("form"), c = h.find(':input[name="' + d.data("parent-field") + '"]'));
        if (!d.data("childFieldInitialized")) d.data("childFieldInitialized", !0).on("html-change", function () {
            var c = a(this);
            c.is("select") && c.data("parent-field-data", l.apply(this)).trigger("html-update")
        }).on("html-update", function () {
            var c = a(this);
            c.is("select") && c.trigger("parent-field-pre-update").each(m).trigger("parent-field-post-update").trigger("parent-field-update")
        });
        c.data("parentFieldInitialized") || c.on("change parent-field-update", n).each(n).data("parentFieldInitialized", !0)
    };
    PURL.formInit = function (d) {
        console.log("WARNING: PURL.formInit is deprecated");
        a("form", d).trigger("purl-form-init")
    };
    PURL.DynamicSelectInit = function () {
        var d = a(this).data("purl-section-values"),
            h = function () {
                var c = a(this),
                    d = PURL.DynamicSelectInit.values[c.data("purl-section-values")],
                    h, g, n;
                if (c.is("select[data-parent-field]")) {
                    if (!1 !== d.values && !d.pfValues)
                        for (d.pfValues = {}, h = 0; h < d.values.length; h++) {
                            n = d.values[h].data && d.values[h].data.pid || "";
                            d.pfValues[n] += '<option value="' + d.values[h].id + '"';
                            if (d.values[h].data)
                                for (g in d.values[h].data) d.pfValues[n] += " data-" + g + '="' + d.values[h].data[g] + '"';
                            d.pfValues[n] += ">" + d.values[h].text + "</option>"
                        }
                    c.data("parent-field-data", d.pfValues).trigger("html-update")
                } else {
                    n = c.val();
                    if (!1 !== d.values && !d.html)
                        for (d.html = "", h = 0; h < d.values.length; h++) {
                            d.html += '<option value="' + d.values[h].id + '"';
                            if (d.values[h].data)
                                for (g in d.values[h].data) d.html += " data-" + g + '="' + d.values[h].data[g] + '"';
                            d.html += ">" + d.values[h].text + "</option>"
                        }
                    c.html(d.html).val(n).trigger("html-change");
                    n != c.val() && c.trigger("change")
                }
            };
        PURL.DynamicSelectInit.values[d] ? (PURL.DynamicSelectInit.values[d].fields.push(this), PURL.DynamicSelectInit.values[d].values && h.apply(this)) : (PURL.DynamicSelectInit.values[d] = {
                html: !1,
                fields: [this],
                values: !1
            }, a.getJSON(WEB_ROOT + "?action=purlSectionForm:values&id=" +
                d,
                function (a) {
                    PURL.DynamicSelectInit.values[d].html = !1;
                    PURL.DynamicSelectInit.values[d].values = a;
                    for (a = 0; a < PURL.DynamicSelectInit.values[d].fields.length; a++) h.apply(PURL.DynamicSelectInit.values[d].fields[a])
                }))
    };
    PURL.DynamicSelectInit.values = {};
    a(function () {
        PURL.popupFieldDialog = a('<div class="purlbeDialog"></div>').appendTo("body").dialog({
            modal: !0,
            autoOpen: !1,
            resizable: !1,
            width: 800,
            maxHeight: .8 * a(window).height(),
            resize: "auto",
            title: "Edit Field",
            buttons: {
                Update: function () {
                    var d = a.Event("purl-popup-update");
                    PURL.popupFieldDialog.trigger(d);
                    d.isDefaultPrevented() || a(this).trigger("purl-popup-save")
                },
                Cancel: function () {
                    var d = a.Event("purl-popup-cancel");
                    PURL.popupFieldDialog.trigger(d);
                    d.isDefaultPrevented() || a(this).trigger("purl-popup-close")
                }
            },
            close: function () {
                a.fn.untinymce && a(".popupField._html", this).untinymce()
            }
        }).on("submit", "form", function () {
            PURL.popupFieldDialog.dialog("option", "buttons").Update.apply(PURL.popupFieldDialog);
            return !1
        }).on("purl-popup-save", function () {
            var d = a(this).data("popupField");
            a.fn.untinymce && a(".popupField._html", this).untinymce();
            a(":input", this).each(function () {
                var d = a(this).data("field");
                d && d.val(a(this).val()).trigger("change")
            });
            d.siblings(".purlPopupContent").html(a(".popupField", this).val());
            a(this).dialog("close")
        }).on("purl-popup-close", function () {
            a(this).dialog("close")
        });
        a(window).resize(function () {
            PURL.popupFieldDialog.dialog("option", "maxHeight", .8 * a(window).height())
        });
        a.fn.preBind = function (d, h, c) {
            this.each(function () {
                a(this).bind(d, h, c);
                var l = a._data(this, "events")[d];
                a.isArray(l) && l.unshift(l.pop())
            });
            return this
        };
        a(document).on("click change keyup update.comboStyle", ".frm_select>select", function () {
            a(this).parent().attr("title", a("option:selected", this).text())
        }).on("focus", ".frm_select>select", function () {
            a(this).parent().addClass("focus")
        }).on("blur", ".frm_select>select", function () {
            a(this).parent().removeClass("focus")
        }).on("click change keyup update.fileStyle", ".frm_file>input", function () {
            var d = a(this),
                h = d.val().split("/").pop().split("\\").pop();
            h || (h = d.attr("placeholder"));
            h || (h = "Select File...");
            d.parent().attr("title", h)
        }).on("focus", ".frm_file>input", function () {
            a(this).parent().addClass("focus")
        }).on("blur", ".frm_file>input", function () {
            a(this).parent().removeClass("focus")
        }).on("click", ".purlPopupButton", function () {
            var d = a(this).siblings(".purlPopupField"),
                h = PURL.popupFieldDialog;
            h.html("");
            h.data("popupField", d);
            d.each(function (c) {
                var d = a(this),
                    m = d.data("type"),
                    d = d.find(":input"),
                    g = d.data("label");
                g && h.append('<div class="_field _' +
                    m + '"><div class="_label">' + g + '</div><div class="_input"><span class="frm_field frm_' + m + '"></span></div></div>');
                d.each(function () {
                    var g = a(this),
                        d;
                    switch (m) {
                        case "string":
                            d = a('<input name="popupField' + c + '" class="popupField" type="text" />').appendTo(h).data("field", g).val(g.val()).css({
                                width: "100%"
                            });
                            break;
                        case "text":
                            d = a('<textarea name="popupField' + c + '" class="popupField"></textarea>').appendTo(h).data("field", g).val(g.val()).css({
                                width: "100%",
                                height: "380px"
                            });
                            break;
                        case "html":
                            d = a('<textarea name="popupField' +
                                c + '" class="popupField _html"></textarea>').appendTo(h).data("field", g).val(g.val()).css({
                                width: "100%",
                                height: "380px"
                            }), g.data("html-link-classes") && d.data("html-link-classes", g.data("html-link-classes")), g.data("html-link-targets") && d.data("html-link-targets", g.data("html-link-targets")), g.data("html-classes") && d.data("html-classes", g.data("html-classes")), g.data("html-class") && d.data("html-class", g.data("html-class"))
                    }
                    d.wrap('<div class="_field _' + m + '"><div class="_input"><span class="frm_field frm_' +
                        m + '"></span></div></div>');
                    g.data("locale-icon") && d.closest("._field").addClass("localized").find("._input").css("background-image", "url(" + g.data("locale-icon") + ")")
                })
            });
            h.children().wrapAll('<form><div class="_form"></div></form>');
            a.fn.tinymce && a(".popupField._html", h).tinymce();
            h.dialog("option", "title", a(this).data("title") || "Edit Field");
            h.trigger("purl-popup-open");
            h.dialog("open");
            h.trigger("purl-popup-show")
        }).on("purl-form-init", function (d) {
            d = a(d.target);
            a("ul.purl_imageset", d).each(PURL.ImageSetInit);
            a("ul.purl_fileset", d).each(PURL.FileSetInit);
            a("ul.purl_dataset", d).each(PURL.DataSetInit);
            a("select[data-purl-section-values]", d).each(PURL.DynamicSelectInit);
            a(":input[data-parent-field]", d).each(PURL.parentFieldInit);
            a(".frm_select>select", d).trigger("update.comboStyle");
            a(".frm_file>input", d).trigger("update.fileStyle");
            a("table.purlRecordListForm", d).each(function () {
                var d = a(this),
                    c = d.find("tr._new").clone().wrap("<div></div>").parent().html();
                d.hasClass("custom-sort") || d.find("tbody").sortable({
                    handle: "td:first-child"
                }).children("tr > td:first-child").disableSelection();
                d.on("change", "tbody>tr._new :input", function () {
                    var l = a(this).closest("tr._new"),
                        m = a(c).appendTo(a("tbody", d));
                    l.removeClass("_new");
                    a("input._del", l).val(0);
                    m.trigger("purl-form-init")
                }).on("click", "tbody>tr>td._action button._del", function () {
                    var c = a(this).closest("tr");
                    c.addClass("_del");
                    a("input._del", c).val(1)
                }).on("click", "tbody>tr>td._action button._undo", function () {
                    var c = a(this).closest("tr");
                    c.removeClass("_del");
                    a("input._del", c).val(0)
                })
            });
            a("form", d).addClass("purlForm");
            d.filter("form").addClass("purlForm")
        }).on("submit.purlForm", "form.purlForm", function (d) {
            if (a(this).data("purl-form-submit-uploaded")) return !0;
            d.stopImmediatePropagation();
            a(this).trigger("purl-form-submit");
            return !1
        }).on("purl-form-submit-uploaded", "form.purlForm", function () {
            var d = a(this),
                h = d.attr("action");
            a(document).on("ajaxComplete.purlForm", function (c, d, m) {
                m.url == h && (a(document).off("ajaxComplete.purlForm"), a("#purl_upload_progress").hide())
            });
            d.data("purl-form-submit-uploaded", !0).trigger("submit").data("purl-form-submit-uploaded", !1)
        }).on("purl-form-submit-abort", "form.purlForm", function () {
            a(document).off("ajaxComplete.purlForm");
            a("#purl_upload_progress").remove()
        }).on("purl-form-submit", "form.purlForm", function () {
            var d = this;
            a(":input", d).each(function () {
                a(this).data("purl-form-orig-name") && a(this).attr("name", a(this).data("purl-form-orig-name"))
            });
            a(d).trigger("purl-form-pre-submit");
            for (a("table.purlRecordListForm", d).each(function () {
                a("tbody>tr", this).each(function (c) {
                    for (a(':input[name*="[]"]', this).each(function () {
                        var g = a(this).attr("name"),
                            d = g.indexOf("[]");
                        a(this).data("purl-form-orig-name") || a(this).data("purl-form-orig-name", g);
                        a(this).attr("name", g.substring(0, d + 1) + c + g.substring(d + 1, g.length))
                    }); 0 < a(':input[name*="[]"]', this).length;) {
                        var g = a(':input[name*="[]"]', this).eq(0),
                            d = g.attr("name"),
                            g = g.attr("type"),
                            h = d.indexOf("[]"),
                            h = [d.substring(0, h + 1), d.substring(h + 1, d.length)],
                            d = ':input[name="' + d + '"]';
                        g && "" != g && (d += "[type" + ("file" == g ? "=" : "!=") + '"file"]');
                        a(d, this).each(function (c) {
                            a(this).data("purl-form-orig-name") || a(this).data("purl-form-orig-name", a(this).attr("name"));
                            a(this).attr("name", h.join(c))
                        })
                    }
                })
            }); 0 < a(':input[name*="[]"]', d).length;) {
                var h = a(':input[name*="[]"]', d).eq(0),
                    c = h.attr("name"),
                    h = h.attr("type"),
                    l = c.indexOf("[]"),
                    l = [c.substring(0, l + 1), c.substring(l + 1, c.length)],
                    c = ':input[name="' + c + '"]';
                h && "" != h && (c += "[type" + ("file" == h ? "=" : "!=") + '"file"]');
                a(c, d).each(function (c) {
                    a(this).data("purl-form-orig-name") || a(this).data("purl-form-orig-name", a(this).attr("name"));
                    a(this).attr("name", l.join(c))
                })
            }
            var m = !0,
                g = a("#purl_upload_progress");
            if (0 == g.length) {
                g = a('<div id="purl_upload_progress"></div>');
                g.append('<div class="_overlay"></div>');
                g.append('<div class="_progress"><div class="_bar"><p></p><div></div></div><div class="_bar"><p></p><div></div></div></div>');
                g.appendTo("body");
                c = a("._progress", g).width();
                h = a("._progress", g).height();
                g.hide().fadeIn();
                a("._progress", g).css({
                    position: "absolute",
                    left: (g.width() - c) / 2 + "px",
                    top: (g.height() - h) / 2 + "px"
                });
                var n = 0;
                a("ul.purl_imageset > li, ul.purl_fileset > li", d).each(function () {
                    a(this).data("file") &&
                    n++
                });
                g.data("steps", n);
                g.data("step", 0)
            }
            a("ul.purl_imageset > li, ul.purl_fileset > li", d).each(function () {
                var c = a(this),
                    h = c.data("file");
                if (h) {
                    m = !1;
                    var n = 100 * g.data("step") / g.data("steps");
                    g.find("._bar:eq(0) > p").text("Uploading: " + h.name);
                    g.find("._bar:eq(0) > div").html('<div style="width:' + n + '%"></div>');
                    g.data("step", g.data("step") + 1);
                    PURL.uploadFile(h, function (g, h, n, l) {
                        g ? (c.data("file", null), c.find("input[type=hidden]._file").val("filename:" + l + ":" + n), a(d).trigger("purl-form-submit")) : (alert(h),
                                a(d).trigger("purl-form-submit-abort"))
                    }, function (a, c, d) {
                        c = PURL.readableSize(a / d) + "/s";
                        d = PURL.readableSize(a) + "/" + PURL.readableSize(a);
                        a = Math.round(100 * a / a, 2);
                        var h = g.find("._bar:eq(1)");
                        h.find(">p").html("Uploaded " + d + " @" + c);
                        h.find(">div").html('<div style="width:' + a + '%"></div>')
                    });
                    return !1
                }
            });
            m && (c = 100 * g.data("step") / g.data("steps"), g.find("._bar:eq(0) > p").text("Processing data..."), g.find("._bar:eq(0) > div").html('<div style="width:' + c + '%"></div>'), g.find("._bar:eq(1) > p").text("Please wait..."),
                g.find("._bar:eq(1) > div").html('<div style="width:50%"></div>'), a(d).trigger("purl-form-submit-uploaded"));
            return !1
        }).on("purl-form-cancel", "form.purlForm", function () {
        }).on("submit.purlPopup", "#cboxLoadedContent form", function () {
            if (a(this).attr("target")) return !0;
            a(this).ajaxSubmit({
                success: function (d) {
                    a.colorbox({
                        arrowKey: !1,
                        rel: "nofollow",
                        html: d,
                        className: "cb-popup"
                    });
                    return !1
                }
            });
            return !1
        }).on("cbox_complete.purlPopup", function () {
            var d = a("#cboxLoadedContent");
            d.trigger("purl-form-init");
            d.find(":input").eq(0).focus()
        }).on("click", 'a[target="popup"]', function () {
            if (!a.colorbox) return !0;
            a.colorbox({
                className: "cb-popup",
                arrowKey: !1,
                rel: "nofollow",
                href: this.href
            });
            return !1
        }).on("click", 'a[target="slideshow"]', function () {
            if (!a.colorbox || a(this).data("popup-gallery")) return !0;
            var d = a(this),
                h = d.attr("rel"),
                c = 'a[target="slideshow"]';
            h && (c += '[rel="' + h + '"]');
            c = a(c);
            c.data("popup-gallery", !0).colorbox({
                className: "cb-slideshow",
                maxWidth: "100%",
                maxHeight: "100%",
                photo: !0,
                scalePhotos: !0,
                fixed: !0,
                scrolling: !1,
                previous: "&laquo;",
                next: "&raquo;",
                title: function () {
                    return a(this).data("title") || a(this).attr("title")
                }
            });
            d.click();
            return !1
        }).trigger("purl-loaded")
    })
})(jQuery);
window.purlMyAccount = {};
purlMyAccount.loadingShow = function (a) {
    purlMyAccount.loadingShow.elements || (purlMyAccount.loadingShow.elements = []);
    a.parent().children(".loading").length || (a = $('<div class="loading"></div>').hide().appendTo(a.parent()).css({
        position: "absolute",
        zIndex: 999,
        top: a.position().top + "px",
        left: a.position().left + "px",
        width: a.outerWidth(!0) + "px",
        height: a.outerHeight(!0) + "px"
    }).fadeIn("fast"), purlMyAccount.loadingShow.elements.push(a))
};
purlMyAccount.loadingHide = function () {
    if (purlMyAccount.loadingShow.elements) {
        var a = purlMyAccount.loadingShow.elements.pop();
        a && a.fadeOut("fast", function () {
            a.remove()
        })
    }
};
jQuery.easing.jswing = jQuery.easing.swing;
jQuery.extend(jQuery.easing, {
    def: "easeOutQuad",
    swing: function (a, d, h, c, l) {
        return jQuery.easing[jQuery.easing.def](a, d, h, c, l)
    },
    easeInQuad: function (a, d, h, c, l) {
        return c * (d /= l) * d + h
    },
    easeOutQuad: function (a, d, h, c, l) {
        return -c * (d /= l) * (d - 2) + h
    },
    easeInOutQuad: function (a, d, h, c, l) {
        return 1 > (d /= l / 2) ? c / 2 * d * d + h : -c / 2 * (--d * (d - 2) - 1) + h
    },
    easeInCubic: function (a, d, h, c, l) {
        return c * (d /= l) * d * d + h
    },
    easeOutCubic: function (a, d, h, c, l) {
        return c * ((d = d / l - 1) * d * d + 1) + h
    },
    easeInOutCubic: function (a, d, h, c, l) {
        return 1 > (d /= l / 2) ? c / 2 * d * d * d + h : c / 2 * ((d -= 2) * d * d + 2) + h
    },
    easeInQuart: function (a, d, h, c, l) {
        return c * (d /= l) * d * d * d + h
    },
    easeOutQuart: function (a, d, h, c, l) {
        return -c * ((d = d / l - 1) * d * d * d - 1) + h
    },
    easeInOutQuart: function (a, d, h, c, l) {
        return 1 > (d /= l / 2) ? c / 2 * d * d * d * d + h : -c / 2 * ((d -= 2) * d * d * d - 2) + h
    },
    easeInQuint: function (a, d, h, c, l) {
        return c * (d /= l) * d * d * d * d + h
    },
    easeOutQuint: function (a, d, h, c, l) {
        return c * ((d = d / l - 1) * d * d * d * d + 1) + h
    },
    easeInOutQuint: function (a, d, h, c, l) {
        return 1 > (d /= l / 2) ? c / 2 * d * d * d * d * d + h : c / 2 * ((d -= 2) * d * d * d * d + 2) + h
    },
    easeInSine: function (a, d, h, c, l) {
        return -c * Math.cos(d /
                l * (Math.PI / 2)) + c + h
    },
    easeOutSine: function (a, d, h, c, l) {
        return c * Math.sin(d / l * (Math.PI / 2)) + h
    },
    easeInOutSine: function (a, d, h, c, l) {
        return -c / 2 * (Math.cos(Math.PI * d / l) - 1) + h
    },
    easeInExpo: function (a, d, h, c, l) {
        return 0 == d ? h : c * Math.pow(2, 10 * (d / l - 1)) + h
    },
    easeOutExpo: function (a, d, h, c, l) {
        return d == l ? h + c : c * (-Math.pow(2, -10 * d / l) + 1) + h
    },
    easeInOutExpo: function (a, d, h, c, l) {
        return 0 == d ? h : d == l ? h + c : 1 > (d /= l / 2) ? c / 2 * Math.pow(2, 10 * (d - 1)) + h : c / 2 * (-Math.pow(2, -10 * --d) + 2) + h
    },
    easeInCirc: function (a, d, h, c, l) {
        return -c * (Math.sqrt(1 - (d /= l) * d) - 1) + h
    },
    easeOutCirc: function (a, d, h, c, l) {
        return c * Math.sqrt(1 - (d = d / l - 1) * d) + h
    },
    easeInOutCirc: function (a, d, h, c, l) {
        return 1 > (d /= l / 2) ? -c / 2 * (Math.sqrt(1 - d * d) - 1) + h : c / 2 * (Math.sqrt(1 - (d -= 2) * d) + 1) + h
    },
    easeInElastic: function (a, d, h, c, l) {
        a = 1.70158;
        var m = 0,
            g = c;
        if (0 == d) return h;
        if (1 == (d /= l)) return h + c;
        m || (m = .3 * l);
        g < Math.abs(c) ? (g = c, a = m / 4) : a = m / (2 * Math.PI) * Math.asin(c / g);
        return -(g * Math.pow(2, 10 * --d) * Math.sin(2 * (d * l - a) * Math.PI / m)) + h
    },
    easeOutElastic: function (a, d, h, c, l) {
        a = 1.70158;
        var m = 0,
            g = c;
        if (0 == d) return h;
        if (1 == (d /= l)) return h + c;
        m || (m = .3 * l);
        g < Math.abs(c) ? (g = c, a = m / 4) : a = m / (2 * Math.PI) * Math.asin(c / g);
        return g * Math.pow(2, -10 * d) * Math.sin(2 * (d * l - a) * Math.PI / m) + c + h
    },
    easeInOutElastic: function (a, d, h, c, l) {
        a = 1.70158;
        var m = 0,
            g = c;
        if (0 == d) return h;
        if (2 == (d /= l / 2)) return h + c;
        m || (m = .3 * l * 1.5);
        g < Math.abs(c) ? (g = c, a = m / 4) : a = m / (2 * Math.PI) * Math.asin(c / g);
        return 1 > d ? -.5 * g * Math.pow(2, 10 * --d) * Math.sin(2 * (d * l - a) * Math.PI / m) + h : g * Math.pow(2, -10 * --d) * Math.sin(2 * (d * l - a) * Math.PI / m) * .5 + c + h
    },
    easeInBack: function (a, d, h, c, l, m) {
        void 0 == m && (m = 1.70158);
        return c * (d /= l) * d * ((m + 1) * d - m) + h
    },
    easeOutBack: function (a, d, h, c, l, m) {
        void 0 == m && (m = 1.70158);
        return c * ((d = d / l - 1) * d * ((m + 1) * d + m) + 1) + h
    },
    easeInOutBack: function (a, d, h, c, l, m) {
        void 0 == m && (m = 1.70158);
        return 1 > (d /= l / 2) ? c / 2 * d * d * (((m *= 1.525) + 1) * d - m) + h : c / 2 * ((d -= 2) * d * (((m *= 1.525) + 1) * d + m) + 2) + h
    },
    easeInBounce: function (a, d, h, c, l) {
        return c - jQuery.easing.easeOutBounce(a, l - d, 0, c, l) + h
    },
    easeOutBounce: function (a, d, h, c, l) {
        return (d /= l) < 1 / 2.75 ? 7.5625 * c * d * d + h : d < 2 / 2.75 ? c * (7.5625 * (d -= 1.5 / 2.75) * d + .75) + h : d < 2.5 / 2.75 ? c * (7.5625 * (d -= 2.25 / 2.75) * d + .9375) + h : c * (7.5625 * (d -= 2.625 / 2.75) * d + .984375) + h
    },
    easeInOutBounce: function (a, d, h, c, l) {
        return d < l / 2 ? .5 * jQuery.easing.easeInBounce(a, 2 * d, 0, c, l) + h : .5 * jQuery.easing.easeOutBounce(a, 2 * d - l, 0, c, l) + .5 * c + h
    }
});
(function (a) {
    function d(c) {
        var d = c || window.event,
            h = [].slice.call(arguments, 1),
            g = 0,
            n = 0,
            q = 0;
        c = a.event.fix(d);
        c.type = "mousewheel";
        c.wheelDelta && (g = c.wheelDelta / 120);
        c.detail && (g = -c.detail / 3);
        q = g;
        void 0 !== d.axis && d.axis === d.HORIZONTAL_AXIS && (q = 0, n = -1 * g);
        void 0 !== d.wheelDeltaY && (q = d.wheelDeltaY / 120);
        void 0 !== d.wheelDeltaX && (n = -1 * d.wheelDeltaX / 120);
        h.unshift(c, g, n, q);
        return a.event.handle.apply(this, h)
    }

    var h = ["DOMMouseScroll", "mousewheel"];
    a.event.special.mousewheel = {
        setup: function () {
            if (this.addEventListener)
                for (var a =
                    h.length; a;) this.addEventListener(h[--a], d, !1);
            else this.onmousewheel = d
        },
        teardown: function () {
            if (this.removeEventListener)
                for (var a = h.length; a;) this.removeEventListener(h[--a], d, !1);
            else this.onmousewheel = null
        }
    };
    a.fn.extend({
        mousewheel: function (a) {
            return a ? this.bind("mousewheel", a) : this.trigger("mousewheel")
        },
        unmousewheel: function (a) {
            return this.unbind("mousewheel", a)
        }
    })
})(jQuery);
(function (a, d, h, c) {
    var l = h("html"),
        m = h(a),
        g = h(d),
        n = h.fancybox = function () {
            n.open.apply(this, arguments)
        },
        q = navigator.userAgent.match(/msie/i),
        v = null,
        u = d.createTouch !== c,
        x = function (b) {
            return b && b.hasOwnProperty && b instanceof h
        },
        w = function (b) {
            return b && "string" === h.type(b)
        },
        t = function (b) {
            return w(b) && 0 < b.indexOf("%")
        },
        y = function (b, a) {
            var f = parseInt(b, 10) || 0;
            a && t(b) && (f *= n.getViewport()[a] / 100);
            return Math.ceil(f)
        },
        A = function (b, a) {
            return y(b, a) + "px"
        };
    h.extend(n, {
        version: "2.1.5",
        defaults: {
            padding: 15,
            margin: 20,
            width: 800,
            height: 600,
            minWidth: 100,
            minHeight: 100,
            maxWidth: 9999,
            maxHeight: 9999,
            pixelRatio: 1,
            autoSize: !0,
            autoHeight: !1,
            autoWidth: !1,
            autoResize: !0,
            autoCenter: !u,
            fitToView: !0,
            aspectRatio: !1,
            topRatio: .5,
            leftRatio: .5,
            scrolling: "auto",
            wrapCSS: "",
            arrows: !0,
            closeBtn: !0,
            closeClick: !1,
            nextClick: !1,
            mouseWheel: !0,
            autoPlay: !1,
            playSpeed: 3E3,
            preload: 3,
            modal: !1,
            loop: !0,
            ajax: {
                dataType: "html",
                headers: {
                    "X-fancyBox": !0
                }
            },
            iframe: {
                scrolling: "auto",
                preload: !0
            },
            swf: {
                wmode: "transparent",
                allowfullscreen: "true",
                allowscriptaccess: "always"
            },
            keys: {
                next: {
                    13: "left",
                    34: "up",
                    39: "left",
                    40: "up"
                },
                prev: {
                    8: "right",
                    33: "down",
                    37: "right",
                    38: "down"
                },
                close: [27],
                play: [32],
                toggle: [70]
            },
            direction: {
                next: "left",
                prev: "right"
            },
            scrollOutside: !0,
            index: 0,
            type: null,
            href: null,
            content: null,
            title: null,
            tpl: {
                wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
                image: '<img class="fancybox-image" src="{href}" alt="" />',
                iframe: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' +
                (q ? ' allowtransparency="true"' : "") + "></iframe>",
                error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
                closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
                next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
                prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
            },
            openEffect: "fade",
            openSpeed: 250,
            openEasing: "swing",
            openOpacity: !0,
            openMethod: "zoomIn",
            closeEffect: "fade",
            closeSpeed: 250,
            closeEasing: "swing",
            closeOpacity: !0,
            closeMethod: "zoomOut",
            nextEffect: "elastic",
            nextSpeed: 250,
            nextEasing: "swing",
            nextMethod: "changeIn",
            prevEffect: "elastic",
            prevSpeed: 250,
            prevEasing: "swing",
            prevMethod: "changeOut",
            helpers: {
                overlay: !0,
                title: !0
            },
            onCancel: h.noop,
            beforeLoad: h.noop,
            afterLoad: h.noop,
            beforeShow: h.noop,
            afterShow: h.noop,
            beforeChange: h.noop,
            beforeClose: h.noop,
            afterClose: h.noop
        },
        group: {},
        opts: {},
        previous: null,
        coming: null,
        current: null,
        isActive: !1,
        isOpen: !1,
        isOpened: !1,
        wrap: null,
        skin: null,
        outer: null,
        inner: null,
        player: {
            timer: null,
            isActive: !1
        },
        ajaxLoad: null,
        imgPreload: null,
        transitions: {},
        helpers: {},
        open: function (b, a) {
            if (b && (h.isPlainObject(a) || (a = {}), !1 !== n.close(!0))) return h.isArray(b) || (b = x(b) ? h(b).get() : [b]), h.each(b, function (f, g) {
                var d = {},
                    l, m, q, v, u;
                "object" === h.type(g) && (g.nodeType && (g = h(g)), x(g) ? (d = {
                        href: g.data("fancybox-href") || g.attr("href"),
                        title: g.data("fancybox-title") || g.attr("title"),
                        isDom: !0,
                        element: g
                    }, h.metadata && h.extend(!0, d,
                        g.metadata())) : d = g);
                l = a.href || d.href || (w(g) ? g : null);
                m = a.title !== c ? a.title : d.title || "";
                v = (q = a.content || d.content) ? "html" : a.type || d.type;
                !v && d.isDom && (v = g.data("fancybox-type"), v || (v = (v = g.prop("class").match(/fancybox\.(\w+)/)) ? v[1] : null));
                w(l) && (v || (n.isImage(l) ? v = "image" : n.isSWF(l) ? v = "swf" : "#" === l.charAt(0) ? v = "inline" : w(g) && (v = "html", q = g)), "ajax" === v && (u = l.split(/\s+/, 2), l = u.shift(), u = u.shift()));
                q || ("inline" === v ? l ? q = h(w(l) ? l.replace(/.*(?=#[^\s]+$)/, "") : l) : d.isDom && (q = g) : "html" === v ? q = l : v || l || !d.isDom ||
                        (v = "inline", q = g));
                h.extend(d, {
                    href: l,
                    type: v,
                    content: q,
                    title: m,
                    selector: u
                });
                b[f] = d
            }), n.opts = h.extend(!0, {}, n.defaults, a), a.keys !== c && (n.opts.keys = a.keys ? h.extend({}, n.defaults.keys, a.keys) : !1), n.group = b, n._start(n.opts.index)
        },
        cancel: function () {
            var b = n.coming;
            b && !1 !== n.trigger("onCancel") && (n.hideLoading(), n.ajaxLoad && n.ajaxLoad.abort(), n.ajaxLoad = null, n.imgPreload && (n.imgPreload.onload = n.imgPreload.onerror = null), b.wrap && b.wrap.stop(!0, !0).trigger("onReset").remove(), n.coming = null, n.current || n._afterZoomOut(b))
        },
        close: function (b) {
            n.cancel();
            !1 !== n.trigger("beforeClose") && (n.unbindEvents(), n.isActive && (n.isOpen && !0 !== b ? (n.isOpen = n.isOpened = !1, n.isClosing = !0, h(".fancybox-item, .fancybox-nav").remove(), n.wrap.stop(!0, !0).removeClass("fancybox-opened"), n.transitions[n.current.closeMethod]()) : (h(".fancybox-wrap").stop(!0).trigger("onReset").remove(), n._afterZoomOut())))
        },
        play: function (b) {
            var a = function () {
                    clearTimeout(n.player.timer)
                },
                f = function () {
                    a();
                    n.current && n.player.isActive && (n.player.timer = setTimeout(n.next,
                        n.current.playSpeed))
                },
                c = function () {
                    a();
                    g.unbind(".player");
                    n.player.isActive = !1;
                    n.trigger("onPlayEnd")
                };
            !0 === b || !n.player.isActive && !1 !== b ? n.current && (n.current.loop || n.current.index < n.group.length - 1) && (n.player.isActive = !0, g.bind({
                    "onCancel.player beforeClose.player": c,
                    "onUpdate.player": f,
                    "beforeLoad.player": a
                }), f(), n.trigger("onPlayStart")) : c()
        },
        next: function (b) {
            var a = n.current;
            a && (w(b) || (b = a.direction.next), n.jumpto(a.index + 1, b, "next"))
        },
        prev: function (b) {
            var a = n.current;
            a && (w(b) || (b = a.direction.prev),
                n.jumpto(a.index - 1, b, "prev"))
        },
        jumpto: function (b, a, f) {
            var g = n.current;
            g && (b = y(b), n.direction = a || g.direction[b >= g.index ? "next" : "prev"], n.router = f || "jumpto", g.loop && (0 > b && (b = g.group.length + b % g.group.length), b %= g.group.length), g.group[b] !== c && (n.cancel(), n._start(b)))
        },
        reposition: function (b, a) {
            var f = n.current,
                c = f ? f.wrap : null,
                g;
            c && (g = n._getPosition(a), b && "scroll" === b.type ? (delete g.position, c.stop(!0, !0).animate(g, 200)) : (c.css(g), f.pos = h.extend({}, f.dim, g)))
        },
        update: function (b) {
            var a = b && b.type,
                f = !a ||
                    "orientationchange" === a;
            f && (clearTimeout(v), v = null);
            n.isOpen && !v && (v = setTimeout(function () {
                var c = n.current;
                c && !n.isClosing && (n.wrap.removeClass("fancybox-tmp"), (f || "load" === a || "resize" === a && c.autoResize) && n._setDimension(), "scroll" === a && c.canShrink || n.reposition(b), n.trigger("onUpdate"), v = null)
            }, f && !u ? 0 : 300))
        },
        toggle: function (b) {
            n.isOpen && (n.current.fitToView = "boolean" === h.type(b) ? b : !n.current.fitToView, u && (n.wrap.removeAttr("style").addClass("fancybox-tmp"), n.trigger("onUpdate")), n.update())
        },
        hideLoading: function () {
            g.unbind(".loading");
            h("#fancybox-loading").remove()
        },
        showLoading: function () {
            var b, a;
            n.hideLoading();
            b = h('<div id="fancybox-loading"><div></div></div>').click(n.cancel).appendTo("body");
            g.bind("keydown.loading", function (b) {
                27 === (b.which || b.keyCode) && (b.preventDefault(), n.cancel())
            });
            n.defaults.fixed || (a = n.getViewport(), b.css({
                position: "absolute",
                top: .5 * a.h + a.y,
                left: .5 * a.w + a.x
            }))
        },
        getViewport: function () {
            var b = n.current && n.current.locked || !1,
                e = {
                    x: m.scrollLeft(),
                    y: m.scrollTop()
                };
            b ? (e.w = b[0].clientWidth, e.h = b[0].clientHeight) :
                (e.w = u && a.innerWidth ? a.innerWidth : m.width(), e.h = u && a.innerHeight ? a.innerHeight : m.height());
            return e
        },
        unbindEvents: function () {
            n.wrap && x(n.wrap) && n.wrap.unbind(".fb");
            g.unbind(".fb");
            m.unbind(".fb")
        },
        bindEvents: function () {
            var b = n.current,
                a;
            b && (m.bind("orientationchange.fb" + (u ? "" : " resize.fb") + (b.autoCenter && !b.locked ? " scroll.fb" : ""), n.update), (a = b.keys) && g.bind("keydown.fb", function (f) {
                var g = f.which || f.keyCode,
                    d = f.target || f.srcElement;
                if (27 === g && n.coming) return !1;
                f.ctrlKey || f.altKey || f.shiftKey || f.metaKey ||
                d && (d.type || h(d).is("[contenteditable]")) || h.each(a, function (a, e) {
                    if (1 < b.group.length && e[g] !== c) return n[a](e[g]), f.preventDefault(), !1;
                    if (-1 < h.inArray(g, e)) return n[a](), f.preventDefault(), !1
                })
            }), h.fn.mousewheel && b.mouseWheel && n.wrap.bind("mousewheel.fb", function (a, e, c, g) {
                for (var d = h(a.target || null), l = !1; d.length && !(l || d.is(".fancybox-skin") || d.is(".fancybox-wrap"));) l = (l = d[0]) && !(l.style.overflow && "hidden" === l.style.overflow) && (l.clientWidth && l.scrollWidth > l.clientWidth || l.clientHeight && l.scrollHeight >
                    l.clientHeight), d = h(d).parent();
                0 !== e && !l && 1 < n.group.length && !b.canShrink && (0 < g || 0 < c ? n.prev(0 < g ? "down" : "left") : (0 > g || 0 > c) && n.next(0 > g ? "up" : "right"), a.preventDefault())
            }))
        },
        trigger: function (b, a) {
            var f, c = a || n.coming || n.current;
            if (c) {
                h.isFunction(c[b]) && (f = c[b].apply(c, Array.prototype.slice.call(arguments, 1)));
                if (!1 === f) return !1;
                c.helpers && h.each(c.helpers, function (a, e) {
                    if (e && n.helpers[a] && h.isFunction(n.helpers[a][b])) n.helpers[a][b](h.extend(!0, {}, n.helpers[a].defaults, e), c)
                });
                g.trigger(b)
            }
        },
        isImage: function (b) {
            return w(b) &&
                b.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i)
        },
        isSWF: function (b) {
            return w(b) && b.match(/\.(swf)((\?|#).*)?$/i)
        },
        _start: function (b) {
            var a = {},
                f, c;
            b = y(b);
            f = n.group[b] || null;
            if (!f) return !1;
            a = h.extend(!0, {}, n.opts, f);
            f = a.margin;
            c = a.padding;
            "number" === h.type(f) && (a.margin = [f, f, f, f]);
            "number" === h.type(c) && (a.padding = [c, c, c, c]);
            a.modal && h.extend(!0, a, {
                closeBtn: !1,
                closeClick: !1,
                nextClick: !1,
                arrows: !1,
                mouseWheel: !1,
                keys: null,
                helpers: {
                    overlay: {
                        closeClick: !1
                    }
                }
            });
            a.autoSize &&
            (a.autoWidth = a.autoHeight = !0);
            "auto" === a.width && (a.autoWidth = !0);
            "auto" === a.height && (a.autoHeight = !0);
            a.group = n.group;
            a.index = b;
            n.coming = a;
            if (!1 === n.trigger("beforeLoad")) n.coming = null;
            else {
                c = a.type;
                f = a.href;
                if (!c) return n.coming = null, n.current && n.router && "jumpto" !== n.router ? (n.current.index = b, n[n.router](n.direction)) : !1;
                n.isActive = !0;
                if ("image" === c || "swf" === c) a.autoHeight = a.autoWidth = !1, a.scrolling = "visible";
                "image" === c && (a.aspectRatio = !0);
                "iframe" === c && u && (a.scrolling = "scroll");
                a.wrap = h(a.tpl.wrap).addClass("fancybox-" +
                    (u ? "mobile" : "desktop") + " fancybox-type-" + c + " fancybox-tmp " + a.wrapCSS).appendTo(a.parent || "body");
                h.extend(a, {
                    skin: h(".fancybox-skin", a.wrap),
                    outer: h(".fancybox-outer", a.wrap),
                    inner: h(".fancybox-inner", a.wrap)
                });
                h.each(["Top", "Right", "Bottom", "Left"], function (b, f) {
                    a.skin.css("padding" + f, A(a.padding[b]))
                });
                n.trigger("onReady");
                if ("inline" === c || "html" === c) {
                    if (!a.content || !a.content.length) return n._error("content")
                } else if (!f) return n._error("href");
                "image" === c ? n._loadImage() : "ajax" === c ? n._loadAjax() :
                        "iframe" === c ? n._loadIframe() : n._afterLoad()
            }
        },
        _error: function (b) {
            h.extend(n.coming, {
                type: "html",
                autoWidth: !0,
                autoHeight: !0,
                minWidth: 0,
                minHeight: 0,
                scrolling: "no",
                hasError: b,
                content: n.coming.tpl.error
            });
            n._afterLoad()
        },
        _loadImage: function () {
            var b = n.imgPreload = new Image;
            b.onload = function () {
                this.onload = this.onerror = null;
                n.coming.width = this.width / n.opts.pixelRatio;
                n.coming.height = this.height / n.opts.pixelRatio;
                n._afterLoad()
            };
            b.onerror = function () {
                this.onload = this.onerror = null;
                n._error("image")
            };
            b.src = n.coming.href;
            !0 !== b.complete && n.showLoading()
        },
        _loadAjax: function () {
            var b = n.coming;
            n.showLoading();
            n.ajaxLoad = h.ajax(h.extend({}, b.ajax, {
                url: b.href,
                error: function (b, a) {
                    n.coming && "abort" !== a ? n._error("ajax", b) : n.hideLoading()
                },
                success: function (a, f) {
                    "success" === f && (b.content = a, n._afterLoad())
                }
            }))
        },
        _loadIframe: function () {
            var b = n.coming,
                a = h(b.tpl.iframe.replace(/\{rnd\}/g, (new Date).getTime())).attr("scrolling", u ? "auto" : b.iframe.scrolling).attr("src", b.href);
            h(b.wrap).bind("onReset", function () {
                try {
                    h(this).find("iframe").hide().attr("src",
                        "//about:blank").end().empty()
                } catch (b) {
                }
            });
            b.iframe.preload && (n.showLoading(), a.one("load", function () {
                h(this).data("ready", 1);
                u || h(this).bind("load.fb", n.update);
                h(this).parents(".fancybox-wrap").width("100%").removeClass("fancybox-tmp").show();
                n._afterLoad()
            }));
            b.content = a.appendTo(b.inner);
            b.iframe.preload || n._afterLoad()
        },
        _preloadImages: function () {
            var b = n.group,
                a = n.current,
                f = b.length,
                c = a.preload ? Math.min(a.preload, f - 1) : 0,
                g, d;
            for (d = 1; d <= c; d += 1) g = b[(a.index + d) % f], "image" === g.type && g.href && ((new Image).src =
                g.href)
        },
        _afterLoad: function () {
            var b = n.coming,
                a = n.current,
                f, c, g, d, l;
            n.hideLoading();
            if (b && !1 !== n.isActive)
                if (!1 === n.trigger("afterLoad", b, a)) b.wrap.stop(!0).trigger("onReset").remove(), n.coming = null;
                else {
                    a && (n.trigger("beforeChange", a), a.wrap.stop(!0).removeClass("fancybox-opened").find(".fancybox-item, .fancybox-nav").remove());
                    n.unbindEvents();
                    f = b.content;
                    c = b.type;
                    g = b.scrolling;
                    h.extend(n, {
                        wrap: b.wrap,
                        skin: b.skin,
                        outer: b.outer,
                        inner: b.inner,
                        current: b,
                        previous: a
                    });
                    d = b.href;
                    switch (c) {
                        case "inline":
                        case "ajax":
                        case "html":
                            b.selector ?
                                f = h("<div>").html(f).find(b.selector) : x(f) && (f.data("fancybox-placeholder") || f.data("fancybox-placeholder", h('<div class="fancybox-placeholder"></div>').insertAfter(f).hide()), f = f.show().detach(), b.wrap.bind("onReset", function () {
                                    h(this).find(f).length && f.hide().replaceAll(f.data("fancybox-placeholder")).data("fancybox-placeholder", !1)
                                }));
                            break;
                        case "image":
                            f = b.tpl.image.replace("{href}", d);
                            break;
                        case "swf":
                            f = '<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="' +
                                d + '"></param>', l = "", h.each(b.swf, function (b, a) {
                                f += '<param name="' + b + '" value="' + a + '"></param>';
                                l += " " + b + '="' + a + '"'
                            }), f += '<embed src="' + d + '" type="application/x-shockwave-flash" width="100%" height="100%"' + l + "></embed></object>"
                    }
                    x(f) && f.parent().is(b.inner) || b.inner.append(f);
                    n.trigger("beforeShow");
                    b.inner.css("overflow", "yes" === g ? "scroll" : "no" === g ? "hidden" : g);
                    n._setDimension();
                    n.reposition();
                    n.isOpen = !1;
                    n.coming = null;
                    n.bindEvents();
                    if (!n.isOpened) h(".fancybox-wrap").not(b.wrap).stop(!0).trigger("onReset").remove();
                    else if (a.prevMethod) n.transitions[a.prevMethod]();
                    n.transitions[n.isOpened ? b.nextMethod : b.openMethod]();
                    n._preloadImages()
                }
        },
        _setDimension: function () {
            var b = n.getViewport(),
                a = 0,
                f = !1,
                c = !1,
                f = n.wrap,
                g = n.skin,
                d = n.inner,
                l = n.current,
                c = l.width,
                m = l.height,
                q = l.minWidth,
                v = l.minHeight,
                w = l.maxWidth,
                u = l.maxHeight,
                x = l.scrolling,
                L = l.scrollOutside ? l.scrollbarWidth : 0,
                C = l.margin,
                M = y(C[1] + C[3]),
                H = y(C[0] + C[2]),
                O, N, Y, P, I, B, V, aa, da;
            f.add(g).add(d).width("auto").height("auto").removeClass("fancybox-tmp");
            C = y(g.outerWidth(!0) -
                g.width());
            O = y(g.outerHeight(!0) - g.height());
            N = M + C;
            Y = H + O;
            P = t(c) ? (b.w - N) * y(c) / 100 : c;
            I = t(m) ? (b.h - Y) * y(m) / 100 : m;
            if ("iframe" === l.type) {
                if (da = l.content, l.autoHeight && 1 === da.data("ready")) try {
                    da[0].contentWindow.document.location && (d.width(P).height(9999), B = da.contents().find("body"), L && B.css("overflow-x", "hidden"), I = B.outerHeight(!0))
                } catch (ea) {
                }
            } else if (l.autoWidth || l.autoHeight) d.addClass("fancybox-tmp"), l.autoWidth || d.width(P), l.autoHeight || d.height(I), l.autoWidth && (P = d.width()), l.autoHeight && (I = d.height()),
                d.removeClass("fancybox-tmp");
            c = y(P);
            m = y(I);
            aa = P / I;
            q = y(t(q) ? y(q, "w") - N : q);
            w = y(t(w) ? y(w, "w") - N : w);
            v = y(t(v) ? y(v, "h") - Y : v);
            u = y(t(u) ? y(u, "h") - Y : u);
            B = w;
            V = u;
            l.fitToView && (w = Math.min(b.w - N, w), u = Math.min(b.h - Y, u));
            N = b.w - M;
            H = b.h - H;
            l.aspectRatio ? (c > w && (c = w, m = y(c / aa)), m > u && (m = u, c = y(m * aa)), c < q && (c = q, m = y(c / aa)), m < v && (m = v, c = y(m * aa))) : (c = Math.max(q, Math.min(c, w)), l.autoHeight && "iframe" !== l.type && (d.width(c), m = d.height()), m = Math.max(v, Math.min(m, u)));
            if (l.fitToView)
                if (d.width(c).height(m), f.width(c + C), b = f.width(),
                        M = f.height(), l.aspectRatio)
                    for (;
                        (b > N || M > H) && c > q && m > v && !(19 < a++);) m = Math.max(v, Math.min(u, m - 10)), c = y(m * aa), c < q && (c = q, m = y(c / aa)), c > w && (c = w, m = y(c / aa)), d.width(c).height(m), f.width(c + C), b = f.width(), M = f.height();
                else c = Math.max(q, Math.min(c, c - (b - N))), m = Math.max(v, Math.min(m, m - (M - H)));
            L && "auto" === x && m < I && c + C + L < N && (c += L);
            d.width(c).height(m);
            f.width(c + C);
            b = f.width();
            M = f.height();
            f = (b > N || M > H) && c > q && m > v;
            c = l.aspectRatio ? c < B && m < V && c < P && m < I : (c < B || m < V) && (c < P || m < I);
            h.extend(l, {
                dim: {
                    width: A(b),
                    height: A(M)
                },
                origWidth: P,
                origHeight: I,
                canShrink: f,
                canExpand: c,
                wPadding: C,
                hPadding: O,
                wrapSpace: M - g.outerHeight(!0),
                skinSpace: g.height() - m
            });
            !da && l.autoHeight && m > v && m < u && !c && d.height("auto")
        },
        _getPosition: function (b) {
            var a = n.current,
                f = n.getViewport(),
                c = a.margin,
                g = n.wrap.width() + c[1] + c[3],
                d = n.wrap.height() + c[0] + c[2],
                c = {
                    position: "absolute",
                    top: c[0],
                    left: c[3]
                };
            a.autoCenter && a.fixed && !b && d <= f.h && g <= f.w ? c.position = "fixed" : a.locked || (c.top += f.y, c.left += f.x);
            c.top = A(Math.max(c.top, c.top + (f.h - d) * a.topRatio));
            c.left = A(Math.max(c.left,
                c.left + (f.w - g) * a.leftRatio));
            return c
        },
        _afterZoomIn: function () {
            var b = n.current;
            b && ((n.isOpen = n.isOpened = !0, n.wrap.css("overflow", "visible").addClass("fancybox-opened"), n.update(), (b.closeClick || b.nextClick && 1 < n.group.length) && n.inner.css("cursor", "pointer").bind("click.fb", function (a) {
                h(a.target).is("a") || h(a.target).parent().is("a") || (a.preventDefault(), n[b.closeClick ? "close" : "next"]())
            }), b.closeBtn && h(b.tpl.closeBtn).appendTo(n.skin).bind("click.fb", function (b) {
                b.preventDefault();
                n.close()
            }), b.arrows &&
            1 < n.group.length && ((b.loop || 0 < b.index) && h(b.tpl.prev).appendTo(n.outer).bind("click.fb", n.prev), (b.loop || b.index < n.group.length - 1) && h(b.tpl.next).appendTo(n.outer).bind("click.fb", n.next)), n.trigger("afterShow"), b.loop || b.index !== b.group.length - 1) ? n.opts.autoPlay && !n.player.isActive && (n.opts.autoPlay = !1, n.play()) : n.play(!1))
        },
        _afterZoomOut: function (b) {
            b = b || n.current;
            h(".fancybox-wrap").trigger("onReset").remove();
            h.extend(n, {
                group: {},
                opts: {},
                router: !1,
                current: null,
                isActive: !1,
                isOpened: !1,
                isOpen: !1,
                isClosing: !1,
                wrap: null,
                skin: null,
                outer: null,
                inner: null
            });
            n.trigger("afterClose", b)
        }
    });
    n.transitions = {
        getOrigPosition: function () {
            var b = n.current,
                a = b.element,
                c = b.orig,
                g = {},
                d = 50,
                h = 50,
                l = b.hPadding,
                m = b.wPadding,
                q = n.getViewport();
            !c && b.isDom && a.is(":visible") && (c = a.find("img:first"), c.length || (c = a));
            x(c) ? (g = c.offset(), c.is("img") && (d = c.outerWidth(), h = c.outerHeight())) : (g.top = q.y + (q.h - h) * b.topRatio, g.left = q.x + (q.w - d) * b.leftRatio);
            if ("fixed" === n.wrap.css("position") || b.locked) g.top -= q.y, g.left -= q.x;
            return g = {
                top: A(g.top - l * b.topRatio),
                left: A(g.left - m * b.leftRatio),
                width: A(d + m),
                height: A(h + l)
            }
        },
        step: function (b, a) {
            var c, g, d = a.prop;
            g = n.current;
            var h = g.wrapSpace,
                l = g.skinSpace;
            if ("width" === d || "height" === d) c = a.end === a.start ? 1 : (b - a.start) / (a.end - a.start), n.isClosing && (c = 1 - c), g = "width" === d ? g.wPadding : g.hPadding, g = b - g, n.skin[d](y("width" === d ? g : g - h * c)), n.inner[d](y("width" === d ? g : g - h * c - l * c))
        },
        zoomIn: function () {
            var b = n.current,
                a = b.pos,
                c = b.openEffect,
                g = "elastic" === c,
                d = h.extend({
                    opacity: 1
                }, a);
            delete d.position;
            g ? (a =
                    this.getOrigPosition(), b.openOpacity && (a.opacity = .1)) : "fade" === c && (a.opacity = .1);
            n.wrap.css(a).animate(d, {
                duration: "none" === c ? 0 : b.openSpeed,
                easing: b.openEasing,
                step: g ? this.step : null,
                complete: n._afterZoomIn
            })
        },
        zoomOut: function () {
            var b = n.current,
                a = b.closeEffect,
                c = "elastic" === a,
                g = {
                    opacity: .1
                };
            c && (g = this.getOrigPosition(), b.closeOpacity && (g.opacity = .1));
            n.wrap.animate(g, {
                duration: "none" === a ? 0 : b.closeSpeed,
                easing: b.closeEasing,
                step: c ? this.step : null,
                complete: n._afterZoomOut
            })
        },
        changeIn: function () {
            var b =
                    n.current,
                a = b.nextEffect,
                c = b.pos,
                g = {
                    opacity: 1
                },
                d = n.direction,
                h;
            c.opacity = .1;
            "elastic" === a && (h = "down" === d || "up" === d ? "top" : "left", "down" === d || "right" === d ? (c[h] = A(y(c[h]) - 200), g[h] = "+=200px") : (c[h] = A(y(c[h]) + 200), g[h] = "-=200px"));
            "none" === a ? n._afterZoomIn() : n.wrap.css(c).animate(g, {
                    duration: b.nextSpeed,
                    easing: b.nextEasing,
                    complete: n._afterZoomIn
                })
        },
        changeOut: function () {
            var b = n.previous,
                a = b.prevEffect,
                c = {
                    opacity: .1
                },
                g = n.direction;
            "elastic" === a && (c["down" === g || "up" === g ? "top" : "left"] = ("up" === g || "left" ===
                g ? "-" : "+") + "=200px");
            b.wrap.animate(c, {
                duration: "none" === a ? 0 : b.prevSpeed,
                easing: b.prevEasing,
                complete: function () {
                    h(this).trigger("onReset").remove()
                }
            })
        }
    };
    n.helpers.overlay = {
        defaults: {
            closeClick: !0,
            speedOut: 200,
            showEarly: !0,
            css: {},
            locked: !u,
            fixed: !0
        },
        overlay: null,
        fixed: !1,
        el: h("html"),
        create: function (b) {
            b = h.extend({}, this.defaults, b);
            this.overlay && this.close();
            this.overlay = h('<div class="fancybox-overlay"></div>').appendTo(n.coming ? n.coming.parent : b.parent);
            this.fixed = !1;
            b.fixed && n.defaults.fixed &&
            (this.overlay.addClass("fancybox-overlay-fixed"), this.fixed = !0)
        },
        open: function (b) {
            var a = this;
            b = h.extend({}, this.defaults, b);
            this.overlay ? this.overlay.unbind(".overlay").width("auto").height("auto") : this.create(b);
            this.fixed || (m.bind("resize.overlay", h.proxy(this.update, this)), this.update());
            b.closeClick && this.overlay.bind("click.overlay", function (b) {
                if (h(b.target).hasClass("fancybox-overlay")) return n.isActive ? n.close() : a.close(), !1
            });
            this.overlay.css(b.css).show()
        },
        close: function () {
            var b, a;
            m.unbind("resize.overlay");
            this.el.hasClass("fancybox-lock") && (h(".fancybox-margin").removeClass("fancybox-margin"), b = m.scrollTop(), a = m.scrollLeft(), this.el.removeClass("fancybox-lock"), m.scrollTop(b).scrollLeft(a));
            h(".fancybox-overlay").remove().hide();
            h.extend(this, {
                overlay: null,
                fixed: !1
            })
        },
        update: function () {
            var b = "100%",
                a;
            this.overlay.width(b).height("100%");
            q ? (a = Math.max(d.documentElement.offsetWidth, d.body.offsetWidth), g.width() > a && (b = g.width())) : g.width() > m.width() && (b = g.width());
            this.overlay.width(b).height(g.height())
        },
        onReady: function (b, a) {
            var c = this.overlay;
            h(".fancybox-overlay").stop(!0, !0);
            c || this.create(b);
            b.locked && this.fixed && a.fixed && (c || (this.margin = g.height() > m.height() ? h("html").css("margin-right").replace("px", "") : !1), a.locked = this.overlay.append(a.wrap), a.fixed = !1);
            !0 === b.showEarly && this.beforeShow.apply(this, arguments)
        },
        beforeShow: function (b, a) {
            var c, g;
            a.locked && (!1 !== this.margin && (h("*").filter(function () {
                return "fixed" === h(this).css("position") && !h(this).hasClass("fancybox-overlay") && !h(this).hasClass("fancybox-wrap")
            }).addClass("fancybox-margin"),
                this.el.addClass("fancybox-margin")), c = m.scrollTop(), g = m.scrollLeft(), this.el.addClass("fancybox-lock"), m.scrollTop(c).scrollLeft(g));
            this.open(b)
        },
        onUpdate: function () {
            this.fixed || this.update()
        },
        afterClose: function (b) {
            this.overlay && !n.coming && this.overlay.fadeOut(b.speedOut, h.proxy(this.close, this))
        }
    };
    n.helpers.title = {
        defaults: {
            type: "float",
            position: "bottom"
        },
        beforeShow: function (b) {
            var a = n.current,
                c = a.title,
                g = b.type;
            h.isFunction(c) && (c = c.call(a.element, a));
            if (w(c) && "" !== h.trim(c)) {
                a = h('<div class="fancybox-title fancybox-title-' +
                    g + '-wrap">' + c + "</div>");
                switch (g) {
                    case "inside":
                        g = n.skin;
                        break;
                    case "outside":
                        g = n.wrap;
                        break;
                    case "over":
                        g = n.inner;
                        break;
                    default:
                        g = n.skin, a.appendTo("body"), q && a.width(a.width()), a.wrapInner('<span class="child"></span>'), n.current.margin[2] += Math.abs(y(a.css("margin-bottom")))
                }
                a["top" === b.position ? "prependTo" : "appendTo"](g)
            }
        }
    };
    h.fn.fancybox = function (b) {
        var a, c = h(this),
            d = this.selector || "",
            l = function (g) {
                var l = h(this).blur(),
                    m = a,
                    q, v;
                g.ctrlKey || g.altKey || g.shiftKey || g.metaKey || l.is(".fancybox-wrap") ||
                (q = b.groupAttr || "data-fancybox-group", v = l.attr(q), v || (q = "rel", v = l.get(0)[q]), v && "" !== v && "nofollow" !== v && (l = d.length ? h(d) : c, l = l.filter("[" + q + '="' + v + '"]'), m = l.index(this)), b.index = m, !1 !== n.open(l, b) && g.preventDefault())
            };
        b = b || {};
        a = b.index || 0;
        d && !1 !== b.live ? g.undelegate(d, "click.fb-start").delegate(d + ":not('.fancybox-item, .fancybox-nav')", "click.fb-start", l) : c.unbind("click.fb-start").bind("click.fb-start", l);
        this.filter("[data-fancybox-start=1]").trigger("click");
        return this
    };
    g.ready(function () {
        var b,
            e;
        h.scrollbarWidth === c && (h.scrollbarWidth = function () {
            var b = h('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo("body"),
                a = b.children(),
                a = a.innerWidth() - a.height(99).innerWidth();
            b.remove();
            return a
        });
        h.support.fixedPosition === c && (h.support.fixedPosition = function () {
            var b = h('<div style="position:fixed;top:20px;"></div>').appendTo("body"),
                a = 20 === b[0].offsetTop || 15 === b[0].offsetTop;
            b.remove();
            return a
        }());
        h.extend(n.defaults, {
            scrollbarWidth: h.scrollbarWidth(),
            fixed: h.support.fixedPosition,
            parent: h("body")
        });
        b = h(a).width();
        l.addClass("fancybox-lock-test");
        e = h(a).width();
        l.removeClass("fancybox-lock-test");
        h("<style type='text/css'>.fancybox-margin{margin-right:" + (e - b) + "px;}</style>").appendTo("head")
    })
})(window, document, jQuery);
+function (a) {
    var d = function (c) {
        a(c).on("click", '[data-dismiss="alert"]', this.close)
    };
    d.prototype.close = function (c) {
        function d() {
            n.trigger("closed.bs.alert").remove()
        }

        var h = a(this),
            g = h.attr("data-target");
        g || (g = (g = h.attr("href")) && g.replace(/.*(?=#[^\s]*$)/, ""));
        var n = a(g);
        c && c.preventDefault();
        n.length || (n = h.hasClass("alert") ? h : h.parent());
        n.trigger(c = a.Event("close.bs.alert"));
        c.isDefaultPrevented() || (n.removeClass("in"), a.support.transition && n.hasClass("fade") ? n.one(a.support.transition.end, d).emulateTransitionEnd(150) :
            d())
    };
    var h = a.fn.alert;
    a.fn.alert = function (c) {
        return this.each(function () {
            var h = a(this),
                m = h.data("bs.alert");
            m || h.data("bs.alert", m = new d(this));
            "string" == typeof c && m[c].call(h)
        })
    };
    a.fn.alert.Constructor = d;
    a.fn.alert.noConflict = function () {
        a.fn.alert = h;
        return this
    };
    a(document).on("click.bs.alert.data-api", '[data-dismiss="alert"]', d.prototype.close)
}(jQuery);
+
    function (a) {
        var d = function (c, h) {
            this.$element = a(c);
            this.options = a.extend({}, d.DEFAULTS, h);
            this.isLoading = !1
        };
        d.DEFAULTS = {
            loadingText: "loading..."
        };
        d.prototype.setState = function (c) {
            var d = this.$element,
                h = d.is("input") ? "val" : "html",
                g = d.data();
            c += "Text";
            g.resetText || d.data("resetText", d[h]());
            d[h](g[c] || this.options[c]);
            setTimeout(a.proxy(function () {
                    "loadingText" == c ? (this.isLoading = !0, d.addClass("disabled").attr("disabled", "disabled")) : this.isLoading && (this.isLoading = !1, d.removeClass("disabled").removeAttr("disabled"))
                },
                this), 0)
        };
        d.prototype.toggle = function () {
            var a = !0,
                d = this.$element.closest('[data-toggle="buttons"]');
            if (d.length) {
                var h = this.$element.find("input");
                "radio" == h.prop("type") && (h.prop("checked") && this.$element.hasClass("active") ? a = !1 : d.find(".active").removeClass("active"));
                a && h.prop("checked", !this.$element.hasClass("active")).trigger("change")
            }
            a && this.$element.toggleClass("active")
        };
        var h = a.fn.button;
        a.fn.button = function (c) {
            return this.each(function () {
                var h = a(this),
                    m = h.data("bs.button"),
                    g = "object" == typeof c && c;
                m || h.data("bs.button", m = new d(this, g));
                "toggle" == c ? m.toggle() : c && m.setState(c)
            })
        };
        a.fn.button.Constructor = d;
        a.fn.button.noConflict = function () {
            a.fn.button = h;
            return this
        };
        a(document).on("click.bs.button.data-api", "[data-toggle^=button]", function (c) {
            var d = a(c.target);
            d.hasClass("btn") || (d = d.closest(".btn"));
            d.button("toggle");
            c.preventDefault()
        })
    }(jQuery);
+
    function (a) {
        var d = function (c, d) {
            this.$element = a(c);
            this.$indicators = this.$element.find(".carousel-indicators");
            this.options = d;
            this.paused = this.sliding = this.interval = this.$active = this.$items = null;
            "hover" == this.options.pause && this.$element.on("mouseenter", a.proxy(this.pause, this)).on("mouseleave", a.proxy(this.cycle, this))
        };
        d.DEFAULTS = {
            interval: 5E3,
            pause: "hover",
            wrap: !0
        };
        d.prototype.cycle = function (c) {
            c || (this.paused = !1);
            this.interval && clearInterval(this.interval);
            this.options.interval && !this.paused &&
            (this.interval = setInterval(a.proxy(this.next, this), this.options.interval));
            return this
        };
        d.prototype.getActiveIndex = function () {
            this.$active = this.$element.find(".item.active");
            this.$items = this.$active.parent().children();
            return this.$items.index(this.$active)
        };
        d.prototype.to = function (c) {
            var d = this,
                h = this.getActiveIndex();
            if (!(c > this.$items.length - 1 || 0 > c)) return this.sliding ? this.$element.one("slid.bs.carousel", function () {
                    d.to(c)
                }) : h == c ? this.pause().cycle() : this.slide(c > h ? "next" : "prev", a(this.$items[c]))
        };
        d.prototype.pause = function (c) {
            c || (this.paused = !0);
            this.$element.find(".next, .prev").length && a.support.transition && (this.$element.trigger(a.support.transition.end), this.cycle(!0));
            this.interval = clearInterval(this.interval);
            return this
        };
        d.prototype.next = function () {
            if (!this.sliding) return this.slide("next")
        };
        d.prototype.prev = function () {
            if (!this.sliding) return this.slide("prev")
        };
        d.prototype.slide = function (c, d) {
            var h = this.$element.find(".item.active"),
                g = d || h[c](),
                n = this.interval,
                q = "next" == c ? "left" : "right",
                v = "next" == c ? "first" : "last",
                u = this;
            if (!g.length) {
                if (!this.options.wrap) return;
                g = this.$element.find(".item")[v]()
            }
            if (g.hasClass("active")) return this.sliding = !1;
            v = a.Event("slide.bs.carousel", {
                relatedTarget: g[0],
                direction: q
            });
            this.$element.trigger(v);
            if (!v.isDefaultPrevented()) return this.sliding = !0, n && this.pause(), this.$indicators.length && (this.$indicators.find(".active").removeClass("active"), this.$element.one("slid.bs.carousel", function () {
                var c = a(u.$indicators.children()[u.getActiveIndex()]);
                c && c.addClass("active")
            })),
                a.support.transition && this.$element.hasClass("slide") ? (g.addClass(c), g[0].offsetWidth, h.addClass(q), g.addClass(q), h.one(a.support.transition.end, function () {
                        g.removeClass([c, q].join(" ")).addClass("active");
                        h.removeClass(["active", q].join(" "));
                        u.sliding = !1;
                        setTimeout(function () {
                            u.$element.trigger("slid.bs.carousel")
                        }, 0)
                    }).emulateTransitionEnd(1E3 * h.css("transition-duration").slice(0, -1))) : (h.removeClass("active"), g.addClass("active"), this.sliding = !1, this.$element.trigger("slid.bs.carousel")), n && this.cycle(),
                this
        };
        var h = a.fn.carousel;
        a.fn.carousel = function (c) {
            return this.each(function () {
                var h = a(this),
                    m = h.data("bs.carousel"),
                    g = a.extend({}, d.DEFAULTS, h.data(), "object" == typeof c && c),
                    n = "string" == typeof c ? c : g.slide;
                m || h.data("bs.carousel", m = new d(this, g));
                if ("number" == typeof c) m.to(c);
                else if (n) m[n]();
                else g.interval && m.pause().cycle()
            })
        };
        a.fn.carousel.Constructor = d;
        a.fn.carousel.noConflict = function () {
            a.fn.carousel = h;
            return this
        };
        a(document).on("click.bs.carousel.data-api", "[data-slide], [data-slide-to]",
            function (c) {
                var d = a(this),
                    h, g = a(d.attr("data-target") || (h = d.attr("href")) && h.replace(/.*(?=#[^\s]+$)/, ""));
                h = a.extend({}, g.data(), d.data());
                var n = d.attr("data-slide-to");
                n && (h.interval = !1);
                g.carousel(h);
                (n = d.attr("data-slide-to")) && g.data("bs.carousel").to(n);
                c.preventDefault()
            });
        a(window).on("load", function () {
            a('[data-ride="carousel"]').each(function () {
                var c = a(this);
                c.carousel(c.data())
            })
        })
    }(jQuery);
+
    function (a) {
        function d(c) {
            a(".dropdown-backdrop").remove();
            a("[data-toggle=dropdown]").each(function () {
                var g = h(a(this)),
                    d = {
                        relatedTarget: this
                    };
                g.hasClass("open") && (g.trigger(c = a.Event("hide.bs.dropdown", d)), c.isDefaultPrevented() || g.removeClass("open").trigger("hidden.bs.dropdown", d))
            })
        }

        function h(c) {
            var g = c.attr("data-target");
            g || (g = (g = c.attr("href")) && /#[A-Za-z]/.test(g) && g.replace(/.*(?=#[^\s]*$)/, ""));
            return (g = g && a(g)) && g.length ? g : c.parent()
        }

        var c = function (c) {
            a(c).on("click.bs.dropdown", this.toggle)
        };
        c.prototype.toggle = function (c) {
            var g = a(this);
            if (!g.is(".disabled, :disabled")) {
                var l = h(g);
                c = l.hasClass("open");
                d();
                if (!c) {
                    if ("ontouchstart" in document.documentElement && !l.closest(".navbar-nav").length) a('<div class="dropdown-backdrop"/>').insertAfter(a(this)).on("click", d);
                    var q = {
                        relatedTarget: this
                    };
                    l.trigger(c = a.Event("show.bs.dropdown", q));
                    if (c.isDefaultPrevented()) return;
                    l.toggleClass("open").trigger("shown.bs.dropdown", q);
                    g.focus()
                }
                return !1
            }
        };
        c.prototype.keydown = function (c) {
            if (/(38|40|27)/.test(c.keyCode)) {
                var g =
                    a(this);
                c.preventDefault();
                c.stopPropagation();
                if (!g.is(".disabled, :disabled")) {
                    var d = h(g),
                        l = d.hasClass("open");
                    if (!l || l && 27 == c.keyCode) return 27 == c.which && d.find("[data-toggle=dropdown]").focus(), g.click();
                    g = d.find("[role=menu] li:not(.divider):visible a, [role=listbox] li:not(.divider):visible a");
                    g.length && (d = g.index(g.filter(":focus")), 38 == c.keyCode && 0 < d && d--, 40 == c.keyCode && d < g.length - 1 && d++, ~d || (d = 0), g.eq(d).focus())
                }
            }
        };
        var l = a.fn.dropdown;
        a.fn.dropdown = function (d) {
            return this.each(function () {
                var g =
                        a(this),
                    h = g.data("bs.dropdown");
                h || g.data("bs.dropdown", h = new c(this));
                "string" == typeof d && h[d].call(g)
            })
        };
        a.fn.dropdown.Constructor = c;
        a.fn.dropdown.noConflict = function () {
            a.fn.dropdown = l;
            return this
        };
        a(document).on("click.bs.dropdown.data-api", d).on("click.bs.dropdown.data-api", ".dropdown form", function (a) {
            a.stopPropagation()
        }).on("click.bs.dropdown.data-api", "[data-toggle=dropdown]", c.prototype.toggle).on("keydown.bs.dropdown.data-api", "[data-toggle=dropdown], [role=menu], [role=listbox]", c.prototype.keydown)
    }(jQuery);
+
    function (a) {
        var d = function (c, d) {
            this.options = d;
            this.$element = a(c);
            this.$backdrop = this.isShown = null;
            this.options.remote && this.$element.find(".modal-content").load(this.options.remote, a.proxy(function () {
                this.$element.trigger("loaded.bs.modal")
            }, this))
        };
        d.DEFAULTS = {
            backdrop: !0,
            keyboard: !0,
            show: !0
        };
        d.prototype.toggle = function (a) {
            return this[this.isShown ? "hide" : "show"](a)
        };
        d.prototype.show = function (c) {
            var d = this,
                h = a.Event("show.bs.modal", {
                    relatedTarget: c
                });
            this.$element.trigger(h);
            this.isShown || h.isDefaultPrevented() ||
            (this.isShown = !0, this.escape(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', a.proxy(this.hide, this)), this.backdrop(function () {
                var g = a.support.transition && d.$element.hasClass("fade");
                d.$element.parent().length || d.$element.appendTo(document.body);
                d.$element.show().scrollTop(0);
                g && d.$element[0].offsetWidth;
                d.$element.addClass("in").attr("aria-hidden", !1);
                d.enforceFocus();
                var h = a.Event("shown.bs.modal", {
                    relatedTarget: c
                });
                g ? d.$element.find(".modal-dialog").one(a.support.transition.end,
                        function () {
                            d.$element.focus().trigger(h)
                        }).emulateTransitionEnd(300) : d.$element.focus().trigger(h)
            }))
        };
        d.prototype.hide = function (c) {
            c && c.preventDefault();
            c = a.Event("hide.bs.modal");
            this.$element.trigger(c);
            this.isShown && !c.isDefaultPrevented() && (this.isShown = !1, this.escape(), a(document).off("focusin.bs.modal"), this.$element.removeClass("in").attr("aria-hidden", !0).off("click.dismiss.bs.modal"), a.support.transition && this.$element.hasClass("fade") ? this.$element.one(a.support.transition.end, a.proxy(this.hideModal,
                    this)).emulateTransitionEnd(300) : this.hideModal())
        };
        d.prototype.enforceFocus = function () {
            a(document).off("focusin.bs.modal").on("focusin.bs.modal", a.proxy(function (a) {
                this.$element[0] === a.target || this.$element.has(a.target).length || this.$element.focus()
            }, this))
        };
        d.prototype.escape = function () {
            if (this.isShown && this.options.keyboard) this.$element.on("keyup.dismiss.bs.modal", a.proxy(function (a) {
                27 == a.which && this.hide()
            }, this));
            else this.isShown || this.$element.off("keyup.dismiss.bs.modal")
        };
        d.prototype.hideModal =
            function () {
                var a = this;
                this.$element.hide();
                this.backdrop(function () {
                    a.removeBackdrop();
                    a.$element.trigger("hidden.bs.modal")
                })
            };
        d.prototype.removeBackdrop = function () {
            this.$backdrop && this.$backdrop.remove();
            this.$backdrop = null
        };
        d.prototype.backdrop = function (c) {
            var d = this.$element.hasClass("fade") ? "fade" : "";
            if (this.isShown && this.options.backdrop) {
                var h = a.support.transition && d;
                this.$backdrop = a('<div class="modal-backdrop ' + d + '" />').appendTo(document.body);
                this.$element.on("click.dismiss.bs.modal", a.proxy(function (a) {
                    a.target ===
                    a.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus.call(this.$element[0]) : this.hide.call(this))
                }, this));
                h && this.$backdrop[0].offsetWidth;
                this.$backdrop.addClass("in");
                c && (h ? this.$backdrop.one(a.support.transition.end, c).emulateTransitionEnd(150) : c())
            } else !this.isShown && this.$backdrop ? (this.$backdrop.removeClass("in"), a.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one(a.support.transition.end, c).emulateTransitionEnd(150) : c()) : c && c()
        };
        var h = a.fn.modal;
        a.fn.modal =
            function (c, h) {
                return this.each(function () {
                    var m = a(this),
                        g = m.data("bs.modal"),
                        n = a.extend({}, d.DEFAULTS, m.data(), "object" == typeof c && c);
                    g || m.data("bs.modal", g = new d(this, n));
                    if ("string" == typeof c) g[c](h);
                    else n.show && g.show(h)
                })
            };
        a.fn.modal.Constructor = d;
        a.fn.modal.noConflict = function () {
            a.fn.modal = h;
            return this
        };
        a(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function (c) {
            var d = a(this),
                h = d.attr("href"),
                g = a(d.attr("data-target") || h && h.replace(/.*(?=#[^\s]+$)/, "")),
                h = g.data("bs.modal") ?
                    "toggle" : a.extend({
                        remote: !/#/.test(h) && h
                    }, g.data(), d.data());
            d.is("a") && c.preventDefault();
            g.modal(h, this).one("hide", function () {
                d.is(":visible") && d.focus()
            })
        });
        a(document).on("show.bs.modal", ".modal", function () {
            a(document.body).addClass("modal-open")
        }).on("hidden.bs.modal", ".modal", function () {
            a(document.body).removeClass("modal-open")
        })
    }(jQuery);
+
    function (a) {
        var d = function (a, d) {
            this.type = this.options = this.enabled = this.timeout = this.hoverState = this.$element = null;
            this.init("tooltip", a, d)
        };
        d.DEFAULTS = {
            animation: !0,
            placement: "top",
            selector: !1,
            template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
            trigger: "hover focus",
            title: "",
            delay: 0,
            html: !1,
            container: !1
        };
        d.prototype.init = function (c, d, h) {
            this.enabled = !0;
            this.type = c;
            this.$element = a(d);
            this.options = this.getOptions(h);
            c = this.options.trigger.split(" ");
            for (d = c.length; d--;)
                if (h = c[d], "click" == h) this.$element.on("click." + this.type, this.options.selector, a.proxy(this.toggle, this));
                else if ("manual" != h) {
                    var g = "hover" == h ? "mouseleave" : "focusout";
                    this.$element.on(("hover" == h ? "mouseenter" : "focusin") + "." + this.type, this.options.selector, a.proxy(this.enter, this));
                    this.$element.on(g + "." + this.type, this.options.selector, a.proxy(this.leave, this))
                }
            this.options.selector ? this._options = a.extend({}, this.options, {
                    trigger: "manual",
                    selector: ""
                }) : this.fixTitle()
        };
        d.prototype.getDefaults =
            function () {
                return d.DEFAULTS
            };
        d.prototype.getOptions = function (c) {
            c = a.extend({}, this.getDefaults(), this.$element.data(), c);
            c.delay && "number" == typeof c.delay && (c.delay = {
                show: c.delay,
                hide: c.delay
            });
            return c
        };
        d.prototype.getDelegateOptions = function () {
            var c = {},
                d = this.getDefaults();
            this._options && a.each(this._options, function (a, g) {
                d[a] != g && (c[a] = g)
            });
            return c
        };
        d.prototype.enter = function (c) {
            var d = c instanceof this.constructor ? c : a(c.currentTarget)[this.type](this.getDelegateOptions()).data("bs." + this.type);
            clearTimeout(d.timeout);
            d.hoverState = "in";
            if (!d.options.delay || !d.options.delay.show) return d.show();
            d.timeout = setTimeout(function () {
                "in" == d.hoverState && d.show()
            }, d.options.delay.show)
        };
        d.prototype.leave = function (c) {
            var d = c instanceof this.constructor ? c : a(c.currentTarget)[this.type](this.getDelegateOptions()).data("bs." + this.type);
            clearTimeout(d.timeout);
            d.hoverState = "out";
            if (!d.options.delay || !d.options.delay.hide) return d.hide();
            d.timeout = setTimeout(function () {
                "out" == d.hoverState && d.hide()
            }, d.options.delay.hide)
        };
        d.prototype.show = function () {
            var c = a.Event("show.bs." + this.type);
            if (this.hasContent() && this.enabled && (this.$element.trigger(c), !c.isDefaultPrevented())) {
                var d = this,
                    c = this.tip();
                this.setContent();
                this.options.animation && c.addClass("fade");
                var h = "function" == typeof this.options.placement ? this.options.placement.call(this, c[0], this.$element[0]) : this.options.placement,
                    g = /\s?auto?\s?/i,
                    n = g.test(h);
                n && (h = h.replace(g, "") || "top");
                c.detach().css({
                    top: 0,
                    left: 0,
                    display: "block"
                }).addClass(h);
                this.options.container ?
                    c.appendTo(this.options.container) : c.insertAfter(this.$element);
                var g = this.getPosition(),
                    q = c[0].offsetWidth,
                    v = c[0].offsetHeight;
                if (n) {
                    var u = this.$element.parent(),
                        n = h,
                        x = document.documentElement.scrollTop || document.body.scrollTop,
                        w = "body" == this.options.container ? window.innerWidth : u.outerWidth(),
                        t = "body" == this.options.container ? window.innerHeight : u.outerHeight(),
                        u = "body" == this.options.container ? 0 : u.offset().left,
                        h = "bottom" == h && g.top + g.height + v - x > t ? "top" : "top" == h && 0 > g.top - x - v ? "bottom" : "right" == h && g.right +
                                q > w ? "left" : "left" == h && g.left - q < u ? "right" : h;
                    c.removeClass(n).addClass(h)
                }
                g = this.getCalculatedOffset(h, g, q, v);
                this.applyPlacement(g, h);
                this.hoverState = null;
                h = function () {
                    d.$element.trigger("shown.bs." + d.type)
                };
                a.support.transition && this.$tip.hasClass("fade") ? c.one(a.support.transition.end, h).emulateTransitionEnd(150) : h()
            }
        };
        d.prototype.applyPlacement = function (c, d) {
            var h, g = this.tip(),
                n = g[0].offsetWidth,
                q = g[0].offsetHeight,
                v = parseInt(g.css("margin-top"), 10),
                u = parseInt(g.css("margin-left"), 10);
            isNaN(v) &&
            (v = 0);
            isNaN(u) && (u = 0);
            c.top += v;
            c.left += u;
            a.offset.setOffset(g[0], a.extend({
                using: function (a) {
                    g.css({
                        top: Math.round(a.top),
                        left: Math.round(a.left)
                    })
                }
            }, c), 0);
            g.addClass("in");
            v = g[0].offsetWidth;
            u = g[0].offsetHeight;
            "top" == d && u != q && (h = !0, c.top = c.top + q - u);
            /bottom|top/.test(d) ? (q = 0, 0 > c.left && (q = -2 * c.left, c.left = 0, g.offset(c), v = g[0].offsetWidth, u = g[0].offsetHeight), this.replaceArrow(q - n + v, v, "left")) : this.replaceArrow(u - q, u, "top");
            h && g.offset(c)
        };
        d.prototype.replaceArrow = function (a, d, h) {
            this.arrow().css(h,
                a ? 50 * (1 - a / d) + "%" : "")
        };
        d.prototype.setContent = function () {
            var a = this.tip(),
                d = this.getTitle();
            a.find(".tooltip-inner")[this.options.html ? "html" : "text"](d);
            a.removeClass("fade in top bottom left right")
        };
        d.prototype.hide = function () {
            function c() {
                "in" != d.hoverState && h.detach();
                d.$element.trigger("hidden.bs." + d.type)
            }

            var d = this,
                h = this.tip(),
                g = a.Event("hide.bs." + this.type);
            this.$element.trigger(g);
            if (!g.isDefaultPrevented()) return h.removeClass("in"), a.support.transition && this.$tip.hasClass("fade") ? h.one(a.support.transition.end,
                    c).emulateTransitionEnd(150) : c(), this.hoverState = null, this
        };
        d.prototype.fixTitle = function () {
            var a = this.$element;
            (a.attr("title") || "string" != typeof a.attr("data-original-title")) && a.attr("data-original-title", a.attr("title") || "").attr("title", "")
        };
        d.prototype.hasContent = function () {
            return this.getTitle()
        };
        d.prototype.getPosition = function () {
            var c = this.$element[0];
            return a.extend({}, "function" == typeof c.getBoundingClientRect ? c.getBoundingClientRect() : {
                    width: c.offsetWidth,
                    height: c.offsetHeight
                }, this.$element.offset())
        };
        d.prototype.getCalculatedOffset = function (a, d, h, g) {
            return "bottom" == a ? {
                    top: d.top + d.height,
                    left: d.left + d.width / 2 - h / 2
                } : "top" == a ? {
                        top: d.top - g,
                        left: d.left + d.width / 2 - h / 2
                    } : "left" == a ? {
                            top: d.top + d.height / 2 - g / 2,
                            left: d.left - h
                        } : {
                            top: d.top + d.height / 2 - g / 2,
                            left: d.left + d.width
                        }
        };
        d.prototype.getTitle = function () {
            var a = this.$element,
                d = this.options;
            return a.attr("data-original-title") || ("function" == typeof d.title ? d.title.call(a[0]) : d.title)
        };
        d.prototype.tip = function () {
            return this.$tip = this.$tip || a(this.options.template)
        };
        d.prototype.arrow = function () {
            return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
        };
        d.prototype.validate = function () {
            this.$element[0].parentNode || (this.hide(), this.options = this.$element = null)
        };
        d.prototype.enable = function () {
            this.enabled = !0
        };
        d.prototype.disable = function () {
            this.enabled = !1
        };
        d.prototype.toggleEnabled = function () {
            this.enabled = !this.enabled
        };
        d.prototype.toggle = function (c) {
            c = c ? a(c.currentTarget)[this.type](this.getDelegateOptions()).data("bs." + this.type) : this;
            c.tip().hasClass("in") ?
                c.leave(c) : c.enter(c)
        };
        d.prototype.destroy = function () {
            clearTimeout(this.timeout);
            this.hide().$element.off("." + this.type).removeData("bs." + this.type)
        };
        var h = a.fn.tooltip;
        a.fn.tooltip = function (c) {
            return this.each(function () {
                var h = a(this),
                    m = h.data("bs.tooltip"),
                    g = "object" == typeof c && c;
                if (m || "destroy" != c)
                    if (m || h.data("bs.tooltip", m = new d(this, g)), "string" == typeof c) m[c]()
            })
        };
        a.fn.tooltip.Constructor = d;
        a.fn.tooltip.noConflict = function () {
            a.fn.tooltip = h;
            return this
        }
    }(jQuery);
+
    function (a) {
        var d = function (a, d) {
            this.init("popover", a, d)
        };
        if (!a.fn.tooltip) throw Error("Popover requires tooltip.js");
        d.DEFAULTS = a.extend({}, a.fn.tooltip.Constructor.DEFAULTS, {
            placement: "right",
            trigger: "click",
            content: "",
            template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
        });
        d.prototype = a.extend({}, a.fn.tooltip.Constructor.prototype);
        d.prototype.constructor = d;
        d.prototype.getDefaults = function () {
            return d.DEFAULTS
        };
        d.prototype.setContent =
            function () {
                var a = this.tip(),
                    d = this.getTitle(),
                    h = this.getContent();
                a.find(".popover-title")[this.options.html ? "html" : "text"](d);
                a.find(".popover-content")[this.options.html ? "string" == typeof h ? "html" : "append" : "text"](h);
                a.removeClass("fade top bottom left right in");
                a.find(".popover-title").html() || a.find(".popover-title").hide()
            };
        d.prototype.hasContent = function () {
            return this.getTitle() || this.getContent()
        };
        d.prototype.getContent = function () {
            var a = this.$element,
                d = this.options;
            return a.attr("data-content") ||
                ("function" == typeof d.content ? d.content.call(a[0]) : d.content)
        };
        d.prototype.arrow = function () {
            return this.$arrow = this.$arrow || this.tip().find(".arrow")
        };
        d.prototype.tip = function () {
            this.$tip || (this.$tip = a(this.options.template));
            return this.$tip
        };
        var h = a.fn.popover;
        a.fn.popover = function (c) {
            return this.each(function () {
                var h = a(this),
                    m = h.data("bs.popover"),
                    g = "object" == typeof c && c;
                if (m || "destroy" != c)
                    if (m || h.data("bs.popover", m = new d(this, g)), "string" == typeof c) m[c]()
            })
        };
        a.fn.popover.Constructor = d;
        a.fn.popover.noConflict =
            function () {
                a.fn.popover = h;
                return this
            }
    }(jQuery);
+
    function (a) {
        var d = function (c) {
            this.element = a(c)
        };
        d.prototype.show = function () {
            var c = this.element,
                d = c.closest("ul:not(.dropdown-menu)"),
                h = c.data("target");
            h || (h = (h = c.attr("href")) && h.replace(/.*(?=#[^\s]*$)/, ""));
            if (!c.parent("li").hasClass("active")) {
                var g = d.find(".active:last a")[0],
                    n = a.Event("show.bs.tab", {
                        relatedTarget: g
                    });
                c.trigger(n);
                n.isDefaultPrevented() || (h = a(h), this.activate(c.parent("li"), d), this.activate(h, h.parent(), function () {
                    c.trigger({
                        type: "shown.bs.tab",
                        relatedTarget: g
                    })
                }))
            }
        };
        d.prototype.activate =
            function (c, d, h) {
                function g() {
                    n.removeClass("active").find("> .dropdown-menu > .active").removeClass("active");
                    c.addClass("active");
                    q ? (c[0].offsetWidth, c.addClass("in")) : c.removeClass("fade");
                    c.parent(".dropdown-menu") && c.closest("li.dropdown").addClass("active");
                    h && h()
                }

                var n = d.find("> .active"),
                    q = h && a.support.transition && n.hasClass("fade");
                q ? n.one(a.support.transition.end, g).emulateTransitionEnd(150) : g();
                n.removeClass("in")
            };
        var h = a.fn.tab;
        a.fn.tab = function (c) {
            return this.each(function () {
                var h = a(this),
                    m = h.data("bs.tab");
                m || h.data("bs.tab", m = new d(this));
                if ("string" == typeof c) m[c]()
            })
        };
        a.fn.tab.Constructor = d;
        a.fn.tab.noConflict = function () {
            a.fn.tab = h;
            return this
        };
        a(document).on("click.bs.tab.data-api", '[data-toggle="tab"], [data-toggle="pill"]', function (c) {
            c.preventDefault();
            a(this).tab("show")
        })
    }(jQuery);
+
    function (a) {
        var d = function (c, h) {
            this.options = a.extend({}, d.DEFAULTS, h);
            this.$window = a(window).on("scroll.bs.affix.data-api", a.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", a.proxy(this.checkPositionWithEventLoop, this));
            this.$element = a(c);
            this.affixed = this.unpin = this.pinnedOffset = null;
            this.checkPosition()
        };
        d.RESET = "affix affix-top affix-bottom";
        d.DEFAULTS = {
            offset: 0
        };
        d.prototype.getPinnedOffset = function () {
            if (this.pinnedOffset) return this.pinnedOffset;
            this.$element.removeClass(d.RESET).addClass("affix");
            var a = this.$window.scrollTop();
            return this.pinnedOffset = this.$element.offset().top - a
        };
        d.prototype.checkPositionWithEventLoop = function () {
            setTimeout(a.proxy(this.checkPosition, this), 1)
        };
        d.prototype.checkPosition = function () {
            if (this.$element.is(":visible")) {
                var c = a(document).height(),
                    h = this.$window.scrollTop(),
                    m = this.$element.offset(),
                    g = this.options.offset,
                    n = g.top,
                    q = g.bottom;
                "top" == this.affixed && (m.top += h);
                "object" != typeof g && (q = n = g);
                "function" == typeof n && (n = g.top(this.$element));
                "function" == typeof q &&
                (q = g.bottom(this.$element));
                h = null != this.unpin && h + this.unpin <= m.top ? !1 : null != q && m.top + this.$element.height() >= c - q ? "bottom" : null != n && h <= n ? "top" : !1;
                this.affixed !== h && (this.unpin && this.$element.css("top", ""), m = "affix" + (h ? "-" + h : ""), g = a.Event(m + ".bs.affix"), this.$element.trigger(g), g.isDefaultPrevented() || (this.affixed = h, this.unpin = "bottom" == h ? this.getPinnedOffset() : null, this.$element.removeClass(d.RESET).addClass(m).trigger(a.Event(m.replace("affix", "affixed"))), "bottom" == h && this.$element.offset({
                    top: c -
                    q - this.$element.height()
                })))
            }
        };
        var h = a.fn.affix;
        a.fn.affix = function (c) {
            return this.each(function () {
                var h = a(this),
                    m = h.data("bs.affix"),
                    g = "object" == typeof c && c;
                m || h.data("bs.affix", m = new d(this, g));
                if ("string" == typeof c) m[c]()
            })
        };
        a.fn.affix.Constructor = d;
        a.fn.affix.noConflict = function () {
            a.fn.affix = h;
            return this
        };
        a(window).on("load", function () {
            a('[data-spy="affix"]').each(function () {
                var c = a(this),
                    d = c.data();
                d.offset = d.offset || {};
                d.offsetBottom && (d.offset.bottom = d.offsetBottom);
                d.offsetTop && (d.offset.top =
                    d.offsetTop);
                c.affix(d)
            })
        })
    }(jQuery);
+
    function (a) {
        var d = function (c, h) {
            this.$element = a(c);
            this.options = a.extend({}, d.DEFAULTS, h);
            this.transitioning = null;
            this.options.parent && (this.$parent = a(this.options.parent));
            this.options.toggle && this.toggle()
        };
        d.DEFAULTS = {
            toggle: !0
        };
        d.prototype.dimension = function () {
            return this.$element.hasClass("width") ? "width" : "height"
        };
        d.prototype.show = function () {
            if (!this.transitioning && !this.$element.hasClass("in")) {
                var c = a.Event("show.bs.collapse");
                this.$element.trigger(c);
                if (!c.isDefaultPrevented()) {
                    if ((c = this.$parent &&
                            this.$parent.find("> .panel > .in")) && c.length) {
                        var d = c.data("bs.collapse");
                        if (d && d.transitioning) return;
                        c.collapse("hide");
                        d || c.data("bs.collapse", null)
                    }
                    var h = this.dimension();
                    this.$element.removeClass("collapse").addClass("collapsing")[h](0);
                    this.transitioning = 1;
                    c = function () {
                        this.$element.removeClass("collapsing").addClass("collapse in")[h]("auto");
                        this.transitioning = 0;
                        this.$element.trigger("shown.bs.collapse")
                    };
                    if (!a.support.transition) return c.call(this);
                    d = a.camelCase(["scroll", h].join("-"));
                    this.$element.one(a.support.transition.end, a.proxy(c, this)).emulateTransitionEnd(350)[h](this.$element[0][d])
                }
            }
        };
        d.prototype.hide = function () {
            if (!this.transitioning && this.$element.hasClass("in")) {
                var c = a.Event("hide.bs.collapse");
                this.$element.trigger(c);
                if (!c.isDefaultPrevented()) {
                    c = this.dimension();
                    this.$element[c](this.$element[c]())[0].offsetHeight;
                    this.$element.addClass("collapsing").removeClass("collapse").removeClass("in");
                    this.transitioning = 1;
                    var d = function () {
                        this.transitioning = 0;
                        this.$element.trigger("hidden.bs.collapse").removeClass("collapsing").addClass("collapse")
                    };
                    if (!a.support.transition) return d.call(this);
                    this.$element[c](0).one(a.support.transition.end, a.proxy(d, this)).emulateTransitionEnd(350)
                }
            }
        };
        d.prototype.toggle = function () {
            this[this.$element.hasClass("in") ? "hide" : "show"]()
        };
        var h = a.fn.collapse;
        a.fn.collapse = function (c) {
            return this.each(function () {
                var h = a(this),
                    m = h.data("bs.collapse"),
                    g = a.extend({}, d.DEFAULTS, h.data(), "object" == typeof c && c);
                !m && g.toggle && "show" == c && (c = !c);
                m || h.data("bs.collapse", m = new d(this, g));
                if ("string" == typeof c) m[c]()
            })
        };
        a.fn.collapse.Constructor =
            d;
        a.fn.collapse.noConflict = function () {
            a.fn.collapse = h;
            return this
        };
        a(document).on("click.bs.collapse.data-api", "[data-toggle=collapse]", function (c) {
            var d = a(this),
                h;
            c = d.attr("data-target") || c.preventDefault() || (h = d.attr("href")) && h.replace(/.*(?=#[^\s]+$)/, "");
            h = a(c);
            var g = (c = h.data("bs.collapse")) ? "toggle" : d.data(),
                n = d.attr("data-parent"),
                q = n && a(n);
            c && c.transitioning || (q && q.find('[data-toggle=collapse][data-parent="' + n + '"]').not(d).addClass("collapsed"), d[h.hasClass("in") ? "addClass" : "removeClass"]("collapsed"));
            h.collapse(g)
        })
    }(jQuery);
+
    function (a) {
        function d(c, h) {
            var m, g = a.proxy(this.process, this);
            this.$element = a(c).is("body") ? a(window) : a(c);
            this.$body = a("body");
            this.$scrollElement = this.$element.on("scroll.bs.scroll-spy.data-api", g);
            this.options = a.extend({}, d.DEFAULTS, h);
            this.selector = (this.options.target || (m = a(c).attr("href")) && m.replace(/.*(?=#[^\s]+$)/, "") || "") + " .nav li > a";
            this.offsets = a([]);
            this.targets = a([]);
            this.activeTarget = null;
            this.refresh();
            this.process()
        }

        d.DEFAULTS = {
            offset: 10
        };
        d.prototype.refresh = function () {
            var c =
                this.$element[0] == window ? "offset" : "position";
            this.offsets = a([]);
            this.targets = a([]);
            var d = this;
            this.$body.find(this.selector).map(function () {
                var h = a(this),
                    h = h.data("target") || h.attr("href"),
                    g = /^#./.test(h) && a(h);
                return g && g.length && g.is(":visible") && [
                        [g[c]().top + (!a.isWindow(d.$scrollElement.get(0)) && d.$scrollElement.scrollTop()), h]
                    ] || null
            }).sort(function (a, c) {
                return a[0] - c[0]
            }).each(function () {
                d.offsets.push(this[0]);
                d.targets.push(this[1])
            })
        };
        d.prototype.process = function () {
            var a = this.$scrollElement.scrollTop() +
                    this.options.offset,
                d = (this.$scrollElement[0].scrollHeight || this.$body[0].scrollHeight) - this.$scrollElement.height(),
                h = this.offsets,
                g = this.targets,
                n = this.activeTarget,
                q;
            if (a >= d) return n != (q = g.last()[0]) && this.activate(q);
            if (n && a <= h[0]) return n != (q = g[0]) && this.activate(q);
            for (q = h.length; q--;) n != g[q] && a >= h[q] && (!h[q + 1] || a <= h[q + 1]) && this.activate(g[q])
        };
        d.prototype.activate = function (c) {
            this.activeTarget = c;
            a(this.selector).parentsUntil(this.options.target, ".active").removeClass("active");
            c = a(this.selector +
                '[data-target="' + c + '"],' + this.selector + '[href="' + c + '"]').parents("li").addClass("active");
            c.parent(".dropdown-menu").length && (c = c.closest("li.dropdown").addClass("active"));
            c.trigger("activate.bs.scrollspy")
        };
        var h = a.fn.scrollspy;
        a.fn.scrollspy = function (c) {
            return this.each(function () {
                var h = a(this),
                    m = h.data("bs.scrollspy"),
                    g = "object" == typeof c && c;
                m || h.data("bs.scrollspy", m = new d(this, g));
                if ("string" == typeof c) m[c]()
            })
        };
        a.fn.scrollspy.Constructor = d;
        a.fn.scrollspy.noConflict = function () {
            a.fn.scrollspy =
                h;
            return this
        };
        a(window).on("load", function () {
            a('[data-spy="scroll"]').each(function () {
                var c = a(this);
                c.scrollspy(c.data())
            })
        })
    }(jQuery);
+
    function (a) {
        a.fn.emulateTransitionEnd = function (d) {
            var h = !1,
                c = this;
            a(this).one(a.support.transition.end, function () {
                h = !0
            });
            setTimeout(function () {
                h || a(c).trigger(a.support.transition.end)
            }, d);
            return this
        };
        a(function () {
            var d = a.support,
                h;
            a: {
                h = document.createElement("bootstrap");
                var c = {
                        WebkitTransition: "webkitTransitionEnd",
                        MozTransition: "transitionend",
                        OTransition: "oTransitionEnd otransitionend",
                        transition: "transitionend"
                    },
                    l;
                for (l in c)
                    if (void 0 !== h.style[l]) {
                        h = {
                            end: c[l]
                        };
                        break a
                    }
                h = !1
            }
            d.transition = h
        })
    }(jQuery);
(function (a, d) {
    function h(b) {
        a.fn.cycle.debug && c(b)
    }

    function c() {
        window.console && console.log && console.log("[cycle] " + Array.prototype.join.call(arguments, " "))
    }

    function l(b, c, g) {
        var d = a(b).data("cycle.opts");
        if (d) {
            var h = !!b.cyclePause;
            h && d.paused ? d.paused(b, d, c, g) : !h && d.resumed && d.resumed(b, d, c, g)
        }
    }

    function m(b, f, g) {
        function h(b, e, f) {
            if (!b && !0 === e) {
                b = a(f).data("cycle.opts");
                if (!b) return c("options not found, can not resume"), !1;
                f.cycleTimeout && (clearTimeout(f.cycleTimeout), f.cycleTimeout = 0);
                w(b.elements,
                    b, 1, !b.backwards)
            }
        }

        b.cycleStop === d && (b.cycleStop = 0);
        if (f === d || null === f) f = {};
        if (f.constructor == String) switch (f) {
            case "destroy":
            case "stop":
                g = a(b).data("cycle.opts");
                if (!g) return !1;
                b.cycleStop++;
                b.cycleTimeout && clearTimeout(b.cycleTimeout);
                b.cycleTimeout = 0;
                g.elements && a(g.elements).stop();
                a(b).removeData("cycle.opts");
                "destroy" == f && n(b, g);
                return !1;
            case "toggle":
                return b.cyclePause = 1 === b.cyclePause ? 0 : 1, h(b.cyclePause, g, b), l(b), !1;
            case "pause":
                return b.cyclePause = 1, l(b), !1;
            case "resume":
                return b.cyclePause =
                    0, h(!1, g, b), l(b), !1;
            case "prev":
            case "next":
                g = a(b).data("cycle.opts");
                if (!g) return c('options not found, "prev/next" ignored'), !1;
                a.fn.cycle[f](g);
                return !1;
            default:
                f = {
                    fx: f
                }
        } else if (f.constructor == Number) {
            var m = f;
            f = a(b).data("cycle.opts");
            if (!f) return c("options not found, can not advance slide"), !1;
            if (0 > m || m >= f.elements.length) return c("invalid slide index: " + m), !1;
            f.nextSlide = m;
            b.cycleTimeout && (clearTimeout(b.cycleTimeout), b.cycleTimeout = 0);
            "string" == typeof g && (f.oneTimeFx = g);
            w(f.elements, f, 1, m >=
                f.currSlide);
            return !1
        }
        return f
    }

    function g(b, c) {
        if (!a.support.opacity && c.cleartype && b.style.filter) try {
            b.style.removeAttribute("filter")
        } catch (g) {
        }
    }

    function n(b, c) {
        c.next && a(c.next).unbind(c.prevNextEvent);
        c.prev && a(c.prev).unbind(c.prevNextEvent);
        (c.pager || c.pagerAnchorBuilder) && a.each(c.pagerAnchors || [], function () {
            this.unbind().remove()
        });
        c.pagerAnchors = null;
        a(b).unbind("mouseenter.cycle mouseleave.cycle");
        c.destroy && c.destroy(c)
    }

    function q(e, f, h, n, m) {
        var q, t = a.extend({}, a.fn.cycle.defaults, n || {},
            a.metadata ? e.metadata() : a.meta ? e.data() : {}),
            K = a.isFunction(e.data) ? e.data(t.metaAttr) : null;
        K && (t = a.extend(t, K));
        t.autostop && (t.countdown = t.autostopCount || h.length);
        var D = e[0];
        e.data("cycle.opts", t);
        t.$cont = e;
        t.stopCount = D.cycleStop;
        t.elements = h;
        t.before = t.before ? [t.before] : [];
        t.after = t.after ? [t.after] : [];
        !a.support.opacity && t.cleartype && t.after.push(function () {
            g(this, t)
        });
        t.continuous && t.after.push(function () {
            w(h, t, 0, !t.backwards)
        });
        v(t);
        a.support.opacity || !t.cleartype || t.cleartypeNoBg || b(f);
        "static" ==
        e.css("position") && e.css("position", "relative");
        t.width && e.width(t.width);
        t.height && "auto" != t.height && e.height(t.height);
        t.startingSlide !== d ? (t.startingSlide = parseInt(t.startingSlide, 10), t.startingSlide >= h.length || 0 > t.startSlide ? t.startingSlide = 0 : q = !0) : t.startingSlide = t.backwards ? h.length - 1 : 0;
        if (t.random) {
            t.randomMap = [];
            for (K = 0; K < h.length; K++) t.randomMap.push(K);
            t.randomMap.sort(function (b, a) {
                return Math.random() - .5
            });
            if (q)
                for (q = 0; q < h.length; q++) t.startingSlide == t.randomMap[q] && (t.randomIndex = q);
            else t.randomIndex = 1, t.startingSlide = t.randomMap[1]
        } else t.startingSlide >= h.length && (t.startingSlide = 0);
        t.currSlide = t.startingSlide || 0;
        var Q = t.startingSlide;
        f.css({
            position: "absolute",
            top: 0,
            left: 0
        }).hide().each(function (b) {
            b = t.backwards ? Q ? b <= Q ? h.length + (b - Q) : Q - b : h.length - b : Q ? b >= Q ? h.length - (b - Q) : Q - b : h.length - b;
            a(this).css("z-index", b)
        });
        a(h[Q]).css("opacity", 1).show();
        g(h[Q], t);
        t.fit && (t.aspect ? f.each(function () {
                var b = a(this),
                    e = !0 === t.aspect ? b.width() / b.height() : t.aspect;
                t.width && b.width() != t.width &&
                (b.width(t.width), b.height(t.width / e));
                t.height && b.height() < t.height && (b.height(t.height), b.width(t.height * e))
            }) : (t.width && f.width(t.width), t.height && "auto" != t.height && f.height(t.height)));
        !t.center || t.fit && !t.aspect || f.each(function () {
            var b = a(this);
            b.css({
                "margin-left": t.width ? (t.width - b.width()) / 2 + "px" : 0,
                "margin-top": t.height ? (t.height - b.height()) / 2 + "px" : 0
            })
        });
        !t.center || t.fit || t.slideResize || f.each(function () {
            var b = a(this);
            b.css({
                "margin-left": t.width ? (t.width - b.width()) / 2 + "px" : 0,
                "margin-top": t.height ?
                    (t.height - b.height()) / 2 + "px" : 0
            })
        });
        if ((t.containerResize || t.containerResizeHeight) && !e.innerHeight()) {
            for (var G = K = q = 0; G < h.length; G++) {
                var T = a(h[G]),
                    L = T[0],
                    C = T.outerWidth(),
                    M = T.outerHeight();
                C || (C = L.offsetWidth || L.width || T.attr("width"));
                M || (M = L.offsetHeight || L.height || T.attr("height"));
                q = C > q ? C : q;
                K = M > K ? M : K
            }
            t.containerResize && 0 < q && 0 < K && e.css({
                width: q + "px",
                height: K + "px"
            });
            t.containerResizeHeight && 0 < K && e.css({
                height: K + "px"
            })
        }
        var H = !1;
        t.pause && e.bind("mouseenter.cycle", function () {
            H = !0;
            this.cyclePause++;
            l(D, !0)
        }).bind("mouseleave.cycle", function () {
            H && this.cyclePause--;
            l(D, !0)
        });
        if (!1 === u(t)) return !1;
        var O = !1;
        n.requeueAttempts = n.requeueAttempts || 0;
        f.each(function () {
            var b = a(this);
            this.cycleH = t.fit && t.height ? t.height : b.height() || this.offsetHeight || this.height || b.attr("height") || 0;
            this.cycleW = t.fit && t.width ? t.width : b.width() || this.offsetWidth || this.width || b.attr("width") || 0;
            if (b.is("img") && 0 === this.cycleH && 0 === this.cycleW && !this.complete) {
                if (m.s && t.requeueOnImageNotLoaded && 100 > ++n.requeueAttempts) return c(n.requeueAttempts,
                    " - img slide not loaded, requeuing slideshow: ", this.src, this.cycleW, this.cycleH), setTimeout(function () {
                    a(m.s, m.c).cycle(n)
                }, t.requeueTimeout), O = !0, !1;
                c("could not determine size of image: " + this.src, this.cycleW, this.cycleH)
            }
            return !0
        });
        if (O) return !1;
        t.cssBefore = t.cssBefore || {};
        t.cssAfter = t.cssAfter || {};
        t.cssFirst = t.cssFirst || {};
        t.animIn = t.animIn || {};
        t.animOut = t.animOut || {};
        f.not(":eq(" + Q + ")").css(t.cssBefore);
        a(f[Q]).css(t.cssFirst);
        if (t.timeout)
            for (t.timeout = parseInt(t.timeout, 10), t.speed.constructor ==
            String && (t.speed = a.fx.speeds[t.speed] || parseInt(t.speed, 10)), t.sync || (t.speed /= 2), q = "none" == t.fx ? 0 : "shuffle" == t.fx ? 500 : 250; t.timeout - t.speed < q;) t.timeout += t.speed;
        t.easing && (t.easeIn = t.easeOut = t.easing);
        t.speedIn || (t.speedIn = t.speed);
        t.speedOut || (t.speedOut = t.speed);
        t.slideCount = h.length;
        t.currSlide = t.lastSlide = Q;
        t.random ? (++t.randomIndex == h.length && (t.randomIndex = 0), t.nextSlide = t.randomMap[t.randomIndex]) : t.nextSlide = t.backwards ? 0 === t.startingSlide ? h.length - 1 : t.startingSlide - 1 : t.startingSlide >= h.length -
                1 ? 0 : t.startingSlide + 1;
        if (!t.multiFx)
            if (q = a.fn.cycle.transitions[t.fx], a.isFunction(q)) q(e, f, t);
            else if ("custom" != t.fx && !t.multiFx) return c("unknown transition: " + t.fx, "; slideshow terminating"), !1;
        e = f[Q];
        t.skipInitializationCallbacks || (t.before.length && t.before[0].apply(e, [e, e, t, !0]), t.after.length && t.after[0].apply(e, [e, e, t, !0]));
        t.next && a(t.next).bind(t.prevNextEvent, function () {
            return y(t, 1)
        });
        t.prev && a(t.prev).bind(t.prevNextEvent, function () {
            return y(t, 0)
        });
        (t.pager || t.pagerAnchorBuilder) && A(h,
            t);
        x(t, h);
        return t
    }

    function v(b) {
        b.original = {
            before: [],
            after: []
        };
        b.original.cssBefore = a.extend({}, b.cssBefore);
        b.original.cssAfter = a.extend({}, b.cssAfter);
        b.original.animIn = a.extend({}, b.animIn);
        b.original.animOut = a.extend({}, b.animOut);
        a.each(b.before, function () {
            b.original.before.push(this)
        });
        a.each(b.after, function () {
            b.original.after.push(this)
        })
    }

    function u(b) {
        var f, g, d = a.fn.cycle.transitions;
        if (0 < b.fx.indexOf(",")) {
            b.multiFx = !0;
            b.fxs = b.fx.replace(/\s*/g, "").split(",");
            for (f = 0; f < b.fxs.length; f++) {
                var n =
                    b.fxs[f];
                g = d[n];
                g && d.hasOwnProperty(n) && a.isFunction(g) || (c("discarding unknown transition: ", n), b.fxs.splice(f, 1), f--)
            }
            if (!b.fxs.length) return c("No valid transitions named; slideshow terminating."), !1
        } else if ("all" == b.fx)
            for (f in b.multiFx = !0, b.fxs = [], d) d.hasOwnProperty(f) && (g = d[f], d.hasOwnProperty(f) && a.isFunction(g) && b.fxs.push(f));
        if (b.multiFx && b.randomizeEffects) {
            g = Math.floor(20 * Math.random()) + 30;
            for (f = 0; f < g; f++) b.fxs.push(b.fxs.splice(Math.floor(Math.random() * b.fxs.length), 1)[0]);
            h("randomized fx sequence: ",
                b.fxs)
        }
        return !0
    }

    function x(e, c) {
        e.addSlide = function (g, d) {
            var h = a(g),
                n = h[0];
            e.autostopCount || e.countdown++;
            c[d ? "unshift" : "push"](n);
            if (e.els) e.els[d ? "unshift" : "push"](n);
            e.slideCount = c.length;
            e.random && (e.randomMap.push(e.slideCount - 1), e.randomMap.sort(function (b, a) {
                return Math.random() - .5
            }));
            h.css("position", "absolute");
            h[d ? "prependTo" : "appendTo"](e.$cont);
            d && (e.currSlide++, e.nextSlide++);
            a.support.opacity || !e.cleartype || e.cleartypeNoBg || b(h);
            e.fit && e.width && h.width(e.width);
            e.fit && e.height && "auto" !=
            e.height && h.height(e.height);
            n.cycleH = e.fit && e.height ? e.height : h.height();
            n.cycleW = e.fit && e.width ? e.width : h.width();
            h.css(e.cssBefore);
            (e.pager || e.pagerAnchorBuilder) && a.fn.cycle.createPagerAnchor(c.length - 1, n, a(e.pager), c, e);
            if (a.isFunction(e.onAddSlide)) e.onAddSlide(h);
            else h.hide()
        }
    }

    function w(b, c, g, n) {
        function l() {
            var a = 0;
            c.timeout && !c.continuous ? (a = t(b[c.currSlide], b[c.nextSlide], c, n), "shuffle" == c.fx && (a -= c.speedOut)) : c.continuous && m.cyclePause && (a = 10);
            0 < a && (m.cycleTimeout = setTimeout(function () {
                w(b,
                    c, 0, !c.backwards)
            }, a))
        }

        var m = c.$cont[0],
            q = b[c.currSlide],
            v = b[c.nextSlide];
        g && c.busy && c.manualTrump && (h("manualTrump in go(), stopping active transition"), a(b).stop(!0, !0), c.busy = 0, clearTimeout(m.cycleTimeout));
        if (c.busy) h("transition active, ignoring new tx request");
        else if (m.cycleStop == c.stopCount && (0 !== m.cycleTimeout || g))
            if (g || m.cyclePause || c.bounce || !(c.autostop && 0 >= --c.countdown || c.nowrap && !c.random && c.nextSlide < c.currSlide)) {
                var u = !1;
                if (!g && m.cyclePause || c.nextSlide == c.currSlide) l();
                else {
                    var u = !0,
                        x = c.fx;
                    q.cycleH = q.cycleH || a(q).height();
                    q.cycleW = q.cycleW || a(q).width();
                    v.cycleH = v.cycleH || a(v).height();
                    v.cycleW = v.cycleW || a(v).width();
                    c.multiFx && (n && (c.lastFx === d || ++c.lastFx >= c.fxs.length) ? c.lastFx = 0 : !n && (c.lastFx === d || 0 > --c.lastFx) && (c.lastFx = c.fxs.length - 1), x = c.fxs[c.lastFx]);
                    c.oneTimeFx && (x = c.oneTimeFx, c.oneTimeFx = null);
                    a.fn.cycle.resetState(c, x);
                    c.before.length && a.each(c.before, function (b, a) {
                        m.cycleStop == c.stopCount && a.apply(v, [q, v, c, n])
                    });
                    var y = function () {
                        c.busy = 0;
                        a.each(c.after, function (b,
                                                  a) {
                            m.cycleStop == c.stopCount && a.apply(v, [q, v, c, n])
                        });
                        m.cycleStop || l()
                    };
                    h("tx firing(" + x + "); currSlide: " + c.currSlide + "; nextSlide: " + c.nextSlide);
                    c.busy = 1;
                    if (c.fxFn) c.fxFn(q, v, c, y, n, g && c.fastOnEvent);
                    else if (a.isFunction(a.fn.cycle[c.fx])) a.fn.cycle[c.fx](q, v, c, y, n, g && c.fastOnEvent);
                    else a.fn.cycle.custom(q, v, c, y, n, g && c.fastOnEvent)
                }
                if (u || c.nextSlide == c.currSlide) c.lastSlide = c.currSlide, c.random ? (c.currSlide = c.nextSlide, ++c.randomIndex == b.length && (c.randomIndex = 0, c.randomMap.sort(function (b, a) {
                        return Math.random() -
                            .5
                    })), c.nextSlide = c.randomMap[c.randomIndex], c.nextSlide == c.currSlide && (c.nextSlide = c.currSlide == c.slideCount - 1 ? 0 : c.currSlide + 1)) : c.backwards ? (g = 0 > c.nextSlide - 1) && c.bounce ? (c.backwards = !c.backwards, c.nextSlide = 1, c.currSlide = 0) : (c.nextSlide = g ? b.length - 1 : c.nextSlide - 1, c.currSlide = g ? 0 : c.nextSlide + 1) : (g = c.nextSlide + 1 == b.length) && c.bounce ? (c.backwards = !c.backwards, c.nextSlide = b.length - 2, c.currSlide = b.length - 1) : (c.nextSlide = g ? 0 : c.nextSlide + 1, c.currSlide = g ? b.length - 1 : c.nextSlide - 1);
                u && c.pager && c.updateActivePagerLink(c.pager,
                    c.currSlide, c.activePagerClass)
            } else c.end && c.end(c)
    }

    function t(b, a, c, g) {
        if (c.timeoutFn) {
            for (b = c.timeoutFn.call(b, b, a, c, g);
                 "none" != c.fx && 250 > b - c.speed;) b += c.speed;
            h("calculated timeout: " + b + "; speed: " + c.speed);
            if (!1 !== b) return b
        }
        return c.timeout
    }

    function y(b, c) {
        var g = c ? 1 : -1,
            d = b.elements,
            h = b.$cont[0],
            n = h.cycleTimeout;
        n && (clearTimeout(n), h.cycleTimeout = 0);
        if (b.random && 0 > g) b.randomIndex--, -2 == --b.randomIndex ? b.randomIndex = d.length - 2 : -1 == b.randomIndex && (b.randomIndex = d.length - 1), b.nextSlide = b.randomMap[b.randomIndex];
        else if (b.random) b.nextSlide = b.randomMap[b.randomIndex];
        else if (b.nextSlide = b.currSlide + g, 0 > b.nextSlide) {
            if (b.nowrap) return !1;
            b.nextSlide = d.length - 1
        } else if (b.nextSlide >= d.length) {
            if (b.nowrap) return !1;
            b.nextSlide = 0
        }
        h = b.onPrevNextEvent || b.prevNextClick;
        a.isFunction(h) && h(0 < g, b.nextSlide, d[b.nextSlide]);
        w(d, b, 1, c);
        return !1
    }

    function A(b, c) {
        var g = a(c.pager);
        a.each(b, function (d, h) {
            a.fn.cycle.createPagerAnchor(d, h, g, b, c)
        });
        c.updateActivePagerLink(c.pager, c.startingSlide, c.activePagerClass)
    }

    function b(b) {
        function c(b) {
            b =
                parseInt(b, 10).toString(16);
            return 2 > b.length ? "0" + b : b
        }

        function g(b) {
            for (; b && "html" != b.nodeName.toLowerCase(); b = b.parentNode) {
                var e = a.css(b, "background-color");
                if (e && 0 <= e.indexOf("rgb")) return b = e.match(/\d+/g), "#" + c(b[0]) + c(b[1]) + c(b[2]);
                if (e && "transparent" != e) return e
            }
            return "#ffffff"
        }

        h("applying clearType background-color hack");
        b.each(function () {
            a(this).css("background-color", g(this))
        })
    }

    a.expr[":"].paused = function (b) {
        return b.cyclePause
    };
    a.fn.cycle = function (b, f) {
        var g = {
            s: this.selector,
            c: this.context
        };
        if (0 === this.length && "stop" != b) {
            if (!a.isReady && g.s) return c("DOM not ready, queuing slideshow"), a(function () {
                a(g.s, g.c).cycle(b, f)
            }), this;
            c("terminating; zero elements found by selector" + (a.isReady ? "" : " (DOM not ready)"));
            return this
        }
        return this.each(function () {
            var d = m(this, b, f);
            if (!1 !== d) {
                d.updateActivePagerLink = d.updateActivePagerLink || a.fn.cycle.updateActivePagerLink;
                this.cycleTimeout && clearTimeout(this.cycleTimeout);
                this.cycleStop = this.cycleTimeout = this.cyclePause = 0;
                var n = a(this),
                    l = d.slideExpr ?
                        a(d.slideExpr, this) : n.children(),
                    v = l.get();
                if (2 > v.length) c("terminating; too few slides: " + v.length);
                else {
                    var u = q(n, l, v, d, g);
                    !1 !== u && (n = u.continuous ? 10 : t(v[u.currSlide], v[u.nextSlide], u, !u.backwards)) && (n += u.delay || 0, 10 > n && (n = 10), h("first timeout: " + n), this.cycleTimeout = setTimeout(function () {
                        w(v, u, 0, !d.backwards)
                    }, n))
                }
            }
        })
    };
    a.fn.cycle.resetState = function (b, c) {
        c = c || b.fx;
        b.before = [];
        b.after = [];
        b.cssBefore = a.extend({}, b.original.cssBefore);
        b.cssAfter = a.extend({}, b.original.cssAfter);
        b.animIn = a.extend({},
            b.original.animIn);
        b.animOut = a.extend({}, b.original.animOut);
        b.fxFn = null;
        a.each(b.original.before, function () {
            b.before.push(this)
        });
        a.each(b.original.after, function () {
            b.after.push(this)
        });
        var g = a.fn.cycle.transitions[c];
        a.isFunction(g) && g(b.$cont, a(b.elements), b)
    };
    a.fn.cycle.updateActivePagerLink = function (b, c, g) {
        a(b).each(function () {
            a(this).children().removeClass(g).eq(c).addClass(g)
        })
    };
    a.fn.cycle.next = function (b) {
        y(b, 1)
    };
    a.fn.cycle.prev = function (b) {
        y(b, 0)
    };
    a.fn.cycle.createPagerAnchor = function (b,
                                             c, g, d, n) {
        a.isFunction(n.pagerAnchorBuilder) ? (c = n.pagerAnchorBuilder(b, c), h("pagerAnchorBuilder(" + b + ", el) returned: " + c)) : c = '<a href="#">' + (b + 1) + "</a>";
        if (c) {
            var m = a(c);
            if (0 === m.parents("body").length) {
                var q = [];
                1 < g.length ? (g.each(function () {
                        var b = m.clone(!0);
                        a(this).append(b);
                        q.push(b[0])
                    }), m = a(q)) : m.appendTo(g)
            }
            n.pagerAnchors = n.pagerAnchors || [];
            n.pagerAnchors.push(m);
            g = function (c) {
                c.preventDefault();
                n.nextSlide = b;
                c = n.$cont[0];
                var f = c.cycleTimeout;
                f && (clearTimeout(f), c.cycleTimeout = 0);
                c = n.onPagerEvent ||
                    n.pagerClick;
                a.isFunction(c) && c(n.nextSlide, d[n.nextSlide]);
                w(d, n, 1, n.currSlide < b)
            };
            /mouseenter|mouseover/i.test(n.pagerEvent) ? m.hover(g, function () {
                }) : m.bind(n.pagerEvent, g);
            /^click/.test(n.pagerEvent) || n.allowPagerClickBubble || m.bind("click.cycle", function () {
                return !1
            });
            var v = n.$cont[0],
                t = !1;
            n.pauseOnPagerHover && m.hover(function () {
                t = !0;
                v.cyclePause++;
                l(v, !0, !0)
            }, function () {
                t && v.cyclePause--;
                l(v, !0, !0)
            })
        }
    };
    a.fn.cycle.hopsFromLast = function (b, a) {
        var c = b.lastSlide,
            g = b.currSlide;
        return a ? g > c ? g - c : b.slideCount -
                c : g < c ? c - g : c + b.slideCount - g
    };
    a.fn.cycle.commonReset = function (b, c, g, d, h, n) {
        a(g.elements).not(b).hide();
        "undefined" == typeof g.cssBefore.opacity && (g.cssBefore.opacity = 1);
        g.cssBefore.display = "block";
        g.slideResize && !1 !== d && 0 < c.cycleW && (g.cssBefore.width = c.cycleW);
        g.slideResize && !1 !== h && 0 < c.cycleH && (g.cssBefore.height = c.cycleH);
        g.cssAfter = g.cssAfter || {};
        g.cssAfter.display = "none";
        a(b).css("zIndex", g.slideCount + (!0 === n ? 1 : 0));
        a(c).css("zIndex", g.slideCount + (!0 === n ? 0 : 1))
    };
    a.fn.cycle.custom = function (b, c, g, d,
                                  h, n) {
        var l = a(b),
            m = a(c),
            q = g.speedIn;
        b = g.speedOut;
        var v = g.easeIn;
        c = g.easeOut;
        m.css(g.cssBefore);
        n && (q = "number" == typeof n ? b = n : b = 1, v = c = null);
        var t = function () {
            m.animate(g.animIn, q, v, function () {
                d()
            })
        };
        l.animate(g.animOut, b, c, function () {
            l.css(g.cssAfter);
            g.sync || t()
        });
        g.sync && t()
    };
    a.fn.cycle.transitions = {
        fade: function (b, c, g) {
            c.not(":eq(" + g.currSlide + ")").css("opacity", 0);
            g.before.push(function (b, c, e) {
                a.fn.cycle.commonReset(b, c, e);
                e.cssBefore.opacity = 0
            });
            g.animIn = {
                opacity: 1
            };
            g.animOut = {
                opacity: 0
            };
            g.cssBefore = {
                top: 0,
                left: 0
            }
        }
    };
    a.fn.cycle.ver = function () {
        return "2.9999.81"
    };
    a.fn.cycle.defaults = {
        activePagerClass: "activeSlide",
        after: null,
        allowPagerClickBubble: !1,
        animIn: null,
        animOut: null,
        aspect: !1,
        autostop: 0,
        autostopCount: 0,
        backwards: !1,
        before: null,
        center: null,
        cleartype: !a.support.opacity,
        cleartypeNoBg: !1,
        containerResize: 1,
        containerResizeHeight: 0,
        continuous: 0,
        cssAfter: null,
        cssBefore: null,
        delay: 0,
        easeIn: null,
        easeOut: null,
        easing: null,
        end: null,
        fastOnEvent: 0,
        fit: 0,
        fx: "fade",
        fxFn: null,
        height: "auto",
        manualTrump: !0,
        metaAttr: "cycle",
        next: null,
        nowrap: 0,
        onPagerEvent: null,
        onPrevNextEvent: null,
        pager: null,
        pagerAnchorBuilder: null,
        pagerEvent: "click.cycle",
        pause: 0,
        pauseOnPagerHover: 0,
        prev: null,
        prevNextEvent: "click.cycle",
        random: 0,
        randomizeEffects: 1,
        requeueOnImageNotLoaded: !0,
        requeueTimeout: 250,
        rev: 0,
        shuffle: null,
        skipInitializationCallbacks: !1,
        slideExpr: null,
        slideResize: 1,
        speed: 1E3,
        speedIn: null,
        speedOut: null,
        startingSlide: d,
        sync: 1,
        timeout: 4E3,
        timeoutFn: null,
        updateActivePagerLink: null,
        width: null
    }
})(jQuery);
(function (a) {
    a.fn.cycle.transitions.none = function (d, h, c) {
        c.fxFn = function (c, d, g, h) {
            a(d).show();
            a(c).hide();
            h()
        }
    };
    a.fn.cycle.transitions.fadeout = function (d, h, c) {
        h.not(":eq(" + c.currSlide + ")").css({
            display: "block",
            opacity: 1
        });
        c.before.push(function (c, d, g, h, q, v) {
            a(c).css("zIndex", g.slideCount + (!0 !== v ? 1 : 0));
            a(d).css("zIndex", g.slideCount + (!0 !== v ? 0 : 1))
        });
        c.animIn.opacity = 1;
        c.animOut.opacity = 0;
        c.cssBefore.opacity = 1;
        c.cssBefore.display = "block";
        c.cssAfter.zIndex = 0
    };
    a.fn.cycle.transitions.scrollUp = function (d,
                                                h, c) {
        d.css("overflow", "hidden");
        c.before.push(a.fn.cycle.commonReset);
        d = d.height();
        c.cssBefore.top = d;
        c.cssBefore.left = 0;
        c.cssFirst.top = 0;
        c.animIn.top = 0;
        c.animOut.top = -d
    };
    a.fn.cycle.transitions.scrollDown = function (d, h, c) {
        d.css("overflow", "hidden");
        c.before.push(a.fn.cycle.commonReset);
        d = d.height();
        c.cssFirst.top = 0;
        c.cssBefore.top = -d;
        c.cssBefore.left = 0;
        c.animIn.top = 0;
        c.animOut.top = d
    };
    a.fn.cycle.transitions.scrollLeft = function (d, h, c) {
        d.css("overflow", "hidden");
        c.before.push(a.fn.cycle.commonReset);
        d =
            d.width();
        c.cssFirst.left = 0;
        c.cssBefore.left = d;
        c.cssBefore.top = 0;
        c.animIn.left = 0;
        c.animOut.left = 0 - d
    };
    a.fn.cycle.transitions.scrollRight = function (d, h, c) {
        d.css("overflow", "hidden");
        c.before.push(a.fn.cycle.commonReset);
        d = d.width();
        c.cssFirst.left = 0;
        c.cssBefore.left = -d;
        c.cssBefore.top = 0;
        c.animIn.left = 0;
        c.animOut.left = d
    };
    a.fn.cycle.transitions.scrollHorz = function (d, h, c) {
        d.css("overflow", "hidden").width();
        c.before.push(function (c, d, g, h) {
            g.rev && (h = !h);
            a.fn.cycle.commonReset(c, d, g);
            g.cssBefore.left = h ? d.cycleW -
                1 : 1 - d.cycleW;
            g.animOut.left = h ? -c.cycleW : c.cycleW
        });
        c.cssFirst.left = 0;
        c.cssBefore.top = 0;
        c.animIn.left = 0;
        c.animOut.top = 0
    };
    a.fn.cycle.transitions.scrollVert = function (d, h, c) {
        d.css("overflow", "hidden");
        c.before.push(function (c, d, g, h) {
            g.rev && (h = !h);
            a.fn.cycle.commonReset(c, d, g);
            g.cssBefore.top = h ? 1 - d.cycleH : d.cycleH - 1;
            g.animOut.top = h ? c.cycleH : -c.cycleH
        });
        c.cssFirst.top = 0;
        c.cssBefore.left = 0;
        c.animIn.top = 0;
        c.animOut.left = 0
    };
    a.fn.cycle.transitions.slideX = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a(g.elements).not(c).hide();
            a.fn.cycle.commonReset(c, d, g, !1, !0);
            g.animIn.width = d.cycleW
        });
        c.cssBefore.left = 0;
        c.cssBefore.top = 0;
        c.cssBefore.width = 0;
        c.animIn.width = "show";
        c.animOut.width = 0
    };
    a.fn.cycle.transitions.slideY = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a(g.elements).not(c).hide();
            a.fn.cycle.commonReset(c, d, g, !0, !1);
            g.animIn.height = d.cycleH
        });
        c.cssBefore.left = 0;
        c.cssBefore.top = 0;
        c.cssBefore.height = 0;
        c.animIn.height = "show";
        c.animOut.height = 0
    };
    a.fn.cycle.transitions.shuffle = function (d, h, c) {
        d = d.css("overflow", "visible").width();
        h.css({
            left: 0,
            top: 0
        });
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !0, !0, !0)
        });
        c.speedAdjusted || (c.speed /= 2, c.speedAdjusted = !0);
        c.random = 0;
        c.shuffle = c.shuffle || {
                left: -d,
                top: 15
            };
        c.els = [];
        for (d = 0; d < h.length; d++) c.els.push(h[d]);
        for (d = 0; d < c.currSlide; d++) c.els.push(c.els.shift());
        c.fxFn = function (c, d, g, h, q) {
            g.rev && (q = !q);
            var v = q ? a(c) : a(d);
            a(d).css(g.cssBefore);
            var u = g.slideCount;
            v.animate(g.shuffle, g.speedIn, g.easeIn, function () {
                for (var d = a.fn.cycle.hopsFromLast(g, q), m = 0; m < d; m++) q ? g.els.push(g.els.shift()) :
                    g.els.unshift(g.els.pop());
                if (q)
                    for (d = 0, m = g.els.length; d < m; d++) a(g.els[d]).css("z-index", m - d + u);
                else d = a(c).css("z-index"), v.css("z-index", parseInt(d, 10) + 1 + u);
                v.animate({
                    left: 0,
                    top: 0
                }, g.speedOut, g.easeOut, function () {
                    a(q ? this : c).hide();
                    h && h()
                })
            })
        };
        a.extend(c.cssBefore, {
            display: "block",
            opacity: 1,
            top: 0,
            left: 0
        })
    };
    a.fn.cycle.transitions.turnUp = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !0, !1);
            g.cssBefore.top = d.cycleH;
            g.animIn.height = d.cycleH;
            g.animOut.width = d.cycleW
        });
        c.cssFirst.top =
            0;
        c.cssBefore.left = 0;
        c.cssBefore.height = 0;
        c.animIn.top = 0;
        c.animOut.height = 0
    };
    a.fn.cycle.transitions.turnDown = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !0, !1);
            g.animIn.height = d.cycleH;
            g.animOut.top = c.cycleH
        });
        c.cssFirst.top = 0;
        c.cssBefore.left = 0;
        c.cssBefore.top = 0;
        c.cssBefore.height = 0;
        c.animOut.height = 0
    };
    a.fn.cycle.transitions.turnLeft = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !1, !0);
            g.cssBefore.left = d.cycleW;
            g.animIn.width = d.cycleW
        });
        c.cssBefore.top = 0;
        c.cssBefore.width = 0;
        c.animIn.left = 0;
        c.animOut.width = 0
    };
    a.fn.cycle.transitions.turnRight = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !1, !0);
            g.animIn.width = d.cycleW;
            g.animOut.left = c.cycleW
        });
        a.extend(c.cssBefore, {
            top: 0,
            left: 0,
            width: 0
        });
        c.animIn.left = 0;
        c.animOut.width = 0
    };
    a.fn.cycle.transitions.zoom = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !1, !1, !0);
            g.cssBefore.top = d.cycleH / 2;
            g.cssBefore.left = d.cycleW / 2;
            a.extend(g.animIn, {
                top: 0,
                left: 0,
                width: d.cycleW,
                height: d.cycleH
            });
            a.extend(g.animOut, {
                width: 0,
                height: 0,
                top: c.cycleH / 2,
                left: c.cycleW / 2
            })
        });
        c.cssFirst.top = 0;
        c.cssFirst.left = 0;
        c.cssBefore.width = 0;
        c.cssBefore.height = 0
    };
    a.fn.cycle.transitions.fadeZoom = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !1, !1);
            g.cssBefore.left = d.cycleW / 2;
            g.cssBefore.top = d.cycleH / 2;
            a.extend(g.animIn, {
                top: 0,
                left: 0,
                width: d.cycleW,
                height: d.cycleH
            })
        });
        c.cssBefore.width = 0;
        c.cssBefore.height = 0;
        c.animOut.opacity = 0
    };
    a.fn.cycle.transitions.blindX =
        function (d, h, c) {
            d = d.css("overflow", "hidden").width();
            c.before.push(function (c, d, g) {
                a.fn.cycle.commonReset(c, d, g);
                g.animIn.width = d.cycleW;
                g.animOut.left = c.cycleW
            });
            c.cssBefore.left = d;
            c.cssBefore.top = 0;
            c.animIn.left = 0;
            c.animOut.left = d
        };
    a.fn.cycle.transitions.blindY = function (d, h, c) {
        d = d.css("overflow", "hidden").height();
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g);
            g.animIn.height = d.cycleH;
            g.animOut.top = c.cycleH
        });
        c.cssBefore.top = d;
        c.cssBefore.left = 0;
        c.animIn.top = 0;
        c.animOut.top = d
    };
    a.fn.cycle.transitions.blindZ =
        function (d, h, c) {
            h = d.css("overflow", "hidden").height();
            d = d.width();
            c.before.push(function (c, d, g) {
                a.fn.cycle.commonReset(c, d, g);
                g.animIn.height = d.cycleH;
                g.animOut.top = c.cycleH
            });
            c.cssBefore.top = h;
            c.cssBefore.left = d;
            c.animIn.top = 0;
            c.animIn.left = 0;
            c.animOut.top = h;
            c.animOut.left = d
        };
    a.fn.cycle.transitions.growX = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !1, !0);
            g.cssBefore.left = this.cycleW / 2;
            g.animIn.left = 0;
            g.animIn.width = this.cycleW;
            g.animOut.left = 0
        });
        c.cssBefore.top = 0;
        c.cssBefore.width =
            0
    };
    a.fn.cycle.transitions.growY = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !0, !1);
            g.cssBefore.top = this.cycleH / 2;
            g.animIn.top = 0;
            g.animIn.height = this.cycleH;
            g.animOut.top = 0
        });
        c.cssBefore.height = 0;
        c.cssBefore.left = 0
    };
    a.fn.cycle.transitions.curtainX = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !1, !0, !0);
            g.cssBefore.left = d.cycleW / 2;
            g.animIn.left = 0;
            g.animIn.width = this.cycleW;
            g.animOut.left = c.cycleW / 2;
            g.animOut.width = 0
        });
        c.cssBefore.top = 0;
        c.cssBefore.width =
            0
    };
    a.fn.cycle.transitions.curtainY = function (d, h, c) {
        c.before.push(function (c, d, g) {
            a.fn.cycle.commonReset(c, d, g, !0, !1, !0);
            g.cssBefore.top = d.cycleH / 2;
            g.animIn.top = 0;
            g.animIn.height = d.cycleH;
            g.animOut.top = c.cycleH / 2;
            g.animOut.height = 0
        });
        c.cssBefore.height = 0;
        c.cssBefore.left = 0
    };
    a.fn.cycle.transitions.cover = function (d, h, c) {
        var l = c.direction || "left",
            m = d.css("overflow", "hidden").width(),
            g = d.height();
        c.before.push(function (c, d, h) {
            a.fn.cycle.commonReset(c, d, h);
            h.cssAfter.display = "";
            "right" == l ? h.cssBefore.left = -m : "up" == l ? h.cssBefore.top = g : "down" == l ? h.cssBefore.top = -g : h.cssBefore.left = m
        });
        c.animIn.left = 0;
        c.animIn.top = 0;
        c.cssBefore.top = 0;
        c.cssBefore.left = 0
    };
    a.fn.cycle.transitions.uncover = function (d, h, c) {
        var l = c.direction || "left",
            m = d.css("overflow", "hidden").width(),
            g = d.height();
        c.before.push(function (c, d, h) {
            a.fn.cycle.commonReset(c, d, h, !0, !0, !0);
            "right" == l ? h.animOut.left = m : "up" == l ? h.animOut.top = -g : "down" == l ? h.animOut.top = g : h.animOut.left = -m
        });
        c.animIn.left = 0;
        c.animIn.top = 0;
        c.cssBefore.top = 0;
        c.cssBefore.left =
            0
    };
    a.fn.cycle.transitions.toss = function (d, h, c) {
        var l = d.css("overflow", "visible").width(),
            m = d.height();
        c.before.push(function (c, d, h) {
            a.fn.cycle.commonReset(c, d, h, !0, !0, !0);
            h.animOut.left || h.animOut.top ? h.animOut.opacity = 0 : a.extend(h.animOut, {
                    left: 2 * l,
                    top: -m / 2,
                    opacity: 0
                })
        });
        c.cssBefore.left = 0;
        c.cssBefore.top = 0;
        c.animIn.left = 0
    };
    a.fn.cycle.transitions.wipe = function (d, h, c) {
        var l = d.css("overflow", "hidden").width(),
            m = d.height();
        c.cssBefore = c.cssBefore || {};
        var g;
        c.clip && (/l2r/.test(c.clip) ? g = "rect(0px 0px " +
                m + "px 0px)" : /r2l/.test(c.clip) ? g = "rect(0px " + l + "px " + m + "px " + l + "px)" : /t2b/.test(c.clip) ? g = "rect(0px " + l + "px 0px 0px)" : /b2t/.test(c.clip) ? g = "rect(" + m + "px " + l + "px " + m + "px 0px)" : /zoom/.test(c.clip) && (d = parseInt(m / 2, 10), h = parseInt(l / 2, 10), g = "rect(" + d + "px " + h + "px " + d + "px " + h + "px)"));
        c.cssBefore.clip = c.cssBefore.clip || g || "rect(0px 0px 0px 0px)";
        d = c.cssBefore.clip.match(/(\d+)/g);
        var n = parseInt(d[0], 10),
            q = parseInt(d[1], 10),
            v = parseInt(d[2], 10),
            u = parseInt(d[3], 10);
        c.before.push(function (c, d, g) {
            if (c != d) {
                var h =
                        a(c),
                    A = a(d);
                a.fn.cycle.commonReset(c, d, g, !0, !0, !1);
                g.cssAfter.display = "block";
                var b = 1,
                    e = parseInt(g.speedIn / 13, 10) - 1;
                (function k() {
                    var a = n ? n - parseInt(n / e * b, 10) : 0,
                        c = u ? u - parseInt(u / e * b, 10) : 0,
                        d = v < m ? v + parseInt(b * ((m - v) / e || 1), 10) : m,
                        g = q < l ? q + parseInt(b * ((l - q) / e || 1), 10) : l;
                    A.css({
                        clip: "rect(" + a + "px " + g + "px " + d + "px " + c + "px)"
                    });
                    b++ <= e ? setTimeout(k, 13) : h.css("display", "none")
                })()
            }
        });
        a.extend(c.cssBefore, {
            display: "block",
            opacity: 1,
            top: 0,
            left: 0
        });
        c.animIn = {
            left: 0
        };
        c.animOut = {
            left: 0
        }
    }
})(jQuery);

$(document).ready(function () {
    resizeBlocks(".achievements .block");
    resizeBlocks(".f-block");
    resizeBlocks(".q-block");
    resizeBlocks(".map .col-sm-6")
});
$(window).resize(function () {
    resizeBlocks(".achievements .block");
    resizeBlocks(".f-block");
    resizeBlocks(".q-block");
    resizeBlocks(".map .col-sm-6")
});

function resizeBlocks(a) {
    var d = Math.max.apply(null, $(a).map(function () {
        return $(this).height()
    }).get());
    $(a).height(d)
};
(function (a) {
    a.fn.customScrollbar = function (d, h) {
        var c = {
                skin: void 0,
                hScroll: !0,
                vScroll: !0,
                updateOnWindowResize: !1,
                animationSpeed: 300,
                onCustomScroll: void 0,
                swipeSpeed: 1,
                wheelSpeed: 40,
                fixedThumbWidth: void 0,
                fixedThumbHeight: void 0
            },
            l = function (c, d) {
                this.$element = a(c);
                this.options = d;
                this.addScrollableClass();
                this.addSkinClass();
                this.addScrollBarComponents();
                this.options.vScroll && (this.vScrollbar = new m(this, new n));
                this.options.hScroll && (this.hScrollbar = new m(this, new g));
                this.$element.data("scrollable",
                    this);
                this.initKeyboardScrolling();
                this.bindEvents()
            };
        l.prototype = {
            addScrollableClass: function () {
                this.$element.hasClass("scrollable") || (this.scrollableAdded = !0, this.$element.addClass("scrollable"))
            },
            removeScrollableClass: function () {
                this.scrollableAdded && this.$element.removeClass("scrollable")
            },
            addSkinClass: function () {
                "string" != typeof this.options.skin || this.$element.hasClass(this.options.skin) || (this.skinClassAdded = !0, this.$element.addClass(this.options.skin))
            },
            removeSkinClass: function () {
                this.skinClassAdded &&
                this.$element.removeClass(this.options.skin)
            },
            addScrollBarComponents: function () {
                this.assignViewPort();
                0 == this.$viewPort.length && (this.$element.wrapInner('<div class="viewport" />'), this.assignViewPort(), this.viewPortAdded = !0);
                this.assignOverview();
                0 == this.$overview.length && (this.$viewPort.wrapInner('<div class="overview" />'), this.assignOverview(), this.overviewAdded = !0);
                this.addScrollBar("vertical", "prepend");
                this.addScrollBar("horizontal", "append")
            },
            removeScrollbarComponents: function () {
                this.removeScrollbar("vertical");
                this.removeScrollbar("horizontal");
                this.overviewAdded && this.$element.unwrap();
                this.viewPortAdded && this.$element.unwrap()
            },
            removeScrollbar: function (a) {
                this[a + "ScrollbarAdded"] && this.$element.find(".scroll-bar." + a).remove()
            },
            assignViewPort: function () {
                this.$viewPort = this.$element.find("")
            },
            assignOverview: function () {
                this.$overview = this.$viewPort.find("")
            },
            addScrollBar: function (a, c) {
                0 == this.$element.find(".scroll-bar." + a).length && (this.$element[c]("<div class='scroll-bar " + a + "'><div class='thumb'></div></div>"),
                    this[a + "ScrollbarAdded"] = !0)
            },
            resize: function (a) {
                this.vScrollbar && this.vScrollbar.resize(a);
                this.hScrollbar && this.hScrollbar.resize(a)
            },
            scrollTo: function (a) {
                this.vScrollbar && this.vScrollbar.scrollToElement(a);
                this.hScrollbar && this.hScrollbar.scrollToElement(a)
            },
            scrollToXY: function (a, c) {
                this.scrollToX(a);
                this.scrollToY(c)
            },
            scrollToX: function (a) {
                this.hScrollbar && this.hScrollbar.scrollOverviewTo(a, !0)
            },
            scrollToY: function (a) {
                this.vScrollbar && this.vScrollbar.scrollOverviewTo(a, !0)
            },
            remove: function () {
                this.removeScrollableClass();
                this.removeSkinClass();
                this.removeScrollbarComponents();
                this.$element.data("scrollable", null);
                this.removeKeyboardScrolling();
                this.vScrollbar && this.vScrollbar.remove();
                this.hScrollbar && this.hScrollbar.remove()
            },
            setAnimationSpeed: function (a) {
                this.options.animationSpeed = a
            },
            isInside: function (c, d) {
                var g = a(c),
                    h = a(d),
                    n = g.offset(),
                    l = h.offset();
                return n.top >= l.top && n.left >= l.left && n.top + g.height() <= l.top + h.height() && n.left + g.width() <= l.left + h.width()
            },
            initKeyboardScrolling: function () {
                var a = this;
                this.elementKeydown =
                    function (c) {
                        document.activeElement === a.$element[0] && (a.vScrollbar && a.vScrollbar.keyScroll(c), a.hScrollbar && a.hScrollbar.keyScroll(c))
                    };
                this.$element.attr("tabindex", "-1").keydown(this.elementKeydown)
            },
            removeKeyboardScrolling: function () {
                this.$element.removeAttr("tabindex").unbind("keydown", this.elementKeydown)
            },
            bindEvents: function () {
                if (this.options.onCustomScroll) this.$element.on("customScroll", this.options.onCustomScroll)
            }
        };
        var m = function (a, c) {
            this.scrollable = a;
            this.sizing = c;
            this.$scrollBar = this.sizing.scrollBar(this.scrollable.$element);
            this.$thumb = this.$scrollBar.find(".thumb");
            this.setScrollPosition(0, 0);
            this.resize();
            this.initMouseMoveScrolling();
            this.initMouseWheelScrolling();
            this.initTouchScrolling();
            this.initMouseClickScrolling();
            this.initWindowResize()
        };
        m.prototype = {
            resize: function (a) {
                this.scrollable.$viewPort.height(this.scrollable.$element.height());
                this.sizing.size(this.scrollable.$viewPort, this.sizing.size(this.scrollable.$element));
                this.viewPortSize = this.sizing.size(this.scrollable.$viewPort);
                this.overviewSize = this.sizing.size(this.scrollable.$overview);
                this.ratio = this.viewPortSize / this.overviewSize;
                this.sizing.size(this.$scrollBar, this.viewPortSize);
                this.thumbSize = this.calculateThumbSize();
                this.sizing.size(this.$thumb, this.thumbSize);
                this.maxThumbPosition = this.calculateMaxThumbPosition();
                this.maxOverviewPosition = this.calculateMaxOverviewPosition();
                this.enabled = this.overviewSize > this.viewPortSize;
                void 0 === this.scrollPercent && (this.scrollPercent = 0);
                this.enabled ? this.rescroll(a) : this.setScrollPosition(0, 0);
                this.$scrollBar.toggle(this.enabled)
            },
            calculateThumbSize: function () {
                var a =
                    this.sizing.fixedThumbSize(this.scrollable.options);
                return Math.max(a ? a : this.ratio * this.viewPortSize, this.sizing.minSize(this.$thumb))
            },
            initMouseMoveScrolling: function () {
                var c = this;
                this.$thumb.mousedown(function (a) {
                    c.enabled && c.startMouseMoveScrolling(a)
                });
                this.documentMouseup = function (a) {
                    c.stopMouseMoveScrolling(a)
                };
                a(document).mouseup(this.documentMouseup);
                this.documentMousemove = function (a) {
                    c.mouseMoveScroll(a)
                };
                a(document).mousemove(this.documentMousemove);
                this.$thumb.click(function (a) {
                    a.stopPropagation()
                })
            },
            removeMouseMoveScrolling: function () {
                this.$thumb.unbind();
                a(document).unbind("mouseup", this.documentMouseup);
                a(document).unbind("mousemove", this.documentMousemove)
            },
            initMouseWheelScrolling: function () {
                var a = this;
                this.scrollable.$element.mousewheel(function (c, d, g, h) {
                    a.enabled && a.mouseWheelScroll(g, h) && (c.stopPropagation(), c.preventDefault())
                })
            },
            removeMouseWheelScrolling: function () {
                this.scrollable.$element.unbind("mousewheel")
            },
            initTouchScrolling: function () {
                if (document.addEventListener) {
                    var a = this;
                    this.elementTouchstart =
                        function (c) {
                            a.enabled && a.startTouchScrolling(c)
                        };
                    this.scrollable.$element[0].addEventListener("touchstart", this.elementTouchstart);
                    this.documentTouchmove = function (c) {
                        a.touchScroll(c)
                    };
                    document.addEventListener("touchmove", this.documentTouchmove);
                    this.elementTouchend = function (c) {
                        a.stopTouchScrolling(c)
                    };
                    this.scrollable.$element[0].addEventListener("touchend", this.elementTouchend)
                }
            },
            removeTouchScrolling: function () {
                document.addEventListener && (this.scrollable.$element[0].removeEventListener("touchstart",
                    this.elementTouchstart), document.removeEventListener("touchmove", this.documentTouchmove), this.scrollable.$element[0].removeEventListener("touchend", this.elementTouchend))
            },
            initMouseClickScrolling: function () {
                var a = this;
                this.scrollBarClick = function (c) {
                    a.mouseClickScroll(c)
                };
                this.$scrollBar.click(this.scrollBarClick)
            },
            removeMouseClickScrolling: function () {
                this.$scrollBar.unbind("click", this.scrollBarClick)
            },
            initWindowResize: function () {
                if (this.scrollable.options.updateOnWindowResize) {
                    var c = this;
                    this.windowResize =
                        function () {
                            c.resize()
                        };
                    a(window).resize(this.windowResize)
                }
            },
            removeWindowResize: function () {
                a(window).unbind("resize", this.windowResize)
            },
            isKeyScrolling: function (a) {
                return null != this.keyScrollDelta(a)
            },
            keyScrollDelta: function (a) {
                for (var c in this.sizing.scrollingKeys)
                    if (c == a) return this.sizing.scrollingKeys[a](this.viewPortSize);
                return null
            },
            startMouseMoveScrolling: function (c) {
                this.mouseMoveScrolling = !0;
                a("html").addClass("not-selectable");
                this.setUnselectable(a("html"), "on");
                this.setScrollEvent(c)
            },
            stopMouseMoveScrolling: function (c) {
                this.mouseMoveScrolling = !1;
                a("html").removeClass("not-selectable");
                this.setUnselectable(a("html"), null)
            },
            setUnselectable: function (a, c) {
                a.attr("unselectable") != c && (a.attr("unselectable", c), a.find(":not(input)").attr("unselectable", c))
            },
            mouseMoveScroll: function (a) {
                if (this.mouseMoveScrolling) {
                    var c = this.sizing.mouseDelta(this.scrollEvent, a);
                    this.scrollThumbBy(c);
                    this.setScrollEvent(a)
                }
            },
            startTouchScrolling: function (a) {
                a.touches && 1 == a.touches.length && (this.setScrollEvent(a.touches[0]),
                    this.touchScrolling = !0, a.stopPropagation())
            },
            touchScroll: function (a) {
                if (this.touchScrolling && a.touches && 1 == a.touches.length) {
                    var c = -this.sizing.mouseDelta(this.scrollEvent, a.touches[0]) * this.scrollable.options.swipeSpeed;
                    this.scrollOverviewBy(c) && (a.stopPropagation(), a.preventDefault(), this.setScrollEvent(a.touches[0]))
                }
            },
            stopTouchScrolling: function (a) {
                this.touchScrolling = !1;
                a.stopPropagation()
            },
            mouseWheelScroll: function (a, c) {
                var d = -this.sizing.wheelDelta(a, c) * this.scrollable.options.wheelSpeed;
                if (0 !=
                    d) return this.scrollOverviewBy(d)
            },
            mouseClickScroll: function (a) {
                var c = this.viewPortSize - 20;
                a["page" + this.sizing.scrollAxis()] < this.$thumb.offset()[this.sizing.offsetComponent()] && (c = -c);
                this.scrollOverviewBy(c)
            },
            keyScroll: function (a) {
                var c = a.which;
                this.enabled && this.isKeyScrolling(c) && this.scrollOverviewBy(this.keyScrollDelta(c)) && a.preventDefault()
            },
            scrollThumbBy: function (a) {
                var c = this.thumbPosition(),
                    c = this.positionOrMax(c + a, this.maxThumbPosition);
                a = this.scrollPercent;
                this.scrollPercent = c / this.maxThumbPosition;
                this.setScrollPosition(c * this.maxOverviewPosition / this.maxThumbPosition, c);
                return a != this.scrollPercent ? (this.triggerCustomScroll(a), !0) : !1
            },
            thumbPosition: function () {
                return this.$thumb.position()[this.sizing.offsetComponent()]
            },
            scrollOverviewBy: function (a) {
                a = this.overviewPosition() + a;
                return this.scrollOverviewTo(a, !1)
            },
            overviewPosition: function () {
                return -this.scrollable.$overview.position()[this.sizing.offsetComponent()]
            },
            scrollOverviewTo: function (a, c) {
                a = this.positionOrMax(a, this.maxOverviewPosition);
                var d = this.scrollPercent;
                this.scrollPercent = a / this.maxOverviewPosition;
                var g = this.scrollPercent * this.maxThumbPosition;
                c ? this.setScrollPositionWithAnimation(a, g) : this.setScrollPosition(a, g);
                return d != this.scrollPercent ? (this.triggerCustomScroll(d), !0) : !1
            },
            positionOrMax: function (a, c) {
                return 0 > a ? 0 : a > c ? c : a
            },
            triggerCustomScroll: function (a) {
                this.scrollable.$element.trigger("customScroll", {
                    scrollAxis: this.sizing.scrollAxis(),
                    direction: this.sizing.scrollDirection(a, this.scrollPercent),
                    scrollPercent: 100 * this.scrollPercent
                })
            },
            rescroll: function (a) {
                if (a) {
                    a = this.positionOrMax(this.overviewPosition(), this.maxOverviewPosition);
                    this.scrollPercent = a / this.maxOverviewPosition;
                    var c = this.scrollPercent * this.maxThumbPosition
                } else c = this.scrollPercent * this.maxThumbPosition, a = this.scrollPercent * this.maxOverviewPosition;
                this.setScrollPosition(a, c)
            },
            setScrollPosition: function (a, c) {
                this.$thumb.css(this.sizing.offsetComponent(), c + "px");
                this.scrollable.$overview.css(this.sizing.offsetComponent(), -a + "px")
            },
            setScrollPositionWithAnimation: function (a,
                                                      c) {
                var d = {},
                    g = {};
                d[this.sizing.offsetComponent()] = c + "px";
                this.$thumb.animate(d, this.scrollable.options.animationSpeed);
                g[this.sizing.offsetComponent()] = -a + "px";
                this.scrollable.$overview.animate(g, this.scrollable.options.animationSpeed)
            },
            calculateMaxThumbPosition: function () {
                return this.sizing.size(this.$scrollBar) - this.thumbSize
            },
            calculateMaxOverviewPosition: function () {
                return this.sizing.size(this.scrollable.$overview) - this.sizing.size(this.scrollable.$viewPort)
            },
            setScrollEvent: function (a) {
                var c = "page" +
                    this.sizing.scrollAxis();
                this.scrollEvent && this.scrollEvent[c] == a[c] || (this.scrollEvent = {
                    pageX: a.pageX,
                    pageY: a.pageY
                })
            },
            scrollToElement: function (c) {
                c = a(c);
                if (this.sizing.isInside(c, this.scrollable.$overview) && !this.sizing.isInside(c, this.scrollable.$viewPort)) {
                    c = c.offset();
                    var d = this.scrollable.$overview.offset();
                    this.scrollable.$viewPort.offset();
                    this.scrollOverviewTo(c[this.sizing.offsetComponent()] - d[this.sizing.offsetComponent()], !0)
                }
            },
            remove: function () {
                this.removeMouseMoveScrolling();
                this.removeMouseWheelScrolling();
                this.removeTouchScrolling();
                this.removeMouseClickScrolling();
                this.removeWindowResize()
            }
        };
        var g = function () {
        };
        g.prototype = {
            size: function (a, c) {
                return c ? a.width(c) : a.width()
            },
            minSize: function (a) {
                return parseInt(a.css("min-width")) || 0
            },
            fixedThumbSize: function (a) {
                return a.fixedThumbWidth
            },
            scrollBar: function (a) {
                return a.find(".scroll-bar.horizontal")
            },
            mouseDelta: function (a, c) {
                return c.pageX - a.pageX
            },
            offsetComponent: function () {
                return "left"
            },
            wheelDelta: function (a, c) {
                return a
            },
            scrollAxis: function () {
                return "X"
            },
            scrollDirection: function (a, c) {
                return a < c ? "right" : "left"
            },
            scrollingKeys: {
                37: function (a) {
                    return -10
                },
                39: function (a) {
                    return 10
                }
            },
            isInside: function (c, d) {
                var g = a(c),
                    h = a(d),
                    n = g.offset(),
                    l = h.offset();
                return n.left >= l.left && n.left + g.width() <= l.left + h.width()
            }
        };
        var n = function () {
        };
        n.prototype = {
            size: function (a, c) {
                return c ? a.height(c) : a.height()
            },
            minSize: function (a) {
                return parseInt(a.css("min-height")) || 0
            },
            fixedThumbSize: function (a) {
                return a.fixedThumbHeight
            },
            scrollBar: function (a) {
                return a.find(".scroll-bar.vertical")
            },
            mouseDelta: function (a, c) {
                return c.pageY - a.pageY
            },
            offsetComponent: function () {
                return "top"
            },
            wheelDelta: function (a, c) {
                return c
            },
            scrollAxis: function () {
                return "Y"
            },
            scrollDirection: function (a, c) {
                return a < c ? "down" : "up"
            },
            scrollingKeys: {
                38: function (a) {
                    return -10
                },
                40: function (a) {
                    return 10
                },
                33: function (a) {
                    return -(a - 20)
                },
                34: function (a) {
                    return a - 20
                }
            },
            isInside: function (c, d) {
                var g = a(c),
                    h = a(d),
                    n = g.offset(),
                    l = h.offset();
                return n.top >= l.top && n.top + g.height() <= l.top + h.height()
            }
        };
        return this.each(function () {
            void 0 == d &&
            (d = c);
            if ("string" == typeof d) {
                var g = a(this).data("scrollable");
                if (g) g[d](h)
            } else if ("object" == typeof d) d = a.extend(c, d), new l(a(this), d);
            else throw "Invalid type of options";
        })
    }
})(jQuery);
(function (a) {
    function d(c) {
        var d = c || window.event,
            g = [].slice.call(arguments, 1),
            h = 0,
            q = 0,
            v = 0;
        c = a.event.fix(d);
        c.type = "mousewheel";
        d.wheelDelta && (h = d.wheelDelta / 120);
        d.detail && (h = -d.detail / 3);
        v = h;
        void 0 !== d.axis && d.axis === d.HORIZONTAL_AXIS && (v = 0, q = h);
        void 0 !== d.wheelDeltaY && (v = d.wheelDeltaY / 120);
        void 0 !== d.wheelDeltaX && (q = d.wheelDeltaX / 120);
        g.unshift(c, h, q, v);
        return (a.event.dispatch || a.event.handle).apply(this, g)
    }

    var h = ["DOMMouseScroll", "mousewheel"];
    if (a.event.fixHooks)
        for (var c = h.length; c;) a.event.fixHooks[h[--c]] =
            a.event.mouseHooks;
    a.event.special.mousewheel = {
        setup: function () {
            if (this.addEventListener)
                for (var a = h.length; a;) this.addEventListener(h[--a], d, !1);
            else this.onmousewheel = d
        },
        teardown: function () {
            if (this.removeEventListener)
                for (var a = h.length; a;) this.removeEventListener(h[--a], d, !1);
            else this.onmousewheel = null
        }
    };
    a.fn.extend({
        mousewheel: function (a) {
            return a ? this.bind("mousewheel", a) : this.trigger("mousewheel")
        },
        unmousewheel: function (a) {
            return this.unbind("mousewheel", a)
        }
    })
})(jQuery);
(function (a) {
    "function" === typeof define && define.amd ? define(["jquery"], a) : "undefined" !== typeof exports ? module.exports = a(require("jquery")) : a(jQuery)
})(function (a) {
    var d = window.Slick || {},
        d = function () {
            var d = 0;
            return function (c, l) {
                var m;
                this.defaults = {
                    accessibility: !0,
                    adaptiveHeight: !1,
                    appendArrows: a(c),
                    appendDots: a(c),
                    arrows: !0,
                    asNavFor: null,
                    prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>',
                    nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>',
                    autoplay: !1,
                    autoplaySpeed: 3E3,
                    centerMode: !1,
                    centerPadding: "50px",
                    cssEase: "ease",
                    customPaging: function (c, d) {
                        return a('<button type="button" data-role="none" role="button" tabindex="0" />').text(d + 1)
                    },
                    dots: !1,
                    dotsClass: "slick-dots",
                    draggable: !0,
                    easing: "linear",
                    edgeFriction: .35,
                    fade: !1,
                    focusOnSelect: !1,
                    infinite: !0,
                    initialSlide: 0,
                    lazyLoad: "ondemand",
                    mobileFirst: !1,
                    pauseOnHover: !0,
                    pauseOnFocus: !0,
                    pauseOnDotsHover: !1,
                    respondTo: "window",
                    responsive: null,
                    rows: 1,
                    rtl: !1,
                    slide: "",
                    slidesPerRow: 1,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    speed: 500,
                    swipe: !0,
                    swipeToSlide: !1,
                    touchMove: !0,
                    touchThreshold: 5,
                    useCSS: !0,
                    useTransform: !0,
                    variableWidth: !1,
                    vertical: !1,
                    verticalSwiping: !1,
                    waitForAnimate: !0,
                    zIndex: 1E3
                };
                this.initials = {
                    animating: !1,
                    dragging: !1,
                    autoPlayTimer: null,
                    currentDirection: 0,
                    currentLeft: null,
                    currentSlide: 0,
                    direction: 1,
                    $dots: null,
                    listWidth: null,
                    listHeight: null,
                    loadIndex: 0,
                    $nextArrow: null,
                    $prevArrow: null,
                    slideCount: null,
                    slideWidth: null,
                    $slideTrack: null,
                    $slides: null,
                    sliding: !1,
                    slideOffset: 0,
                    swipeLeft: null,
                    $list: null,
                    touchObject: {},
                    transformsEnabled: !1,
                    unslicked: !1
                };
                a.extend(this, this.initials);
                this.animProp = this.animType = this.activeBreakpoint = null;
                this.breakpoints = [];
                this.breakpointSettings = [];
                this.interrupted = this.focussed = this.cssTransitions = !1;
                this.hidden = "hidden";
                this.paused = !0;
                this.respondTo = this.positionProp = null;
                this.rowCount = 1;
                this.shouldClick = !0;
                this.$slider = a(c);
                this.transitionType = this.transformType = this.$slidesCache = null;
                this.visibilityChange = "visibilitychange";
                this.windowWidth = 0;
                this.windowTimer =
                    null;
                m = a(c).data("slick") || {};
                this.options = a.extend({}, this.defaults, l, m);
                this.currentSlide = this.options.initialSlide;
                this.originalSettings = this.options;
                "undefined" !== typeof document.mozHidden ? (this.hidden = "mozHidden", this.visibilityChange = "mozvisibilitychange") : "undefined" !== typeof document.webkitHidden && (this.hidden = "webkitHidden", this.visibilityChange = "webkitvisibilitychange");
                this.autoPlay = a.proxy(this.autoPlay, this);
                this.autoPlayClear = a.proxy(this.autoPlayClear, this);
                this.autoPlayIterator = a.proxy(this.autoPlayIterator,
                    this);
                this.changeSlide = a.proxy(this.changeSlide, this);
                this.clickHandler = a.proxy(this.clickHandler, this);
                this.selectHandler = a.proxy(this.selectHandler, this);
                this.setPosition = a.proxy(this.setPosition, this);
                this.swipeHandler = a.proxy(this.swipeHandler, this);
                this.dragHandler = a.proxy(this.dragHandler, this);
                this.keyHandler = a.proxy(this.keyHandler, this);
                this.instanceUid = d++;
                this.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/;
                this.registerBreakpoints();
                this.init(!0)
            }
        }();
    d.prototype.activateADA = function () {
        this.$slideTrack.find(".slick-active").attr({
            "aria-hidden": "false"
        }).find("a, input, button, select").attr({
            tabindex: "0"
        })
    };
    d.prototype.addSlide = d.prototype.slickAdd = function (d, c, l) {
        if ("boolean" === typeof c) l = c, c = null;
        else if (0 > c || c >= this.slideCount) return !1;
        this.unload();
        "number" === typeof c ? 0 === c && 0 === this.$slides.length ? a(d).appendTo(this.$slideTrack) : l ? a(d).insertBefore(this.$slides.eq(c)) : a(d).insertAfter(this.$slides.eq(c)) : !0 === l ? a(d).prependTo(this.$slideTrack) : a(d).appendTo(this.$slideTrack);
        this.$slides = this.$slideTrack.children(this.options.slide);
        this.$slideTrack.children(this.options.slide).detach();
        this.$slideTrack.append(this.$slides);
        this.$slides.each(function (c, d) {
            a(d).attr("data-slick-index", c)
        });
        this.$slidesCache = this.$slides;
        this.reinit()
    };
    d.prototype.animateHeight = function () {
        if (1 === this.options.slidesToShow && !0 === this.options.adaptiveHeight && !1 === this.options.vertical) {
            var a = this.$slides.eq(this.currentSlide).outerHeight(!0);
            this.$list.animate({
                height: a
            }, this.options.speed)
        }
    };
    d.prototype.animateSlide = function (d, c) {
        var l = {},
            m = this;
        m.animateHeight();
        !0 === m.options.rtl && !1 === m.options.vertical && (d = -d);
        !1 === m.transformsEnabled ?
            !1 === m.options.vertical ? m.$slideTrack.animate({
                    left: d
                }, m.options.speed, m.options.easing, c) : m.$slideTrack.animate({
                    top: d
                }, m.options.speed, m.options.easing, c) : !1 === m.cssTransitions ? (!0 === m.options.rtl && (m.currentLeft = -m.currentLeft), a({
                    animStart: m.currentLeft
                }).animate({
                    animStart: d
                }, {
                    duration: m.options.speed,
                    easing: m.options.easing,
                    step: function (a) {
                        a = Math.ceil(a);
                        l[m.animType] = !1 === m.options.vertical ? "translate(" + a + "px, 0px)" : "translate(0px," + a + "px)";
                        m.$slideTrack.css(l)
                    },
                    complete: function () {
                        c && c.call()
                    }
                })) :
                (m.applyTransition(), d = Math.ceil(d), l[m.animType] = !1 === m.options.vertical ? "translate3d(" + d + "px, 0px, 0px)" : "translate3d(0px," + d + "px, 0px)", m.$slideTrack.css(l), c && setTimeout(function () {
                    m.disableTransition();
                    c.call()
                }, m.options.speed))
    };
    d.prototype.getNavTarget = function () {
        var d = this.options.asNavFor;
        d && null !== d && (d = a(d).not(this.$slider));
        return d
    };
    d.prototype.asNavFor = function (d) {
        var c = this.getNavTarget();
        null !== c && "object" === typeof c && c.each(function () {
            var c = a(this).slick("getSlick");
            c.unslicked ||
            c.slideHandler(d, !0)
        })
    };
    d.prototype.applyTransition = function (a) {
        var c = {};
        c[this.transitionType] = !1 === this.options.fade ? this.transformType + " " + this.options.speed + "ms " + this.options.cssEase : "opacity " + this.options.speed + "ms " + this.options.cssEase;
        !1 === this.options.fade ? this.$slideTrack.css(c) : this.$slides.eq(a).css(c)
    };
    d.prototype.autoPlay = function () {
        this.autoPlayClear();
        this.slideCount > this.options.slidesToShow && (this.autoPlayTimer = setInterval(this.autoPlayIterator, this.options.autoplaySpeed))
    };
    d.prototype.autoPlayClear =
        function () {
            this.autoPlayTimer && clearInterval(this.autoPlayTimer)
        };
    d.prototype.autoPlayIterator = function () {
        var a = this.currentSlide + this.options.slidesToScroll;
        this.paused || this.interrupted || this.focussed || (!1 === this.options.infinite && (1 === this.direction && this.currentSlide + 1 === this.slideCount - 1 ? this.direction = 0 : 0 === this.direction && (a = this.currentSlide - this.options.slidesToScroll, 0 === this.currentSlide - 1 && (this.direction = 1))), this.slideHandler(a))
    };
    d.prototype.buildArrows = function () {
        !0 === this.options.arrows &&
        (this.$prevArrow = a(this.options.prevArrow).addClass("slick-arrow"), this.$nextArrow = a(this.options.nextArrow).addClass("slick-arrow"), this.slideCount > this.options.slidesToShow ? (this.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), this.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), this.htmlExpr.test(this.options.prevArrow) && this.$prevArrow.prependTo(this.options.appendArrows), this.htmlExpr.test(this.options.nextArrow) && this.$nextArrow.appendTo(this.options.appendArrows), !0 !== this.options.infinite && this.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : this.$prevArrow.add(this.$nextArrow).addClass("slick-hidden").attr({
                "aria-disabled": "true",
                tabindex: "-1"
            }))
    };
    d.prototype.buildDots = function () {
        var d, c;
        if (!0 === this.options.dots && this.slideCount > this.options.slidesToShow) {
            this.$slider.addClass("slick-dotted");
            c = a("<ul />").addClass(this.options.dotsClass);
            for (d = 0; d <= this.getDotCount(); d += 1) c.append(a("<li />").append(this.options.customPaging.call(this,
                this, d)));
            this.$dots = c.appendTo(this.options.appendDots);
            this.$dots.find("li").first().addClass("slick-active").attr("aria-hidden", "false")
        }
    };
    d.prototype.buildOut = function () {
        this.$slides = this.$slider.children(this.options.slide + ":not(.slick-cloned)").addClass("slick-slide");
        this.slideCount = this.$slides.length;
        this.$slides.each(function (d, c) {
            a(c).attr("data-slick-index", d).data("originalStyling", a(c).attr("style") || "")
        });
        this.$slider.addClass("slick-slider");
        this.$slideTrack = 0 === this.slideCount ? a('<div class="slick-track"/>').appendTo(this.$slider) :
            this.$slides.wrapAll('<div class="slick-track"/>').parent();
        this.$list = this.$slideTrack.wrap('<div aria-live="polite" class="slick-list"/>').parent();
        this.$slideTrack.css("opacity", 0);
        if (!0 === this.options.centerMode || !0 === this.options.swipeToSlide) this.options.slidesToScroll = 1;
        a("img[data-lazy]", this.$slider).not("[src]").addClass("slick-loading");
        this.setupInfinite();
        this.buildArrows();
        this.buildDots();
        this.updateDots();
        this.setSlideClasses("number" === typeof this.currentSlide ? this.currentSlide : 0);
        !0 === this.options.draggable && this.$list.addClass("draggable")
    };
    d.prototype.buildRows = function () {
        var a, c, d, m, g, n, q;
        m = document.createDocumentFragment();
        n = this.$slider.children();
        if (1 < this.options.rows) {
            q = this.options.slidesPerRow * this.options.rows;
            g = Math.ceil(n.length / q);
            for (a = 0; a < g; a++) {
                var v = document.createElement("div");
                for (c = 0; c < this.options.rows; c++) {
                    var u = document.createElement("div");
                    for (d = 0; d < this.options.slidesPerRow; d++) {
                        var x = a * q + (c * this.options.slidesPerRow + d);
                        n.get(x) && u.appendChild(n.get(x))
                    }
                    v.appendChild(u)
                }
                m.appendChild(v)
            }
            this.$slider.empty().append(m);
            this.$slider.children().children().children().css({
                width: 100 / this.options.slidesPerRow + "%",
                display: "inline-block"
            })
        }
    };
    d.prototype.checkResponsive = function (d, c) {
        var l, m, g, n = !1;
        m = this.$slider.width();
        var q = window.innerWidth || a(window).width();
        "window" === this.respondTo ? g = q : "slider" === this.respondTo ? g = m : "min" === this.respondTo && (g = Math.min(q, m));
        if (this.options.responsive && this.options.responsive.length && null !== this.options.responsive) {
            m = null;
            for (l in this.breakpoints) this.breakpoints.hasOwnProperty(l) &&
            (!1 === this.originalSettings.mobileFirst ? g < this.breakpoints[l] && (m = this.breakpoints[l]) : g > this.breakpoints[l] && (m = this.breakpoints[l]));
            if (null !== m)
                if (null !== this.activeBreakpoint) {
                    if (m !== this.activeBreakpoint || c) this.activeBreakpoint = m, "unslick" === this.breakpointSettings[m] ? this.unslick(m) : (this.options = a.extend({}, this.originalSettings, this.breakpointSettings[m]), !0 === d && (this.currentSlide = this.options.initialSlide), this.refresh(d)), n = m
                } else this.activeBreakpoint = m, "unslick" === this.breakpointSettings[m] ?
                    this.unslick(m) : (this.options = a.extend({}, this.originalSettings, this.breakpointSettings[m]), !0 === d && (this.currentSlide = this.options.initialSlide), this.refresh(d)), n = m;
            else null !== this.activeBreakpoint && (this.activeBreakpoint = null, this.options = this.originalSettings, !0 === d && (this.currentSlide = this.options.initialSlide), this.refresh(d), n = m);
            d || !1 === n || this.$slider.trigger("breakpoint", [this, n])
        }
    };
    d.prototype.changeSlide = function (d, c) {
        var l = a(d.currentTarget),
            m;
        l.is("a") && d.preventDefault();
        l.is("li") ||
        (l = l.closest("li"));
        m = 0 !== this.slideCount % this.options.slidesToScroll ? 0 : (this.slideCount - this.currentSlide) % this.options.slidesToScroll;
        switch (d.data.message) {
            case "previous":
                l = 0 === m ? this.options.slidesToScroll : this.options.slidesToShow - m;
                this.slideCount > this.options.slidesToShow && this.slideHandler(this.currentSlide - l, !1, c);
                break;
            case "next":
                l = 0 === m ? this.options.slidesToScroll : m;
                this.slideCount > this.options.slidesToShow && this.slideHandler(this.currentSlide + l, !1, c);
                break;
            case "index":
                m = 0 === d.data.index ?
                    0 : d.data.index || l.index() * this.options.slidesToScroll, this.slideHandler(this.checkNavigable(m), !1, c), l.children().trigger("focus")
        }
    };
    d.prototype.checkNavigable = function (a) {
        var c, d;
        c = this.getNavigableIndexes();
        d = 0;
        if (a > c[c.length - 1]) a = c[c.length - 1];
        else
            for (var m in c) {
                if (a < c[m]) {
                    a = d;
                    break
                }
                d = c[m]
            }
        return a
    };
    d.prototype.cleanUpEvents = function () {
        this.options.dots && null !== this.$dots && a("li", this.$dots).off("click.slick", this.changeSlide).off("mouseenter.slick", a.proxy(this.interrupt, this, !0)).off("mouseleave.slick",
            a.proxy(this.interrupt, this, !1));
        this.$slider.off("focus.slick blur.slick");
        !0 === this.options.arrows && this.slideCount > this.options.slidesToShow && (this.$prevArrow && this.$prevArrow.off("click.slick", this.changeSlide), this.$nextArrow && this.$nextArrow.off("click.slick", this.changeSlide));
        this.$list.off("touchstart.slick mousedown.slick", this.swipeHandler);
        this.$list.off("touchmove.slick mousemove.slick", this.swipeHandler);
        this.$list.off("touchend.slick mouseup.slick", this.swipeHandler);
        this.$list.off("touchcancel.slick mouseleave.slick",
            this.swipeHandler);
        this.$list.off("click.slick", this.clickHandler);
        a(document).off(this.visibilityChange, this.visibility);
        this.cleanUpSlideEvents();
        !0 === this.options.accessibility && this.$list.off("keydown.slick", this.keyHandler);
        !0 === this.options.focusOnSelect && a(this.$slideTrack).children().off("click.slick", this.selectHandler);
        a(window).off("orientationchange.slick.slick-" + this.instanceUid, this.orientationChange);
        a(window).off("resize.slick.slick-" + this.instanceUid, this.resize);
        a("[draggable!=true]",
            this.$slideTrack).off("dragstart", this.preventDefault);
        a(window).off("load.slick.slick-" + this.instanceUid, this.setPosition);
        a(document).off("ready.slick.slick-" + this.instanceUid, this.setPosition)
    };
    d.prototype.cleanUpSlideEvents = function () {
        this.$list.off("mouseenter.slick", a.proxy(this.interrupt, this, !0));
        this.$list.off("mouseleave.slick", a.proxy(this.interrupt, this, !1))
    };
    d.prototype.cleanUpRows = function () {
        var a;
        1 < this.options.rows && (a = this.$slides.children().children(), a.removeAttr("style"), this.$slider.empty().append(a))
    };
    d.prototype.clickHandler = function (a) {
        !1 === this.shouldClick && (a.stopImmediatePropagation(), a.stopPropagation(), a.preventDefault())
    };
    d.prototype.destroy = function (d) {
        this.autoPlayClear();
        this.touchObject = {};
        this.cleanUpEvents();
        a(".slick-cloned", this.$slider).detach();
        this.$dots && this.$dots.remove();
        this.$prevArrow && this.$prevArrow.length && (this.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), this.htmlExpr.test(this.options.prevArrow) &&
        this.$prevArrow.remove());
        this.$nextArrow && this.$nextArrow.length && (this.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), this.htmlExpr.test(this.options.nextArrow) && this.$nextArrow.remove());
        this.$slides && (this.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function () {
            a(this).attr("style", a(this).data("originalStyling"))
        }),
            this.$slideTrack.children(this.options.slide).detach(), this.$slideTrack.detach(), this.$list.detach(), this.$slider.append(this.$slides));
        this.cleanUpRows();
        this.$slider.removeClass("slick-slider");
        this.$slider.removeClass("slick-initialized");
        this.$slider.removeClass("slick-dotted");
        this.unslicked = !0;
        d || this.$slider.trigger("destroy", [this])
    };
    d.prototype.disableTransition = function (a) {
        var c = {};
        c[this.transitionType] = "";
        !1 === this.options.fade ? this.$slideTrack.css(c) : this.$slides.eq(a).css(c)
    };
    d.prototype.fadeSlide =
        function (a, c) {
            var d = this;
            !1 === d.cssTransitions ? (d.$slides.eq(a).css({
                    zIndex: d.options.zIndex
                }), d.$slides.eq(a).animate({
                    opacity: 1
                }, d.options.speed, d.options.easing, c)) : (d.applyTransition(a), d.$slides.eq(a).css({
                    opacity: 1,
                    zIndex: d.options.zIndex
                }), c && setTimeout(function () {
                    d.disableTransition(a);
                    c.call()
                }, d.options.speed))
        };
    d.prototype.fadeSlideOut = function (a) {
        !1 === this.cssTransitions ? this.$slides.eq(a).animate({
                opacity: 0,
                zIndex: this.options.zIndex - 2
            }, this.options.speed, this.options.easing) : (this.applyTransition(a),
                this.$slides.eq(a).css({
                    opacity: 0,
                    zIndex: this.options.zIndex - 2
                }))
    };
    d.prototype.filterSlides = d.prototype.slickFilter = function (a) {
        null !== a && (this.$slidesCache = this.$slides, this.unload(), this.$slideTrack.children(this.options.slide).detach(), this.$slidesCache.filter(a).appendTo(this.$slideTrack), this.reinit())
    };
    d.prototype.focusHandler = function () {
        var d = this;
        d.$slider.off("focus.slick blur.slick").on("focus.slick blur.slick", "*:not(.slick-arrow)", function (c) {
            c.stopImmediatePropagation();
            var l = a(this);
            setTimeout(function () {
                d.options.pauseOnFocus && (d.focussed = l.is(":focus"), d.autoPlay())
            }, 0)
        })
    };
    d.prototype.getCurrent = d.prototype.slickCurrentSlide = function () {
        return this.currentSlide
    };
    d.prototype.getDotCount = function () {
        var a = 0,
            c = 0,
            d = 0;
        if (!0 === this.options.infinite)
            for (; a < this.slideCount;) ++d, a = c + this.options.slidesToScroll, c += this.options.slidesToScroll <= this.options.slidesToShow ? this.options.slidesToScroll : this.options.slidesToShow;
        else if (!0 === this.options.centerMode) d = this.slideCount;
        else if (this.options.asNavFor)
            for (; a <
                   this.slideCount;) ++d, a = c + this.options.slidesToScroll, c += this.options.slidesToScroll <= this.options.slidesToShow ? this.options.slidesToScroll : this.options.slidesToShow;
        else d = 1 + Math.ceil((this.slideCount - this.options.slidesToShow) / this.options.slidesToScroll);
        return d - 1
    };
    d.prototype.getLeft = function (a) {
        var c, d = 0;
        this.slideOffset = 0;
        c = this.$slides.first().outerHeight(!0);
        !0 === this.options.infinite ? (this.slideCount > this.options.slidesToShow && (this.slideOffset = this.slideWidth * this.options.slidesToShow * -1,
                d = c * this.options.slidesToShow * -1), 0 !== this.slideCount % this.options.slidesToScroll && a + this.options.slidesToScroll > this.slideCount && this.slideCount > this.options.slidesToShow && (a > this.slideCount ? (this.slideOffset = (this.options.slidesToShow - (a - this.slideCount)) * this.slideWidth * -1, d = (this.options.slidesToShow - (a - this.slideCount)) * c * -1) : (this.slideOffset = this.slideCount % this.options.slidesToScroll * this.slideWidth * -1, d = this.slideCount % this.options.slidesToScroll * c * -1))) : a + this.options.slidesToShow > this.slideCount &&
            (this.slideOffset = (a + this.options.slidesToShow - this.slideCount) * this.slideWidth, d = (a + this.options.slidesToShow - this.slideCount) * c);
        this.slideCount <= this.options.slidesToShow && (d = this.slideOffset = 0);
        !0 === this.options.centerMode && !0 === this.options.infinite ? this.slideOffset += this.slideWidth * Math.floor(this.options.slidesToShow / 2) - this.slideWidth : !0 === this.options.centerMode && (this.slideOffset = 0, this.slideOffset += this.slideWidth * Math.floor(this.options.slidesToShow / 2));
        c = !1 === this.options.vertical ? a *
            this.slideWidth * -1 + this.slideOffset : a * c * -1 + d;
        !0 === this.options.variableWidth && (d = this.slideCount <= this.options.slidesToShow || !1 === this.options.infinite ? this.$slideTrack.children(".slick-slide").eq(a) : this.$slideTrack.children(".slick-slide").eq(a + this.options.slidesToShow), c = !0 === this.options.rtl ? d[0] ? -1 * (this.$slideTrack.width() - d[0].offsetLeft - d.width()) : 0 : d[0] ? -1 * d[0].offsetLeft : 0, !0 === this.options.centerMode && (d = this.slideCount <= this.options.slidesToShow || !1 === this.options.infinite ? this.$slideTrack.children(".slick-slide").eq(a) :
            this.$slideTrack.children(".slick-slide").eq(a + this.options.slidesToShow + 1), c = !0 === this.options.rtl ? d[0] ? -1 * (this.$slideTrack.width() - d[0].offsetLeft - d.width()) : 0 : d[0] ? -1 * d[0].offsetLeft : 0, c += (this.$list.width() - d.outerWidth()) / 2));
        return c
    };
    d.prototype.getOption = d.prototype.slickGetOption = function (a) {
        return this.options[a]
    };
    d.prototype.getNavigableIndexes = function () {
        var a = 0,
            c = 0,
            d = [],
            m;
        !1 === this.options.infinite ? m = this.slideCount : (a = -1 * this.options.slidesToScroll, c = -1 * this.options.slidesToScroll,
                m = 2 * this.slideCount);
        for (; a < m;) d.push(a), a = c + this.options.slidesToScroll, c += this.options.slidesToScroll <= this.options.slidesToShow ? this.options.slidesToScroll : this.options.slidesToShow;
        return d
    };
    d.prototype.getSlick = function () {
        return this
    };
    d.prototype.getSlideCount = function () {
        var d = this,
            c, l, m;
        m = !0 === d.options.centerMode ? d.slideWidth * Math.floor(d.options.slidesToShow / 2) : 0;
        return !0 === d.options.swipeToSlide ? (d.$slideTrack.find(".slick-slide").each(function (c, n) {
                if (n.offsetLeft - m + a(n).outerWidth() / 2 >
                    -1 * d.swipeLeft) return l = n, !1
            }), c = Math.abs(a(l).attr("data-slick-index") - d.currentSlide) || 1) : d.options.slidesToScroll
    };
    d.prototype.goTo = d.prototype.slickGoTo = function (a, c) {
        this.changeSlide({
            data: {
                message: "index",
                index: parseInt(a)
            }
        }, c)
    };
    d.prototype.init = function (d) {
        a(this.$slider).hasClass("slick-initialized") || (a(this.$slider).addClass("slick-initialized"), this.buildRows(), this.buildOut(), this.setProps(), this.startLoad(), this.loadSlider(), this.initializeEvents(), this.updateArrows(), this.updateDots(),
            this.checkResponsive(!0), this.focusHandler());
        d && this.$slider.trigger("init", [this]);
        !0 === this.options.accessibility && this.initADA();
        this.options.autoplay && (this.paused = !1, this.autoPlay())
    };
    d.prototype.initADA = function () {
        var d = this;
        d.$slides.add(d.$slideTrack.find(".slick-cloned")).attr({
            "aria-hidden": "true",
            tabindex: "-1"
        }).find("a, input, button, select").attr({
            tabindex: "-1"
        });
        d.$slideTrack.attr("role", "listbox");
        d.$slides.not(d.$slideTrack.find(".slick-cloned")).each(function (c) {
            a(this).attr({
                role: "option",
                "aria-describedby": "slick-slide" + d.instanceUid + c + ""
            })
        });
        null !== d.$dots && d.$dots.attr("role", "tablist").find("li").each(function (c) {
            a(this).attr({
                role: "presentation",
                "aria-selected": "false",
                "aria-controls": "navigation" + d.instanceUid + c + "",
                id: "slick-slide" + d.instanceUid + c + ""
            })
        }).first().attr("aria-selected", "true").end().find("button").attr("role", "button").end().closest("div").attr("role", "toolbar");
        d.activateADA()
    };
    d.prototype.initArrowEvents = function () {
        !0 === this.options.arrows && this.slideCount > this.options.slidesToShow &&
        (this.$prevArrow.off("click.slick").on("click.slick", {
            message: "previous"
        }, this.changeSlide), this.$nextArrow.off("click.slick").on("click.slick", {
            message: "next"
        }, this.changeSlide))
    };
    d.prototype.initDotEvents = function () {
        if (!0 === this.options.dots && this.slideCount > this.options.slidesToShow) a("li", this.$dots).on("click.slick", {
            message: "index"
        }, this.changeSlide);
        if (!0 === this.options.dots && !0 === this.options.pauseOnDotsHover) a("li", this.$dots).on("mouseenter.slick", a.proxy(this.interrupt, this, !0)).on("mouseleave.slick",
            a.proxy(this.interrupt, this, !1))
    };
    d.prototype.initSlideEvents = function () {
        this.options.pauseOnHover && (this.$list.on("mouseenter.slick", a.proxy(this.interrupt, this, !0)), this.$list.on("mouseleave.slick", a.proxy(this.interrupt, this, !1)))
    };
    d.prototype.initializeEvents = function () {
        this.initArrowEvents();
        this.initDotEvents();
        this.initSlideEvents();
        this.$list.on("touchstart.slick mousedown.slick", {
            action: "start"
        }, this.swipeHandler);
        this.$list.on("touchmove.slick mousemove.slick", {
            action: "move"
        }, this.swipeHandler);
        this.$list.on("touchend.slick mouseup.slick", {
            action: "end"
        }, this.swipeHandler);
        this.$list.on("touchcancel.slick mouseleave.slick", {
            action: "end"
        }, this.swipeHandler);
        this.$list.on("click.slick", this.clickHandler);
        a(document).on(this.visibilityChange, a.proxy(this.visibility, this));
        if (!0 === this.options.accessibility) this.$list.on("keydown.slick", this.keyHandler);
        if (!0 === this.options.focusOnSelect) a(this.$slideTrack).children().on("click.slick", this.selectHandler);
        a(window).on("orientationchange.slick.slick-" +
            this.instanceUid, a.proxy(this.orientationChange, this));
        a(window).on("resize.slick.slick-" + this.instanceUid, a.proxy(this.resize, this));
        a("[draggable!=true]", this.$slideTrack).on("dragstart", this.preventDefault);
        a(window).on("load.slick.slick-" + this.instanceUid, this.setPosition);
        a(document).on("ready.slick.slick-" + this.instanceUid, this.setPosition)
    };
    d.prototype.initUI = function () {
        !0 === this.options.arrows && this.slideCount > this.options.slidesToShow && (this.$prevArrow.show(), this.$nextArrow.show());
        !0 ===
        this.options.dots && this.slideCount > this.options.slidesToShow && this.$dots.show()
    };
    d.prototype.keyHandler = function (a) {
        a.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === a.keyCode && !0 === this.options.accessibility ? this.changeSlide({
                data: {
                    message: !0 === this.options.rtl ? "next" : "previous"
                }
            }) : 39 === a.keyCode && !0 === this.options.accessibility && this.changeSlide({
                data: {
                    message: !0 === this.options.rtl ? "previous" : "next"
                }
            }))
    };
    d.prototype.lazyLoad = function () {
        function d(g) {
            a("img[data-lazy]", g).each(function () {
                var d =
                        a(this),
                    g = a(this).attr("data-lazy"),
                    h = document.createElement("img");
                h.onload = function () {
                    d.animate({
                        opacity: 0
                    }, 100, function () {
                        d.attr("src", g).animate({
                            opacity: 1
                        }, 200, function () {
                            d.removeAttr("data-lazy").removeClass("slick-loading")
                        });
                        c.$slider.trigger("lazyLoaded", [c, d, g])
                    })
                };
                h.onerror = function () {
                    d.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error");
                    c.$slider.trigger("lazyLoadError", [c, d, g])
                };
                h.src = g
            })
        }

        var c = this,
            l, m;
        !0 === c.options.centerMode ? !0 === c.options.infinite ?
                (l = c.currentSlide + (c.options.slidesToShow / 2 + 1), m = l + c.options.slidesToShow + 2) : (l = Math.max(0, c.currentSlide - (c.options.slidesToShow / 2 + 1)), m = 2 + (c.options.slidesToShow / 2 + 1) + c.currentSlide) : (l = c.options.infinite ? c.options.slidesToShow + c.currentSlide : c.currentSlide, m = Math.ceil(l + c.options.slidesToShow), !0 === c.options.fade && (0 < l && l--, m <= c.slideCount && m++));
        l = c.$slider.find(".slick-slide").slice(l, m);
        d(l);
        c.slideCount <= c.options.slidesToShow ? (l = c.$slider.find(".slick-slide"), d(l)) : c.currentSlide >= c.slideCount -
            c.options.slidesToShow ? (l = c.$slider.find(".slick-cloned").slice(0, c.options.slidesToShow), d(l)) : 0 === c.currentSlide && (l = c.$slider.find(".slick-cloned").slice(-1 * c.options.slidesToShow), d(l))
    };
    d.prototype.loadSlider = function () {
        this.setPosition();
        this.$slideTrack.css({
            opacity: 1
        });
        this.$slider.removeClass("slick-loading");
        this.initUI();
        "progressive" === this.options.lazyLoad && this.progressiveLazyLoad()
    };
    d.prototype.next = d.prototype.slickNext = function () {
        this.changeSlide({
            data: {
                message: "next"
            }
        })
    };
    d.prototype.orientationChange =
        function () {
            this.checkResponsive();
            this.setPosition()
        };
    d.prototype.pause = d.prototype.slickPause = function () {
        this.autoPlayClear();
        this.paused = !0
    };
    d.prototype.play = d.prototype.slickPlay = function () {
        this.autoPlay();
        this.options.autoplay = !0;
        this.interrupted = this.focussed = this.paused = !1
    };
    d.prototype.postSlide = function (a) {
        this.unslicked || (this.$slider.trigger("afterChange", [this, a]), this.animating = !1, this.setPosition(), this.swipeLeft = null, this.options.autoplay && this.autoPlay(), !0 === this.options.accessibility &&
        this.initADA())
    };
    d.prototype.prev = d.prototype.slickPrev = function () {
        this.changeSlide({
            data: {
                message: "previous"
            }
        })
    };
    d.prototype.preventDefault = function (a) {
        a.preventDefault()
    };
    d.prototype.progressiveLazyLoad = function (d) {
        d = d || 1;
        var c = this,
            l = a("img[data-lazy]", c.$slider),
            m, g;
        l.length ? (m = l.first(), g = m.attr("data-lazy"), l = document.createElement("img"), l.onload = function () {
                m.attr("src", g).removeAttr("data-lazy").removeClass("slick-loading");
                !0 === c.options.adaptiveHeight && c.setPosition();
                c.$slider.trigger("lazyLoaded", [c, m, g]);
                c.progressiveLazyLoad()
            }, l.onerror = function () {
                3 > d ? setTimeout(function () {
                        c.progressiveLazyLoad(d + 1)
                    }, 500) : (m.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), c.$slider.trigger("lazyLoadError", [c, m, g]), c.progressiveLazyLoad())
            }, l.src = g) : c.$slider.trigger("allImagesLoaded", [c])
    };
    d.prototype.refresh = function (d) {
        var c;
        c = this.slideCount - this.options.slidesToShow;
        !this.options.infinite && this.currentSlide > c && (this.currentSlide = c);
        this.slideCount <= this.options.slidesToShow &&
        (this.currentSlide = 0);
        c = this.currentSlide;
        this.destroy(!0);
        a.extend(this, this.initials, {
            currentSlide: c
        });
        this.init();
        d || this.changeSlide({
            data: {
                message: "index",
                index: c
            }
        }, !1)
    };
    d.prototype.registerBreakpoints = function () {
        var d = this,
            c, l, m, g = d.options.responsive || null;
        if ("array" === a.type(g) && g.length) {
            d.respondTo = d.options.respondTo || "window";
            for (c in g)
                if (m = d.breakpoints.length - 1, l = g[c].breakpoint, g.hasOwnProperty(c)) {
                    for (; 0 <= m;) d.breakpoints[m] && d.breakpoints[m] === l && d.breakpoints.splice(m, 1), m--;
                    d.breakpoints.push(l);
                    d.breakpointSettings[l] = g[c].settings
                }
            d.breakpoints.sort(function (a, c) {
                return d.options.mobileFirst ? a - c : c - a
            })
        }
    };
    d.prototype.reinit = function () {
        this.$slides = this.$slideTrack.children(this.options.slide).addClass("slick-slide");
        this.slideCount = this.$slides.length;
        this.currentSlide >= this.slideCount && 0 !== this.currentSlide && (this.currentSlide -= this.options.slidesToScroll);
        this.slideCount <= this.options.slidesToShow && (this.currentSlide = 0);
        this.registerBreakpoints();
        this.setProps();
        this.setupInfinite();
        this.buildArrows();
        this.updateArrows();
        this.initArrowEvents();
        this.buildDots();
        this.updateDots();
        this.initDotEvents();
        this.cleanUpSlideEvents();
        this.initSlideEvents();
        this.checkResponsive(!1, !0);
        if (!0 === this.options.focusOnSelect) a(this.$slideTrack).children().on("click.slick", this.selectHandler);
        this.setSlideClasses("number" === typeof this.currentSlide ? this.currentSlide : 0);
        this.setPosition();
        this.focusHandler();
        this.paused = !this.options.autoplay;
        this.autoPlay();
        this.$slider.trigger("reInit", [this])
    };
    d.prototype.resize =
        function () {
            var d = this;
            a(window).width() !== d.windowWidth && (clearTimeout(d.windowDelay), d.windowDelay = window.setTimeout(function () {
                d.windowWidth = a(window).width();
                d.checkResponsive();
                d.unslicked || d.setPosition()
            }, 50))
        };
    d.prototype.removeSlide = d.prototype.slickRemove = function (a, c, d) {
        a = "boolean" === typeof a ? !0 === a ? 0 : this.slideCount - 1 : !0 === c ? --a : a;
        if (1 > this.slideCount || 0 > a || a > this.slideCount - 1) return !1;
        this.unload();
        !0 === d ? this.$slideTrack.children().remove() : this.$slideTrack.children(this.options.slide).eq(a).remove();
        this.$slides = this.$slideTrack.children(this.options.slide);
        this.$slideTrack.children(this.options.slide).detach();
        this.$slideTrack.append(this.$slides);
        this.$slidesCache = this.$slides;
        this.reinit()
    };
    d.prototype.setCSS = function (a) {
        var c = {},
            d, m;
        !0 === this.options.rtl && (a = -a);
        d = "left" == this.positionProp ? Math.ceil(a) + "px" : "0px";
        m = "top" == this.positionProp ? Math.ceil(a) + "px" : "0px";
        c[this.positionProp] = a;
        !1 !== this.transformsEnabled && (c = {}, c[this.animType] = !1 === this.cssTransitions ? "translate(" + d + ", " + m + ")" :
            "translate3d(" + d + ", " + m + ", 0px)");
        this.$slideTrack.css(c)
    };
    d.prototype.setDimensions = function () {
        !1 === this.options.vertical ? !0 === this.options.centerMode && this.$list.css({
                padding: "0px " + this.options.centerPadding
            }) : (this.$list.height(this.$slides.first().outerHeight(!0) * this.options.slidesToShow), !0 === this.options.centerMode && this.$list.css({
                padding: this.options.centerPadding + " 0px"
            }));
        this.listWidth = this.$list.width();
        this.listHeight = this.$list.height();
        !1 === this.options.vertical && !1 === this.options.variableWidth ?
            (this.slideWidth = Math.ceil(this.listWidth / this.options.slidesToShow), this.$slideTrack.width(Math.ceil(this.slideWidth * this.$slideTrack.children(".slick-slide").length))) : !0 === this.options.variableWidth ? this.$slideTrack.width(5E3 * this.slideCount) : (this.slideWidth = Math.ceil(this.listWidth), this.$slideTrack.height(Math.ceil(this.$slides.first().outerHeight(!0) * this.$slideTrack.children(".slick-slide").length)));
        var a = this.$slides.first().outerWidth(!0) - this.$slides.first().width();
        !1 === this.options.variableWidth &&
        this.$slideTrack.children(".slick-slide").width(this.slideWidth - a)
    };
    d.prototype.setFade = function () {
        var d = this,
            c;
        d.$slides.each(function (l, m) {
            c = d.slideWidth * l * -1;
            !0 === d.options.rtl ? a(m).css({
                    position: "relative",
                    right: c,
                    top: 0,
                    zIndex: d.options.zIndex - 2,
                    opacity: 0
                }) : a(m).css({
                    position: "relative",
                    left: c,
                    top: 0,
                    zIndex: d.options.zIndex - 2,
                    opacity: 0
                })
        });
        d.$slides.eq(d.currentSlide).css({
            zIndex: d.options.zIndex - 1,
            opacity: 1
        })
    };
    d.prototype.setHeight = function () {
        if (1 === this.options.slidesToShow && !0 === this.options.adaptiveHeight &&
            !1 === this.options.vertical) {
            var a = this.$slides.eq(this.currentSlide).outerHeight(!0);
            this.$list.css("height", a)
        }
    };
    d.prototype.setOption = d.prototype.slickSetOption = function (d, c, l) {
        var m = this,
            g, n, q, v = !1,
            u;
        "object" === a.type(d) ? (n = d, v = c, u = "multiple") : "string" === a.type(d) && (n = d, q = c, v = l, "responsive" === d && "array" === a.type(c) ? u = "responsive" : "undefined" !== typeof c && (u = "single"));
        if ("single" === u) m.options[n] = q;
        else if ("multiple" === u) a.each(n, function (a, c) {
            m.options[a] = c
        });
        else if ("responsive" === u)
            for (g in q)
                if ("array" !==
                    a.type(m.options.responsive)) m.options.responsive = [q[g]];
                else {
                    for (d = m.options.responsive.length - 1; 0 <= d;) m.options.responsive[d].breakpoint === q[g].breakpoint && m.options.responsive.splice(d, 1), d--;
                    m.options.responsive.push(q[g])
                }
        v && (m.unload(), m.reinit())
    };
    d.prototype.setPosition = function () {
        this.setDimensions();
        this.setHeight();
        !1 === this.options.fade ? this.setCSS(this.getLeft(this.currentSlide)) : this.setFade();
        this.$slider.trigger("setPosition", [this])
    };
    d.prototype.setProps = function () {
        var a = document.body.style;
        this.positionProp = !0 === this.options.vertical ? "top" : "left";
        "top" === this.positionProp ? this.$slider.addClass("slick-vertical") : this.$slider.removeClass("slick-vertical");
        void 0 === a.WebkitTransition && void 0 === a.MozTransition && void 0 === a.msTransition || !0 !== this.options.useCSS || (this.cssTransitions = !0);
        this.options.fade && ("number" === typeof this.options.zIndex ? 3 > this.options.zIndex && (this.options.zIndex = 3) : this.options.zIndex = this.defaults.zIndex);
        void 0 !== a.OTransform && (this.animType = "OTransform", this.transformType =
            "-o-transform", this.transitionType = "OTransition", void 0 === a.perspectiveProperty && void 0 === a.webkitPerspective && (this.animType = !1));
        void 0 !== a.MozTransform && (this.animType = "MozTransform", this.transformType = "-moz-transform", this.transitionType = "MozTransition", void 0 === a.perspectiveProperty && void 0 === a.MozPerspective && (this.animType = !1));
        void 0 !== a.webkitTransform && (this.animType = "webkitTransform", this.transformType = "-webkit-transform", this.transitionType = "webkitTransition", void 0 === a.perspectiveProperty &&
        void 0 === a.webkitPerspective && (this.animType = !1));
        void 0 !== a.msTransform && (this.animType = "msTransform", this.transformType = "-ms-transform", this.transitionType = "msTransition", void 0 === a.msTransform && (this.animType = !1));
        void 0 !== a.transform && !1 !== this.animType && (this.transformType = this.animType = "transform", this.transitionType = "transition");
        this.transformsEnabled = this.options.useTransform && null !== this.animType && !1 !== this.animType
    };
    d.prototype.setSlideClasses = function (a) {
        var c, d, m;
        d = this.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden",
            "true");
        this.$slides.eq(a).addClass("slick-current");
        !0 === this.options.centerMode ? (c = Math.floor(this.options.slidesToShow / 2), !0 === this.options.infinite && (a >= c && a <= this.slideCount - 1 - c ? this.$slides.slice(a - c, a + c + 1).addClass("slick-active").attr("aria-hidden", "false") : (m = this.options.slidesToShow + a, d.slice(m - c + 1, m + c + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === a ? d.eq(d.length - 1 - this.options.slidesToShow).addClass("slick-center") : a === this.slideCount - 1 && d.eq(this.options.slidesToShow).addClass("slick-center")),
                this.$slides.eq(a).addClass("slick-center")) : 0 <= a && a <= this.slideCount - this.options.slidesToShow ? this.$slides.slice(a, a + this.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : d.length <= this.options.slidesToShow ? d.addClass("slick-active").attr("aria-hidden", "false") : (c = this.slideCount % this.options.slidesToShow, m = !0 === this.options.infinite ? this.options.slidesToShow + a : a, this.options.slidesToShow == this.options.slidesToScroll && this.slideCount - a < this.options.slidesToShow ? d.slice(m -
                            (this.options.slidesToShow - c), m + c).addClass("slick-active").attr("aria-hidden", "false") : d.slice(m, m + this.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false"));
        "ondemand" === this.options.lazyLoad && this.lazyLoad()
    };
    d.prototype.setupInfinite = function () {
        var d, c, l;
        !0 === this.options.fade && (this.options.centerMode = !1);
        if (!0 === this.options.infinite && !1 === this.options.fade && (c = null, this.slideCount > this.options.slidesToShow)) {
            l = !0 === this.options.centerMode ? this.options.slidesToShow + 1 : this.options.slidesToShow;
            for (d = this.slideCount; d > this.slideCount - l; --d) c = d - 1, a(this.$slides[c]).clone(!0).attr("id", "").attr("data-slick-index", c - this.slideCount).prependTo(this.$slideTrack).addClass("slick-cloned");
            for (d = 0; d < l; d += 1) c = d, a(this.$slides[c]).clone(!0).attr("id", "").attr("data-slick-index", c + this.slideCount).appendTo(this.$slideTrack).addClass("slick-cloned");
            this.$slideTrack.find(".slick-cloned").find("[id]").each(function () {
                a(this).attr("id", "")
            })
        }
    };
    d.prototype.interrupt = function (a) {
        a || this.autoPlay();
        this.interrupted =
            a
    };
    d.prototype.selectHandler = function (d) {
        d = a(d.target).is(".slick-slide") ? a(d.target) : a(d.target).parents(".slick-slide");
        (d = parseInt(d.attr("data-slick-index"))) || (d = 0);
        this.slideCount <= this.options.slidesToShow ? (this.setSlideClasses(d), this.asNavFor(d)) : this.slideHandler(d)
    };
    d.prototype.slideHandler = function (a, c, d) {
        var m, g, n = null,
            q = this;
        !0 === q.animating && !0 === q.options.waitForAnimate || !0 === q.options.fade && q.currentSlide === a || q.slideCount <= q.options.slidesToShow || (!1 === (c || !1) && q.asNavFor(a), m = a,
            n = q.getLeft(m), c = q.getLeft(q.currentSlide), q.currentLeft = null === q.swipeLeft ? c : q.swipeLeft, !1 === q.options.infinite && !1 === q.options.centerMode && (0 > a || a > q.getDotCount() * q.options.slidesToScroll) ? !1 === q.options.fade && (m = q.currentSlide, !0 !== d ? q.animateSlide(c, function () {
                    q.postSlide(m)
                }) : q.postSlide(m)) : !1 === q.options.infinite && !0 === q.options.centerMode && (0 > a || a > q.slideCount - q.options.slidesToScroll) ? !1 === q.options.fade && (m = q.currentSlide, !0 !== d ? q.animateSlide(c, function () {
                        q.postSlide(m)
                    }) : q.postSlide(m)) :
                (q.options.autoplay && clearInterval(q.autoPlayTimer), g = 0 > m ? 0 !== q.slideCount % q.options.slidesToScroll ? q.slideCount - q.slideCount % q.options.slidesToScroll : q.slideCount + m : m >= q.slideCount ? 0 !== q.slideCount % q.options.slidesToScroll ? 0 : m - q.slideCount : m, q.animating = !0, q.$slider.trigger("beforeChange", [q, q.currentSlide, g]), a = q.currentSlide, q.currentSlide = g, q.setSlideClasses(q.currentSlide), q.options.asNavFor && (c = q.getNavTarget(), c = c.slick("getSlick"), c.slideCount <= c.options.slidesToShow && c.setSlideClasses(q.currentSlide)),
                    q.updateDots(), q.updateArrows(), !0 === q.options.fade ? (!0 !== d ? (q.fadeSlideOut(a), q.fadeSlide(g, function () {
                            q.postSlide(g)
                        })) : q.postSlide(g), q.animateHeight()) : !0 !== d ? q.animateSlide(n, function () {
                            q.postSlide(g)
                        }) : q.postSlide(g)))
    };
    d.prototype.startLoad = function () {
        !0 === this.options.arrows && this.slideCount > this.options.slidesToShow && (this.$prevArrow.hide(), this.$nextArrow.hide());
        !0 === this.options.dots && this.slideCount > this.options.slidesToShow && this.$dots.hide();
        this.$slider.addClass("slick-loading")
    };
    d.prototype.swipeDirection = function () {
        var a;
        a = Math.round(180 * Math.atan2(this.touchObject.startY - this.touchObject.curY, this.touchObject.startX - this.touchObject.curX) / Math.PI);
        0 > a && (a = 360 - Math.abs(a));
        return 45 >= a && 0 <= a || 360 >= a && 315 <= a ? !1 === this.options.rtl ? "left" : "right" : 135 <= a && 225 >= a ? !1 === this.options.rtl ? "right" : "left" : !0 === this.options.verticalSwiping ? 35 <= a && 135 >= a ? "down" : "up" : "vertical"
    };
    d.prototype.swipeEnd = function (a) {
        var c;
        this.interrupted = this.dragging = !1;
        this.shouldClick = 10 < this.touchObject.swipeLength ?
            !1 : !0;
        if (void 0 === this.touchObject.curX) return !1;
        !0 === this.touchObject.edgeHit && this.$slider.trigger("edge", [this, this.swipeDirection()]);
        if (this.touchObject.swipeLength >= this.touchObject.minSwipe) {
            a = this.swipeDirection();
            switch (a) {
                case "left":
                case "down":
                    c = this.options.swipeToSlide ? this.checkNavigable(this.currentSlide + this.getSlideCount()) : this.currentSlide + this.getSlideCount();
                    this.currentDirection = 0;
                    break;
                case "right":
                case "up":
                    c = this.options.swipeToSlide ? this.checkNavigable(this.currentSlide -
                            this.getSlideCount()) : this.currentSlide - this.getSlideCount(), this.currentDirection = 1
            }
            "vertical" != a && (this.slideHandler(c), this.touchObject = {}, this.$slider.trigger("swipe", [this, a]))
        } else this.touchObject.startX !== this.touchObject.curX && (this.slideHandler(this.currentSlide), this.touchObject = {})
    };
    d.prototype.swipeHandler = function (a) {
        if (!(!1 === this.options.swipe || "ontouchend" in document && !1 === this.options.swipe || !1 === this.options.draggable && -1 !== a.type.indexOf("mouse"))) switch (this.touchObject.fingerCount =
            a.originalEvent && void 0 !== a.originalEvent.touches ? a.originalEvent.touches.length : 1, this.touchObject.minSwipe = this.listWidth / this.options.touchThreshold, !0 === this.options.verticalSwiping && (this.touchObject.minSwipe = this.listHeight / this.options.touchThreshold), a.data.action) {
            case "start":
                this.swipeStart(a);
                break;
            case "move":
                this.swipeMove(a);
                break;
            case "end":
                this.swipeEnd(a)
        }
    };
    d.prototype.swipeMove = function (a) {
        var c, d, m;
        d = void 0 !== a.originalEvent ? a.originalEvent.touches : null;
        if (!this.dragging || d && 1 !==
            d.length) return !1;
        c = this.getLeft(this.currentSlide);
        this.touchObject.curX = void 0 !== d ? d[0].pageX : a.clientX;
        this.touchObject.curY = void 0 !== d ? d[0].pageY : a.clientY;
        this.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(this.touchObject.curX - this.touchObject.startX, 2)));
        !0 === this.options.verticalSwiping && (this.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(this.touchObject.curY - this.touchObject.startY, 2))));
        d = this.swipeDirection();
        if ("vertical" !== d) {
            void 0 !== a.originalEvent && 4 < this.touchObject.swipeLength &&
            a.preventDefault();
            m = (!1 === this.options.rtl ? 1 : -1) * (this.touchObject.curX > this.touchObject.startX ? 1 : -1);
            !0 === this.options.verticalSwiping && (m = this.touchObject.curY > this.touchObject.startY ? 1 : -1);
            a = this.touchObject.swipeLength;
            this.touchObject.edgeHit = !1;
            !1 === this.options.infinite && (0 === this.currentSlide && "right" === d || this.currentSlide >= this.getDotCount() && "left" === d) && (a = this.touchObject.swipeLength * this.options.edgeFriction, this.touchObject.edgeHit = !0);
            this.swipeLeft = !1 === this.options.vertical ? c + a *
                m : c + a * (this.$list.height() / this.listWidth) * m;
            !0 === this.options.verticalSwiping && (this.swipeLeft = c + a * m);
            if (!0 === this.options.fade || !1 === this.options.touchMove) return !1;
            if (!0 === this.animating) return this.swipeLeft = null, !1;
            this.setCSS(this.swipeLeft)
        }
    };
    d.prototype.swipeStart = function (a) {
        var c;
        this.interrupted = !0;
        if (1 !== this.touchObject.fingerCount || this.slideCount <= this.options.slidesToShow) return this.touchObject = {}, !1;
        void 0 !== a.originalEvent && void 0 !== a.originalEvent.touches && (c = a.originalEvent.touches[0]);
        this.touchObject.startX = this.touchObject.curX = void 0 !== c ? c.pageX : a.clientX;
        this.touchObject.startY = this.touchObject.curY = void 0 !== c ? c.pageY : a.clientY;
        this.dragging = !0
    };
    d.prototype.unfilterSlides = d.prototype.slickUnfilter = function () {
        null !== this.$slidesCache && (this.unload(), this.$slideTrack.children(this.options.slide).detach(), this.$slidesCache.appendTo(this.$slideTrack), this.reinit())
    };
    d.prototype.unload = function () {
        a(".slick-cloned", this.$slider).remove();
        this.$dots && this.$dots.remove();
        this.$prevArrow &&
        this.htmlExpr.test(this.options.prevArrow) && this.$prevArrow.remove();
        this.$nextArrow && this.htmlExpr.test(this.options.nextArrow) && this.$nextArrow.remove();
        this.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "")
    };
    d.prototype.unslick = function (a) {
        this.$slider.trigger("unslick", [this, a]);
        this.destroy()
    };
    d.prototype.updateArrows = function () {
        !0 === this.options.arrows && this.slideCount > this.options.slidesToShow && !this.options.infinite && (this.$prevArrow.removeClass("slick-disabled").attr("aria-disabled",
            "false"), this.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === this.currentSlide ? (this.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), this.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : this.currentSlide >= this.slideCount - this.options.slidesToShow && !1 === this.options.centerMode ? (this.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), this.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : this.currentSlide >=
                this.slideCount - 1 && !0 === this.options.centerMode && (this.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), this.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")))
    };
    d.prototype.updateDots = function () {
        null !== this.$dots && (this.$dots.find("li").removeClass("slick-active").attr("aria-hidden", "true"), this.$dots.find("li").eq(Math.floor(this.currentSlide / this.options.slidesToScroll)).addClass("slick-active").attr("aria-hidden", "false"))
    };
    d.prototype.visibility = function () {
        this.options.autoplay &&
        (this.interrupted = document[this.hidden] ? !0 : !1)
    };
    a.fn.slick = function () {
        var a = arguments[0],
            c = Array.prototype.slice.call(arguments, 1),
            l = this.length,
            m, g;
        for (m = 0; m < l; m++)
            if ("object" == typeof a || "undefined" == typeof a ? this[m].slick = new d(this[m], a) : g = this[m].slick[a].apply(this[m].slick, c), "undefined" != typeof g) return g;
        return this
    }
});
(function (a, d, h) {
    var c = a(d),
        l = d.document,
        m = a(l),
        g = function () {
            for (var a = 3, c = l.createElement("div"), d = c.getElementsByTagName("i"); c.innerHTML = "\x3c!--[if gt IE " + ++a + "]><i></i><![endif]--\x3e", d[0];);
            return 4 < a ? a : void 0
        }(),
        n = function () {
            var a = d.pageXOffset !== h ? d.pageXOffset : "CSS1Compat" == l.compatMode ? d.document.documentElement.scrollLeft : d.document.body.scrollLeft,
                c = d.pageYOffset !== h ? d.pageYOffset : "CSS1Compat" == l.compatMode ? d.document.documentElement.scrollTop : d.document.body.scrollTop;
            "undefined" == typeof n.x && (n.x = a, n.y = c);
            "undefined" == typeof n.distanceX ? (n.distanceX = a, n.distanceY = c) : (n.distanceX = a - n.x, n.distanceY = c - n.y);
            var g = n.x - a,
                m = n.y - c;
            n.direction = 0 > g ? "right" : 0 < g ? "left" : 0 >= m ? "down" : 0 < m ? "up" : "first";
            n.x = a;
            n.y = c
        };
    c.on("scroll", n);
    a.fn.style = function (c) {
        if (!c) return null;
        var g = a(this),
            h, n = g.clone().css("display", "none");
        n.find("input:radio").attr("name", "copy-" + Math.floor(100 * Math.random() + 1));
        g.after(n);
        var m = function (a, c) {
            var h;
            a.currentStyle ? h = a.currentStyle[c.replace(/-\w/g, function (b) {
                    return b.toUpperCase().replace("-",
                        "")
                })] : d.getComputedStyle && (h = l.defaultView.getComputedStyle(a, null).getPropertyValue(c));
            return h = /margin/g.test(c) ? parseInt(h) === g[0].offsetLeft ? h : "auto" : h
        };
        "string" == typeof c ? h = m(n[0], c) : (h = {}, a.each(c, function (a, c) {
                h[c] = m(n[0], c)
            }));
        n.remove();
        return h || null
    };
    a.fn.extend({
        hcSticky: function (l) {
            if (0 == this.length) return this;
            this.pluginOptions("hcSticky", {
                top: 0,
                bottom: 0,
                bottomEnd: 0,
                innerTop: 0,
                innerSticker: null,
                className: "sticky",
                wrapperClassName: "wrapper-sticky",
                stickTo: null,
                responsive: !0,
                followScroll: !0,
                offResolutions: null,
                onStart: a.noop,
                onStop: a.noop,
                on: !0,
                fn: null
            }, l || {}, {
                reinit: function () {
                    a(this).hcSticky()
                },
                stop: function () {
                    a(this).pluginOptions("hcSticky", {
                        on: !1
                    }).each(function () {
                        var c = a(this),
                            d = c.pluginOptions("hcSticky"),
                            g = c.parent("." + d.wrapperClassName),
                            g = c.offset().top - g.offset().top;
                        c.css({
                            position: "absolute",
                            top: g,
                            bottom: "auto",
                            left: "auto",
                            right: "auto"
                        }).removeClass(d.className)
                    })
                },
                off: function () {
                    a(this).pluginOptions("hcSticky", {
                        on: !1
                    }).each(function () {
                        var c = a(this),
                            d = c.pluginOptions("hcSticky"),
                            g = c.parent("." + d.wrapperClassName);
                        c.css({
                            position: "relative",
                            top: "auto",
                            bottom: "auto",
                            left: "auto",
                            right: "auto"
                        }).removeClass(d.className);
                        g.css("height", "auto")
                    })
                },
                on: function () {
                    a(this).each(function () {
                        a(this).pluginOptions("hcSticky", {
                            on: !0,
                            remember: {
                                offsetTop: c.scrollTop()
                            }
                        }).hcSticky()
                    })
                },
                destroy: function () {
                    var d = a(this),
                        g = d.pluginOptions("hcSticky"),
                        h = d.parent("." + g.wrapperClassName);
                    d.removeData("hcStickyInit").css({
                        position: h.css("position"),
                        top: h.css("top"),
                        bottom: h.css("bottom"),
                        left: h.css("left"),
                        right: h.css("right")
                    }).removeClass(g.className);
                    c.off("resize", g.fn.resize).off("scroll", g.fn.scroll);
                    d.unwrap()
                }
            });
            l && "undefined" != typeof l.on && (l.on ? this.hcSticky("on") : this.hcSticky("off"));
            return "string" == typeof l ? this : this.each(function () {
                    var l = a(this),
                        q = l.pluginOptions("hcSticky"),
                        x = function () {
                                var b = l.parent("." + q.wrapperClassName);
                                return 0 < b.length ? (b.css({
                                        height: l.outerHeight(!0),
                                        width: function () {
                                            var a = b.style("width");
                                            return 0 <= a.indexOf("%") || "auto" == a ? ("border-box" == l.css("box-sizing") ||
                                                "border-box" == l.css("-moz-box-sizing") ? l.css("width", b.width()) : l.css("width", b.width() - parseInt(l.css("padding-left") - parseInt(l.css("padding-right")))), a) : l.outerWidth(!0)
                                        }()
                                    }), b) : !1
                            }() || function () {
                                var b = l.style("width margin-left left right top bottom float display".split(" ")),
                                    c = l.css("display"),
                                    e = a("<div>", {
                                        "class": q.wrapperClassName
                                    }).css({
                                        display: c,
                                        height: l.outerHeight(!0),
                                        width: function () {
                                            return 0 <= b.width.indexOf("%") || "auto" == b.width && "inline-block" != c && "inline" != c ? (l.css("width", parseFloat(l.css("width"))),
                                                    b.width) : "auto" != b.width || "inline-block" != c && "inline" != c ? "auto" == b["margin-left"] ? l.outerWidth() : l.outerWidth(!0) : l.width()
                                        }(),
                                        margin: b["margin-left"] ? "auto" : null,
                                        position: function () {
                                            var b = l.css("position");
                                            return "static" == b ? "relative" : b
                                        }(),
                                        "float": b["float"] || null,
                                        left: b.left,
                                        right: b.right,
                                        top: b.top,
                                        bottom: b.bottom,
                                        "vertical-align": "top"
                                    });
                                l.wrap(e);
                                7 === g && 0 === a("head").find("style#hcsticky-iefix").length && a('<style id="hcsticky-iefix">.' + q.wrapperClassName + " {zoom: 1;}</style>").appendTo("head");
                                return l.parent()
                            }();
                    if (!l.data("hcStickyInit")) {
                        l.data("hcStickyInit", !0);
                        var w = q.stickTo && ("document" == q.stickTo || q.stickTo.nodeType && 9 == q.stickTo.nodeType || "object" == typeof q.stickTo && q.stickTo instanceof ("undefined" != typeof HTMLDocument ? HTMLDocument : Document)) ? !0 : !1,
                            t = q.stickTo ? w ? m : "string" == typeof q.stickTo ? a(q.stickTo) : q.stickTo : x.parent();
                        l.css({
                            top: "auto",
                            bottom: "auto",
                            left: "auto",
                            right: "auto"
                        });
                        c.load(function () {
                            l.outerHeight(!0) > t.height() && (x.css("height", l.outerHeight(!0)), l.hcSticky("reinit"))
                        });
                        var y = function (b) {
                                l.hasClass(q.className) || (b = b || {}, l.css({
                                    position: "fixed",
                                    top: b.top || 0,
                                    left: b.left || x.offset().left
                                }).addClass(q.className), q.onStart.apply(l[0]), x.addClass("sticky-active"))
                            },
                            A = function (b) {
                                b = b || {};
                                b.position = b.position || "absolute";
                                b.top = b.top || 0;
                                b.left = b.left || 0;
                                if ("fixed" == l.css("position") || parseInt(l.css("top")) != b.top) l.css({
                                    position: b.position,
                                    top: b.top,
                                    left: b.left
                                }).removeClass(q.className), q.onStop.apply(l[0]), x.removeClass("sticky-active")
                            },
                            b = !1,
                            e = !1,
                            f = function () {
                                r();
                                k();
                                if (q.on) {
                                    if (q.responsive) {
                                        e || (e = l.clone().attr("style", "").css({
                                            visibility: "hidden",
                                            height: 0,
                                            overflow: "hidden",
                                            paddingTop: 0,
                                            paddingBottom: 0,
                                            marginTop: 0,
                                            marginBottom: 0
                                        }), x.after(e));
                                        var a = x.style("width"),
                                            c = e.style("width");
                                        "auto" == c && "auto" != a && (c = parseInt(l.css("width")));
                                        c != a && x.width(c);
                                        b && clearTimeout(b);
                                        b = setTimeout(function () {
                                            b = !1;
                                            e.remove();
                                            e = !1
                                        }, 250)
                                    }
                                    "fixed" == l.css("position") ? l.css("left", x.offset().left) : l.css("left", 0);
                                    l.outerWidth(!0) != x.width() && (a = "border-box" == l.css("box-sizing") ||
                                    "border-box" == l.css("-moz-box-sizing") ? x.width() : x.width() - parseInt(l.css("padding-left")) - parseInt(l.css("padding-right")), a = a - parseInt(l.css("margin-left")) - parseInt(l.css("margin-right")), l.css("width", a))
                                }
                            };
                        l.pluginOptions("hcSticky", {
                            fn: {
                                scroll: function (b) {
                                    if (q.on && l.is(":visible"))
                                        if (l.outerHeight(!0) >= t.height()) A();
                                        else {
                                            b = q.innerSticker ? a(q.innerSticker).position().top : q.innerTop ? q.innerTop : 0;
                                            var e = x.offset().top,
                                                f = t.height() - q.bottomEnd + (w ? 0 : e),
                                                d = x.offset().top - q.top + b,
                                                g = l.outerHeight(!0) +
                                                    q.bottom,
                                                h = c.height(),
                                                k = c.scrollTop(),
                                                m = l.offset().top,
                                                r = m - k,
                                                C;
                                            "undefined" != typeof q.remember && q.remember ? (C = m - q.top - b, g - b > h && q.followScroll ? C < k && k + h <= C + l.height() && (q.remember = !1) : q.remember.offsetTop > C ? k <= C && (y({
                                                            top: q.top - b
                                                        }), q.remember = !1) : k >= C && (y({
                                                            top: q.top - b
                                                        }), q.remember = !1)) : k > d ? f + q.bottom - (q.followScroll && h < g ? 0 : q.top) <= k + g - b - (g - b > h - (d - b) && q.followScroll ? 0 < (C = g - h - b) ? C : 0 : 0) ? A({
                                                            top: f - g + q.bottom - e
                                                        }) : g - b > h && q.followScroll ? r + g <= h ? "down" == n.direction ? y({
                                                                        top: h - g
                                                                    }) : 0 > r && "fixed" == l.css("position") &&
                                                                    A({
                                                                        top: m - (d + q.top - b) - n.distanceY
                                                                    }) : "up" == n.direction && m >= k + q.top - b ? y({
                                                                        top: q.top - b
                                                                    }) : "down" == n.direction && m + g > h && "fixed" == l.css("position") && A({
                                                                        top: m - (d + q.top - b) - n.distanceY
                                                                    }) : y({
                                                                top: q.top - b
                                                            }) : A()
                                        }
                                },
                                resize: f
                            }
                        });
                        var k = function () {
                            if (q.offResolutions) {
                                a.isArray(q.offResolutions) || (q.offResolutions = [q.offResolutions]);
                                var b = !0;
                                a.each(q.offResolutions, function (a, e) {
                                    0 > e ? c.width() < -1 * e && (b = !1, l.hcSticky("off")) : c.width() > e && (b = !1, l.hcSticky("off"))
                                });
                                b && !q.on && l.hcSticky("on")
                            }
                        };
                        k();
                        c.on("resize", f);
                        var r =
                            function () {
                                var b = !1;
                                a._data(d, "events").scroll != h && a.each(a._data(d, "events").scroll, function (a, c) {
                                    c.handler == q.fn.scroll && (b = !0)
                                });
                                b || (q.fn.scroll(!0), c.on("scroll", q.fn.scroll))
                            };
                        r()
                    }
                })
        }
    })
})(jQuery, this);
(function (a, d) {
    a.fn.extend({
        pluginOptions: function (h, c, l, m) {
            this.data(h) || this.data(h, {});
            if (h && "undefined" == typeof c) return this.data(h).options;
            l = l || c || {};
            return "object" == typeof l || l === d ? this.each(function () {
                    var d = a(this);
                    d.data(h).options ? d.data(h, a.extend(d.data(h), {
                            options: a.extend(d.data(h).options, l || {})
                        })) : (d.data(h, {
                            options: a.extend(c, l || {})
                        }), m && (d.data(h).commands = m))
                }) : "string" == typeof l ? this.each(function () {
                        a(this).data(h).commands[l].call(this)
                    }) : this
        }
    })
})(jQuery);
$(document).ready(function () {
    $("#scroll-container").customScrollbar({
        skin: "endoca-skin",
        hScroll: !1,
        updateOnWindowResize: !0
    })
});
!function (a) {
    function d() {
    }

    function h(a) {
        function h(c) {
            c.prototype.option || (c.prototype.option = function (c) {
                a.isPlainObject(c) && (this.options = a.extend(!0, this.options, c))
            })
        }

        function g(d, g) {
            a.fn[d] = function (h) {
                if ("string" == typeof h) {
                    for (var m = c.call(arguments, 1), w = 0, t = this.length; t > w; w++) {
                        var y = a.data(this[w], d);
                        if (y)
                            if (a.isFunction(y[h]) && "_" !== h.charAt(0)) {
                                if (y = y[h].apply(y, m), void 0 !== y) return y
                            } else n("no such method '" + h + "' for " + d + " instance");
                        else n("cannot call methods on " + d + " prior to initialization; attempted to call '" +
                            h + "'")
                    }
                    return this
                }
                return this.each(function () {
                    var c = a.data(this, d);
                    c ? (c.option(h), c._init()) : (c = new g(this, h), a.data(this, d, c))
                })
            }
        }

        if (a) {
            var n = "undefined" == typeof console ? d : function (a) {
                    console.error(a)
                };
            return a.bridget = function (a, c) {
                h(c);
                g(a, c)
            }, a.bridget
        }
    }

    var c = Array.prototype.slice;
    "function" == typeof define && define.amd ? define("jquery-bridget/jquery.bridget", ["jquery"], h) : h("object" == typeof exports ? require("jquery") : a.jQuery)
}(window);
(function (a) {
    function d(c) {
        var d = a.event;
        return d.target = d.target || d.srcElement || c, d
    }

    var h = document.documentElement,
        c = function () {
        };
    h.addEventListener ? c = function (a, c, d) {
            a.addEventListener(c, d, !1)
        } : h.attachEvent && (c = function (a, c, h) {
            a[c + h] = h.handleEvent ? function () {
                    var c = d(a);
                    h.handleEvent.call(h, c)
                } : function () {
                    var c = d(a);
                    h.call(a, c)
                };
            a.attachEvent("on" + c, a[c + h])
        });
    var l = function () {
    };
    h.removeEventListener ? l = function (a, c, d) {
            a.removeEventListener(c, d, !1)
        } : h.detachEvent && (l = function (a, c, d) {
            a.detachEvent("on" +
                c, a[c + d]);
            try {
                delete a[c + d]
            } catch (h) {
                a[c + d] = void 0
            }
        });
    h = {
        bind: c,
        unbind: l
    };
    "function" == typeof define && define.amd ? define("eventie/eventie", h) : "object" == typeof exports ? module.exports = h : a.eventie = h
})(window);
(function () {
    function a() {
    }

    function d(a, c) {
        for (var d = a.length; d--;)
            if (a[d].listener === c) return d;
        return -1
    }

    function h(a) {
        return function () {
            return this[a].apply(this, arguments)
        }
    }

    var c = a.prototype,
        l = this,
        m = l.EventEmitter;
    c.getListeners = function (a) {
        var c, d, h = this._getEvents();
        if (a instanceof RegExp)
            for (d in c = {}, h) h.hasOwnProperty(d) && a.test(d) && (c[d] = h[d]);
        else c = h[a] || (h[a] = []);
        return c
    };
    c.flattenListeners = function (a) {
        var c, d = [];
        for (c = 0; c < a.length; c += 1) d.push(a[c].listener);
        return d
    };
    c.getListenersAsObject =
        function (a) {
            var c, d = this.getListeners(a);
            return d instanceof Array && (c = {}, c[a] = d), c || d
        };
    c.addListener = function (a, c) {
        var h, l = this.getListenersAsObject(a),
            m = "object" == typeof c;
        for (h in l) l.hasOwnProperty(h) && -1 === d(l[h], c) && l[h].push(m ? c : {
                listener: c,
                once: !1
            });
        return this
    };
    c.on = h("addListener");
    c.addOnceListener = function (a, c) {
        return this.addListener(a, {
            listener: c,
            once: !0
        })
    };
    c.once = h("addOnceListener");
    c.defineEvent = function (a) {
        return this.getListeners(a), this
    };
    c.defineEvents = function (a) {
        for (var c = 0; c <
        a.length; c += 1) this.defineEvent(a[c]);
        return this
    };
    c.removeListener = function (a, c) {
        var h, l, m = this.getListenersAsObject(a);
        for (l in m) m.hasOwnProperty(l) && (h = d(m[l], c), -1 !== h && m[l].splice(h, 1));
        return this
    };
    c.off = h("removeListener");
    c.addListeners = function (a, c) {
        return this.manipulateListeners(!1, a, c)
    };
    c.removeListeners = function (a, c) {
        return this.manipulateListeners(!0, a, c)
    };
    c.manipulateListeners = function (a, c, d) {
        var h, l, m = a ? this.removeListener : this.addListener;
        a = a ? this.removeListeners : this.addListeners;
        if ("object" != typeof c || c instanceof RegExp)
            for (h = d.length; h--;) m.call(this, c, d[h]);
        else
            for (h in c) c.hasOwnProperty(h) && (l = c[h]) && ("function" == typeof l ? m.call(this, h, l) : a.call(this, h, l));
        return this
    };
    c.removeEvent = function (a) {
        var c, d = typeof a,
            h = this._getEvents();
        if ("string" === d) delete h[a];
        else if (a instanceof RegExp)
            for (c in h) h.hasOwnProperty(c) && a.test(c) && delete h[c];
        else delete this._events;
        return this
    };
    c.removeAllListeners = h("removeEvent");
    c.emitEvent = function (a, c) {
        var d, h, l, m, w = this.getListenersAsObject(a);
        for (l in w)
            if (w.hasOwnProperty(l))
                for (h = w[l].length; h--;) d = w[l][h], !0 === d.once && this.removeListener(a, d.listener), m = d.listener.apply(this, c || []), m === this._getOnceReturnValue() && this.removeListener(a, d.listener);
        return this
    };
    c.trigger = h("emitEvent");
    c.emit = function (a) {
        var c = Array.prototype.slice.call(arguments, 1);
        return this.emitEvent(a, c)
    };
    c.setOnceReturnValue = function (a) {
        return this._onceReturnValue = a, this
    };
    c._getOnceReturnValue = function () {
        return this.hasOwnProperty("_onceReturnValue") ? this._onceReturnValue :
            !0
    };
    c._getEvents = function () {
        return this._events || (this._events = {})
    };
    a.noConflict = function () {
        return l.EventEmitter = m, a
    };
    "function" == typeof define && define.amd ? define("eventEmitter/EventEmitter", [], function () {
            return a
        }) : "object" == typeof module && module.exports ? module.exports = a : l.EventEmitter = a
}).call(this);
(function (a) {
    function d(a) {
        if (a) {
            if ("string" == typeof c[a]) return a;
            a = a.charAt(0).toUpperCase() + a.slice(1);
            for (var d, g = 0, n = h.length; n > g; g++)
                if (d = h[g] + a, "string" == typeof c[d]) return d
        }
    }

    var h = ["Webkit", "Moz", "ms", "Ms", "O"],
        c = document.documentElement.style;
    "function" == typeof define && define.amd ? define("get-style-property/get-style-property", [], function () {
            return d
        }) : "object" == typeof exports ? module.exports = d : a.getStyleProperty = d
})(window);
(function (a) {
    function d(a) {
        var c = parseFloat(a);
        return -1 === a.indexOf("%") && !isNaN(c) && c
    }

    function h() {
    }

    function c(c) {
        function h() {
            if (!x) {
                x = !0;
                var n = a.getComputedStyle;
                if (q = function () {
                        var b = n ? function (b) {
                                return n(b, null)
                            } : function (b) {
                                return b.currentStyle
                            };
                        return function (a) {
                            a = b(a);
                            return a || l("Style returned " + a + ". Are you running this code in a hidden iframe on Firefox? See http://bit.ly/getsizebug1"), a
                        }
                    }(), v = c("boxSizing")) {
                    var m = document.createElement("div");
                    m.style.width = "200px";
                    m.style.padding =
                        "1px 2px 3px 4px";
                    m.style.borderStyle = "solid";
                    m.style.borderWidth = "1px 2px 3px 4px";
                    m.style[v] = "border-box";
                    var y = document.body || document.documentElement;
                    y.appendChild(m);
                    var A = q(m);
                    u = 200 === d(A.width);
                    y.removeChild(m)
                }
            }
        }

        var q, v, u, x = !1;
        return function (c) {
            if (h(), "string" == typeof c && (c = document.querySelector(c)), c && "object" == typeof c && c.nodeType) {
                var g = q(c);
                if ("none" === g.display) {
                    for (var l = {
                        width: 0,
                        height: 0,
                        innerWidth: 0,
                        innerHeight: 0,
                        outerWidth: 0,
                        outerHeight: 0
                    }, g = 0, x = m.length; x > g; g++) l[m[g]] = 0;
                    return l
                }
                l = {};
                l.width = c.offsetWidth;
                l.height = c.offsetHeight;
                for (var x = l.isBorderBox = !(!v || !g[v] || "border-box" !== g[v]), b = 0, e = m.length; e > b; b++) {
                    var f = m[b],
                        k = g[f];
                    var r = c,
                        z = k;
                    if (a.getComputedStyle || -1 === z.indexOf("%")) k = z;
                    else var k = r.style,
                        X = k.left,
                        U = r.runtimeStyle,
                        K = U && U.left,
                        k = (K && (U.left = r.currentStyle.left), k.left = z, z = k.pixelLeft, k.left = X, K && (U.left = K), z);
                    r = parseFloat(k);
                    l[f] = isNaN(r) ? 0 : r
                }
                c = l.paddingLeft + l.paddingRight;
                b = l.paddingTop + l.paddingBottom;
                e = l.marginLeft + l.marginRight;
                f = l.marginTop + l.marginBottom;
                r = l.borderLeftWidth + l.borderRightWidth;
                z = l.borderTopWidth + l.borderBottomWidth;
                x = x && u;
                k = d(g.width);
                !1 !== k && (l.width = k + (x ? 0 : c + r));
                g = d(g.height);
                return !1 !== g && (l.height = g + (x ? 0 : b + z)), l.innerWidth = l.width - (c + r), l.innerHeight = l.height - (b + z), l.outerWidth = l.width + e, l.outerHeight = l.height + f, l
            }
        }
    }

    var l = "undefined" == typeof console ? h : function (a) {
                console.error(a)
            },
        m = "paddingLeft paddingRight paddingTop paddingBottom marginLeft marginRight marginTop marginBottom borderLeftWidth borderRightWidth borderTopWidth borderBottomWidth".split(" ");
    "function" == typeof define && define.amd ? define("get-size/get-size", ["get-style-property/get-style-property"], c) : "object" == typeof exports ? module.exports = c(require("desandro-get-style-property")) : a.getSize = c(a.getStyleProperty)
})(window);
(function (a) {
    function d(a) {
        "function" == typeof a && (d.isReady ? a() : g.push(a))
    }

    function h(a) {
        a = "readystatechange" === a.type && "complete" !== m.readyState;
        d.isReady || a || c()
    }

    function c() {
        d.isReady = !0;
        for (var a = 0, c = g.length; c > a; a++)(0, g[a])()
    }

    function l(g) {
        return "complete" === m.readyState ? c() : (g.bind(m, "DOMContentLoaded", h), g.bind(m, "readystatechange", h), g.bind(a, "load", h)), d
    }

    var m = a.document,
        g = [];
    d.isReady = !1;
    "function" == typeof define && define.amd ? define("doc-ready/doc-ready", ["eventie/eventie"], l) : "object" == typeof exports ? module.exports = l(require("eventie")) : a.docReady = l(a.eventie)
})(window);
(function (a) {
    function d(a, c) {
        return a[m](c)
    }

    function h(a, c) {
        a.parentNode || document.createDocumentFragment().appendChild(a);
        for (var d = a.parentNode.querySelectorAll(c), g = 0, h = d.length; h > g; g++)
            if (d[g] === a) return !0;
        return !1
    }

    function c(a, c) {
        a.parentNode || document.createDocumentFragment().appendChild(a);
        return d(a, c)
    }

    var l, m = function () {
        if (a.matches) return "matches";
        if (a.matchesSelector) return "matchesSelector";
        for (var c = ["webkit", "moz", "ms", "o"], d = 0, g = c.length; g > d; d++) {
            var h = c[d] + "MatchesSelector";
            if (a[h]) return h
        }
    }();
    if (m) {
        var g = document.createElement("div");
        l = d(g, "div") ? d : c
    } else l = h;
    "function" == typeof define && define.amd ? define("matches-selector/matches-selector", [], function () {
            return l
        }) : "object" == typeof exports ? module.exports = l : window.matchesSelector = l
})(Element.prototype);
(function (a, d) {
    "function" == typeof define && define.amd ? define("fizzy-ui-utils/utils", ["doc-ready/doc-ready", "matches-selector/matches-selector"], function (h, c) {
            return d(a, h, c)
        }) : "object" == typeof exports ? module.exports = d(a, require("doc-ready"), require("desandro-matches-selector")) : a.fizzyUIUtils = d(a, a.docReady, a.matchesSelector)
})(window, function (a, d, h) {
    var c = {
            extend: function (a, c) {
                for (var d in c) a[d] = c[d];
                return a
            },
            modulo: function (a, c) {
                return (a % c + c) % c
            }
        },
        l = Object.prototype.toString;
    c.isArray = function (a) {
        return "[object Array]" ==
            l.call(a)
    };
    c.makeArray = function (a) {
        var d = [];
        if (c.isArray(a)) d = a;
        else if (a && "number" == typeof a.length)
            for (var h = 0, l = a.length; l > h; h++) d.push(a[h]);
        else d.push(a);
        return d
    };
    c.indexOf = Array.prototype.indexOf ? function (a, c) {
            return a.indexOf(c)
        } : function (a, c) {
            for (var d = 0, h = a.length; h > d; d++)
                if (a[d] === c) return d;
            return -1
        };
    c.removeFrom = function (a, d) {
        var h = c.indexOf(a, d);
        -1 != h && a.splice(h, 1)
    };
    c.isElement = "function" == typeof HTMLElement || "object" == typeof HTMLElement ? function (a) {
            return a instanceof HTMLElement
        } :
        function (a) {
            return a && "object" == typeof a && 1 == a.nodeType && "string" == typeof a.nodeName
        };
    c.setText = function () {
        var a;
        return function (c, d) {
            a = a || (void 0 !== document.documentElement.textContent ? "textContent" : "innerText");
            c[a] = d
        }
    }();
    c.getParent = function (a, c) {
        for (; a != document.body;)
            if (a = a.parentNode, h(a, c)) return a
    };
    c.getQueryElement = function (a) {
        return "string" == typeof a ? document.querySelector(a) : a
    };
    c.handleEvent = function (a) {
        var c = "on" + a.type;
        this[c] && this[c](a)
    };
    c.filterFindElements = function (a, d) {
        a = c.makeArray(a);
        for (var l = [], m = 0, u = a.length; u > m; m++) {
            var x = a[m];
            if (c.isElement(x))
                if (d) {
                    h(x, d) && l.push(x);
                    for (var x = x.querySelectorAll(d), w = 0, t = x.length; t > w; w++) l.push(x[w])
                } else l.push(x)
        }
        return l
    };
    c.debounceMethod = function (a, c, d) {
        var h = a.prototype[c],
            l = c + "Timeout";
        a.prototype[c] = function () {
            var a = this[l];
            a && clearTimeout(a);
            var c = arguments,
                g = this;
            this[l] = setTimeout(function () {
                h.apply(g, c);
                delete g[l]
            }, d || 100)
        }
    };
    c.toDashed = function (a) {
        return a.replace(/(.)([A-Z])/g, function (a, c, d) {
            return c + "-" + d
        }).toLowerCase()
    };
    var m = a.console;
    return c.htmlInit = function (g, h) {
        d(function () {
            for (var d = c.toDashed(h), l = document.querySelectorAll(".js-" + d), d = "data-" + d + "-options", u = 0, x = l.length; x > u; u++) {
                var w, t = l[u],
                    y = t.getAttribute(d);
                try {
                    w = y && JSON.parse(y)
                } catch (b) {
                    m && m.error("Error parsing " + d + " on " + t.nodeName.toLowerCase() + (t.id ? "#" + t.id : "") + ": " + b);
                    continue
                }
                var y = new g(t, w),
                    A = a.jQuery;
                A && A.data(t, h, y)
            }
        })
    }, c
});
(function (a, d) {
    "function" == typeof define && define.amd ? define("outlayer/item", ["eventEmitter/EventEmitter", "get-size/get-size", "get-style-property/get-style-property", "fizzy-ui-utils/utils"], function (h, c, l, m) {
            return d(a, h, c, l, m)
        }) : "object" == typeof exports ? module.exports = d(a, require("wolfy87-eventemitter"), require("get-size"), require("desandro-get-style-property"), require("fizzy-ui-utils")) : (a.Outlayer = {}, a.Outlayer.Item = d(a, a.EventEmitter, a.getSize, a.getStyleProperty, a.fizzyUIUtils))
})(window, function (a,
                     d, h, c, l) {
    function m(b, a) {
        b && (this.element = b, this.layout = a, this.position = {
            x: 0,
            y: 0
        }, this._create())
    }

    var g = a.getComputedStyle,
        n = g ? function (b) {
                return g(b, null)
            } : function (b) {
                return b.currentStyle
            },
        q = c("transition");
    a = c("transform");
    a = q && a;
    var v = !!c("perspective"),
        u = {
            WebkitTransition: "webkitTransitionEnd",
            MozTransition: "transitionend",
            OTransition: "otransitionend",
            transition: "transitionend"
        }[q],
        x = ["transform", "transition", "transitionDuration", "transitionProperty"],
        w = function () {
            for (var b = {}, a = 0, f = x.length; f >
            a; a++) {
                var d = x[a],
                    g = c(d);
                g && g !== d && (b[d] = g)
            }
            return b
        }();
    l.extend(m.prototype, d.prototype);
    m.prototype._create = function () {
        this._transn = {
            ingProperties: {},
            clean: {},
            onEnd: {}
        };
        this.css({
            position: "absolute"
        })
    };
    m.prototype.handleEvent = function (b) {
        var a = "on" + b.type;
        this[a] && this[a](b)
    };
    m.prototype.getSize = function () {
        this.size = h(this.element)
    };
    m.prototype.css = function (b) {
        var a = this.element.style,
            c;
        for (c in b) a[w[c] || c] = b[c]
    };
    m.prototype.getPosition = function () {
        var b = n(this.element),
            a = this.layout.options,
            c =
                a.isOriginLeft,
            a = a.isOriginTop,
            d = b[c ? "left" : "right"],
            g = b[a ? "top" : "bottom"],
            b = this.layout.size,
            d = -1 != d.indexOf("%") ? parseFloat(d) / 100 * b.width : parseInt(d, 10),
            g = -1 != g.indexOf("%") ? parseFloat(g) / 100 * b.height : parseInt(g, 10),
            d = isNaN(d) ? 0 : d,
            g = isNaN(g) ? 0 : g,
            d = d - (c ? b.paddingLeft : b.paddingRight),
            g = g - (a ? b.paddingTop : b.paddingBottom);
        this.position.x = d;
        this.position.y = g
    };
    m.prototype.layoutPosition = function () {
        var b = this.layout.size,
            a = this.layout.options,
            c = {},
            d = a.isOriginLeft ? "right" : "left";
        c[a.isOriginLeft ? "left" :
            "right"] = this.getXValue(this.position.x + b[a.isOriginLeft ? "paddingLeft" : "paddingRight"]);
        c[d] = "";
        d = a.isOriginTop ? "bottom" : "top";
        c[a.isOriginTop ? "top" : "bottom"] = this.getYValue(this.position.y + b[a.isOriginTop ? "paddingTop" : "paddingBottom"]);
        c[d] = "";
        this.css(c);
        this.emitEvent("layout", [this])
    };
    m.prototype.getXValue = function (b) {
        var a = this.layout.options;
        return a.percentPosition && !a.isHorizontal ? b / this.layout.size.width * 100 + "%" : b + "px"
    };
    m.prototype.getYValue = function (b) {
        var a = this.layout.options;
        return a.percentPosition &&
        a.isHorizontal ? b / this.layout.size.height * 100 + "%" : b + "px"
    };
    m.prototype._transitionTo = function (b, a) {
        this.getPosition();
        var c = this.position.x,
            d = this.position.y,
            g = parseInt(b, 10),
            h = parseInt(a, 10),
            g = g === this.position.x && h === this.position.y;
        if (this.setPosition(b, a), g && !this.isTransitioning) return void this.layoutPosition();
        g = {};
        g.transform = this.getTranslate(b - c, a - d);
        this.transition({
            to: g,
            onTransitionEnd: {
                transform: this.layoutPosition
            },
            isCleaning: !0
        })
    };
    m.prototype.getTranslate = function (b, a) {
        var c = this.layout.options;
        return b = c.isOriginLeft ? b : -b, a = c.isOriginTop ? a : -a, v ? "translate3d(" + b + "px, " + a + "px, 0)" : "translate(" + b + "px, " + a + "px)"
    };
    m.prototype.goTo = function (b, a) {
        this.setPosition(b, a);
        this.layoutPosition()
    };
    m.prototype.moveTo = a ? m.prototype._transitionTo : m.prototype.goTo;
    m.prototype.setPosition = function (b, a) {
        this.position.x = parseInt(b, 10);
        this.position.y = parseInt(a, 10)
    };
    m.prototype._nonTransition = function (b) {
        this.css(b.to);
        b.isCleaning && this._removeStyles(b.to);
        for (var a in b.onTransitionEnd) b.onTransitionEnd[a].call(this)
    };
    m.prototype._transition = function (b) {
        if (!parseFloat(this.layout.options.transitionDuration)) return void this._nonTransition(b);
        var a = this._transn,
            c;
        for (c in b.onTransitionEnd) a.onEnd[c] = b.onTransitionEnd[c];
        for (c in b.to) a.ingProperties[c] = !0, b.isCleaning && (a.clean[c] = !0);
        b.from && this.css(b.from);
        this.enableTransition(b.to);
        this.css(b.to);
        this.isTransitioning = !0
    };
    var t = "opacity," + function (b) {
            return b.replace(/([A-Z])/g, function (b) {
                return "-" + b.toLowerCase()
            })
        }(w.transform || "transform");
    m.prototype.enableTransition =
        function () {
            this.isTransitioning || (this.css({
                transitionProperty: t,
                transitionDuration: this.layout.options.transitionDuration
            }), this.element.addEventListener(u, this, !1))
        };
    m.prototype.transition = m.prototype[q ? "_transition" : "_nonTransition"];
    m.prototype.onwebkitTransitionEnd = function (b) {
        this.ontransitionend(b)
    };
    m.prototype.onotransitionend = function (b) {
        this.ontransitionend(b)
    };
    var y = {
        "-webkit-transform": "transform",
        "-moz-transform": "transform",
        "-o-transform": "transform"
    };
    m.prototype.ontransitionend = function (b) {
        if (b.target ===
            this.element) {
            var a = this._transn,
                c = y[b.propertyName] || b.propertyName;
            delete a.ingProperties[c];
            var d;
            a: {
                d = a.ingProperties;
                for (var g in d) {
                    d = !1;
                    break a
                }
                d = !0
            }
            if (d && this.disableTransition(), c in a.clean && (this.element.style[b.propertyName] = "", delete a.clean[c]), c in a.onEnd) a.onEnd[c].call(this), delete a.onEnd[c];
            this.emitEvent("transitionEnd", [this])
        }
    };
    m.prototype.disableTransition = function () {
        this.removeTransitionStyles();
        this.element.removeEventListener(u, this, !1);
        this.isTransitioning = !1
    };
    m.prototype._removeStyles =
        function (b) {
            var a = {},
                c;
            for (c in b) a[c] = "";
            this.css(a)
        };
    var A = {
        transitionProperty: "",
        transitionDuration: ""
    };
    return m.prototype.removeTransitionStyles = function () {
        this.css(A)
    }, m.prototype.removeElem = function () {
        this.element.parentNode.removeChild(this.element);
        this.css({
            display: ""
        });
        this.emitEvent("remove", [this])
    }, m.prototype.remove = function () {
        if (!q || !parseFloat(this.layout.options.transitionDuration)) return void this.removeElem();
        var b = this;
        this.once("transitionEnd", function () {
            b.removeElem()
        });
        this.hide()
    },
        m.prototype.reveal = function () {
            delete this.isHidden;
            this.css({
                display: ""
            });
            var b = this.layout.options,
                a = {},
                c = this.getHideRevealTransitionEndProperty("visibleStyle");
            a[c] = this.onRevealTransitionEnd;
            this.transition({
                from: b.hiddenStyle,
                to: b.visibleStyle,
                isCleaning: !0,
                onTransitionEnd: a
            })
        }, m.prototype.onRevealTransitionEnd = function () {
        this.isHidden || this.emitEvent("reveal")
    }, m.prototype.getHideRevealTransitionEndProperty = function (b) {
        b = this.layout.options[b];
        if (b.opacity) return "opacity";
        for (var a in b) return a
    },
        m.prototype.hide = function () {
            this.isHidden = !0;
            this.css({
                display: ""
            });
            var b = this.layout.options,
                a = {},
                c = this.getHideRevealTransitionEndProperty("hiddenStyle");
            a[c] = this.onHideTransitionEnd;
            this.transition({
                from: b.visibleStyle,
                to: b.hiddenStyle,
                isCleaning: !0,
                onTransitionEnd: a
            })
        }, m.prototype.onHideTransitionEnd = function () {
        this.isHidden && (this.css({
            display: "none"
        }), this.emitEvent("hide"))
    }, m.prototype.destroy = function () {
        this.css({
            position: "",
            left: "",
            right: "",
            top: "",
            bottom: "",
            transition: "",
            transform: ""
        })
    },
        m
});
(function (a, d) {
    "function" == typeof define && define.amd ? define("outlayer/outlayer", ["eventie/eventie", "eventEmitter/EventEmitter", "get-size/get-size", "fizzy-ui-utils/utils", "./item"], function (h, c, l, m, g) {
            return d(a, h, c, l, m, g)
        }) : "object" == typeof exports ? module.exports = d(a, require("eventie"), require("wolfy87-eventemitter"), require("get-size"), require("fizzy-ui-utils"), require("./item")) : a.Outlayer = d(a, a.eventie, a.EventEmitter, a.getSize, a.fizzyUIUtils, a.Outlayer.Item)
})(window, function (a, d, h, c, l, m) {
    function g(a, c) {
        var d =
            l.getQueryElement(a);
        if (!d) return void(n && n.error("Bad element for " + this.constructor.namespace + ": " + (d || a)));
        this.element = d;
        q && (this.$element = q(this.element));
        this.options = l.extend({}, this.constructor.defaults);
        this.option(c);
        d = ++u;
        this.element.outlayerGUID = d;
        x[d] = this;
        this._create();
        this.options.isInitLayout && this.layout()
    }

    var n = a.console,
        q = a.jQuery,
        v = function () {
        },
        u = 0,
        x = {};
    return g.namespace = "outlayer", g.Item = m, g.defaults = {
        containerStyle: {
            position: "relative"
        },
        isInitLayout: !0,
        isOriginLeft: !0,
        isOriginTop: !0,
        isResizeBound: !0,
        isResizingContainer: !0,
        transitionDuration: "0.4s",
        hiddenStyle: {
            opacity: 0,
            transform: "scale(0.001)"
        },
        visibleStyle: {
            opacity: 1,
            transform: "scale(1)"
        }
    }, l.extend(g.prototype, h.prototype), g.prototype.option = function (a) {
        l.extend(this.options, a)
    }, g.prototype._create = function () {
        this.reloadItems();
        this.stamps = [];
        this.stamp(this.options.stamp);
        l.extend(this.element.style, this.options.containerStyle);
        this.options.isResizeBound && this.bindResize()
    }, g.prototype.reloadItems = function () {
        this.items = this._itemize(this.element.children)
    },
        g.prototype._itemize = function (a) {
            a = this._filterFindItemElements(a);
            for (var c = this.constructor.Item, d = [], g = 0, b = a.length; b > g; g++) {
                var e = new c(a[g], this);
                d.push(e)
            }
            return d
        }, g.prototype._filterFindItemElements = function (a) {
        return l.filterFindElements(a, this.options.itemSelector)
    }, g.prototype.getItemElements = function () {
        for (var a = [], c = 0, d = this.items.length; d > c; c++) a.push(this.items[c].element);
        return a
    }, g.prototype.layout = function () {
        this._resetLayout();
        this._manageStamps();
        this.layoutItems(this.items, void 0 !==
        this.options.isLayoutInstant ? this.options.isLayoutInstant : !this._isLayoutInited);
        this._isLayoutInited = !0
    }, g.prototype._init = g.prototype.layout, g.prototype._resetLayout = function () {
        this.getSize()
    }, g.prototype.getSize = function () {
        this.size = c(this.element)
    }, g.prototype._getMeasurement = function (a, d) {
        var g, h = this.options[a];
        h ? ("string" == typeof h ? g = this.element.querySelector(h) : l.isElement(h) && (g = h), this[a] = g ? c(g)[d] : h) : this[a] = 0
    }, g.prototype.layoutItems = function (a, c) {
        a = this._getItemsForLayout(a);
        this._layoutItems(a,
            c);
        this._postLayout()
    }, g.prototype._getItemsForLayout = function (a) {
        for (var c = [], d = 0, g = a.length; g > d; d++) {
            var b = a[d];
            b.isIgnored || c.push(b)
        }
        return c
    }, g.prototype._layoutItems = function (a, c) {
        if (this._emitCompleteOnItems("layout", a), a && a.length) {
            for (var d = [], g = 0, b = a.length; b > g; g++) {
                var e = a[g],
                    f = this._getItemLayoutPosition(e);
                f.item = e;
                f.isInstant = c || e.isLayoutInstant;
                d.push(f)
            }
            this._processLayoutQueue(d)
        }
    }, g.prototype._getItemLayoutPosition = function () {
        return {
            x: 0,
            y: 0
        }
    }, g.prototype._processLayoutQueue = function (a) {
        for (var c =
            0, d = a.length; d > c; c++) {
            var g = a[c];
            this._positionItem(g.item, g.x, g.y, g.isInstant)
        }
    }, g.prototype._positionItem = function (a, c, d, g) {
        g ? a.goTo(c, d) : a.moveTo(c, d)
    }, g.prototype._postLayout = function () {
        this.resizeContainer()
    }, g.prototype.resizeContainer = function () {
        if (this.options.isResizingContainer) {
            var a = this._getContainerSize();
            a && (this._setContainerMeasure(a.width, !0), this._setContainerMeasure(a.height, !1))
        }
    }, g.prototype._getContainerSize = v, g.prototype._setContainerMeasure = function (a, c) {
        if (void 0 !== a) {
            var d =
                this.size;
            d.isBorderBox && (a += c ? d.paddingLeft + d.paddingRight + d.borderLeftWidth + d.borderRightWidth : d.paddingBottom + d.paddingTop + d.borderTopWidth + d.borderBottomWidth);
            a = Math.max(a, 0);
            this.element.style[c ? "width" : "height"] = a + "px"
        }
    }, g.prototype._emitCompleteOnItems = function (a, c) {
        function d() {
            b.dispatchEvent(a + "Complete", null, [c])
        }

        function g() {
            f++;
            f === e && d()
        }

        var b = this,
            e = c.length;
        if (!c || !e) return void d();
        for (var f = 0, h = 0, n = c.length; n > h; h++) c[h].once(a, g)
    }, g.prototype.dispatchEvent = function (a, c, d) {
        var g =
            c ? [c].concat(d) : d;
        if (this.emitEvent(a, g), q) (this.$element = this.$element || q(this.element), c) ? (c = q.Event(c), c.type = a, this.$element.trigger(c, d)) : this.$element.trigger(a, d)
    }, g.prototype.ignore = function (a) {
        (a = this.getItem(a)) && (a.isIgnored = !0)
    }, g.prototype.unignore = function (a) {
        (a = this.getItem(a)) && delete a.isIgnored
    }, g.prototype.stamp = function (a) {
        if (a = this._find(a)) {
            this.stamps = this.stamps.concat(a);
            for (var c = 0, d = a.length; d > c; c++) this.ignore(a[c])
        }
    }, g.prototype.unstamp = function (a) {
        if (a = this._find(a))
            for (var c =
                0, d = a.length; d > c; c++) {
                var g = a[c];
                l.removeFrom(this.stamps, g);
                this.unignore(g)
            }
    }, g.prototype._find = function (a) {
        return a ? ("string" == typeof a && (a = this.element.querySelectorAll(a)), l.makeArray(a)) : void 0
    }, g.prototype._manageStamps = function () {
        if (this.stamps && this.stamps.length) {
            this._getBoundingRect();
            for (var a = 0, c = this.stamps.length; c > a; a++) this._manageStamp(this.stamps[a])
        }
    }, g.prototype._getBoundingRect = function () {
        var a = this.element.getBoundingClientRect(),
            c = this.size;
        this._boundingRect = {
            left: a.left +
            c.paddingLeft + c.borderLeftWidth,
            top: a.top + c.paddingTop + c.borderTopWidth,
            right: a.right - (c.paddingRight + c.borderRightWidth),
            bottom: a.bottom - (c.paddingBottom + c.borderBottomWidth)
        }
    }, g.prototype._manageStamp = v, g.prototype._getElementOffset = function (a) {
        var d = a.getBoundingClientRect(),
            g = this._boundingRect;
        a = c(a);
        return {
            left: d.left - g.left - a.marginLeft,
            top: d.top - g.top - a.marginTop,
            right: g.right - d.right - a.marginRight,
            bottom: g.bottom - d.bottom - a.marginBottom
        }
    }, g.prototype.handleEvent = function (a) {
        var c = "on" + a.type;
        this[c] && this[c](a)
    }, g.prototype.bindResize = function () {
        this.isResizeBound || (d.bind(a, "resize", this), this.isResizeBound = !0)
    }, g.prototype.unbindResize = function () {
        this.isResizeBound && d.unbind(a, "resize", this);
        this.isResizeBound = !1
    }, g.prototype.onresize = function () {
        this.resizeTimeout && clearTimeout(this.resizeTimeout);
        var a = this;
        this.resizeTimeout = setTimeout(function () {
            a.resize();
            delete a.resizeTimeout
        }, 100)
    }, g.prototype.resize = function () {
        this.isResizeBound && this.needsResizeLayout() && this.layout()
    }, g.prototype.needsResizeLayout =
        function () {
            var a = c(this.element);
            return this.size && a && a.innerWidth !== this.size.innerWidth
        }, g.prototype.addItems = function (a) {
        a = this._itemize(a);
        return a.length && (this.items = this.items.concat(a)), a
    }, g.prototype.appended = function (a) {
        a = this.addItems(a);
        a.length && (this.layoutItems(a, !0), this.reveal(a))
    }, g.prototype.prepended = function (a) {
        a = this._itemize(a);
        if (a.length) {
            var c = this.items.slice(0);
            this.items = a.concat(c);
            this._resetLayout();
            this._manageStamps();
            this.layoutItems(a, !0);
            this.reveal(a);
            this.layoutItems(c)
        }
    },
        g.prototype.reveal = function (a) {
            this._emitCompleteOnItems("reveal", a);
            for (var c = a && a.length, d = 0; c && c > d; d++) a[d].reveal()
        }, g.prototype.hide = function (a) {
        this._emitCompleteOnItems("hide", a);
        for (var c = a && a.length, d = 0; c && c > d; d++) a[d].hide()
    }, g.prototype.revealItemElements = function (a) {
        a = this.getItems(a);
        this.reveal(a)
    }, g.prototype.hideItemElements = function (a) {
        a = this.getItems(a);
        this.hide(a)
    }, g.prototype.getItem = function (a) {
        for (var c = 0, d = this.items.length; d > c; c++) {
            var g = this.items[c];
            if (g.element === a) return g
        }
    },
        g.prototype.getItems = function (a) {
            a = l.makeArray(a);
            for (var c = [], d = 0, g = a.length; g > d; d++) {
                var b = this.getItem(a[d]);
                b && c.push(b)
            }
            return c
        }, g.prototype.remove = function (a) {
        a = this.getItems(a);
        if (this._emitCompleteOnItems("remove", a), a && a.length)
            for (var c = 0, d = a.length; d > c; c++) {
                var g = a[c];
                g.remove();
                l.removeFrom(this.items, g)
            }
    }, g.prototype.destroy = function () {
        var a = this.element.style;
        a.height = "";
        a.position = "";
        a.width = "";
        for (var a = 0, c = this.items.length; c > a; a++) this.items[a].destroy();
        this.unbindResize();
        delete x[this.element.outlayerGUID];
        delete this.element.outlayerGUID;
        q && q.removeData(this.element, this.constructor.namespace)
    }, g.data = function (a) {
        return (a = (a = l.getQueryElement(a)) && a.outlayerGUID) && x[a]
    }, g.create = function (a, c) {
        function d() {
            g.apply(this, arguments)
        }

        return Object.create ? d.prototype = Object.create(g.prototype) : l.extend(d.prototype, g.prototype), d.prototype.constructor = d, d.defaults = l.extend({}, g.defaults), l.extend(d.defaults, c), d.prototype.settings = {}, d.namespace = a, d.data = g.data, d.Item = function () {
            m.apply(this, arguments)
        },
            d.Item.prototype = new m, l.htmlInit(d, a), q && q.bridget && q.bridget(a, d), d
    }, g.Item = m, g
});
(function (a, d) {
    "function" == typeof define && define.amd ? define(["outlayer/outlayer", "get-size/get-size", "fizzy-ui-utils/utils"], d) : "object" == typeof exports ? module.exports = d(require("outlayer"), require("get-size"), require("fizzy-ui-utils")) : a.Masonry = d(a.Outlayer, a.getSize, a.fizzyUIUtils)
})(window, function (a, d, h) {
    a = a.create("masonry");
    return a.prototype._resetLayout = function () {
        this.getSize();
        this._getMeasurement("columnWidth", "outerWidth");
        this._getMeasurement("gutter", "outerWidth");
        this.measureColumns();
        var a = this.cols;
        for (this.colYs = []; a--;) this.colYs.push(0);
        this.maxY = 0
    }, a.prototype.measureColumns = function () {
        if (this.getContainerWidth(), !this.columnWidth) {
            var a = this.items[0];
            this.columnWidth = (a = a && a.element) && d(a).outerWidth || this.containerWidth
        }
        var a = this.columnWidth += this.gutter,
            h = this.containerWidth + this.gutter,
            m = a - h % a,
            a = Math[m && 1 > m ? "round" : "floor"](h / a);
        this.cols = Math.max(a, 1)
    }, a.prototype.getContainerWidth = function () {
        var a = d(this.options.isFitWidth ? this.element.parentNode : this.element);
        this.containerWidth =
            a && a.innerWidth
    }, a.prototype._getItemLayoutPosition = function (a) {
        a.getSize();
        var d = a.size.outerWidth % this.columnWidth,
            d = Math[d && 1 > d ? "round" : "ceil"](a.size.outerWidth / this.columnWidth),
            d = Math.min(d, this.cols),
            m = this._getColGroup(d),
            g = Math.min.apply(Math, m),
            d = h.indexOf(m, g),
            n = {
                x: this.columnWidth * d,
                y: g
            };
        a = g + a.size.outerHeight;
        m = this.cols + 1 - m.length;
        for (g = 0; m > g; g++) this.colYs[d + g] = a;
        return n
    }, a.prototype._getColGroup = function (a) {
        if (2 > a) return this.colYs;
        for (var d = [], h = this.cols + 1 - a, g = 0; h > g; g++) {
            var n =
                this.colYs.slice(g, g + a);
            d[g] = Math.max.apply(Math, n)
        }
        return d
    }, a.prototype._manageStamp = function (a) {
        var h = d(a),
            m = this._getElementOffset(a);
        a = this.options.isOriginLeft ? m.left : m.right;
        var g = a + h.outerWidth,
            n = Math.floor(a / this.columnWidth),
            n = Math.max(0, n);
        a = Math.floor(g / this.columnWidth);
        a -= g % this.columnWidth ? 0 : 1;
        a = Math.min(this.cols - 1, a);
        h = (this.options.isOriginTop ? m.top : m.bottom) + h.outerHeight;
        for (m = n; a >= m; m++) this.colYs[m] = Math.max(h, this.colYs[m])
    }, a.prototype._getContainerSize = function () {
        this.maxY =
            Math.max.apply(Math, this.colYs);
        var a = {
            height: this.maxY
        };
        return this.options.isFitWidth && (a.width = this._getContainerFitWidth()), a
    }, a.prototype._getContainerFitWidth = function () {
        for (var a = 0, d = this.cols; --d && 0 === this.colYs[d];) a++;
        return (this.cols - a) * this.columnWidth - this.gutter
    }, a.prototype.needsResizeLayout = function () {
        var a = this.containerWidth;
        return this.getContainerWidth(), a !== this.containerWidth
    }, a
});
$(document).ready(function () {
    $("#valutes").click(function () {
        $("#valutes .lang").toggle()
    });
    $("#valutes .lang").click(function () {
        window.location.href = $("base").attr("href") + $(this).find("a").attr("title")
    });
    $("#valutes").mouseleave(function () {
        $("#valutes .lang").hide()
    });
    $("#plus").click(function () {
        value = parseInt($("#amount").val()) + 1;
        $("#amount").val(value)
    });
    $("#minus").click(function () {
        value = parseInt($("#amount").val()) - 1;
        0 < value && $("#amount").val(value)
    });
    $("#multiselect-1").multiselect();
    $("#multiselect-2").multiselect();
    $("#multiselect-3").multiselect();
    $(".bestsellers").slick({
        infinite: !0,
        slidesToShow: 4,
        slidesToScroll: 4,
        centerMode: !1,
        centerPadding: "0px",
        prevArrow: '<a href="javascript: void(0)" class="slick-prev"><span class="sprite carousel_prev"></span></a>',
        nextArrow: '<a href="javascript: void(0)" class="slick-next"><span class="sprite carousel_next"></span></a>',
        responsive: [{
            breakpoint: 1280,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 3,
                slidesToScroll: 3
            }
        }, {
            breakpoint: 1024,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 3,
                slidesToScroll: 3
            }
        }, {
            breakpoint: 768,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 2,
                slidesToScroll: 2
            }
        }, {
            breakpoint: 560,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    });
    $("#related-slider").slick({
        infinite: !0,
        slidesToShow: 4,
        slidesToScroll: 4,
        centerMode: !1,
        centerPadding: "0px",
        prevArrow: '<a href="javascript: void(0)" class="slick-prev"><img src="images/carousel_prev.png" /></a>',
        nextArrow: '<a href="javascript: void(0)" class="slick-next"><img src="images/carousel_next.png" /></a>',
        responsive: [{
            breakpoint: 1280,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 3,
                slidesToScroll: 3
            }
        }, {
            breakpoint: 1024,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 2,
                slidesToScroll: 2
            }
        }, {
            breakpoint: 768,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 2,
                slidesToScroll: 2
            }
        }, {
            breakpoint: 560,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    });
    $(".bestsellers").on("beforeChange", function (a, c, d, h) {
        a = h - 1;
        c = h - 2;
        d =
            $(window).width();
        $(".slick-slide .slick-inside .sep").hide();
        480 < d && ($('.slick-slide[data-slick-index="' + h + '"] .slick-inside .sep').show(), $('.slick-slide[data-slick-index="' + a + '"] .slick-inside .sep').show());
        768 < d && $('.slick-slide[data-slick-index="' + c + '"] .slick-inside .sep').show()
    });
    var a = "";
    $(".slick-initialized .slick-slide .slick-inside ").each(function () {
        var c = $(this);
        $(this).find(".testimonial-carousel a");
        c.find(".title").height();
        a = a > $(this).find(".title").height() ? a : $(this).find(".title").height()
    });
    $(".slick-initialized .slick-slide .slick-inside .title").css("height", a);
    var d = $(window).width();
    $(".slick-slide .slick-inside .sep").hide();
    480 < d && ($('.slick-slide[data-slick-index="0"] .slick-inside .sep').show(), $('.slick-slide[data-slick-index="-1"] .slick-inside .sep').show());
    768 < d && $('.slick-slide[data-slick-index="-2"] .slick-inside .sep').show();
    $(window).load(function () {
        var a = $(window).width(),
            c = 172 - (39 - parseInt($(".jas-navigation .jas-navigation-top img").height()));
        $(".navbar-nav .dropdown-menu").css("top",
            c + "px");
        1200 >= a && $(".navbar-nav .dropdown-menu").css("top", "100px")
    });
    $(window).resize(function () {
        var a = $(window).width(),
            c = 39 - parseInt($(".jas-navigation .jas-navigation-top img").height()),
            d = 172 - c;
        console.log(c);
        $(".navbar-nav .dropdown-menu").css("top", d + "px");
        1200 >= a && $(".navbar-nav .dropdown-menu").css("top", "100px")
    });
    $(window).load(function () {
        $(".jas-why-choose-endoca .jas-tabs ul li .jas-inside").each(function () {
            var a = parseInt($(this).find(".jas-title").height()) / 2,
                c = parseInt($(this).find("img").height()) /
                    2,
                a = a - c;
            console.log(a);
            $(this).find("img").css("margin-top", a + "px")
        })
    });
    $(window).scroll(function () {
        var a = $(window).width(),
            c = $(".product-inner").length,
            d = $(".content.products").length,
            h = $(".product-categories").length;
        if ((0 < c || 0 < d && 0 >= h) && 1024 <= a) {
            var a = $(".navbar-nav > li > .dropdown-menu"),
                c = $(".load-tpc"),
                d = $(window).scrollTop(),
                l = $(".jas-navigation"),
                h = $(".navigation"),
                l = l.height(),
                h = h.height();
            d >= l + h ? (a.addClass("fixed"), c.addClass("fixed")) : (a.removeClass("fixed"), c.removeClass("fixed"))
        }
    });
    d = $(window).width();
    if (0 < $(".product-inner").length && 1024 <= d) {
        var d = $(".navbar-nav > li > .dropdown-menu"),
            h = $(".load-tpc"),
            c = $(window).scrollTop(),
            l = $(".jas-navigation"),
            m = $(".navigation"),
            l = l.height(),
            m = m.height();
        c >= l + m ? (d.addClass("fixed"), h.addClass("fixed")) : (d.removeClass("fixed"), h.removeClass("fixed"))
    }
    $("#responsive-btn").on("click", function () {
        $("#responsive-menu").is(":visible") ? $("#responsive-menu").slideUp(400, function () {
                $("body").css("overflow", "auto");
                $(".responsive-parent").removeClass("fixed_trans")
            }) :
            ($("#responsive-menu").height($(window).height()), $("#responsive-menu").slideDown(), $("body").css("overflow", "hidden"), $(".responsive-parent").addClass("fixed_trans"))
    });
    $(window).on("orientationchange", function (a) {
        $("#responsive-menu").is(":visible") && $("#responsive-btn").click()
    });
    $(window).on("resize", function (a) {
        a = $(this);
        $("#responsive-menu").is(":visible") && 1023 <= a.width() && $("#responsive-btn").click()
    })
});
jQuery.fn.multiselect = function () {
    $(this).children(".heading").click(function () {
        $(this).parent().hasClass("selected") ? $(this).parent().removeClass("selected") : $(this).parent().addClass("selected")
    });
    $(".multiselect").mouseleave(function () {
        $(this).removeClass("selected")
    })
};
jQuery.fn.imagechanger = function () {
    $(this).find(".thumbs img").click(function () {
        $(".big").attr("src", $(this).attr("src"));
        $(".thumb").removeClass("active");
        $(this).addClass("active")
    })
};

function logout_amazon() {
    "undefined" !== typeof amazon && (amazon.Login.logout(), document.cookie = "amazon_Login_accessToken=; expires=Thu, 01 Jan 1970 00:00:00 GMT")
};
$(document).ready(function () {
    $("#plus").click(function () {
        value = parseInt($("#quantity").val()) + 1;
        $("#quantity").val(value)
    });
    $("#minus").click(function () {
        value = parseInt($("#quantity").val()) - 1;
        0 < value && $("#quantity").val(value)
    });
    0 < $(".product-to-choose-btn2").length && $(".product-to-choose-btn2 a").hcSticky({
        top: 60,
        stickTo: "#products",
        bottomEnd: 250,
        responsive: !1
    });
    if ($("#payments .payment_block.active").is(":visible"))
        if ("bank_payment_input" == $("#payments .payment_block.active input").attr("id")) {
            var a = ["action"],
                d = ["add_bank_discount"];
            ajax_siusti(a, d, "ajax_interface.php", "add_bank_discount_end")
        } else a = ["action"], d = ["remove_bank_discount"], ajax_siusti(a, d, "ajax_interface.php", "remove_bank_discount_end");
    $('#payments .payment_block input[type="radio"]').on("change", function () {
        if ("bank_payment_input" == $(this).attr("id")) {
            var a = ["action"],
                c = ["add_bank_discount"];
            ajax_siusti(a, c, "ajax_interface.php", "add_bank_discount_end")
        } else a = ["action"], c = ["remove_bank_discount"], ajax_siusti(a, c, "ajax_interface.php",
            "remove_bank_discount_end")
    })
});

function add_bank_discount_end(a) {
    a = parse_get(a);
    1 == a.ok && html("order_price_summary", ajax_decode(a.html))
}

function remove_bank_discount_end(a) {
    a = parse_get(a);
    html("order_price_summary", ajax_decode(a.html))
}

function plus(a, d, h) {
    value = parseInt(a.val()) + 1;
    value >= d && value <= h && a.val(value)
}

function minus(a, d, h) {
    value = parseInt(a.val()) - 1;
    value >= d && value <= h && a.val(value)
}

function menu_expand(a) {
    a = "cat_menu" + a;
    exists(a) && (is_hidden(a) ? show(a) : hide(a))
}

function menu_more(a) {
    for (i = 0; 1E3 > i; i++)
        if (oid = "hlev_" + a + "_" + i, exists(oid)) show(oid, "block");
        else break;
    hide("hlev_" + a + "_t")
}

function select_variation(a, d, h, c) {
    $(".colors ul li a span").remove();
    $(a).append("<span></span>");
    $("#selected_color").val(d);
    d = a = $("#quantity").val();
    parseInt(a) > parseInt(h) ? d = h : a < c && (d = c);
    $("#quantity").val(d);
    $(".plus").attr("onclick", "plus($('#quantity'), '" + c + "', '" + h + "'); return false;");
    $(".minus").attr("onclick", "minus($('#quantity'), '" + c + "', '" + h + "'); return false;")
}

function show_variation(a, d, h) {
    ge("product_img_" + a).src = d;
    html(ge("product_code_" + a), h)
}

function ntab(a) {
    exists("tab_naujienos") && hide("tab_naujienos");
    exists("tab_duk") && hide("tab_duk");
    exists("tab_atsiliepimai") && hide("tab_atsiliepimai");
    show("tab_" + a)
}

function start_inc(a, d, h, c, l, m) {
    var g = 1,
        g = parseInt(ge(a).value),
        g = d ? g + h : g - h;
    g < c && (g = c);
    g > l && (g = l);
    ge(a).value = g;
    undef(m) || "" != m && eval(m)
}

function stop_inc() {
}

function catalogue_menu(a) {
    "1" == a ? (hide("catalogue_menu_tr2"), show("catalogue_menu_tr1"), setcss("menu_tab1", "tab1 active", !1), setcss("menu_tab2", "tab2", !1)) : (hide("catalogue_menu_tr1"), show("catalogue_menu_tr2"), setcss("menu_tab1", "tab1", !1), setcss("menu_tab2", "tab2 active", !1))
}
var p2c = 0;

function add2cart(a) {
    p2c = a;
    temp = a.split("_");
    id = temp[0];
    ajax_siusti(["action", "product", "quantity", "size", "variation"], ["add_to_cart", id, 1, "", ""], "ajax_interface.php", "add2cart_end")
}

function add2cart_end(a) {
    "0" != parse_get(a).ok && add2cart_confirm2()
}

function add2cart_confirm2() {
    end_cart_addition();
    hideSelectBoxes();
    hideFlash();
    if (1024 > window.innerWidth) {
        show("cart_dialog_bg", "block");
        show("cart_dialog", "block");
        setProperty("cart_dialog_bg", "w", getProperty("", "px"));
        setProperty("cart_dialog_bg", "h", getProperty("", "py"));
        var a = round((getProperty("", "wx") - getProperty("cart_dialog", "w")) / 2),
            d = round((getProperty("", "wy") - getProperty("cart_dialog", "h")) / 2 + getProperty("", "sy"));
        setProperty("cart_dialog", "x", a);
        setProperty("cart_dialog", "y", d)
    }
}

function cart_dialog_close() {
    hide("cart_dialog_bg");
    hide("cart_dialog");
    showSelectBoxes();
    showFlash()
}

function add2cart_confirm() {
    ge("cart_animation").src = ge(p2c).src;
    copyProperty(p2c, "cart_animation", "w");
    copyProperty(p2c, "cart_animation", "h");
    show("cart_animation", "block");
    fotox = getProperty(p2c, "x");
    fotoy = getProperty(p2c, "y");
    setProperty("cart_animation", "x", fotox);
    setProperty("cart_animation", "y", fotoy);
    targetx = getProperty("sidecart_contents", "x") + 150;
    targety = getProperty("sidecart_contents", "y") + getProperty("sidecart_contents", "h") - 75;
    var a = [fotox, targetx, -150],
        d = [fotoy, targety, -150],
        h = new requiem_action;
    h.cycles = 75;
    h.callback = 'hide("cart_animation");';
    h.go("cart_animation", a, d, ["", 10, 0], ["", 10, 0], "");
    setTimeout("end_cart_addition()", 1200)
}

function hide_cart_errors() {
    hide("cart_error_zero");
    hide("cart_error_product");
    hide("cart_error_quantity");
    hide("cart_error_variation");
    hide("cart_error_size")
}

function confirm_cart_addition() {
    ge("cart_animation").src = ge("main_foto").src;
    copyProperty("main_foto", "cart_animation", "w");
    copyProperty("main_foto", "cart_animation", "h");
    show("cart_animation", "block");
    fotox = getProperty("main_foto", "x");
    fotoy = getProperty("main_foto", "y");
    setProperty("cart_animation", "x", fotox);
    setProperty("cart_animation", "y", fotoy);
    targetx = getProperty("sidecart_contents", "x") + 150;
    targety = getProperty("sidecart_contents", "y") + getProperty("sidecart_contents", "h") - 75;
    var a = [fotox, targetx,
            20
        ],
        d = [fotoy, targety, -800],
        h = new requiem_action;
    h.cycles = 35;
    h.callback = 'hide("cart_animation");';
    h.go("cart_animation", a, d, ["", 10, 0], ["", 10, 0], "");
    setTimeout("end_cart_addition()", 1200)
}

function end_cart_addition() {
    update_cart()
}

function update_cart() {
    $.getJSON("shopping-cart.html?action=minicart", function (a) {
        $("#sidecart_contents, #fw_sidecart_contents").html(a.html);
        $("#scroll-container").customScrollbar("remove").customScrollbar({
            skin: "endoca-skin",
            hScroll: !1,
            updateOnWindowResize: !0
        })
    })
}

function end_update_cart(a) {
    a = parse_get(a);
    a = ajax_decode(a.html);
    $("#sidecart_contents").html(a);
    $("#scroll-container").customScrollbar("remove");
    $("#scroll-container").customScrollbar({
        skin: "endoca-skin",
        hScroll: !1,
        updateOnWindowResize: !0
    })
}

function change_cart_amount(a) {
    var d = 0 != a ? gv("quantity" + a) : 0;
    ajax_siusti(["action", "cart_id", "quantity", "lang"], ["update_cart_quantity", a, d, lang], "ajax_interface.php", "end_update_cart_amount")
}

function end_update_cart_amount(a) {
    a = parse_get(a);
    if ("1" == a.ok) {
        var d = a.row;
        0 < parseInt(d) && (html("single_new_price_" + d, ajax_decode(a.p2_new)), html("sum_new_price_" + d, ajax_decode(a.s2_new)), "" != a.p_old ? (html("single_old_price_" + d, "<strike>" + ajax_decode(a.p2_old) + "</strike>"), show("single_old_price_" + d)) : (html("single_old_price_" + d, ""), hide("single_old_price_" + d)), "" != a.s_old ? (html("sum_old_price_" + d, "<strike>" + ajax_decode(a.s2_old) + "</strike>"), show("sum_old_price_" + d)) : (html("sum_old_price_" + d, ""),
                hide("sum_old_price_" + d)));
        html("order_price_summary", ajax_decode(a.html))
    }
    update_coupon_list_short()
}

function change_cart_amount2(a) {
    var d = 0 != a ? gv("quantity" + a) : 0;
    ajax_siusti(["action", "cart_id", "quantity", "lang"], ["update_cart_quantity", a, d, lang], "ajax_interface.php", "end_update_cart_amount2")
}

function end_update_cart_amount2(a) {
    a = parse_get(a);
    "1" == a.ok && html("order_price_summary", ajax_decode(a.html))
}

function update_cart_extra() {
    ajax_siusti(["action"], ["update_cart_extra"], "ajax_interface.php", "end_update_cart_extra")
}

function end_update_cart_extra(a) {
    a = parse_get(a);
    html("cart_arrival_date", a.d);
    html("cart_bonus_count", a.b)
}

function order_show_login() {
    show("account_type1", "");
    hide("account_type0");
    hide("order_block_1");
    exists("order_block_4") && hide("order_block_4")
}

function to_wishlist(a) {
    ajax_siusti(["action", "product"], ["add2wishlist", a], "ajax_interface.php", "end_to_wishlist")
}

function end_to_wishlist(a) {
    "ok" == a && ($(".wanted a").addClass("active"), setTimeout("update_wishlist()", 500))
}

function update_wishlist() {
    ajax_siusti(["action"], ["update_wishlist"], "ajax_interface.php", "end_update_wishlist")
}

function end_update_wishlist(a) {
    a = ajax_decode(a);
    html("wishlist_container", a)
}

function wishlist_remove(a) {
    confirm(jslang.wishlist_really_remove) && ajax_siusti(["action", "product"], ["wishlist_remove", a], "ajax_interface.php", "update_wishlist")
}

function enter_coupon() {
    hide("coupon_error");
    var a = ["add_coupon", gv("coupon_input")];
    ajax_siusti(["action", "coupon_nr"], a, "ajax_interface.php", "end_enter_coupon")
}

function end_enter_coupon(a) {
    a = parse_get(a);
    0 == a.ok ? (exists("coupon_error_nr") && html("coupon_error_nr", a.coupon_nr), a.error && $("#coupon_error").text(a.error), show("coupon_error", "block")) : ($(".cart-products-reload").load(window.location.href + " .cart-products-reload", function () {
            $(this).find(".cart-products-reload").unwrap()
        }), refresh_coupon_list())
}

function remove_coupon(a) {
    ajax_siusti(["action", "coupon_id"], ["remove_coupon", a], "ajax_interface.php", "end_remove_coupon")
}

function end_remove_coupon(a) {
    $(".cart-products-reload").load(window.location.href + " .cart-products-reload", function () {
        $(this).find(".cart-products-reload").unwrap()
    });
    refresh_coupon_list()
}

function refresh_coupon_list() {
    ajax_siusti(["action"], ["refresh_coupons"], "ajax_interface.php", "end_refresh_coupon_list")
}

function end_refresh_coupon_list(a) {
    html("coupon_list_container", ajax_decode(a));
    update_price_table();
    $(".product-block").each(function () {
        var a = $(this).attr("data-product-id");
        change_cart_amount(a)
    })
}

function update_coupon_list_short() {
    ajax_siusti(["action"], ["refresh_coupons"], "ajax_interface.php", "end_refresh_coupon_list_short")
}

function end_refresh_coupon_list_short(a) {
    html("coupon_list_container", ajax_decode(a));
    update_cart_extra()
}

function use_order_bonuses(a) {
    ajax_siusti(["action", "use"], ["use_bonuses", a], "ajax_interface.php", "end_use_order_bonuses")
}

function end_use_order_bonuses(a) {
    refresh_coupon_list()
}

function update_price_table(a) {
    undef(a) && (a = "");
    ajax_siusti(["action", "lang", "mod"], ["update_prices", lang, a], "ajax_interface.php", "end_update_price_table")
}

function end_update_price_table(a) {
    html("order_price_summary", ajax_decode(a));
    exists("cart_total_price") && change_cart_amount(0)
}

function change_delivery_way(a) {
    ajax_siusti(["action", "delivery", "lang"], ["update_delivery", a, lang], "ajax_interface.php", "end_change_delivery_way")
}

function end_change_delivery_way(a) {
    ajax_siusti(["action", "lang"], ["update_prices", lang], "ajax_interface.php", "end_update_price_table2")
}

function end_update_price_table2(a) {
    html("order_price_summary", ajax_decode(a))
}

function check_payment(a) {
    ajax_siusti(["action", "payment", "lang"], ["update_payment", a, lang], "ajax_interface.php", "end_change_payment")
}

function end_change_payment(a) {
}

function update_delivery() {
    ajax_siusti(["action", "lang"], ["update_delivery_payment", lang], "ajax_interface.php", "end_change_delivery")
}

function end_change_delivery(a) {
    ajax_siusti(["action"], ["update_prices"], "ajax_interface.php", "end_update_price_table2");
    html("delivery_container", ajax_decode(a))
}
var max_suggestions = 16,
    suggestion_target, selected_suggestion = 0;

function start_suggestions(a, d, h) {
    a = key(a);
    if (38 == a) move_suggest_up();
    else if (40 == a) move_suggest_down();
    else if (13 == a && 0 < selected_suggestion) dosuggest(ge("suggestion" + selected_suggestion).innerHTML);
    else {
        suggestion_target = d;
        d = gv(d);
        if (3 > d.length) return;
        ajax_siusti(["action", "keyword", "lang", "max"], ["suggest", d, h, max_suggestions], "ajax_interface.php", "get_suggestions")
    }
    return !0
}

function suggestions_form() {
    return 0 < selected_suggestion ? (dosuggest(ge("suggestion" + selected_suggestion).innerHTML), !1) : !0
}

function get_suggestions(a) {
    exists("suggestions") && "none" != a && "" != a ? (html("suggestions", ajax_decode(a)), show("suggestions", "block"), selected_suggestion = 0) : hide_suggestions()
}

function position_suggest_box() {
    var a = getProperty(suggestion_target, "x"),
        d = getProperty(suggestion_target, "y"),
        h = ge("suggestions");
    setProperty(h, "x", a - 15);
    setProperty(h, "y", d + 29)
}

function move_suggest_up() {
    var a = selected_suggestion - 1;
    if (!exists("suggestion" + a))
        for (var d = max_suggestions; 0 < d; d--)
            if (exists("suggestion" + d)) {
                a = d;
                break
            }
    if (exists("suggestion" + a)) {
        selected_suggestion = a;
        for (d = 1; d <= max_suggestions; d++) exists("suggestion" + d) && delcss("suggestion" + d, "selected");
        setcss("suggestion" + a, "selected")
    }
}

function move_suggest_down() {
    var a = selected_suggestion + 1;
    if (!exists("suggestion" + a))
        for (var d = 1; d <= max_suggestions; d++)
            if (exists("suggestion" + d)) {
                a = d;
                break
            }
    if (exists("suggestion" + a)) {
        selected_suggestion = a;
        for (d = 1; d <= max_suggestions; d++) exists("suggestion" + d) && delcss("suggestion" + d, "selected");
        setcss("suggestion" + a, "selected")
    }
}

function dosuggest(a) {
    sv("quicksearch", strip_tags(unhtmlspecialchars(a)));
    selected_suggestion = 0;
    hide_suggestions();
    ge("quicksearch_form").submit()
}

function blur_suggestions() {
    setTimeout("hide_suggestions()", 50)
}

function hide_suggestions() {
    exists("suggestions") && hide("suggestions")
}
var current_color = 0;

function select_product_color(a, d, h, c) {
    sv("selected_color", c);
    sv("product_code", h);
    setcss("color_div" + d, "selected_img");
    delcss("color_div" + current_color, "selected_img");
    current_color = d;
    a.show_foto(d);
    load_variation_sizes(c)
}

function load_variation_sizes(a) {
    html("product_variations", '<img src="style/loading2.gif">');
    ajax_siusti(["action", "variation_id"], ["get_variation_sizes", a], "ajax_interface.php", "end_load_variation_sizes")
}

function end_load_variation_sizes(a) {
    html("product_variations", ajax_decode(a))
}

function product_tab(a, d) {
    undef(d) && (d = 0);
    for (var h = 0; 10 > h;)
        if (h++, exists("product_tab" + h)) {
            hide("product_tab" + h);
            var c = "tab1";
            5 == h && (c += " comment");
            setcss("product_tab_card_" + h, c, !1)
        }
    show("product_tab" + a, "");
    c = "tab2";
    5 == a && (c += " comment");
    setcss("product_tab_card_" + a, c, !1);
    5 == a && 0 == d && (hide("kom_naujas_mgt"), show("kom_naujas"));
    5 == a && hide("product_short_comment")
}

function check_remaining() {
    code = gv("product_code");
    ajax_siusti(["action", "code", "lang"], ["check_remaining", code, lang], "ajax_interface.php", "end_check_remaining");
    html("dialog_text", '<div align="center"><img src="style/wait.gif"></div>');
    hideSelectBoxes();
    hideFlash();
    show("dialog_foreground");
    show("dialog_background");
    position_dialog()
}

function end_check_remaining(a) {
    show_dialog(ajax_decode(a))
}

function show_dialog(a) {
    "" != a && (html("dialog_text", a), hideSelectBoxes(), hideFlash(), show("dialog_foreground"), show("dialog_background"), position_dialog())
}

function hide_dialog() {
    showSelectBoxes();
    showFlash();
    hide("dialog_background");
    hide("dialog_foreground")
}

function position_dialog() {
    setProperty("dialog_background", "h", getProperty("", "py"));
    var a = round((getProperty("", "wx") - getProperty("dialog_foreground", "w")) / 2),
        d = round((getProperty("", "wy") - getProperty("dialog_foreground", "h")) / 2 + getProperty("", "sy"));
    setProperty("dialog_foreground", "x", a);
    setProperty("dialog_foreground", "y", d)
}

function common_dialog(a) {
    hideSelectBoxes();
    hideFlash();
    show("common_dialog_" + a, "block");
    show("common_dialog_bg", "block");
    position_common_dialog(a)
}

function hide_common_dialog() {
    showSelectBoxes();
    showFlash();
    hide("common_dialog_bg");
    for (var a = 0; 20 > a; a++) exists("common_dialog_" + a) && hide("common_dialog_" + a)
}

function position_common_dialog(a) {
    setProperty("common_dialog_bg", "h", getProperty("", "py"));
    var d = round((getProperty("", "wx") - getProperty("common_dialog_" + a, "w")) / 2),
        h = round((getProperty("", "wy") - getProperty("common_dialog_" + a, "h")) / 2 + getProperty("", "sy"));
    setProperty("common_dialog_" + a, "x", d);
    setProperty("common_dialog_" + a, "y", h)
}

function Foto_changer() {
    this.list = [];
    this.current = 0;
    this.target = "main_foto";
    this.next_foto = function () {
        this.current++;
        this.current >= this.list.length && (this.current = 0);
        this.show_foto(this.current)
    };
    this.show_foto = function (a) {
        this.current = a;
        img = ge(this.target);
        img.src = this.list[a][0];
        img.alt = this.list[a][1];
        img.title = this.list[a][1];
        for (var d = 0; d < this.list.length; d++) ge("product_thumb_cnt_" + d).className = "product_thumb";
        ge("product_thumb_cnt_" + a).className = "product_thumb act"
    };
    this.zoom_foto = function (a) {
        undef(a) &&
        (a = this.current);
        myLightbox.start(ge("lightboxlink" + a))
    }
}
document.onmousemove = mouseMove;
var larger_foto_visible = !1;

function show_larger_foto(a, d, h, c) {
    undef(h) && (h = "s");
    undef(c) && (c = "l");
    larger_foto_visible = !0;
    d = d.src.replace("/" + h + "/", "/" + c + "/");
    d = d.replace("/perziura/", "/" + c + "/");
    ge("larger_foto").src = d;
    show("larger_foto_container", "block");
    a = mousePos(a);
    set_larger_foto_position(a)
}

function mouseMove(a) {
    larger_foto_visible && (a = mousePos(a), set_larger_foto_position(a))
}

function set_larger_foto_position(a) {
    var d = ge("larger_foto_container");
    setProperty(d, "x", a[0] + 10);
    setProperty(d, "y", a[1] + 20);
    getProperty(d, "y") + getProperty(d, "h") > getProperty("", "sy") + getProperty("", "wy") && setProperty(d, "y", a[1] - 5 - getProperty(d, "h"))
}

function hide_larger_foto() {
    larger_foto_visible = !1;
    ge("larger_foto").src = "style/blank.gif";
    hide("larger_foto_container")
}

function goto_negotiate() {
    product_tab(4);
    var a = getProperty(ge("product_tab4"), "y");
    scrollpage(a - 30, 80, 15)
}

function filter_go() {
    window.location = filter_generate();
    return !1
}

function filter_generate() {
    var a = clean_url + "-filter_",
        d = filter_get_checked();
    filts1 = d[0];
    filts2 = d[1];
    for (d = 0; d < filts1.length; d++) {
        0 < d && (a += ";");
        for (var a = a + (filts1[d] + ":"), h = 0; h < filts2[d].length; h++) 0 < h && (a += ","), a += filter_encode(filts2[d][h])
    }
    return a
}

function filter_get_checked() {
    for (var a = [
        [],
        []
    ], d = -1, h = 0; h < filters1.length; h++) {
        vals = filters2[h];
        for (var c = -1, l = 0; l < filters2[h].length; l++) {
            var m = "filter_" + filters1[h] + "_" + filters2[h][l];
            exists(m) && ge(m).checked && (c++, 0 == c && (d++, a[1][d] = []), a[0][d] = filters1[h], a[1][d][c] = filters2[h][l])
        }
    }
    return a
}

function filter_generate_checked() {
    for (var a = 0; a < filters1.length; a++) {
        vals = filters2[a];
        for (var d = 0; d < filters2[a].length; d++) {
            var h = "filter_" + filters1[a] + "_" + filters2[a][d];
            exists(h) && (ge(h).checked = !1)
        }
    }
    for (a = 0; a < filters_checked.length; a++) h = "filter_" + filters_checked[a], exists(h) && (ge(h).checked = !0)
}

function filter_encode(a) {
    return a.replace("-", "~")
}

function save_subscription() {
    var a = ["save_subscription", gv("subscription_email")];
    ajax_siusti(["action", "email"], a, "ajax_interface.php", "saved_subscription")
}

function saved_subscription(a) {
    "OK" == parse_get(a).r ? (hide("news_header"), hide("news_error"), show("news_ok", "block")) : (hide("news_header"), hide("news_ok"), show("news_error", "block"))
}

function show_request() {
    show_dialog_common();
    hide("recommend_container");
    hide("negotiate_container");
    show("request_container", "block");
    hide("request_title2");
    hide("request_title3");
    show("request_title1", "block");
    position_dialog()
}

function show_recommend() {
    show_dialog_common();
    hide("request_container");
    hide("negotiate_container");
    show("recommend_container", "block");
    hide("request_title1");
    hide("request_title3");
    show("request_title2", "block");
    position_dialog()
}

function show_negotiate() {
    show_dialog_common();
    hide("recommend_container");
    hide("request_container");
    show("negotiate_container", "block");
    hide("request_title1");
    hide("request_title2");
    show("request_title3", "block");
    position_dialog()
}

function show_dialog_common() {
    hideSelectBoxes();
    hideFlash();
    show("dialog_foreground", "block");
    show("dialog_background", "block")
}

function hide_dialog() {
    showSelectBoxes();
    showFlash();
    hide("dialog_background");
    hide("dialog_foreground")
}

function position_dialog() {
    setProperty("dialog_background", "h", getProperty("", "py"));
    var a = round((getProperty("", "wx") - getProperty("dialog_foreground", "w")) / 2),
        d = round((getProperty("", "wy") - getProperty("dialog_foreground", "h")) / 2 + getProperty("", "sy"));
    setProperty("dialog_foreground", "x", a);
    setProperty("dialog_foreground", "y", d)
}

function more_categories(a) {
    hide("hlev_" + a + "_t");
    for (var d = 0; 100 > d && exists("hlev_" + a + "_" + d);) show("hlev_" + a + "_" + d, "block"), d++
}

function show_motive(a) {
    for (var d = 1; 100 > d && exists("motive_img" + d); d++) hide("motive_img" + d), ge("motive_dot" + d).src = "style/dot_w1.gif";
    show("motive_img" + a);
    ge("motive_dot" + a).src = "style/dot_w2.gif"
}

function change_top(a) {
    for (var d = 0; 100 > d && exists("top_dot" + d); d++) hide("top_img" + d), ge("top_dot" + d).src = "style/dot_w1.gif";
    show("top_img" + a);
    ge("top_dot" + a).src = "style/dot_w2.gif"
}

function show_product_descr() {
    product_tab(1);
    scrollpage(getProperty("product_tab_card_1", "y"), 60, 8)
}

function show_product_lease() {
    product_tab(4);
    scrollpage(getProperty("product_tab_card_4", "y"), 60, 8)
}

function write_product_comment() {
    product_tab(5);
    hide("kom_naujas_mgt");
    show("kom_naujas");
    scrollpage(getProperty("kom_naujas", "y") - 40, 60, 8)
}

function view_product_comments() {
    product_tab(5);
    scrollpage(getProperty("product_tab_card_5", "y") - 40, 60, 8)
}

function send_thoughts(a) {
    var d = gv("thoughts");
    ajax_siusti(["action", "t", "url", "lang"], ["send_thoughts", d, a, lang], "ajax_interface.php", "thoughts_sent", !1)
}

function thoughts_sent(a) {
    hide("thoughts_a1");
    hide("thoughts_a2");
    hide("thoughts_a3");
    hide("thoughts_a4");
    show("thoughts_b1", "block");
    show("thoughts_b2", "block")
}
var temp_id = "";

function rate_product(a, d) {
    temp_id = a;
    ajax_siusti(["action", "product_id", "rate"], ["rate_product", a, d], "ajax_interface.php", "product_rated")
}

function product_rated(a) {
    html("product_rate" + temp_id, ajax_decode(a))
}

function add_wishlist_comment() {
    hide("wishlist_add_comment");
    show("wishlist_comment1");
    show("wishlist_comment2")
}

function laikrodis(a, d) {
    var h = d - 1,
        c = Math.floor(h / 86400),
        h = h % 86400,
        l = Math.floor(h / 3600),
        h = h % 3600,
        m = Math.floor(h / 60),
        h = h % 60;
    1 == m.toString().length && (m = "0" + m);
    1 == h.toString().length && (h = "0" + h);
    str = 1 == c ? " diena " : " dienos ";
    $("#" + a).html(c + str + l + ":" + m + ":" + h);
    0 >= d ? $("#" + a).html("Laikas baigėsi") : (--d, setTimeout(function () {
            laikrodis(a, d)
        }, 1E3))
}

function amout(a, d, h) {
    "plus" == a ? (value = parseInt($("#quantity" + d).val()) + 1, value >= h && ($("#quantity" + d).val(value), change_cart_amount(d))) : (value = parseInt($("#quantity" + d).val()) - 1, 0 < value && value >= h && ($("#quantity" + d).val(value), change_cart_amount(d)))
};
var slidesCount = 10,
    slidesVisible = 10,
    leftSlideIndex = 0,
    sliderWidth = 0,
    slideWidth = 0,
    actualVisibleSlidesWidth = 0,
    minSlideWidth = 220,
    _historySlider, _historySliderInner, _historySlides, _leftArrow, _rightArrow, _historySlide;

function cacheVariables() {
    _historySlider = jQuery(".historySlider");
    _historySliderInner = jQuery(".historySliderInner");
    _historySlides = jQuery(".historySlides");
    _leftArrow = _historySlider.find(".arrowLeft");
    _rightArrow = _historySlider.find(".arrowRight");
    _historySlide = jQuery(".historySlide")
}

function setDynamicVars() {
    sliderWidth = jQuery(".historySlider").outerWidth();
    slidesVisible = Math.floor(sliderWidth / minSlideWidth);
    slideWidth = Math.floor(sliderWidth / slidesVisible);
    actualVisibleSlidesWidth = slideWidth * slidesVisible;
    _historySliderInner.width(actualVisibleSlidesWidth - 1);
    _historySlider.find(".arrowLeft").css("visibility", "hidden")
}

function setSlidesWidth() {
    _historySlide.width(slideWidth)
}

function debugOutput() {
    console.log("slidesCount=" + slidesCount);
    console.log("slidesVisible=" + slidesVisible);
    console.log("leftSlideIndex=" + leftSlideIndex);
    console.log("sliderWidth=" + sliderWidth);
    console.log("slideWidth=" + slideWidth);
    console.log("minSlideWidth=" + minSlideWidth)
}

function leftArrowClick() {
    var a = leftSlideIndex - 1;
    0 <= a && (changeLeftSlide(a), leftSlideIndex = a);
    0 == leftSlideIndex ? _historySlider.find(".arrowLeft").css("visibility", "hidden") : (_historySlider.find(".arrowLeft").css("visibility", "visible"), _historySlider.find(".arrowRight").css("visibility", "visible"))
}

function rightArrowClick() {
    var a = leftSlideIndex + 1,
        d = slidesCount - slidesVisible;
    a <= d && (changeLeftSlide(a), leftSlideIndex = a);
    d == leftSlideIndex ? _historySlider.find(".arrowRight").css("visibility", "hidden") : (_historySlider.find(".arrowLeft").css("visibility", "visible"), _historySlider.find(".arrowRight").css("visibility", "visible"))
}

function changeLeftSlide(a) {
    setTranslate3d(_historySlides, -1 * a * slideWidth, 0, 0)
}

function setTranslate3d(a, d, h, c) {
    a.css("transform", "translate3d(" + d + "px," + h + "px," + c + "px)");
    a.css("-ms-transform", "translate3d(" + d + "px," + h + "px," + c + "px)");
    a.css("-webkit-transform", "translate3d(" + d + "px," + h + "px," + c + "px)");
    a.css("-moz-transform", "translate3d(" + d + "px," + h + "px," + c + "px)")
}
jQuery(function () {
    cacheVariables();
    setDynamicVars();
    setSlidesWidth();
    _leftArrow.click(function () {
        leftArrowClick();
        return !1
    });
    _rightArrow.click(function () {
        rightArrowClick();
        return !1
    });
    jQuery(window).resize(function () {
        setDynamicVars();
        setSlidesWidth();
        leftSlideIndex = 0;
        changeLeftSlide(leftSlideIndex)
    })
});
!function (a) {
    var d, h, c, l = Math.max,
        m = Math.min;
    d = {};
    d.d = a(document);
    d.t = function (a) {
        return a.originalEvent.touches.length - 1
    };
    h = function () {
        var c = this;
        this.cv = this.v = this.g = this.i = this.$ = this.o = null;
        this.h = this.w = this.y = this.x = 0;
        this.c = this.$c = null;
        this.t = 0;
        this.isInit = !1;
        this.rH = this.eH = this.cH = this.dH = this.pColor = this.fgColor = null;
        this.scale = 1;
        this.relativeHeight = this.relativeWidth = this.relative = !1;
        this.$div = null;
        this.run = function () {
            var d = function (a, d) {
                for (var h in d) c.o[h] = d[h];
                c.init();
                c._configure()._draw()
            };
            if (!this.$.data("kontroled")) return this.$.data("kontroled", !0), this.extend(), this.o = a.extend({
                min: this.$.data("min") || 0,
                max: this.$.data("max") || 100,
                stopper: !0,
                readOnly: this.$.data("readonly") || "readonly" == this.$.attr("readonly"),
                cursor: !0 === this.$.data("cursor") && 30 || this.$.data("cursor") || 0,
                thickness: this.$.data("thickness") && Math.max(Math.min(this.$.data("thickness"), 1), .01) || .35,
                lineCap: this.$.data("linecap") || "butt",
                width: this.$.data("width") || 200,
                height: this.$.data("height") || 200,
                displayInput: null ==
                this.$.data("displayinput") || this.$.data("displayinput"),
                displayPrevious: this.$.data("displayprevious"),
                fgColor: this.$.data("fgcolor") || "#87CEEB",
                inputColor: this.$.data("inputcolor"),
                font: this.$.data("font") || "Arial",
                fontWeight: this.$.data("font-weight") || "bold",
                inline: !1,
                step: this.$.data("step") || 1,
                draw: null,
                change: null,
                cancel: null,
                release: null,
                error: null
            }, this.o), this.o.inputColor || (this.o.inputColor = this.o.fgColor), this.$.is("fieldset") ? (this.v = {}, this.i = this.$.find("input"), this.i.each(function (d) {
                    var h =
                        a(this);
                    c.i[d] = h;
                    c.v[d] = h.val();
                    h.bind("change keyup", function () {
                        var a = {};
                        a[d] = h.val();
                        c.val(a)
                    })
                }), this.$.find("legend").remove()) : (this.i = this.$, this.v = this.$.val(), "" == this.v && (this.v = this.o.min), this.$.bind("change keyup", function () {
                    c.val(c._validate(c.$.val()))
                })), !this.o.displayInput && this.$.hide(), this.$c = a(document.createElement("canvas")), "undefined" != typeof G_vmlCanvasManager && G_vmlCanvasManager.initElement(this.$c[0]), this.c = this.$c[0].getContext ? this.$c[0].getContext("2d") : null, this.c ?
                (this.scale = (window.devicePixelRatio || 1) / (this.c.webkitBackingStorePixelRatio || this.c.mozBackingStorePixelRatio || this.c.msBackingStorePixelRatio || this.c.oBackingStorePixelRatio || this.c.backingStorePixelRatio || 1), this.relativeWidth = 0 !== this.o.width % 1 && this.o.width.indexOf("%"), this.relativeHeight = 0 !== this.o.height % 1 && this.o.height.indexOf("%"), this.relative = this.relativeWidth || this.relativeHeight, this.$div = a('<div style="' + (this.o.inline ? "display:inline-block;" : "") + '"></div>'), this.$.wrap(this.$div).before(this.$c),
                    this.$div = this.$.parent(), this._carve(), this.v instanceof Object ? (this.cv = {}, this.copy(this.v, this.cv)) : this.cv = this.v, this.$.bind("configure", d).parent().bind("configure", d), this._listen()._configure()._xy().init(), this.isInit = !0, this._draw(), this) : void(this.o.error && this.o.error())
        };
        this._carve = function () {
            if (this.relative) {
                var a = this.relativeWidth ? this.$div.parent().width() * parseInt(this.o.width) / 100 : this.$div.parent().width(),
                    c = this.relativeHeight ? this.$div.parent().height() * parseInt(this.o.height) /
                        100 : this.$div.parent().height();
                this.w = this.h = Math.min(a, c)
            } else this.w = this.o.width, this.h = this.o.height;
            return this.$div.css({
                width: this.w + "px",
                height: this.h + "px"
            }), this.$c.attr({
                width: this.w,
                height: this.h
            }), 1 !== this.scale && (this.$c[0].width *= this.scale, this.$c[0].height *= this.scale, this.$c.width(this.w), this.$c.height(this.h)), this
        };
        this._draw = function () {
            var a = !0;
            c.g = c.c;
            c.clear();
            c.dH && (a = c.dH());
            !1 !== a && c.draw()
        };
        this._touch = function (a) {
            var h = function (a) {
                a = c.xy2val(a.originalEvent.touches[c.t].pageX,
                    a.originalEvent.touches[c.t].pageY);
                c.change(c._validate(a));
                c._draw()
            };
            return this.t = d.t(a), h(a), d.d.bind("touchmove.k", h).bind("touchend.k", function () {
                d.d.unbind("touchmove.k touchend.k");
                c.rH && !1 === c.rH(c.cv) || c.val(c.cv)
            }), this
        };
        this._mouse = function (a) {
            var h = function (a) {
                a = c.xy2val(a.pageX, a.pageY);
                c.change(c._validate(a));
                c._draw()
            };
            return h(a), d.d.bind("mousemove.k", h).bind("keyup.k", function (a) {
                27 !== a.keyCode || (d.d.unbind("mouseup.k mousemove.k keyup.k"), c.eH && !1 === c.eH()) || c.cancel()
            }).bind("mouseup.k",
                function (a) {
                    d.d.unbind("mousemove.k mouseup.k keyup.k");
                    c.rH && !1 === c.rH(c.cv) || c.val(c.cv)
                }), this
        };
        this._xy = function () {
            var a = this.$c.offset();
            return this.x = a.left, this.y = a.top, this
        };
        this._listen = function () {
            return this.o.readOnly ? this.$.attr("readonly", "readonly") : (this.$c.bind("mousedown", function (a) {
                    a.preventDefault();
                    c._xy()._mouse(a)
                }).bind("touchstart", function (a) {
                    a.preventDefault();
                    c._xy()._touch(a)
                }), this.listen()), this.relative && a(window).resize(function () {
                c._carve().init();
                c._draw()
            }), this
        };
        this._configure = function () {
            return this.o.draw && (this.dH = this.o.draw), this.o.change && (this.cH = this.o.change), this.o.cancel && (this.eH = this.o.cancel), this.o.release && (this.rH = this.o.release), this.o.displayPrevious ? (this.pColor = this.h2rgba(this.o.fgColor, "0.4"), this.fgColor = this.h2rgba(this.o.fgColor, "0.6")) : this.fgColor = this.o.fgColor, this
        };
        this._clear = function () {
            this.$c[0].width = this.$c[0].width
        };
        this._validate = function (a) {
            return ~~((0 > a ? -.5 : .5) + a / this.o.step) * this.o.step
        };
        this.listen = function () {
        };
        this.extend =
            function () {
            };
        this.init = function () {
        };
        this.change = function (a) {
        };
        this.val = function (a) {
        };
        this.xy2val = function (a, c) {
        };
        this.draw = function () {
        };
        this.clear = function () {
            this._clear()
        };
        this.h2rgba = function (a, c) {
            var d;
            return a = a.substring(1, 7), d = [parseInt(a.substring(0, 2), 16), parseInt(a.substring(2, 4), 16), parseInt(a.substring(4, 6), 16)], "rgba(" + d[0] + "," + d[1] + "," + d[2] + "," + c + ")"
        };
        this.copy = function (a, c) {
            for (var d in a) c[d] = a[d]
        }
    };
    c = function () {
        h.call(this);
        this.w2 = this.cursorExt = this.lineWidth = this.radius = this.xy =
            this.startAngle = null;
        this.PI2 = 2 * Math.PI;
        this.extend = function () {
            this.o = a.extend({
                bgColor: this.$.data("bgcolor") || "#EEEEEE",
                angleOffset: this.$.data("angleoffset") || 0,
                angleArc: this.$.data("anglearc") || 360,
                inline: !0
            }, this.o)
        };
        this.val = function (a) {
            if (null == a) return this.v;
            a = this.o.stopper ? l(m(a, this.o.max), this.o.min) : a;
            a != this.cv && this.cH && !1 === this.cH(this.cv) || (this.v = this.cv = a, this.$.val(this.v), this._draw())
        };
        this.xy2val = function (a, c) {
            var d, h;
            return d = Math.atan2(a - (this.x + this.w2), -(c - this.y - this.w2)) -
                this.angleOffset, this.angleArc != this.PI2 && 0 > d && -.5 < d ? d = 0 : 0 > d && (d += this.PI2), h = ~~(.5 + d * (this.o.max - this.o.min) / this.angleArc) + this.o.min, this.o.stopper && (h = l(m(h, this.o.max), this.o.min)), h
        };
        this.listen = function () {
            var c, d, h = this,
                v = function (a) {
                    a.preventDefault();
                    var c = a.originalEvent;
                    a = c.detail || c.wheelDeltaX;
                    c = c.detail || c.wheelDeltaY;
                    a = parseInt(h.$.val()) + (0 < a || 0 < c ? h.o.step : 0 > a || 0 > c ? -h.o.step : 0);
                    h.val(a)
                },
                u = 1,
                x = {
                    37: -h.o.step,
                    38: h.o.step,
                    39: h.o.step,
                    40: -h.o.step
                };
            this.$.bind("keydown", function (v) {
                var t =
                    v.keyCode;
                if (96 <= t && 105 >= t && (t = v.keyCode = t - 48), c = parseInt(String.fromCharCode(t)), isNaN(c) && (13 !== t && 8 !== t && 9 !== t && 189 !== t && v.preventDefault(), -1 < a.inArray(t, [37, 38, 39, 40]))) v.preventDefault(), v = parseInt(h.$.val()) + x[t] * u, h.o.stopper && (v = l(m(v, h.o.max), h.o.min)), h.change(v), h._draw(), d = window.setTimeout(function () {
                    u *= 2
                }, 30)
            }).bind("keyup", function (a) {
                isNaN(c) ? d && (window.clearTimeout(d), d = null, u = 1, h.val(h.$.val())) : h.$.val() > h.o.max && h.$.val(h.o.max) || h.$.val() < h.o.min && h.$.val(h.o.min)
            });
            this.$c.bind("mousewheel DOMMouseScroll",
                v);
            this.$.bind("mousewheel DOMMouseScroll", v)
        };
        this.init = function () {
            (this.v < this.o.min || this.v > this.o.max) && (this.v = this.o.min);
            this.$.val(this.v);
            this.w2 = this.w / 2;
            this.cursorExt = this.o.cursor / 100;
            this.xy = this.w2 * this.scale;
            this.lineWidth = this.xy * this.o.thickness;
            this.lineCap = this.o.lineCap;
            this.radius = this.xy - this.lineWidth / 2;
            this.o.angleOffset && (this.o.angleOffset = isNaN(this.o.angleOffset) ? 0 : this.o.angleOffset);
            this.o.angleArc && (this.o.angleArc = isNaN(this.o.angleArc) ? this.PI2 : this.o.angleArc);
            this.angleOffset =
                this.o.angleOffset * Math.PI / 180;
            this.angleArc = this.o.angleArc * Math.PI / 180;
            this.startAngle = 1.5 * Math.PI + this.angleOffset;
            this.endAngle = 1.5 * Math.PI + this.angleOffset + this.angleArc;
            var a = l(String(Math.abs(this.o.max)).length, String(Math.abs(this.o.min)).length, 2) + 2;
            this.o.displayInput && this.i.css({
                width: (this.w / 2 + 4 >> 0) + "px",
                height: (this.w / 3 >> 0) + "px",
                position: "absolute",
                "vertical-align": "middle",
                "margin-top": (this.w / 3 >> 0) + "px",
                "margin-left": "-" + (3 * this.w / 4 + 2 >> 0) + "px",
                border: 0,
                background: "none",
                font: this.o.fontWeight +
                " " + (this.w / a >> 0) + "px " + this.o.font,
                "text-align": "center",
                color: this.o.inputColor || this.o.fgColor,
                padding: "0px",
                "-webkit-appearance": "none"
            }) || this.i.css({
                width: "0px",
                visibility: "hidden"
            })
        };
        this.change = function (a) {
            a != this.cv && (this.cv = a, this.cH && !1 === this.cH(a))
        };
        this.angle = function (a) {
            return (a - this.o.min) * this.angleArc / (this.o.max - this.o.min)
        };
        this.draw = function () {
            var a, c, d = this.g,
                h = this.angle(this.cv),
                l = this.startAngle,
                h = l + h,
                m = 1;
            d.lineWidth = this.lineWidth;
            d.lineCap = this.lineCap;
            this.o.cursor && (l =
                h - this.cursorExt) && (h += this.cursorExt);
            d.beginPath();
            d.strokeStyle = this.o.bgColor;
            d.arc(this.xy, this.xy, this.radius, this.endAngle - 1E-5, this.startAngle + 1E-5, !0);
            d.stroke();
            this.o.displayPrevious && (c = this.startAngle + this.angle(this.v), a = this.startAngle, this.o.cursor && (a = c - this.cursorExt) && (c += this.cursorExt), d.beginPath(), d.strokeStyle = this.pColor, d.arc(this.xy, this.xy, this.radius, a - 1E-5, c + 1E-5, !1), d.stroke(), m = this.cv == this.v);
            d.beginPath();
            d.strokeStyle = m ? this.o.fgColor : this.fgColor;
            d.arc(this.xy,
                this.xy, this.radius, l - 1E-5, h + 1E-5, !1);
            d.stroke()
        };
        this.cancel = function () {
            this.val(this.v)
        }
    };
    a.fn.dial = a.fn.knob = function (d) {
        return this.each(function () {
            var h = new c;
            h.o = d;
            h.$ = a(this);
            h.run()
        }).parent()
    }
}(jQuery);
$(document).ready(function () {
    $(".num").knob({
        min: 0,
        max: 100,
        step: 1,
        angleOffset: 0,
        angleArc: 360,
        stopper: !0,
        readOnly: !1,
        cursor: !1,
        lineCap: "butt",
        thickness: "0.05",
        width: 137,
        height: 137,
        displayInput: !0,
        displayPrevious: !0,
        fgColor: "#80AD00",
        inputColor: "#0E4145",
        font: "Arial",
        fontWeight: "normal",
        bgColor: "#80ad00",
        readOnly: !0,
        draw: function () {
            $(this.i).css({
                "font-size": "22px",
                "margin-top": "30px"
            });
            0 == $(this.i).val() && $(this.i).val(this.cv + "%")
        }
    });
    $(window).scroll(function () {
    });
    $(document).ready(function () {
    })
});
(function (a) {
    "function" === typeof define && define.amd ? define(["jquery"], a) : a(jQuery)
})(function (a) {
    a.fn.addBack = a.fn.addBack || a.fn.andSelf;
    a.fn.extend({
        actual: function (d, h) {
            if (!this[d]) throw '$.actual => The jQuery method "' + d + '" you called does not exist';
            var c = a.extend({
                    absolute: !1,
                    clone: !1,
                    includeMargin: !1,
                    display: "block"
                }, h),
                l = this.eq(0),
                m, g;
            if (!0 === c.clone) m = function () {
                l = l.clone().attr("style", "position: absolute !important; top: -1000 !important; ").appendTo("body")
            }, g = function () {
                l.remove()
            };
            else {
                var n = [],
                    q = "",
                    v;
                m = function () {
                    v = l.parents().addBack().filter(":hidden");
                    q += "visibility: hidden !important; display: " + c.display + " !important; ";
                    !0 === c.absolute && (q += "position: absolute !important; ");
                    v.each(function () {
                        var c = a(this),
                            d = c.attr("style");
                        n.push(d);
                        c.attr("style", d ? d + ";" + q : q)
                    })
                };
                g = function () {
                    v.each(function (c) {
                        var d = a(this);
                        c = n[c];
                        void 0 === c ? d.removeAttr("style") : d.attr("style", c)
                    })
                }
            }
            m();
            m = /(outer)/.test(d) ? l[d](c.includeMargin) : l[d]();
            g();
            return m
        }
    })
});

function resizeBlocks(a) {
    var d = Math.max.apply(null, $(a).map(function () {
        return $(this).height()
    }).get());
    $(a).height(d)
}
$(document).ready(function () {
    $(".dialog-tabs .nav a").on("click", function (a) {
        a.preventDefault();
        a = $(this).attr("data-href");
        $(".dialog-tabs .nav li").removeClass("active");
        $(this).parent().addClass("active");
        $(".dialog-tabs .tab-pane").hide().removeClass("active");
        $(".dialog-tabs .tab-pane" + a).addClass("active").show()
    });
    var a = {
        backdrop: "static"
    };
    if (0 < $(".register-save").length) {
        $(".login-dialog").modal(a);
        var d = $(".dialog-tabs .nav li:last a").attr("data-href");
        $(".dialog-tabs .nav li").removeClass("active");
        $(".dialog-tabs .nav li:last").addClass("active");
        $(".dialog-tabs .tab-pane").hide().removeClass("active");
        $(".dialog-tabs .tab-pane" + d).addClass("active").show()
    }
    0 < $(".register-errors").length && ($(".login-dialog").modal(a), d = $(".dialog-tabs .nav li:last a").attr("data-href"), $(".dialog-tabs .nav li").removeClass("active"), $(".dialog-tabs .nav li:last").addClass("active"), $(".dialog-tabs .tab-pane").hide().removeClass("active"), $(".dialog-tabs .tab-pane" + d).addClass("active").show());
    0 < $("login-errors").length &&
    $(".login-dialog").modal(a)
});
$(document).ready(function () {
    var a = !1;
    $(".important-message-trigger").on("click", function () {
        a ? ($(".important-message .inside").animate({
                "margin-bottom": -300
            }, 1E3), a = !1) : ($(".important-message .inside").animate({
                "margin-bottom": 40
            }, 1E3), a = !0)
    });
    $(".important-message .inside .minimize").on("click", function () {
        a ? ($(".important-message .inside").animate({
                "margin-bottom": -300
            }, 1E3), a = !1) : ($(".important-message .inside").animate({
                "margin-bottom": 40
            }, 1E3), a = !0)
    })
});
$(document).ready(function () {
    $("#top_line").each(function () {
        var a = $(this),
            d = a.find(".bubble"),
            h = a.find(".slide"),
            g = null;
        a.on("click", ".bubble", function () {
            clearTimeout(g);
            var a = d.index(this);
            d.removeClass("sel").eq(a).addClass("sel");
            h.removeClass("active").eq(a).addClass("active");
            ++a >= d.length && (a = 0);
            g = setTimeout(function () {
                d.eq(a).click()
            }, 1E3 * (h.eq(a).data("delay") || 6));
            return !1
        });
        d.eq(0).click()
    });
    $(window).load(function () {
        block_height = $(".our_categories").height() + 80;
        0 < $(".svg-border").length &&
        intro_bubble(0)
    });
    var a = !1;
    jQuery(".readMoreButton").click(function () {
        if (a) $(".readMoreBlocks").css("max-height", "402px"), $(".readMoreBlocks").css("margin-bottom", "20px"), a = !1, $(this).find("span.read-less").fadeOut("normal", function () {
            $(".readMoreButton span.read-more").fadeIn("normal")
        });
        else {
            var c = $(".readMoreBlocks .block").first().height() + 30;
            $(".readMoreBlocks").css("max-height", c);
            $(".readMoreBlocks").css("margin-bottom", "0");
            a = !0;
            $(this).find("span.read-more").fadeOut("normal", function () {
                $(".readMoreButton span.read-less").fadeIn("normal")
            })
        }
    });
    var d = !1;
    jQuery(".readMoreButtonFAQ").click(function () {
        if (d) $(".readMoreBlocksFAQ").css("max-height", "94px"), $(".readMoreBlocksFAQ").css("margin-bottom", "20px"), d = !1, $(this).find("span.read-less").fadeOut("normal", function () {
            $(".readMoreButtonFAQ span.read-more").fadeIn("normal")
        });
        else {
            var a = Math.max.apply(null, $(".readMoreBlocksFAQ .question").map(function () {
                return $(this).height()
            }).get());
            $(".readMoreBlocksFAQ").css("max-height", a);
            $(".readMoreBlocksFAQ").css("margin-bottom", "0");
            d = !0;
            $(this).find("span.read-more").fadeOut("normal",
                function () {
                    $(".readMoreButtonFAQ span.read-less").fadeIn("normal")
                })
        }
    });
    if (0 < $(".testimonial-carousel-control").length) {
        var h = $("div.item").map(function () {
                return $(this).innerHeight()
            }).get(),
            h = Math.max.apply(null, h);
        $(".carousel-inner").height(h + 50);
        $(window).resize(function () {
            var a = $("div.item").map(function () {
                    return $(this).innerHeight()
                }).get(),
                a = Math.max.apply(null, a);
            $(".carousel-inner").height(a + 50)
        })
    }
    0 < $(".shopping #scroll-container").length && $(".shopping #scroll-container").customScrollbar({
        skin: "endoca-skin",
        hScroll: !1,
        updateOnWindowResize: !0
    });
    0 < $(".shopping #scroll-container").length && $(".shopping #scroll-container").customScrollbar({
        skin: "endoca-skin",
        hScroll: !1,
        updateOnWindowResize: !0
    })
});
var block_height;

function find_out_more(a) {
    var d = jQuery("#our_intro_categories");
    if (d.length) {
        var h = 300;
        $(document).scrollTop() + 92 == d.offset().top && (h = 1);
        jQuery("html, body").animate({
            scrollTop: d.offset().top - 92
        }, h, function () {
            $(".our_categories").css("overflow", "hidden");
            $("#intro_product_" + a).css("top", block_height + 40);
            $("#intro_product_" + a).show();
            $(".our_categories").animate({
                height: $("#intro_product_" + a).outerHeight(!0) - 10
            }, 300, function () {
                $("#intro_product_" + a).animate({
                    top: -40
                }, 300, function () {
                })
            })
        })
    }
}

function close_more(a) {
    $(".our_categories").css("overflow", "hidden");
    $("#intro_product_" + a).css("top", -40);
    $("#intro_product_" + a).show();
    $(".our_categories").height("auto");
    $("#intro_product_" + a).animate({
        top: block_height + 40
    }, 500, function () {
        $(this).hide()
    })
}

function change_order_company() {
    ge("company1").checked ? $("#company_blocks").show() : $("#company_blocks").hide()
}

function submenu(a) {
    "block" == ge("submenu" + a).style.display ? ($("#submenu" + a).hide(), $("#submenu_arrow" + a).hide()) : ($(".dropdown-menu").hide(), $("#submenu" + a).show(), $(".hover-arrow").hide(), $("#submenu_arrow" + a).show())
};

$(function () {
    var a = $("#product").find("a.item_image");
    a.length && a.fancybox();
});

function loadingPush(a) {
    0 < loadingPush.stack++ || $('<div class="loading"></div>').hide().appendTo(a.parent()).css({
        position: "absolute",
        zIndex: 999,
        top: a.position().top + "px",
        left: a.position().left + "px",
        width: a.outerWidth(!0) + "px",
        height: a.outerHeight(!0) + "px"
    }).fadeIn("fast")
}

function loadingPop(a) {
    0 < --loadingPush.stack || a.siblings(".loading").fadeOut("fast", function () {
        $(this).remove()
    })
};
/*(function (a) {
    a(function () {
        a(".checkout-step").each(function () {
            var d = a(this).children(),
                h = a("#main"),
                c = a(".checkout-address.shipping"),
                l = a(".shipping-method"),
                m = a(".checkout-address.billing"),
                g = a(".payment-method"),
                n = a(".order-summary"),
                q = a("body._checkout").length ? 0 == a(".box.shipping-method").length || location.href.match(/\?.*action=payment/) ? 2 : 1 : 0,
                v = function (c) {
                    void 0 !== c.shippingAddressHtml && a('select[name="shipping_address"]').html(c.shippingAddressHtml).trigger("update.comboStyle");
                    void 0 !== c.billingAddressHtml &&
                    a('select[name="billing_address"]').html(c.billingAddressHtml).trigger("update.comboStyle");
                    void 0 !== c.shippingHtml && l.html(c.shippingHtml);
                    void 0 !== c.paymentHtml && g.html(c.paymentHtml);
                    void 0 !== c.summaryHtml && n.html(c.summaryHtml);
                    u();
                    loadingPop(h)
                },
                u = function () {
                    d.each(function (c) {
                        c < q + 1 ? a(this).addClass("active") : a(this).removeClass("active")
                    });
                    1 == q ? (c.removeClass("hidden").find(".address_form").addClass("hidden"), 0 < a('select[name="shipping_address"]').val() ? l.removeClass("hidden") : l.addClass("hidden")) :
                        (c.addClass("hidden"), l.addClass("hidden"));
                    2 == q ? (m.removeClass("hidden").find(".address_form").addClass("hidden"), 0 < a('select[name="billing_address"]').val() ? g.removeClass("hidden") : g.addClass("hidden")) : (m.addClass("hidden"), g.addClass("hidden"))
                };
            u();
            a("body").on("click", "a.shipping_new", function () {
                var c = a(this).closest(".checkout-address");
                c.find(".address_form").removeClass("hidden");
                c.find("form :input").val("").change();
                c.find('form :input[name="type"]').val("shipping");
                return !1
            }).on("click",
                "a.shipping_edit",
                function () {
                    var c = a(this).closest(".checkout-address"),
                        d = c.find('select[name="shipping_address"]').val(),
                        g = c.find('select[name="shipping_address"]').find("option:selected");
                    c.find(".address_form").removeClass("hidden");
                    c.find('form :input[name="id"]').val(d);
                    c.find('form :input[name="type"]').val("shipping");
                    c.find('form :input[name="address_firstname"]').val(g.data("fn"));
                    c.find('form :input[name="address_lastname"]').val(g.data("ln"));
                    c.find('form :input[name="address_company"]').val(g.data("cn"));
                    c.find('form :input[name="address_address"]').val(g.data("ad"));
                    c.find('form :input[name="address_city"]').val(g.data("ci"));
                    c.find('form :input[name="address_zip"]').val(g.data("zi"));
                    c.find('form :input[name="address_country"]').val(g.data("co")).change();
                    c.find('form :input[name="address_state"]').val(g.data("st")).change();
                    c.find('form :input[name="address_phone"]').val(g.data("ph"));
                    c.find('form :input[name="address_email"]').val(g.data("em"));
                    return !1
                }).on("change", 'select[name="shipping_address"]',
                function () {
                    a(this);
                    loadingPush(h);
                    a.getJSON(WEB_ROOT + "checkout", {
                        action: "shippingAddress",
                        id: a(this).val()
                    }, v)
                }).on("change", ':input[name="shipping-method"]', function () {
                var c = a(':input[name="shipping-method"]:checked');
                loadingPush(h);
                a.getJSON(WEB_ROOT + "checkout", {
                    action: "shippingMethod",
                    id: c.val()
                }, v)
            }).on("submit", "form._address", function () {
                var c = a(this);
                loadingPush(h);
                c.ajaxSubmit({
                    success: function (a) {
                        "object" == typeof a ? v(a) : (c.html(a.replace(/(^<form[^>]+>|<\/form>$)/gi, "")).trigger("purl-form-init"),
                                loadingPop(h))
                    }
                });
                return !1
            }).on("change", 'select[name="billing_address"]', function () {
                a(this);
                loadingPush(h);
                a.getJSON(WEB_ROOT + "checkout", {
                    action: "billingAddress",
                    id: a(this).val()
                }, v)
            }).on("click", "a.billing_new", function () {
                var c = a(this).closest(".checkout-address");
                c.find(".address_form").removeClass("hidden");
                c.find("form :input").val("").change();
                c.find('form :input[name="type"]').val("billing");
                return !1
            }).on("click", "a.billing_edit", function () {
                var c = a(this).closest(".checkout-address"),
                    d = c.find('select[name="billing_address"]').val(),
                    g = c.find('select[name="billing_address"]').find("option:selected");
                c.find(".address_form").removeClass("hidden");
                c.find('form :input[name="id"]').val(d);
                c.find('form :input[name="type"]').val("billing");
                c.find('form :input[name="address_firstname"]').val(g.data("fn"));
                c.find('form :input[name="address_lastname"]').val(g.data("ln"));
                c.find('form :input[name="address_company"]').val(g.data("cn"));
                c.find('form :input[name="address_address"]').val(g.data("ad"));
                c.find('form :input[name="address_city"]').val(g.data("ci"));
                c.find('form :input[name="address_zip"]').val(g.data("zi"));
                c.find('form :input[name="address_country"]').val(g.data("co")).change();
                c.find('form :input[name="address_state"]').val(g.data("st")).change();
                c.find('form :input[name="address_phone"]').val(g.data("ph"));
                c.find('form :input[name="address_email"]').val(g.data("em"));
                return !1
            }).on("click", ".checkout-buttons .continue", function () {
                if (1 == q) {
                    if (0 < a(".box.shipping-method").length && !a(':input[name="shipping-method"]:checked').val() && !a(':input[type="hidden"][name="shipping-method"]').val()) {
                        alert(a(this).data("msg-select-shipping"));
                        return
                    }
                    q++;
                    u()
                } else if (2 == q) {
                    if (!a(':input[name="payment-method"]:checked').val()) {
                        alert(a(this).data("msg-select-payment"));
                        return
                    }
                    a(this).hide();
                    a("form._payment").submit()
                }
                return !1
            }).on("change", ':input[name="payment-method"]', function () {
                a("ul.payment-methods>li").removeClass("selected");
                a('ul.payment-methods :input[name="payment-method"]:checked').closest("li").addClass("selected")
            });
            a(".column-main").addClass("animate")
        });
        a(".checkout-address select").trigger("update.comboStyle");
        a(document).on("click",
            "#account_container a.button.show-comment",
            function () {
                a(this).closest(".history-entry").toggleClass("show-comment");
                return !1
            })
    })
})(jQuery);*/

$(function () {
    var a;
    $(document).on("click", ".amount .plus, .amount .minus", function (c) {
        c = $(this);
        var d = c.closest(".amount").find(":input");
        c = c.hasClass("plus") ? 1 : -1;
        d.val(parseInt(d.val() || 0) + c);
        clearTimeout(a);
        a = setTimeout(function () {
            d.trigger("change")
        }, 500);
        return !1
    });
	/*
    $(".shopping-cart.cart_block").on("change", '.amount input, :input[name^="autoship["]', function () {
        $(this).closest("form").submit()
    }).on("submit", "form", function () {
        $(this).ajaxSubmit({
            success: function (a) {
                cartUpdateCB(a)
            }
        });
        return !1
    });
    if ("#show-login" == location.hash) $("button.login").click();
    else {
        var d = $(".modal.login-dialog");
        d.find(".message-stack").each(function () {
            $("button.login").click();
            var a = d.find(".tab-pane").index($(this).closest(".tab-pane"));
            d.find(".nav-tabs a").eq(a).click()
        })
    }
   
    $(document).on("purl-form-init", function (a) {
        $(":checkbox, :radio", a.target).trigger("change.checked-label")
    }).find("form").trigger("purl-form-init").end().find(".frm_select>select").trigger("update.comboStyle").end().on("click", "a.scroll", function () {
        var a =
            $($(this).attr("href").replace(/^.*#/, "#"));
        $("html,body").animate({
            scrollTop: a.offset().top - 30 + "px"
        });
        return !1
    }).on("click", "#account_container a.button.show-comment", function () {
        $(this).closest(".history-entry").toggleClass("show-comment");
        return !1
    }).on("submit", '.product-info form[name="buy"]', function () {
        var a = $(this);
        productBuy(a.find(':input[name="id"]').val(), a.find(':input[name="qty"]').val(), 0 < a.find(':input[name="recurring"]:checked').val() ? a.find(':input[name="recurring_days"]').val() : 0);
        return !1
    }).on("change.autoship", '.as-widget-checkbox-wrapper :input[name="recurring"]', function () {
        0 < $('.as-widget-checkbox-wrapper :input[name="recurring"]:checked').val() ? $(".as-selector-wrapper").show() : $(".as-selector-wrapper").hide()
    }).find('.as-widget-checkbox-wrapper :input[name="recurring"]').trigger("change.autoship").end().on("click", ".navbar-nav>li>a .show-hide", function () {
        $(this).closest("li").toggleClass("open");
        return !1
    }).on("click", "a.direct-contact", function () {
        var a = $(this),
            c = $("body"),
            d = a.data("contact-popup") || a.closest(".box").find(".contact-direct-popup").appendTo(c);
        a.data("contact-popup", d);
        c.addClass("popup-visible");
        $(".contact-direct-popup").removeClass("visible");
        setTimeout(function () {
            d.addClass("visible")
        }, 100);
        return !1
    }).on("click", ".contact-direct-popup", function (a) {
        var c = $(this);
        if (a.target == this || a.target == c.children(".wrap")[0]) c.removeClass("visible"), $("body").removeClass("popup-visible")
    }).on("submit", ".contact-direct-popup form", function (a) {
        a = $(this);
        var c = a.closest(".contact-form");
        loadingPush(c);
        a.ajaxSubmit({
            success: function (a) {
                c.html(a);
                loadingPop(c)
            }
        });
        return !1
    }).on("submit", "#footer form._newsletter", function (a) {
        var c = $(this);
        loadingPush(c);
        c.ajaxSubmit({
            success: function (a) {
                c.html(a);
                loadingPop(c)
            }
        });
        return !1
    });
    */
    $("a.youtube-video").fancybox({
        padding: 0,
        autoScale: !1,
        transitionIn: "none",
        transitionOut: "none",
        width: 640,
        height: 385,
        type: "iframe",
        swf: {
            wmode: "transparent",
            allowfullscreen: "true"
        }
    });
    var h = $("#stickyNavigationContainer"),
        c = $(".box.product-categories"),
        l = $(".navbar-nav>li>.dropdown-menu.fixed"),
        m = $("#sidebar"),
        g = m.length ? m.offset().top : 0;
    $(window).on("ready scroll resize", function (a) {
        if (a.target == window || a.target == document) c.length ? 400 < $(window).scrollTop() ? c.addClass("show-category-float") : c.removeClass("show-category-float") : l.length || (h.length && 200 < $(window).scrollTop() ? h.addClass("navigation").removeClass("navigationIndex") : h.removeClass("navigation").addClass("navigationIndex")), m.length && ($(window).scrollTop() > g ? (a = m.outerHeight() + 80 + $("#footer").outerHeight(), a = Math.min(0, $("body").height() -
                a - $(window).scrollTop()), m.css({
                width: m.width() + "px",
                top: a + "px"
            }).addClass("sticky")) : m.css({
                width: "auto",
                top: "0"
            }).removeClass("sticky"))
    });
    $(".box.tab-menu").each(function () {
        var a = $(this).children("a"),
            c = $(".box.tab-content");
        a.click(function () {
            var d = $(this);
            a.removeClass("active");
            c.removeClass("visible");
            d.addClass("active");
            $(d.attr("href")).addClass("visible");
            return !1
        }).eq(0).click()
    });
    $("#sidecart_contents").each(function () {
        $(".product").draggable({
            scroll: !1,
            helper: "clone"
        });
        $(this).droppable({
            activeClass: "ui-state-default",
            hoverClass: "ui-state-hover",
            accept: ":not(.ui-sortable-helper)",
            drop: function (a, c) {
                c.draggable.find(".add-basket").trigger("click")
            }
        })
    });
    $("div.batch-container").each(function () {
        var a = $(this),
            c = a.find(".menu a");
        a.on("click", ".menu a", function () {
            c.removeClass("sel");
            $(this).addClass("sel");
            a.find(".group").removeClass("sel").eq(c.index(this)).addClass("sel");
            return !1
        });
        c.eq(0).click()
    })
});