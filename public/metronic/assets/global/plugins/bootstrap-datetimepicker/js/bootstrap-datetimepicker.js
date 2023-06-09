!(function (t) {
    function e() {
        return new Date(Date.UTC.apply(Date, arguments));
    }
    var i = function (e, i) {
        var a = this;
        (this.element = t(e)),
            (this.language = i.language || this.element.data("date-language") || "en"),
            (this.language = this.language in n ? this.language : "en"),
            (this.isRTL = n[this.language].rtl || "rtl" == t("body").css("direction")),
            (this.formatType = i.formatType || this.element.data("format-type") || "standard"),
            (this.format = s.parseFormat(i.format || this.element.data("date-format") || n[this.language].format || s.getDefaultFormat(this.formatType, "input"), this.formatType)),
            (this.isInline = !1),
            (this.isVisible = !1),
            (this.isInput = this.element.is("input")),
            (this.component = this.element.is(".date") ? this.element.find(".date-set").parent() : !1),
            (this.componentReset = this.element.is(".date") ? this.element.find(".date-reset").parent() : !1),
            (this.hasInput = this.component && this.element.find("input").length),
            this.component && 0 === this.component.length && (this.component = !1),
            (this.linkField = i.linkField || this.element.data("link-field") || !1),
            (this.linkFormat = s.parseFormat(i.linkFormat || this.element.data("link-format") || s.getDefaultFormat(this.formatType, "link"), this.formatType)),
            (this.minuteStep = i.minuteStep || this.element.data("minute-step") || 5),
            (this.pickerPosition = i.pickerPosition || this.element.data("picker-position") || "bottom-right"),
            (this.showMeridian = i.showMeridian || this.element.data("show-meridian") || !1),
            (this.initialDate = i.initialDate || new Date()),
            this._attachEvents(),
            (this.formatViewType = "datetime"),
            "formatViewType" in i ? (this.formatViewType = i.formatViewType) : "formatViewType" in this.element.data() && (this.formatViewType = this.element.data("formatViewType")),
            (this.minView = 0),
            "minView" in i ? (this.minView = i.minView) : "minView" in this.element.data() && (this.minView = this.element.data("min-view")),
            (this.minView = s.convertViewMode(this.minView)),
            (this.maxView = s.modes.length - 1),
            "maxView" in i ? (this.maxView = i.maxView) : "maxView" in this.element.data() && (this.maxView = this.element.data("max-view")),
            (this.maxView = s.convertViewMode(this.maxView)),
            (this.wheelViewModeNavigation = !1),
            "wheelViewModeNavigation" in i ? (this.wheelViewModeNavigation = i.wheelViewModeNavigation) : "wheelViewModeNavigation" in this.element.data() && (this.wheelViewModeNavigation = this.element.data("view-mode-wheel-navigation")),
            (this.wheelViewModeNavigationInverseDirection = !1),
            "wheelViewModeNavigationInverseDirection" in i
                ? (this.wheelViewModeNavigationInverseDirection = i.wheelViewModeNavigationInverseDirection)
                : "wheelViewModeNavigationInverseDirection" in this.element.data() && (this.wheelViewModeNavigationInverseDirection = this.element.data("view-mode-wheel-navigation-inverse-dir")),
            (this.wheelViewModeNavigationDelay = 100),
            "wheelViewModeNavigationDelay" in i
                ? (this.wheelViewModeNavigationDelay = i.wheelViewModeNavigationDelay)
                : "wheelViewModeNavigationDelay" in this.element.data() && (this.wheelViewModeNavigationDelay = this.element.data("view-mode-wheel-navigation-delay")),
            (this.startViewMode = 2),
            "startView" in i ? (this.startViewMode = i.startView) : "startView" in this.element.data() && (this.startViewMode = this.element.data("start-view")),
            (this.startViewMode = s.convertViewMode(this.startViewMode)),
            (this.viewMode = this.startViewMode),
            (this.viewSelect = this.minView),
            "viewSelect" in i ? (this.viewSelect = i.viewSelect) : "viewSelect" in this.element.data() && (this.viewSelect = this.element.data("view-select")),
            (this.viewSelect = s.convertViewMode(this.viewSelect)),
            (this.forceParse = !0),
            "forceParse" in i ? (this.forceParse = i.forceParse) : "dateForceParse" in this.element.data() && (this.forceParse = this.element.data("date-force-parse")),
            (this.picker = t(s.template)
                .appendTo(this.isInline ? this.element : "body")
                .on({ click: t.proxy(this.click, this), mousedown: t.proxy(this.mousedown, this) })),
            this.wheelViewModeNavigation &&
                (t.fn.mousewheel ? this.picker.on({ mousewheel: t.proxy(this.mousewheel, this) }) : console.log("Mouse Wheel event is not supported. Please include the jQuery Mouse Wheel plugin before enabling this option")),
            this.isInline ? this.picker.addClass("datetimepicker-inline") : this.picker.addClass("datetimepicker-dropdown-" + this.pickerPosition + " dropdown-menu"),
            this.isRTL && (this.picker.addClass("datetimepicker-rtl"), this.picker.find(".prev i, .next i").toggleClass("fa-arrow-left fa-arrow-right")),
            t(document).on("mousedown", function (e) {
                0 === t(e.target).closest(".datetimepicker").length && a.hide();
            }),
            (this.autoclose = !1),
            "autoclose" in i ? (this.autoclose = i.autoclose) : "dateAutoclose" in this.element.data() && (this.autoclose = this.element.data("date-autoclose")),
            (this.keyboardNavigation = !0),
            "keyboardNavigation" in i ? (this.keyboardNavigation = i.keyboardNavigation) : "dateKeyboardNavigation" in this.element.data() && (this.keyboardNavigation = this.element.data("date-keyboard-navigation")),
            (this.todayBtn = i.todayBtn || this.element.data("date-today-btn") || !1),
            (this.todayHighlight = i.todayHighlight || this.element.data("date-today-highlight") || !1),
            (this.weekStart = (i.weekStart || this.element.data("date-weekstart") || n[this.language].weekStart || 0) % 7),
            (this.weekEnd = (this.weekStart + 6) % 7),
            (this.startDate = -1 / 0),
            (this.endDate = 1 / 0),
            (this.daysOfWeekDisabled = []),
            this.setStartDate(i.startDate || this.element.data("date-startdate")),
            this.setEndDate(i.endDate || this.element.data("date-enddate")),
            this.setDaysOfWeekDisabled(i.daysOfWeekDisabled || this.element.data("date-days-of-week-disabled")),
            this.fillDow(),
            this.fillMonths(),
            this.update(),
            this.showMode(),
            this.isInline && this.show();
    };
    (i.prototype = {
        constructor: i,
        _events: [],
        _attachEvents: function () {
            this._detachEvents(),
                this.isInput
                    ? (this._events = [[this.element, { focus: t.proxy(this.show, this), keyup: t.proxy(this.update, this), keydown: t.proxy(this.keydown, this) }]])
                    : this.component && this.hasInput
                    ? ((this._events = [
                          [this.element.find("input"), { focus: t.proxy(this.show, this), keyup: t.proxy(this.update, this), keydown: t.proxy(this.keydown, this) }],
                          [this.component, { click: t.proxy(this.show, this) }],
                      ]),
                      this.componentReset && this._events.push([this.componentReset, { click: t.proxy(this.reset, this) }]))
                    : this.element.is("div")
                    ? (this.isInline = !0)
                    : (this._events = [[this.element, { click: t.proxy(this.show, this) }]]);
            for (var e, i, n = 0; n < this._events.length; n++) (e = this._events[n][0]), (i = this._events[n][1]), e.on(i);
        },
        _detachEvents: function () {
            for (var t, e, i = 0; i < this._events.length; i++) (t = this._events[i][0]), (e = this._events[i][1]), t.off(e);
            this._events = [];
        },
        show: function (e) {
            this.picker.show(),
                (this.height = this.component ? this.component.outerHeight() : this.element.outerHeight()),
                this.forceParse && this.update(),
                this.place(),
                t(window).on("resize", t.proxy(this.place, this)),
                e && (e.stopPropagation(), e.preventDefault()),
                (this.isVisible = !0),
                this.element.trigger({ type: "show", date: this.date });
        },
        hide: function () {
            this.isVisible &&
                (this.isInline ||
                    (this.picker.hide(),
                    t(window).off("resize", this.place),
                    (this.viewMode = this.startViewMode),
                    this.showMode(),
                    this.isInput || t(document).off("mousedown", this.hide),
                    this.forceParse && ((this.isInput && this.element.val()) || (this.hasInput && this.element.find("input").val())) && this.setValue(),
                    (this.isVisible = !1),
                    this.element.trigger({ type: "hide", date: this.date })));
        },
        remove: function () {
            this._detachEvents(), this.picker.remove(), delete this.picker, delete this.element.data().datetimepicker;
        },
        getDate: function () {
            var t = this.getUTCDate();
            return new Date(t.getTime() + 6e4 * t.getTimezoneOffset());
        },
        getUTCDate: function () {
            return this.date;
        },
        setDate: function (t) {
            this.setUTCDate(new Date(t.getTime() - 6e4 * t.getTimezoneOffset()));
        },
        setUTCDate: function (t) {
            t >= this.startDate && t <= this.endDate ? ((this.date = t), this.setValue(), (this.viewDate = this.date), this.fill()) : this.element.trigger({ type: "outOfRange", date: t, startDate: this.startDate, endDate: this.endDate });
        },
        setFormat: function (t) {
            this.format = s.parseFormat(t, this.formatType);
            var e;
            this.isInput ? (e = this.element) : this.component && (e = this.element.find("input")), e && e.val() && this.setValue();
        },
        setValue: function () {
            var e = this.getFormattedDate();
            this.isInput ? this.element.val(e) : (this.component && this.element.find("input").val(e), this.element.data("date", e)), this.linkField && t("#" + this.linkField).val(this.getFormattedDate(this.linkFormat));
        },
        getFormattedDate: function (t) {
            return void 0 == t && (t = this.format), s.formatDate(this.date, t, this.language, this.formatType);
        },
        setStartDate: function (t) {
            (this.startDate = t || -1 / 0), this.startDate !== -1 / 0 && (this.startDate = s.parseDate(this.startDate, this.format, this.language, this.formatType)), this.update(), this.updateNavArrows();
        },
        setEndDate: function (t) {
            (this.endDate = t || 1 / 0), 1 / 0 !== this.endDate && (this.endDate = s.parseDate(this.endDate, this.format, this.language, this.formatType)), this.update(), this.updateNavArrows();
        },
        setDaysOfWeekDisabled: function (e) {
            (this.daysOfWeekDisabled = e || []),
                t.isArray(this.daysOfWeekDisabled) || (this.daysOfWeekDisabled = this.daysOfWeekDisabled.split(/,\s*/)),
                (this.daysOfWeekDisabled = t.map(this.daysOfWeekDisabled, function (t) {
                    return parseInt(t, 10);
                })),
                this.update(),
                this.updateNavArrows();
        },
        place: function () {
            if (!this.isInline) {
                var e,
                    i,
                    n,
                    s =
                        parseInt(
                            this.element
                                .parents()
                                .filter(function () {
                                    return "auto" != t(this).css("z-index");
                                })
                                .first()
                                .css("z-index")
                        ) + 10;
                this.component
                    ? ((e = this.component.offset()), (n = e.left), ("bottom-left" == this.pickerPosition || "top-left" == this.pickerPosition) && (n += this.component.outerWidth() - this.picker.outerWidth()))
                    : ((e = this.element.offset()), (n = e.left)),
                    (i = "top-left" == this.pickerPosition || "top-right" == this.pickerPosition ? e.top - this.picker.outerHeight() : e.top + this.height),
                    this.picker.css({ top: i, left: n, zIndex: s });
            }
        },
        update: function () {
            var t,
                e = !1;
            arguments && arguments.length && ("string" == typeof arguments[0] || arguments[0] instanceof Date)
                ? ((t = arguments[0]), (e = !0))
                : (t = this.element.data("date") || (this.isInput ? this.element.val() : this.element.find("input").val()) || this.initialDate),
                t || ((t = new Date()), (e = !1)),
                (this.date = s.parseDate(t, this.format, this.language, this.formatType)),
                e && this.setValue(),
                (this.viewDate = this.date < this.startDate ? new Date(this.startDate) : this.date > this.endDate ? new Date(this.endDate) : new Date(this.date)),
                this.fill();
        },
        fillDow: function () {
            for (var t = this.weekStart, e = "<tr>"; t < this.weekStart + 7; ) e += '<th class="dow">' + n[this.language].daysMin[t++ % 7] + "</th>";
            (e += "</tr>"), this.picker.find(".datetimepicker-days thead").append(e);
        },
        fillMonths: function () {
            for (var t = "", e = 0; 12 > e; ) t += '<span class="month">' + n[this.language].monthsShort[e++] + "</span>";
            this.picker.find(".datetimepicker-months td").html(t);
        },
        fill: function () {
            if (null != this.date && null != this.viewDate) {
                var i = new Date(this.viewDate),
                    a = i.getUTCFullYear(),
                    o = i.getUTCMonth(),
                    r = i.getUTCDate(),
                    l = i.getUTCHours(),
                    c = i.getUTCMinutes(),
                    d = this.startDate !== -1 / 0 ? this.startDate.getUTCFullYear() : -1 / 0,
                    h = this.startDate !== -1 / 0 ? this.startDate.getUTCMonth() : -1 / 0,
                    u = 1 / 0 !== this.endDate ? this.endDate.getUTCFullYear() : 1 / 0,
                    p = 1 / 0 !== this.endDate ? this.endDate.getUTCMonth() : 1 / 0,
                    f = new e(this.date.getUTCFullYear(), this.date.getUTCMonth(), this.date.getUTCDate()).valueOf(),
                    g = new Date();
                if ((this.picker.find(".datetimepicker-days thead th:eq(1)").text(n[this.language].months[o] + " " + a), "time" == this.formatViewType)) {
                    var v = l % 12 ? l % 12 : 12,
                        m = (10 > v ? "0" : "") + v,
                        b = (10 > c ? "0" : "") + c,
                        w = n[this.language].meridiem[12 > l ? 0 : 1];
                    this.picker.find(".datetimepicker-hours thead th:eq(1)").text(m + ":" + b + " " + w.toUpperCase()), this.picker.find(".datetimepicker-minutes thead th:eq(1)").text(m + ":" + b + " " + w.toUpperCase());
                } else
                    this.picker.find(".datetimepicker-hours thead th:eq(1)").text(r + " " + n[this.language].months[o] + " " + a),
                        this.picker.find(".datetimepicker-minutes thead th:eq(1)").text(r + " " + n[this.language].months[o] + " " + a);
                this.picker
                    .find("tfoot th.today")
                    .text(n[this.language].today)
                    .toggle(this.todayBtn !== !1),
                    this.updateNavArrows(),
                    this.fillMonths();
                var y = e(a, o - 1, 28, 0, 0, 0, 0),
                    x = s.getDaysInMonth(y.getUTCFullYear(), y.getUTCMonth());
                y.setUTCDate(x), y.setUTCDate(x - ((y.getUTCDay() - this.weekStart + 7) % 7));
                var T = new Date(y);
                T.setUTCDate(T.getUTCDate() + 42), (T = T.valueOf());
                for (var C, S = []; y.valueOf() < T; )
                    y.getUTCDay() == this.weekStart && S.push("<tr>"),
                        (C = ""),
                        y.getUTCFullYear() < a || (y.getUTCFullYear() == a && y.getUTCMonth() < o) ? (C += " old") : (y.getUTCFullYear() > a || (y.getUTCFullYear() == a && y.getUTCMonth() > o)) && (C += " new"),
                        this.todayHighlight && y.getUTCFullYear() == g.getFullYear() && y.getUTCMonth() == g.getMonth() && y.getUTCDate() == g.getDate() && (C += " today"),
                        y.valueOf() == f && (C += " active"),
                        (y.valueOf() + 864e5 <= this.startDate || y.valueOf() > this.endDate || -1 !== t.inArray(y.getUTCDay(), this.daysOfWeekDisabled)) && (C += " disabled"),
                        S.push('<td class="day' + C + '">' + y.getUTCDate() + "</td>"),
                        y.getUTCDay() == this.weekEnd && S.push("</tr>"),
                        y.setUTCDate(y.getUTCDate() + 1);
                this.picker.find(".datetimepicker-days tbody").empty().append(S.join("")), (S = []);
                for (var k = "", _ = "", $ = "", D = 0; 24 > D; D++) {
                    var I = e(a, o, r, D);
                    (C = ""),
                        I.valueOf() + 36e5 <= this.startDate || I.valueOf() > this.endDate ? (C += " disabled") : l == D && (C += " active"),
                        this.showMeridian && 2 == n[this.language].meridiem.length
                            ? ((_ = 12 > D ? n[this.language].meridiem[0] : n[this.language].meridiem[1]),
                              _ != $ && ("" != $ && S.push("</fieldset>"), S.push('<fieldset class="hour"><legend>' + _.toUpperCase() + "</legend>")),
                              ($ = _),
                              (k = D % 12 ? D % 12 : 12),
                              S.push('<span class="hour' + C + " hour_" + (12 > D ? "am" : "pm") + '">' + k + "</span>"),
                              23 == D && S.push("</fieldset>"))
                            : ((k = D + ":00"), S.push('<span class="hour' + C + '">' + k + "</span>"));
                }
                this.picker.find(".datetimepicker-hours td").html(S.join("")), (S = []), (k = ""), (_ = ""), ($ = "");
                for (var D = 0; 60 > D; D += this.minuteStep) {
                    var I = e(a, o, r, l, D, 0);
                    (C = ""),
                        I.valueOf() < this.startDate || I.valueOf() > this.endDate ? (C += " disabled") : Math.floor(c / this.minuteStep) == Math.floor(D / this.minuteStep) && (C += " active"),
                        this.showMeridian && 2 == n[this.language].meridiem.length
                            ? ((_ = 12 > l ? n[this.language].meridiem[0] : n[this.language].meridiem[1]),
                              _ != $ && ("" != $ && S.push("</fieldset>"), S.push('<fieldset class="minute"><legend>' + _.toUpperCase() + "</legend>")),
                              ($ = _),
                              (k = l % 12 ? l % 12 : 12),
                              S.push('<span class="minute' + C + '">' + k + ":" + (10 > D ? "0" + D : D) + "</span>"),
                              59 == D && S.push("</fieldset>"))
                            : ((k = D + ":00"), S.push('<span class="minute' + C + '">' + l + ":" + (10 > D ? "0" + D : D) + "</span>"));
                }
                this.picker.find(".datetimepicker-minutes td").html(S.join(""));
                var M = this.date.getUTCFullYear(),
                    E = this.picker.find(".datetimepicker-months").find("th:eq(1)").text(a).end().find("span").removeClass("active");
                M == a && E.eq(this.date.getUTCMonth()).addClass("active"),
                    (d > a || a > u) && E.addClass("disabled"),
                    a == d && E.slice(0, h).addClass("disabled"),
                    a == u && E.slice(p + 1).addClass("disabled"),
                    (S = ""),
                    (a = 10 * parseInt(a / 10, 10));
                var A = this.picker
                    .find(".datetimepicker-years")
                    .find("th:eq(1)")
                    .text(a + "-" + (a + 9))
                    .end()
                    .find("td");
                a -= 1;
                for (var D = -1; 11 > D; D++) (S += '<span class="year' + (-1 == D || 10 == D ? " old" : "") + (M == a ? " active" : "") + (d > a || a > u ? " disabled" : "") + '">' + a + "</span>"), (a += 1);
                A.html(S), this.place();
            }
        },
        updateNavArrows: function () {
            var t = new Date(this.viewDate),
                e = t.getUTCFullYear(),
                i = t.getUTCMonth(),
                n = t.getUTCDate(),
                s = t.getUTCHours();
            switch (this.viewMode) {
                case 0:
                    this.startDate !== -1 / 0 && e <= this.startDate.getUTCFullYear() && i <= this.startDate.getUTCMonth() && n <= this.startDate.getUTCDate() && s <= this.startDate.getUTCHours()
                        ? this.picker.find(".prev").css({ visibility: "hidden" })
                        : this.picker.find(".prev").css({ visibility: "visible" }),
                        1 / 0 !== this.endDate && e >= this.endDate.getUTCFullYear() && i >= this.endDate.getUTCMonth() && n >= this.endDate.getUTCDate() && s >= this.endDate.getUTCHours()
                            ? this.picker.find(".next").css({ visibility: "hidden" })
                            : this.picker.find(".next").css({ visibility: "visible" });
                    break;
                case 1:
                    this.startDate !== -1 / 0 && e <= this.startDate.getUTCFullYear() && i <= this.startDate.getUTCMonth() && n <= this.startDate.getUTCDate()
                        ? this.picker.find(".prev").css({ visibility: "hidden" })
                        : this.picker.find(".prev").css({ visibility: "visible" }),
                        1 / 0 !== this.endDate && e >= this.endDate.getUTCFullYear() && i >= this.endDate.getUTCMonth() && n >= this.endDate.getUTCDate()
                            ? this.picker.find(".next").css({ visibility: "hidden" })
                            : this.picker.find(".next").css({ visibility: "visible" });
                    break;
                case 2:
                    this.startDate !== -1 / 0 && e <= this.startDate.getUTCFullYear() && i <= this.startDate.getUTCMonth() ? this.picker.find(".prev").css({ visibility: "hidden" }) : this.picker.find(".prev").css({ visibility: "visible" }),
                        1 / 0 !== this.endDate && e >= this.endDate.getUTCFullYear() && i >= this.endDate.getUTCMonth() ? this.picker.find(".next").css({ visibility: "hidden" }) : this.picker.find(".next").css({ visibility: "visible" });
                    break;
                case 3:
                case 4:
                    this.startDate !== -1 / 0 && e <= this.startDate.getUTCFullYear() ? this.picker.find(".prev").css({ visibility: "hidden" }) : this.picker.find(".prev").css({ visibility: "visible" }),
                        1 / 0 !== this.endDate && e >= this.endDate.getUTCFullYear() ? this.picker.find(".next").css({ visibility: "hidden" }) : this.picker.find(".next").css({ visibility: "visible" });
            }
        },
        mousewheel: function (e) {
            if ((e.preventDefault(), e.stopPropagation(), !this.wheelPause)) {
                this.wheelPause = !0;
                var i = e.originalEvent,
                    n = i.wheelDelta,
                    s = n > 0 ? 1 : 0 === n ? 0 : -1;
                this.wheelViewModeNavigationInverseDirection && (s = -s),
                    this.showMode(s),
                    setTimeout(
                        t.proxy(function () {
                            this.wheelPause = !1;
                        }, this),
                        this.wheelViewModeNavigationDelay
                    );
            }
        },
        click: function (i) {
            i.stopPropagation(), i.preventDefault();
            var n = t(i.target).closest("span, td, th, legend");
            if (1 == n.length) {
                if (n.is(".disabled")) return this.element.trigger({ type: "outOfRange", date: this.viewDate, startDate: this.startDate, endDate: this.endDate }), void 0;
                switch (n[0].nodeName.toLowerCase()) {
                    case "th":
                        switch (n[0].className) {
                            case "switch":
                                this.showMode(1);
                                break;
                            case "prev":
                            case "next":
                                var a = s.modes[this.viewMode].navStep * ("prev" == n[0].className ? -1 : 1);
                                switch (this.viewMode) {
                                    case 0:
                                        this.viewDate = this.moveHour(this.viewDate, a);
                                        break;
                                    case 1:
                                        this.viewDate = this.moveDate(this.viewDate, a);
                                        break;
                                    case 2:
                                        this.viewDate = this.moveMonth(this.viewDate, a);
                                        break;
                                    case 3:
                                    case 4:
                                        this.viewDate = this.moveYear(this.viewDate, a);
                                }
                                this.fill();
                                break;
                            case "today":
                                var o = new Date();
                                (o = e(o.getFullYear(), o.getMonth(), o.getDate(), o.getHours(), o.getMinutes(), o.getSeconds(), 0)),
                                    (this.viewMode = this.startViewMode),
                                    this.showMode(0),
                                    this._setDate(o),
                                    this.fill(),
                                    this.autoclose && this.hide();
                        }
                        break;
                    case "span":
                        if (!n.is(".disabled")) {
                            var r = this.viewDate.getUTCFullYear(),
                                l = this.viewDate.getUTCMonth(),
                                c = this.viewDate.getUTCDate(),
                                d = this.viewDate.getUTCHours(),
                                h = this.viewDate.getUTCMinutes(),
                                u = this.viewDate.getUTCSeconds();
                            if (
                                (n.is(".month")
                                    ? (this.viewDate.setUTCDate(1),
                                      (l = n.parent().find("span").index(n)),
                                      (c = this.viewDate.getUTCDate()),
                                      this.viewDate.setUTCMonth(l),
                                      this.element.trigger({ type: "changeMonth", date: this.viewDate }),
                                      this.viewSelect >= 3 && this._setDate(e(r, l, c, d, h, u, 0)))
                                    : n.is(".year")
                                    ? (this.viewDate.setUTCDate(1),
                                      (r = parseInt(n.text(), 10) || 0),
                                      this.viewDate.setUTCFullYear(r),
                                      this.element.trigger({ type: "changeYear", date: this.viewDate }),
                                      this.viewSelect >= 4 && this._setDate(e(r, l, c, d, h, u, 0)))
                                    : n.is(".hour")
                                    ? ((d = parseInt(n.text(), 10) || 0),
                                      (n.hasClass("hour_am") || n.hasClass("hour_pm")) && (12 == d && n.hasClass("hour_am") ? (d = 0) : 12 != d && n.hasClass("hour_pm") && (d += 12)),
                                      this.viewDate.setUTCHours(d),
                                      this.element.trigger({ type: "changeHour", date: this.viewDate }),
                                      this.viewSelect >= 1 && this._setDate(e(r, l, c, d, h, u, 0)))
                                    : n.is(".minute") &&
                                      ((h = parseInt(n.text().substr(n.text().indexOf(":") + 1), 10) || 0),
                                      this.viewDate.setUTCMinutes(h),
                                      this.element.trigger({ type: "changeMinute", date: this.viewDate }),
                                      this.viewSelect >= 0 && this._setDate(e(r, l, c, d, h, u, 0))),
                                0 != this.viewMode)
                            ) {
                                var p = this.viewMode;
                                this.showMode(-1), this.fill(), p == this.viewMode && this.autoclose && this.hide();
                            } else this.fill(), this.autoclose && this.hide();
                        }
                        break;
                    case "td":
                        if (n.is(".day") && !n.is(".disabled")) {
                            var c = parseInt(n.text(), 10) || 1,
                                r = this.viewDate.getUTCFullYear(),
                                l = this.viewDate.getUTCMonth(),
                                d = this.viewDate.getUTCHours(),
                                h = this.viewDate.getUTCMinutes(),
                                u = this.viewDate.getUTCSeconds();
                            n.is(".old") ? (0 === l ? ((l = 11), (r -= 1)) : (l -= 1)) : n.is(".new") && (11 == l ? ((l = 0), (r += 1)) : (l += 1)),
                                this.viewDate.setUTCFullYear(r),
                                this.viewDate.setUTCMonth(l),
                                this.viewDate.setUTCDate(c),
                                this.element.trigger({ type: "changeDay", date: this.viewDate }),
                                this.viewSelect >= 2 && this._setDate(e(r, l, c, d, h, u, 0));
                        }
                        var p = this.viewMode;
                        this.showMode(-1), this.fill(), p == this.viewMode && this.autoclose && this.hide();
                }
            }
        },
        _setDate: function (t, e) {
            (e && "date" != e) || (this.date = t), (e && "view" != e) || (this.viewDate = t), this.fill(), this.setValue();
            var i;
            this.isInput ? (i = this.element) : this.component && (i = this.element.find("input")), i && (i.change(), this.autoclose && (!e || "date" == e)), this.element.trigger({ type: "changeDate", date: this.date });
        },
        moveMinute: function (t, e) {
            if (!e) return t;
            var i = new Date(t.valueOf());
            return i.setUTCMinutes(i.getUTCMinutes() + e * this.minuteStep), i;
        },
        moveHour: function (t, e) {
            if (!e) return t;
            var i = new Date(t.valueOf());
            return i.setUTCHours(i.getUTCHours() + e), i;
        },
        moveDate: function (t, e) {
            if (!e) return t;
            var i = new Date(t.valueOf());
            return i.setUTCDate(i.getUTCDate() + e), i;
        },
        moveMonth: function (t, e) {
            if (!e) return t;
            var i,
                n,
                s = new Date(t.valueOf()),
                a = s.getUTCDate(),
                o = s.getUTCMonth(),
                r = Math.abs(e);
            if (((e = e > 0 ? 1 : -1), 1 == r))
                (n =
                    -1 == e
                        ? function () {
                              return s.getUTCMonth() == o;
                          }
                        : function () {
                              return s.getUTCMonth() != i;
                          }),
                    (i = o + e),
                    s.setUTCMonth(i),
                    (0 > i || i > 11) && (i = (i + 12) % 12);
            else {
                for (var l = 0; r > l; l++) s = this.moveMonth(s, e);
                (i = s.getUTCMonth()),
                    s.setUTCDate(a),
                    (n = function () {
                        return i != s.getUTCMonth();
                    });
            }
            for (; n(); ) s.setUTCDate(--a), s.setUTCMonth(i);
            return s;
        },
        moveYear: function (t, e) {
            return this.moveMonth(t, 12 * e);
        },
        dateWithinRange: function (t) {
            return t >= this.startDate && t <= this.endDate;
        },
        keydown: function (t) {
            if (this.picker.is(":not(:visible)")) return 27 == t.keyCode && this.show(), void 0;
            var e,
                i,
                n,
                s = !1;
            switch (t.keyCode) {
                case 27:
                    this.hide(), t.preventDefault();
                    break;
                case 37:
                case 39:
                    if (!this.keyboardNavigation) break;
                    (e = 37 == t.keyCode ? -1 : 1),
                        (viewMode = this.viewMode),
                        t.ctrlKey ? (viewMode += 2) : t.shiftKey && (viewMode += 1),
                        4 == viewMode
                            ? ((i = this.moveYear(this.date, e)), (n = this.moveYear(this.viewDate, e)))
                            : 3 == viewMode
                            ? ((i = this.moveMonth(this.date, e)), (n = this.moveMonth(this.viewDate, e)))
                            : 2 == viewMode
                            ? ((i = this.moveDate(this.date, e)), (n = this.moveDate(this.viewDate, e)))
                            : 1 == viewMode
                            ? ((i = this.moveHour(this.date, e)), (n = this.moveHour(this.viewDate, e)))
                            : 0 == viewMode && ((i = this.moveMinute(this.date, e)), (n = this.moveMinute(this.viewDate, e))),
                        this.dateWithinRange(i) && ((this.date = i), (this.viewDate = n), this.setValue(), this.update(), t.preventDefault(), (s = !0));
                    break;
                case 38:
                case 40:
                    if (!this.keyboardNavigation) break;
                    (e = 38 == t.keyCode ? -1 : 1),
                        (viewMode = this.viewMode),
                        t.ctrlKey ? (viewMode += 2) : t.shiftKey && (viewMode += 1),
                        4 == viewMode
                            ? ((i = this.moveYear(this.date, e)), (n = this.moveYear(this.viewDate, e)))
                            : 3 == viewMode
                            ? ((i = this.moveMonth(this.date, e)), (n = this.moveMonth(this.viewDate, e)))
                            : 2 == viewMode
                            ? ((i = this.moveDate(this.date, 7 * e)), (n = this.moveDate(this.viewDate, 7 * e)))
                            : 1 == viewMode
                            ? this.showMeridian
                                ? ((i = this.moveHour(this.date, 6 * e)), (n = this.moveHour(this.viewDate, 6 * e)))
                                : ((i = this.moveHour(this.date, 4 * e)), (n = this.moveHour(this.viewDate, 4 * e)))
                            : 0 == viewMode && ((i = this.moveMinute(this.date, 4 * e)), (n = this.moveMinute(this.viewDate, 4 * e))),
                        this.dateWithinRange(i) && ((this.date = i), (this.viewDate = n), this.setValue(), this.update(), t.preventDefault(), (s = !0));
                    break;
                case 13:
                    if (0 != this.viewMode) {
                        var a = this.viewMode;
                        this.showMode(-1), this.fill(), a == this.viewMode && this.autoclose && this.hide();
                    } else this.fill(), this.autoclose && this.hide();
                    t.preventDefault();
                    break;
                case 9:
                    this.hide();
            }
            if (s) {
                var o;
                this.isInput ? (o = this.element) : this.component && (o = this.element.find("input")), o && o.change(), this.element.trigger({ type: "changeDate", date: this.date });
            }
        },
        showMode: function (t) {
            if (t) {
                var e = Math.max(0, Math.min(s.modes.length - 1, this.viewMode + t));
                e >= this.minView && e <= this.maxView && (this.element.trigger({ type: "changeMode", date: this.viewDate, oldViewMode: this.viewMode, newViewMode: e }), (this.viewMode = e));
            }
            this.picker
                .find(">div")
                .hide()
                .filter(".datetimepicker-" + s.modes[this.viewMode].clsName)
                .css("display", "block"),
                this.updateNavArrows();
        },
        reset: function () {
            this._setDate(null, "date");
        },
    }),
        (t.fn.datetimepicker = function (e) {
            var n = Array.apply(null, arguments);
            return (
                n.shift(),
                this.each(function () {
                    var s = t(this),
                        a = s.data("datetimepicker"),
                        o = "object" == typeof e && e;
                    a || s.data("datetimepicker", (a = new i(this, t.extend({}, t.fn.datetimepicker.defaults, o)))), "string" == typeof e && "function" == typeof a[e] && a[e].apply(a, n);
                })
            );
        }),
        (t.fn.datetimepicker.defaults = {}),
        (t.fn.datetimepicker.Constructor = i);
    var n = (t.fn.datetimepicker.dates = {
            en: {
                days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
                months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                meridiem: ["am", "pm"],
                suffix: ["st", "nd", "rd", "th"],
                today: "Today",
            },
        }),
        s = {
            modes: [
                { clsName: "minutes", navFnc: "Hours", navStep: 1 },
                { clsName: "hours", navFnc: "Date", navStep: 1 },
                { clsName: "days", navFnc: "Month", navStep: 1 },
                { clsName: "months", navFnc: "FullYear", navStep: 1 },
                { clsName: "years", navFnc: "FullYear", navStep: 10 },
            ],
            isLeapYear: function (t) {
                return (0 === t % 4 && 0 !== t % 100) || 0 === t % 400;
            },
            getDaysInMonth: function (t, e) {
                return [31, s.isLeapYear(t) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][e];
            },
            getDefaultFormat: function (t, e) {
                if ("standard" == t) return "input" == e ? "yyyy-mm-dd hh:ii" : "yyyy-mm-dd hh:ii:ss";
                if ("php" == t) return "input" == e ? "Y-m-d H:i" : "Y-m-d H:i:s";
                throw new Error("Invalid format type.");
            },
            validParts: function (t) {
                if ("standard" == t) return /hh?|HH?|p|P|ii?|ss?|dd?|DD?|mm?|MM?|yy(?:yy)?/g;
                if ("php" == t) return /[dDjlNwzFmMnStyYaABgGhHis]/g;
                throw new Error("Invalid format type.");
            },
            nonpunctuation: /[^ -\/:-@\[-`{-~\t\n\rTZ]+/g,
            parseFormat: function (t, e) {
                var i = t.replace(this.validParts(e), "\0").split("\0"),
                    n = t.match(this.validParts(e));
                if (!i || !i.length || !n || 0 == n.length) throw new Error("Invalid date format.");
                return { separators: i, parts: n };
            },
            parseDate: function (s, a, o, r) {
                if (s instanceof Date) {
                    var l = new Date(s.valueOf() - 6e4 * s.getTimezoneOffset());
                    return l.setMilliseconds(0), l;
                }
                if (
                    (/^\d{4}\-\d{1,2}\-\d{1,2}$/.test(s) && (a = this.parseFormat("yyyy-mm-dd", r)),
                    /^\d{4}\-\d{1,2}\-\d{1,2}[T ]\d{1,2}\:\d{1,2}$/.test(s) && (a = this.parseFormat("yyyy-mm-dd hh:ii", r)),
                    /^\d{4}\-\d{1,2}\-\d{1,2}[T ]\d{1,2}\:\d{1,2}\:\d{1,2}[Z]{0,1}$/.test(s) && (a = this.parseFormat("yyyy-mm-dd hh:ii:ss", r)),
                    /^[-+]\d+[dmwy]([\s,]+[-+]\d+[dmwy])*$/.test(s))
                ) {
                    var c,
                        d,
                        h = /([-+]\d+)([dmwy])/,
                        u = s.match(/([-+]\d+)([dmwy])/g);
                    s = new Date();
                    for (var p = 0; p < u.length; p++)
                        switch (((c = h.exec(u[p])), (d = parseInt(c[1])), c[2])) {
                            case "d":
                                s.setUTCDate(s.getUTCDate() + d);
                                break;
                            case "m":
                                s = i.prototype.moveMonth.call(i.prototype, s, d);
                                break;
                            case "w":
                                s.setUTCDate(s.getUTCDate() + 7 * d);
                                break;
                            case "y":
                                s = i.prototype.moveYear.call(i.prototype, s, d);
                        }
                    return e(s.getUTCFullYear(), s.getUTCMonth(), s.getUTCDate(), s.getUTCHours(), s.getUTCMinutes(), s.getUTCSeconds(), 0);
                }
                var f,
                    g,
                    c,
                    u = (s && s.match(this.nonpunctuation)) || [],
                    s = new Date(0, 0, 0, 0, 0, 0, 0),
                    v = {},
                    m = ["hh", "h", "ii", "i", "ss", "s", "yyyy", "yy", "M", "MM", "m", "mm", "D", "DD", "d", "dd", "H", "HH", "p", "P"],
                    b = {
                        hh: function (t, e) {
                            return t.setUTCHours(e);
                        },
                        h: function (t, e) {
                            return t.setUTCHours(e);
                        },
                        HH: function (t, e) {
                            return t.setUTCHours(12 == e ? 0 : e);
                        },
                        H: function (t, e) {
                            return t.setUTCHours(12 == e ? 0 : e);
                        },
                        ii: function (t, e) {
                            return t.setUTCMinutes(e);
                        },
                        i: function (t, e) {
                            return t.setUTCMinutes(e);
                        },
                        ss: function (t, e) {
                            return t.setUTCSeconds(e);
                        },
                        s: function (t, e) {
                            return t.setUTCSeconds(e);
                        },
                        yyyy: function (t, e) {
                            return t.setUTCFullYear(e);
                        },
                        yy: function (t, e) {
                            return t.setUTCFullYear(2e3 + e);
                        },
                        m: function (t, e) {
                            for (e -= 1; 0 > e; ) e += 12;
                            for (e %= 12, t.setUTCMonth(e); t.getUTCMonth() != e; ) t.setUTCDate(t.getUTCDate() - 1);
                            return t;
                        },
                        d: function (t, e) {
                            return t.setUTCDate(e);
                        },
                        p: function (t, e) {
                            return t.setUTCHours(1 == e ? t.getUTCHours() + 12 : t.getUTCHours());
                        },
                    };
                if (((b.M = b.MM = b.mm = b.m), (b.dd = b.d), (b.P = b.p), (s = e(s.getFullYear(), s.getMonth(), s.getDate(), s.getHours(), s.getMinutes(), s.getSeconds())), u.length == a.parts.length)) {
                    for (var p = 0, w = a.parts.length; w > p; p++) {
                        if (((f = parseInt(u[p], 10)), (c = a.parts[p]), isNaN(f)))
                            switch (c) {
                                case "MM":
                                    (g = t(n[o].months).filter(function () {
                                        var t = this.slice(0, u[p].length),
                                            e = u[p].slice(0, t.length);
                                        return t == e;
                                    })),
                                        (f = t.inArray(g[0], n[o].months) + 1);
                                    break;
                                case "M":
                                    (g = t(n[o].monthsShort).filter(function () {
                                        var t = this.slice(0, u[p].length),
                                            e = u[p].slice(0, t.length);
                                        return t == e;
                                    })),
                                        (f = t.inArray(g[0], n[o].monthsShort) + 1);
                                    break;
                                case "p":
                                case "P":
                                    f = t.inArray(u[p].toLowerCase(), n[o].meridiem);
                            }
                        v[c] = f;
                    }
                    for (var y, p = 0; p < m.length; p++) (y = m[p]), y in v && !isNaN(v[y]) && b[y](s, v[y]);
                }
                return s;
            },
            formatDate: function (e, i, a, o) {
                if (null == e) return "";
                var r;
                if ("standard" == o)
                    (r = {
                        yy: e.getUTCFullYear().toString().substring(2),
                        yyyy: e.getUTCFullYear(),
                        m: e.getUTCMonth() + 1,
                        M: n[a].monthsShort[e.getUTCMonth()],
                        MM: n[a].months[e.getUTCMonth()],
                        d: e.getUTCDate(),
                        D: n[a].daysShort[e.getUTCDay()],
                        DD: n[a].days[e.getUTCDay()],
                        p: 2 == n[a].meridiem.length ? n[a].meridiem[e.getUTCHours() < 12 ? 0 : 1] : "",
                        h: e.getUTCHours(),
                        i: e.getUTCMinutes(),
                        s: e.getUTCSeconds(),
                    }),
                        (r.H = 0 == r.h % 12 ? 12 : r.h % 12),
                        (r.HH = (r.H < 10 ? "0" : "") + r.H),
                        (r.P = r.p.toUpperCase()),
                        (r.hh = (r.h < 10 ? "0" : "") + r.h),
                        (r.ii = (r.i < 10 ? "0" : "") + r.i),
                        (r.ss = (r.s < 10 ? "0" : "") + r.s),
                        (r.dd = (r.d < 10 ? "0" : "") + r.d),
                        (r.mm = (r.m < 10 ? "0" : "") + r.m);
                else {
                    if ("php" != o) throw new Error("Invalid format type.");
                    (r = {
                        y: e.getUTCFullYear().toString().substring(2),
                        Y: e.getUTCFullYear(),
                        F: n[a].months[e.getUTCMonth()],
                        M: n[a].monthsShort[e.getUTCMonth()],
                        n: e.getUTCMonth() + 1,
                        t: s.getDaysInMonth(e.getUTCFullYear(), e.getUTCMonth()),
                        j: e.getUTCDate(),
                        l: n[a].days[e.getUTCDay()],
                        D: n[a].daysShort[e.getUTCDay()],
                        w: e.getUTCDay(),
                        N: 0 == e.getUTCDay() ? 7 : e.getUTCDay(),
                        S: e.getUTCDate() % 10 <= n[a].suffix.length ? n[a].suffix[(e.getUTCDate() % 10) - 1] : "",
                        a: 2 == n[a].meridiem.length ? n[a].meridiem[e.getUTCHours() < 12 ? 0 : 1] : "",
                        g: 0 == e.getUTCHours() % 12 ? 12 : e.getUTCHours() % 12,
                        G: e.getUTCHours(),
                        i: e.getUTCMinutes(),
                        s: e.getUTCSeconds(),
                    }),
                        (r.m = (r.n < 10 ? "0" : "") + r.n),
                        (r.d = (r.j < 10 ? "0" : "") + r.j),
                        (r.A = r.a.toString().toUpperCase()),
                        (r.h = (r.g < 10 ? "0" : "") + r.g),
                        (r.H = (r.G < 10 ? "0" : "") + r.G),
                        (r.i = (r.i < 10 ? "0" : "") + r.i),
                        (r.s = (r.s < 10 ? "0" : "") + r.s);
                }
                for (var e = [], l = t.extend([], i.separators), c = 0, d = i.parts.length; d > c; c++) l.length && e.push(l.shift()), e.push(r[i.parts[c]]);
                return e.join("");
            },
            convertViewMode: function (t) {
                switch (t) {
                    case 4:
                    case "decade":
                        t = 4;
                        break;
                    case 3:
                    case "year":
                        t = 3;
                        break;
                    case 2:
                    case "month":
                        t = 2;
                        break;
                    case 1:
                    case "day":
                        t = 1;
                        break;
                    case 0:
                    case "hour":
                        t = 0;
                }
                return t;
            },
            headTemplate: '<thead><tr><th class="prev"><i class="fa fa-angle-left"/></th><th colspan="5" class="switch"></th><th class="next"><i class="fa fa-angle-right"/></th></tr></thead>',
            contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
            footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr></tfoot>',
        };
    (s.template =
        '<div class="datetimepicker"><div class="datetimepicker-minutes"><table class=" table-condensed">' +
        s.headTemplate +
        s.contTemplate +
        s.footTemplate +
        "</table>" +
        "</div>" +
        '<div class="datetimepicker-hours">' +
        '<table class=" table-condensed">' +
        s.headTemplate +
        s.contTemplate +
        s.footTemplate +
        "</table>" +
        "</div>" +
        '<div class="datetimepicker-days">' +
        '<table class=" table-condensed">' +
        s.headTemplate +
        "<tbody></tbody>" +
        s.footTemplate +
        "</table>" +
        "</div>" +
        '<div class="datetimepicker-months">' +
        '<table class="table-condensed">' +
        s.headTemplate +
        s.contTemplate +
        s.footTemplate +
        "</table>" +
        "</div>" +
        '<div class="datetimepicker-years">' +
        '<table class="table-condensed">' +
        s.headTemplate +
        s.contTemplate +
        s.footTemplate +
        "</table>" +
        "</div>" +
        "</div>"),
        (t.fn.datetimepicker.DPGlobal = s),
        (t.fn.datetimepicker.noConflict = function () {
            return (t.fn.datetimepicker = old), this;
        }),
        t(document).on("focus.datetimepicker.data-api click.datetimepicker.data-api", '[data-provide="datetimepicker"]', function (e) {
            var i = t(this);
            i.data("datetimepicker") || (e.preventDefault(), i.datetimepicker("show"));
        }),
        t(function () {
            t('[data-provide="datetimepicker-inline"]').datetimepicker();
        });
})(window.jQuery);
